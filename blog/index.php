<?php
    require_once('../includes/define.php');
    require_once('../includes/db.php');
    require_once('../includes/blog.php');
    require_once('../includes/comments.php');
    require_once('../includes/database.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>StevDev Blog</title>
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.2.0/build/cssreset/reset-min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo absPrefix; ?>site.css">
</head>
<body>
<?php
    include_once('../includes/header.php');
?>
<div id="container">
    <div id="sidebar" class="grid">
        <p>This page is still sorta under construction, but should still display the 8 most recent blog posts (if there are 8 of them).</p>
    </div>
    <div class="grid">
        <div id="blog">
            <?php
                $blog = new Blog($dbhost, $dbusername, $dbpassword, $database);
                if (isset($_GET['id'])) {
                    $num = (int) $_GET['id'];
                    $comments = new Comments($dbhost, $dbusername, $dbpassword, $database);
                    $blog->printBlogPost($num);
                    $comments->startComments();
                    $comments->printComments($num);
                    $comments->endComments();
                }
                else {
                    $post = $blog->getRecentPostIDs(8);
                    foreach($post as $p) {
                        $blog->printBlogPost($p);
                    }
                }
            ?>
            
        </div>
    </div>
    <div class="clear"></div>    
</div>
<?php
    include_once('../includes/footer.php');
?>
</body>
</html>