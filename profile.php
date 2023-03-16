<?php
    require_once("inc/User.php");
    require_once("inc/Authentication.php");
    $user->redirect_if_not_logged();
?>


<?php
    require_once("inc/head.php");

    $user->display_user_profile();
    
    require_once("inc/footer.php");
    Authentication::delete_error_session();
?>