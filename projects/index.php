<?php
    require_once('../includes/define.php');
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
    <div class="project">
        <a href="<?php echo absPrefix; ?>projects/shoutbox/">Shout Box</a>
    </div>
    <div class="project l20">
        <a href="<?php echo absPrefix; ?>projects/inbox/">Inbox</a>
    </div>
    <div class="clear"></div>
</div>
<?php
    include_once('../includes/footer.php');
?>
</body>
</html>