<?php
class Database {
    // mysqli object information variable
    private $mysqli;
    
    // creates the mysqli object
    function __construct($cHost = null, $cUsername = null, $cPassword = null, $cDatabase = null){
        // checks to make sure all necessary objects are given
        if(empty($cHost) || empty($cUsername) || empty($cPassword) || empty($cDatabase))
            die('Insufficient Information');
        
        $this->mysqli = new mysqli($cHost, $cUsername, $cPassword, $cDatabase)
            or die('mysqli object creation failed');
    }
    
    // returns the created mysqli object
    function getMysqli() {
        return $this->mysqli;
    }
}
?>