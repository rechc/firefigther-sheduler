<?php

require_once('DbConnector.php');
require_once('../Configuration/Config.php');
require_once('G26.php');
require_once('Uebung.php');
require_once('UebungListe.php');
require_once('Unterweisung.php');
require_once('UnterweisungListe.php');
require_once('Einsatz.php');
require_once('EinsatzListe.php');
require_once('Strecke.php');
require_once('StreckeListe.php');

/**
 * Description of User
 *
 * @author Warken Andreas
 * @version 1.0 Beta
 * 
 */
class User { // TODO sqls hier was bedeutet der Punkt in den Statements
    // joins überprüfen , performance
    // todo sql befehle andere sicherere , ggf schneller syntax
    // http://php.net/manual/de/pdo.prepared-statements.php

    private $ID;
    private $email;
    private $password;
    private $name;
    private $vorname;
    private $gebDat;
    /** LBZ ist Loeschbezirk. */
    private $lbz_ID;
    /** Agt ist Atemschutzgeraetetraeger. (boolean) */
    private $agt;
    private $rollen_ID;
    // folgendes sind Objekte
    private $g26_object;
    private $unterweisungListe_object;
    private $uebungListe_object;
    private $einsatzListe_object;
    private $streckeListe_object;

    /**
     * Standard Konstruktor
     * mit Initialisierungen
     */
    public function __construct() {
        $this->ID = 0;
        $this->email = "";
        $this->password = "";
        $this->name = "";
        $this->vorname = "";
        $this->gebDat = "";
        $this->lbz_ID = 0;
        $this->agt = false;
        $this->rollen_ID = 0;
        $this->g26_object = new G26();
        $this->unterweisungListe_object = new UnterweisungListe();
        $this->uebungListe_object = new UebungListe();
        $this->einsatzListe_object = new EinsatzListe();
        $this->streckeListe_object = new StreckeListe();
    }

    /**
     * get_user_by_login
     * Erfragt mittels Email und Password den Benutzer aus der DB
     * (ohne passwort Attribut zu liefern)
     *
     * @param <type> $email
     * @param <type> $password
     * @return User-Objekt 
     */
    public static function get_user_by_login($email, $password) {
        $sql = "SELECT ID, email, name, vorname, gebDat, lbz_ID, agt, rollen_ID " .
                "FROM user " .
                "WHERE ( email like '" . $email .
                "' ) AND ( " .
                "passwort = '" . $password . "')";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);

        return USER::parse_result_as_object($result);
    }

    /**
     * get_user
     * liefert den vollständigen User mit allen Listen (ausser passwort)
     * @param <type> $ID
     * @return User-Objekt 
     */
    public static function get_user($ID) {
        if (is_numeric($ID)) {
            $sql = "SELECT ID, email, name, vorname, gebDat, lbz_ID, agt, rollen_ID
                 FROM user WHERE ID = " . $ID;

            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);

            return USER::parse_result_as_object($result);
        } else {
            throw new FFSException(ExceptionText::user_ID_not_numeric());
        }
    }

    /**
     * parse_result_as_object
     * weist die Daten aus der DB einem UserObjekt zu
     * und liefert dies mit allen Listen (ausser passwort)
     * 
     * @param <type> $result MySql Result-Set
     * @return User-Objekt 
     */
    private static function parse_result_as_object($result) {
        if (mysql_num_rows($result) > 0) {
            // Benutzerdaten in ein Array auslesen.
            $data = mysql_fetch_array($result);

            $user = new User();
            $user->setID($data["ID"]);
            $user->setEmail($data["email"]);
            // $user->setPassword($data["password"]);
            $user->setName($data["name"]);
            $user->setVorname($data["vorname"]);
            $user->setGebDat($data["gebDat"]);
            $user->setLbz_ID($data["lbz_ID"]);
            $user->setAgt($data["agt"]);
            $user->setRollen_ID($data["rollen_ID"]);

            //folgend aus anderen tabellen
            $user->setG26_object(G26::load($data["ID"]));
            $user->setUnterweisungListe_object(UnterweisungListe::load($data["ID"]));
            $user->setUebungListe_object(UebungListe::load($data["ID"]));
            $user->setEinsatzListe_object(EinsatzListe::load($data["ID"]));
            $user->setStreckeListe_object(StreckeListe::load($data["ID"]));

            return $user;
        } else {
            throw new FFSException(ExceptionText::user_not_found());
        }
    }

    /**
     * save_without_pw
     * speichert Änderungen am User Objekt, ohne Berücksichtigung des Passworts
     * ohne abhaengige Listen wie G26
     */
    public function save_without_pw() {
        $sql = "UPDATE user
            SET email = '$this->email', name = '$this->name',
                vorname = '$this->vorname', gebDat = '$this->gebDat',
                lbz_ID = '$this->lbz_ID', agt = '$this->agt',
                rollen_ID = '$this->rollen_ID'
            WHERE ID = '$this->ID'";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);
    }

    /**
     * save_pw
     * speichert ein neues Passwort
     * ohneabhaengige Listen wie G26
     */
    public function save_pw() {
        $sql = "UPDATE user
            SET password = '$this->password'
            WHERE ID = '$this->ID'";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);
    }

    /**
     * create_db_entry
     * erstellt einen neuen Eintrag mit dem aktuellen Benutzer
     */
    public function create_db_entry() {
        if (($this->name != NULL) and ($this->vorname != NULL) and
                ($this->email != NULL) and ($this->password != NULL) and
                ($this->rollen_ID != NULL) and ($this->gebDat != NULL) and
                ($this->lbz_ID != NULL) and ( $this->agt != NULL)) {
            $sql = "INSERT INTO user ( name, vorname, email,  passwort , rollen_ID,
                    gebDat, lbz_ID, agt)
                VALUES ( '$this->name', '$this->vorname', '$this->email',
                    '$this->password', '$this->rollen_ID', '$this->gebDat',
                    '$this->lbz_ID', '$this->agt' )";

            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);
        } else {
            throw new FFSException(ExceptionText::user_missing_param());
        }
    }

    /**
     * delete_with_dependencys
     * loescht den Benutzer mit seinen direkten Abhaengigkeiten:
     * - alle user_ID Fremdschlüssel (uebung unterweisung strekce einsatz)
     * - zugehoeriges G26 Objekt
     */
    public function delete_with_dependencys() {
        $sql = "DELETE FROM user
        WHERE ID = '$this->ID';";
        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);

        // dependencys
        $sql = "DELETE FROM r_streckeUser
        WHERE user_ID = '$this->ID';";
        $result = $dbConnector->execute_sql($sql);

        $sql = "DELETE FROM r_uebungUser
        WHERE user_ID = '$this->ID';";
        $result = $dbConnector->execute_sql($sql);

        $sql = "DELETE FROM r_unterweisungUser
        WHERE user_ID = '$this->ID';";
        $result = $dbConnector->execute_sql($sql);

        $sql = "DELETE FROM r_einsatzUser
        WHERE user_ID = '$this->ID';";
        $result = $dbConnector->execute_sql($sql);

        $sql = "DELETE FROM g26
        WHERE userID = '$this->ID';";
        $result = $dbConnector->execute_sql($sql);
    }

    /**
     * get_warning_status
     * 
     * Rot wenn
     * G26.3 Untersuchung abgelaufen ODER
     * Einsatz UND Einsatzübung älter als 365 Tage ODER
     * Belastungsstrecke älter als 365 Tage
     * 
     * @return <type> integer, siehe Config.php 
     */
    public function get_warning_status() {
        // TODO implement UNTERWEISUNG in warnings genauso wie strecke also wenn rot alles rot
        $warning = 0;


        if (($this->g26_object == NULL) or
                (($this->einsatzListe_object == NULL) and ($this->uebungListe_object == NULL))
                or ($this->streckeListe_object == NULL)) {
            return Config::red(); // wenn Bedingung komplett fehlt
        }

        if ($this->einsatzListe_object == NULL) {
            $einsatzWarning = Config::yellow();
        } else {
            $einsatzWarning = $this->einsatzListe_object->get_warning_status();
        }

        if ($this->uebungListe_object == NULL) {
            $uebungWarning = Config::yellow();
        } else {
            $uebungWarning = $this->uebungListe_object->get_warning_status();
        }

        // so nun sollte es weiter keine "Nullpointer" mehr geben
        
        $g26Warning = $this->g26_object->get_warning_status();
        $streckeWarning = $this->streckeListe_object->get_warning_status();

        if (($g26Warning == Config::red()) or
                (($einsatzWarning == Config::red()) and ($uebungWarning == Config::red()))
                or ($streckeWarning == Config::red())) {
            return Config::red();
        }

        if (($g26Warning == Config::yellow()) or
                (($einsatzWarning == Config::yellow()) and ($uebungWarning == Config::yellow()))
                or ($streckeWarning == Config::yellow())) {
            return Config::yellow();
        } else {
            return Config::green();
        }
    }

    /**
     * is_admin
     * @return boolean
     */
    public function is_admin() {
        if ($this->rollen_ID == Config::admin_role_id()) {
            return true;
        }
        return false;
    }

    /**
     * is_agw
     * @return boolean
     */
    public function is_agw() {
        if ($this->rollen_ID == Config::agw_role_id()) {
            return true;
        }
        return false;
    }

    /**
     * is_manager
     * @return boolean
     */
    public function is_manager() {
        if ($this->rollen_ID == Config::manager_role_id()) {
            return true;
        }
        return false;
    }

    /**
     * is_member
     * @return boolean
     */
    public function is_member() {
        if ($this->rollen_ID == Config::member_role_id()) {
            return true;
        }
        return false;
    }

    //TODO @Rech brauchst du die methode als static ? wenn ja sag bescheid dann muss ich sie anpassen ansonsten nutz die delete_with_dependencys()
    public static function deleteUser($ID) {
        $sql = "DELETE FROM user WHERE id=" . $ID;
        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);
    }

    /**
     * erwartet einen vollen (betrunkenen) Benutzer ^^
     * wem was nicht an der Ausgabe gefaellt, schoener machen ohne zu fragen
     * @deprecated !
     */
    public function debug_output_full_user() {
        echo '<h3>', "User:", '</h3>', '<br>';
        echo "Email: ", $this->getEmail(), '<br>';
        echo "Name: ", $this->getName(), '<br>';
        echo "Vorname: ", $this->getVorname(), '<br>';
        echo "ID: ", $this->getID(), '<br>';
        echo "GebDat.: ", $this->getGebDat(), '<br>';
        echo "LoeschbezirkID: ", $this->getLbz_ID(), '<br>';
        echo "Atemschutzg.: ", $this->getAgt(), '<br>';
        echo "Rollen_ID: ", $this->getRollen_ID(), '<br>';
        echo "Warning Status: ", $this->get_warning_status(), '<br>';

        echo '<h3>', "G26:", '</h3>', '<br>';
        $g26 = $this->getG26_object();
        if ($g26 != NULL) {
            echo "GDatum: ", $g26->getDatum(), '<br>';
            echo "GGueltigBis: ", $g26->getGueltigBis(), '<br>';
            echo "GID: ", $g26->getID(), '<br>';
            echo "GUserID: ", $g26->getUserID(), '<br>';
            echo "Gwarning_status: ", $g26->get_warning_status(), '<br>';
        } else {
            echo "G26 null", '<br>';
        }

        echo '<h3>', "Unterweisungen:", '</h3>', '<br>';

        $uwlist = $this->getUnterweisungListe_object();
        if ($uwlist != NULL) {
            echo "UnterwBestWarning Status: ", $uwlist->get_warning_status(), '<br>';
            $uwarray = $uwlist->getUnterweisung_array();
            foreach ($uwarray as $uwarray_entry) {
                echo "NEXT", '<br>';
                echo "UOrt: ", $uwarray_entry->getOrt(), '<br>';
                echo "UDatum: ", $uwarray_entry->getDatum(), '<br>';
                echo "UID: ", $uwarray_entry->getID(), '<br>';
                echo "UVerantID: ", $uwarray_entry->getVerantID(), '<br>';
                echo "Uwarning_status: ", $uwarray_entry->get_warning_status(), '<br>';
                echo '<br>';
            }
        } else {
            echo "Unterweisung null", '<br>';
        }

        echo '<h3>', "Uebungen:", '</h3>', '<br>';

        $ublist = $this->getUebungListe_object();
        if ($ublist != NULL) {
            echo "UbBestWarning Status: ", $ublist->get_warning_status(), '<br>';
            $ubarray = $ublist->getUebung_array();
            foreach ($ubarray as $ubarray_entry) {
                echo "NEXT", '<br>';
                echo "UbOrt: ", $ubarray_entry->getOrt(), '<br>';
                echo "UbDatum: ", $ubarray_entry->getDatum(), '<br>';
                echo "UbID: ", $ubarray_entry->getID(), '<br>';
                echo "Ubwarning_status: ", $ubarray_entry->get_warning_status(), '<br>';
                echo '<br>';
            }
        } else {
            echo "Uebung null", '<br>';
        }

        echo '<h3>', "Strecke:", '</h3>', '<br>';

        $stlist = $this->getStreckeListe_object();
        if ($stlist != NULL) {
            echo "StBestWarning Status: ", $stlist->get_warning_status(), '<br>';
            $starray = $stlist->getStrecke_array();
            foreach ($starray as $starray_entry) {
                echo "NEXT", '<br>';
                echo "StOrt: ", $starray_entry->getOrt(), '<br>';
                echo "StDatum: ", $starray_entry->getDatum(), '<br>';
                echo "StID: ", $starray_entry->getID(), '<br>';
                echo "Stwarning_status: ", $starray_entry->get_warning_status(), '<br>';
                echo '<br>';
            }
        } else {
            echo "Strecke null", '<br>';
        }

        echo '<h3>', "Einsatz:", '</h3>', '<br>';

        $elist = $this->getEinsatzListe_object();
        if ($elist != NULL) {
            echo "EBestWarning Status: ", $elist->get_warning_status(), '<br>';
            $earray = $elist->getEinsatz_array();
            foreach ($earray as $earray_entry) {
                echo "NEXT", '<br>';
                echo "EOrt: ", $earray_entry->getOrt(), '<br>';
                echo "EDatum: ", $earray_entry->getDatum(), '<br>';
                echo "EID: ", $earray_entry->getID(), '<br>';
                echo "Ewarning_status: ", $earray_entry->get_warning_status(), '<br>';
                echo '<br>';
            }
        } else {
            echo "Einsatz null", '<br>';
        }
    }

    // ---------------- Down setter and getter ----------------
    // auto über alt+einfg  // geht anscheind nicht übers kontextmenü wie bei
    // java projekten, ps: plz stil beibehalten setter dann getter
    // TODO validierung feldlänge , numerical etc.

    public function setID($ID) {
        $this->ID = $ID;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setVorname($vorname) {
        $this->vorname = $vorname;
    }

    public function setGebDat($gebDat) {
        $this->gebDat = $gebDat;
    }

    public function setLbz_ID($lbz_ID) {
        $this->lbz_ID = $lbz_ID;
    }

    public function setAgt($agt) {
        $this->agt = $agt;
    }

    public function setRollen_ID($rollen_ID) {
        $this->rollen_ID = $rollen_ID;
    }

    public function setG26_object($g26_object) {
        if (is_a($g26_object, 'G26')) {
            $this->g26_object = $g26_object;
        } else {
            //fehlerhandling
        }
    }

    public function setUnterweisungListe_object($unterweisungListe_object) {
        $this->unterweisungListe_object = $unterweisungListe_object;
    }

    public function setUebungListe_object($uebungListe_object) {
        $this->uebungListe_object = $uebungListe_object;
    }

    public function setEinsatzListe_object($einsatzListe_object) {
        $this->einsatzListe_object = $einsatzListe_object;
    }

    public function setStreckeListe_object($streckeListe_object) {
        $this->streckeListe_object = $streckeListe_object;
    }

    public function getID() {
        return $this->ID;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getName() {
        return $this->name;
    }

    public function getVorname() {
        return $this->vorname;
    }

    public function getGebDat() {
        return $this->gebDat;
    }

    public function getLbz_ID() {
        return $this->lbz_ID;
    }

    public function getAgt() {
        return $this->agt;
    }

    public function getRollen_ID() {
        return $this->rollen_ID;
    }

    public function getG26_object() {
        return $this->g26_object;
    }

    public function getUnterweisungListe_object() {
        return $this->unterweisungListe_object;
    }

    public function getUebungListe_object() {
        return $this->uebungListe_object;
    }

    public function getEinsatzListe_object() {
        return $this->einsatzListe_object;
    }

    public function getStreckeListe_object() {
        return $this->streckeListe_object;
    }

}

?>
