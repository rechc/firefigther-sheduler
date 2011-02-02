<?php
/*
 * Description
 *
 *@author Rech Christian
 *@version alpha
 */
    require_once '../Model/User.php';

    $user = new User();
    $user->setName($_POST['firstname']);
    $user->setVorname($_POST['lastname']);
    $user->setEmail($_POST['email']);
    $user->setGebDat($_POST['bday']);
    $user->setPassword("test");
    $user->setRollen_ID(4);

    $user->create_db_entry();

    header("Location: ../View/startseite.php?section=users");
?>
