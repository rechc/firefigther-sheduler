<?php
require_once('DbConnector.php');
require_once('../Configuration/Config.php');

/**
 * Description of Unterweisung
 *
 * @author Warken Andreas
 * @version alpha
 */
class Unterweisung {
    private $ID;
    private $ort;
    private $datum;
    private $verantID;


    /**
     * Standard Konstruktor
     */
    public function __construct(){}


    /**
     * load
     * laed das Objekt aus der DB anhand seiner ID
     * @param <type> $ID
     * @return Unterweisung Objekt or NULL
     */
    public static function load($ID){
        $sql="SELECT *
            FROM unterweisung
            WHERE ID = $ID ";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);

        if (mysql_num_rows($result) > 0) {
            $data = mysql_fetch_array($result);

            $unterweisung = new Unterweisung();
            $unterweisung->setID($data["ID"]);
            $unterweisung->setOrt($data["ort"]);
            $unterweisung->setDatum($data["datum"]);
            $unterweisung->setVerantID($data["verantID"]);

            return $unterweisung;
        }else{
            return NULL;
        }   
    }
    
    /**
     * save
     * speichert das Objekt anhand seiner ID
     */
    public function save(){
        //kann fehlschlagen falls gelöscht wurde -> handling
        $sql = "UPDATE unterweisung
            SET ort = '$this->ort', datum = '$this->datum',
                verantID = '$this->verantID'
            WHERE ID = '$this->ID'";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);
    }


    /**
     * create_db_entry
     * legt ein neues Objekt mit seinen Parametern an
     */
     public function create_db_entry(){
        //aktuell gibt es keine Prüfung ab alle Daten im Objekt vorhanden sind
        $sql= "INSERT INTO unterweisung ( ort, datum, verantID)
            VALUES ( '$this->ort', '$this->datum', '$this->verantID' )";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);
     }


    /**
     * delete_if_not_referenced
     * löscht das Objekt falls es nicht mehr referenziert wird
     */
    public function delete_if_not_referenced(){
        if (false){ // daten kommen noch
            $sql = "DELETE FROM unterweisung
                WHERE ID = '$this->ID'";
            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);
        }
    }

    

    // wird nur ggf benoetigt, wenn man eine unterweisung explizit und somit von allen benutzern entfernen will
    public function delete_with_references(){}


    
    /**
     *
     * @return <type> 
     */
    public function is_expired(){
        $timestamp = time();
        $datum_formated =  mktime(0,0,0,
                 (int)substr($this->datum,5,2),
                 (int)substr($this->datum,8,2),
                 (int)substr($this->datum,0,4));
         $date_difference = floor(($datum_formated - $timestamp)/86400);
         if ($date_difference < -111){ //TODO  weis nemmer für was unterweisungsstrecke da ist, abwaerts ueberarbeiten
            return Config::green();
         }else{
             return Config::red();
         }
    }

    // ---------------- Down setter and getter ----------------

    public function setID($ID) {
        $this->ID = $ID;
    }

    public function setOrt($ort) {
        $this->ort = $ort;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function setVerantID($verantID) {
        $this->verantID = $verantID;
    }

    public function getID() {
        return $this->ID;
    }

    public function getOrt() {
        return $this->ort;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function getVerantID() {
        return $this->verantID;
    }

}
?>
