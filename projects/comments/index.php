<?php
    require_once('../../includes/define.php');
    require_once('../../includes/db.php');
    require_once('../../includes/database.php');
    require_once('../../includes/blog.php');
    require_once('../../includes/comments.php');
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
<?php
    //include_once('../../includes/database.php');
    //$database = new Database($dbhost, $dbusername, $dbpassword, $database);
    //include_once('comments.php');
    $blog = new Blog($dbhost, $dbusername, $dbpassword, $database);
    $comments = new Comments($dbhost, $dbusername, $dbpassword, $database);
    $post = $blog->getRecentPostIDs(1);
    $blog->printBlogPost($post);
    $comments->startComments();
    $comments->printComments($post);
    $comments->endComments();
?>
</div>
<?php
    include_once('../../includes/footer.php');
?>
</body>
</html>