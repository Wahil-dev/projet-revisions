<?php
    require_once("inc/User.php");
    require_once("inc/Article.php");
?>

<?php
    require_once("inc/head.php");
?>
    <section class="content">
        <a href="?order=ASC">ASC</a>
        <a href="?order=DESC">DESC</a>
        <?= Article::display_all_articles(isset($_GET["order"]) ? $_GET["order"] : NULL);?>
    </section>

<?php
    require_once("inc/footer.php");
?>
