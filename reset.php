<?php
session_start();
session_destroy();

$dataFile = __DIR__ . '/data/bankdata.dat';
if (file_exists($dataFile)) {
    unlink($dataFile);
}

header('Location: index.php');
exit;
