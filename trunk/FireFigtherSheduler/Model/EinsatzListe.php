<?php

require_once('../Configuration/ExceptionText.php');
require_once('../Configuration/Config.php');
require_once('Einsatz.php');
require_once('FFSException.php');

/**
 * Description of EinsatzListe
 * realisiert die m zu n Beziehung zwischen User und Einsatz
 *
 * @author Warken Andreas
 * @version Version 1.0
 */
class EinsatzListe {

    public $einsatz_array;

    /**
     * Standard Konstruktor
     * mit Initialisierung
     */
    public function __construct() {
        $this->einsatz_array = new ArrayObject();
    }

    /**
     * load
     * laed zu der Uebergebenen UserID alle Einsatzen
     * und fuegt sie dem einsatz_array hinzu.
     *
     * @param <type> $UserID Die UserID des Datenbankeintrags
     * @return EinsatzListe
     */
    public static function load($UserID) {
        if (is_numeric($UserID)) {
            $sql = "SELECT * FROM r_einsatzUser
            INNER JOIN einsatz
            ON r_einsatzUser.einsatz_ID = einsatz.ID
            WHERE user_ID = '$UserID'
            ORDER BY datum DESC;";

            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);

            if (mysql_num_rows($result) > 0) {// wenn mehr als 0 eintraege
                $einsatzliste = new EinsatzListe;

                while ($row = mysql_fetch_array($result)) { //sequentielles durchgehen der zeilen
                    $einsatzliste->append_einsatz(
                            Einsatz::parse_result_as_objekt($row));
                }
                return $einsatzliste;
            } else {
                throw new FFSException(ExceptionText::einsatzListe_no_einsatz());
            }
        } else {
            throw new FFSException(ExceptionText::user_ID_not_numeric());
        }
    }

    /**
     * append_einsatz
     * fuegt eine Einsatz dem Array hinzu
     *
     * @param <type> $einsatz
     */
    public function append_einsatz($einsatz) {
        if (is_a($einsatz, "Einsatz")) {
            $this->einsatz_array->append($einsatz);
        } else {
            throw new FFSException(ExceptionText::einsatzListe_not_einsatz());
        }
    }

    /**
     * get_warning_status
     * liefert den Warnungsstatus des neusten Einsatzobjektes
     * (geht von einer sortierten Liste aus)
     */
    public function get_warning_status() {
        if (is_a($this->einsatz_array[0], "Einsatz")) {
            return $this->einsatz_array[0]->get_warning_status();
        } else {
            return Config::red();
        }
    }

    public function getEinsatz_array() {
        return $this->einsatz_array;
    }

}

?>
