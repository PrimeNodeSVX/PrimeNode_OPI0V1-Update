#!/bin/bash

LOG_FILE="/dev/shm/svxlink.log"

while [ ! -f "$LOG_FILE" ]; do
  sleep 5
done

tail -F -n0 "$LOG_FILE" | while read line; do

  if echo "$line" | grep -q "ReflectorLogic: Heartbeat timeout"; then
    echo "[$(date)] >> WYKRYTO HEARTBEAT TIMEOUT! Wymuszam natychmiastowy restart..." >> /dev/shm/watchdog.log

    systemctl restart svxlink

    sleep 15
  fi
done