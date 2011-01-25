<?php
require_once('../Model/Unterweisung.php');

function laden(){
    $unterw =  Unterweisung::load(1);
    echo $unterw->getID() , '<br>';
    echo $unterw->getOrt() , '<br>';
    echo $unterw->getDatum() , '<br>';
    echo $unterw->getVerantID() , '<br>';
}
laden();

?>
