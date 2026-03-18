<?php

require_once __DIR__ . '/../classes/Transactable.php';
require_once __DIR__ . '/../classes/Transaction.php';
require_once __DIR__ . '/../classes/Owner.php';
require_once __DIR__ . '/../classes/BankAccount.php';
require_once __DIR__ . '/../classes/SavingsAccount.php';
require_once __DIR__ . '/../classes/DebitCard.php';
require_once __DIR__ . '/../classes/Transfer.php';

define('DATA_FILE', __DIR__ . '/../data/bankdata.dat');

session_start();

if (!isset($_SESSION['accounts'])) {
    if (file_exists(DATA_FILE)) {
        $saved                 = unserialize(file_get_contents(DATA_FILE));
        $_SESSION['accounts']  = $saved['accounts'];
        $_SESSION['cards']     = $saved['cards'];
        $_SESSION['wallets']   = $saved['wallets'];
    } else {
        $owner1 = new Owner('Clara', 'clara@email.com');
        $owner2 = new Owner('Bongo', 'bongo@email.com');
        $owner3 = new Owner('Alice', 'alice@email.com');

        $acc0 = new BankAccount($owner1, 1500);
        $acc1 = new BankAccount($owner2, 1000);
        $acc2 = new BankAccount($owner3, 2000);

        $_SESSION['accounts'] = [$acc0, $acc1, $acc2];
        $_SESSION['cards']    = [
            new DebitCard($owner1, $acc0),
            new DebitCard($owner2, $acc1),
            new DebitCard($owner3, $acc2),
        ];
        $_SESSION['wallets']  = [
            new BankAccount(new Owner("Clara's Wallet"),  5000),
            new BankAccount(new Owner("Bongo's Wallet"),  5000),
            new BankAccount(new Owner("Alice's Wallet"),  5000),
        ];

        saveData($_SESSION['accounts'], $_SESSION['cards'], $_SESSION['wallets']);
    }

    $_SESSION['selected_idx'] = null;
}

$accounts    = $_SESSION['accounts'];
$cards       = $_SESSION['cards'];
$wallets     = $_SESSION['wallets'];
$selectedIdx = $_SESSION['selected_idx'] ?? null;

$account = ($selectedIdx !== null) ? $accounts[$selectedIdx] : null;
$card    = ($selectedIdx !== null) ? $cards[$selectedIdx]    : null;
$wallet  = ($selectedIdx !== null) ? $wallets[$selectedIdx]  : null;

function saveData(array $accounts, array $cards, array $wallets): void {
    $dir = dirname(DATA_FILE);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents(DATA_FILE, serialize([
        'accounts' => $accounts,
        'cards'    => $cards,
        'wallets'  => $wallets,
    ]));
}

function saveSession(array $accounts, array $cards, array $wallets): void {
    $_SESSION['accounts'] = $accounts;
    $_SESSION['cards']    = $cards;
    $_SESSION['wallets']  = $wallets;
    saveData($accounts, $cards, $wallets);
}
