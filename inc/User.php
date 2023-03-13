<?php
    if(!session_id()) {
        session_start();
    }
    class User {
        private $bdd; //Connexion utiliser
        private $user_info = NULL; //Tableaux contient les information de utlisateur
        private $logged_in = false; //Utilisateur connecté
        private $tbname = "utilisateurs"; //nom de tableau(database) utiliser dans ce class
        private $errors = []; //Tableau d'erreurs

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

            //si l'id trouvé c'est a dire qui'il est déja connecter
            if(isset($_SESSION["user_id"])) {
                //Obtenir les identifiants de l'utilisateur d'apres son id
                $this->user_info = $this->get_by_id($_SESSION["user_id"]);

                if($this->user_info != NULL) {
                    $this->logged_in = true;
                }
            }
        }

        public function register(string $login, string $email, string $password) {
            if($this->is_exist($login)) {
                $this->errors[] = "login déja utiliser !";
                return false;
            }

            $sql = "INSERT INTO ".$this->get_tbname()."(login, password, email) VALUES(?, ?, ?)";
            $req = $this->bdd->prepare($sql);
            $req->execute([$login, $email, $password]);
            return true;
        }

        public function connect(string $login, string $password) {
            //
            if(!$this->is_exist($login)) {
                $this->errors[] = "user not found";
                return false;
            }

            $sql = "SELECT * FROM ".$this->get_tbname()." WHERE login = ? && password = ?";
            $req = $this->bdd->prepare($sql);
            $req->execute([$login, $password]);
            $res = $req->fetchObject();

            if($req->rowCount()) {
                $this->logged_in = true;
                //Créez un ID de session à utiliser dans le constructeur pour vérifier s'il est déjà 
                //connecter pour une utilisation sur d'autres pages
                $_SESSION["user_id"] = $res->id;
                return true;
            } 
            $this->errors[] = "error identifiant !";
            return false;
        }

        // _________________________________________ Getters
        public function get_tbname() {
            return $this->tbname;
        }
        
        public function get_id() {
            return $this->user_info->id;
        }

        public function get_login() {
            return $this->user_info->login;
        }

        public function get_password() {
            return $this->user_info->password;
        }

        public function get_email() {
            return $this->user_info->email;
        }

        public function get_register_date() {
            return $this->user_info->register_date;
        }

        public function get_user_info() {
            return $this->user_info;
        }

        public function get_by_id($id) {
            $sql = "SELECT * FROM ".$this->get_tbname()." WHERE id = ?";
            $req = $this->bdd->prepare($sql);
            $req->execute([$id]);

            if($req->rowCount() == 0) {
                $this->errors[] = "login not found";
                return NULL;
            }
            return $req->fetchObject();
        }

        public function get_errors() {
            return $this->errors;
        }

        // _________________________________________
        
        // _________________________________________ Setters


        public function is_logged() {
            return $this->logged_in;
        }

        public function is_exist($login) {
            $sql = "SELECT * FROM ".$this->get_tbname()." WHERE login = ?";
            $req = $this->bdd->prepare($sql);
            $req->execute([$login]);

            if($req->rowCount() == 0) {
                return false;
            }
            return true;
        }

        public function disconnect() {
            unset($_SESSION["user_id"]);
            header("location: ../index.php");
            exit();
        }

        //pour la redirection (s'il est connecter ou s'il n'est pas connecter)
        public function redirect_if_logged() {
            if(isset($_SESSION["user_id"])) {
                header("location: index.php");
                exit();
            }
        }

        //on l'utilise sur les pages accesibles pour les utilisateurs connecter comme (profile)
        public function redirect_if_not_logged() {
            if(!isset($_SESSION["user_id"])) {
                header("location: index.php");
                exit();
            }
        }
    }

    $user = new User;
    