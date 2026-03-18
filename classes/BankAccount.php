<?php

    require_once __DIR__ . '/Owner.php';
    require_once __DIR__ . '/Transaction.php';
    require_once __DIR__ . '/Transfer.php';

    class BankAccount implements Transactable {
        protected Owner $owner;
        protected float $balance;
        protected $transactions= [];

        function __construct (Owner $owner, $balance) {
            $this -> owner = $owner;
            $this -> balance = $balance;

        }

        function deposit($amount) {
            if($amount > 0) {
                $this-> balance += $amount;
                $this -> transactions[] = new Transaction($amount, 'deposit');
            }
        }

        function withdraw($amount) {
            if($amount < $this -> balance) {
                $this-> balance -= $amount;
                $this -> transactions[]= new Transaction($amount, 'withdraw');
            } else {
                echo "Not enough funds!<br>";
            }
        }

        function getTransactions() {
            return $this-> transactions;
        }

        function getBalance() {
            return $this-> balance;
        }

        function getOwner() {
            return $this->owner;
        }

        function receiveTransfer($amount, BankAccount $from): void {
            $this->balance += $amount;
            $this->transactions[] = new Transfer($amount, $from, $this);
        }

        function transfer($amount, BankAccount $target) {

            if($amount > 0 && $amount <= $this->balance) {
                $this->balance -= $amount;
                $target->receiveTransfer($amount, $this);
                $this->transactions[] = new Transfer($amount, $this, $target);
            } else {
                echo "Insufficient funds!";
                return;
            }

        }

        public function __toString() {
            return 'Owner: ' . $this->owner . ' | ' . 'Balance: ' . $this -> balance;
        }


    }
