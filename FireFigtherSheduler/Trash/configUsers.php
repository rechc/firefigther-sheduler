<?php

    include ("../../Model/Includes/dbConnector.php");

    // übertragener Text sollte vorher noch auf Hacks untersucht werden!!!!

    if ($_POST($option) == "create")
        createUser($_POST($ID), $_POST($lastname));
    else if ($_POST($option) == "create")
        deleteUser($_POST($ID));
    else
        echo "configUsers: Option nicht vorhanden!";

    function createUser($id, $lname){
        $sql = "INSERT INTO id, nachname FROM user value " . $id . ", " . $lastname;
        $result = mysql_query($sql)
                     or die("Anfrage nicht erfolgreich!");
        echo "Neuer Benutzer wurde erstellt";
    }


    function deleteUser($id){
        $sql = "DELTE FROM user where ID = " . ($_POST($ID));
        $result = mysql_query($sql)
                     or die("Anfrage nicht erfolgreich!");
        echo "Benutzer wurde geloescht";
     }
?>
