<?php
    require_once("inc/User.php");
    require_once("inc/Authentication.php");
    $user->redirect_if_logged();
?>
<?php require_once("inc/head2.php")?>
        <form class="form" action="inc/b_conn.php" method="post">
            <input type="text" name="login" id="login" class="inp">
            <span class="err-msg"><?php echo isset($_SESSION["loginErr"]) ? $_SESSION["loginErr"] : ""?></span>

            <input type="password" name="password" id="password" class="inp">
            <span class="err-msg"><?php echo isset($_SESSION["passwordErr"]) ? $_SESSION["passwordErr"] : ""?></span>

            <input type="submit" value="connexion" class="btn-custom">
            <span class="err-msg"><?php echo isset($_SESSION["identifierErr"]) ? $_SESSION["identifierErr"] : ""?></span>
        </form>
        <p>vous-etez déja inscrit <a href="inscription.php">inscription</a></p>
    </div>
</body>
</html>

<?php
    Authentication::delete_error_session();
?>