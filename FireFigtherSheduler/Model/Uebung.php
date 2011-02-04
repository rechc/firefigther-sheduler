<?php

require_once('DbConnector.php');
require_once('FFSException.php');
require_once('../Configuration/Config.php');
require_once('../Configuration/ExceptionText.php');

/**
 * Description of Uebung
 * Die Klasse stellt Daten einer Uebung bereit und
 * handhabt alle dazugehoerigen Funktionen.
 *
 * @author Warken Andreas
 * @version 1.0
 */
class Uebung {

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
     * @return Uebungs Objekt
     */
    public static function load($ID) {
        if (is_numeric($ID)) {
            $sql = "SELECT *
            FROM uebung
            WHERE ID = '$ID' ;";

            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);

            if (mysql_num_rows($result) > 0) {
                $data = mysql_fetch_array($result);

                return Uebung::parse_result_as_objekt($data);
            } else {
                throw new FFSException(ExceptionText::uebung_not_found());
            }
        } else {
            throw new FFSException(ExceptionText::uebung_ID_not_numeric());
        }
    }

    /**
     * parse_result_as_objekt
     * erstellt aus einer Datenbankzeile ein Objekt der Klasse
     *
     * @param <type> $row DB-row
     * @return Uebungs Objekt
     */
    public static function parse_result_as_objekt($row) {
        $uebung = new Uebung();
        $uebung->setID($row["ID"]);
        $uebung->setOrt($row["ort"]);
        $uebung->setDatum($row["datum"]);
        return $uebung;
    }

    /**
     * save
     * speichert das Objekt anhand seiner ID
     */
    public function save() {
        if ($this->ort != NULL) {
            if ($this->datum != NULL) {
                $sql = "UPDATE uebung
                SET ort = '$this->ort', datum = '$this->datum'
                WHERE ID = '$this->ID';";

                $dbConnector = DbConnector::getInstance();
                $result = $dbConnector->execute_sql($sql);
            } else {
                throw new FFSException(ExceptionText::uebung_no_date());
            }
        } else {
            throw new FFSException(ExceptionText::uebung_no_location());
        }
    }

    /**
     * create_db_entry
     * legt ein neues Objekt mit seinen Parametern an
     */
    public function create_db_entry() {
        if ($this->ort != NULL) {
            if ($this->datum != NULL) {
                $sql = "INSERT INTO uebung ( ort, datum)
                    VALUES ( '$this->ort', '$this->datum' );";

                $dbConnector = DbConnector::getInstance();
                $result = $dbConnector->execute_sql($sql);
            } else {
                throw new FFSException(ExceptionText::uebung_no_date());
            }
        } else {
            throw new FFSException(ExceptionText::uebung_no_date());
        }
    }

    /**
     * delete_with_dependencys
     * loescht das Objekt mit den Abhaengigkeiten zu den Benutzern
     */
    public function delete_with_dependencys() {
        $sql = "DELETE FROM uebung
        WHERE ID = '$this->ID';";
        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);

        // dependencys
        $sql = "DELETE FROM r_uebungUser
        WHERE uebung_ID = '$this->ID';";
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
        if ($date_difference < Config::last_uebung()) {
            return Config::red();
        } elseif ($date_difference < (Config::last_uebung()+Config::uebung_warning_yellow())) {
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
            throw new FFSException(ExceptionText::uebung_ID_not_numeric());
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
