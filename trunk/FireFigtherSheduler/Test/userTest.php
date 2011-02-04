<?php
require_once('../Model/User.php');
require_once('../Model/AllUser.php');
require_once('../Model/UnterweisungListe.php');
require_once('../Model/Unterweisung.php');

//schnelle unsaubere tests

function test_ausgabe($user){
    echo $user->getEmail();
    echo "<br>";
    echo $user->getName();
    echo "<br>";
    echo $user->getVorname();
    echo "<br>";
    echo "G26: ";
    if ($user->getG26_object() != NULL){

        echo $user->getG26_object()->getGueltigBis();//->delete(); <- tested
    }else{echo "null";}
    echo "<br>";
    echo '<br>', "unterweisung: ",'<br>';
    $uwlist = $user->getUnterweisungListe_object();
    echo "warning",$uwlist->get_warning_status(), '<br>';

    $array = $uwlist->getUnterweisung_array();
    if ($array[0] != NULL){}else{echo "eintrag eins geleich null ",'<br>';}
   
    foreach( $array as  $array_entry){
        echo $array_entry->getOrt() , '<br>';
        echo $array_entry->getDatum() , '<br>';

    }
}


function testcreate(){
    $user = new User;
    $user->setEmail('emai@email.de');
    $user->setGebDat("2001-10-10");
    $user->setName('name');
    $user->setPassword("passwd");
    $user->setVorname("vorname");
    $user->setRollen_ID(10);
    $user->create_db_entry();
}

function testusrmanagerlist(){
    $user_array=  AllUser::get_userarray_for_manager_view();
    foreach($user_array as $user){
        test_ausgabe($user);
        echo "<br>";
        echo "<br>";
    }
}

function testusrg26(){
    $email = "t.lana@ff-riegelsberg.de";
    $password = 4711;

    $user = User::get_user_by_login($email, $password);
    test_ausgabe($user);
}





 testcreate();
testusrmanagerlist();
try {
    testusrg26();
} catch (Exception $exc) {
    echo $exc;
}




?>
