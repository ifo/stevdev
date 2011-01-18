<?php
    require_once('includes/define.php');
    require_once('includes/closeDivs.php');
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
    include_once('includes/header.php');
?>
<div id="container">
    <div id="sidebar" class="grid">
        <p>This spot intentionally left blank for now.</p>
    </div>
    <div class="grid">
        <div id="blog">
            <div class="bar">
                <h4>Latest Blog Post:</h4>
            </div>
            <?php
                include_once('blog/db.php');
                include_once('blog/blog.inc.php');
                    
                $blog = new Blog($dbhost, $dbusername, $dbpassword, $database);
                $post = $blog->getRecentPostIDs(1);
                $blog->printBlogPost($post);
            ?>
            
        </div>
    </div>
    <div class="clear"></div>    
</div>
<?php
    include_once('includes/footer.php');
?>
</body>
</html>