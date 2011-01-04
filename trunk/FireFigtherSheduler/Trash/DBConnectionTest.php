<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
//            $mysqlhost="feuerwehr-saar.de"; // MySQL-Host angeben
//            $mysqldb="db1057229-2"; // Gewuenschte Datenbank angeben
//            $mysqluser="dbu1057229"; // MySQL-User angeben
//            $mysqlpwd="h0m3b0y"; // Passwort angeben

            $mysqlhost="stud-i-pr2.htw-saarland.de"; // MySQL-Host angeben
            $mysqldb="FFS"; // Gewuenschte Datenbank angeben
            $mysqluser="htwmaps"; // MySQL-User angeben
            $mysqlpwd="g00gl3m4p5k1ll4"; // Passwort angeben
            
            $connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd)
                        or die ("Verbindungsversuch fehlgeschlagen!");

            mysql_select_db($mysqldb, $connection)
                            or die("Konnte die Datenbank nicht waehlen.");

            $sql = "SELECT ID, email, name from user";

            $adressen_query = mysql_query($sql)
                              or die("Anfrage nicht erfolgreich");

            ?>
            <table border = 2>
                <tr>
                    <td>ID</td>
                    <td>E-Mail</td>
                    <td>Kennwort</td>
                </tr>
             <?php
            //Daten in Array lesen
            while ($adr = mysql_fetch_array($adressen_query)){
                echo "<tr>" . 
                        "<td>$adr[ID]</td>" .
                        "<td>$adr[email]</td>" .
                        "<td>$adr[name]</td>" .
                    "</tr>";
            }
            ?>
            </table>
            <?php
            //Optional
            $anzahl = mysql_num_rows($adressen_query);
            echo "<br>Anzahl der Datensätze: $anzahl";
        ?>
    </body>
</html>
