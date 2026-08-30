#!/bin/bash -e
LOG_FILE="/var/www/html/ram/core_install.log"
mkdir -p /var/www/html/ram
chmod 777 /var/www/html/ram
trap "swapoff /var/temp_svx_swap 2>/dev/null || true; rm -f /var/temp_svx_swap" EXIT

echo "=== START AKTUALIZACJI RDZENIA SVXLINK (DO STABILNEJ V26.05.1) ===" > $LOG_FILE
date >> $LOG_FILE

echo "Sprawdzanie obecnej wersji systemu..." >> $LOG_FILE
CURRENT_VER=$(/usr/bin/svxlink --version 2>/dev/null || /usr/local/bin/svxlink --version 2>/dev/null)
if [[ "$CURRENT_VER" == *"26.05.1"* ]]; then
    echo ">> Wykryto wersje 26.05.1. System posiada juz najnowszy rdzen!" >> $LOG_FILE
    echo "=== SYSTEM JEST JUZ AKTUALNY ===" >> $LOG_FILE
    exit 0
fi

echo "Zatrzymywanie usługi SvxLink..." >> $LOG_FILE
systemctl stop svxlink >> $LOG_FILE 2>&1 || true

echo "Instalacja wymaganych bibliotek (Dependencies)..." >> $LOG_FILE
apt-get update >> $LOG_FILE 2>&1 || true
apt-get install -y g++ make cmake libsigc++-2.0-dev libgsm1-dev libpopt-dev tcl-dev libgcrypt20-dev libspeex-dev libasound2-dev libopus-dev librtlsdr-dev groff doxygen libgpiod-dev >> $LOG_FILE 2>&1 || true

echo "Zabezpieczenie RAM-u (Tworzenie awaryjnego pliku wymiany SWAP 1GB)..." >> $LOG_FILE
fallocate -l 1G /var/temp_svx_swap || dd if=/dev/zero of=/var/temp_svx_swap bs=1M count=1024 >> $LOG_FILE 2>&1
chmod 600 /var/temp_svx_swap
mkswap /var/temp_svx_swap >> $LOG_FILE 2>&1
swapon /var/temp_svx_swap >> $LOG_FILE 2>&1 || true

echo "Pobieranie stabilnej wersji 26.05.1 z GitHuba..." >> $LOG_FILE
cd /tmp
rm -rf svxlink_build
git clone --branch 26.05.1 --depth 1 https://github.com/sm0svx/svxlink.git svxlink_build >> $LOG_FILE 2>&1

echo "Konfigurowanie środowiska kompilacji (CMake)..." >> $LOG_FILE
mkdir -p svxlink_build/src/build
cd svxlink_build/src/build
cmake -DCMAKE_INSTALL_PREFIX=/usr/local -DSYSCONF_INSTALL_DIR=/etc -DLOCAL_STATE_DIR=/var -DCMAKE_BUILD_TYPE=Release -DUSE_QT=OFF -DWITH_SYSTEMD=ON .. >> $LOG_FILE 2>&1

echo "Trwa kompilacja (2 watki dla bezpieczenstwa Orange Pi)..." >> $LOG_FILE
echo "To zajmie okolo 25 minut, idz zrobic kawe!" >> $LOG_FILE
make -j2 >> $LOG_FILE 2>&1

echo "Instalacja skompilowanych plików..." >> $LOG_FILE
make install >> $LOG_FILE 2>&1
ldconfig >> $LOG_FILE 2>&1

echo "Przywracanie uprawnien dla uslugi..." >> $LOG_FILE
chown -R svxlink:daemon /etc/svxlink /var/spool/svxlink /var/lib/svxlink 2>/dev/null || true

echo "Sprzątanie plików tymczasowych i usuwanie awaryjnego SWAP-a..." >> $LOG_FILE
rm -rf /tmp/svxlink_build

echo "Przywracanie plików TCL, makr i ustawień z GitHuba..." >> $LOG_FILE
sudo /usr/local/bin/update_dashboard.sh >> $LOG_FILE 2>&1 || true

echo "=== KOMPILACJA I AKTUALIZACJA ZAKONCZONA SUKCESEM! ===" >> $LOG_FILE
date >> $LOG_FILE
echo "Restart systemu za 5 sekund..." >> $LOG_FILE
sleep 5
reboot