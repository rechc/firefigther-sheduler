<?php

require_once('../Configuration/ExceptionText.php');
require_once('../Configuration/Config.php');
require_once('Unterweisung.php');
require_once('FFSException.php');

/**
 * Description of UnterweisungListe
 * realisiert die m zu n Beziehung zwischen User und Unterweisung
 * 
 * @author Warken Andreas
 * @version Version 1.0
 */
class UnterweisungListe {

    public $unterweisung_array;

    /**
     * Standard Konstruktor
     * mit Initialisierung
     */
    public function __construct() {
        $this->unterweisung_array = new ArrayObject();
    }

    /**
     * load
     * laed zu der Uebergebenen UserID alle Unterweisungen
     * und fuegt sie dem unterweisung_array hinzu.
     *
     * @param <type> $UserID Die UserID des Datenbankeintrags
     * @return UnterweisungListe
     */
    public static function load($UserID) {
        if (is_numeric($UserID)) {
            $sql = "SELECT * FROM r_unterweisungUser
            INNER JOIN unterweisung
            ON r_unterweisungUser.unterweisung_ID = unterweisung.ID
            WHERE user_ID = '$UserID'
            ORDER BY datum DESC;";

            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);

            if (mysql_num_rows($result) > 0) {// wenn mehr als 0 eintraege
                $unterweisungsliste = new UnterweisungListe;

                while ($row = mysql_fetch_array($result)) { //sequentielles durchgehen der zeilen
                    $unterweisungsliste->append_unterweisung(
                            Unterweisung::parse_result_as_objekt($row));
                }
                return $unterweisungsliste;
            } else {
                throw new FFSException(ExceptionText::unterweisungListe_no_unterweisung());
            }
        } else {
            throw new FFSException(ExceptionText::user_ID_not_numeric());
        }
    }

    /**
     * append_unterweisung
     * fuegt eine Unterweisung dem Array hinzu
     *
     * @param <type> $unterweisung ein Unterweisungsobjekt
     */
    public function append_unterweisung($unterweisung) {
        if (is_a($unterweisung, "Unterweisung")) {
            $this->unterweisung_array->append($unterweisung);
        } else {
            throw new FFSException(ExceptionText::unterweisungListe_not_unterweisung());
        }
    }

    /**
     * get_warning_status
     * liefert den Warnungsstatus des neusten Unterweisungobjektes
     * (geht von einer sortierten Liste aus)
     */
    public function get_warning_status() {
        if (is_a($this->unterweisung_array[0], "Unterweisung")) {
            return $this->unterweisung_array[0]->get_warning_status();
        } else {
            return Config::red(); // vorläufig ka ... wenn halt keine da ist
        }
    }

    // ---------------- Down setter and getter ----------------

    public function getUnterweisung_array() {
        return $this->unterweisung_array;
    }

}

?>
