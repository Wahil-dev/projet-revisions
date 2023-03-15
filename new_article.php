<?php
    require_once("inc/User.php");
    require_once("inc/Article.php");
    require_once("inc/Categories.php");
    require_once("inc/Authentication.php");
    

    require_once("inc/head.php");
?>

    <form class="form" action="inc/b_new_form.php" method="post">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="inp">
        <span class="err-msg"><?php echo isset($_SESSION["titleErr"]) ? $_SESSION["titleErr"] : ""?></span>

        <?php Categories::display_categories()?>

        <span class="err-msg"><?php echo isset($_SESSION["categoryErr"]) ? $_SESSION["categoryErr"] : ""?></span>

        <label for="content">Content</label>
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
        <span class="err-msg"><?php echo isset($_SESSION["contentErr"]) ? $_SESSION["contentErr"] : ""?></span>

        <input type="submit" value="Post" class="btn-custom">
        <span class="err-msg"><?php echo isset($_SESSION["postErr"]) ? $_SESSION["postErr"] : ""?></span>
    </form>


<?php
    require_once("inc/footer.php");
    Authentication::delete_error_session();
?>
