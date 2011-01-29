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


    //use case ein benutzer wird gelöscht ... alle referenzen zu untwerweisungen und anderen dingen sollten dann auch gelöscht werden...
    // macht viel arbeit ... vllt einfach alles referenzen einer unterweisung löschen wenn die unterweisung gelöscht wird ....
    // hm nein doch mehr arbeit weil: benutzer wird gelöscht , neuer wird angelegt und bekommt dessen id ---> fehler
    // so hab mir mal was zu reuse ids in dbs durchgelesen , es sollte zwar nciht vorkommen , tut es in manchen fällen aber doch
    // und es gibt datenbanken die standardmäßig ein reuse machen ... grad bei nachrichtensystemen ist das wichtig ...
    // also drauf verlassen dass ein key nciht wiederverwendet wird ===> nein , also auch alle abhängigkeiten löschen = sauberer
    public static function delete_user_references($UserID){}

    public static function is_unterweisung_referenced(){
        return false;
    }


    /**
     * 
     * liefert den Warnungsstatus des neusten Unterweisungobjektes
     */
    public function get_warning_status(){
        // hm kann ich hier davon ausgehen dass ich immer es neuste durch swl sortierung vorne in der liste habe -> vorlaeufig ja
    }

    


}
?>
