<?php
require_once('DbConnector.php');
require_once('../Configuration/Config.php');

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of G26
 *
 * @author awagen
 * @version beta
 */
class G26 {

    private $ID;
    private $userID;
    private $datum;
    private $gueltigBis;
    //put your code here
/*//*G26.3 ist normalerweise alle 3 jahre faellig.
Der Arzt kann aber auch andere Daten festlegen, wie er es fuer richtig haelt.
Du bekommst also bei der Untersuchung eine Art haltbarkeitsdatum verpasst.*/
    /**
     * Standard Konstruktor
     */
    public function __construct(){}

    
    /**
     *
     * @param <type> $ID
     * @return G26-Objekt or NULL
     */
    public static function load($userID){
        $sql="SELECT *
            FROM g26
            WHERE userID = $userID ";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);

        if (mysql_num_rows($result) > 0) {
            $data = mysql_fetch_array($result);

            $g26 = new G26();
            $g26->setID($data["ID"]);
            $g26->setUserID($data["userID"]);
            $g26->setDatum($data["datum"]);
            $g26->setGueltigBis($data["gueltigBis"]);

            return $g26;
        }else{
            return NULL;
        }
    }
    

    /**
     * 
     */
    public function save(){
        //kann fehlschlagen falls g26 gelöscht wurde -> handling
        $sql = "UPDATE g26
            SET userID = '$this->userID', datum = '$this->datum',
                gueltigBis = '$this->gueltigBis'
            WHERE ID = '$this->ID'";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);
    }


    /**
     * 
     */
     public function create_db_entry(){
         $sql= "INSERT INTO g26 ( userID, datum, gueltigBis)
        VALUES ( '$this->userID', '$this->datum', '$this->gueltigBis' )";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);
     }


     /**
      *
      */
     public function delete(){
         $sql = "DELETE FROM g26
             WHERE ID = '$this->ID'";
         $dbConnector = DbConnector::getInstance();
         $result = $dbConnector->execute_sql($sql);
     }


     /**
      * get_warning_status
      * 
      * @return <type> integer, siehe Config.php :
      * Standard: 3 = Config::red(), 2 = Config::yellow() und 1 = Config::green()
      */
     public function get_warning_status(){
         $timestamp = time(); //lesbar: //$current_date = date("d.m.Y",$timestamp);
         $gueltigBis_formated =  mktime(0,0,0,
                 (int)substr($this->gueltigBis,5,2),
                 (int)substr($this->gueltigBis,8,2),
                 (int)substr($this->gueltigBis,0,4));
         $date_difference = floor(($gueltigBis_formated - $timestamp)/86400);
         
         if ($date_difference < 0){
             return Config::red();
         }  elseif ($date_difference < Config::g26_yellow_state()) {
             return Config::yellow();
         }  else {
             return Config::green();
         }
     }


    // ---------------- Down setter and getter ----------------
    
    public function getID() {
        return $this->ID;
    }

    public function setID($ID) {
        $this->ID = $ID;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function getGueltigBis() {
        return $this->gueltigBis;
    }

    public function setGueltigBis($gueltigBis) {
        $this->gueltigBis = $gueltigBis;
    }

}

?>
