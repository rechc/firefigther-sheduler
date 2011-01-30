<?php
require_once('DbConnector.php');
require_once('../Configuration/Config.php');

/**
 * Description of Unterweisung
 *
 * @author Warken Andreas
 * @version alpha+
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

    public static function parse_result_as_objekt($row){
         $unterweisung = new Unterweisung();
         $unterweisung->setID($row["ID"]);
         $unterweisung->setOrt($row["ort"]);
         $unterweisung->setDatum($row["datum"]);
         $unterweisung->setVerantID($row["verantID"]);
         return $unterweisung;
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
      * delete_with_dependencys
      * loescht das Objekt mit den Abhaengigkeiten zu den Benutzern
      */
    public function delete_with_dependencys(){
        $sql = "DELETE FROM unterweisung
        WHERE ID = '$this->ID'";
        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);

        // dependencys
        $sql = "DELETE FROM r_unterweisungUser
        WHERE unterweisung_ID = '$this->ID'";
        $result = $dbConnector->execute_sql($sql);
    }

    
    /**
     * get_warning_status
     * prueft ob abgelaufen
     * @return <type> 
     */
    public function get_warning_status(){
        $timestamp = time();
        $datum_formated =  mktime(0,0,0,
                 (int)substr($this->datum,5,2),
                 (int)substr($this->datum,8,2),
                 (int)substr($this->datum,0,4));
         $date_difference = floor(($datum_formated - $timestamp)/86400);
        // echo $date_difference,'<br>';
         if ($date_difference < 0){ //TODO  weis nemmer für was unterweisungsstrecke da ist, abwaerts ueberarbeiten
            return Config::red();
         }else{
             return Config::green();// vorl noch ueberlegen wann gelb 30 tage vorher ? oder noch ne farbe nur fuer abgelaufen aber nicht relevant im zusammenhang
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