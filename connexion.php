<?php
    require_once("inc/User.php");
    require_once("inc/Authentication.php");
    $user->redirect_if_logged();
?>
<?php require_once("inc/head2.php")?>
        <a href="index.php" class="abs-lien">Acceuil</a>
        <div class="box-form">
            <h2 class="title">Connexion</h2>
            <form class="form" action="inc/b_conn.php" method="post">
                <input type="text" name="login" id="login" class="inp" placeholder="Login">
                <span class="err-msg"><?php echo isset($_SESSION["loginErr"]) ? $_SESSION["loginErr"] : ""?></span>
    
                <input type="password" name="password" id="password" class="inp" placeholder="Password">
                <span class="err-msg"><?php echo isset($_SESSION["passwordErr"]) ? $_SESSION["passwordErr"] : ""?></span>
    
                <input type="submit" value="connexion" class="btn-custom btn-submit">
                <span class="err-msg"><?php echo isset($_SESSION["identifierErr"]) ? $_SESSION["identifierErr"] : ""?></span>
            </form>
            <p>vous-etez déja inscrit <a href="inscription.php">inscription</a></p>
        </div>
        </div>
</body>
</html>

<?php
    Authentication::delete_error_session();
?>