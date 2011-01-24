<?php
require_once('../Configuration/Config.php');

/**
 * Description of DbConnector
 *
 * @author awagen
 * @version beta
 */
class DbConnector {
 
    private static $singletonInstance = null;
    private $connectionid;
    

    /**
     * Konstruktor
     * legt eine neue Verbindung an
     * private wegen Singelton
     */
    private function __construct(){
        // nice to have : singelton
        // Datenbankverbindung aufbauen
        $this->connectionid = mysql_connect(Config::mysqlhost(),
                Config::mysqluser(), Config::mysqlpwd())
                or die (mysql_error());
        mysql_select_db(Config::mysqldb()) or die(mysql_error());
    }


    /**
     * getInstance
     * liefert eine Instanz vom DbConnector (Singleton)
     * @return DbConnector-Objekt
     */
    public static function getInstance(){
        if(self::$singletonInstance == null)
      {
         self::$singletonInstance = new DbConnector();
      }
      return self::$singletonInstance;
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
