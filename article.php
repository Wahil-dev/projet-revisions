<?php
    require_once("inc/User.php");
    require_once("inc/Article.php");
    require_once("inc/Categories.php");
    require_once("inc/Authentication.php");
    
    $user->redirect_if_not_logged();
    require_once("inc/head.php");
?>
    <div class="box-form content-box">
        <form class="form" action="inc/b_new_article.php" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="inp">
            <span class="err-msg"><?php echo isset($_SESSION["titleErr"]) ? $_SESSION["titleErr"] : ""?></span>

            <?php Categories::display_categories()?>
            <span class="err-msg"><?php echo isset($_SESSION["categoryErr"]) ? $_SESSION["categoryErr"] : ""?></span>

            <input type="file" name="postImage" id="postImage" class="inp">
            <span class="err-msg"><?php echo isset($_SESSION["postImageErr"]) ? $_SESSION["postImageErr"] : ""?></span>

            <textarea name="content" id="content" cols="30" rows="10" class="inp" placeholder="Content ..."></textarea>
            <span class="err-msg"><?php echo isset($_SESSION["contentErr"]) ? $_SESSION["contentErr"] : ""?></span>

            <input type="submit" value="Post" class="btn-custom">
            <span class="err-msg"><?php echo isset($_SESSION["postErr"]) ? $_SESSION["postErr"] : ""?></span>
        </form>
    </div>
<?php
    require_once("inc/footer.php");
    Authentication::delete_error_session();
?>
