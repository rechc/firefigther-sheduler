<?php

require_once('DbConnector.php');
require_once('FFSException.php');
require_once('../Configuration/Config.php');
require_once('../Configuration/ExceptionText.php');

/**
 * Description of G26
 * Die Klasse stellt Daten einer G26 bereit und
 * handhabt alle dazugehoerigen Funktionen.
 *
 * @author Warken Andreas
 * @version 1.0
 */
class G26 {

    private $ID;
    private $userID;
    private $datum;
    private $gueltigBis;

    /**
     * Standard Konstruktor
     */
    public function __construct() {
        
    }

    /**
     * load
     * laed das Objekt aus der DB anhand seiner ID
     *
     * @param <type> $ID Die Id des Datenbankeintrags
     * @return G26-Objekt
     */
    public static function load($userID) {
        if ((is_numeric($userID)or $userID == NULL)) {
            $sql = "SELECT *
            FROM g26
            WHERE userID = '$userID' ";

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
            } else {
                throw new FFSException(ExceptionText::g26_not_found());
            }
        } else {
            throw new FFSException(ExceptionText::g26_ID_not_numeric());
        }
    }

    /**
     * save
     * speichert das Objekt anhand seiner ID
     */
    public function save() {
        if ($this->datum != NULL) {
            if ($this->userID != NULL) {
                if ($this->gueltigBis != NULL) {
                    $sql = "UPDATE g26
                        SET userID = '$this->userID', datum = '$this->datum',
                            gueltigBis = '$this->gueltigBis'
                        WHERE ID = '$this->ID'";

                    $dbConnector = DbConnector::getInstance();
                    $result = $dbConnector->execute_sql($sql);
                } else {
                    throw new FFSException(ExceptionText::g26_no_date());
                }
            } else {
                throw new FFSException(ExceptionText::g26_no_userID());
            }
        } else {
            throw new FFSException(ExceptionText::g26_no_gueltigBis());
        }
    }

    /**
     * create_db_entry
     * legt ein neues Objekt mit seinen Parametern an
     */
    public function create_db_entry() {
        if ($this->datum != NULL) {
            if ($this->userID != NULL) {
                if ($this->gueltigBis != NULL) {
                    $sql = "INSERT INTO g26 ( userID, datum, gueltigBis)
                        VALUES ( '$this->userID', '$this->datum', '$this->gueltigBis' )";

                    $dbConnector = DbConnector::getInstance();
                    $result = $dbConnector->execute_sql($sql);
                } else {
                    throw new FFSException(ExceptionText::g26_no_date());
                }
            } else {
                throw new FFSException(ExceptionText::g26_no_userID());
            }
        } else {
            throw new FFSException(ExceptionText::g26_no_gueltigBis());
        }
    }

    /**
     * delete
     * löscht das Objekt anhand seiner ID
     */
    public function delete() {
        $sql = "DELETE FROM g26
             WHERE ID = '$this->ID'";
        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);
    }

    /**
     * get_warning_status
     * liefert den Warnungs-Status des Objekts
     * @return <type> integer, siehe Config.php 
     */
    public function get_warning_status() {
        $timestamp = time(); //lesbar: //$current_date = date("d.m.Y",$timestamp);
        $gueltigBis_formated = mktime(0, 0, 0,
                        (int) substr($this->gueltigBis, 5, 2),
                        (int) substr($this->gueltigBis, 8, 2),
                        (int) substr($this->gueltigBis, 0, 4));
        $date_difference = floor(($gueltigBis_formated - $timestamp) / 86400);

        if ($date_difference < 0) {
            return Config::red();
        } elseif ($date_difference < Config::g26_yellow_state()) {
            return Config::yellow();
        } else {
            return Config::green();
        }
    }

    // ---------------- Down setter and getter ----------------

    public function setID($ID) {
        if ((is_numeric($ID)) or ($ID == NULL)) {
            $this->ID = $ID;
        } else {
            throw new FFSException(ExceptionText::g26_ID_not_numeric());
        }
    }

    public function setUserID($userID) {
        if ((is_numeric($userID)) or ($userID == NULL)) {
            $this->userID = $userID;
        } else {
            throw new FFSException(ExceptionText::g26_userID_not_numeric());
        }
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function setGueltigBis($gueltigBis) {
        $this->gueltigBis = $gueltigBis;
    }

    public function getID() {
        return $this->ID;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function getGueltigBis() {
        return $this->gueltigBis;
    }

}

?>
