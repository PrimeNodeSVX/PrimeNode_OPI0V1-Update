<?php
$TR = [
    'pl' => [
        'cfg_title' => '⚙️ Konfiguracja Modułu Radiowego',
        'cfg_desc' => 'Wprowadź częstotliwość pracy hotspota. <br>Zatwierdzenie spowoduje chwilowy restart usługi.',
        'lbl_desc' => 'Opis Sprzętu (Wizualne)',
        'ph_desc' => 'np. OrangePi + SA818',
        'lbl_freq' => 'Częstotliwość Pracy (MHz)',
        'lbl_ctcss' => 'Ton CTCSS',
        'lbl_sq' => 'Squelch (1-8)',
        'hw_title' => '⚙️ Sprzęt i GPIO (Hardware)',
        'lbl_uart' => 'Port UART (SA818)',
        'hlp_uart' => 'Ścieżka do portu szeregowego (np. /dev/ttyS1)',
        'lbl_ptt' => 'GPIO PTT (TX)',
        'hlp_ptt' => 'Pin BCM PTT',
        'lbl_sql' => 'GPIO SQL (RX)',
        'hlp_sql' => 'Pin BCM COS/SQL',
        'btn_save' => '💾 Zaprogramuj Radio i Zapisz GPIO',
        'info_title' => '⚠️ Ważne Informacje SA818',
        'info_freq' => '📶 <b>Częstotliwość:</b><br>Moduł pracuje w trybie Simplex. Wpisana częstotliwość jest ustawiana automatycznie zarówno dla Nadawania (TX), jak i Odbioru (RX).',
        'info_ctcss' => '🔒 <b>Co to jest CTCSS?</b><br>To system "Prywatnego Kanału". Działa jak elektroniczny klucz. Jeśli go ustawisz, Twój hotspot nie będzie odbierał przypadkowych zakłóceń z eteru, a jedynie Twoje radio (które musi mieć ustawiony ten sam ton).',
        'info_note' => '⚡ <b>Uwaga:</b><br>Squelch zalecamy ustawić na poziom <b>2-4</b>. Poziom 1 może być zbyt czuły w pobliżu elektroniki komputera.',
        'csq' => 'Brak (CSQ)'
    ],
    'en' => [
        'cfg_title' => '⚙️ Radio Module Configuration',
        'cfg_desc' => 'Enter hotspot operating frequency. <br>Saving will cause a temporary service restart.',
        'lbl_desc' => 'Hardware Description (Visual)',
        'ph_desc' => 'e.g. OrangePi + SA818',
        'lbl_freq' => 'Operating Frequency (MHz)',
        'lbl_ctcss' => 'CTCSS Tone',
        'lbl_sq' => 'Squelch (1-8)',
        'hw_title' => '⚙️ Hardware & GPIO',
        'lbl_uart' => 'UART Port (SA818)',
        'hlp_uart' => 'Serial port path (e.g. /dev/ttyS1)',
        'lbl_ptt' => 'GPIO PTT (TX)',
        'hlp_ptt' => 'BCM PTT Pin',
        'lbl_sql' => 'GPIO SQL (RX)',
        'hlp_sql' => 'BCM COS/SQL Pin',
        'btn_save' => '💾 Program Radio & Save GPIO',
        'info_title' => '⚠️ Important SA818 Info',
        'info_freq' => '📶 <b>Frequency:</b><br>Module works in Simplex mode. Frequency is set automatically for both Transmit (TX) and Receive (RX).',
        'info_ctcss' => '🔒 <b>What is CTCSS?</b><br>It is a "Private Channel" system acting like a key. If set, hotspot ignores random noise, listening only to your radio (which must share the tone).',
        'info_note' => '⚡ <b>Note:</b><br>We recommend Squelch level <b>2-4</b>. Level 1 might be too sensitive near computer electronics.',
        'csq' => 'None (CSQ)'
    ]
];

$CTCSS_MAP = [
    "0000" => $TR[$lang]['csq'], "0670" => "67.0 Hz", "0719" => "71.9 Hz", "0744" => "74.4 Hz", "0770" => "77.0 Hz",
    "0797" => "79.7 Hz", "0825" => "82.5 Hz", "0854" => "85.4 Hz", "0885" => "88.5 Hz", "0915" => "91.5 Hz",
    "0948" => "94.8 Hz", "0974" => "97.4 Hz", "1000" => "100.0 Hz", "1035" => "103.5 Hz", "1072" => "107.2 Hz",
    "1109" => "110.9 Hz", "1148" => "114.8 Hz", "1188" => "118.8 Hz", "1230" => "123.0 Hz", "1273" => "127.3 Hz",
    "1318" => "131.8 Hz", "1365" => "136.5 Hz", "1413" => "141.3 Hz", "1462" => "146.2 Hz", "1514" => "151.4 Hz",
    "1567" => "156.7 Hz", "1622" => "162.2 Hz", "1679" => "167.9 Hz", "1738" => "173.8 Hz", "1799" => "179.9 Hz",
    "1862" => "186.2 Hz", "1928" => "192.8 Hz", "2035" => "203.5 Hz", "2107" => "210.7 Hz", "2181" => "218.1 Hz",
    "2257" => "225.7 Hz", "2336" => "233.6 Hz", "2418" => "241.8 Hz", "2503" => "250.3 Hz"
];
?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    <div class="panel-box" style="border-top: 3px solid #2196F3;">
        <h4 class="panel-title blue"><?php echo $TR[$lang]['cfg_title']; ?></h4>
        <div style="font-size: 12px; color: #aaa; margin-bottom: 15px; font-style: italic;">
            <?php echo $TR[$lang]['cfg_desc']; ?>
        </div>
        
        <form method="post">
            <input type="hidden" name="active_tab" class="active-tab-input" value="Radio">
            
            <div class="form-group">
                <label><?php echo $TR[$lang]['lbl_desc']; ?></label>
                <input type="text" name="radio_desc" value="<?php echo isset($radio['desc']) ? htmlspecialchars($radio['desc']) : ''; ?>" placeholder="<?php echo $TR[$lang]['ph_desc']; ?>">
            </div>

            <div class="form-group">
                <label><?php echo $TR[$lang]['lbl_freq']; ?></label>
                <input type="text" name="single_freq" value="<?php echo htmlspecialchars($radio['rx']); ?>" style="font-size: 18px; font-weight: bold; color: #4CAF50;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div class="form-group">
                    <label><?php echo $TR[$lang]['lbl_ctcss']; ?></label>
                    <select name="ctcss">
                        <?php
                            foreach($CTCSS_MAP as $code => $label) {
                                $sel = ($radio['ctcss'] == $code) ? 'selected' : '';
                                echo "<option value='$code' $sel>$label</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo $TR[$lang]['lbl_sq']; ?></label>
                    <select name="sq">
                        <?php foreach([1,2,3,4,5,6,7,8] as $s) {
                            $sel = ($radio['sq'] == $s) ? 'selected' : '';
                            echo "<option value='$s' $sel>$s</option>";
                        } ?>
                    </select>
                </div>
            </div>

            <hr style="border:0; border-top:1px solid #444; margin: 20px 0;">
            <h4 class="panel-title blue" style="font-size:14px; margin-bottom:15px;"><?php echo $TR[$lang]['hw_title']; ?></h4>

            <div class="form-group">
                <label><?php echo $TR[$lang]['lbl_uart']; ?></label>
                <input type="text" name="SerialPort" value="<?php echo isset($radio['serial_port']) ? $radio['serial_port'] : '/dev/ttyS2'; ?>" placeholder="/dev/ttyS2">
                <small style="color:#888; font-size:9px;"><?php echo $TR[$lang]['hlp_uart']; ?></small>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div class="form-group">
                    <label><?php echo $TR[$lang]['lbl_ptt']; ?></label>
                    <input type="number" name="GpioPtt" value="<?php echo isset($radio['gpio_ptt']) ? $radio['gpio_ptt'] : '7'; ?>">
                    <small style="color:#888; font-size:9px;"><?php echo $TR[$lang]['hlp_ptt']; ?></small>
                </div>
                <div class="form-group">
                    <label><?php echo $TR[$lang]['lbl_sql']; ?></label>
                    <input type="number" name="GpioSql" value="<?php echo isset($radio['gpio_sql']) ? $radio['gpio_sql'] : '10'; ?>">
                    <small style="color:#888; font-size:9px;"><?php echo $TR[$lang]['hlp_sql']; ?></small>
                </div>
            </div>

            <button type="submit" name="save_radio" class="btn btn-green" style="margin-top:15px;"><?php echo $TR[$lang]['btn_save']; ?></button>
        </form>
    </div>

    <div>
        <div class="panel-box" style="border-left: 5px solid #FF9800; background: #26201b;">
            <h4 class="panel-title" style="color: #FF9800; border: none;"><?php echo $TR[$lang]['info_title']; ?></h4>
            <div style="font-size: 13px; color: #ddd; line-height: 1.6;">
                <ul style="list-style: none; padding: 0; margin-top: 10px;">
                    <li style="margin-bottom: 12px;">
                        <?php echo $TR[$lang]['info_freq']; ?>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <?php echo $TR[$lang]['info_ctcss']; ?>
                    </li>
                    <li>
                        <?php echo $TR[$lang]['info_note']; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
