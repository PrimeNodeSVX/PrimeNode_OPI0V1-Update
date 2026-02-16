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

if (file_exists($logFile)) {
    $lines = array_slice(file($logFile), -300);
    $logContent = implode("", $lines);

    $lastConnect = max(
        (int)strrpos($logContent, "ReflectorLogic: Connection established"),
        (int)strrpos($logContent, "ReflectorLogic: Connected nodes"),
        (int)strrpos($logContent, "ReflectorLogic: Talker start")
    );
    $lastDisconnect = max(
        (int)strrpos($logContent, "ReflectorLogic: Disconnected"),
        (int)strrpos($logContent, "ReflectorLogic: Authentication failed")
    );

    if ($lastConnect > $lastDisconnect) {
        $response['status'] = 'ONLINE';
    }

    if (preg_match_all('/ReflectorLogic: Selecting TG #(\d+)/', $logContent, $matchesSelect)) {
        $lastIdx = count($matchesSelect[0]) - 1;
        $response['tg'] = $matchesSelect[1][$lastIdx];
    }

    if (preg_match_all('/Talker start on TG #(\d+): ([A-Z0-9-\/]+)/', $logContent, $matchesTalk)) {
        $lastIdx = count($matchesTalk[0]) - 1;
        $talkerTg = $matchesTalk[1][$lastIdx];
        $talkerStartPos = strrpos($logContent, $matchesTalk[0][$lastIdx]);
        $talkerStopPos = strrpos($logContent, "Talker stop on TG");

        if ($talkerStartPos > $talkerStopPos) {
            $response['tg'] = $talkerTg;
            $response['callsign'] = $matchesTalk[2][$lastIdx];
        } else {
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
