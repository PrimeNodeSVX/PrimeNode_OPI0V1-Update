#!/bin/bash
ERROR_FLAG="/var/www/html/el_error.flag"
ONLINE_FLAG="/var/www/html/el_online.flag"
LOG_FILE="/var/log/svxlink"
rm -f "$ERROR_FLAG" "$ONLINE_FLAG"
analyze_line() {
    local line="$1"
    if [[ "$line" == *"EchoLink directory status changed to ON"* ]]; then
        touch "$ONLINE_FLAG"
        chmod 666 "$ONLINE_FLAG"
        rm -f "$ERROR_FLAG"
    fi
    if [[ "$line" == *"Disconnected from EchoLink proxy"* ]] || \
       [[ "$line" == *"Connection to proxy failed"* ]] || \
       [[ "$line" == *"Proxy authentication failed"* ]]; then
        touch "$ERROR_FLAG"
        chmod 666 "$ERROR_FLAG"
        rm -f "$ONLINE_FLAG"
    fi
    if [[ "$line" == *"EchoLink directory status changed to"* ]] && [[ "$line" != *"ON"* ]]; then
        rm -f "$ONLINE_FLAG"
    fi
}
if [ -f "$LOG_FILE" ]; then
    tail -n 300 "$LOG_FILE" | grep -a "EchoLink" | while read start_line; do
        analyze_line "$start_line"
    done
fi
tail -F -n 0 "$LOG_FILE" 2>/dev/null | while read live_line; do
    analyze_line "$live_line"
done