<?php

require_once('../Configuration/ExceptionText.php');
require_once('../Configuration/Config.php');
require_once('Uebung.php');
require_once('FFSException.php');

/**
 * Description of UebungListe
 * realisiert die m zu n Beziehung zwischen User und Uebung
 *
 * @author Warken Andreas
 * @version Version 1.0
 */
class UebungListe {

    public $uebung_array;

    /**
     * Standard Konstruktor
     * mit Initialisierung
     */
    public function __construct() {
        $this->uebung_array = new ArrayObject();
    }

    /**
     * load
     * laed zu der Uebergebenen UserID alle Uebungen
     * und fuegt sie dem uebung_array hinzu.
     *
     * @param <type> $UserID Die UserID des Datenbankeintrags
     * @return UebungListe
     */
    public static function load($UserID) {
        if (is_numeric($UserID)) {
            $sql = "SELECT * FROM r_uebungUser
            INNER JOIN uebung
            ON r_uebungUser.uebung_ID = uebung.ID
            WHERE user_ID = '$UserID'
            ORDER BY datum DESC;";

            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);

            if (mysql_num_rows($result) > 0) {// wenn mehr als 0 eintraege
                $uebungliste = new UebungListe;

                while ($row = mysql_fetch_array($result)) { //sequentielles durchgehen der zeilen
                    $uebungliste->append_uebung(
                            Uebung::parse_result_as_objekt($row));
                }
                return $uebungliste;
            } else {
                throw new FFSException(ExceptionText::uebungListe_no_uebung());
            }
        } else {
            throw new FFSException(ExceptionText::user_ID_not_numeric());
        }
    }

    /**
     * append_uebung
     * fuegt eine Uebung dem Array hinzu
     *
     * @param <type> $uebung
     */
    public function append_uebung($uebung) {
        if (is_a($uebung, "Uebung")) {
            $this->uebung_array->append($uebung);
        } else {
            throw new FFSException(ExceptionText::uebungListe_not_uebung());
        }
    }

    /**
     * get_warning_status
     * liefert den Warnungsstatus des neusten Uebungobjektes
     * (geht von einer sortierten Liste aus)
     */
    public function get_warning_status() {
        if (is_a($this->uebung_array[0], "Uebung")) {
            return $this->uebung_array[0]->get_warning_status();
        } else {
            return Config::red(); 
        }
    }

    public function getUebung_array() {
        return $this->uebung_array;
    }

}

?>
