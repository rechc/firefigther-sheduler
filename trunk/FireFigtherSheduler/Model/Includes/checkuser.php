<?php
    session_start ();
    if (!isset ($_SESSION["user_id"])){
      header ("Location: ../View/login_formular.php");
    }
?>