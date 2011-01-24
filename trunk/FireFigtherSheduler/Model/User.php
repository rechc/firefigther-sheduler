<?php
require_once('DbConnector.php');
require_once('../Configuration/Config.php');


/**
 * Description of User
 *
 * @author awagen
 * @version alpha
 * 
 */
class User {

    private $ID;
    private $email;
    private $password;
    private $name;
    private $vorname;
    private $gebDat;
    private $lbz_ID; // ist nochmal was
    private $agt; // ist nochmal was 
    private $rollen_ID;

    /**
     * Standard Konstruktor
     */
    public function __construct(){}
    

    /**
     * save_without_pw
     * speichert Änderungen am User Objekt, ohne Berücksichtigung des Passworts
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
     * get_user_by_login
     * Erfragt mittels Email und Password den Benutzer aus der DB
     * (ohne passwort Attribut zu liefern)
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

            return $user;
        }else {
            return NULL;
        }
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


    /**
     * get_warning_status
     * @return a String-Value: red, yellow or green
     */
    public function get_warning_status(){
        // TODO implement
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

    
    /**
     * get_userarray_for_manager_view
     * Liefert ein Array aller User (ohne passwort)
     * @return User-ArrayObject
     */
    public static function get_userarray_for_manager_view(){
        //ist glaub net so ganz sauber dass die methode in user ist .... bitte um statement
         $user_array=new ArrayObject();

         $sql = "SELECT ID, email, name, vorname, gebDat, lbz_ID, agt, rollen_ID
             FROM user";

         $dbConnector = DbConnector::getInstance();
         $result = $dbConnector->execute_sql($sql);

         while($row = mysql_fetch_array($result)){ //sequentielles durchgehen der zeilen

            $user = new User();
            $user->setID($row["ID"]);
            $user->setEmail($row["email"]);
            $user->setName($row["name"]);
            $user->setVorname($row["vorname"]);
            $user->setGebDat($row["gebDat"]);
            $user->setLbz_ID($row["lbz_ID"]);
            $user->setAgt($row["agt"]);
            $user->setRollen_ID($row["rollen_ID"]);

            $user_array->append($user);
         }
         return $user_array;
     }


    // ---------------- Down setter and getter ----------------
    // auto über alt+einfg  // geht anscheind nicht übers kontextmenü wie bei
    // java projekten

    // TODO validierung feldlänge , numerical etc.
    public function getID() {
        return $this->ID;
    }

    public function setID($ID) {
        $this->ID = $ID;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getVorname() {
        return $this->vorname;
    }

    public function setVorname($vorname) {
        $this->vorname = $vorname;
    }

    public function getGebDat() {
        return $this->gebDat;
    }

    public function setGebDat($gebDat) {
        $this->gebDat = $gebDat;
    }

    public function getLbz_ID() {
        return $this->lbz_ID;
    }

    public function setLbz_ID($lbz_ID) {
        $this->lbz_ID = $lbz_ID;
    }

    public function getAgt() {
        return $this->agt;
    }

    public function setAgt($agt) {
        $this->agt = $agt;
    }

    public function getRollen_ID() {
        return $this->rollen_ID;
    }

    public function setRollen_ID($rollen_ID) {
        $this->rollen_ID = $rollen_ID;
    }

}

//schnell tests
function testusr(){
    $email = "t.lana@ff-riegelsberg.de";
    $password = 4711;

    $user = User::get_user_by_login($email, $password);


    echo $user->getEmail();
    echo $user->getName();
    echo $user->getVorname();
    
    $user->setName("Lan");
    $user->save_without_pw();



}

function testcreate(){
    $user = new User;
    $user->setEmail('emai@email.de');
    $user->setGebDat("2001-10-10");
    $user->setName('name');
    $user->setPassword("passwd");
    $user->setVorname("vorname");
    $user->setRollen_ID(10);
    $user->create_db_entry();
}

function testusrlist(){
    $user_array=  User::get_userarray_for_manager_view();
    foreach($user_array as $user){
        echo $user->getName(),"<br />";
    }
}

//testusr();
 //testcreate();
testusrlist();


?>
