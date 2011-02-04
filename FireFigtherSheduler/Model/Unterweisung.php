<?php

require_once('DbConnector.php');
require_once('../Configuration/Config.php');
require_once('FFSException.php');
require_once('../Configuration/ExceptionText.php');

/**
 * Description of Unterweisung
 * Die Klasse stellt Daten einer Unterweisung bereit und
 * handhabt alle dazugehoerigen Funktionen.
 *
 * @author Warken Andreas
 * @version 0.9
 */
class Unterweisung {

    private $ID;
    private $ort;
    private $datum;
    private $verantID;

    /**
     * Standard Konstruktor
     */
    public function __construct() {
        
    }

    /**
     * load
     * laed das Objekt aus der DB anhand seiner ID
     * @param <type> $ID Die Id des Datenbankeintrags
     * @return Unterweisungs Objekt
     */
    public static function load($ID) {
        if (is_numeric($ID)) {
            $sql = "SELECT *
            FROM unterweisung
            WHERE ID = '$ID' ;";

            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);

            if (mysql_num_rows($result) > 0) {
                $data = mysql_fetch_array($result);

                return Unterweisung::parse_result_as_objekt($data);
            } else {
                throw new FFSException(ExceptionText::unterweisung_not_found());
            }
        } else {
            throw new FFSException(ExceptionText::unterweisung_ID_not_numeric());
        }
    }

    /**
     * parse_result_as_objekt
     * erstellt aus einer Datenbankzeile ein Objekt der Klasse
     *
     * @param <type> $row DB-row
     * @return Unterweisungs Objekt
     */
    public static function parse_result_as_objekt($row) {
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
    public function save() {
        if ($this->ort != NULL) {
            if ($this->datum != NULL) {
                $sql = "UPDATE unterweisung
                SET ort = '$this->ort', datum = '$this->datum',
                    verantID = '$this->verantID'
                WHERE ID = '$this->ID';";

                $dbConnector = DbConnector::getInstance();
                $result = $dbConnector->execute_sql($sql);
            } else {
                throw new FFSException(ExceptionText::unterweisung_no_date());
            }
        } else {
            throw new FFSException(ExceptionText::unterweisung_no_date());
        }
    }

    /**
     * create_db_entry
     * legt ein neues Objekt mit seinen Parametern an
     */
    public function create_db_entry() {
        if ($this->ort != NULL) {
            if ($this->datum != NULL) {
                $sql = "INSERT INTO unterweisung ( ort, datum, verantID)
                    VALUES ( '$this->ort', '$this->datum', '$this->verantID' );";

                $dbConnector = DbConnector::getInstance();
                $result = $dbConnector->execute_sql($sql);
            } else {
                throw new FFSException(ExceptionText::unterweisung_no_date());
            }
        } else {
            throw new FFSException(ExceptionText::unterweisung_no_location());
        }
    }

    /**
     * delete_with_dependencys
     * loescht das Objekt mit den Abhaengigkeiten zu den Benutzern
     */
    public function delete_with_dependencys() {
        $sql = "DELETE FROM unterweisung
        WHERE ID = '$this->ID';";
        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);

        // dependencys
        $sql = "DELETE FROM r_unterweisungUser
        WHERE unterweisung_ID = '$this->ID';";
        $result = $dbConnector->execute_sql($sql);
    }

    /**
     * get_warning_status
     * liefert den Warnungs-Status des Objekts
     * @return <type> integer, siehe Config.php 
     */
    public function get_warning_status() {
        $timestamp = time();
        $datum_formated = mktime(0, 0, 0,
                        (int) substr($this->datum, 5, 2),
                        (int) substr($this->datum, 8, 2),
                        (int) substr($this->datum, 0, 4));
        $date_difference = floor(($datum_formated - $timestamp) / 86400);
        if ($date_difference < 0) { //TODO  weis nemmer für was unterweisungsstrecke da ist......
            return Config::red();
        } elseif ($date_difference < Config::unterweisung_warning_yellow()) {
            return Config::yellow();
        } else {
            return Config::green();
        }
    }

    // ---------------- Down setter and getter ----------------

    public function setID($ID) {
        if ((is_numeric($ID))or ($ID == NULL)) {
            $this->ID = $ID;
        } else {
            throw new FFSException(ExceptionText::unterweisung_ID_not_numeric());
        }
    }

    public function setOrt($ort) {
        $this->ort = $ort;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function setVerantID($verantID) {
        if ((is_numeric($verantID))or ($verantID == NULL)){
            $this->verantID = $verantID;
        } else {
            throw new FFSException(ExceptionText::unterweisung_verantID_not_numeric());
        }
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
