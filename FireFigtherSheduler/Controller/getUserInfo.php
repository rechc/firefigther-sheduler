<?php
    require_once('../Model/DbConnector.php');
    
    if($_GET['userID'] != ""){
        $sql = "SELECT name, vorname FROM user WHERE ID = " . $_GET['userID'] ."'";

        $dbConnector = DbConnector::getInstance();
        $result = $dbConnector->execute_sql($sql);

        if (mysql_num_rows($result) > 0) {
            $data = mysql_fetch_array($result);

            header ("Content-Type:text/xml");
            echo "<?xml version='1.0' encoding='UTF-8'?>
                    <root>
                        <lastname>Schneider</lastname>
                        <firstname>Lucian</firstname>
                    </root>";
                        //<root>
                            //<lastname>" . $data['name'] . "</lastname>
                            //<firstname>" . $data['vorname'] . "</firstname>
                        //</root>";
        }
    }
?>