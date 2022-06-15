<?php
    require('utils.php');

    function protect_string_in_array($inp) { 

        if(is_array($inp)) 
            return array_map(__METHOD__, $inp); 
    
        if(!empty($inp) && is_string($inp)) { 
            return "'" . str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp) . "'";
        } 
    
        return $inp; 
    } 
    
    const MYSQL_IP = "localhost";
    const MYSQL_USER = "root";
    const MYSQL_PASSWORD = "root";
    const MYSQL_DB = "test2";
    $connect = mysqli_connect(MYSQL_IP, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    printf("Connexion %s", $connect ? "réussie" : "ratée :(");
    space(2);
    if (!$connect) {
        return;
    }
    
?>
