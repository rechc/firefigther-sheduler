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

    //unterweisung

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

    //unterweisungListe

    public static function unterweisungListe_no_unterweisung() {
        return "Zu dem angegebenen Benutzer wurde keine Unterweisung gefunden";
    }

    public static function unterweisungListe_not_unterweisung() {
        return "Das zugewiesene Objekt ist nicht vom Typ Unterweisung";
    }

    //uebung

    public static function uebung_not_found() {
        return "Es wurde keine Uebung zu den angegebenen Paramtern gefunden";
    }

    public static function uebung_no_date() {
        return "Es wurde kein Datum zu der Uebung angegeben";
    }

    public static function uebung_no_location() {
        return "Es wurde kein Ort zur Uebung angegeben";
    }

    public static function uebung_ID_not_numeric() {
        return "Die ID der Uebung muss ein numerischer Wert sein";
    }

    //uebungListe
    public static function uebungListe_no_uebung() {
        return "Zu dem angegebenen Benutzer wurde keine Uebung gefunden";
    }

    public static function uebungListe_not_uebung() {
        return "Das zugewiesene Objekt ist nicht vom Typ Uebung";
    }



    //strecke
    public static function strecke_not_found() {
        return "Es wurde keine Strecke zu den angegebenen Paramtern gefunden";
    }

    public static function strecke_no_date() {
        return "Es wurde kein Datum zu der Strecke angegeben";
    }

    public static function strecke_no_location() {
        return "Es wurde kein Ort zur Strecke angegeben";
    }

    public static function strecke_ID_not_numeric() {
        return "Die ID der Strecke muss ein numerischer Wert sein";
    }

    //streckeListe
    public static function streckeListe_no_strecke() {
        return "Zu dem angegebenen Benutzer wurde keine Strecke gefunden";
    }

    public static function streckeListe_not_strecke() {
        return "Das zugewiesene Objekt ist nicht vom Typ Strecke";
    }

    //einsatz
    public static function einsatz_not_found() {
        return "Es wurde keine Einsatz zu den angegebenen Paramtern gefunden";
    }

    public static function einsatz_no_date() {
        return "Es wurde kein Datum zu der Einsatz angegeben";
    }

    public static function einsatz_no_location() {
        return "Es wurde kein Ort zur Einsatz angegeben";
    }

    public static function einsatz_ID_not_numeric() {
        return "Die ID der Einsatz muss ein numerischer Wert sein";
    }

    //einsatzListe
    public static function einsatzListe_no_einsatz() {
        return "Zu dem angegebenen Benutzer wurde keine Einsatz gefunden";
    }

    public static function einsatzListe_not_einsatz() {
        return "Das zugewiesene Objekt ist nicht vom Typ Einsatz";
    }


        //user

    public static function user_ID_not_numeric() {
        return "Die ID vom User muss ein numerischer Wert sein";
    }

}

?>
