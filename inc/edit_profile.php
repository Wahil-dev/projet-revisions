<?php
    require_once("User.php");
    require_once("Authentication.php");

    $login = $password = $email = "";
    $loginErr = $passwordErr = $emailErr = "";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ________________ Login validation
        if(isset($_POST["login"])) {
            if(!empty($_POST["login"])) {
                if(strlen($_POST["login"]) > 2) {
                    $login = Authentication::process_input($_POST["login"]);
                } else {
                    $loginErr = "trois caractère en minimum !";
                }
            }
        } else {
            $loginErr = "login requise !";
        }
        // ___________________________________

        // ________________ Email validation
        if(isset($_POST["email"])) {
            if(!empty($_POST["email"])) {//si on veut modifier on check si la valeur est valid
                if(strlen($_POST["email"]) > 2) {
                    if(Authentication::is_valid_email($_POST["email"])) {
                        $email = Authentication::process_input($_POST["email"]);
                    } else {
                        $emailErr = "Entrer un email valid !";
                    }
                } else {
                    $emailErr = "trois caractère en minimum !";
                }
            }
        } else {
            $emailErr = "email requise !";
        }
        // ___________________________________

        // ________________ password validation
        if(isset($_POST["password"])) {
            if(!empty($_POST["password"])) {
                if(Authentication::is_valid_password($_POST["password"])) {
                    $password = Authentication::process_input($_POST["password"]);
                } else {
                    $passwordErr = "
                    * 8 caractère en minimum !
                    * 1 caractère au miniscule
                    * 1 caractère au majuscule
                    * 1 caractère spécieux
                    * 1 chifre en minimum
                    ";
                }
            }
        } else {
            $passwordErr = "password requise !";
        }
        // ___________________________________

        if(!empty($login)) {
            if($user->login_email_exist(login: $login)) {
                $_SESSION["identifierErr"] = "login déja utiliser";
            } else {
                $user->set_login($login);
            }
        } else {
        }

        if(!empty($email)) {
            if($user->login_email_exist(email: $email)) {
                $_SESSION["identifierErr"] = " email déja utiliser";
            } else {
                $user->set_email($email);
            }
        }

        if(!empty($password)) {
            $user->set_password($password);
        }


        if(!empty($loginErr)) {
            $_SESSION["loginErr"] = $loginErr;
        }

        if(!empty($emailErr)) {
            $_SESSION["emailErr"] = $emailErr;
        }

        if(!empty($passwordErr)) {
            $_SESSION["passwordErr"] = $passwordErr;
        }

        header("location: ../profile.php");
        exit();
    }
