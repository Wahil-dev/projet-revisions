<?php
    class Bdd {
        public $server_name = "localhost";
        public $username = "root";
        public $password = "";
        public $dbname = "révisions";
        public function __construct() {
            $options = [
                // turn off emulation mode for "real" prepared statements
                PDO::ATTR_EMULATE_PREPARES   => false, 
                //turn on errors in the form of exceptions
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
                //make the default fetch be an anonymous object with column names as properties
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, 
            ];

            try {
                $bdd = new PDO("mysql:host=$this->server_name; dbname=$this->dbname", $this->username, $this->password, $options);
                return $bdd;
                
            } catch(PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                die();
            }
        }
    }
