<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author awagen
 * @version beta
 */
class Config {
    //put your code here

    public static function xx(){}

    // --------- for user ---------
    public static function admin_role_id(){
        return 50;
    }

    public static function agw_role_id(){
        return 40;
    }

    public static function manager_role_id(){
        return 30;
    }

    public static function member_role_id(){
        return 10;
    }

    /**
     * 
     * max Zeitabstand zur letzten Einsatzübung
     * @return Anzahl Tage
     */
    public static function last_uebung(){
        return -365;
    }

    /**
     *
     * max Zeitabstand zum letzten Einsatz
     * @return Anzahl Tage
     */
    public static function last_einsatz(){
        return -365;
    }

    public static function last_strecke(){
        return -365;
    }


    /**
     * wieviel tage vor ablauf der zeit der gelbe warning status angezeigt wird
     * @return <type>
     */
    public static function unterweisung_warning_yellow(){
        return 60;
    }

    public static function uebung_warning_yellow(){
        return 60;
    }

    public static function einsatz_warning_yellow(){
        return 60;
    }

    public static function strecke_warning_yellow(){
        return 60;
    }
    

    /**
     *
     * max Zeitabstand zur letzten belastungsstrecke
     * @return Anzahl Tage
     */
    public static function last_loading_track(){//uebersetzung ka....
        return 356;
    }

    public static function g26_yellow_state(){
        return 60;//vorläufig normale zeit 1068 Tage = 3 JAhre
    }

    public static function green(){
        return 0;
    }
    public static function yellow(){
        return 1;
    }
    public static function red(){
        return 2;
    }



            /*Rot wenn
G26.3 Untersuchung abgelaufen ODER
Einsatz UND Einsatzübung älter als 365 Tage ODER
Belastungsstrecke älter als 365 Tage*/

    



    // --------- for db ---------

    /*    const mysqlhost="stud-i-pr2.htw-saarland.de"; // MySQL-Host angeben
    const mysqldb="FFS"; // Gewuenschte Datenbank angeben
    const mysqluser="htwmaps"; // MySQL-User angeben
    const mysqlpwd="g00gl3m4p5k1ll4"; // Passwort angeben


    var $mysqlhost="feuerwehr-saar.de"; // MySQL-Host angeben
    var $mysqldb="db1057229-2"; // Gewuenschte Datenbank angeben
    var $mysqluser="dbu1057229"; // MySQL-User angeben
    var $mysqlpwd="h0m3b0y"; // Passwort angeben
    */

    public static function mysqlhost(){
        return "stud-i-pr2.htw-saarland.de";
    }

    public static function mysqldb(){
        return "FFS";
    }

    public static function mysqluser(){
        return "htwmaps";
    }

    public static function mysqlpwd(){
        return "g00gl3m4p5k1ll4";
    }




    



}
?>
