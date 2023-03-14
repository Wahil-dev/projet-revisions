<?php
    require_once("User.php");
    require_once("Authentication.php");
    require_once("Article.php");


    $title = $category = $content = "";
    $titleErr = $categoryErr = $contentErr = "";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ________________ Title validation
        if(isset($_POST["title"]) && !empty($_POST["title"])) {
            $title = Authentication::process_input($_POST["title"]);
        } else {
            $titleErr = "title requise !";
        }
        // ___________________________________

        // ________________ Category validation
        if(isset($_POST["categories"]) && !empty($_POST["categories"])) {
            $category = Authentication::process_input($_POST["categories"]);
        } else {
            $categoryErr = "category requise !";
        }
        // ___________________________________

        // ________________ Content validation
        if(isset($_POST["content"]) && !empty($_POST["content"])) {
            $content = Authentication::process_input($_POST["content"]);
        } else {
            $contentErr = "content requise !";
        }
        // ___________________________________

        if(!empty($title) && !empty($category) && !empty($content)) {
            $new_article = new Article($title, $category, $content, "image path");
            if($new_article) {
                header("location: ../articles.php");
                exit();
            }
        } else {
            $_SESSION["titleErr"] = $titleErr;
            $_SESSION["categoryErr"] = $categoryErr;
            $_SESSION["contentErr"] = $contentErr;

            header("location: ../new_article.php");
            exit();
        }
    }
