<?php
    include_once('../includes/db.php');
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
</head>
<body>
    <form method="post" action="insertpost.php">
        <label for="title">Title:</label>
        <br />
        <input type="text" name="title" size="55" />
        <br />
        <label for="post">Post:</label>
        <br />
        <textarea name="post" rows="20" cols="50"></textarea>
        <br />
        <label for="author">Author:</label>
        <select name="author">
            <option value="1">Steve</option>
        </select>
        <br />
        <label for="descriptors">Descriptors (separate by commas):</label>
        <br />
        <input type="text" name="descriptors" size="55" />
        <br />
        <br />
        <input type="submit" name="submit" value="Post!" />
    </form>
</body>
</html>