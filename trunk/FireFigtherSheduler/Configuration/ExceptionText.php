<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExceptionText
 *
 * @author awagen
 */
class ExceptionText {

    //put your code here
    public static function xx() {

    }

    public static function unterweisung_not_found() {
        return "Es wurde keine Unterweisung zu den angegebenen Paramtern gefunden";
    }

    public static function unterweisung_no_date() {
        return "Es wurde kein Datum zu der Unterweisung angegeben";
    }

    public static function unterweisung_no_location() {
        return "Es wurde kein Ort zur Unterweisung angegeben";
    }

    public static function unterweisung_verantID_not_numeric() {
        return "Die VerantwortlichenID der Untweisung muss ein numerischer Wert sein";
    }

    public static function unterweisung_ID_not_numeric() {
        return "Die ID der Untweisung muss ein numerischer Wert sein";
    }

    public static function  unterweisungListe_no_unterweisung(){
        return "Zu dem angegebenen Benutzer wurde keine Unterweisung gefunden";
    }
     public static function  unterweisungListe_not_unterweisung(){
        return "Das zugewiesene Objekt ist nicht vom Typ Unterweisung";
    }

}

?>
