<?php
    // Zugangsdaten Datenbank
    $mysqlhost="feuerwehr-saar.de"; // MySQL-Host angeben
                $mysqldb="db1057229-2"; // Gewuenschte Datenbank angeben
                $mysqluser="dbu1057229"; // MySQL-User angeben
                $mysqlpwd="h0m3b0y"; // Passwort angeben

    // Datenbankverbindung aufbauen
    $connectionid = mysql_connect($mysqlhost, $mysqluser, $mysqlpwd)
                        or die ("Verbindungsversuch zur Datenbank fehlgeschlagen!");
    mysql_select_db($mysqldb) or die(mysql_error());
?>
