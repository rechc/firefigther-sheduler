<?php session_start (); ?>
<html>
    <head>
        <title>Login</title>
    </head>

    <body>
        <?php
        if (isset($_REQUEST["fehler"])) {
            echo "Die Zugangsdaten waren ungueltig.";
        }
        ?>
        <form action="login.php" method="post">
            E-Mail: <input type="text" name="Mail" size="20"><br>
            Kennwort: <input type="password" name="Pwd" size="20"><br>
            <input type="submit" value="Login">
        </form>
    </body>  
</html>