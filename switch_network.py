#!/usr/bin/env python3
import sys
import json
import os
import argparse
import subprocess
import time

NET_FILE = '/etc/svxlink/networks.json'
SETTINGS_FILE = '/tmp/svx_new_settings.json'
UPDATE_SCRIPT = '/usr/local/bin/update_svx_full.py'
LOG_FILE = '/dev/shm/switch_debug.log'

def log(msg):
    with open(LOG_FILE, 'a') as f:
        f.write(f"[{time.strftime('%H:%M:%S')}] {msg}\n")
    print(msg)

def main():
    try:
        with open(LOG_FILE, 'w') as f:
            f.write(f"[{time.strftime('%H:%M:%S')}] --- NEW SWITCH REQUEST ---\n")

        parser = argparse.ArgumentParser()
        parser.add_argument("--dtmf", type=int, required=True, help="Network ID")
        args = parser.parse_args()

        log(f"Requested Network ID: {args.dtmf}")

        if not os.path.exists(NET_FILE):
            log(f"Error: {NET_FILE} not found")
            sys.exit(1)

        with open(NET_FILE, 'r') as f:
            try:
                data = json.load(f)
            except json.JSONDecodeError as e:
                log(f"Error parsing networks.json: {e}")
                sys.exit(1)

        target_net = None
        for net in data.get('list', []):
            if int(net.get('id', -1)) == args.dtmf:
                target_net = net
                break

        if not target_net:
            log(f"Error: Network ID {args.dtmf} not found in list.")
            sys.exit(1)

        data['active'] = target_net['id']
        with open(NET_FILE, 'w') as f:
            json.dump(data, f, indent=4)
        log("Updated active network in networks.json")

        callsign_val = target_net.get('callsign', '')
        if callsign_val is None: callsign_val = ''

        new_conf = {
            "Host": str(target_net.get('host', '')),
            "Port": str(target_net.get('port', '5300')),
            "Password": str(target_net.get('pass', '')),
            "Callsign": str(callsign_val),
            "MonitorTGs": str(target_net.get('tgs', '')),
            "node_api_url": str(target_net.get('api', '')),
            "audio_file": str(target_net.get('audio', '')) 
        }
        
        if 'deftg' in target_net and target_net['deftg']:
             new_conf['DefaultTG'] = str(target_net['deftg'])

        log(f"Prepared settings: Host={new_conf['Host']}, Call={new_conf['Callsign']}")

        with open(SETTINGS_FILE, 'w') as f:
            json.dump(new_conf, f)

        log("Running update_svx_full.py...")

        result = subprocess.run(["sudo", "/usr/bin/python3", UPDATE_SCRIPT, "--netid", str(args.dtmf)], capture_output=True, text=True)
        
        if result.returncode != 0:
            log(f"Update Script FAILED: {result.stderr}")
        else:
            log("Update Script OK.")
        
        log("Restarting SvxLink service...")
        subprocess.run(["sudo", "systemctl", "restart", "svxlink"])
        log("Done.")

    except Exception as e:
        log(f"CRITICAL ERROR: {str(e)}")
        sys.exit(1)

if __name__ == "__main__":
    main()