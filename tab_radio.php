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
        'hlp_uart' => 'Ścieżka do portu szeregowego (np. /dev/ttyS2)',
        'lbl_ptt' => 'GPIO PTT (TX)',
        'hlp_ptt' => 'Pin BCM PTT',
        'lbl_sql' => 'GPIO SQL (RX)',
        'hlp_sql' => 'Pin BCM COS/SQL',
        'btn_save' => '💾 Zaprogramuj Radio i Zapisz GPIO',
        'info_title' => '⚠️ Ważne Informacje Systemowe',
        'info_freq' => '📶 <b>Częstotliwość:</b><br>Moduł pracuje w trybie Simplex. Wpisana częstotliwość jest ustawiana automatycznie zarówno dla Nadawania (TX), jak i Odbioru (RX).',
        'info_ctcss' => '🔒 <b>Co to jest CTCSS?</b><br>To system "Prywatnego Kanału". Działa jak elektroniczny klucz. Jeśli go ustawisz, Twój hotspot nie będzie odbierał przypadkowych zakłóceń z eteru, a jedynie Twoje radio (które musi mieć ustawiony ten sam ton).',
        'info_svx_filters' => '🎛️ <b>Filtry SvxLink (Programowe):</b><br><b>Deemphasis (RX):</b> Wyrównuje pasmo odbieranego sygnału. <b>Preemphasis (TX):</b> Podbija wyższe tony przed nadaniem.<br><i style="color:#888;">Zalecenie: Używaj ich zamiennie z filtrami SA818 (albo tu, albo tam).</i>',
        'info_sa_bw' => '📻 <b>Dewiacja (Bandwidth):</b><br><b>WIDE (1)</b> = 25 kHz.<br><b>NARROW (0)</b> = 12.5 kHz.',
        'info_sa_filters' => '🔊 <b>Filtry SA818 (Sprzętowe):</b><br>Wbudowane w moduł radiowy. <b>High/Low Pass Filter</b> świetnie odcinają skrajne zakłócenia (np. buczenie z zasilania 50Hz).',
        'info_note' => '⚡ <b>Uwaga o SQL:</b><br>Squelch zalecamy ustawić na poziom <b>2-4</b>. Poziom 1 może być zbyt czuły w pobliżu elektroniki komputera.',
        'csq' => 'Brak (CSQ)',
        
        'audio_filters_title' => '🎛️ Filtry Audio (SvxLink)',
        'lbl_deemph' => '[Rx1] DEEMPHASIS',
        'lbl_preemph' => '[Tx1] PREEMPHASIS',
        'opt_0_off' => '0 - Wyłączony',
        'opt_1_on' => '1 - Włączony',

        'sa818_title' => '📡 Sprzętowe Parametry SA818',
        'lbl_bandwidth' => 'Dewiacja (Bandwidth)',
        'opt_wide' => '1 - WIDE (Szeroki FM)',
        'opt_narrow' => '0 - NARROW (Wąski FM)',
        'lbl_sa_vol' => 'Głośność SA818 (Volume)',
        'lbl_prede' => 'Pre/De-Emphasis',
        'opt_off' => '0 - Wył',
        'opt_on' => '1 - Wł',
        'lbl_hpf' => 'High Pass Filter',
        'lbl_lpf' => 'Low Pass Filter'
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
        'info_title' => '⚠️ Important System Info',
        'info_freq' => '📶 <b>Frequency:</b><br>Module works in Simplex mode. Frequency is set automatically for both Transmit (TX) and Receive (RX).',
        'info_ctcss' => '🔒 <b>What is CTCSS?</b><br>It is a "Private Channel" system acting like a key. If set, hotspot ignores random noise, listening only to your radio (which must share the tone).',
        'info_svx_filters' => '🎛️ <b>SvxLink Filters (Software):</b><br><b>Deemphasis (RX):</b> Flattens the received acoustic band. <b>Preemphasis (TX):</b> Boosts higher tones before transmitting.<br><i style="color:#888;">Tip: If enabled here, disable them in SA818.</i>',
        'info_sa_bw' => '📻 <b>Bandwidth:</b><br><b>WIDE (1)</b> = 25 kHz.<br><b>NARROW (0)</b> = 12.5 kHz.',
        'info_sa_filters' => '🔊 <b>SA818 Filters (Hardware):</b><br>Built-in module audio filters. <b>High/Low Pass Filters</b> are great for cutting off extreme noise (e.g., 50Hz power hum).',
        'info_note' => '⚡ <b>SQL Note:</b><br>We recommend Squelch level <b>2-4</b>. Level 1 might be too sensitive near computer electronics.',
        'csq' => 'None (CSQ)',
        
        'audio_filters_title' => '🎛️ Audio Filters (SvxLink)',
        'lbl_deemph' => '[Rx1] DEEMPHASIS',
        'lbl_preemph' => '[Tx1] PREEMPHASIS',
        'opt_0_off' => '0 - Disabled',
        'opt_1_on' => '1 - Enabled',

        'sa818_title' => '📡 SA818 Hardware Params',
        'lbl_bandwidth' => 'Bandwidth (Deviation)',
        'opt_wide' => '1 - WIDE (Wide FM)',
        'opt_narrow' => '0 - NARROW (Narrow FM)',
        'lbl_sa_vol' => 'SA818 Volume',
        'lbl_prede' => 'Pre/De-Emphasis',
        'opt_off' => '0 - Off',
        'opt_on' => '1 - On',
        'lbl_hpf' => 'High Pass Filter',
        'lbl_lpf' => 'Low Pass Filter'
    ]
];

$CTCSS_MAP = [
    "0000" => $TR[$lang]['csq'], "0670" => "67.0 Hz", "0693" => "69.3 Hz", "0719" => "71.9 Hz", "0744" => "74.4 Hz", 
    "0770" => "77.0 Hz", "0797" => "79.7 Hz", "0825" => "82.5 Hz", "0854" => "85.4 Hz", "0885" => "88.5 Hz", 
    "0915" => "91.5 Hz", "0948" => "94.8 Hz", "0974" => "97.4 Hz", "1000" => "100.0 Hz", "1035" => "103.5 Hz", 
    "1072" => "107.2 Hz", "1109" => "110.9 Hz", "1148" => "114.8 Hz", "1188" => "118.8 Hz", "1230" => "123.0 Hz", 
    "1273" => "127.3 Hz", "1318" => "131.8 Hz", "1365" => "136.5 Hz", "1413" => "141.3 Hz", "1462" => "146.2 Hz", 
    "1514" => "151.4 Hz", "1567" => "156.7 Hz", "1598" => "159.8 Hz", "1622" => "162.2 Hz", "1655" => "165.5 Hz", 
    "1679" => "167.9 Hz", "1713" => "171.3 Hz", "1738" => "173.8 Hz", "1773" => "177.3 Hz", "1799" => "179.9 Hz", 
    "1835" => "183.5 Hz", "1862" => "186.2 Hz", "1899" => "189.9 Hz", "1928" => "192.8 Hz", "1966" => "196.6 Hz", 
    "1995" => "199.5 Hz", "2035" => "203.5 Hz", "2065" => "206.5 Hz", "2107" => "210.7 Hz", "2181" => "218.1 Hz",
    "2257" => "225.7 Hz", "2291" => "229.1 Hz", "2336" => "233.6 Hz", "2418" => "241.8 Hz", "2503" => "250.3 Hz", 
    "2541" => "254.1 Hz"
];

if (!function_exists('normalizeCtcss')) {
    function normalizeCtcss($ctcss) {
        if ($ctcss === null || $ctcss === '' || $ctcss == '0' || $ctcss == '0000') return '0000';
        $str = (string)$ctcss;
        if (strlen($str) === 4 && is_numeric($str) && strpos($str, '.') === false) return $str;
        $floatVal = (float)$ctcss;
        if ($floatVal > 0) {
            return str_pad(round($floatVal * 10), 4, "0", STR_PAD_LEFT);
        }
        return '0000';
    }
}
$current_ctcss = normalizeCtcss($radio['ctcss'] ?? '0000');
?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    <div class="panel-box" style="border-top: 3px solid #2196F3;">
        <h4 class="panel-title blue" style="border-bottom: 1px solid #444; padding-bottom: 5px; margin-bottom: 15px;"><?php echo $TR[$lang]['cfg_title']; ?></h4>
        <div style="font-size: 12px; color: #aaa; margin-bottom: 15px; font-style: italic;">
            <?php echo $TR[$lang]['cfg_desc']; ?>
        </div>
        
        <form method="post">
            <input type="hidden" name="active_tab" class="active-tab-input" value="Radio">
            
            <div class="form-group">
                <label><?php echo $TR[$lang]['lbl_desc']; ?></label>
                <input type="text" name="radio_desc" value="<?php echo isset($radio['desc']) && !empty($radio['desc']) ? htmlspecialchars($radio['desc']) : ''; ?>" placeholder="<?php echo $TR[$lang]['ph_desc']; ?>">
            </div>

            <div class="form-group">
                <label><?php echo $TR[$lang]['lbl_freq']; ?></label>
                <input type="text" name="single_freq" value="<?php echo htmlspecialchars($radio['rx'] ?? '432.800'); ?>" style="font-size: 18px; font-weight: bold; color: #2196F3;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div class="form-group">
                    <label><?php echo $TR[$lang]['lbl_ctcss']; ?></label>
                    <select name="ctcss">
                        <?php
                            foreach($CTCSS_MAP as $code => $label) {
                                $sel = ($current_ctcss == $code) ? 'selected' : '';
                                echo "<option value='$code' $sel>$label</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo $TR[$lang]['lbl_sq']; ?></label>
                    <select name="sq">
                        <?php foreach([1,2,3,4,5,6,7,8] as $s) {
                            $sel = (($radio['sq'] ?? '4') == $s) ? 'selected' : '';
                            echo "<option value='$s' $sel>$s</option>";
                        } ?>
                    </select>
                </div>
            </div>

            <hr style="border:0; border-top:1px solid #444; margin: 20px 0;">
            <h4 class="panel-title blue" style="font-size:14px; margin-bottom:15px; border-bottom: 1px solid #444; padding-bottom: 5px;"><?php echo $TR[$lang]['audio_filters_title']; ?></h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                <div class="form-group">
                    <label><?php echo $TR[$lang]['lbl_deemph']; ?></label>
                    <select name="svx_deemph">
                        <option value="0" <?php if(!isset($radio['svx_deemph']) || $radio['svx_deemph'] == '0') echo 'selected'; ?>><?php echo $TR[$lang]['opt_0_off']; ?></option>
                        <option value="1" <?php if(isset($radio['svx_deemph']) && $radio['svx_deemph'] == '1') echo 'selected'; ?>><?php echo $TR[$lang]['opt_1_on']; ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo $TR[$lang]['lbl_preemph']; ?></label>
                    <select name="svx_preemph">
                        <option value="0" <?php if(!isset($radio['svx_preemph']) || $radio['svx_preemph'] == '0') echo 'selected'; ?>><?php echo $TR[$lang]['opt_0_off']; ?></option>
                        <option value="1" <?php if(isset($radio['svx_preemph']) && $radio['svx_preemph'] == '1') echo 'selected'; ?>><?php echo $TR[$lang]['opt_1_on']; ?></option>
                    </select>
                </div>
            </div>

            <div style="background: rgba(76, 175, 80, 0.1); padding: 10px; border-radius: 5px; margin-top: 15px;">
                <h4 class="panel-title" style="color: #4CAF50; font-size: 14px; border:none; margin-bottom: 5px; padding-bottom: 0;"><?php echo $TR[$lang]['sa818_title']; ?></h4>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="form-group">
                        <label><?php echo $TR[$lang]['lbl_bandwidth']; ?></label>
                        <select name="sa_bw">
                            <option value="1" <?php if(!isset($radio['sa_bw']) || $radio['sa_bw'] == '1') echo 'selected'; ?>><?php echo $TR[$lang]['opt_wide']; ?></option>
                            <option value="0" <?php if(isset($radio['sa_bw']) && $radio['sa_bw'] == '0') echo 'selected'; ?>><?php echo $TR[$lang]['opt_narrow']; ?></option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label><?php echo $TR[$lang]['lbl_sa_vol']; ?></label>
                        <select name="sa_vol">
                            <?php for($i=1; $i<=8; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php if(isset($radio['sa_vol']) && $radio['sa_vol'] == $i) echo 'selected'; elseif(!isset($radio['sa_vol']) && $i==8) echo 'selected'; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <hr style="border:0; border-top:1px dashed #4CAF50; margin: 10px 0;">

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                    <div class="form-group">
                        <label><?php echo $TR[$lang]['lbl_prede']; ?></label>
                        <select name="sa_prede">
                            <option value="0" <?php if(!isset($radio['sa_prede']) || $radio['sa_prede'] == '0') echo 'selected'; ?>><?php echo $TR[$lang]['opt_off']; ?></option>
                            <option value="1" <?php if(isset($radio['sa_prede']) && $radio['sa_prede'] == '1') echo 'selected'; ?>><?php echo $TR[$lang]['opt_on']; ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo $TR[$lang]['lbl_hpf']; ?></label>
                        <select name="sa_hpf">
                            <option value="0" <?php if(!isset($radio['sa_hpf']) || $radio['sa_hpf'] == '0') echo 'selected'; ?>><?php echo $TR[$lang]['opt_off']; ?></option>
                            <option value="1" <?php if(isset($radio['sa_hpf']) && $radio['sa_hpf'] == '1') echo 'selected'; ?>><?php echo $TR[$lang]['opt_on']; ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo $TR[$lang]['lbl_lpf']; ?></label>
                        <select name="sa_lpf">
                            <option value="0" <?php if(!isset($radio['sa_lpf']) || $radio['sa_lpf'] == '0') echo 'selected'; ?>><?php echo $TR[$lang]['opt_off']; ?></option>
                            <option value="1" <?php if(isset($radio['sa_lpf']) && $radio['sa_lpf'] == '1') echo 'selected'; ?>><?php echo $TR[$lang]['opt_on']; ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <hr style="border:0; border-top:1px solid #444; margin: 20px 0;">
            <h4 class="panel-title blue" style="font-size:14px; margin-bottom:15px; border-bottom: 1px solid #444; padding-bottom: 5px;"><?php echo $TR[$lang]['hw_title']; ?></h4>

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

            <button type="submit" name="save_radio" class="btn btn-blue" style="margin-top:15px; width: 100%;"><?php echo $TR[$lang]['btn_save']; ?></button>
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
                    <li style="margin-bottom: 12px; border-top: 1px dashed #555; padding-top: 12px;">
                        <?php echo $TR[$lang]['info_svx_filters']; ?>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <?php echo $TR[$lang]['info_sa_bw']; ?>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <?php echo $TR[$lang]['info_sa_filters']; ?>
                    </li>
                    <li style="border-top: 1px dashed #555; padding-top: 12px; color: #FF9800;">
                        <?php echo $TR[$lang]['info_note']; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>