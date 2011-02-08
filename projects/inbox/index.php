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
    <?php
        include_once('../../includes/db.php');
        include_once('inbox.php');
        
        $inbox = new Inbox($dbhost, $dbusername, $dbpassword, $database);
        
        $ids = $inbox->getTaskIDs();
        
        foreach ($ids as $id) {
            $inbox->printTask($id);
        }
    ?>
</div>
<?php
    include_once('../../includes/footer.php');
?>
</body>
</html>