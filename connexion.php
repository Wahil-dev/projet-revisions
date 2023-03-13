<?php
    require_once("inc/User.php");
    $user->redirect_if_logged();
?>
<?php require_once("inc/head2.php")?>
        <form class="form" action="inc/b_conn.php">
            <input type="text" name="login" id="login" class="inp">
            <input type="password" name="password" id="password" class="inp">

            <input type="submit" value="connexion" class="btn-custom">
        </form>
    </div>
</body>
</html>
