<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FFS Benutzer</title>
        <link rel="stylesheet" type="text/css" href="css/users.css" />
        <script type="text/javascript" src="../Controller/jsXMLHttpRequestHandle.js"></script>
        <script type="text/javascript" src="../Model/User_Manager/jsUserInfos.js"></script>
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
                        <td><div><input type="submit" value="hinzufügen" name="ok" id="ok"></div></td>
                        <td><div><input type ="button" value="abbrechen" name="reset" id="reset"></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
