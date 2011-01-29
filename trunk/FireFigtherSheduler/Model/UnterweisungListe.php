<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UnterweisungListe
 * realisiert die m zu n Beziehung zwischen User und Unterweisung
 * 
 * @author awagen
 */
class UnterweisungListe {
    
    private $unterweisung_array;

    /**
     * Standard Konstruktor
     * mit Initialisierung
     */
    public function __construct() {
       $this->unterweisung_array=new ArrayObject() ;
    }

    public static function load($UserID){}



    /**
     * 
     * liefert den Warnungsstatus des neusten Unterweisungobjektes
     */
    public function get_warning_status(){
        // hm kann ich hier davon ausgehen dass ich immer es neuste durch swl sortierung vorne in der liste habe -> vorlaeufig ja
    }

    


}
?>
