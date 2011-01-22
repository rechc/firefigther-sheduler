<?php

/**
 * Description of DbConnector
 * Version 0.1 not tested
 * @author awagen
 */
class DbConnector {
 
    const mysqlhost="stud-i-pr2.htw-saarland.de"; // MySQL-Host angeben
    const mysqldb="FFS"; // Gewuenschte Datenbank angeben
    const mysqluser="htwmaps"; // MySQL-User angeben
    const mysqlpwd="g00gl3m4p5k1ll4"; // Passwort angeben
 
    /*
    var $mysqlhost="feuerwehr-saar.de"; // MySQL-Host angeben
    var $mysqldb="db1057229-2"; // Gewuenschte Datenbank angeben
    var $mysqluser="dbu1057229"; // MySQL-User angeben
    var $mysqlpwd="h0m3b0y"; // Passwort angeben
    */
    var $connectionid;

    /**
     * Konstruktor
     */
    public function __construct(){
        // Datenbankverbindung aufbauen
        $this->connectionid = mysql_connect(DbConnector::mysqlhost,
                DbConnector::mysqluser, DbConnector::mysqlpwd)
                or die (mysql_error());
        mysql_select_db(DbConnector::mysqldb) or die(mysql_error()); 
    }

    /**
     * execute_sql
     * Sendet ein SQL Befehl und liefert das Resultset zurueck
     * @param <type> $sql Ein SQL Befehl
     */
    public function execute_sql($sql){
        $result = mysql_query($sql)
            or die(mysql_error());;
        return $result;
    }

    /**
     * explizit_shutdown
     * schließt die DB Verbindung
     * (Normalerweise wird eine Trennung der Datenbankverbindung nicht benötigt,
     * da dies automatisch mit dem Ende des Scripts erfolgt.)
     */
    public function explizit_shutdown(){
        mysql_close( $this->connectionid );
    }


}
// schnell  Test:
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
