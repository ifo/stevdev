<?php
    require_once('../../includes/db.php');
    require_once('../../includes/shoutbox.php');
    require_once('../../includes/define.php');
    
    if(!empty($_POST['shout'])) {
        $shoutBox = new ShoutBox($dbhost, $dbusername, $dbpassword, $database);
        $shoutBox->insertShout($_POST['shout']);
    }
    header('Location: '.absPrefix);
?>