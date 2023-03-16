<?php
    if(!session_id()) {
        session_start();
    }
    require_once("Bdd.php");
    class User extends Bdd {
        private $bdd; //Connexion utiliser
        private $user_info = NULL; //Tableaux contient les information de utlisateur
        private $logged_in = false; //Utilisateur connecté
        private $tbname = "utilisateurs"; //nom de tableau(database) utiliser dans ce class
        private $errors = []; //Tableau d'erreurs

        public function __construct() {
            $this->bdd = Parent::__construct();

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
            $sql = "INSERT INTO ".$this->get_tbname()."(login, password, email) VALUES(?, ?, ?)";
            $req = $this->bdd->prepare($sql);
            $req->execute([$login, $password, $email]);
            return true;
        }

        public function connect(string $login, string $password) {
            $sql = "SELECT * FROM ".$this->get_tbname()." WHERE login = ? && password = ?";
            $req = $this->bdd->prepare($sql);
            $req->execute([$login, $password]);
            $res = $req->fetchObject();

            $this->logged_in = true;
            //Créez un ID de session à utiliser dans le constructeur pour vérifier s'il est déjà connecter pour une utilisation sur d'autres pages
            $_SESSION["user_id"] = $res->id;
            return true;
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
                $this->errors[] = "login not found / compte supprimer";
                return NULL;
            }
            return $req->fetchObject();
        }


        // _________________________________________
        
        // _________________________________________ Setters
        public function set_login($login) {
            $this->update(["login", $login]);
            return $this;
        }
        
        
        public function set_email($email) {
            $this->update(["email", $email]);
            return $this;
        }
        
        
        public function set_password($password) {
            $this->update(["password", $password]);
            return $this;
        }
        
        
        
        
        
        // _________________________________________ Other Method
        public function update(array $column) {
            $column_name = $column[0];
            $new_value = $column[1];
            $user_id = $this->get_id();
            $sql = "UPDATE ".$this->get_tbname()." SET $column_name = ? WHERE id = $user_id";
            $req = $this->bdd->prepare($sql);
            $req->execute([$new_value]);
            return true;
        }

        public function is_logged() {
            return $this->logged_in;
        }

        public function is_exist($login, $password) {
            $sql = "SELECT * FROM ".$this->get_tbname()." WHERE login = ? && password = ?";
            $req = $this->bdd->prepare($sql);
            $req->execute([$login, $password]);

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

        public function login_email_exist($login = '', $email = '') {
            $sql = "SELECT * FROM ".$this->get_tbname(). " WHERE login = ? || email = ?";
            $req = $this->bdd->prepare($sql);
            $req->execute([$login, $email]);

            return !empty($req->fetchObject());
        }

        public function display_user_profile() {
            ?>
            <section class="content">
                <article class="profile flex-c">
                    <h3>Profile</h3>
                    <div class="img-box">
                        <img src="" alt="profile-image">
                    </div>
                    <div class="info">
                        <p>Login : <?= $this->get_login()?></p>
                        <p>Email : <?= $this->get_email()?></p>
                        <p>Date d'Inscription : <?= $this->get_register_date()?></p>
                        <p>Password : <?= $this->get_password()?></p>
                    </div>
                </article>
                <form class="form" action="inc/edit_profile.php" method="post">
                    <input type="text" name="login" id="login" class="inp" placeholder="login">
                    <span class="err-msg"><?php echo isset($_SESSION["loginErr"]) ? $_SESSION["loginErr"] : ""?></span>

                    <input type="email" name="email" id="email" class="inp" placeholder="email">
                    <span class="err-msg"><?php echo isset($_SESSION["emailErr"]) ? $_SESSION["emailErr"] : ""?></span>

                    <input type="password" name="password" id="password" class="inp" placeholder="password">
                    <span class="err-msg"><?php echo isset($_SESSION["passwordErr"]) ? $_SESSION["passwordErr"] : ""?></span>


                    <input type="submit" value="Update" class="btn-custom">
                    <span class="err-msg"><?php echo isset($_SESSION["identifierErr"]) ? $_SESSION["identifierErr"] : ""?></span>
                </form>
            </section>
    <?php }
    }

    $user = new User;
    