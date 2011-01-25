<?php
    require_once('../Model/User.php');

    /**
     * author christian
     */

    class Userlist{
        /**
         * Standard Konstruktor
         */
        public function __construct(){
            $user_array=  User::get_userarray_for_manager_view();
            echo "<table border=1>";
            foreach($user_array as $user){
                echo "<tr onClick=window.location.href=<a href='#' onClick='sendUserInfoRequest(" . $user->getID . ")'>";
                echo    "<td>" . $user->getName() . "</td>";
                echo    "<td>" . $user->getVorname() . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

?>
