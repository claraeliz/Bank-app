<?php
require_once 'includes/bootstrap.php';

if ($selectedIdx === null) {
    header('Location: index.php');
    exit;
}

$card->freeze();
saveSession($accounts, $cards, $wallets);
header('Location: index.php');
exit;
