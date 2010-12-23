<?php
    // Session starten
    session_start ();

    // Zugangsdaten Datenbank
    $mysqlhost="feuerwehr-saar.de"; // MySQL-Host angeben
                $mysqldb="db1057229-2"; // Gewuenschte Datenbank angeben
                $mysqluser="dbu1057229"; // MySQL-User angeben
                $mysqlpwd="h0m3b0y"; // Passwort angeben

    // Datenbankverbindung aufbauen
    $connectionid = mysql_connect($mysqlhost, $mysqluser, $mysqlpwd)
                        or die ("Verbindungsversuch zur Datenbank fehlgeschlagen!");
    mysql_select_db($mysqldb) or die(mysql_error());


    $sql = "SELECT ID, email, name, vorname " .
            "FROM user " .
            "WHERE ( email like '" . $_REQUEST["Mail"] .
            "' ) AND ( " .
            "name = '" . $_REQUEST["Pwd"] . "')";
            //"name = '" . md5($_REQUEST["pwd"]) . "')";

    // echo "$sql<br>"; // zum Test wie Befehl geschrieben aussieht

    $result = mysql_query($sql);

    //Test
    //$anzahl = mysql_num_rows($adressen_query);
    //echo "<br>Anzahl der Datensätze: $anzahl";

    if (mysql_num_rows($result) > 0) {
        // Benutzerdaten in ein Array auslesen.
        $data = mysql_fetch_array($result);

        // Sessionvariablen erstellen und registrieren
        $_SESSION["user_id"] = $data["ID"];
        $_SESSION["user_email"] = $data["email"];
        $_SESSION["user_nachname"] = $data["name"];
        $_SESSION["user_vorname"] = $data["vorname"];

        header("Location: intern.php");
    } else {
        header("Location: formular.php?fehler=1");
    }
?>