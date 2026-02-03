#!/bin/bash

LOG_RAM="/dev/shm/svxlink.log"
ARCHIVE_DIR="/root/svxlink_history"
FLAG_ONLINE="/var/www/html/el_online.flag"
FLAG_ERROR="/var/www/html/el_error.flag"

systemctl stop svxlink
rm -f "$FLAG_ONLINE" "$FLAG_ERROR"
rm -f "$LOG_RAM"
touch "$LOG_RAM"
chmod 777 "$LOG_RAM"
pkill -9 -f "svx_event_logger.sh"
nohup /usr/local/bin/svx_event_logger.sh > /dev/null 2>&1 &
sed -i 's|^LOGFILE=.*|LOGFILE=/dev/shm/svxlink.log|g' /etc/svxlink/svxlink.conf

sleep 2
systemctl start svxlink

exit 0