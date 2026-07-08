#!/usr/bin/env python3
import serial
import time
import sys
import json
import os

RADIO_JSON = "/var/www/html/radio_config.json"
DEFAULT_SERIAL = "/dev/ttyS2"

CTCSS_MAP = {
    "0000": "0000",
    "0670": "0001", "0719": "0002", "0744": "0003", "0770": "0004",
    "0797": "0005", "0825": "0006", "0854": "0007", "0885": "0008",
    "0915": "0009", "0948": "0010", "0974": "0011", "1000": "0012",
    "1035": "0013", "1072": "0014", "1109": "0015", "1148": "0016",
    "1188": "0017", "1230": "0018", "1273": "0019", "1318": "0020",
    "1365": "0021", "1413": "0022", "1462": "0023", "1514": "0024",
    "1567": "0025", "1622": "0026", "1679": "0027", "1738": "0028",
    "1799": "0029", "1862": "0030", "1928": "0031", "2035": "0032",
    "2107": "0033", "2181": "0034", "2257": "0035", "2336": "0036",
    "2418": "0037", "2503": "0038"
}

def get_serial_port():
    port = DEFAULT_SERIAL
    if os.path.exists(RADIO_JSON):
        try:
            with open(RADIO_JSON, 'r') as f:
                data = json.load(f)
                port = data.get("serial_port", DEFAULT_SERIAL)
        except:
            pass
    return port

def program_radio(rx_freq, tx_freq, ctcss_tx, ctcss_rx, squelch, bw="1", vol="8", prede="0", hpf="0", lpf="0"):
    try:
        rx_formatted = "{:.4f}".format(float(rx_freq))
        tx_formatted = "{:.4f}".format(float(tx_freq))

        if not ctcss_tx or ctcss_tx == "None": ctcss_tx = "0000"
        if not ctcss_rx or ctcss_rx == "None": ctcss_rx = "0000"
        
        radio_code_tx = CTCSS_MAP.get(ctcss_tx, "0000")
        radio_code_rx = CTCSS_MAP.get(ctcss_rx, "0000")
        
        serial_port = get_serial_port()

        ser = serial.Serial(serial_port, 9600, timeout=1)
        ser.flushInput()
        ser.flushOutput()
        
        # Format komendy to: Bandwidth, TX Freq, RX Freq, TX_CTCSS, SQ, RX_CTCSS
        cmd_group = f"AT+DMOSETGROUP={bw},{tx_formatted},{rx_formatted},{radio_code_tx},{squelch},{radio_code_rx}\r\n"
        cmd_vol = f"AT+DMOSETVOLUME={vol}\r\n"
        cmd_filter = f"AT+SETFILTER={prede},{hpf},{lpf}\r\n"

        print(f"Port: {serial_port}")
        
        print(f"Wysylanie: {cmd_group.strip()}")
        ser.write(cmd_group.encode())
        time.sleep(0.5)
        resp1 = ser.read_all().decode(errors='ignore').strip()

        print(f"Wysylanie: {cmd_vol.strip()}")
        ser.write(cmd_vol.encode())
        time.sleep(0.5)
        resp2 = ser.read_all().decode(errors='ignore').strip()

        print(f"Wysylanie: {cmd_filter.strip()}")
        ser.write(cmd_filter.encode())
        time.sleep(0.5)
        resp3 = ser.read_all().decode(errors='ignore').strip()

        ser.close()

        if "0" in resp1:
            print(f"SUKCES: Zaprogramowane! (TX CTCSS: {radio_code_tx}, RX CTCSS: {radio_code_rx}, Vol: {vol}, Filtry: {prede}/{hpf}/{lpf})")
            return True
        else:
            print(f"BLAD: Radio zwrocilo: {resp1}")
            return False

    except Exception as e:
        print(f"BLAD KRYTYCZNY UART: {e}")
        return False

if __name__ == "__main__":
    if len(sys.argv) < 6:
        print("Uzycie: setup_radio.py RX TX CTCSS_TX CTCSS_RX SQ [BW] [VOL] [PREDE] [HPF] [LPF]")
        sys.exit(1)
        
    rx = sys.argv[1]
    tx = sys.argv[2]
    cx_tx = sys.argv[3]
    cx_rx = sys.argv[4]
    sq = sys.argv[5]
    
    bw = sys.argv[6] if len(sys.argv) > 6 else "1"
    vol = sys.argv[7] if len(sys.argv) > 7 else "8"
    prede = sys.argv[8] if len(sys.argv) > 8 else "0"
    hpf = sys.argv[9] if len(sys.argv) > 9 else "0"
    lpf = sys.argv[10] if len(sys.argv) > 10 else "0"
    
    program_radio(rx, tx, cx_tx, cx_rx, sq, bw, vol, prede, hpf, lpf)