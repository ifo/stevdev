<?php
    require_once('../includes/db.php');
    require_once('../includes/shoutBox.php');
    require_once('../includes/define.php');
    
    if (empty($_POST['shout'])) {
        header('Location: '.absPrefix.'?shout=empty');
    }
    
    $shoutBox = new ShoutBox($dbhost, $dbusername, $dbpassword, $database);
    $shoutBox->insertShout($_POST['shout']);
    header('Location: '.absPrefix.'');
?>