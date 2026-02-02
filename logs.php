<?php
session_start();
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'pl';

$LL = [
    'pl' => [
        'no_data' => 'Brak danych lub problem z uprawnieniami (sudo).'
    ],
    'en' => [
        'no_data' => 'No data or permission problem (sudo).'
    ]
];

$output = shell_exec('sudo /usr/bin/tail -n 300 /var/log/svxlink | grep -v "Distortion detected"');

if ($output) {
    echo nl2br(htmlspecialchars($output));
} else {
    echo $LL[$lang]['no_data'];
}
?>
