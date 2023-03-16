<?php
    require_once("inc/User.php");
    require_once("inc/Article.php");
?>

<?php
    require_once("inc/head.php");
?>

    <?= Article::display_article(isset($_GET["article_id"]) ? $_GET["article_id"] : NULL);?>

<?php
    require_once("inc/footer.php");
?>
