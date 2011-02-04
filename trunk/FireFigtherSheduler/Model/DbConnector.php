<?php
require_once('../Configuration/Config.php');

/**
 * Description of DbConnector
 *
 * @author Warken Andreas, Rech Christian
 * @version 1.0
 */
class DbConnector {
 
    private static $singletonInstance = NULL;
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
        if(self::$singletonInstance == NULL)
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

?>
