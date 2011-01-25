<?php
require_once('../Model/DbConnector.php');

//schnelle unsaubere tests

function testdbc(){
    $db = new DbConnector();

    $email = "t.lana@ff-riegelsberg.de";
    $name = "Lana";
    $sql = "SELECT ID, email, name, vorname " .
                "FROM user " .
                "WHERE ( email like '" . $email .
                "' ) AND ( " .
                //"Password = '" .  md5($_REQUEST["Pwd"]) . "')";
                "name = '" . $name . "')";
    $resu = $db->execute_sql($sql);
    echo $resu;
    if (mysql_num_rows($resu) > 0) {
            // Benutzerdaten in ein Array auslesen.
            $data = mysql_fetch_array($resu);


            echo $data["ID"]. "\n";
            echo $data["email"];
            echo $data["name"];
            echo $data["vorname"];}
}

//test(); uncommit for test

?>
