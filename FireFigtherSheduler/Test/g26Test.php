<?php
require_once('../Model/G26.php');

//schnelle unsaubere tests

function g26test(){
    $g26 = G26::load(1);
    if ($g26 == NULL){echo "null";}
    $g26->get_warning_status();

}
//g26test();
?>
