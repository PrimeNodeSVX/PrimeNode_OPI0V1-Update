#!/usr/bin/env python3
import sys
import os
import json

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

    if not os.path.exists(INPUT_JSON):
        pass
    else:
        with open(INPUT_JSON, 'r') as f: data = json.load(f)

    lines = load_lines(CONFIG_FILE)
    lines = sanitize_lines(lines) 
    lines = update_key_in_lines(lines, "GLOBAL", "LOGFILE", LOG_FILE_RAM)

    if os.path.exists(INPUT_JSON):
        with open(INPUT_JSON, 'r') as f: data = json.load(f)
        
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
        serial_port = data.get('SerialPort') or radio_data.get('serial_port')
        gpio_ptt = data.get('GpioPtt') or radio_data.get('gpio_ptt')
        gpio_sql = data.get('GpioSql') or radio_data.get('gpio_sql')

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
                "PREAMP": "6"
            },
            "Tx1": { "PTT_GPIOD_LINE": gpio_ptt }
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
        
        node_api_url = data.get('node_api_url')
        if node_api_url is not None:
            radio_data['node_api_url'] = node_api_url

        with open(RADIO_JSON, 'w') as f:
            json.dump(radio_data, f, indent=4)

    save_lines(CONFIG_FILE, lines)
    print("DONE")

if __name__ == "__main__":
    main()