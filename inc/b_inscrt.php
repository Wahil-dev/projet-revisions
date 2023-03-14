<?php
    require_once("User.php");
    require_once("Authentication.php");


    $login = $password = $cPassword = $email = "";
    $loginErr = $passwordErr = $cPasswordErr = $emailErr = "";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ________________ Login validation
        if(isset($_POST["login"]) && !empty($_POST["login"])) {
            if(strlen($_POST["login"]) > 2) {
                $login = Authentication::process_input($_POST["login"]);
            } else {
                $loginErr = "trois caractère en minimum !";
            }
        } else {
            $loginErr = "login requise !";
        }
        // ___________________________________

        // ________________ Email validation
        if(isset($_POST["email"]) && !empty($_POST["email"])) {
            if(strlen($_POST["email"]) > 2) {
                if(Authentication::is_valid_email($_POST["email"])) {
                    $email = Authentication::process_input($_POST["email"]);
                } else {
                    $emailErr = "Entrer un email valid !";
                }
            } else {
                $emailErr = "trois caractère en minimum !";
            }
        } else {
            $emailErr = "email requise !";
        }
        // ___________________________________

        // ________________ Password validation
        if(isset($_POST["password"]) && !empty($_POST["password"])) {
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
        } else {
            $passwordErr = "password requise !";
        }
        // ___________________________________

        // ________________ Confirm Password validation
        if(isset($_POST["cPassword"]) && !empty($_POST["cPassword"])) {
            if($_POST["cPassword"] === $_POST["password"]) {
                $cPassword = Authentication::process_input($_POST["cPassword"]);
            } else {
                $cPasswordErr = "Confirm password != password";
            }
        } else {
            $cPasswordErr = "Confirm password requise !";
        }
        // ___________________________________

        if(!empty($login) && !empty($password) && !empty($cPassword) && !empty($email)) {
            if($user->login_email_exist($login, $email)) {
                $_SESSION["identifierErr"] = "login or email déja utiliser";
                header("location: ../inscription.php");
                exit();
            } else {
                var_dump($password);
                if($user->register(login: $login, password: $password, email: $email)) {
                    header("location: ../connexion.php");
                    exit();
                }
            }
        } else {
            $_SESSION["loginErr"] = $loginErr;
            $_SESSION["emailErr"] = $emailErr;
            $_SESSION["passwordErr"] = $passwordErr;
            $_SESSION["cPasswordErr"] = $cPasswordErr;

            header("location: ../inscription.php");
            exit();
        }
    }
