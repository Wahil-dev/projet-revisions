<?php
    require_once("inc/User.php");
    require_once("inc/Categories.php");
    require_once("inc/Authentication.php");
    
    $user->redirect_if_not_logged();
    require_once("inc/head.php");
?>

    <form class="form" action="inc/b_new_category.php" method="post">
        <label for="name">name</label>
        <input type="text" name="name" id="name" class="inp">
        <span class="err-msg"><?php echo isset($_SESSION["nameErr"]) ? $_SESSION["nameErr"] : ""?></span>

        <input type="submit" value="Post" class="btn-custom">
        <span class="err-msg"><?php echo isset($_SESSION["postErr"]) ? $_SESSION["postErr"] : ""?></span>
    </form>


<?php
    require_once("inc/footer.php");
    Authentication::delete_error_session();
?>
