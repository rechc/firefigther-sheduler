<?php
    // Session starten
    session_start ();

    include ("../../Model/Includes/dbConnector.php");

    $sql = "SELECT ID, email, name, vorname " .
            "FROM user " .
            "WHERE ( email like '" . $_REQUEST["Mail"] .
            "' ) AND ( " .
            "Password = '" .  md5($_REQUEST["Pwd"]) . "')";
            //"name = '" . $_REQUEST["Pwd"] . "')";

    // echo "$sql<br>"; // zum Test wie Befehl geschrieben aussieht

    $result = mysql_query($sql)
                 or die("Anfrage nicht erfolgreich!");;

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

        header("Location: ../../View/startseite.php?section=overview");
        //header("Location: ../../Trash/intern.php");
    } else {
        header("Location: ../../View/login_formular.php?fehler=1");
    }
?>