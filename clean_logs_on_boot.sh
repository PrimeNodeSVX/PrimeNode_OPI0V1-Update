#!/bin/bash
LOG_FILE="/var/log/svxlink"
ARCHIVE_DIR="/root/svxlink_history"
MAX_ARCHIVES=5

systemctl stop svxlink

if [ -f "$LOG_FILE" ]; then
    TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
    mkdir -p "$ARCHIVE_DIR"
    cp "$LOG_FILE" "$ARCHIVE_DIR/svxlink_$TIMESTAMP.log"
    truncate -s 0 "$LOG_FILE"
    chmod 644 "$LOG_FILE"
fi

ls -1t "$ARCHIVE_DIR"/svxlink_*.log 2>/dev/null | tail -n +$((MAX_ARCHIVES + 1)) | xargs -r rm --

ps -ef | grep "tail" | grep "/var/log/svxlink" | grep -v grep | awk '{print $2}' | xargs -r kill -9
pkill -9 -f "svx_event_logger.sh"
pkill -9 -f "watchdog_el.sh"

nohup /usr/local/bin/svx_event_logger.sh > /dev/null 2>&1 &

sleep 2
systemctl start svxlink

exit 0