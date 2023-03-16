<?php
    require_once("User.php");
    require_once("Authentication.php");
    require_once("Article.php");

    $target_dir = "../assets/img/articles/";
    $title = $category_id = $content = "";
    $titleErr = $categoryErr = $contentErr = $postImageErr = "";

    $imageName = "";
    
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
            $category_id = Authentication::process_input($_POST["categories"]);
        } else {
            $categoryErr = "category requise !";
        }
        // ___________________________________

        // ________________ Image validation
        if(isset($_FILES["postImage"]) && $_FILES["postImage"]["error"] == 0) {
            // Check if the file was uploaded without errors
            $imageName = date('d-m-Y h-i-s a').basename($_FILES["postImage"]["name"]);
            $target_file = $target_dir . $imageName;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Check if the file is an image
            $check = getimagesize($_FILES["postImage"]["tmp_name"]);
            if($check !== false) {
                // Move the file to the uploads directory
                if(move_uploaded_file($_FILES["postImage"]["tmp_name"], $target_file)) {
                    // echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                } else {
                    $postImageErr = "Sorry, there was an error uploading your file.";
                }
            } else {
                $postImageErr = "File is not an image.";
            }
        } else {
            $postImageErr = "image requise !";
        }
        // ___________________________________

        // ________________ Content validation
        if(isset($_POST["content"]) && !empty($_POST["content"])) {
            $content = Authentication::process_input($_POST["content"]);
        } else {
            $contentErr = "content requise !";
        }
        // ___________________________________

        if(!empty($title) && !empty($category_id) && !empty($content) && empty($postImageErr)) {
            $new_article = new Article($title, $content, $imageName, $category_id);
            if($new_article) {
                header("location: ../articles.php");
                exit();
            }
        } else {
            $_SESSION["titleErr"] = $titleErr;
            $_SESSION["categoryErr"] = $categoryErr;
            $_SESSION["postImageErr"] = $postImageErr;
            $_SESSION["contentErr"] = $contentErr;

            header("location: ../article.php");
            exit();
        }
    }
