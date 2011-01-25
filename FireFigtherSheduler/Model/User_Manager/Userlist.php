<?php
    require_once('../DbConnector.php');

    /**
     * author christian
     */

    class Userlist{

        /**
         * Standard Konstruktor
         */
        public function __construct(){
            init();
        }

        private function init(){
            $sql = "SELECT id, name, vorname FROM user";

            $dbConnector = DbConnector::getInstance();
            $result = $dbConnector->execute_sql($sql);

            echo "<table>";
            while ($adr = mysql_fetch_array($adressen_query)){
                echo "<tr>";
                echo    "<td>" . $adr[name] . "</td>";
                echo    "<td>" . $adr[vorname] . "</td>";
                echo "target=<a href='#' onClick='sendUserInfoRequest(" . $adr[id] . ")'>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

?>
