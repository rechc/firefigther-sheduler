<?php
    require_once('../Model/AllUser.php');

    /**
     * author christian
     */

    class Userlist{
        /**
         * Standard Konstruktor
         */
        public function __construct(){}

        public static function getUserTable(){
            $user_array=AllUser::get_userarray_for_manager_view();
            $output = "<table border=1>";
            foreach($user_array as $user){
                $output .= "<tr id='list' onClick=document.location.href='javascript:sendUserInfoRequest(" . $user->getID() . ")' >";
                $output .=   "<td class='usertable'>" . $user->getName() . "</td>";
                $output .=    "<td class='usertable'>" . $user->getVorname() . "</td>";
                $output .= "</tr>";
            }
            $output .= "</table>";
            echo $output;
        }
    }

?>
