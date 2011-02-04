<?php

require_once('../Configuration/ExceptionText.php');
require_once('../Configuration/Config.php');
require_once('Strecke.php');
require_once('FFSException.php');

/**
 * Description of StreckeListe
 * realisiert die m zu n Beziehung zwischen User und Strecke
 *
 * @author Warken Andreas
 * @version Version 1.0
 */
class StreckeListe {

    public $strecke_array;

    /**
     * Standard Konstruktor
     * mit Initialisierung
     */
    public function __construct() {
        $this->strecke_array = new ArrayObject();
    }

    /**
     * load
     * laed zu der Uebergebenen UserID alle Streckeen
     * und fuegt sie dem strecke_array hinzu.
     *
     * @param <type> $UserID Die UserID des Datenbankeintrags
     * @return StreckeListe
     */
    public static function load($UserID) {
        if (is_numeric($UserID)) {
            $sql = "SELECT * FROM r_streckeUser
            INNER JOIN strecke
            ON r_streckeUser.strecke_ID = strecke.ID
            WHERE user_ID = '$UserID'
            ORDER BY datum DESC;";

            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);

            if (mysql_num_rows($result) > 0) {// wenn mehr als 0 eintraege
                $streckeliste = new StreckeListe;

                while ($row = mysql_fetch_array($result)) { //sequentielles durchgehen der zeilen
                    $streckeliste->append_strecke(
                            Strecke::parse_result_as_objekt($row));
                }
                return $streckeliste;
            } else {
                throw new FFSException(ExceptionText::streckeListe_no_strecke());
            }
        } else {
            throw new FFSException(ExceptionText::user_ID_not_numeric());
        }
    }

    /**
     * append_strecke
     * fuegt eine Strecke dem Array hinzu
     *
     * @param <type> $strecke
     */
    public function append_strecke($strecke) {
        if (is_a($strecke, "Strecke")) {
            $this->strecke_array->append($strecke);
        } else {
            throw new FFSException(ExceptionText::streckeListe_not_strecke());
        }
    }

    /**
     * get_warning_status
     * liefert den Warnungsstatus des neusten Streckeobjektes
     * (geht von einer sortierten Liste aus)
     */
    public function get_warning_status() {
        if (is_a($this->strecke_array[0], "Strecke")) {
            return $this->strecke_array[0]->get_warning_status();
        } else {
            return Config::red();
        }
    }

    public function getStrecke_array() {
        return $this->strecke_array;
    }

}

?>
