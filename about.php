<?php
    require_once('includes/define.php');
    require_once('includes/closeDivs.php');
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
    include_once('includes/header.php');
?>
<div id="container">
    <h2>About:</h2>
    <br />
    <p>My name is Steve.  I like making websites.  StevDev is about learning to make websites of all kinds.  Mostly just whatever interests me at the moment.  Eventually, I hope to share what little knowledge I have with others.</p>
    <br />
    <p>All the code (except for the database access information) is hosted on github: <a href="https://github.com/ifo/stevdev">https://github.com/ifo/stevdev</a></p>
    <br />
    <p>There is currently no conact information here because I'm not sure how best to secure it.  I will likely make a form where you can send me an email.  Till then, you could message me on github (user name: ifo).</p>
    <br />
    <p>Thanks for stopping by.  Have a great day.</p>
    <br />
</div>
<?php
    include_once('includes/footer.php');
?>
</body>
</html>