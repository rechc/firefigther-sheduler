<?php
/*
 * Description
 *
 *@author Rech Christian
 *@version alpha
 */

//define('ABSPATH', dirname(__FILE__).'\\');
require_once 'XML.php';
require_once '../Model/User.php';

$ID= $_GET["userID"];

if($ID != ""){
    $user2 = User::get_user($ID);
    $user = new User();
    $user->setName("Name");
    $user->setVorname("Vorname");
    $user->setEmail("asd@asd.de");
    $user->setGebDat("01.01.1900");
    XML::getXML($ID,$user->getName(), $user->getVorname(),$user->getEmail(),$user->getGebDat());
}


?>