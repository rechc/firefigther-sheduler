<?php
    if($_GET['userID'] == ""){
	echo "ID is empty";
    } else {
        $name = 'franz';
	echo "you sent ID: " . $_GET['userID'];
        
    }
?>
