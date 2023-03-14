<?php
    require_once("User.php");
    require_once("Authentication.php");


    $login = $password = "";
    $loginErr = $passwordErr = "";
    
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

        // ________________ Password validation
        if(isset($_POST["password"]) && !empty($_POST["password"])) {
            if(Authentication::is_valid($_POST["password"])) {
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

        if(!empty($login) && !empty($password)) {
            if($user->is_exist($login, $password)) {
                if($user->connect(login: $login, password: $password)) {
                    header("location: ../profile.php");
                    exit();
                }
            } else {
                $_SESSION["identifierErr"] = "user not found / erreur identifiant";
                header("location: ../connexion.php");
                exit();
            }
        } else {
            $_SESSION["loginErr"] = $loginErr;
            $_SESSION["passwordErr"] = $passwordErr;

            header("location: ../connexion.php");
            exit();
        }
    }
