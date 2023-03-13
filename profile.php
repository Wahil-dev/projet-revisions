<?php
    require_once("inc/User.php");
    $user->redirect_if_not_logged();
    echo "<pre>";
        var_dump($user->get_user_info());
    echo "</pre>";
?>

<a href="inc/deconnexion.php">déconnexion</a>