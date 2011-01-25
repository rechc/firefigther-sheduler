<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FFS Benutzer</title>
        <link rel="stylesheet" type="text/css" href="css/users.css" />
        	<script type="text/javascript" src="../Controller/jsXMLHttpRequestHandle.js"></script>
                <script type="text/javascript">
                        function sendUserInfoRequest(userID) {
                              var xmlHttp = getXMLHttp();

                              xmlHttp.onreadystatechange = function() {
                                if(xmlHttp.readyState == 4) {
                                  HandleResponse(xmlHttp.responseXML);
                                }
                              }
                              xmlHttp.open("GET", "../Controller/getUserInfo.php?userID=" + userID, true); //+ Math.random()
                              xmlHttp.send(null);
                        }

                        function HandleResponse(response){
                             var lastname = response.getElementsByTagName('lastname')[0].childNodes[0].nodeValue;
                             var firstname = response.getElementsByTagName('firstname')[0].childNodes[0].nodeValue;

                             document.getElementById('lastname').value = lastname;
                             document.getElementById('firstname').value = firstname;
                        }

     /*               function createNewUser(){
                            var lastname = document.getElementById('lastname').value;
                            var firstname = document.getElementById('firstname').value;
                            var email = document.getElementById('email').value;
                            var bday = document.getElementById('bday').value;

                            var xmlHttp = getXMLHttp();

                            xmlHttp.onreadystatechange = function() {
                              if(xmlHttp.readyState == 4) {
                                 HandleResponse(xmlHttp.responseText);
                                }
                             }

                              xmlHttp.open("POST", "../Controller/configUsera.php?lastname=" + lastname +
                              "&firstname=" + firstname + "&email=" + email + "&bday=" + bday + "", true); //+ Math.random()
                              xmlHttp.send(null);
                        }

                        function deleteUser(id){
                            var xmlHttp = getXMLHttp();

                            xmlHttp.onreadystatechange = function() {
                              if(xmlHttp.readyState == 4) {
                                 HandleResponse(xmlHttp.responseText);
                                }
                             }

                              xmlHttp.open("POST", "../Controller/configUsera.php?id=" + id;
                              xmlHttp.send(null);
                        }

                        */
		</script>

                <?php
                        function test(){
                            ;
                        }
                ?>
    </head>
    <body>
        <h1>Benutzer</h1>
        <div id="userlist">
            <?php
                include ("../Model/Includes/dbConnector.php");

                $sql = "SELECT id, email, name FROM user";
                $adressen_query = mysql_query($sql)
                                  or die("Anfrage nicht erfolgreich!");

                while ($adr = mysql_fetch_array($adressen_query)){
                    echo "<hr>";
                    echo "<a href='#' onClick='sendUserInfoRequest(" . $adr[id] . ")'>" . 
                            $adr[email] . "; " . $adr[name] . "<br>".
                        "</a>";
                    echo "<hr>";
                }
            ?>
        </div>
        <div id="userdata">
            <form id="editUser" onsubmit="return false;" action="<?php test();?>">
                <table border="0">
                    <tr>
                        <td><div>Name: <input type ="text" id="lastname" value=""></div></td>
                        <td><div>Vorname: <input type ="text" id="firstname" value=""></div></td>
                    </tr>
                    <tr>
                        <td><div>E-Mail: <input type ="text" id="email"></div></td>
                        <td><div>Geburtsdatum: <input type ="text" id="bday"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div>Geschlecht:
                                  männlisch <input type="radio" value="maennlisch" name="Geschlecht" id="man">
                                  weiblisch <input type="radio" value="weiblisch" name="Geschlecht" id="woman">
                             </div>
                        </td>
                    </tr>
                    <tr>
                        <td><div><input type="button" value="hinzufügen" name="ok" onClick="createNewUser();"></div></td>
                        <td><div><input type ="button" value="abbrechen" name="reset"</div></td>
                    </tr>
                </table>
            </form>
                <div id='ResponseDiv'></div>
        </div>
    </body>
</html>
