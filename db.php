<?php    
    // returns a connection to the database
    // root user must have empty password field
    function getDB() {
        $dbhost="localhost";
        $dbuser="root";
        $dbpass="";
        $dbname="nitflux";
        $dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname; charset=utf8",$dbuser,$dbpass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    } 
?>