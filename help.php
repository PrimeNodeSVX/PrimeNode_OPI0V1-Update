<?php
$H = [
    'pl' => [
        'title' => 'Centrum Dowodzenia i Pomocy (SQLink Orange Pi Edition)',
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
        's2_a_title' => '🅰️ Świat A: Reflektor (SQLink)',
        's2_a_desc' => 'To jest Twój "dom". Jesteś tu zawsze po uruchomieniu.<br>Rozmawiasz z polskimi stacjami na grupach (np. Ogólnopolska).',
        's2_b_title' => '🅱️ Świat B: EchoLink (Światowy)',
        's2_b_desc' => 'Chcesz pogadać z kimś z USA, Japonii czy innego miasta?',
        's2_b_step1' => '1. Kliknij <strong>🚀 Aktywuj Moduł (2#)</strong> lub użyj przycisku w Configu.',
        's2_b_step2' => '2. Wpisz numer węzła i kliknij <strong>📞 Połącz</strong>.',
        's2_warn' => '🛑 <strong>WAŻNE - KONIEC ROZMOWY:</strong>',
        's2_disc' => 'Aby wrócić do sieci SQLink, musisz wyjść z EchoLinka przyciskiem <span style="color:#F44336; font-weight:bold;">Rozłącz (#)</span>.<br><span style="color:#FF9800;">👉 Jeśli nadal jesteś w EchoLinku, naciśnij <strong>Rozłącz</strong> jeszcze raz! Musisz usłyszeć komunikat "Deactivating module EchoLink".</span>',

        's3_title' => '3. Zakładka DTMF (Pilot)',
        's3_text' => 'Tutaj sterujesz hotspotem bez dotykania mikrofonu radia.',
        's3_tg' => '<strong>👥 Grupy Rozmowne:</strong> Kliknięcie kafelka (np. TG 260) natychmiast przełącza Cię na tę grupę.',
        's3_info' => '<strong>ℹ️ Tryb Info / Status (*#):</strong> Kliknij przycisk <strong>Status</strong> lub wklep kod <code style="background:#333; padding:2px 5px; border-radius:3px;">*#</code> na radiu. Hotspot przemówi do Ciebie i poda: aktualną godzinę, swój adres IP oraz status logowania.',
        's3_parrot' => '<strong>🦜 Papuga (Test Audio):</strong> Narzędzie do sprawdzania, jak Cię słychać.',
        's3_key' => '<strong>⌨️ Klawiatura:</strong> Pozwala wpisać dowolny kod DTMF (np. ukryte funkcje SVXLink).',

        's4_title' => '4. Audio i WiFi',
        's4_warn' => '⚠️ <strong>Ostrożnie z suwakami Audio!</strong> Zła konfiguracja może sprawić, że przestaniesz być słyszany.',
        's4_mic' => '<strong>🎙️ Suwak MIC Boost / ADC Gain:</strong> Reguluje głośność Twojego głosu w sieci.',
        's4_tx' => '<strong>🔊 Suwak TX Volume:</strong> Reguluje jak głośno słyszysz rozmówców w swoim radiu.',
        's4_wifi' => '<strong>📶 WiFi:</strong> Możesz tu dodać nową sieć (np. z telefonu) lub usunąć stare, nieużywane sieci.',

        's5_title' => '5. Zasilanie i Aktualizacje',
        's5_text' => 'W zakładce <strong>Zasilanie</strong> masz centrum sterowania życiem systemu.',
        's5_reb' => '<strong>🔄 Reboot / Wyłącz:</strong> Bezpieczne zamykanie systemu. Nie wyrywaj wtyczki z prądu, bo karta pamięci tego nie lubi!',
        's5_upd' => '<strong>☁️ Aktualizuj System:</strong> Kliknij zielony przycisk, żeby pobrać nowości. Hotspot sam połączy się z GitHubem i ściągnie poprawki.',
        's5_rst' => '<strong>♻️ Restart Usługi SvxLink:</strong> "Lekarstwo na wszystko". Jeśli dashboard się zawiesi albo dźwięk zniknie - kliknij to. Trwa to tylko 5-10 sekund.',

        's6_title' => '6. Wskazówki i Nowe Funkcje (Warto wiedzieć)',
        's6_text' => 'Oto kilka przydatnych funkcji, które ułatwią Ci życie z Hotspotem:',
        's6_lang' => '<strong>🌐 Zmiana Języka (PL/EN):</strong>',
        's6_lang_d' => 'Kliknij flagę w prawym górnym rogu, aby zmienić język napisów. Głos lektora (gadaczka) zmienisz w zakładce <strong>Config</strong> (Zaawansowane).',
        's6_mute' => '<strong>🔇 Cisza w Eterze (Recytacja Znaku):</strong>',
        's6_mute_d' => 'Denerwuje Cię ciągłe "Stefan Paweł..."? W zakładce <strong>Config</strong> (sekcja Zaawansowane) możesz wyłączyć opcję <strong>Recytowanie Znaku</strong>. Hotspot przestanie się przedstawiać głosowo (identyfikacja telegrafią CW pozostaje aktywna).',
        's6_hw' => '<strong>🛠️ Sprzęt i GPIO (Dla Konstruktorów):</strong>',
        's6_hw_d' => 'Budujesz własny interfejs lub zmieniasz płytkę? W zakładce <strong>Radio</strong> (na dole) możesz zmienić port <strong>UART (SA818)</strong> oraz piny <strong>GPIO PTT i SQL</strong> bez edycji plików systemowych.',
        's6_card' => '<strong>🌍 Twoja Wizytówka w Sieci:</strong>',
        's6_card_d' => 'W zakładce <strong>Config</strong> uzupełnij nową sekcję <em>"Lokalizacja i Operator"</em>. Dzięki temu Twoje Imię i Miasto będą widoczne dla innych kolegów w sieci (w dymkach informacyjnych i na mapie).',
        's6_map' => '<strong>🗺️ Grid Mapper (Mapa Sieci):</strong>',
        's6_map_d' => 'W zakładce <strong>Nodes</strong> znajdziesz przycisk otwierający mapę aktywnych stacji. Możesz zmienić jej wygląd (Ciemna / Jasna / Kolorowa) w zakładce <strong>Config</strong>.',
        's6_qrz' => '<strong>🖱️ Szybki Podgląd QRZ:</strong>',
        's6_qrz_d' => 'W zakładce <strong>Nodes</strong> (Węzły) kafelki stacji są interaktywne. <strong>Kliknij w znak stacji</strong>, aby natychmiast otworzyć jej profil na QRZ.com w nowym oknie.',
        's6_mod' => '<strong>🎛️ Wygodne Moduły:</strong>',
        's6_mod_d' => 'W Konfiguracji nie musisz już wpisywać nazw modułów ręcznie. Użyj przycisków, aby włączać/wyłączać funkcje (Help, Parrot, EchoLink).<br><span style="color:#4CAF50; font-weight:bold;">Zielony</span> = Włączony, <span style="color:#666; font-weight:bold;">Szary</span> = Wyłączony.',

        'qa_title' => 'Szybka Pomoc (Q&A)',
        'qa_q1' => '❓ Nie mogę połączyć się z EchoLinkiem (Status: Disconnected).',
        'qa_a1' => '✅ Jeśli używasz internetu mobilnego (GSM), operatorzy często blokują porty. Wejdź w zakładkę <strong>Config</strong> i kliknij zielony przycisk <strong>♻️ Auto-Proxy</strong>. System automatycznie znajdzie działający serwer proxy.',
        'qa_q2' => '❓ Hotspot przestał gadać / Dashboard "wisi".',
        'qa_a2' => '✅ Wejdź w zakładkę <strong>⚡ Zasilanie</strong> i kliknij niebieski przycisk <strong>Restart Usługi SvxLink</strong>.',
        'qa_q3' => '❓ Słyszę komunikaty, ale nikt mnie nie słyszy.',
        'qa_a3' => '✅ Sprawdź częstotliwość radia i ton CTCSS w zakładce <strong>📻 Radio</strong>. Upewnij się też, że w radiu ręcznym masz ustawiony ten sam ton nadawania.',
        'qa_q4' => '❓ W logach widzę "Distortion detected".',
        'qa_a4' => '✅ Twoje radio nadaje zbyt głośno do hotspota (przester). Ścisz radio (jeśli podłączone kablem) lub zmniejsz <em>ADC Gain</em> w zakładce Audio.'
    ],
    'en' => [
        'title' => 'Command & Help Center (SQLink Orange Pi Edition)',
        'subtitle' => 'System designed for:',
        'hw_desc' => '<strong style="color: #FF9800;">Orange Pi Zero</strong> + <strong style="color: #2196F3;">SA818 Module</strong>',
        's1_title' => '1. Your Dashboard',
        's1_text' => 'This is where you check the pulse of your device. Everything should be green!',
        's1_msg' => '📢 Message Bar:',
        's1_msg_d' => 'If you see a blue bar with text at the very top, it is an <strong>important message from the Administrator</strong> (e.g., about updates, network failure, or maintenance).',
        's1_stat' => '🚦 Status Bar:',
        's1_stat_d' => 'The colorful bar below the header. If it is <span style="color:#4CAF50; font-weight:bold;">GREEN</span>, the system works. If <span style="color:#F44336; font-weight:bold;">RED</span>, something is broken (try restarting in the Power tab).',
        's1_temp' => '🌡️ Temperature:',
        's1_temp_d' => 'Orange Pi Zero likes to be warm, but not too hot.',
        's1_temp_ok' => '✅ 35°C - 60°C: It\'s OK.',
        's1_temp_hot' => '🔥 > 75°C: Too hot! Give it some air.',
        's1_mon' => '📺 Big Monitor (Live):',
        's1_mon_d' => 'Here you see what is happening on air:',
        's1_mon_stby' => '⚪ <strong>Silence (Standby):</strong> No one is talking, boring.',
        's1_mon_rx' => '🟢 <span style="color:#4CAF50; font-weight:bold;">RECEIVING (RX):</span> You are talking to the radio (Hotspot hears you).',
        's1_mon_tx' => '🟠 <span style="color:#FF9800; font-weight:bold;">TRANSMITTING (TX):</span> Someone is talking from the internet (You hear it on the radio).',
        
        's2_title' => '2. Two Worlds: Reflector & EchoLink',
        's2_text' => 'Remember: You can only be in one place at a time!',
        's2_a_title' => '🅰️ World A: Reflector (SQLink)',
        's2_a_desc' => 'This is your "home". You are always here after startup.<br>You talk to stations on Talkgroups.',
        's2_b_title' => '🅱️ World B: EchoLink (Global)',
        's2_b_desc' => 'Want to talk to someone from USA, Japan, or another city?',
        's2_b_step1' => '1. Click <strong>🚀 Activate Module (2#)</strong> or use the button in Config.',
        's2_b_step2' => '2. Select a node number and click <strong>📞 Connect</strong>.',
        's2_warn' => '🛑 <strong>VERY IMPORTANT - END CALL:</strong>',
        's2_disc' => 'To return to SQLink network, you must exit EchoLink using <span style="color:#F44336; font-weight:bold;">Disconnect (#)</span>.<br><span style="color:#FF9800;">👉 If you are still in EchoLink, press <strong>Disconnect</strong> again! You must hear "Deactivating module EchoLink".</span>',

        's3_title' => '3. DTMF Tab (Remote)',
        's3_text' => 'Control the hotspot without touching the radio microphone.',
        's3_tg' => '<strong>👥 Talkgroups:</strong> Clicking a tile (e.g., TG 260) instantly switches you to that group.',
        's3_info' => '<strong>ℹ️ Info / Status Mode (*#):</strong> Click <strong>Status</strong> or type <code style="background:#333; padding:2px 5px; border-radius:3px;">*#</code> on radio. Hotspot will speak to you: time, IP address, and login status.',
        's3_parrot' => '<strong>🦜 Parrot (Audio Test):</strong> Tool to check how you sound.',
        's3_key' => '<strong>⌨️ Keypad:</strong> Allows typing any DTMF code (e.g., hidden SVXLink functions).',

        's4_title' => '4. Audio & WiFi',
        's4_warn' => '⚠️ <strong>Careful with Audio sliders!</strong> Bad configuration can make you unheard.',
        's4_mic' => '<strong>🎙️ MIC Boost / ADC Gain Slider:</strong> Regulates your voice level sent to the world.',
        's4_tx' => '<strong>🔊 TX Volume Slider:</strong> Regulates how loud you hear others on your radio.',
        's4_wifi' => '<strong>📶 WiFi:</strong> You can add a new network (e.g. from phone) or delete old unused ones.',

        's5_title' => '5. Power & Updates',
        's5_text' => 'In the <strong>Power</strong> tab, you control the life of your system.',
        's5_reb' => '<strong>🔄 Reboot / Shutdown:</strong> Safe system shutdown. Do not pull the plug, SD card hates it!',
        's5_upd' => '<strong>☁️ Update System:</strong> Click the green button to get new features. Hotspot pulls fixes from GitHub.',
        's5_rst' => '<strong>♻️ Restart SvxLink Service:</strong> "Cure for everything". If dashboard freezes or sound is lost - click this. Takes 5-10 seconds.',

        's6_title' => '6. Tips & New Features (Good to know)',
        's6_text' => 'Here are some useful features to make your life easier:',
        's6_lang' => '<strong>🌐 Language Switch (PL/EN):</strong>',
        's6_lang_d' => 'Click the flag in the top right corner to change text language. Voice announcements (speech) are changed in the <strong>Config</strong> tab (Advanced).',
        's6_mute' => '<strong>🔇 Silence on Air (Callsign Recitation):</strong>',
        's6_mute_d' => 'Annoyed by constant "Steven Paul..."? In <strong>Config</strong> (Advanced section) you can disable <strong>Callsign Recitation</strong>. Hotspot stops introducing itself verbally (CW ID remains active).',
        's6_hw' => '<strong>🛠️ Hardware & GPIO (For Builders):</strong>',
        's6_hw_d' => 'Building a custom interface? In <strong>Radio</strong> tab (bottom) you can now change <strong>UART (SA818)</strong> port and <strong>GPIO PTT & SQL</strong> pins directly from the panel.',
        's6_card' => '<strong>🌍 Your Network Card:</strong>',
        's6_card_d' => 'In <strong>Config</strong> fill in the new section <em>"Location & Operator"</em>. Your Name and City will be visible to other colleagues on the network (in info bubbles and map).',
        's6_map' => '<strong>🗺️ Grid Mapper (Network Map):</strong>',
        's6_map_d' => 'In <strong>Nodes</strong> tab find the button opening the map of active stations. You can change its look (Dark / Light / Color) in <strong>Config</strong>.',
        's6_qrz' => '<strong>🖱️ Quick QRZ Preview:</strong>',
        's6_qrz_d' => 'In <strong>Nodes</strong> tab, station tiles are interactive. <strong>Click the callsign</strong> to instantly open its QRZ.com profile in a new window.',
        's6_mod' => '<strong>🎛️ Easy Modules:</strong>',
        's6_mod_d' => 'In Config you don\'t have to type module names manually. Use buttons to toggle functions (Help, Parrot, EchoLink).<br><span style="color:#4CAF50; font-weight:bold;">Green</span> = ON, <span style="color:#666; font-weight:bold;">Gray</span> = OFF.',

        'qa_title' => 'Quick Help (Q&A)',
        'qa_q1' => '❓ EchoLink not connecting (Status: Disconnected).',
        'qa_a1' => '✅ Using mobile internet (LTE)? Carriers often block ports. Go to <strong>Config</strong> tab and click green button <strong>♻️ Auto-Proxy</strong>. It is a "magic button" that bypasses blocks.',
        'qa_q2' => '❓ Hotspot stopped talking / Dashboard frozen.',
        'qa_a2' => '✅ Go to <strong>⚡ Power</strong> tab and click blue button <strong>Restart SvxLink Service</strong>.',
        'qa_q3' => '❓ Radio is silent, but screen shows RX.',
        'qa_a3' => '✅ Check your handheld radio <strong>CTCSS / Tone Squelch</strong> codes. They must match Hotspot settings (Radio tab). Best to ensure radio uses the same TX tone.',
        'qa_q4' => '❓ Logs show "Distortion detected".',
        'qa_a4' => '✅ Your radio is shouting too loud to the hotspot. Turn down volume (if using cable) or decrease <em>ADC Gain</em> in Audio tab.'
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
            <li><?php echo $H[$lang]['s3_tg']; ?></li>
            <li><?php echo $H[$lang]['s3_info']; ?></li>
            <li><?php echo $H[$lang]['s3_parrot']; ?></li>
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
            <li style="margin-bottom: 8px;"><?php echo $H[$lang]['s6_lang']; ?>
                <br><?php echo $H[$lang]['s6_lang_d']; ?>
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
            <li><?php echo $H[$lang]['s6_mod']; ?>
                <br><?php echo $H[$lang]['s6_mod_d']; ?>
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
