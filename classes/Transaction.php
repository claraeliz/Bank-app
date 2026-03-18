<?php


/*
 * HINTS FOR ADDING TRANSACTION LOGGING:
 *
 * 1. Create a Transaction class in classes/Transaction.php with:
 *    - Private properties: $amount, $type (e.g., 'deposit' or 'withdraw'), $timestamp
 *    - Constructor that takes $amount and $type, sets timestamp to current date/time
 *    - Getter methods for each property
 *    - __toString() method to display the transaction nicely
 *
 * 2. In BankAccount class:
 *    - Add a protected $transactions array to store Transaction objects
 *    - In deposit() method: after updating balance, create new Transaction('deposit', $amount) and add to $transactions
 *    - In withdraw() method: after updating balance, create new Transaction('withdraw', $amount) and add to $transactions
 *    - Add a getTransactions() method to return the $transactions array
 *
 * 3. Don't forget to require_once 'Transaction.php' at the top of this file
 *
 * 4. For timestamp, use: $this->timestamp = date('Y-m-d H:i:s');
 */


class Transaction {
    private $amount, $type, $timestamp;

    function __construct( $amount, $type) {
        $this->amount = $amount;
        $this->type = $type;
        $this->timestamp = date('Y-m-d H:i:s');
    }

    function getAmount() {
        return $this->amount;
    }

    function getType() {
        return $this->type;
    }

    function getTimestamp() {
        return $this->timestamp;
    }

    function __toString() {
        return 'Amount: ' . $this->amount . ' | Type: ' . $this->type . ' | Timestamp: ' . $this->timestamp;
    }
}