<?php
    require_once("inc/User.php");
    $user->redirect_if_not_logged();
?>


<?php
    require_once("inc/head.php");
    
    echo "<pre>";
        var_dump($user->get_user_info());
    echo "</pre>";
    
    require_once("inc/footer.php");
?>