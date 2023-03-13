<?php
    if(!session_id()) {
        session_start();
    }
    class User {
        private $id = NULL; //Connexion utiliser
        private $user_info = NULL; //Tableaux contient les information de utlisateur
        private $logged_in = false; //Utilisateur connecté
        private $tbname = "utilisateurs"; //nom de tableau(database) utiliser dans ce class
        private $bdd;
        private $login;
        private $password;
        private $email;

        public function __construct() {
            $options = [
                // turn off emulation mode for "real" prepared statements
                PDO::ATTR_EMULATE_PREPARES   => false, 
                //turn on errors in the form of exceptions
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
                //make the default fetch be an anonymous object with column names as properties
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, 
            ];
            $server_name = "localhost";
            $username = "root";
            $password = "";
            $dbname = "révisions";
            try {
                $this->bdd = new PDO("mysql:host=$server_name; dbname=$dbname", $username, 
                $password, $options);
                
            } catch(PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                die();
            }
        }


        // _________________________________________ Getters
        public function get_tbname() {
            return $this->tbname;
        }
        
        public function get_id() {
            return $this->id;
        }

        public function get_login() {
            return $this->login;
        }

        public function get_password() {
            return $this->password;
        }

        public function get_email() {
            return $this->email;
        }

        public function get_by_id($id) {
            $sql = "SELECT * FROM ".$this->get_tbname()." WHERE id = ?";
            $req = $this->bdd->prepare($sql);
            $req->execute([$id]);

            if($req->rowCount() == 0) {
                return false;
            }
            return $req->fetchObject();
        }

        public function is_logged() {
            return $this->logged_in;
        }

        // _________________________________________
        
        // _________________________________________ Setters

    }

    $user = new User;
