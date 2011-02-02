<?php
/*
 * Description
 *
 *@author Rech Christian
 *@version alpha
 */

class XML{

    public static function getXML($ID, $vorname, $name, $email, $bday){

       header ("Content-Type: application/xml");
            $output = "<?xml version='1.0' encoding='UTF-8'?>\n";
            $output .= "<root>\n
                            \t<id>" .$ID. "</id>\n
                            \t<lastname>" .$vorname. "</lastname>\n
                            \t<firstname>". $name ."</firstname>\n
                            \t<email>". $email ."</email>\n
                            \t<bday>". $bday ."</bday>\n
                       </root>\n";

            print $output;
    }
}

?>
