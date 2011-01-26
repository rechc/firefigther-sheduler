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
              $userlist = new Userlist();
            ?>
        </div>
        <div id="userdata">
            <form id="editUser" onsubmit="return false;" action="">
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
        </div>
    </body>
</html>
