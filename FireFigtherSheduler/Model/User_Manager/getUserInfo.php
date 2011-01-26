<?php
   header ("Content-Type:text/xml");
   
//require_once('../Model/User.php');
    if($_GET['userID'] != ""){
//      $user = User::get_user($ID);
       $test = ("as");
        createXML();
    }

    function createXML(){
        $output = "<?xml version='1.0' encoding='UTF-8'?>";
        $output .= "<root>
                    <lastname>Schneider</lastname>
                    <firstname>Lucian</firstname>
                   </root>";

        print $output;
    }
?>