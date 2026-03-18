<?php

/*
 * HINTS FOR CREATING THE DEBIT CARD CLASS:
 *
 * 1. Create a DebitCard class with these private properties:
 *    - $cardNumber       (string, 16-digit, generated in constructor)
 *    - $owner            (Owner object, the cardholder)
 *    - $linkedAccount    (BankAccount object, money is drawn from here instantly on charge)
 *    - $expiryDate       (string, set to 3 years from now: date('Y-m-d', strtotime('+3 years')))
 *    - $isActive         (bool, true by default)
 *
 * 2. Constructor takes: Owner $owner, BankAccount $linkedAccount
 *    - Assign all properties
 *    - Generate $cardNumber with a loop: for ($i = 0; $i < 16; $i++) { $this->cardNumber .= random_int(0, 9); }
 *    - Set $expiryDate and $isActive with their defaults
 *
 * 3. Add these methods:
 *    - charge($amount)     — if active, call $linkedAccount->withdraw($amount); else echo "Card is frozen!"
 *    - freeze()            — set $isActive to false
 *    - unfreeze()          — set $isActive to true
 *    - getBalance()        — return $linkedAccount->getBalance() (card balance = account balance)
 *    - getCardNumber()     — return $cardNumber
 *    - isActive()          — return $isActive
 *
 * 4. Add a __toString() method, e.g.:
 *    "Card: XXXX-XXXX-XXXX-1234 | Owner: Clara | Balance: 500 | Expires: 2029-03-17 | Status: Active"
 *    Tip: mask the card number showing only the last 4 digits (use substr($this->cardNumber, -4))
 *
 * 5. Don't forget to require_once 'Owner.php' and require_once 'BankAccount.php' at the top
 *
 * 6. Test it in index.php like:
 *    $card = new DebitCard($owner1, $obj1);
 *    $card->charge(300);   // should reduce $obj1 balance by 300 immediately
 *    echo $card;           // should show updated balance
 *    $card->freeze();
 *    $card->charge(100);   // should echo an error — card is frozen
 */

    require_once 'BankAccount.php';
    require_once 'Owner.php';

    class DebitCard {
        function __construct(Owner $owner, BankAccount $linkedAccount) {

            $this->cardNumber = '';

            for ($i = 0; $i < 16; $i++) {
                $this->cardNumber .= random_int(0, 9);
            }
            $this->owner = $owner;
            $this->linkedAccount = $linkedAccount;
            $this->expiryDate = date('Y-m-d', strtotime('+3 years'));
            $this->isActive = true;
        }

        function charge($amount) {
            if($this->isActive) {
                $this->linkedAccount->withdraw($amount);
            } else {
                echo "Card is frozen!";
            }
        }

        function freeze(){
            $this->isActive = false;
        }

        function unfreeze(){
            $this->isActive = true;
        }

        function getBalance() {
            return $this->linkedAccount->getBalance();
        }

        function getCardNumber() {
            return $this->cardNumber;
        }

        function getExpiryDate() {
            return $this->expiryDate;
        }

        function isActive() {
            return $this->isActive;
        }

        function __toString() {
            return 'Card: ' . $this->cardNumber . '| Owner: ' . $this->owner. ' | Balance: ' .  $this->linkedAccount->getBalance() . ' | Expires: ' . $this->expiryDate . ' | Status: ' . ($this->isActive ? 'Active' : 'Frozen') . '<br>';
        }

    }