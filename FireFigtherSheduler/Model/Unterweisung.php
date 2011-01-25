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
     * 
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
     *
     */
    public function save(){}

    public function create_db_entry(){}

    /**
     *
     */
    public function delete_if_not_referenced(){}


    

    
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
         if ($date_difference < -111){ //TODO  weis nemmer für was unterweisungsstrecke da ist
            return true;
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
