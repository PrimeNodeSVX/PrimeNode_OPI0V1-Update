<?php
header('Content-Type: application/json');

$url = ''; 

$configFile = '/var/www/html/radio_config.json';
if (file_exists($configFile)) {
    $config = json_decode(file_get_contents($configFile), true);
    if (isset($config['node_api_url']) && !empty($config['node_api_url'])) {
        $url = $config['node_api_url'];
    }
}

if (empty($url)) {
    echo json_encode([]);
    exit;
}

$ctx = stream_context_create(array(
    'http' => array(
        'timeout' => 2 
    )
));

$json = @file_get_contents($url, false, $ctx);

if ($json === FALSE) {
    echo json_encode([]);
} else {
    echo $json;
}
?>