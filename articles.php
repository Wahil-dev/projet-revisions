<?php
    require_once("inc/User.php");
    require_once("inc/Article.php");
?>

<?php
    require_once("inc/head.php");

    Article::display_all_articles();

    require_once("inc/footer.php");
?>
