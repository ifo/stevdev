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
    <div class="project"><a href="#"><img height="150" width="225" alt="some picture" /></a></div>
    <div class="project l20">But can you see this?</div>
    <div class="project l20">But can you see this?</div>
    <div class="project l20">But can you see this?</div>
    <div class="clear"></div> 
</div>
<?php
    include_once('../includes/footer.php');
?>
</body>
</html>