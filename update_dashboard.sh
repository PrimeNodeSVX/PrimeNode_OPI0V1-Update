#!/bin/bash
GIT_URL="https://github.com/PrimeNodeSVX/PrimeNode_OPI0V1-Update"
GIT_DIR="/root/PrimeNode_OPI0V1-Update"
WWW_DIR="/var/www/html"
SVX_CONF="/etc/svxlink/svxlink.conf"
SOUNDS_DIR="/usr/local/share/svxlink/sounds"

echo "--- START UPDATE ---"
date

OLD_HASH=""
NEW_HASH=""

if [ ! -d "$GIT_DIR" ]; then
    cd /root
    git clone $GIT_URL
    NEW_HASH="CLONED"
else
    cd $GIT_DIR
    git config core.fileMode false
    OLD_HASH=$(git rev-parse HEAD)
    git fetch --all
    git reset --hard origin/main
    NEW_HASH=$(git rev-parse HEAD)
    
    echo "Old Hash: $OLD_HASH"
    echo "New Hash: $NEW_HASH"
    
    if [ $? -ne 0 ]; then 
        echo "STATUS: FAILURE"
        exit 1
    fi
fi

SCRIPT_PATH="/usr/local/bin/update_dashboard.sh"
REPO_SCRIPT="$GIT_DIR/update_dashboard.sh"

if [ -f "$SCRIPT_PATH" ] && [ -f "$REPO_SCRIPT" ]; then
    if ! cmp -s "$REPO_SCRIPT" "$SCRIPT_PATH"; then
        echo ">> Aktualizacja samego skryptu update..."
        cp "$REPO_SCRIPT" "$SCRIPT_PATH"
        chmod +x "$SCRIPT_PATH"
        export SELF_UPDATED=1
        exec "$SCRIPT_PATH"
        exit 0
    fi
fi

usermod -aG dialout svxlink
usermod -aG dialout www-data
usermod -aG gpio svxlink
usermod -aG gpio www-data

if [ ! -f /dev/shm/svxlink.log ]; then
    touch /dev/shm/svxlink.log
    chmod 777 /dev/shm/svxlink.log
fi

if [ -d "$GIT_DIR/PL" ]; then
    if [ -d "$SOUNDS_DIR/pl_PL" ]; then
        rm -rf "$SOUNDS_DIR/pl_PL"
    fi
    mkdir -p "$SOUNDS_DIR"
    rsync -av --delete "$GIT_DIR/PL/" "$SOUNDS_DIR/PL/"
    chmod -R 777 "$SOUNDS_DIR/PL"
    
    if [ -f "$SVX_CONF" ]; then
        sed -i '/^\[SimplexLogic\]/,/^\[/ s/DEFAULT_LANG=pl_PL/DEFAULT_LANG=PL/' "$SVX_CONF"
        sed -i '/^\[ReflectorLogic\]/,/^\[/ s/DEFAULT_LANG=pl_PL/DEFAULT_LANG=PL/' "$SVX_CONF"
    fi
fi

if [ -d "$GIT_DIR/en_US" ]; then
    mkdir -p "$SOUNDS_DIR/en_US"
    rsync -av --delete "$GIT_DIR/en_US/" "$SOUNDS_DIR/en_US/"
    chmod -R 777 "$SOUNDS_DIR/en_US"
fi

cp $GIT_DIR/*.css $WWW_DIR/ 2>/dev/null
cp $GIT_DIR/*.js $WWW_DIR/ 2>/dev/null
cp $GIT_DIR/*.png $WWW_DIR/ 2>/dev/null
cp $GIT_DIR/*.jpg $WWW_DIR/ 2>/dev/null
cp $GIT_DIR/*.php $WWW_DIR/

mkdir -p "$WWW_DIR/flags"
cp $GIT_DIR/*.svg "$WWW_DIR/flags/" 2>/dev/null
chown -R www-data:www-data "$WWW_DIR/flags"
chmod 644 "$WWW_DIR/flags/"*.svg 2>/dev/null

if [ ! -f "$WWW_DIR/radio_config.json" ] && [ -f "$GIT_DIR/radio_config.json" ]; then
    cp $GIT_DIR/radio_config.json $WWW_DIR/
fi

if compgen -G "$GIT_DIR/*.py" > /dev/null; then
    cp $GIT_DIR/*.py /usr/local/bin/
    chmod +x /usr/local/bin/*.py
fi

for script in $GIT_DIR/*.sh; do
    filename=$(basename "$script")
    if [ "$filename" != "update_dashboard.sh" ]; then
        cp "$script" /usr/local/bin/
        chmod +x "/usr/local/bin/$filename"
    fi
done

echo ">> Sprawdzanie poprawnosci logowania do RAM..."
sed -i 's|LOG_SOURCE="/var/log/svxlink"|LOG_SOURCE="/dev/shm/svxlink.log"|g' /usr/local/bin/svx_event_logger.sh

if grep -q "/var/log/svxlink" /etc/systemd/system/svxlink.service; then
    echo ">> Korekta svxlink.service na RAM..."
    sed -i 's|--logfile=/var/log/svxlink|--logfile=/dev/shm/svxlink.log|g' /etc/systemd/system/svxlink.service
    systemctl daemon-reload
fi

rm -f /usr/local/bin/watchdog_el.sh
rm -f /usr/local/bin/fix_svxlink_nodes.sh
rm -f /usr/local/bin/svx_watchdog.sh

chown -R www-data:www-data $WWW_DIR
chmod -R 755 $WWW_DIR
sed -i '/wifi_guard.sh/d' /etc/rc.local
sed -i '/fix_svxlink_nodes.sh/d' /etc/rc.local
sed -i '/svx_watchdog.sh/d' /etc/rc.local

if ! grep -q "clean_logs_on_boot.sh" /etc/rc.local; then
    sed -i -e '$i \/usr/local/bin/clean_logs_on_boot.sh &\n' /etc/rc.local
fi

if ! grep -q "svx_reconnect.sh" /etc/rc.local; then
    sed -i -e '$i \/usr/local/bin/svx_reconnect.sh &\n' /etc/rc.local
fi

chmod +x /etc/rc.local

echo ">> Restartowanie usług..."
ps -ef | grep "tail" | grep "/var/log/svxlink" | grep -v grep | awk '{print $2}' | xargs -r kill -9
pkill -9 -f "svx_event_logger.sh"
pkill -9 -f "watchdog_el.sh"
pkill -9 -f "svx_watchdog.sh"
pkill -9 -f "svx_reconnect.sh"

FINAL_STATUS="UP_TO_DATE"
if [[ "$SELF_UPDATED" == "1" ]]; then
    FINAL_STATUS="SUCCESS"
elif [[ "$NEW_HASH" == "CLONED" ]]; then
    FINAL_STATUS="SUCCESS"
elif [[ "$OLD_HASH" != "$NEW_HASH" ]]; then
    FINAL_STATUS="SUCCESS"
fi

echo "STATUS: $FINAL_STATUS"

if [[ "$FINAL_STATUS" == "UP_TO_DATE" ]]; then
    if [ ! -f /dev/shm/svxlink.log ]; then
        touch /dev/shm/svxlink.log
        chmod 777 /dev/shm/svxlink.log
    fi

    nohup /usr/local/bin/svx_event_logger.sh > /dev/null 2>&1 &
    nohup /usr/local/bin/svx_reconnect.sh > /dev/null 2>&1 &
fi

rm -f /tmp/primenode_alert_cache.txt

exit 0