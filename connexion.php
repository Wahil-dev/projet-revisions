<?php
    require_once("User.php");
    if($user->connect(login: "bvb", password: "bvb")) {
        header("location: profile.php");
        exit();
    }