<?php

require_once('../Model/Uebung.php');
require_once('../Model/UebungListe.php');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//schnelle unsaubere tests
function laden_liste(){
    $ueblist = UebungListe::load(1);

    $array = $ueblist->getUebung_array();
    if ($array[0] != NULL){echo "ungleich null",'<br>';}else{echo "eintrag eins geleich null ",'<br>';}
    echo $ueblist ->get_warning_status() , '<br>';
    foreach( $array as  $array_entry){
        echo $array_entry->getOrt() , '<br>';
        echo $array_entry->getDatum() , '<br>';
    }
}


laden_liste();




?>
