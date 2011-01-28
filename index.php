<?php
    require_once('includes/define.php');
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
        <?php
            include_once('includes/db.php');
            include_once('includes/shoutbox.php');
            
            $shoutBox = new ShoutBox($dbhost, $dbusername, $dbpassword, $database);
            $shoutBox->makeShoutbox();
        ?>
        <form method="post" action="<?php echo absPrefix; ?>projects/shoutbox/process.php">
            <h2>Give a Shout:</h2>
            <textarea name="shout" rows="4" cols="30"></textarea>
            <br />
            <input type="submit" name="submit" value="Shout!" />
        </form>
        <h6>Note only the first 140 characters of a shout are used (about the size of the text box)</h6>
    </div>
    <div class="grid">
        <div id="blog">
            <div class="bar">
                <h4>Latest Blog Post:</h4>
            </div>
            <?php
                include_once('includes/db.php');
                include_once('includes/blog.php');
                    
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