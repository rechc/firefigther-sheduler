<?php
include ("../Model/Includes/checkuser.php");
?>
<html>
    <head>
        <title>Interne Seite</title>
    </head>
    <body>
        BenutzerId: <?php echo $_SESSION["user_id"]; ?><br>
        Nickname: <?php echo $_SESSION["user_email"]; ?><br>
        Nachname: <?php echo $_SESSION["user_nachname"]; ?><br>
        Vorname: <?php echo $_SESSION["user_vorname"]; ?>
        <hr>
        <a href="../Controller/Login/logout.php">Ausloggen</a>
    </body>
</html>