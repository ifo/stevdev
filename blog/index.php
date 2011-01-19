<?php
    require_once('../includes/define.php');
    require_once('../includes/closeDivs.php');
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
                include_once('../includes/db.php');
                include_once('../includes/blog.php');
                
                $blog = new Blog($dbhost, $dbusername, $dbpassword, $database);
                $post = $blog->getRecentPostIDs(8);
                foreach($post as $p) {
                    $blog->printBlogPost($p);
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