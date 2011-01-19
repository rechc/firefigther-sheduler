<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FFS Benutzer</title>
        <link rel="stylesheet" type="text/css" href="css/users.css" />
        	<script type="text/javascript" src="../Controller/jsXMLHttpRequestHandle.js"></script>
                <script type="text/javascript">
                        function sendUserInfoRequest() {
                          var xmlHttp = getXMLHttp();

                          xmlHttp.onreadystatechange = function() {
                            if(xmlHttp.readyState == 4) {
                              HandleResponse(xmlHttp.responseText);
                            }
                          }
                          xmlHttp.open("GET", "../Controller/getUserInfo.php?" + Math.random(), true);
                          xmlHttp.send(null);
                        }

                        function HandleResponse(response){
                          document.getElementById('ResponseDiv').innerHTML = response;
                        }
		</script>
    </head>
    <body>
        <h1>Benutzer</h1>
        <div id="userlist">
            <?php
                include ("../Model/Includes/dbConnector.php");

                $sql = "SELECT email, name FROM user";
                $adressen_query = mysql_query($sql)
                                  or die("Anfrage nicht erfolgreich!");
        
                while ($adr = mysql_fetch_array($adressen_query)){
                    echo "<hr>";
                    echo "<a href='startseite.php?userselect=" . $adr[email] ."'>" .
                            $adr[email] . "; " . $adr[name] . "<br>".
                        "</a>";
                    echo "<hr>";
                }
            ?>
        </div>
        <div id="userdata">
            <form id="editUser" onsubmit="return false;">
                <table border="0">
                    <tr>
                        <td><div>Name: <input type ="text"></div></td>
                        <td><div>Vorname: <input type ="text"></div></td>
                    </tr>
                    <tr>
                        <td><div>E-Mail: <input type ="text"></div></td>
                        <td><div>Geburtsdatum: <input type ="text"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div>Geschlecht:
                                  männlisch <input type="radio" value="maennlisch" name="Geschlecht">
                                  weiblisch <input type="radio" value="weiblisch" name="Geschlecht">
                             </div>
                        </td>
                    </tr>
                    <tr>
                        <td><div><input type="button" value="Ok" name="ok" onClick="sendUserInfoRequest();"></div></td>
                        <td><div><input type ="button" value="abbrechen" name="reset"</div></td>
                    </tr>
                </table>
            </form>
                <div id='ResponseDiv'></div>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
