<?php
/*
 * Description
 *
 *@author Rech Christian
 *@version alpha
 */

//define('ABSPATH', dirname(__FILE__).'\\');
require_once 'XML.php';
//require_once '../Model/User.php';

$ID=$_GET["userID"];

if($ID != ""){
//    $user = User::get_user($ID);
     XML::getXML($ID,"Luky", "Luke", "email", "01.01.1901");
//    XML::getXML($user->getID(),$user->getVorname(),$user->getName(),$user->getEmail(),$user->getGebDat());
}


?>