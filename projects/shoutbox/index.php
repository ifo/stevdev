<?php
    require_once('../../includes/define.php');
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
    <form method="post" action="#">
        <h2>Give a Shout:</h2>
        <textarea name="shout" rows="5" cols="40"></textarea>
        <br />
        <input type="submit" name="shout" value="Shout!" />
    </form>
    <p>This shoutbox is not currently active.</p>
</div>
<?php
    include_once('../../includes/footer.php');
?>
</body>
</html>