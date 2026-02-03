<?php
$H = [
    'pl' => [
        'title' => 'Centrum Dowodzenia i Pomocy PrimeNode by SQ7UTP',
        'subtitle' => 'System zaprojektowany dla:',
        'hw_desc' => '<strong style="color: #FF9800;">Orange Pi Zero</strong> + <strong style="color: #2196F3;">Moduł SA818</strong>',
        's1_title' => '1. Twój Kokpit (Dashboard)',
        's1_text' => 'To tutaj sprawdzasz puls swojego urządzenia. Wszystko powinno świecić na zielono!',
        's1_msg' => '📢 Pasek Komunikatów:',
        's1_msg_d' => 'Jeśli na samej górze strony zobaczysz niebieski pasek z tekstem, to <strong>ważna wiadomość od Administratora</strong> (np. o dostępnej aktualizacji, awarii sieci lub pracach technicznych).',
        's1_stat' => '🚦 Pasek Statusu:',
        's1_stat_d' => 'To ten kolorowy pasek pod nagłówkiem. Jeśli jest <span style="color:#4CAF50; font-weight:bold;">ZIELONY</span>, system działa. Jeśli <span style="color:#F44336; font-weight:bold;">CZERWONY</span>, coś się popsuło (zrób restart w zakładce Zasilanie).',
        's1_temp' => '🌡️ Temperatura:',
        's1_temp_d' => 'Orange Pi Zero lubi być ciepłe, ale bez przesady.',
        's1_temp_ok' => '✅ 35°C - 60°C: Jest OK.',
        's1_temp_hot' => '🔥 > 75°C: Za gorąco! Zapewnij mu trochę powietrza.',
        's1_mon' => '📺 Wielki Monitor (Live):',
        's1_mon_d' => 'Tu widzisz, co się dzieje w eterze:',
        's1_mon_stby' => '⚪ <strong>Cisza (Standby):</strong> Nikt nie gada, nuda.',
        's1_mon_rx' => '🟢 <span style="color:#4CAF50; font-weight:bold;">ODBIERANIE (RX):</span> Ty mówisz do radia (Hotspot Cię słyszy).',
        's1_mon_tx' => '🟠 <span style="color:#FF9800; font-weight:bold;">NADAWANIE (TX):</span> Ktoś mówi z internetu (Słyszysz to w radiu).',
        
        's2_title' => '2. Dwa Światy: Reflektor i EchoLink',
        's2_text' => 'Pamiętaj: Możesz być tylko w jednym miejscu naraz!',
        's2_a_title' => '🅰️ Świat A: Reflektor',
        's2_a_desc' => 'To jest Twój "dom". Jesteś tu zawsze po uruchomieniu.<br>Rozmawiasz z polskimi stacjami na grupach (np. Ogólnopolska).',
        's2_b_title' => '🅱️ Świat B: EchoLink (Światowy)',
        's2_b_desc' => 'Chcesz pogadać z kimś z USA, Japonii czy innego miasta?',
        's2_b_step1' => '1. Kliknij <strong>🚀 Aktywuj Moduł (2#)</strong> lub użyj przycisku w Configu.',
        's2_b_step2' => '2. Wpisz numer węzła i kliknij <strong>📞 Połącz</strong>.',
        's2_warn' => '🛑 <strong>WAŻNE - KONIEC ROZMOWY:</strong>',
        's2_disc' => 'Aby wrócić do sieci reflektora, musisz wyjść z EchoLinka przyciskiem <span style="color:#F44336; font-weight:bold;">Rozłącz (#)</span>.<br><span style="color:#FF9800;">👉 Jeśli nadal jesteś w EchoLinku, naciśnij <strong>Rozłącz</strong> jeszcze raz! Musisz usłyszeć komunikat "Deactivating module EchoLink".</span>',

        's3_title' => '3. Zakładka DTMF (Edytor i Pilot)',
        's3_text' => 'Pełna wolność! Teraz możesz dowolnie edytować układ przycisków sterujących.',
        's3_tabs' => '<strong>📂 Własne Zakładki:</strong> Możesz tworzyć nowe grupy (np. "Moje Ulubione", "DX"). Użyj pola na górze "Nowa Zakładka".',
        's3_btns' => '<strong>🎛️ Dodawanie Przycisków:</strong> Na dole każdej zakładki masz formularz. Wpisz <strong>Nazwę</strong> i <strong>Kod TG</strong> (lub komendę DTMF), kliknij "+" i gotowe! Przycisk działa od razu.',
        's3_del' => '<strong>❌ Usuwanie:</strong> Każdy przycisk i każdą zakładkę możesz usunąć małym "x". System zapamiętuje zmiany automatycznie.',
        's3_info' => '<strong>ℹ️ Status (*#):</strong> Przycisk Status sprawi, że hotspot przemówi (godzina, IP, logowanie).',
        's3_key' => '<strong>⌨️ Klawiatura:</strong> Tradycyjna klawiatura numeryczna do wpisywania kodów ręcznie.',

        's4_title' => '4. Audio i WiFi',
        's4_warn' => '⚠️ <strong>Ostrożnie z suwakami Audio!</strong> Zła konfiguracja może sprawić, że przestaniesz być słyszany.',
        's4_mic' => '<strong>🎙️ Suwak MIC Boost / ADC Gain:</strong> Reguluje głośność Twojego głosu w sieci.',
        's4_tx' => '<strong>🔊 Suwak TX Volume:</strong> Reguluje jak głośno słyszysz rozmówców w swoim radiu.',
        's4_wifi' => '<strong>📶 WiFi:</strong> Możesz tu dodać nową sieć (np. z telefonu) lub usunąć stare, nieużywane sieci.',

        's5_title' => '5. Zasilanie i Aktualizacje',
        's5_text' => 'W zakładce <strong>Zasilanie</strong> masz centrum sterowania życiem systemu.',
        's5_reb' => '<strong>🔄 Reboot / Wyłącz:</strong> Bezpieczne zamykanie systemu.',
        's5_upd' => '<strong>☁️ Aktualizuj System:</strong> Kliknij zielony przycisk, żeby pobrać nowości. Skrypt automatycznie wykrywa i naprawia błędy konfiguracji.',
        's5_rst' => '<strong>♻️ Restart Usługi SvxLink:</strong> "Lekarstwo na wszystko". Jeśli dźwięk zniknie - kliknij to. Trwa to tylko 5-10 sekund.',

        's6_title' => '6. Wskazówki i Nowe Funkcje (Warto wiedzieć)',
        's6_text' => 'Oto kilka przydatnych funkcji wersji PRO:',
        's6_api' => '<strong>🔗 API Węzłów (Nowość):</strong>',
        's6_api_d' => 'W zakładce <strong>Config</strong> znajdziesz pole <em>"Node API URL"</em>. To adres, z którego Dashboard pobiera listę aktywnych stacji. Nie zmieniaj go, chyba że wiesz co robisz.',
        's6_mute' => '<strong>🔇 Cisza w Eterze (Recytacja Znaku):</strong>',
        's6_mute_d' => 'Denerwuje Cię ciągłe "Stefan Paweł..."? W zakładce <strong>Config</strong> (Zaawansowane) możesz wyłączyć opcję <strong>Recytowanie Znaku</strong>.',
        's6_hw' => '<strong>🛠️ Sprzęt i GPIO:</strong>',
        's6_hw_d' => 'W zakładce <strong>Radio</strong> możesz zmienić porty UART oraz piny GPIO PTT/SQL bez grzebania w plikach.',
        's6_card' => '<strong>🌍 Twoja Wizytówka:</strong>',
        's6_card_d' => 'W zakładce <strong>Config</strong> uzupełnij sekcję <em>"Lokalizacja i Operator"</em>, aby inni widzieli Twoje imię na mapie.',
        's6_map' => '<strong>🗺️ Grid Mapper:</strong>',
        's6_map_d' => 'W zakładce <strong>Nodes</strong> znajdziesz mapę aktywnych stacji.',
        's6_qrz' => '<strong>🖱️ Szybki Podgląd QRZ:</strong>',
        's6_qrz_d' => 'Kliknij w znak stacji na liście węzłów, aby otworzyć jej profil na QRZ.com.',
        's6_lang' => '<strong>🌐 Język (PL/EN):</strong>',
        's6_lang_d' => 'Kliknij flagę w rogu, aby zmienić język interfejsu.',

        'qa_title' => 'Szybka Pomoc (Q&A)',
        'qa_q1' => '❓ Nie mogę połączyć się z EchoLinkiem (Status: Disconnected).',
        'qa_a1' => '✅ Jeśli używasz LTE, operatorzy blokują porty. Wejdź w <strong>Config</strong> i kliknij <strong>♻️ Auto-Proxy</strong>.',
        'qa_q2' => '❓ Lista "Last Heard" jest pusta po restarcie.',
        'qa_a2' => '✅ To normalne. W ramach optymalizacji (System Turbo), logi są trzymane w pamięci RAM. Po restarcie urządzenia historia zaczyna się od nowa.',
        'qa_q3' => '❓ Słyszę komunikaty, ale nikt mnie nie słyszy.',
        'qa_a3' => '✅ Sprawdź częstotliwość radia i ton CTCSS w zakładce <strong>📻 Radio</strong>.',
        'qa_q4' => '❓ W logach widzę "Distortion detected".',
        'qa_a4' => '✅ Twoje radio nadaje zbyt głośno (przester). Zmniejsz <em>ADC Gain</em> w zakładce Audio.'
    ],
    'en' => [
        'title' => 'Command & Help Center PrimeNode by SQ7UTP',
        'subtitle' => 'System designed for:',
        'hw_desc' => '<strong style="color: #FF9800;">Orange Pi Zero</strong> + <strong style="color: #2196F3;">SA818 Module</strong>',
        's1_title' => '1. Your Dashboard',
        's1_text' => 'This is where you check the pulse of your device. Everything should be green!',
        's1_msg' => '📢 Message Bar:',
        's1_msg_d' => 'Blue bar at the top means an <strong>important message from Administrator</strong> (updates, maintenance, etc.).',
        's1_stat' => '🚦 Status Bar:',
        's1_stat_d' => '<span style="color:#4CAF50; font-weight:bold;">GREEN</span> = System OK. <span style="color:#F44336; font-weight:bold;">RED</span> = Error (restart via Power tab).',
        's1_temp' => '🌡️ Temperature:',
        's1_temp_d' => 'Orange Pi Zero likes to be warm, but not too hot.',
        's1_temp_ok' => '✅ 35°C - 60°C: It\'s OK.',
        's1_temp_hot' => '🔥 > 75°C: Too hot! Give it some air.',
        's1_mon' => '📺 Big Monitor (Live):',
        's1_mon_d' => 'Here you see what is happening on air:',
        's1_mon_stby' => '⚪ <strong>Silence (Standby):</strong> No one is talking.',
        's1_mon_rx' => '🟢 <span style="color:#4CAF50; font-weight:bold;">RECEIVING (RX):</span> You are talking (Hotspot hears you).',
        's1_mon_tx' => '🟠 <span style="color:#FF9800; font-weight:bold;">TRANSMITTING (TX):</span> Someone is talking from internet.',
        
        's2_title' => '2. Two Worlds: Reflector & EchoLink',
        's2_text' => 'Remember: You can only be in one place at a time!',
        's2_a_title' => '🅰️ World A: Reflector',
        's2_a_desc' => 'This is your "home". You connect here automatically on startup.',
        's2_b_title' => '🅱️ World B: EchoLink (Global)',
        's2_b_desc' => 'Talk to the world (USA, Japan, etc.).',
        's2_b_step1' => '1. Click <strong>🚀 Activate Module (2#)</strong>.',
        's2_b_step2' => '2. Enter node number and click <strong>📞 Connect</strong>.',
        's2_warn' => '🛑 <strong>IMPORTANT - END CALL:</strong>',
        's2_disc' => 'To return to reflector, use <span style="color:#F44336; font-weight:bold;">Disconnect (#)</span> button. If still in EchoLink, press it again!',

        's3_title' => '3. DTMF Tab (Editor & Remote)',
        's3_text' => 'Total freedom! You can now customize your control buttons.',
        's3_tabs' => '<strong>📂 Custom Tabs:</strong> Create new groups (e.g. "Favorites"). Use "New Tab" input at the top.',
        's3_btns' => '<strong>🎛️ Adding Buttons:</strong> At the bottom of each tab is a form. Enter <strong>Name</strong> and <strong>TG Code</strong>, click "+" and it works instantly.',
        's3_del' => '<strong>❌ Deleting:</strong> You can remove any button or tab with the small "x". Changes are saved automatically.',
        's3_info' => '<strong>ℹ️ Status (*#):</strong> Makes the hotspot speak status info (Time, IP, Login).',
        's3_key' => '<strong>⌨️ Keypad:</strong> Standard numeric keypad for manual codes.',

        's4_title' => '4. Audio & WiFi',
        's4_warn' => '⚠️ <strong>Careful with Audio sliders!</strong> Bad config = no audio.',
        's4_mic' => '<strong>🎙️ MIC Boost / ADC Gain:</strong> Your voice volume sent to network.',
        's4_tx' => '<strong>🔊 TX Volume:</strong> Volume of others heard on your radio.',
        's4_wifi' => '<strong>📶 WiFi:</strong> Add new networks or delete old ones here.',

        's5_title' => '5. Power & Updates',
        's5_text' => 'Control center for system life.',
        's5_reb' => '<strong>🔄 Reboot / Shutdown:</strong> Safe shutdown.',
        's5_upd' => '<strong>☁️ Update System:</strong> Pulls latest fixes from GitHub and auto-repairs config.',
        's5_rst' => '<strong>♻️ Restart SvxLink Service:</strong> "Cure for everything". Fixes audio/freeze in 5-10s.',

        's6_title' => '6. Tips & New Features (Pro Version)',
        's6_text' => 'Useful features:',
        's6_api' => '<strong>🔗 Node API (New):</strong>',
        's6_api_d' => 'In <strong>Config</strong>, the <em>"Node API URL"</em> defines where the station list comes from.',
        's6_mute' => '<strong>🔇 Silence on Air:</strong>',
        's6_mute_d' => 'Disable <strong>Callsign Recitation</strong> in <strong>Config</strong> (Advanced) to stop verbal ID.',
        's6_hw' => '<strong>🛠️ Hardware & GPIO:</strong>',
        's6_hw_d' => 'Change UART ports and GPIO pins in <strong>Radio</strong> tab.',
        's6_card' => '<strong>🌍 Network Card:</strong>',
        's6_card_d' => 'Fill <em>"Location & Operator"</em> in <strong>Config</strong> to be visible on map.',
        's6_map' => '<strong>🗺️ Grid Mapper:</strong>',
        's6_map_d' => 'Map of active stations in <strong>Nodes</strong> tab.',
        's6_qrz' => '<strong>🖱️ Quick QRZ:</strong>',
        's6_qrz_d' => 'Click station callsign in Nodes list to open QRZ.com.',
        's6_lang' => '<strong>🌐 Language:</strong>',
        's6_lang_d' => 'Click flag icon to switch language.',

        'qa_title' => 'Quick Help (Q&A)',
        'qa_q1' => '❓ EchoLink not connecting.',
        'qa_a1' => '✅ LTE blocks ports. Use <strong>♻️ Auto-Proxy</strong> in <strong>Config</strong>.',
        'qa_q2' => '❓ "Last Heard" list is empty after reboot.',
        'qa_a2' => '✅ Normal behavior. For "Turbo" performance, logs are in RAM. History clears on reboot.',
        'qa_q3' => '❓ I hear others, they don\'t hear me.',
        'qa_a3' => '✅ Check CTCSS tones and Frequency in <strong>📻 Radio</strong> tab.',
        'qa_q4' => '❓ Logs show "Distortion detected".',
        'qa_a4' => '✅ Input too loud. Decrease <em>ADC Gain</em> in Audio tab.'
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

<div class="help-section">
    <div class="help-title"><span class="help-icon">📱</span> <?php echo $H[$lang]['s3_title']; ?></div>
    <div class="help-text">
        <?php echo $H[$lang]['s3_text']; ?>
        <ul>
            <li><?php echo $H[$lang]['s3_tabs']; ?></li>
            <li><?php echo $H[$lang]['s3_btns']; ?></li>
            <li><?php echo $H[$lang]['s3_del']; ?></li>
            <li style="margin-top:10px;"><?php echo $H[$lang]['s3_info']; ?></li>
            <li><?php echo $H[$lang]['s3_key']; ?></li>
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
        </ul>
    </div>
</div>

<div class="help-section">
    <div class="help-title" style="color: #BA68C8;"><span class="help-icon">💡</span> <?php echo $H[$lang]['s6_title']; ?></div>
    <div class="help-text">
        <?php echo $H[$lang]['s6_text']; ?>
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
            <li style="margin-bottom: 8px;"><?php echo $H[$lang]['s6_qrz']; ?>
                <br><?php echo $H[$lang]['s6_qrz_d']; ?>
            </li>
            <li><?php echo $H[$lang]['s6_lang']; ?>
                <br><?php echo $H[$lang]['s6_lang_d']; ?>
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
        <?php echo $H[$lang]['qa_a3']; ?><br><br>

        <strong><?php echo $H[$lang]['qa_q4']; ?></strong><br>
        <?php echo $H[$lang]['qa_a4']; ?>
    </div>
</div>