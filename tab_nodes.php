<?php
$TN = [
    'pl' => [
        'lbl_op' => 'Operator:',
        'lbl_tg' => 'Aktualna Grupa (TG):',
        'lbl_qth' => 'Lokator QTH:',
        'lbl_loc' => 'Miasto / Opis:',
        'lbl_mon' => 'Monitorowane:',
        'lbl_ver' => 'Wersja:',
        'btn_close_map' => '❌ ZAMKNIJ MAPĘ',
        'header_nodes' => 'Aktywne Węzły (Network)',
        'btn_show_map' => '🌍 Grid Mapper Node (Pokaż Mapę)',
        'loading' => 'Ładowanie listy węzłów...'
    ],
    'en' => [
        'lbl_op' => 'Operator:',
        'lbl_tg' => 'Current Talkgroup:',
        'lbl_qth' => 'QTH Locator:',
        'lbl_loc' => 'City / Desc:',
        'lbl_mon' => 'Monitored:',
        'lbl_ver' => 'Version:',
        'btn_close_map' => '❌ CLOSE MAP',
        'header_nodes' => 'Active Nodes (Network)',
        'btn_show_map' => '🌍 Grid Mapper Node (Show Map)',
        'loading' => 'Loading nodes list...'
    ]
];
?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div id="node-tooltip" class="node-tooltip">
    <div class="nt-header">
        <span id="nt-callsign"></span>
        <span id="nt-sw"></span>
    </div>
    <div class="nt-body">
        
        <div class="nt-row">
            <span class="nt-label"><?php echo $TN[$lang]['lbl_op']; ?></span>
            <span class="nt-val hl" id="nt-name">---</span>
        </div>

        <div class="nt-row">
            <span class="nt-label"><?php echo $TN[$lang]['lbl_tg']; ?></span>
            <span class="nt-val" id="nt-tg">---</span>
        </div>

        <div class="nt-row">
            <span class="nt-label"><?php echo $TN[$lang]['lbl_qth']; ?></span>
            <span class="nt-val" id="nt-qth">---</span>
        </div>

        <div class="nt-row">
            <span class="nt-label"><?php echo $TN[$lang]['lbl_loc']; ?></span>
            <span class="nt-val" id="nt-loc">---</span>
        </div>
        
        <div class="nt-row">
            <span class="nt-label"><?php echo $TN[$lang]['lbl_mon']; ?></span>
            <span class="nt-val" id="nt-monitored">---</span>
        </div>
        
        <div class="nt-row">
            <span class="nt-label"><?php echo $TN[$lang]['lbl_ver']; ?></span>
            <span class="nt-val" id="nt-ver">---</span>
        </div>
        
        <div class="qrz-logo-container">
            <img src="qrz.png" alt="QRZ" class="qrz-img">
        </div>
    </div>
</div>

<div id="map-overlay">
    <button class="map-close-btn" onclick="closeGridMapper()"><?php echo $TN[$lang]['btn_close_map']; ?></button>
    <div id="map-container"></div>
</div>

<h3><?php echo $TN[$lang]['header_nodes']; ?></h3>

<div style="text-align: center; margin-bottom: 15px;">
    <button class="map-btn-trigger" onclick="openGridMapper()"><?php echo $TN[$lang]['btn_show_map']; ?></button>
</div>

<div class="nodes-container" id="nodes-content">
    <div style="grid-column: 1/-1; text-align: center; color: #777; padding: 20px;">
        <?php echo $TN[$lang]['loading']; ?>
    </div>
</div>

<script>
    if(typeof updateNodes === "function") {
        updateNodes();
    }
</script>
