<?php
    if(empty($_POST['title']))
        header("Location: index.php?title=rememberNextTime");
    
    include ('db.php');
    include ('blog.inc.php');
    
    $blog = new Blog($dbhost, $dbusername, $dbpassword, $database);
    
    $title = mysqli_real_escape_string($blog->getConnection(), $_POST['title']);
    $post = $_POST['post'];
    
    $descriptorList = $_POST['descriptors'];
    $explodeDescriptors = explode(',', $descriptorList);
    $tempDescriptors = array();
    foreach ($explodeDescriptors as $temp) {
        $temp = trim($temp);
        $blog->insertDescriptor($temp);
        array_push($tempDescriptors, $blog->checkDescriptor($temp));
    }
    
    $formattedDescriptors = implode('~', $tempDescriptors);
    
    $blog->submitBlogPost($title, $post, $_POST['author'], $formattedDescriptors);
    
    header("Location: index.php?submit=true");
?>