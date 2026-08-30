#!/bin/bash
GIT_URL="https://github.com/PrimeNodeSVX/PrimeNode_OPI0V1-Update"
GIT_DIR="/root/PrimeNode_OPI0V1-Update"
WWW_DIR="/var/www/html"
SVX_CONF="/etc/svxlink/svxlink.conf"
SOUNDS_DIR="/usr/local/share/svxlink/sounds"

echo "--- START UPDATE ---"
date

echo ">> Sprawdzanie wymaganych pakietow (ZIP)..."
if ! command -v zip >/dev/null 2>&1 || ! dpkg -l | grep -q "php.*-zip"; then
    echo ">> Instalacja brakujacych pakietow do obslugi kopii zapasowych..."
    apt update
    apt install zip unzip php-zip -y
    systemctl restart apache2
fi

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
    rsync -av --delete --exclude 'Core/start.wav' --exclude 'Core/ptt.wav' "$GIT_DIR/PL/" "$SOUNDS_DIR/PL/"
    chmod -R 777 "$SOUNDS_DIR/PL"
    
    if [ -f "$SVX_CONF" ]; then
        sed -i '/^\[SimplexLogic\]/,/^\[/ s/DEFAULT_LANG=pl_PL/DEFAULT_LANG=PL/' "$SVX_CONF"
        sed -i '/^\[ReflectorLogic\]/,/^\[/ s/DEFAULT_LANG=pl_PL/DEFAULT_LANG=PL/' "$SVX_CONF"
        sed -i -e 's/\x53\x51\x4C\x69\x6E\x6B/PrimeNode/g' "$SVX_CONF"
        sed -i -e 's/PrimeNode Config   /PrimeNode Config/g' "$SVX_CONF"
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
    echo ">> Instalacja skryptów Python (w tym switch_network.py)..."
    cp $GIT_DIR/*.py /usr/local/bin/
    chmod +x /usr/local/bin/*.py
fi

echo ">> Konfiguracja dynamicznych zapowiedzi audio..."
REF_DIR="$SOUNDS_DIR/ref_sounds"
CORE_DIR="$SOUNDS_DIR/PL/Core"

mkdir -p "$REF_DIR"
mkdir -p "$CORE_DIR"

if [ -d "$GIT_DIR/ref_sounds" ]; then
    cp -R "$GIT_DIR/ref_sounds/"* "$REF_DIR/" 2>/dev/null
fi

if [ -f "$GIT_DIR/PL/Core/online_PN.wav" ]; then
    cp "$GIT_DIR/PL/Core/online_PN.wav" "$CORE_DIR/online_PN.wav"
elif [ -f "$GIT_DIR/online_PN.wav" ]; then
    cp "$GIT_DIR/online_PN.wav" "$CORE_DIR/online_PN.wav"
fi

echo ">> Aktualizacja plików dźwiękowych PrimeNode..."
if [ -f "$GIT_DIR/start.wav" ]; then
    cp "$GIT_DIR/start.wav" "$CORE_DIR/start.wav"
    chmod 777 "$CORE_DIR/start.wav"
elif [ -f "$GIT_DIR/PL/Core/start.wav" ]; then
    cp "$GIT_DIR/PL/Core/start.wav" "$CORE_DIR/start.wav"
    chmod 777 "$CORE_DIR/start.wav"
fi

if [ -f "$GIT_DIR/ptt.wav" ]; then
    cp "$GIT_DIR/ptt.wav" "$CORE_DIR/ptt.wav"
    chmod 777 "$CORE_DIR/ptt.wav"
elif [ -f "$GIT_DIR/PL/Core/ptt.wav" ]; then
    cp "$GIT_DIR/PL/Core/ptt.wav" "$CORE_DIR/ptt.wav"
    chmod 777 "$CORE_DIR/ptt.wav"
fi

echo ">> Generowanie bezpiecznych łatek TCL (w trybie LOCAL)..."
TCL_LOCAL_DIR="/usr/local/share/svxlink/events.d/local"
mkdir -p "$TCL_LOCAL_DIR"

cat << 'EOF' > "$TCL_LOCAL_DIR/Logic.tcl"
namespace eval Logic {
  proc startup {} {
    playFile "/usr/local/share/svxlink/sounds/PL/Core/start.wav"
    playSilence 200
    playMsg "online"
    send_short_ident
    addMinuteTickSubscriber checkPeriodicIdentify
  }

  proc send_rgr_sound {} {
    variable sql_rx_id
    set sql_rx_id "?"
    playFile "/usr/local/share/svxlink/sounds/PL/Core/ptt.wav"
    playSilence 100
  }

  if {[info commands original_dtmf_cmd_received] == ""} {
      catch {rename dtmf_cmd_received original_dtmf_cmd_received}
  }
  proc dtmf_cmd_received {cmd} {
    set clean_cmd $cmd
    if {[string index $cmd 0] == "*"} {
      set clean_cmd [string range $cmd 1 end]
    }
    if {$clean_cmd == "997"} {
        puts ">>> Zamykanie systemu (kod 997) <<<"
        catch {playFile "/usr/local/share/svxlink/sounds/PL/Core/poweroff.wav"}
        playSilence 500
        catch {exec sudo bash -c "sleep 5 && shutdown -h now" > /dev/null 2>&1 &}
        return 1
    }
    if {$clean_cmd == "998"} {
        puts ">>> Uruchamianie Proxy Hunter (kod 998) <<<"
        catch {playMsg "Core" "szukam_proxy"}
        catch {exec sudo /usr/bin/python3 /usr/local/bin/proxy_hunter.py > /dev/null 2>&1 &}
        return 1
    }
    if {[string range $clean_cmd 0 2] == "555"} {
      set net_id [string range $clean_cmd 3 end]
      puts "Logic.tcl ROAMING: Wykryto kod 555 -> ID: $net_id"
      playTone 880 100 100
      playSilence 50
      playTone 1000 100 100
      playSilence 50
      playTone 1200 100 100
      playSilence 10
      playMsg "Core" "connecting_to"
      playMsg "Core" "online"
      catch {exec sudo /usr/local/bin/switch_network.py --dtmf $net_id > /dev/null 2>&1 &}
      return 1
    }
    if {[info commands original_dtmf_cmd_received] != ""} {
        return [original_dtmf_cmd_received $cmd]
    }
    return 0
  }
}
EOF

cat << 'EOF' > "$TCL_LOCAL_DIR/ReflectorLogic.tcl"
namespace eval ReflectorLogic {
  
  if {[info commands original_tg_selected] == ""} {
      catch {rename tg_selected original_tg_selected}
  }
  proc tg_selected {tg} {
    playTone 600 100 100
    playSilence 50
    playTone 1000 150 100
    playSilence 100
    if {$tg > 0} {
      playMsg "tg"
      playNumber $tg
    } else {
      playMsg "tg_0"
    }
    if {[info commands original_tg_selected] != ""} {
        original_tg_selected $tg
    }
  }

  if {[info commands original_reflector_connection_status_update] == ""} {
      catch {rename reflector_connection_status_update original_reflector_connection_status_update}
  }
  proc reflector_connection_status_update {is_established} {
    variable reflector_connection_established
    if {$is_established != $reflector_connection_established} {
      set reflector_connection_established $is_established
      playMsg "Core" "reflector"
      if {$is_established} {
        playMsg "Core" "connected"
      } else {
        playMsg "Core" "disconnected"
      }
    }
    if {[info commands original_reflector_connection_status_update] != ""} {
        original_reflector_connection_status_update $is_established
    }
  }
}
EOF

chmod 644 "$TCL_LOCAL_DIR/"*.tcl
chmod -R 777 "$REF_DIR"
find "$REF_DIR" -type f -exec chmod 777 {} \; 2>/dev/null
[ -f "$CORE_DIR/online_PN.wav" ] && chmod 777 "$CORE_DIR/online_PN.wav"

echo ">> Synchronizacja konfiguracji radia (Python)..."
python3 /usr/local/bin/update_svx_full.py

for script in $GIT_DIR/*.sh; do
    filename=$(basename "$script")
    if [ "$filename" != "update_dashboard.sh" ]; then
        cp "$script" /usr/local/bin/
        chmod +x "/usr/local/bin/$filename"
    fi
done

echo ">> Instalacja odpornego na bledy send_dtmf.sh..."
cat << 'EOF' > /usr/local/bin/send_dtmf.sh
#!/bin/bash
DTMF=$1
if [ -z "$DTMF" ]; then exit 1; fi

if [ ! -w "/var/lib/svxlink/dtmf_svx" ]; then
    echo "Blad: Brak aktywnego portu PTY. SvxLink nie jest gotowy."
    exit 1
fi

echo "$DTMF" > /var/lib/svxlink/dtmf_svx
EOF
chmod +x /usr/local/bin/send_dtmf.sh

if ! grep -q "/bin/cp, /usr/bin/cp" /etc/sudoers; then
    echo ">> Dodawanie uprawnień sudo dla www-data do pliku sudoers..."
    echo "www-data ALL=(ALL) NOPASSWD: /bin/rm, /usr/bin/rm" >> /etc/sudoers
    echo "www-data ALL=(ALL) NOPASSWD: /bin/cp, /usr/bin/cp" >> /etc/sudoers
    echo "www-data ALL=(ALL) NOPASSWD: /bin/chown, /usr/bin/chown" >> /etc/sudoers
    echo "www-data ALL=(ALL) NOPASSWD: /bin/chmod, /usr/bin/chmod" >> /etc/sudoers
    echo "www-data ALL=(ALL) NOPASSWD: /usr/bin/python3, /usr/bin/amixer, /usr/sbin/alsactl, /usr/bin/systemctl, /usr/sbin/reboot, /usr/sbin/shutdown" >> /etc/sudoers
fi

if ! grep -q "update_core.sh" /etc/sudoers; then
    echo ">> Dodawanie uprawnien sudo dla update_core.sh..."
    echo "www-data ALL=(ALL) NOPASSWD: /usr/local/bin/update_core.sh" >> /etc/sudoers
    systemctl restart apache2
fi

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

if [ ! -f "/etc/cron.d/echolink_update" ]; then
    cat << 'EOF' > /etc/cron.d/echolink_update
0 * * * * root /usr/bin/python3 /usr/local/bin/fetch_echolink.py >/dev/null 2>&1
EOF
    chmod 644 /etc/cron.d/echolink_update
    systemctl restart cron
fi

if [ -x "/usr/local/bin/fetch_echolink.py" ]; then
    /usr/bin/python3 /usr/local/bin/fetch_echolink.py >/dev/null 2>&1
fi

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

rm -f /dev/shm/primenode_alert_cache.txt
rm -f /dev/shm/primenode_update_status.txt

git -C /root/PrimeNode_OPI0V1-Update rev-parse HEAD > /var/www/html/local_hash.txt
chmod 666 /var/www/html/local_hash.txt

exit 0