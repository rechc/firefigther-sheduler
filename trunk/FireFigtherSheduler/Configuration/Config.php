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
