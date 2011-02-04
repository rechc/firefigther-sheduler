<?php
require_once('../Model/Strecke.php');
require_once('../Model/StreckeListe.php');


//schnelle unsaubere tests
function laden_liste(){
    $ueblist = StreckeListe::load(1);

    $array = $ueblist->getStrecke_array();
    if ($array[0] != NULL){echo "ungleich null",'<br>';}else{echo "eintrag eins geleich null ",'<br>';}
    echo $ueblist ->get_warning_status() , '<br>';
    foreach( $array as  $array_entry){
        echo $array_entry->getOrt() , '<br>';
        echo $array_entry->getDatum() , '<br>';
    }
}


laden_liste();




?>
