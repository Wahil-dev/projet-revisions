<?php
    require_once("inc/User.php");
    if($user->connect(login: "bvb", password: "bvb")) {
        header("location: profile.php");
        exit();
    }