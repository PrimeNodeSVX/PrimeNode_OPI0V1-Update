<?php
header('Content-Type: application/json');

function cleanText($text) {
    $map = [
        'ą'=>'a', 'ć'=>'c', 'ę'=>'e', 'ł'=>'l', 'ń'=>'n', 'ó'=>'o', 'ś'=>'s', 'ź'=>'z', 'ż'=>'z',
        'Ą'=>'A', 'Ć'=>'C', 'Ę'=>'E', 'Ł'=>'L', 'Ń'=>'N', 'Ó'=>'O', 'Ś'=>'S', 'Ź'=>'Z', 'Ż'=>'Z'
    ];
    $text = str_replace(array_keys($map), array_values($map), $text);
    $text = preg_replace('/[^a-zA-Z0-9\s\-\(\)\.\,\/]/', '', $text);
    return trim(preg_replace('/\s+/', ' ', $text));
}

$activeNetworkName = '';
$netFile = '/etc/svxlink/networks.json';
if (file_exists($netFile)) {
    $netData = json_decode(file_get_contents($netFile), true);
    if (isset($netData['active']) && isset($netData['list'])) {
        $activeId = $netData['active'];
        if ($activeId != 0) {
            foreach ($netData['list'] as $net) {
                if ($net['id'] == $activeId) {
                    $activeNetworkName = $net['name'];
                    break;
                }
            }
        }
    }
}

$tgNames = [];
$customDtmfFile = '/var/www/html/dtmf_custom.json';
if (file_exists($customDtmfFile)) {
    $jsonData = json_decode(file_get_contents($customDtmfFile), true);
    if ($jsonData) {
        foreach ($jsonData as $key => $val) {
            if (isset($val['tg']) && isset($val['name'])) $tgNames[$val['tg']] = $val['name'];
            elseif (isset($val['buttons']) && is_array($val['buttons'])) {
                foreach ($val['buttons'] as $btn) if (isset($btn['tg']) && isset($btn['name'])) $tgNames[$btn['tg']] = $btn['name'];
            }
            elseif (is_array($val) && isset($val['name']) && isset($val['tg'])) $tgNames[$val['tg']] = $val['name'];
        }
    }
}

$sysTgdbFile = '/etc/svxlink/tgdb';
if (file_exists($sysTgdbFile)) {
    $lines = file($sysTgdbFile);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || $line[0] == '#' || $line[0] == ';') continue;
        if (strpos($line, '#') !== false) {
            $parts = explode('#', $line, 2);
            $id = trim($parts[0]);
            $name = trim($parts[1]);
            if (!empty($id) && !isset($tgNames[$id])) $tgNames[$id] = $name;
        }
    }
}

if (!isset($tgNames['0'])) $tgNames['0'] = 'Czuwanie';
if (!isset($tgNames['999'])) $tgNames['999'] = 'Echolink/Parrot';

$logFile = '/dev/shm/svxlink.log';

$response = [
    'status' => 'OFFLINE',
    'network' => cleanText($activeNetworkName),
    'tg' => '0',
    'tg_name' => 'Czuwanie',
    'callsign' => '---',
    'temp' => 0
];

$temp = @file_get_contents('/sys/class/thermal/thermal_zone0/temp');
$response['temp'] = $temp ? round($temp / 1000, 1) : 0;

if (file_exists($logFile) && is_readable($logFile)) {

    exec("tail -n 300 " . escapeshellarg($logFile), $lines);
    $lastConnStatus = exec("tac " . escapeshellarg($logFile) . " | grep -m 1 -E 'ReflectorLogic: Connection established|ReflectorLogic: Disconnected|ReflectorLogic: Authentication failed'");
    
    if (strpos($lastConnStatus, 'Connection established') !== false) {
        $status = 'ONLINE';
    } else {
        $status = 'OFFLINE';
    }

    $selectedTg = '0';
    $activeCallsign = '---';
    $talkerTg = '0';
    foreach ($lines as $line) {
        if (strpos($line, "ReflectorLogic: Connection established") !== false || strpos($line, "ReflectorLogic: Connected nodes") !== false) {
            $status = 'ONLINE';
        }
        if (strpos($line, "ReflectorLogic: Disconnected") !== false || strpos($line, "ReflectorLogic: Authentication failed") !== false) {
            $status = 'OFFLINE';
            $selectedTg = '0';
            $activeCallsign = '---';
        }
        if (preg_match('/ReflectorLogic: Selecting TG #(\d+)/', $line, $m)) {
            $status = 'ONLINE';
            $selectedTg = $m[1];
            $activeCallsign = '---';
        }
        if (preg_match('/Talker start on TG #(\d+): ([A-Z0-9-\/]+)/', $line, $m)) {
            $status = 'ONLINE';
            $talkerTg = $m[1];
            $activeCallsign = $m[2];
        }
        if (strpos($line, "Talker stop on TG") !== false) {
            $activeCallsign = '---';
        }
    }

    if ($status == 'OFFLINE') {
        $response['status'] = 'OFFLINE';
        $response['tg'] = '0';
        $response['callsign'] = '---';
    } else {
        $response['status'] = 'ONLINE';
        if ($activeCallsign !== '---') {
            $response['tg'] = $talkerTg;
            $response['callsign'] = $activeCallsign;
        } else {
            $response['tg'] = $selectedTg;
            $response['callsign'] = '---';
        }
    }

    if (isset($tgNames[$response['tg']])) {
        $response['tg_name'] = cleanText($tgNames[$response['tg']]);
    } else {
        $response['tg_name'] = '';
    }
}

echo json_encode($response);
?>