<?php
    if(empty($_POST['id']))
        header("Location: http://www.stevdev.com/blog/");
    
    include ('../../includes/db.php');
    include ('../../includes/blog.php');
    include ('../../includes/database.php');
    include ('../../includes/comments.php');
    
    $comments = new Comments($dbhost, $dbusername, $dbpassword, $database);
    
    $id = (int)$_POST['id'];
    
    $comments->addComment($_POST['name'], $_POST['comment'], $id);
    
    header("Location: http://localhost/blog/index.php?id=" . $_POST['id']);
?>