<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FFS Benutzer</title>
        <link rel="stylesheet" type="text/css" href="css/users.css" />
        <script type="text/javascript" src="../Model/JavaScript/jsXMLHttpRequestHandle.js"></script>
        <script type="text/javascript" src="../Model/JavaScript/jsUserManager.js"></script>
    </head>
    <body>
        <h1>Benutzer</h1>
        <div id="userlist">
            <?php
              require_once('../Model/User_Manager/Userlist.php');
              $userlist = Userlist::getUserTable();
            ?>
        </div>
        <div id="userdata">
            <form id="editUser" action="../Controller/createUser.php" method="post">
                Benutzer-ID: <input type ="text" name="id" id="id" value="" readonly>
                <table border="0">
                    <tr>
                        <td><div>Name: <input type ="text" name="lastname" id="lastname" value=""></div></td>
                        <td><div>Vorname: <input type ="text" name="firstname" id="firstname" value=""></div></td>
                    </tr>
                    <tr>
                        <td><div>E-Mail: <input type ="text" name ="email" id="email"></div></td>
                        <td><div>Geburtsdatum: <input type ="text" name="bday" id="bday"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div>Geschlecht:
                                  männlich <input type="radio" value="maennlisch" name="Geschlecht" id="man">
                                  weiblich <input type="radio" value="weiblisch" name="Geschlecht" id="woman">
                             </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div>
                                <input type="submit" value="hinzufügen" name="ok" id="ok">
                                <input type="button" value="löschen" name="delete" id="delete" onClick="document.location.href='javascript:sendDeleteUserRequest(document.getElementById(id))'">
                                <input type ="reset" value="abbrechen" name="reset" id="reset" onClick="document.location.href='javascript:reset()'">
                             </div>
                        </td>
                    </tr>
                </table>
                <div name="infobox" id ="infobox"></div>
            </form>
        </div>
    </body>
</html>
