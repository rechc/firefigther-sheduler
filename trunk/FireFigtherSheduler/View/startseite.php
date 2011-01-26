<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
//include ("../Model/Includes/checkuser.php");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>FireFighterScheduler</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body>
        <div id="maincontainer">
            <div id="header" >
                <div id="branding" class="left"  style="cursor: pointer;" />
            </div>
            <div id="buttonbar">
                <ul>
                    <li><a href="startseite.php?section=overview">Übersicht</a></li>
                    <li><a href="#">Komplett Übersicht</a></li>
                    <li><a href="startseite.php?section=users">Benutzer</a></li>
                    <li><a href="#">Statistik</a></li>
                    <li><a href="startseite.php?section=logout">Logout</a></li>
                </ul>
            </div>
            <div id="content">
                <?php
                $section = array();
                $section['overview'] = 'overview.php';
                $section['link_2'] = 'overview_all.php';
                $section['users'] = 'user_manager.php';
                $section['link_4'] = 'statistic.php';
                $section['logout'] = 'logout.php';

                if (isset($_GET['section'])) {
                    switch ($_GET['section']) {
                        case 'overview': include('overview.php');
                            break;
                        case 'link_2': include('link_2.php');
                            break;
                        case 'users': include('user_manager.php');
                            break;
                        case 'logout': ;//header("Location:../Controller/Login/logout.php");
                            ;
                            break;
                    }
                } else {
                    include('login_formular.php');
                }
                ?>
            </div>
        </div>

        <div id="foot">
            <a href="http://www.ff-riegelsberg.de/?page_id=30">Impressum</a>
        </div>

    </body>
</html>
