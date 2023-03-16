<?php
    require_once("inc/User.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mQuery.css">
    <style>
		.container {
			min-height: calc(100vh - 70px - 70px);
		}
	</style>
</head>
<body>
    <header class="flex-r">
        <a href="index.php"><?= $user->is_logged() ? $user->get_login() : "visiteur"?></a>
        <nav>
            <?php if($user->is_logged()) : ?>
                <ul class="menu flex-r">
                    <li><a href="index.php">acceuil</a></li>
                    <li><a href="articles.php">articles</a></li>
                    <li><a href="profile.php">profile</a></li>
                    <li><a href="article.php">new_article</a></li>
                    <li><a href="new_category.php">new_category</a></li>
                    <li><a href="inc/deconnexion.php">déconnexion</a></li>
                </ul>
            <?php else :?>
                <ul class="menu flex-r">
                    <li><a href="index.php">acceuil</a></li>
                    <li><a href="articles.php">articles</a></li>
                    <li><a href="connexion.php">connexion</a></li>
                    <li><a href="inscription.php">inscription</a></li>
                </ul>
            <?php endif ?>
        </nav>
    </header>
    <div class="container flex-r">