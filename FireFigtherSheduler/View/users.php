<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Benutzer</h1>
        <div style="height:500px;width:250px;overflow:scroll;" id="userlist">
            <?php
                include ("../../Model/Includes/dbConnector.php");
                $sql = "SELECT email, name from user";
                $adressen_query = mysql_query($sql)
                                  or die("Anfrage nicht erfolgreich");
                ?>
                <table border = 2>
                    <tr>
                        <td>E-Mail</td>
                        <td>Name</td>
                    </tr>
                 <?php
                //Daten in Array lesen
                while ($adr = mysql_fetch_array($adressen_query)){
                    echo "<tr>" .
                            "<td>$adr[email]</td>" .
                            "<td>$adr[name]</td>" .
                        "</tr>";
                }
                ?>
                </table>
        </div>
        <div style="height:300px;width:250px;overflow:scroll;" id="userlist">
            <div>Name <input type ="text"></div>
            <div>Vorname: <input type ="text"></div>
            <div>E-Mail: <input type ="text"></div>
            <div>Geburtsdatum: <input type ="text"></div>
            <div>Geschlecht: <input type ="radio"></div>

            <div><input type="button" name="ok"></div>
            <div><input type ="button" value="abbrechen" name="reset"</div>
        </div>

        <?php
        // put your code here
        ?>
    </body>
</html>
