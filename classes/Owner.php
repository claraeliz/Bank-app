<?php

/*
 * HINTS FOR ADDING OWNER CLASS:
 *
 * 1. Create an Owner class in classes/Owner.php with:
 *    - Private properties: $name, $email (optional), $phone (optional)
 *    - Constructor that takes $name and optional $email, $phone
 *    - Getter methods: getName(), getEmail(), getPhone()
 *    - Setter methods: setEmail(), setPhone()
 *    - __toString() method to display owner info nicely
 *
 * 2. In BankAccount class:
 *    - Add require_once 'Owner.php' at the top
 *    - Change constructor parameter from $owner (string) to Owner $owner (object)
 *    - Update __toString() to use $this->owner (will call Owner's __toString)
 *
 * 3. In SavingsAccount class:
 *    - Constructor already passes $owner to parent, so it will work with Owner objects
 *    - Update __toString() if needed to use Owner object
 *
 * 4. In index.php:
 *    - Create Owner objects: $owner1 = new Owner('Clara', 'clara@email.com');
 *    - Pass Owner objects to BankAccount/SavingsAccount constructors
 *    - Test with multiple owners/accounts
 */


    class Owner {
        private $name, $email, $phone;

        public function __construct($name, $email = null, $phone = null) {
            $this->name = $name;
            $this->email = $email;
            $this->phone = $phone;
        }

        function getName() {
           return $this -> name;
        }

        function getEmail() {
            return $this -> email;
        }

        function getPhone() {
            return $this -> phone;
        }

        function setEmail($email) {
            $this -> email = $email;
        }

        function setPhone($phone) {
            $this -> phone = $phone;
        }

        public function __toString() {
            $info = $this -> name;
            if($this -> email) $info .= " | Email: " . $this->email;
            if($this -> phone) $info .= " | Phone: " . $this->phone;
            return $info;
        }
    }
    