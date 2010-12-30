<?php session_start (); ?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="./css/login_style.css" />


        <script LANGUAGE="JavaScript">
            function register(){
                alert("Um sich zu registrieren wenden Sie sich bitte an den System-Administrator");
            }

            function password(){
                alert("not yet supported");
            }
        </script>

    </head>

    <body>
        <?php
        if (isset($_REQUEST["fehler"])) {
            echo "Die Zugangsdaten waren ungueltig.";
        }
        ?>
        <form action="../Controller/Login/login.php" method="post">
            <div id="login">
                <div id="pos">
                <h1>Login</h1>
                    <table border="0">
                        <tr class="input">
                            <td>E-Mail:</td>
                            <td><input type="text" name="Mail" class="input-field"></td>
                            <td><a href="JavaScript:register()">registrieren</a></td>
                        </tr>
                        <tr class="input">
                            <td>Kennwort:</td>
                            <td><input type="password" name="Pwd" class="input-field"></td>
                            <td><a href="JavaScript:password()">passwort vergessen</a></td>
                        </tr>
                    </table>
                    <p class="button">
                        <input type="submit" value="Login" id="login-button">
                    </p>
                    <p class="button">
                        <a href="../Trash/DBConnectionTest.php">user + passwort table (only for test)</a>
                    </p>
                </div>
            </div>
        </form>
    </body>  
</html>