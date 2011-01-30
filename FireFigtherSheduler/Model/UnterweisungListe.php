<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UnterweisungListe
 * realisiert die m zu n Beziehung zwischen User und Unterweisung
 * 
 * @author Warken Andreas
 * @version alpha+
 */
class UnterweisungListe {
    
    public $unterweisung_array;

    
    /**
     * Standard Konstruktor
     * mit Initialisierung
     */
    public function __construct() {
       $this->unterweisung_array=new ArrayObject() ;
    }


    /**
     *
     * @param <type> $UserID
     * @return UnterweisungListe
     */
    public static function load($UserID){

        $sql="SELECT * FROM r_unterweisungUser
            INNER JOIN unterweisung
            ON r_unterweisungUser.unterweisung_ID = unterweisung.ID
            WHERE user_ID = $UserID
            ORDER BY datum DESC";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);

        if (mysql_num_rows($result) > 0) {// wenn mehr als 0 eintraege

            $unterweisungsliste = new UnterweisungListe;

            while($row = mysql_fetch_array($result)){ //sequentielles durchgehen der zeilen
                 $unterweisungsliste->append_unterweisung(
                         Unterweisung::parse_result_as_objekt($row));
             }
             return $unterweisungsliste;

        }else{
            return NULL;
        }
    }


    /**
     *
     * @param <type> $unterweisung
     */
    public function append_unterweisung($unterweisung){
        if (is_a ( $unterweisung , "Unterweisung" )){
            $this-> unterweisung_array->append($unterweisung);
        }
    }


    /**
     * 
     * liefert den Warnungsstatus des neusten Unterweisungobjektes
     */
    public function get_warning_status(){
        // hm kann ich hier davon ausgehen dass ich immer es neuste durch swl sortierung vorne in der liste habe -> vorlaeufig ja
        if (is_a ( $this->unterweisung_array[0] , "Unterweisung" )){
            return $this->unterweisung_array[0]->get_warning_status();
        }else{
            return Config::red(); // vorläufig ka ... wenn halt keine da ist
        }

    }

    /**
     *
     * @return <type> 
     */
    public function getUnterweisung_array() {
        return $this->unterweisung_array;
    }



}
?>
