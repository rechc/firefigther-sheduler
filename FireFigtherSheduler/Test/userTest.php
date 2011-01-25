<?php
require_once('../Model/User.php');

//schnelle unsaubere tests


function testusr(){
    $email = "t.lana@ff-riegelsberg.de";
    $password = 4711;

    $user = User::get_user_by_login($email, $password);


    echo $user->getEmail();
    echo $user->getName();
    echo $user->getVorname();

    $user->setName("Lan");
    $user->save_without_pw();

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

function testusrlist(){
    $user_array=  User::get_userarray_for_manager_view();
    foreach($user_array as $user){
        echo $user->getName(),"<br />";
    }
}

function testusraddg26(){
    $email = "t.lana@ff-riegelsberg.de";
    $password = 4711;

    $user = User::get_user_by_login($email, $password);
    if ($user->getG26_objekt() != NULL){
        echo "!=null";
        echo '<br>';
        echo $user->getG26_objekt()->getGueltigBis();//->delete(); <- tested
    }else{echo "null";}
}

//testusr();
 //testcreate();
//testusrlist();
testusraddg26();


?>
