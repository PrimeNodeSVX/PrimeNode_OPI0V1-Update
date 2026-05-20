#!/usr/bin/env python3
import sys
import os
import json
import shutil

CONFIG_FILE = "/etc/svxlink/svxlink.conf"
INPUT_JSON = "/tmp/svx_new_settings.json"
RADIO_JSON = "/var/www/html/radio_config.json"
NODE_INFO_FILE = "/etc/svxlink/node_info.json"
LOG_FILE_RAM = "/dev/shm/svxlink.log"

def load_lines(path):
    if not os.path.exists(path): return []
    with open(path, 'r', encoding='utf-8', errors='ignore') as f: return f.readlines()

def save_lines(path, lines):
    with open(path, 'w', encoding='utf-8') as f: f.writelines(lines)

def sanitize_lines(lines):
    seen_headers = set()
    clean_lines = []
    skip_mode = False
    
    for line in lines:
        stripped = line.strip()
        if stripped.startswith("[") and stripped.endswith("]"):
            if stripped in seen_headers:
                skip_mode = True
            else:
                seen_headers.add(stripped)
                skip_mode = False
                clean_lines.append(line)
        else:
            if not skip_mode:
                clean_lines.append(line)

    final_lines = []
    current_section = ""
    
    for line in clean_lines:
        stripped = line.strip()
        if stripped.startswith("[") and stripped.endswith("]"):
            current_section = stripped
            final_lines.append(line)
            continue

        if stripped.startswith("HOSTS=") or stripped.startswith("HOST_PORT="):
            continue

        if stripped.startswith("HOST=") or stripped.startswith("PORT="):
            if current_section == "[ReflectorLogic]":
                final_lines.append(line)
            else:
                pass
        else:
            final_lines.append(line)
            
    return final_lines

def update_key_in_lines(lines, section, key, value):
    new_lines = []
    in_section = False
    key_found = False
    section_header = f"[{section}]"
    section_exists = False

    for line in lines:
        if line.strip() == section_header:
            section_exists = True
            break
            
    if not section_exists:
        lines.append(f"\n{section_header}\n")

    for line in lines:
        stripped = line.strip()
        if stripped.startswith("[") and stripped.endswith("]"):
            in_section = (stripped == section_header)
            new_lines.append(line)
            continue

        if in_section:
            if stripped.startswith(key + "="):
                new_lines.append(f"{key}={value}\n")
                key_found = True
            else:
                new_lines.append(line)
        else:
            new_lines.append(line)

    if section_exists and not key_found:
        final_lines = []
        for line in new_lines:
            final_lines.append(line)
            if line.strip() == section_header:
                final_lines.append(f"{key}={value}\n")
        return final_lines

    return new_lines

def main():
    if not os.path.exists(LOG_FILE_RAM):
        with open(LOG_FILE_RAM, 'w') as f: pass
    try:
        os.chmod(LOG_FILE_RAM, 0o666)
    except:
        pass

    data = {}
    if os.path.exists(INPUT_JSON):
        with open(INPUT_JSON, 'r') as f: data = json.load(f)

    lines = load_lines(CONFIG_FILE)
    lines = sanitize_lines(lines) 
    lines = update_key_in_lines(lines, "GLOBAL", "LOGFILE", LOG_FILE_RAM)

    radio_data = {}
    if os.path.exists(RADIO_JSON):
        try:
            with open(RADIO_JSON, 'r') as rf:
                radio_data = json.load(rf)
        except:
            pass

    backup_info = {}
    if os.path.exists(NODE_INFO_FILE):
        try:
            with open(NODE_INFO_FILE, 'r') as nf:
                backup_info = json.load(nf)
        except:
            pass

    def get_val(keys_input, key_radio, key_backup, default=""):
        val = data.get(keys_input)
        if val is not None: return val
        val = radio_data.get(key_radio)
        if val: return val
        return backup_info.get(key_backup, default)

    qth_name = get_val('qth_name', 'qth_name', 'Sysop')
    qth_city = get_val('qth_city', 'qth_city', 'Location')
    qth_loc  = get_val('qth_loc',  'qth_loc',  'Locator')
    serial_port = data.get('SerialPort') or radio_data.get('serial_port', '/dev/ttyS2')
    gpio_ptt = data.get('GpioPtt') or radio_data.get('gpio_ptt', '7')
    gpio_sql = data.get('GpioSql') or radio_data.get('gpio_sql', '10')
    sa_bw = str(data.get("sa_bw", radio_data.get("sa_bw", "1")))
    sa_vol = str(data.get("sa_vol", radio_data.get("sa_vol", "8")))
    sa_prede = str(data.get("sa_prede", radio_data.get("sa_prede", "0")))
    sa_hpf = str(data.get("sa_hpf", radio_data.get("sa_hpf", "0")))
    sa_lpf = str(data.get("sa_lpf", radio_data.get("sa_lpf", "0")))
    svx_deemph = str(data.get("svx_deemph", radio_data.get("svx_deemph", "0")))
    svx_preemph = str(data.get("svx_preemph", radio_data.get("svx_preemph", "0")))

    modules_str = data.get('Modules')
    if modules_str is not None:
        el_pass = data.get('EL_Password', '')
        if not el_pass:
            modules_list = [m.strip() for m in modules_str.split(',')]
            modules_list = [m for m in modules_list if 'EchoLink' not in m]
            data['Modules'] = ",".join(modules_list)

    rx_freq = radio_data.get("rx", "")
    tx_freq = radio_data.get("tx", "")
    ctcss = radio_data.get("ctcss", "0")
    if ctcss == "0000":
        ctcss = "0"
    elif len(ctcss) == 4 and ctcss.isdigit():
        ctcss = str(float(ctcss) / 10.0)
    is_echolink = "1" if (data.get('Modules') and "EchoLink" in data['Modules']) else "0"
    current_default_tg = data.get('DefaultTG') or backup_info.get('DefaultTG', '0')

    node_info_data = {
        "Location": qth_city, "Locator": qth_loc, "Sysop": qth_name,
        "LAT": "0.0", "LONG": "0.0", "TXFREQ": tx_freq, "RXFREQ": rx_freq, "CTCSS": ctcss,
        "DefaultTG": current_default_tg, "Mode": "FM", "Type": "1", 
        "Echolink": is_echolink, "Website": "https://github.com/ArduUTP", "LinkedTo": "PrimeNode"
    }
    try:
        with open(NODE_INFO_FILE, 'w') as nf:
            json.dump(node_info_data, nf, indent=4)
        os.chmod(NODE_INFO_FILE, 0o644) 
    except:
        pass

    loc_parts = []
    if qth_city: loc_parts.append(qth_city)
    if qth_loc: loc_parts.append(qth_loc)
    if qth_name: loc_parts.append(f"(Op: {qth_name})")
    location_str = ", ".join(loc_parts)

    main_callsign = data.get('Callsign')
    announce_call = data.get('AnnounceCall', '1')
    reflector_callsign = main_callsign
    simplex_callsign = main_callsign if announce_call=="1" else ""
    
    ident_int = "60"
    if not main_callsign:
        ident_int = "0"
        simplex_callsign = ""

    mapping = {
        "ReflectorLogic": {
            "CALLSIGN": reflector_callsign, "AUTH_KEY": data.get('Password'),
            "HOST": data.get('Host'),       
            "PORT": data.get('Port'),      
            "DEFAULT_TG": data.get('DefaultTG'), "MONITOR_TGS": data.get('MonitorTGs'),
            "TG_SELECT_TIMEOUT": data.get('TgTimeout'), "TMP_MONITOR_TIMEOUT": data.get('TmpTimeout'),
            "TGSTBEEP_ENABLE": data.get('Beep3Tone'), "TGREANON_ENABLE": data.get('AnnounceTG'),
            "REFCON_ENABLE": data.get('RefStatusInfo'), "UDP_HEARTBEAT_INTERVAL": "15",
            "LOCATION": f'"{location_str}"', "NODE_INFO_FILE": NODE_INFO_FILE,
            "DEFAULT_LANG": data.get('AudioLang')
        },
        "SimplexLogic": {
            "CALLSIGN": simplex_callsign, "RGR_SOUND_ALWAYS": data.get('RogerBeep'),
            "MODULES": data.get('Modules'),
            "SHORT_IDENT_INTERVAL": ident_int,
            "LONG_IDENT_INTERVAL": ident_int,
            "DEFAULT_LANG": data.get('AudioLang')
        },
        "EchoLink": {
            "CALLSIGN": data.get('EL_Callsign'), "PASSWORD": data.get('EL_Password'),
            "SYSOPNAME": data.get('EL_Sysop'), "LOCATION": data.get('EL_Location'),
            "DESCRIPTION": data.get('EL_Desc'), "PROXY_SERVER": data.get('EL_ProxyHost'),
            "TIMEOUT": data.get('EL_ModTimeout'), "LINK_IDLE_TIMEOUT": data.get('EL_IdleTimeout')
        },
        "Rx1": { 
            "DTMF_SERIAL": serial_port, 
            "SQL_GPIOD_LINE": gpio_sql,
            "PREAMP": "6",
            "DEEMPHASIS": svx_deemph
        },
        "Tx1": { 
            "PTT_GPIOD_LINE": gpio_ptt,
            "PREEMPHASIS": svx_preemph
        }
    }
    
    for section, keys in mapping.items():
        for cfg_key, json_val in keys.items():
            if json_val is not None:
                lines = update_key_in_lines(lines, section, cfg_key, str(json_val))

    radio_data['qth_name'] = qth_name
    radio_data['qth_city'] = qth_city
    radio_data['qth_loc'] = qth_loc
    if serial_port: radio_data['serial_port'] = serial_port
    if gpio_ptt: radio_data['gpio_ptt'] = gpio_ptt
    if gpio_sql: radio_data['gpio_sql'] = gpio_sql
    
    radio_data['sa_bw'] = sa_bw
    radio_data['sa_vol'] = sa_vol
    radio_data['sa_prede'] = sa_prede
    radio_data['sa_hpf'] = sa_hpf
    radio_data['sa_lpf'] = sa_lpf
    radio_data['svx_deemph'] = svx_deemph
    radio_data['svx_preemph'] = svx_preemph

    node_api_url = data.get('node_api_url')
    if node_api_url is not None:
        radio_data['node_api_url'] = node_api_url

    shari_sql = data.get('sq') or radio_data.get('sq', '4')
    cmd = f"sudo /usr/bin/python3 /usr/local/bin/setup_radio.py {rx_freq} {tx_freq} {ctcss} {shari_sql} {sa_bw} {sa_vol} {sa_prede} {sa_hpf} {sa_lpf}"
    os.system(cmd)

    with open(RADIO_JSON, 'w') as f:
        json.dump(radio_data, f, indent=4)


    REF_SOUNDS_DIR = "/usr/local/share/svxlink/sounds/ref_sounds"
    CORE_DIR = "/usr/local/share/svxlink/sounds/PL/Core"
    TARGET_FILE = os.path.join(CORE_DIR, "online.wav")
    DEFAULT_FILE = os.path.join(CORE_DIR, "online_PN.wav")

    forced_net_id = 0
    if "--netid" in sys.argv:
        try:
            idx = sys.argv.index("--netid")
            forced_net_id = int(sys.argv[idx + 1])
        except:
            pass

    chosen_audio = data.get('audio_file', '')

    NETWORKS_JSON = "/etc/svxlink/networks.json"
    if os.path.exists(NETWORKS_JSON):
        try:
            with open(NETWORKS_JSON, 'r') as nf:
                net_data = json.load(nf)
                active_id = forced_net_id if forced_net_id > 0 else net_data.get('active', 0)
                
                if active_id > 0:
                    for net in net_data.get('list', []):
                        if int(net.get('id')) == int(active_id):
                            if net.get('audio'):
                                chosen_audio = net.get('audio')
                            break
        except Exception as e:
            print(f"DEBUG: Błąd odczytu networks.json: {e}")

    try:
        source_path = os.path.join(REF_SOUNDS_DIR, chosen_audio) if chosen_audio else ""
        
        if chosen_audio and os.path.exists(source_path):
            shutil.copy2(source_path, TARGET_FILE)
            print(f"DEBUG: Podmieniono na audio sieci: {chosen_audio}")
        else:
            if os.path.exists(DEFAULT_FILE):
                shutil.copy2(DEFAULT_FILE, TARGET_FILE)
                print("DEBUG: Użyto audio domyślnego (online_PN.wav)")
        
        if os.path.exists(TARGET_FILE):
            os.chmod(TARGET_FILE, 0o666)
    except Exception as e:
        print(f"DEBUG: Błąd kopiowania audio: {e}")

    save_lines(CONFIG_FILE, lines)
    print("DONE")

if __name__ == "__main__":
    main()