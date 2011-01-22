<?php
include('DbConnector.php');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author awagen
 */
class User {

    private $ID;
    private $email;
    private $password;
    private $name;
    private $vorname;
    private $gebDat;
    private $lbz_ID;
    private $agt;
    private $rollen_ID;

    /**
     * 
     */
    public function __construct(){}

    /**
     *
     */
    function save_without_pw(){}

    /**
     *
     */
    function save_pw(){}

    /**
     * 
     */
    public static function get_user_by_login($email, $password){
        // TODO validierung auf injections 
        $sql = "SELECT ID, email, name, vorname " .
            "FROM user " .
            "WHERE ( email like '" . $email .
            "' ) AND ( " .
            "passwort = '" . $password . "')";
        
        $dbConnector = new DbConnector();
        $result = $dbConnector->execute_sql($sql);

        if (mysql_num_rows($result) > 0) {
            // Benutzerdaten in ein Array auslesen.
            $data = mysql_fetch_array($result);
            
            $user = new User();
            $user->setID($data["ID"]);
            $user->setEmail($data["email"]);
            $user->setPassword($data["password"]);
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
     *
     */
    function get_warning_status(){}




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
}

//testusr();




?>
