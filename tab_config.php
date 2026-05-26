<?php
    $net_file = '/etc/svxlink/networks.json';
    $sound_dir = '/usr/local/share/svxlink/sounds/ref_sounds';
    $available_sounds = [];
    if (is_dir($sound_dir)) {
        $files = glob($sound_dir . '/*.{wav,WAV,Wav}', GLOB_BRACE);
        if ($files !== false) {
            foreach ($files as $file) {
                $available_sounds[] = basename($file);
            }
        }
    }

    if (!file_exists($net_file)) {
        $default_net = [
            "active" => 0,
            "list" => []
        ];
        file_put_contents($net_file, json_encode($default_net, JSON_PRETTY_PRINT));
        exec("sudo chown www-data:www-data $net_file");
        exec("sudo chmod 664 $net_file");
    }

    $networks = json_decode(file_get_contents($net_file), true);
    $radio_config_file = '/var/www/html/radio_config.json';
    if (file_exists($radio_config_file)) {
        $radio_data_internal = json_decode(file_get_contents($radio_config_file), true);
        if (isset($_POST['save_svx_full'])) {
            $radio_data_internal['aprs_enabled'] = $_POST['AprsEnable'] ?? '0';
            $radio_data_internal['aprs_passcode'] = $_POST['AprsPasscode'] ?? '';
            $radio_data_internal['aprs_ssid'] = $_POST['AprsSsid'] ?? '';
            $radio_data_internal['aprs_icon'] = $_POST['AprsIcon'] ?? '/-';
            $radio_data_internal['aprs_lat'] = $_POST['AprsLat'] ?? '';
            $radio_data_internal['aprs_lon'] = $_POST['AprsLon'] ?? '';
            $radio_data_internal['aprs_power'] = $_POST['AprsPower'] ?? '0';
            $radio_data_internal['aprs_height'] = $_POST['AprsHeight'] ?? '0';
            $radio_data_internal['aprs_gain'] = $_POST['AprsGain'] ?? '0';
            $radio_data_internal['aprs_dir'] = $_POST['AprsDir'] ?? '0';
            $radio_data_internal['aprs_interval'] = $_POST['AprsInterval'] ?? '30';
            $radio_data_internal['aprs_comment'] = $_POST['AprsComment'] ?? 'PrimeNode OPI0';
            file_put_contents($radio_config_file, json_encode($radio_data_internal, JSON_PRETTY_PRINT));
        }
        $radio = array_merge($radio ?? [], $radio_data_internal);
    }
    $edit_mode = false;
    $edit_data = ['id'=>'','name'=>'','host'=>'','port'=>'5300','pass'=>'','api'=>'','tgs'=>'','callsign'=>'','deftg'=>''];
    $active_callsign = isset($vals['Callsign']) ? $vals['Callsign'] : ''; 
    
    if (isset($networks['active']) && $networks['active'] > 0 && isset($networks['list'])) {
        foreach ($networks['list'] as $net) {
            if ($net['id'] == $networks['active']) {
                $active_callsign = $net['callsign'];
                break;
            }
        }
    }

    if (isset($_POST['save_network'])) {
        $id_to_save = $_POST['n_id'];
        $is_new = true;

        $new_data = [
            'id' => ($id_to_save != '') ? $id_to_save : 0,
            'name' => htmlspecialchars($_POST['n_name']),
            'host' => htmlspecialchars($_POST['n_host']),
            'port' => htmlspecialchars($_POST['n_port']),
            'pass' => htmlspecialchars($_POST['n_pass']),
            'api' => htmlspecialchars($_POST['n_api']),
            'tgs' => htmlspecialchars($_POST['n_tgs']),
            'callsign' => strtoupper(htmlspecialchars($_POST['n_callsign'])),
            'deftg' => htmlspecialchars($_POST['n_deftg']),
            'audio' => htmlspecialchars($_POST['n_audio'] ?? '')
        ];

        if ($id_to_save != '') {
            foreach ($networks['list'] as $key => $net) {
                if ($net['id'] == $id_to_save) {
                    $networks['list'][$key] = $new_data;
                    $is_new = false;
                    break;
                }
            }
        }

        if ($is_new) {
            $new_id = 1;
            if (!empty($networks['list'])) {
                $ids = array_column($networks['list'], 'id');
                $new_id = max($ids) + 1;
            }
            $new_data['id'] = $new_id;
            $networks['list'][] = $new_data;
        }
        
        file_put_contents($net_file, json_encode($networks, JSON_PRETTY_PRINT));

        if (isset($networks['active']) && $networks['active'] == $new_data['id']) {
            $switch_data = [
                'Callsign'   => $new_data['callsign'],
                'Host'       => $new_data['host'],
                'Port'       => $new_data['port'],
                'Password'   => $new_data['pass'],
                'DefaultTG'  => $new_data['deftg'],
                'MonitorTGs' => $new_data['tgs'],
                'node_api_url' => $new_data['api'],
                'audio_file' => $new_data['audio'] ?? ''
            ];

            file_put_contents('/tmp/svx_new_settings.json', json_encode($switch_data));
            shell_exec('sudo /usr/bin/python3 /usr/local/bin/update_svx_full.py 2>&1');
            shell_exec('sudo /usr/bin/systemctl restart svxlink > /dev/null 2>&1 &');
            echo "<div class='alert alert-success'>Zaktualizowano parametry aktywnej sieci. Restart...</div>";
        }

        echo "<script>window.location.href='index.php';</script>";
    }

    if (isset($_POST['del_network'])) {
        $del_id = $_POST['del_network'];
        $was_active = ($networks['active'] == $del_id); 

        foreach ($networks['list'] as $key => $net) {
            if ($net['id'] == $del_id) {
                unset($networks['list'][$key]);
            }
        }
        $networks['list'] = array_values($networks['list']);
        
        if ($was_active) {
            $networks['active'] = 0;

            $disconnect_data = [
                'Host' => '', 
                'Port' => '0',
                'Password' => '',
                'MonitorTGs' => '',
                'node_api_url' => '',
                'Callsign' => '',
                'audio_file' => ''
            ];
            file_put_contents('/tmp/svx_new_settings.json', json_encode($disconnect_data));
            shell_exec('sudo /usr/bin/python3 /usr/local/bin/update_svx_full.py 2>&1');
            shell_exec('sudo /usr/bin/systemctl restart svxlink > /dev/null 2>&1 &');
        }

        file_put_contents($net_file, json_encode($networks, JSON_PRETTY_PRINT));
        echo "<script>window.location.href='index.php';</script>";
    }

    if (isset($_POST['switch_network'])) {
        $target_id = $_POST['switch_network'];
        $selected_net = null;

        foreach ($networks['list'] as $net) {
            if ($net['id'] == $target_id) {
                $selected_net = $net;
                break;
            }
        }

        if ($selected_net) {
            $switch_data = [
                'Callsign'   => $selected_net['callsign'],
                'Host'       => $selected_net['host'],
                'Port'       => $selected_net['port'],
                'Password'   => $selected_net['pass'],
                'DefaultTG'  => isset($selected_net['deftg']) ? $selected_net['deftg'] : '0',
                'MonitorTGs' => isset($selected_net['tgs']) ? $selected_net['tgs'] : '',
                'node_api_url' => isset($selected_net['api']) ? $selected_net['api'] : '',
                'audio_file' => $selected_net['audio'] ?? ''
            ];

            file_put_contents('/tmp/svx_new_settings.json', json_encode($switch_data));
            shell_exec('sudo /usr/bin/python3 /usr/local/bin/update_svx_full.py 2>&1');
            $networks['active'] = $target_id;
            file_put_contents($net_file, json_encode($networks, JSON_PRETTY_PRINT));
            shell_exec('sudo /usr/bin/systemctl restart svxlink > /dev/null 2>&1 &');
            echo "<div class='alert alert-success'>Przełączono na: " . htmlspecialchars($selected_net['name']) . ". Restart...</div>";
            echo "<script>setTimeout(function(){ window.location.href='index.php'; }, 3000);</script>";
        }
    }

    if (isset($_POST['edit_network'])) {
        $edit_mode = true;
        foreach ($networks['list'] as $net) {
            if ($net['id'] == $_POST['edit_network']) {
                $edit_data = $net;
                if(empty($edit_data['callsign'])) $edit_data['callsign'] = $vals['Callsign'] ?? ''; 
                if(empty($edit_data['deftg'])) $edit_data['deftg'] = $vals['DefaultTG'] ?? '';
                if(empty($edit_data['tgs'])) $edit_data['tgs'] = $vals['MonitorTGs'] ?? '';
                if(empty($edit_data['audio'])) $edit_data['audio'] = '';
                break;
            }
        }
    }

    $current_audio_lang = $simp['DEFAULT_LANG'] ?? 'PL';

    $TC = [
        'pl' => [
            'header' => 'Konfiguracja SvxLink',
            'sect_roam' => 'Menedżer Sieci (Roaming)',
            'th_name' => 'Nazwa',
            'th_host' => 'Host',
            'th_dtmf' => 'Kod DTMF',
            'th_act' => 'Akcja',
            'btn_switch' => 'PRZEŁĄCZ',
            'btn_edit' => 'EDYTUJ',
            'lbl_active' => 'AKTYWNY',
            'lbl_add_new' => 'Edycja / Dodawanie Sieci:',
            'btn_add' => 'ZAPISZ SIEC',
            'btn_cancel' => 'ANULUJ',
            'ph_name' => 'Nazwa (np. Mój Serwer)',
            'ph_host' => 'Host (np. sqlink.pl)',
            'ph_pass' => 'Hasło',
            'ph_tgs' => 'Monitorowane TG (np. 260)',
            'ph_call' => 'Znak Noda',
            'ph_deftg' => 'Startowe TG',
            'lbl_audio_sel' => 'Zapowiedź Audio',
            'opt_default' => 'Domyślny',
            'sect_el' => 'EchoLink',
            'lbl_el_call' => 'Znak EchoLink',
            'lbl_el_pass' => 'Hasło EchoLink',
            'lbl_el_sysop' => 'Nazwa Sysop',
            'lbl_el_desc' => 'Opis Stacji',
            'lbl_el_proxy' => 'Proxy (IP)',
            'ph_el_proxy' => 'np. 44.31.61.106',
            'btn_proxy' => '♻️ Auto-Proxy',
            'sect_loc' => 'Lokalizacja i Operator',
            'lbl_name' => 'Imię Operatora',
            'lbl_city' => 'Miasto (QTH)',
            'lbl_loc' => 'QTH Locator',
            'sect_map' => 'Wygląd Mapy',
            'btn_dark' => '🌑 Ciemna',
            'btn_light' => '☀️ Jasna',
            'btn_osm' => '🗺️ Kolorowa',
            'sect_adv' => 'Audio i Moduły',
            'lbl_modules' => 'Aktywne Moduły',
            'btn_help' => 'Pomoc',
            'btn_parrot' => 'Papuga',
            'btn_el' => 'EchoLink',
            'lbl_tg_time' => 'TG Timeout',
            'lbl_tmp_time' => 'Tmp Timeout',
            'lbl_beep' => 'Beep 3-ton',
            'lbl_ann_tg' => 'Zapowiedź TG',
            'lbl_info' => 'Info Link',
            'lbl_roger' => 'Roger Beep',
            'lbl_voice_id' => 'Recytowanie Znaku',
            'lbl_lang_audio' => 'Język Audio',
            'opt_yes' => 'TAK',
            'opt_no' => 'NIE',
            'btn_save' => 'Zapisz Ustawienia Globalne',
	        'tg_modal_title' => '🎙️ Wybierz Grupy TG',
            'tg_selected' => 'Wybrane:',
            'tg_ph_manual' => 'Wpisz nr TG...',
            'btn_add_tg' => 'DODAJ',
            'btn_confirm' => '✅ ZATWIERDŹ',
            'btn_cancel' => '❌ ANULUJ',
            'sect_aprs' => '🌍 Ustawienia APRS (Beacon)',
            'lbl_aprs_en' => 'Włącz Moduł APRS',
            'lbl_aprs_pass' => 'Passcode (APRS-IS)',
            'lbl_aprs_ssid' => 'SSID (Sufiks)',
            'opt_aprs_none' => 'Brak (Główny znak)',
            'lbl_aprs_icon' => 'Ikona (Tabela/Znak)',
            'lbl_aprs_int' => 'Interwał (min)',
            'lbl_aprs_lat' => 'Szerokość (Lat)',
            'lbl_aprs_lon' => 'Długość (Lon)',
            'lbl_aprs_power' => 'Moc (W)',
            'lbl_aprs_gain' => 'Zysk Ant. (dBd)',
            'lbl_aprs_height' => 'Wys. A.p.t. (m)',
            'lbl_aprs_dir' => 'Kierunek (°)',
            'lbl_aprs_comment' => 'Komentarz Systemowy',
            'aprs_icon_echo' => '🌐 [ E 0 ] Węzeł EchoLink',
            'aprs_icon_node' => '🎯 [ / n ] Węzeł / Node',
            'aprs_icon_digi' => '🌟 [ / # ] Cyfrowe Digi',
            'aprs_icon_rep' => '📡 [ / r ] Przemiennik',
            'aprs_icon_home' => '🏠 [ / - ] Dom (QTH)',
            'aprs_icon_car' => '🚗 [ / > ] Samochód',
            'aprs_icon_van' => '🚙 [ \ v ] Van',
            'aprs_icon_walk' => '🚶 [ / [ ] Człowiek (Portable)'
        ],
        'en' => [
            'header' => 'SvxLink Configuration',
            'sect_roam' => 'Network Manager (Roaming)',
            'th_name' => 'Name',
            'th_host' => 'Host',
            'th_dtmf' => 'DTMF Code',
            'th_act' => 'Action',
            'btn_switch' => 'SWITCH',
            'btn_edit' => 'EDIT',
            'lbl_active' => 'ACTIVE',
            'lbl_add_new' => 'Edit / Add Network:',
            'btn_add' => 'SAVE NETWORK',
            'btn_cancel' => 'CANCEL',
            'ph_name' => 'Name',
            'ph_host' => 'Host',
            'ph_pass' => 'Password',
            'ph_tgs' => 'Monitor TGs',
            'ph_call' => 'Node Callsign',
            'ph_deftg' => 'Default TG',
            'lbl_audio_sel' => 'Voice ID',
            'opt_default' => 'Default',
            'sect_el' => 'EchoLink',
            'lbl_el_call' => 'EchoLink Callsign',
            'lbl_el_pass' => 'EchoLink Password',
            'lbl_el_sysop' => 'Sysop Name',
            'lbl_el_desc' => 'Description',
            'lbl_el_proxy' => 'Proxy (IP)',
            'ph_el_proxy' => 'e.g. 44.31.61.106',
            'btn_proxy' => '♻️ Auto-Proxy',
            'sect_loc' => 'Location & Operator',
            'lbl_name' => 'Operator Name',
            'lbl_city' => 'City (QTH)',
            'lbl_loc' => 'QTH Locator',
            'sect_map' => 'Map Style',
            'btn_dark' => '🌑 Dark',
            'btn_light' => '☀️ Light',
            'btn_osm' => '🗺️ Colorful',
            'sect_adv' => 'Audio & Modules',
            'lbl_modules' => 'Active Modules',
            'btn_help' => 'Help',
            'btn_parrot' => 'Parrot',
            'btn_el' => 'EchoLink',
            'lbl_tg_time' => 'TG Timeout',
            'lbl_tmp_time' => 'Tmp Timeout',
            'lbl_beep' => '3-Tone Beep',
            'lbl_ann_tg' => 'Announce TG',
            'lbl_info' => 'Link Info',
            'lbl_roger' => 'Roger Beep',
            'lbl_voice_id' => 'Voice ID',
            'lbl_lang_audio' => 'Audio Lang',
            'opt_yes' => 'YES',
            'opt_no' => 'NO',
            'btn_save' => 'Save Global Settings',
	        'tg_modal_title' => '🎙️ Select TG Groups',
            'tg_selected' => 'Selected:',
            'tg_ph_manual' => 'Enter TG no...',
            'btn_add_tg' => 'ADD',
            'btn_confirm' => '✅ CONFIRM',
            'btn_cancel' => '❌ CANCEL',
            'sect_aprs' => '🌍 APRS Settings (Beacon)',
            'lbl_aprs_en' => 'Enable APRS Module',
            'lbl_aprs_pass' => 'Passcode (APRS-IS)',
            'lbl_aprs_ssid' => 'SSID (Suffix)',
            'opt_aprs_none' => 'None (Main callsign)',
            'lbl_aprs_icon' => 'Icon (Table/Symbol)',
            'lbl_aprs_int' => 'Interval (min)',
            'lbl_aprs_lat' => 'Latitude (Lat)',
            'lbl_aprs_lon' => 'Longitude (Lon)',
            'lbl_aprs_power' => 'Power (W)',
            'lbl_aprs_gain' => 'Ant. Gain (dBd)',
            'lbl_aprs_height' => 'Height ASL (m)',
            'lbl_aprs_dir' => 'Direction (°)',
            'lbl_aprs_comment' => 'System Comment',
            'aprs_icon_echo' => '🌐 [ E 0 ] EchoLink Node',
            'aprs_icon_node' => '🎯 [ / n ] Node',
            'aprs_icon_digi' => '🌟 [ / # ] Digital Digi',
            'aprs_icon_rep' => '📡 [ / r ] Repeater',
            'aprs_icon_home' => '🏠 [ / - ] Home (QTH)',
            'aprs_icon_car' => '🚗 [ / > ] Car',
            'aprs_icon_van' => '🚙 [ \ v ] Van',
            'aprs_icon_walk' => '🚶 [ / [ ] Human (Portable)'
        ]
    ];
?>

<h3><?php echo $TC[$lang]['header']; ?></h3>
<div class="panel-box box-full" style="border: 1px solid #FF9800;">
    <h4 class="panel-title" style="color:#FF9800; border-color:#FF9800;"><?php echo $TC[$lang]['sect_roam']; ?></h4>
    <table class="wifi-saved-table">
        <tr>
            <th><?php echo $TC[$lang]['th_name']; ?></th>
            <th><?php echo $TC[$lang]['th_host']; ?></th>
            <th><?php echo $TC[$lang]['th_dtmf']; ?></th>
            <th><?php echo $TC[$lang]['th_act']; ?></th>
        </tr>
        <?php if(isset($networks['list'])): foreach($networks['list'] as $net): ?>
        <tr style="<?php echo ($networks['active'] == $net['id'] ? 'background:rgba(76,175,80,0.1); border-left: 3px solid #4CAF50;' : ''); ?>">
            <td><?php echo $net['name']; ?></td>
            <td><?php echo $net['host']; ?></td>
            <td style="font-weight:bold; color:#FF9800;">555<?php echo $net['id']; ?>#</td>
            <td style="display:flex; gap:5px; align-items: center;">
                <?php if($networks['active'] != $net['id']): ?>
                    <form method="post" style="margin:0;">
                        <button type="submit" name="switch_network" value="<?php echo $net['id']; ?>" class="btn-small-del" style="background:#2196F3; font-weight:bold;"><?php echo $TC[$lang]['btn_switch']; ?></button>
                    </form>
                <?php else: ?>
                    <span style="color:#4CAF50; font-weight:bold; padding:5px; font-size:12px;"><?php echo $TC[$lang]['lbl_active']; ?></span>
                <?php endif; ?>
                
                <form method="post" style="margin:0;">
                    <button type="submit" name="edit_network" value="<?php echo $net['id']; ?>" class="btn-small-del" style="background:#FF9800;"><?php echo $TC[$lang]['btn_edit']; ?></button>
                </form>

                <form method="post" style="margin:0;">
                    <button type="submit" name="del_network" value="<?php echo $net['id']; ?>" class="btn-small-del" onclick="return confirm('Delete?');">X</button>
                </form>
            </td>
        </tr>
        <?php endforeach; endif; ?>
    </table>

    <div style="background:#2a2a2a; padding:15px; border-radius:5px; margin-top:15px; border:1px solid #444;">
        <label style="margin-bottom:8px; color:#ddd; font-size:14px;"><?php echo $TC[$lang]['lbl_add_new']; ?></label>
        <form method="post">
            <input type="hidden" name="n_id" value="<?php echo $edit_data['id']; ?>">
            
            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:10px;">
                <div style="flex:1; min-width:150px;">
                    <input type="text" name="n_name" placeholder="<?php echo $TC[$lang]['ph_name']; ?>" value="<?php echo $edit_data['name']; ?>" required>
                </div>
                <div style="flex:1; min-width:150px;">
                    <input type="text" name="n_host" placeholder="<?php echo $TC[$lang]['ph_host']; ?>" value="<?php echo $edit_data['host']; ?>" required>
                </div>
                <div style="width:80px;">
                    <input type="number" name="n_port" placeholder="5300" value="<?php echo $edit_data['port']; ?>" required>
                </div>
            </div>

            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:10px;">
                <div style="flex:1; min-width:120px;">
                    <input type="text" name="n_callsign" placeholder="<?php echo $TC[$lang]['ph_call']; ?>" value="<?php echo $edit_data['callsign']; ?>" oninput="this.value = this.value.toUpperCase()" style="text-transform:uppercase;" required>
                </div>
                <div style="flex:1; min-width:120px;">
                    <input type="password" name="n_pass" placeholder="<?php echo $TC[$lang]['ph_pass']; ?>" value="<?php echo $edit_data['pass']; ?>" required>
                </div>
            </div>

            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:10px;">
                <div style="flex:1; min-width:200px;">
                    <input type="text" name="n_api" placeholder="API URL (http://...)" value="<?php echo $edit_data['api']; ?>">
                </div>
                <div style="flex:1; min-width:150px;">
                    <select name="n_audio" style="width:100%; cursor:pointer; color: #ccc; background: transparent; border: 1px solid #444; padding: 8px; border-radius: 4px;">
                        <option value="" style="background: #2a2a2a; color: #ccc;"><?php echo $TC[$lang]['lbl_audio_sel']; ?>: <?php echo $TC[$lang]['opt_default']; ?></option>
                        <?php foreach($available_sounds as $snd): ?>
                            <option value="<?php echo $snd; ?>" style="background: #2a2a2a; color: #ccc;" <?php if($edit_data['audio'] == $snd) echo 'selected'; ?>><?php echo $snd; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
               <div style="flex:1; min-width:100px;">
                    <input type="text" id="n_deftg_input" name="n_deftg" placeholder="<?php echo $TC[$lang]['ph_deftg']; ?>" value="<?php echo $edit_data['deftg']; ?>" onclick="openTgSelector('n_deftg_input', 'single')" style="cursor: pointer;" readonly title="Kliknij, aby wybrać z listy">
                </div>
                <div style="flex:1; min-width:100px;">
                    <input type="text" id="n_tgs_input" name="n_tgs" placeholder="<?php echo $TC[$lang]['ph_tgs']; ?>" value="<?php echo $edit_data['tgs']; ?>" onclick="openTgSelector('n_tgs_input', 'multi')" style="cursor: pointer;" readonly title="Kliknij, aby wybrać z listy">
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:5px;">
                <button type="submit" name="save_network" class="btn-small-del" style="background:#4CAF50; color:#fff; font-weight:bold; width:auto; padding:10px 30px; font-size:14px;"><?php echo $TC[$lang]['btn_add']; ?></button>
                <?php if($edit_mode): ?>
                    <a href="index.php" class="btn-small-del" style="background:#777; text-decoration:none; padding:10px 20px; display:inline-block;"><?php echo $TC[$lang]['btn_cancel']; ?></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<form method="post">
    <input type="hidden" name="active_tab" class="active-tab-input" value="SvxConfig">
    
    <input type="hidden" name="Callsign" value="<?php echo $active_callsign; ?>">

    <div class="form-grid-layout">
        
        <div class="panel-box box-full">
            <h4 class="panel-title blue"><?php echo $TC[$lang]['sect_el']; ?></h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label><?php echo $TC[$lang]['lbl_el_call']; ?></label><input type="text" name="EL_Callsign" value="<?php echo $vals_el['Callsign']; ?>"></div>
                <div class="form-group"><label><?php echo $TC[$lang]['lbl_el_pass']; ?></label><input type="password" name="EL_Password" id="el-pass" value="<?php echo $vals_el['Password']; ?>"></div>
                <div class="form-group"><label><?php echo $TC[$lang]['lbl_el_sysop']; ?></label><input type="text" name="EL_Sysop" value="<?php echo $vals_el['Sysop']; ?>"></div>
                <div class="form-group"><label><?php echo $TC[$lang]['lbl_el_desc']; ?></label><input type="text" name="EL_Desc" value="<?php echo $vals_el['Desc']; ?>"></div>
            </div>
            <div class="form-group" style="margin-top:15px;"><label><?php echo $TC[$lang]['lbl_el_proxy']; ?></label><input type="text" name="EL_ProxyHost" value="<?php echo $vals_el['Proxy']; ?>" placeholder="<?php echo $TC[$lang]['ph_el_proxy']; ?>"><small style="color:#888; font-size:10px;"><?php echo $TC[$lang]['help_proxy'] ?? ''; ?></small></div>
            <div style="margin-top:5px;">
                <button type="submit" name="auto_proxy" class="btn btn-green" style="margin:0; padding:8px; font-size:12px;" onclick="return confirm('Czy na pewno chcesz szukać Proxy?')"><?php echo $TC[$lang]['btn_proxy']; ?></button>
            </div>
        </div>

        <div class="panel-box box-full">
            <h4 class="panel-title green"><?php echo $TC[$lang]['sect_loc']; ?></h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_name']; ?></label><input type="text" name="qth_name" value="<?php echo isset($radio['qth_name']) ? $radio['qth_name'] : ''; ?>"></div>
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_city']; ?></label><input type="text" name="qth_city" value="<?php echo isset($radio['qth_city']) ? $radio['qth_city'] : ''; ?>"></div>
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_loc']; ?></label><input type="text" name="qth_loc" value="<?php echo isset($radio['qth_loc']) ? $radio['qth_loc'] : ''; ?>" placeholder="np. JO91QI"></div>
            </div>
            <small style="color:#888; font-size:10px; display:block; margin-top:5px;"></small>
        </div>

        <div class="panel-box box-full">
            <h4 class="panel-title" style="color: #2196F3; border-color: #2196F3;"><?php echo $TC[$lang]['sect_aprs']; ?></h4>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group" style="margin:0;">
                    <label><?php echo $TC[$lang]['lbl_aprs_en']; ?></label>
                    <select name="AprsEnable">
                        <option value="1" <?php if(($radio['aprs_enabled'] ?? '0') == '1') echo 'selected'; ?>><?php echo $TC[$lang]['opt_yes']; ?></option>
                        <option value="0" <?php if(($radio['aprs_enabled'] ?? '0') == '0') echo 'selected'; ?>><?php echo $TC[$lang]['opt_no']; ?></option>
                    </select>
                </div>
                <div class="form-group" style="margin:0;">
                    <label><?php echo $TC[$lang]['lbl_aprs_pass']; ?></label>
                    <input type="password" name="AprsPasscode" value="<?php echo $radio['aprs_passcode'] ?? ''; ?>">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group" style="margin:0;">
                    <label><?php echo $TC[$lang]['lbl_aprs_ssid']; ?></label>
                    <select name="AprsSsid">
                        <option value="" <?php if(($radio['aprs_ssid'] ?? '') == '') echo 'selected'; ?>><?php echo $TC[$lang]['opt_aprs_none']; ?></option>
                        <?php for($i=1; $i<=15; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php if(($radio['aprs_ssid'] ?? '') == (string)$i) echo 'selected'; ?>>-<?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group" style="margin:0;">
                    <label><?php echo $TC[$lang]['lbl_aprs_icon']; ?></label>
                    <select name="AprsIcon">
                        <option value="E0" <?php if(($radio['aprs_icon'] ?? 'E0') == 'E0') echo 'selected'; ?>><?php echo $TC[$lang]['aprs_icon_echo']; ?></option>
                        <option value="/n" <?php if(($radio['aprs_icon'] ?? '') == '/n') echo 'selected'; ?>><?php echo $TC[$lang]['aprs_icon_node']; ?></option>
                        <option value="/#" <?php if(($radio['aprs_icon'] ?? '') == '/#') echo 'selected'; ?>><?php echo $TC[$lang]['aprs_icon_digi']; ?></option>
                        <option value="/r" <?php if(($radio['aprs_icon'] ?? '') == '/r') echo 'selected'; ?>><?php echo $TC[$lang]['aprs_icon_rep']; ?></option>
                        <option value="/-" <?php if(($radio['aprs_icon'] ?? '') == '/-') echo 'selected'; ?>><?php echo $TC[$lang]['aprs_icon_home']; ?></option>
                        <option value="/>" <?php if(($radio['aprs_icon'] ?? '') == '/>') echo 'selected'; ?>><?php echo $TC[$lang]['aprs_icon_car']; ?></option>
                        <option value="1v" <?php if(($radio['aprs_icon'] ?? '') == '1v') echo 'selected'; ?>><?php echo $TC[$lang]['aprs_icon_van']; ?></option>
                        <option value="/[" <?php if(($radio['aprs_icon'] ?? '') == '/[') echo 'selected'; ?>><?php echo $TC[$lang]['aprs_icon_walk']; ?></option>
                    </select>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_aprs_lat']; ?></label><input type="text" name="AprsLat" value="<?php echo $radio['aprs_lat'] ?? ''; ?>" placeholder="51.3456"></div>
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_aprs_lon']; ?></label><input type="text" name="AprsLon" value="<?php echo $radio['aprs_lon'] ?? ''; ?>" placeholder="19.3456"></div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_aprs_power']; ?></label><input type="number" name="AprsPower" value="<?php echo $radio['aprs_power'] ?? '0'; ?>"></div>
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_aprs_gain']; ?></label><input type="number" name="AprsGain" value="<?php echo $radio['aprs_gain'] ?? '0'; ?>"></div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_aprs_height']; ?></label><input type="number" name="AprsHeight" value="<?php echo $radio['aprs_height'] ?? '0'; ?>"></div>
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_aprs_dir']; ?></label><input type="number" name="AprsDir" value="<?php echo $radio['aprs_dir'] ?? '0'; ?>"></div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_aprs_int']; ?></label><input type="number" name="AprsInterval" value="<?php echo $radio['aprs_interval'] ?? '30'; ?>" min="10"></div>
                <div class="form-group" style="margin:0;"><label><?php echo $TC[$lang]['lbl_aprs_comment']; ?></label><input type="text" name="AprsComment" value="<?php echo $radio['aprs_comment'] ?? 'PrimeNode OPI0'; ?>"></div>
            </div>
        </div>

        <div class="panel-box box-full">
            <h4 class="panel-title"><?php echo $TC[$lang]['sect_map']; ?></h4>
            <div style="display:flex; gap:10px; justify-content:center;">
                <button type="button" id="btn-map-dark" onclick="setMapStyle('dark')" class="mod-btn"><?php echo $TC[$lang]['btn_dark']; ?></button>
                <button type="button" id="btn-map-light" onclick="setMapStyle('light')" class="mod-btn"><?php echo $TC[$lang]['btn_light']; ?></button>
                <button type="button" id="btn-map-osm" onclick="setMapStyle('osm')" class="mod-btn"><?php echo $TC[$lang]['btn_osm']; ?></button>
            </div>
        </div>

        <div class="panel-box box-full">
            <h4 class="panel-title green"><?php echo $TC[$lang]['sect_adv']; ?></h4>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="text-align:center; margin-bottom:10px;"><?php echo $TC[$lang]['lbl_modules']; ?></label>
                <input type="hidden" name="Modules" id="input-modules" value="<?php echo $vals['Modules'] ?? ''; ?>">
                
                <div class="mod-grid">
                    <div class="mod-btn" id="btn-ModuleHelp" onclick="toggleModule('ModuleHelp')" style="max-width:120px;"><?php echo $TC[$lang]['btn_help']; ?></div>
                    <div class="mod-btn" id="btn-ModuleParrot" onclick="toggleModule('ModuleParrot')" style="max-width:120px;"><?php echo $TC[$lang]['btn_parrot']; ?></div>
                    <div class="mod-btn" id="btn-ModuleEchoLink" onclick="toggleModule('ModuleEchoLink')" style="max-width:120px;"><?php echo $TC[$lang]['btn_el']; ?></div>
                </div>
            </div>

            <div class="flex-settings">
                
                <div class="form-group">
                    <label><?php echo $TC[$lang]['lbl_lang_audio']; ?></label>
                    <select name="AudioLang">
                        <option value="PL" <?php if($current_audio_lang == 'PL') echo 'selected'; ?>>PL (Polski)</option>
                        <option value="en_US" <?php if($current_audio_lang == 'en_US') echo 'selected'; ?>>EN (English)</option>
                    </select>
                </div>

                <div class="form-group"><label><?php echo $TC[$lang]['lbl_tg_time']; ?></label><input type="number" name="TgTimeout" value="<?php echo $vals['TgTimeout'] ?? ''; ?>" required min="0"></div>
                <div class="form-group"><label><?php echo $TC[$lang]['lbl_tmp_time']; ?></label><input type="number" name="TmpTimeout" value="<?php echo $vals['TmpTimeout'] ?? ''; ?>" required min="0"></div>
                
                <div class="form-group"><label><?php echo $TC[$lang]['lbl_beep']; ?></label><select name="Beep3Tone"><option value="1" <?php if(isset($vals['Beep3Tone']) && $vals['Beep3Tone']=='1') echo 'selected'; ?>><?php echo $TC[$lang]['opt_yes']; ?></option><option value="0" <?php if(isset($vals['Beep3Tone']) && $vals['Beep3Tone']=='0') echo 'selected'; ?>><?php echo $TC[$lang]['opt_no']; ?></option></select></div>
                <div class="form-group"><label><?php echo $TC[$lang]['lbl_ann_tg']; ?></label><select name="AnnounceTG"><option value="1" <?php if(isset($vals['AnnounceTG']) && $vals['AnnounceTG']=='1') echo 'selected'; ?>><?php echo $TC[$lang]['opt_yes']; ?></option><option value="0" <?php if(isset($vals['AnnounceTG']) && $vals['AnnounceTG']=='0') echo 'selected'; ?>><?php echo $TC[$lang]['opt_no']; ?></option></select></div>
                <div class="form-group"><label><?php echo $TC[$lang]['lbl_info']; ?></label><select name="RefStatusInfo"><option value="1" <?php if(isset($vals['RefStatusInfo']) && $vals['RefStatusInfo']=='1') echo 'selected'; ?>><?php echo $TC[$lang]['opt_yes']; ?></option><option value="0" <?php if(isset($vals['RefStatusInfo']) && $vals['RefStatusInfo']=='0') echo 'selected'; ?>><?php echo $TC[$lang]['opt_no']; ?></option></select></div>
                <div class="form-group"><label><?php echo $TC[$lang]['lbl_roger']; ?></label><select name="RogerBeep"><option value="1" <?php if(isset($vals['RogerBeep']) && $vals['RogerBeep']=='1') echo 'selected'; ?>><?php echo $TC[$lang]['opt_yes']; ?></option><option value="0" <?php if(isset($vals['RogerBeep']) && $vals['RogerBeep']=='0') echo 'selected'; ?>><?php echo $TC[$lang]['opt_no']; ?></option></select></div>
                <div class="form-group"><label><?php echo $TC[$lang]['lbl_voice_id']; ?></label><select name="AnnounceCall"><option value="1" <?php if(isset($vals['AnnounceCall']) && $vals['AnnounceCall']=='1') echo 'selected'; ?>><?php echo $TC[$lang]['opt_yes']; ?></option><option value="0" <?php if(isset($vals['AnnounceCall']) && $vals['AnnounceCall']=='0') echo 'selected'; ?>><?php echo $TC[$lang]['opt_no']; ?></option></select></div>
            </div>
        </div>
    </div>
    <button type="submit" name="save_svx_full" class="btn btn-blue" style="margin-top:20px;"><?php echo $TC[$lang]['btn_save']; ?></button>
</form>

<?php
$tg_list_data = [];
$custom_dtmf_path = '/var/www/html/dtmf_custom.json';
if (file_exists($custom_dtmf_path)) {
    $tg_list_data = json_decode(file_get_contents($custom_dtmf_path), true);
}
?>

<style>

#tg-modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.85);
    z-index: 10000;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
}

#tg-modal {
    background: #1e1e1e;
    border: 2px solid #2196F3;
    border-radius: 12px;
    padding: 25px;
    max-width: 550px;
    width: 90%;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 15px 50px rgba(0,0,0,0.9);
    color: #eee;
}

.tg-sel-box {
    display: flex; flex-wrap: wrap; gap: 8px;
    background: #111; 
    border: 1px inset #444; 
    border-radius: 8px;
    padding: 12px; 
    min-height: 48px; 
    margin-bottom: 15px;
}

.tg-chip {
    background: #4CAF50; 
    color: #fff;
    padding: 6px 12px; 
    border-radius: 20px;
    font-size: 13px; 
    font-weight: bold;
    display: flex; 
    align-items: center; 
    gap: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
}

.tg-chip-del {
    cursor: pointer; 
    background: rgba(0,0,0,0.2);
    border-radius: 50%; 
    width: 20px; height: 20px;
    display: flex; justify-content: center; align-items: center;
    transition: 0.2s;
}
.tg-chip-del:hover { 
    background: #F44336; 
}

.tg-manual-add {
    display: flex; gap: 10px; margin-bottom: 15px;
}

.tg-cat-title {
    color: #FF9800; 
    font-size: 15px; 
    font-weight: bold;
    margin: 15px 0 10px 0; 
    border-bottom: 1px dashed #555; 
    padding-bottom: 5px;
}

.tg-grid {
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); 
    gap: 10px;
}

.tg-tile {
    background: #2a2a2a; 
    border: 1px solid #444; 
    border-radius: 8px;
    padding: 12px 5px; 
    text-align: center; 
    cursor: pointer; 
    transition: 0.2s;
}
.tg-tile:hover {
    background: #333; 
    border-color: #2196F3; 
    transform: translateY(-2px);
}

.tg-tile-num {
    font-size: 18px; 
    font-weight: bold; 
    color: #2196F3; 
    margin-bottom: 5px;
}

.tg-tile-name {
    font-size: 11px; 
    color: #aaa; 
    white-space: nowrap; 
    overflow: hidden; 
    text-overflow: ellipsis; 
    padding: 0 5px;
}
</style>

<div id="tg-modal-overlay">
    <div id="tg-modal">
        <h3 style="margin-top:0; color:#2196F3; border-bottom: 1px solid #333; padding-bottom: 10px; display:flex; justify-content:space-between; align-items:center;">
            <span><?php echo $TC[$lang]['tg_modal_title']; ?></span>
            <span id="tg-modal-mode" style="font-size:12px; background:#333; color:#ccc; padding:3px 8px; border-radius:4px;"></span>
        </h3>

        <div style="font-size:11px; color:#888; margin-bottom:5px;"><?php echo $TC[$lang]['tg_selected']; ?></div>
        <div class="tg-sel-box" id="tg-selected-container"></div>

        <div class="tg-manual-add">
            <input type="number" id="tg-manual-input" placeholder="<?php echo $TC[$lang]['tg_ph_manual']; ?>" style="flex:1; padding:8px; font-size:14px; background:#222; color:#fff; border:1px solid #444; border-radius:4px;">
            <button class="btn btn-blue" style="width:auto; margin:0; padding:0 20px;" onclick="addManualTg()"><?php echo $TC[$lang]['btn_add_tg']; ?></button>
        </div>

        <div style="flex:1; overflow-y:auto; padding-right:5px; margin-bottom:15px;" id="tg-lists-container"></div>

        <div style="display:flex; gap:10px;">
            <button class="btn btn-green" style="margin:0;" onclick="saveTgSelection()"><?php echo $TC[$lang]['btn_confirm']; ?></button>
            <button class="btn btn-red" style="margin:0;" onclick="closeTgSelector()"><?php echo $TC[$lang]['btn_cancel']; ?></button>
        </div>
    </div>
</div>

<script>
    const tgDataGroups = <?php echo json_encode($tg_list_data); ?>;
</script>