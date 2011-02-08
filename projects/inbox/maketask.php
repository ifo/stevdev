<?php
    session_start();
    require_once('../../includes/define.php');
    require_once('../../includes/db.php');
    
    if (isset($_POST['authorname']) && isset($_POST['password'])) {
        $authorname = $_POST['authorname'];
        $password = $_POST['password'];
        
        $connection = mysqli_connect($dbhost, $dbusername, $dbpassword, $database);
        $authorname = mysqli_real_escape_string($connection, $authorname);
        $query = "SELECT password, salt
                  FROM authors
                  WHERE authorname = '$authorname';";
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result) < 1) {
            header('Location: index.php');
        }
        $userData = mysqli_fetch_array($result, MYSQL_ASSOC);
        $hash = hash('sha256', $userData['salt'] . hash('sha256', $password));
        if ($hash != $userData['password']) {
            header('Location: index.php');
        }
        // setup the session for later use - i.e. multiple tasks to add
        $_SESSION['auth'] = 1;
    }
    elseif ($_SESSION['auth'] != 1) {
        header('Location: index.php');
    }
    
    if (isset($_POST['title']) && isset($_POST['description'])) {
        include_once('inbox.php');
        
        $title = $_POST['title'];
        $description = $_POST['description'];
        
        $inbox = new Inbox($dbhost, $dbusername, $dbpassword, $database);
        
        $inbox->addTask($title, $description);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>StevDev</title>
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.2.0/build/cssreset/reset-min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo absPrefix; ?>site.css" />
</head>
<body>
<?php
    include_once('../../includes/header.php');
?>
<div id="container">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Title: <input type="text" name="title" size="55" /><br />
        Description: <textarea name="description" cols="50" rows="5"></textarea><br />
        <input type="submit" name="submit" value="Add Task" />
    </form>
</div>
<?php
    include_once('../../includes/footer.php');
?>
</body>
</html>