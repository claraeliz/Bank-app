<?php

    require_once __DIR__ . '/Owner.php';
    
    class SavingsAccount extends BankAccount {
        protected Owner $owner;
        private $interestRate;

        function __construct(Owner $owner, $balance, $interestRate) {
            parent::__construct($owner, $balance);
            $this->interestRate = $interestRate;
        }

        function applyInterest() {
            $this -> balance += $this -> balance * $this -> interestRate;
            // return $this -> balance;
        }

        function getInterestRate() {
            return $this->interestRate;
        }

        public function __toString() {
            return 'Owner: ' . $this -> owner . ' | ' . 'Balance: ' . $this -> balance . ' | ' . 'Interest Rate: ' . $this -> interestRate;
        }
    }
