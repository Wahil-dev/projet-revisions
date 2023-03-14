<?php
    class Bdd {
        private $server_name = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "révisions";

        public function __construct() {
            return $this->get_conn();
        }

        public static function get_conn() {
            $server_name = "localhost";
            $username = "root";
            $password = "";
            $dbname = "révisions";
            $options = [
                // turn off emulation mode for "real" prepared statements
                PDO::ATTR_EMULATE_PREPARES   => false, 
                //turn on errors in the form of exceptions
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
                //make the default fetch be an anonymous object with column names as properties
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, 
            ];

            try {
                $bdd = new PDO("mysql:host=$server_name; dbname=$dbname", $username, $password, $options);
                return $bdd;
                
            } catch(PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                die();
            }
        }
    }
