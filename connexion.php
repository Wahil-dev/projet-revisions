<?php
    require_once("inc/User.php");
    $user->redirect_if_logged();
    if($user->connect(login: "bvb", password: "bvb")) {
        header("location: profile.php");
        exit();
    }