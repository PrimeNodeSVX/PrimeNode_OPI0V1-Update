<?php
$H = [
    'pl' => [
        'title' => 'Centrum Dowodzenia i Pomocy PrimeNode by SQ7UTP',
        'subtitle' => 'System zaprojektowany dla:',
        'hw_desc' => '<strong style="color: #FF9800;">Orange Pi Zero</strong> + <strong style="color: #2196F3;">Moduł SA818</strong>',
        's1_title' => '1. Twój Kokpit (Dashboard)',
        's1_text' => 'To tutaj sprawdzasz puls swojego urządzenia. Wszystko powinno świecić na zielono!',
        's1_msg' => '📢 Pasek Komunikatów:',
        's1_msg_d' => 'Jeśli na samej górze strony zobaczysz niebieski pasek z tekstem, to <strong>ważna wiadomość od Administratora</strong> (np. o dostępnej aktualizacji).',
        's1_stat' => '🚦 Pasek Statusu:',
        's1_stat_d' => 'To ten kolorowy pasek pod nagłówkiem. <span style="color:#4CAF50; font-weight:bold;">ZIELONY</span> = OK. <span style="color:#F44336; font-weight:bold;">CZERWONY</span> = Awaria (zrób restart).',
        's1_temp' => '🌡️ Temperatura:',
        's1_temp_d' => 'Orange Pi Zero lubi być ciepłe. 35°C - 60°C to norma.',
        's1_mon' => '📺 Wielki Monitor (Live):',
        's1_mon_d' => 'Tu widzisz, co się dzieje w eterze:',
        's1_mon_stby' => '⚪ <strong>Cisza (Standby):</strong> Nikt nie gada, nuda.',
        's1_mon_rx' => '🟢 <span style="color:#4CAF50; font-weight:bold;">ODBIERANIE (RX):</span> Ty mówisz do radia (Hotspot Cię słyszy).',
        's1_mon_tx' => '🟠 <span style="color:#FF9800; font-weight:bold;">NADAWANIE (TX):</span> Ktoś mówi z sieci.',
        's1_mon_info' => '✨ <strong>Inteligentne Info:</strong> System rozpoznaje rozmówcę! Pod znakiem wyświetli się <strong>Imię i Miasto</strong> operatora (pobierane z bazy węzłów).',
        
        's2_title' => '2. Dwa Światy: Reflektor i EchoLink',
        's2_text' => 'Pamiętaj: Możesz być tylko w jednym miejscu naraz!',
        's2_a_title' => '🅰️ Świat A: Reflektor',
        's2_a_desc' => 'To jest Twój "dom". Jesteś tu zawsze po uruchomieniu.<br>Rozmawiasz z polskimi stacjami na grupach (np. Ogólnopolska).',
        's2_b_title' => '🅱️ Świat B: EchoLink (Światowy)',
        's2_b_desc' => 'Chcesz pogadać z kimś z USA, Japonii czy innego miasta?',
        's2_b_step1' => '1. Kliknij <strong>🚀 Aktywuj Moduł (2#)</strong> lub użyj przycisku w Configu.',
        's2_b_step2' => '2. Wpisz numer węzła i kliknij <strong>📞 Połącz</strong>.',
        's2_warn' => '🛑 <strong>WAŻNE - KONIEC ROZMOWY:</strong>',
        's2_disc' => 'Aby wrócić do sieci reflektora, musisz wyjść z EchoLinka przyciskiem <span style="color:#F44336; font-weight:bold;">Rozłącz (#)</span>.',

        'roam_title' => '3. Roaming i Baza Sieci (NOWOŚĆ!)',
        'roam_text' => 'System PrimeNode obsługuje teraz dynamiczne przełączanie między różnymi sieciami (Reflektorami).',
        'roam_cfg' => '<strong>🛠️ Edytor w Configu:</strong>',
        'roam_cfg_d' => 'W zakładce <strong>Config</strong> znajdziesz nową sekcję "Baza Sieci". Możesz tam dodawać własne serwery (np. SQLink, FM Poland, lokalne).',
        'roam_dtmf' => '<strong>📞 Przełączanie z Radia (555):</strong>',
        'roam_dtmf_d' => 'Aby zmienić sieć bez wchodzenia na stronę, wpisz na radiu kod w formacie: <span style="color:#FF9800; font-weight:bold;">555 + ID + #</span>.',
        'roam_ex' => 'Przykład: <strong>5551#</strong> (Włącza sieć o ID 1), <strong>5552#</strong> (Włącza sieć o ID 2). System zrestartuje się i połączy z nowym serwerem.',

        's3_title' => '4. Zakładka DTMF (Edytor i Pilot)',
        's3_text' => 'Pełna wolność! Teraz możesz dowolnie edytować układ przycisków sterujących.',
        's3_move' => '✨ <strong>Drag & Drop:</strong> Przytrzymaj i przeciągnij kafelek, aby zmienić jego kolejność!',
        's3_tabs' => '<strong>📂 Własne Zakładki:</strong> Możesz tworzyć nowe grupy (np. "Moje Ulubione").',
        's3_btns' => '<strong>🎛️ Dodawanie Przycisków:</strong> Na dole każdej zakładki jest formularz. Wpisz <strong>Nazwę</strong> i <strong>Kod TG</strong>, kliknij "+".',
        's3_del' => '<strong>❌ Usuwanie:</strong> Każdy przycisk możesz usunąć małym "x".',
        's3_info' => '<strong>ℹ️ Status (*#):</strong> Hotspot powie która godzina itp.',

        's4_title' => '5. Audio i WiFi',
        's4_warn' => '⚠️ <strong>Ostrożnie z suwakami Audio!</strong>',
        's4_mic' => '<strong>🎙️ Suwak MIC Boost / ADC Gain:</strong> Reguluje głośność Twojego głosu w sieci. (Ustaw tak, by nie było przesterów).',
        's4_tx' => '<strong>🔊 Suwak TX Volume:</strong> Reguluje jak głośno słyszysz rozmówców w swoim radiu.',
        's4_wifi' => '<strong>📶 WiFi:</strong> Zarządzanie sieciami bezprzewodowymi.',

        's5_title' => '6. Zasilanie, Aktualizacje i Terminal',
        's5_text' => 'Centrum sterowania życiem systemu.',
        's5_reb' => '<strong>🔄 Reboot / Wyłącz:</strong> Bezpieczne zamykanie systemu.',
        's5_upd' => '<strong>☁️ Aktualizuj System:</strong> Pobiera nowości z repozytoriów technicznych i naprawia błędy.',
        's5_rst' => '<strong>♻️ Restart Usługi SvxLink:</strong> "Lekarstwo na wszystko". Kliknij, jeśli zniknie dźwięk.',
        's5_ssh' => '<strong>💻 Web Terminal (SSH):</strong>',
        's5_ssh_d' => 'Dostęp do konsoli systemowej z przeglądarki. Kliknij zakładkę "Terminal" i "Uruchom". Pamiętaj o kliknięciu "Zatrzymaj" po pracy!',

        's6_title' => '7. Wskazówki (Warto wiedzieć)',
        's6_api' => '<strong>🔗 API Węzłów:</strong>',
        's6_api_d' => 'Adres w Configu, skąd pobierana jest lista stacji.',
        's6_mute' => '<strong>🔇 Cisza w Eterze:</strong>',
        's6_mute_d' => 'Możesz wyłączyć "Recytowanie Znaku" w ustawieniach zaawansowanych.',
        's6_hw' => '<strong>🛠️ Sprzęt i GPIO:</strong>',
        's6_hw_d' => 'Zmiana pinów PTT/SQL w zakładce <strong>Radio</strong>.',
        's6_card' => '<strong>🌍 Twoja Wizytówka:</strong>',
        's6_card_d' => 'Uzupełnij "Lokalizacja i Operator" w Configu, by inni widzieli Cię na mapie.',
        's6_map' => '<strong>🗺️ Grid Mapper:</strong>',
        's6_map_d' => 'Mapa aktywnych stacji w zakładce <strong>Nodes</strong>.',

        'qa_title' => 'Szybka Pomoc (Q&A)',
        'qa_q1' => '❓ Nie mogę połączyć się z EchoLinkiem (Status: Disconnected).',
        'qa_a1' => '✅ Jeśli używasz LTE, operatorzy blokują porty. Wejdź w <strong>Config</strong> i kliknij <strong>♻️ Auto-Proxy</strong>.',
        'qa_q2' => '❓ Lista "Last Heard" jest pusta po restarcie.',
        'qa_a2' => '✅ To normalne. Logi są trzymane w pamięci RAM (System Turbo). Historia czyści się przy restarcie.',
        'qa_q3' => '❓ W logach widzę "Distortion detected".',
        'qa_a3' => '✅ Twoje radio nadaje zbyt głośno (przester). Zmniejsz <em>ADC Gain</em> w zakładce Audio.'
    ],
    'en' => [
        'title' => 'Command & Help Center PrimeNode by SQ7UTP',
        'subtitle' => 'System designed for:',
        'hw_desc' => '<strong style="color: #FF9800;">Orange Pi Zero</strong> + <strong style="color: #2196F3;">SA818 Module</strong>',
        's1_title' => '1. Your Dashboard',
        's1_text' => 'This is where you check the pulse of your device. Everything should be green!',
        's1_msg' => '📢 Message Bar:',
        's1_msg_d' => 'Blue bar at the top means an <strong>important message from Administrator</strong>.',
        's1_stat' => '🚦 Status Bar:',
        's1_stat_d' => '<span style="color:#4CAF50; font-weight:bold;">GREEN</span> = System OK. <span style="color:#F44336; font-weight:bold;">RED</span> = Error (restart via Power tab).',
        's1_temp' => '🌡️ Temperature:',
        's1_temp_d' => '35°C - 60°C is OK.',
        's1_mon' => '📺 Big Monitor (Live):',
        's1_mon_d' => 'Here you see what is happening on air:',
        's1_mon_stby' => '⚪ <strong>Silence (Standby):</strong> No one is talking.',
        's1_mon_rx' => '🟢 <span style="color:#4CAF50; font-weight:bold;">RECEIVING (RX):</span> You are talking (Hotspot hears you).',
        's1_mon_tx' => '🟠 <span style="color:#FF9800; font-weight:bold;">TRANSMITTING (TX):</span> Someone is talking from internet.',
        's1_mon_info' => '✨ <strong>Smart Info:</strong> System recognizes the caller! You will see <strong>Name and City</strong> below the callsign.',

        's2_title' => '2. Two Worlds: Reflector & EchoLink',
        's2_text' => 'Remember: You can only be in one place at a time!',
        's2_a_title' => '🅰️ World A: Reflector',
        's2_a_desc' => 'This is your "home". You connect here automatically on startup.',
        's2_b_title' => '🅱️ World B: EchoLink (Global)',
        's2_b_desc' => 'Talk to the world (USA, Japan, etc.).',
        's2_b_step1' => '1. Click <strong>🚀 Activate Module (2#)</strong>.',
        's2_b_step2' => '2. Enter node number and click <strong>📞 Connect</strong>.',
        's2_warn' => '🛑 <strong>IMPORTANT - END CALL:</strong>',
        's2_disc' => 'To return to reflector, use <span style="color:#F44336; font-weight:bold;">Disconnect (#)</span> button.',

        'roam_title' => '3. Roaming & Network Database (NEW!)',
        'roam_text' => 'PrimeNode system now supports dynamic switching between different networks (Reflectors).',
        'roam_cfg' => '<strong>🛠️ Config Editor:</strong>',
        'roam_cfg_d' => 'In <strong>Config</strong> tab (bottom), you will find "Network Database". Add your favorite servers here and assign them an <strong>ID</strong>.',
        'roam_dtmf' => '<strong>📞 DTMF Switching (555):</strong>',
        'roam_dtmf_d' => 'To switch network via radio, dial: <span style="color:#FF9800; font-weight:bold;">555 + ID + #</span>.',
        'roam_ex' => 'Example: <strong>5551#</strong> (Switch to ID 1), <strong>5552#</strong> (Switch to ID 2). System will reboot to new server.',

        's3_title' => '4. DTMF Tab (Editor & Remote)',
        's3_text' => 'Total freedom! You can now customize your control buttons.',
        's3_move' => '✨ <strong>Drag & Drop:</strong> Hold and drag a button to reorder it!',
        's3_tabs' => '<strong>📂 Custom Tabs:</strong> Create new groups (e.g. "Favorites").',
        's3_btns' => '<strong>🎛️ Adding Buttons:</strong> Enter <strong>Name</strong> and <strong>TG Code</strong>, click "+".',
        's3_del' => '<strong>❌ Deleting:</strong> You can remove any button or tab.',
        's3_info' => '<strong>ℹ️ Status (*#):</strong> Makes the hotspot speak status info.',

        's4_title' => '5. Audio & WiFi',
        's4_warn' => '⚠️ <strong>Careful with Audio sliders!</strong>',
        's4_mic' => '<strong>🎙️ MIC Boost / ADC Gain:</strong> Your voice volume sent to network.',
        's4_tx' => '<strong>🔊 TX Volume:</strong> Volume of others heard on your radio.',
        's4_wifi' => '<strong>📶 WiFi:</strong> Manage wireless networks.',

        's5_title' => '6. Power, Updates & Terminal',
        's5_text' => 'Control center for system life.',
        's5_reb' => '<strong>🔄 Reboot / Shutdown:</strong> Safe shutdown.',
        's5_upd' => '<strong>☁️ Update System:</strong> Pulls latest fixes from GitHub.',
        's5_rst' => '<strong>♻️ Restart SvxLink Service:</strong> "Cure for everything". Fixes audio issues.',
        's5_ssh' => '<strong>💻 Web Terminal (SSH):</strong>',
        's5_ssh_d' => 'System console access from browser. Click "Terminal" -> "Start". Remember to stop it after work!',

        's6_title' => '7. Tips (Pro Version)',
        's6_api' => '<strong>🔗 Node API:</strong>',
        's6_api_d' => 'Source of station list in Config.',
        's6_mute' => '<strong>🔇 Silence on Air:</strong>',
        's6_mute_d' => 'Disable "Callsign Recitation" in Config.',
        's6_hw' => '<strong>🛠️ Hardware & GPIO:</strong>',
        's6_hw_d' => 'Change UART ports and GPIO in <strong>Radio</strong> tab.',
        's6_card' => '<strong>🌍 Network Card:</strong>',
        's6_card_d' => 'Fill "Location & Operator" in Config to be visible on map.',
        's6_map' => '<strong>🗺️ Grid Mapper:</strong>',
        's6_map_d' => 'Map of active stations in <strong>Nodes</strong> tab.',

        'qa_title' => 'Quick Help (Q&A)',
        'qa_q1' => '❓ EchoLink not connecting.',
        'qa_a1' => '✅ LTE blocks ports. Use <strong>♻️ Auto-Proxy</strong> in <strong>Config</strong>.',
        'qa_q2' => '❓ "Last Heard" list is empty after reboot.',
        'qa_a2' => '✅ Normal behavior. Logs are in RAM (Turbo System).',
        'qa_q3' => '❓ Logs show "Distortion detected".',
        'qa_a3' => '✅ Input too loud. Decrease <em>ADC Gain</em> in Audio tab.'
    ]
];
?>
<h3>🎓 <?php echo $H[$lang]['title']; ?></h3>
<div style="text-align: center; margin-bottom: 20px; font-size: 0.9em; color: #888; background: #222; padding: 5px; border-radius: 4px; border: 1px solid #444;">
    ℹ️ <?php echo $H[$lang]['subtitle']; ?> <?php echo $H[$lang]['hw_desc']; ?>
</div>

<div class="help-section">
    <div class="help-title"><span class="help-icon">🖥️</span> <?php echo $H[$lang]['s1_title']; ?></div>
    <div class="help-text">
        <?php echo $H[$lang]['s1_text']; ?>
        <ul>
            <li style="margin-bottom: 5px;"><strong><?php echo $H[$lang]['s1_msg']; ?></strong> <?php echo $H[$lang]['s1_msg_d']; ?></li>
            <li><strong><?php echo $H[$lang]['s1_stat']; ?></strong> <?php echo $H[$lang]['s1_stat_d']; ?></li>
            <li><strong><?php echo $H[$lang]['s1_temp']; ?></strong> <?php echo $H[$lang]['s1_temp_d']; ?>
                <br><small><?php echo $H[$lang]['s1_temp_ok']; ?><br><?php echo $H[$lang]['s1_temp_hot']; ?></small>
            </li>
            <li><strong><?php echo $H[$lang]['s1_mon']; ?></strong> <?php echo $H[$lang]['s1_mon_d']; ?>
                <ul>
                    <li><?php echo $H[$lang]['s1_mon_stby']; ?></li>
                    <li><?php echo $H[$lang]['s1_mon_rx']; ?></li>
                    <li><?php echo $H[$lang]['s1_mon_tx']; ?></li>
                    <li style="margin-top:5px; color:#4CAF50;"><?php echo $H[$lang]['s1_mon_info']; ?></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="help-section">
    <div class="help-title"><span class="help-icon">🔄</span> <?php echo $H[$lang]['s2_title']; ?></div>
    <div class="help-text">
        <?php echo $H[$lang]['s2_text']; ?>
        
        <div class="help-step">
            <strong><?php echo $H[$lang]['s2_a_title']; ?></strong><br>
            <?php echo $H[$lang]['s2_a_desc']; ?>
        </div>

        <div class="help-step" style="border-left-color: #2196F3;">
            <strong><?php echo $H[$lang]['s2_b_title']; ?></strong><br>
            <?php echo $H[$lang]['s2_b_desc']; ?><br>
            <?php echo $H[$lang]['s2_b_step1']; ?><br>
            <?php echo $H[$lang]['s2_b_step2']; ?><br>
            <hr style="border: 0; border-top: 1px dashed #555; margin: 10px 0;">
            <?php echo $H[$lang]['s2_warn']; ?><br>
            <?php echo $H[$lang]['s2_disc']; ?>
        </div>
    </div>
</div>

<div class="help-section" style="border-left: 3px solid #FF9800; background: rgba(255,152,0,0.05); padding: 15px;">
    <div class="help-title" style="color: #FF9800;"><span class="help-icon">🌐</span> <?php echo $H[$lang]['roam_title']; ?></div>
    <div class="help-text">
        <p><?php echo $H[$lang]['roam_text']; ?></p>
        
        <div style="margin-bottom: 10px;">
            <?php echo $H[$lang]['roam_cfg']; ?><br>
            <small style="color:#aaa;"><?php echo $H[$lang]['roam_cfg_d']; ?></small>
        </div>
        
        <div>
            <?php echo $H[$lang]['roam_dtmf']; ?><br>
            <small><?php echo $H[$lang]['roam_dtmf_d']; ?></small><br>
            <div style="background:#222; padding:5px; margin-top:5px; border-radius:3px; font-family:monospace;">
                <?php echo $H[$lang]['roam_ex']; ?>
            </div>
        </div>
    </div>
</div>

<div class="help-section">
    <div class="help-title"><span class="help-icon">📱</span> <?php echo $H[$lang]['s3_title']; ?></div>
    <div class="help-text">
        <?php echo $H[$lang]['s3_text']; ?>
        <ul>
            <li style="margin-bottom: 8px;"><?php echo $H[$lang]['s3_move']; ?></li>
            <li><?php echo $H[$lang]['s3_tabs']; ?></li>
            <li><?php echo $H[$lang]['s3_btns']; ?></li>
            <li><?php echo $H[$lang]['s3_del']; ?></li>
            <li style="margin-top:10px;"><?php echo $H[$lang]['s3_info']; ?></li>
        </ul>
    </div>
</div>

<div class="help-section">
    <div class="help-title"><span class="help-icon">🎚️</span> <?php echo $H[$lang]['s4_title']; ?></div>
    <div class="help-text">
        <div class="help-warn">
            <?php echo $H[$lang]['s4_warn']; ?>
        </div>
        <ul>
            <li><?php echo $H[$lang]['s4_mic']; ?></li>
            <li><?php echo $H[$lang]['s4_tx']; ?></li>
            <li><?php echo $H[$lang]['s4_wifi']; ?></li>
        </ul>
    </div>
</div>

<div class="help-section">
    <div class="help-title"><span class="help-icon">⚡</span> <?php echo $H[$lang]['s5_title']; ?></div>
    <div class="help-text">
        <?php echo $H[$lang]['s5_text']; ?>
        <ul>
            <li><?php echo $H[$lang]['s5_reb']; ?></li>
            <li><?php echo $H[$lang]['s5_upd']; ?></li>
            <li><?php echo $H[$lang]['s5_rst']; ?></li>
            <li style="margin-top: 10px;"><?php echo $H[$lang]['s5_ssh']; ?> <?php echo $H[$lang]['s5_ssh_d']; ?></li>
        </ul>
    </div>
</div>

<div class="help-section">
    <div class="help-title" style="color: #BA68C8;"><span class="help-icon">💡</span> <?php echo $H[$lang]['s6_title']; ?></div>
    <div class="help-text">
        <ul>
            <li style="margin-bottom: 8px;"><?php echo $H[$lang]['s6_api']; ?>
                <br><?php echo $H[$lang]['s6_api_d']; ?>
            </li>
            <li style="margin-bottom: 8px;"><?php echo $H[$lang]['s6_mute']; ?>
                <br><?php echo $H[$lang]['s6_mute_d']; ?>
            </li>
            <li style="margin-bottom: 8px;"><?php echo $H[$lang]['s6_hw']; ?>
                <br><?php echo $H[$lang]['s6_hw_d']; ?>
            </li>
            <li style="margin-bottom: 8px;"><?php echo $H[$lang]['s6_card']; ?>
                <br><?php echo $H[$lang]['s6_card_d']; ?>
            </li>
            <li style="margin-bottom: 8px;"><?php echo $H[$lang]['s6_map']; ?>
                <br><?php echo $H[$lang]['s6_map_d']; ?>
            </li>
        </ul>
    </div>
</div>

<div class="help-section" style="border:none;">
    <div class="help-title"><span class="help-icon">🔧</span> <?php echo $H[$lang]['qa_title']; ?></div>
    <div class="help-text">
        <strong><?php echo $H[$lang]['qa_q1']; ?></strong><br>
        <?php echo $H[$lang]['qa_a1']; ?><br><br>
        
        <strong><?php echo $H[$lang]['qa_q2']; ?></strong><br>
        <?php echo $H[$lang]['qa_a2']; ?><br><br>

        <strong><?php echo $H[$lang]['qa_q3']; ?></strong><br>
        <?php echo $H[$lang]['qa_a3']; ?>
    </div>
</div>