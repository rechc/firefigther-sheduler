<?php session_start (); ?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="./css/login_style.css" />
    </head>

    <body>
        <?php
        if (isset($_REQUEST["fehler"])) {
            echo "Die Zugangsdaten waren ungueltig.";
        }
        ?>
        <form action="../Controller/Login/login.php" method="post">
            <div id="login">
                E-Mail: <input type="text" name="Mail" size="20"><br>
                Kennwort: <input type="password" name="Pwd" size="20"><br>
                <input type="submit" value="Login">
                <br><br>
                <a href="../Trash/DBConnectionTest.php">user + passwort table (only for test)</a>
            </div>
        </form>
    </body>  
</html>