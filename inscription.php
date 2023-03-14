<?php
    require_once("inc/User.php");
    require_once("inc/Authentication.php");
    $user->redirect_if_logged();
?>
<?php require_once("inc/head2.php")?>
        <form class="form" action="inc/b_inscrt.php" method="post">
            <input type="text" name="login" id="login" class="inp" placeholder="Login">
            <span class="err-msg"><?php echo isset($_SESSION["loginErr"]) ? $_SESSION["loginErr"] : ""?></span>

            <input type="email" name="email" id="email" class="inp" placeholder="Email">
            <span class="err-msg"><?php echo isset($_SESSION["emailErr"]) ? $_SESSION["emailErr"] : ""?></span>

            <input type="password" name="password" id="password" class="inp" placeholder="Password">
            <span class="err-msg"><?php echo isset($_SESSION["passwordErr"]) ? $_SESSION["passwordErr"] : ""?></span>

            <input type="password" name="cPassword" id="cPassword" class="inp" placeholder="Confirm Password">
            <span class="err-msg"><?php echo isset($_SESSION["cPasswordErr"]) ? $_SESSION["cPasswordErr"] : ""?></span>

            <input type="submit" value="inscription" class="btn-custom">
            <span class="err-msg"><?php echo isset($_SESSION["identifierErr"]) ? $_SESSION["identifierErr"] : ""?></span>
        </form>
        <p>vous n'etez pas inscrit <a href="connexion.php">connexion</a></p>

    </div>
</body>
</html>

<?php
    Authentication::delete_error_session();
?>