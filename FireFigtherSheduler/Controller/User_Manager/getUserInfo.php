<?php
/*
 * Description
 *
 *@author Rech Christian
 *@version alpha
 */

define('ABSPATH', dirname(__FILE__).'\\');
require_once ABSPATH . 'XML.php';
//require_once ABSPATH . '../User.php';
//include '../User.php';

$ID=$_GET["userID"];

if($ID != ""){
//    $user = User::get_user($ID);
     XML::getXML("Luky", "Luke", "email", "01.01.2011");
//    XML::getXML($user->getVorname(),$user->getName());
}


?>