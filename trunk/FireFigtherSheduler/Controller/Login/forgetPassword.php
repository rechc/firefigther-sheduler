<!--
    Document   : forgetPassword
    Created on : 16.01.2011, 21:58:52
    Author     : christian
    Description: 
-->
<?php
    if ($_POST['Submit']=='Send'){
        $sql = "select email from user where email='$_POST[email]'";
        $rs_search = mysql_query($sql);
        $user_count = mysql_num_rows($rs_search);

        if ($user_count != 0){
            $newpwd = rand(1000,9999);
            $newmd5pwd = md5($newpwd);
            mysql_query("UPDATE user set password='$newmd5pwd' where email='$_POST[email]'");
            $message =
                "Ihr Passwort wurde zurückgesetzt. Ihr neuen Login-Daten sind:\n\n
                Benutzername: $_POST[email] \n
                Passwort: $newpwd \n
                ____________________________________________
                Dies ist eine automatisch erstellte E-Mail. Bitte antworten Sie nicht darauf.
                ";

            mail($_POST['email'], "Neue Zugangsdaten", $message,
            "From: \"Domain\" <from_email_address>\r\n" .
            "X-Mailer: PHP/" . phpversion());

            die("Ihre neuen Zugangsdaten wurden an Ihre E-Mail Adresse versandt.");
        } else
            die("Ein Benutzerkonto mit der angegebenen E-Mail Adresse existiert nicht.");
    }
?>
