#!/bin/bash

LOG_SOURCE="/dev/shm/svxlink.log"
LOG_DEST="/var/www/html/svx_events.log"
FLAG_ONLINE="/var/www/html/el_online.flag"
FLAG_ERROR="/var/www/html/el_error.flag"

if [ ! -f "$LOG_SOURCE" ]; then
    touch "$LOG_SOURCE"
    chmod 777 "$LOG_SOURCE"
fi

for pid in $(pgrep -f "svx_event_logger.sh"); do
    if [ "$pid" != "$$" ]; then
        kill -9 "$pid" 2>/dev/null
    fi
done

ps -ef | grep "tail" | grep "svxlink" | grep -v grep | awk '{print $2}' | xargs -r kill -9
touch $LOG_DEST
chown www-data:www-data $LOG_DEST
chmod 644 $LOG_DEST

LAST_LINE=""

tail -F -n 0 "$LOG_SOURCE" 2>/dev/null | \
grep --line-buffered -a -E "ReflectorLogic|EchoLink|Tx1|Rx1|Node|Talker|Underrun|Clipping|Distortion|ModuleEchoLink" | \
while read -r line; do
    if [ "$line" == "$LAST_LINE" ]; then
        continue
    fi
    LAST_LINE="$line"
    

    echo "$line" >> "$LOG_DEST"
    case "$line" in
        *"EchoLink directory status changed to ON"*)
            touch "$FLAG_ONLINE"
            rm -f "$FLAG_ERROR"
            chown www-data:www-data "$FLAG_ONLINE"
            ;;
        *"EchoLink directory status changed to"*"OFF"*)
            rm -f "$FLAG_ONLINE"
            ;;
        *"EchoLink authentication failed"*|*"Connection failed"*|*"Disconnected from EchoLink proxy"*)
            rm -f "$FLAG_ONLINE"
            touch "$FLAG_ERROR"
            chown www-data:www-data "$FLAG_ERROR"
            ;;
    esac
done &