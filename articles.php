<?php
    require_once("inc/User.php");
    require_once("inc/Article.php");
?>

<?php
    require_once("inc/head.php");
?>

    <?= Article::display_all_articles(isset($_GET["order"]) ? $_GET["order"] : NULL);?>

<?php
    require_once("inc/footer.php");
?>
