<?php
    require_once("inc/User.php");
    require_once("inc/Article.php");

    $article = Article::get_all_articles();
?>
<?php
    require_once("inc/head.php");

    Article::display_all_articles();

    require_once("inc/footer.php");
?>
