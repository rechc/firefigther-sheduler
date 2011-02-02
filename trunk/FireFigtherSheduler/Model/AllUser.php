<?php
    require_once('User.php');
    require_once('DbConnector.php');
    require_once('../Configuration/Config.php');
    
 class AllUser {
    /**
     * Standard Konstruktor
     */
    public function __construct(){}

    /**
     * get_userarray_for_manager_view
     * Liefert ein Array aller User (ohne passwort)
     * @return User-ArrayObject
     */
    public static function get_userarray_for_manager_view(){
        //ist glaub net so ganz sauber dass die methode in user ist .... bitte um statement
         $user_array = new ArrayObject();

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
 }
?>
