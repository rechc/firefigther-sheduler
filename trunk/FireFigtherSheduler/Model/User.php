<?php
require_once('DbConnector.php');
require_once('../Configuration/Config.php');
require_once('G26.php');


/**
 * Description of User
 *
 * @author Warken Andreas
 * @version alpha
 * 
 */
class User { // TODO global gescheites fehlerhandling dazu rückgaben von mysql_query() noch anschauen, bzw noch typprüfungen "bool is_a ( object $object , string $class_name )"
    //dynamisches nachladen der objekt variablen,welche selten gebraucht werden, bei get anfrage ?

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



    /**
     * Standard Konstruktor
     */
    public function __construct(){}
    
    
    /**
     * get_user_by_login
     * Erfragt mittels Email und Password den Benutzer aus der DB
     * (ohne passwort Attribut zu liefern)
     * @param <type> $email
     * @param <type> $password
     * @return User-Objekt or NULL
     */
    public static function get_user_by_login($email, $password){
        // TODO validierung auf injections
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
     *
     * @param <type> $ID
     * @return User 
     */
    public static function get_user($ID){
         $sql = "SELECT ID, email, name, vorname, gebDat, lbz_ID, agt, rollen_ID
             FROM user WHERE ID = " . $ID;

         $dbConnector = DbConnector::getInstance();
         $result = $dbConnector->execute_sql($sql);

         return USER::parse_result_as_object($result);
    }

    
    /**
     * parse_result_as_object
     * weist die Daten aus der DB einem UserObjekt zu und liefert dies zurueck
     * @param <type> $result
     * @return User
     */
    private static function parse_result_as_object($result){
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


            return $user;
        }else {
            return NULL;
        }

    }


    /**
     * save_without_pw
     * speichert Änderungen am User Objekt, ohne Berücksichtigung des Passworts
     * ohne abhaengig Tabellen wie G26
     */
    public function save_without_pw(){
        //kann fehlschlagen falls benutzer gelöscht wurde -> handling
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
     * ohne abhaengig Tabellen wie G26
     */
    public function save_pw(){
         //kann fehlschlagen falls benutzer gelöscht wurde -> handling
        $sql = "UPDATE user
            SET password = '$this->password'
            WHERE ID = '$this->ID'";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);
    }


    /**
     * create_db_entry
     * erstellt einen neuen Eintrag mit dem aktuellen Benutzer
     *
     */
    public function create_db_entry(){
        //TODO missing lbz und agt, festellung kein uniqueness der email
        $sql= "INSERT INTO user ( name, vorname, email,  passwort , rollen_ID,
            gebDat)
        VALUES ( '$this->name', '$this->vorname', '$this->email',
                '$this->password', '$this->rollen_ID', '$this->gebDat' )";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);
    }


    public function delete_with_dependencys(){}

    // nur die abhaengigkeiten werden gelöscht also die m-n tables nicht aber die listen objekte
    // die 1zun werden direkt gelöscht
    // die m-n objekte werden manuell gelöscht das ein abhaengiges loeschen sehr unwahrscheinlich ist und diese listen sowieso gepflegt werden
    private function delete_dependencys(){}


    /**
     * get_warning_status
     * @return a String-Value: red, yellow or green
     */
    public function get_warning_status(){
        // TODO implement
        /*Rot wenn
G26.3 Untersuchung abgelaufen ODER
Einsatz UND Einsatzübung älter als 365 Tage ODER
Belastungsstrecke älter als 365 Tage*/
  
        return "green";
    }


    /**
     * is_admin
     * @return boolean
     */
    public function is_admin(){
        if ($this->rollen_ID == Config::admin_role_id()){ 
            return true;
        }
        return false;
    }


    /**
     * is_agw
     * @return boolean
     */
    public function is_agw(){
        if ($this->rollen_ID == Config::agw_role_id()){
            return true;
        }
        return false;
    }


    /**
     * is_manager
     * @return boolean
     */
    public function is_manager(){
        if ($this->rollen_ID == Config::manager_role_id()){
            return true;
        }
        return false;
    }
    

    /**
     * is_member
     * @return boolean
     */
    public function is_member(){
        if ($this->rollen_ID == Config::member_role_id()){
            return true;
        }
        return false;
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
        if (is_a($g26_object, 'G26')){
            $this->g26_object = $g26_object;
        }else{
            //fehlerhandling
        }   
    }

    public function setUnterweisungListe_object($unterweisungListe_object) {
        $this->unterweisungListe_object = $unterweisungListe_object;
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



}

?>
