<?php

/*
 * HINTS FOR CREATING THE TRANSFER CLASS:
 *
 * 1. Create a Transfer class with:
 *    - Private properties: $amount, $fromAccount, $toAccount, $timestamp
 *    - Constructor that takes $amount, BankAccount $fromAccount, BankAccount $toAccount
 *    - Set $timestamp to current date/time in the constructor
 *    - Getter methods for each property: getAmount(), getFromAccount(), getToAccount(), getTimestamp()
 *    - __toString() to display the transfer nicely (e.g. "Transferred: 200 | From: Clara | To: Bongo | At: 2026-01-01 12:00:00")
 *
 * 2. Add a transfer() method inside BankAccount class (not here):
 *    - Signature: function transfer($amount, BankAccount $target)
 *    - Check that $amount > 0 and $amount <= $this->balance before proceeding
 *    - Call $this->withdraw($amount) and $target->deposit($amount)
 *    - Create a new Transfer object and store it (you could log it in $this->transactions)
 *    - If funds are insufficient, echo an error message and return early
 *
 * 3. Don't forget to require_once 'Transfer.php' at the top of BankAccount.php
 *
 * 4. Test it in index.php like:
 *    $obj1->transfer(200, $obj2);
 *    Then print both accounts' transactions to verify both sides are recorded
 */


    class Transfer {
        private $amount, $fromAccount, $toAccount, $timestamp;

        function __construct($amount, BankAccount $fromAccount, BankAccount $toAccount) {
            $this->amount = $amount;
            $this->fromAccount = $fromAccount;
            $this->toAccount = $toAccount;
            $this->timestamp = date('Y-m-d H:i:s');
        }

        function getAmount() {
            return $this->amount;
        }

        function getFromAccount() {
            return $this->fromAccount;
        }

        function getToAccount() {
            return $this->toAccount;
        }

        function getTimestamp() {
            return $this->timestamp;
        }

        public function __toString() {
            return 'Transferred: ' . $this->amount . ' | ' . 'From: ' . $this -> fromAccount. ' | ' . 'To: ' . $this -> toAccount. ' | ' . 'At: ' . $this -> timestamp;
        }
    }

