<?php

require_once('DbConnector.php');
require_once('FFSException.php');
require_once('../Configuration/Config.php');
require_once('../Configuration/ExceptionText.php');

/**
 * Description of Einsatz
 * Die Klasse stellt Daten einer Einsatz bereit und
 * handhabt alle dazugehoerigen Funktionen.
 *
 * @author Warken Andreas
 * @version 1.0
 */
class Einsatz {

    private $ID;
    private $ort;
    private $datum;

    /**
     * Standard Konstruktor
     */
    public function __construct() {

    }

    /**
     * load
     * laed das Objekt aus der DB anhand seiner ID
     * @param <type> $ID Die Id des Datenbankeintrags
     * @return Einsatzs Objekt
     */
    public static function load($ID) {
        if (is_numeric($ID)) {
            $sql = "SELECT *
            FROM einsatz
            WHERE ID = '$ID' ;";

            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);

            if (mysql_num_rows($result) > 0) {
                $data = mysql_fetch_array($result);

                return Einsatz::parse_result_as_objekt($data);
            } else {
                throw new FFSException(ExceptionText::einsatz_not_found());
            }
        } else {
            throw new FFSException(ExceptionText::einsatz_ID_not_numeric());
        }
    }

    /**
     * parse_result_as_objekt
     * erstellt aus einer Datenbankzeile ein Objekt der Klasse
     *
     * @param <type> $row DB-row
     * @return Einsatzs Objekt
     */
    public static function parse_result_as_objekt($row) {
        $einsatz = new Einsatz();
        $einsatz->setID($row["ID"]);
        $einsatz->setOrt($row["ort"]);
        $einsatz->setDatum($row["datum"]);
        return $einsatz;
    }

    /**
     * save
     * speichert das Objekt anhand seiner ID
     */
    public function save() {
        if ($this->ort != NULL) {
            if ($this->datum != NULL) {
                $sql = "UPDATE einsatz
                SET ort = '$this->ort', datum = '$this->datum'
                WHERE ID = '$this->ID';";

                $dbConnector = DbConnector::getInstance();
                $result = $dbConnector->execute_sql($sql);
            } else {
                throw new FFSException(ExceptionText::einsatz_no_date());
            }
        } else {
            throw new FFSException(ExceptionText::einsatz_no_location());
        }
    }

    /**
     * create_db_entry
     * legt ein neues Objekt mit seinen Parametern an
     */
    public function create_db_entry() {
        if ($this->ort != NULL) {
            if ($this->datum != NULL) {
                $sql = "INSERT INTO einsatz ( ort, datum)
                    VALUES ( '$this->ort', '$this->datum' );";

                $dbConnector = DbConnector::getInstance();
                $result = $dbConnector->execute_sql($sql);
            } else {
                throw new FFSException(ExceptionText::einsatz_no_date());
            }
        } else {
            throw new FFSException(ExceptionText::einsatz_no_date());
        }
    }

    /**
     * delete_with_dependencys
     * loescht das Objekt mit den Abhaengigkeiten zu den Benutzern
     */
    public function delete_with_dependencys() {
        $sql = "DELETE FROM einsatz
        WHERE ID = '$this->ID';";
        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);

        // dependencys
        $sql = "DELETE FROM r_einsatzUser
        WHERE einsatz_ID = '$this->ID';";
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
        if ($date_difference < Config::last_einsatz()) {
            return Config::red();
        } elseif ($date_difference < (Config::last_einsatz()+Config::einsatz_warning_yellow())) {
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
            throw new FFSException(ExceptionText::einsatz_ID_not_numeric());
        }
    }

    public function setOrt($ort) {
        $this->ort = $ort;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
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

}

?>
