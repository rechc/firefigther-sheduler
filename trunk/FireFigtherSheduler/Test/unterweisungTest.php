<?php
require_once('../Model/Unterweisung.php');
require_once('../Model/UnterweisungListe.php');

function laden(){
    try {
        $unterw =  Unterweisung::load(1);
        echo $unterw->getID() , '<br>';
        echo $unterw->getOrt() , '<br>';
        echo $unterw->getDatum() , '<br>';
        echo $unterw->getVerantID() , '<br>';

    } catch (FFSException $exc) {
        echo "sds";
    }

    
}
//laden();


function laden_liste(){
    $unterwlist = UnterweisungListe::load(1);

    $array = $unterwlist->getUnterweisung_array();
    if ($array[0] != NULL){echo "ungleich null",'<br>';}else{echo "eintrag eins geleich null ",'<br>';}
    echo $unterwlist->get_warning_status() , '<br>';
    foreach( $array as  $array_entry){
        echo $array_entry->getOrt() , '<br>';
        echo $array_entry->getDatum() , '<br>';
    }
}


//laden_liste();
laden();

?>
