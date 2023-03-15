<?php
    require_once("User.php");
    require_once("Authentication.php");
    require_once("Categories.php");


    $name = "";
    $nameErr = "";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ________________ Title validation
        if(isset($_POST["name"]) && !empty($_POST["name"])) {
            $name = Authentication::process_input($_POST["name"]);
        } else {
            $nameErr = "name requise !";
        }
        // ___________________________________

        if(!empty($name)) {
            if(Categories::is_exist($name)) {
                $nameErr = "category exist déja !";
                header("location: ../new_category.php");
                exit();
            }
            $new_category = new Categories($name);
            if($new_category) {
                header("location: ../articles.php");
                exit();
            }
        } else {
            $_SESSION["nameErr"] = $nameErr;

            header("location: ../new_category.php");
            exit();
        }
    }
