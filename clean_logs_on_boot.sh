#!/bin/bash
ARCHIVE_DIR="/root/svxlink_history"
MAX_ARCHIVES=5
FLAG_ONLINE="/var/www/html/el_online.flag"
FLAG_ERROR="/var/www/html/el_error.flag"
LOG_RAM="/dev/shm/svxlink.log"

systemctl stop svxlink
rm -f "$FLAG_ONLINE" "$FLAG_ERROR"
touch "$LOG_RAM"
chmod 666 "$LOG_RAM"
pkill -9 -f "svx_event_logger.sh"
nohup /usr/local/bin/svx_event_logger.sh > /dev/null 2>&1 &
sleep 2
/usr/bin/python3 /usr/local/bin/update_svx_full.py

systemctl start svxlink

exit 0