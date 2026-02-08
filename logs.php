<?php
session_start();
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'pl';

$LL = [
    'pl' => [ 'no_data' => 'Brak danych.' ],
    'en' => [ 'no_data' => 'No data.' ]
];

$logFile = '/dev/shm/svxlink.log';

if (file_exists($logFile)) {

    $output = shell_exec("tail -n 100 $logFile | grep -v 'Distortion detected'");
    if ($output) {
        echo nl2br(htmlspecialchars($output));
    } else {
        echo $LL[$lang]['no_data'];
    }
} else {
    echo "Log file not found in RAM ($logFile)";
}
?>