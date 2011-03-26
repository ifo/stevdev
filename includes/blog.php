<?php
class Blog {
    // Database connection information variable
    private $connect;
    
    // check to make sure all necessary variables are passed
    function __construct($cHost = null, $cUsername = null, $cPassword = null, $cDatabase = null){
        if(empty($cHost) || empty($cUsername) || empty($cPassword) || empty($cDatabase))
            die('Insufficient Information');
        
        $this->connect = mysqli_connect($cHost, $cUsername, $cPassword, $cDatabase)
            or die('Connection did not work');
    }
    
    // allows programs to grab the same connection that the Blog object is using
    function getConnection() {
        return $this->connect;
    }
    
    // Returns array of the $num most recent blog post ids
    // or $num most recent after the given parameter (integer)
    function getRecentPostIDs($num = 10, $startID = null) {
        
        // used to get posts after the 10 most recent
        if(is_integer($startID)) {
            // 10 most recent post id's after the given number
            $query = "SELECT id
                      FROM blog_posts
                      WHERE id < " . $startID . "
                      ORDER BY id
                      DESC LIMIT $num;";
        }
        else {
            // $num most recent post id's
            $query = "SELECT id
                      FROM blog_posts
                      ORDER BY id
                      DESC LIMIT $num;";
        }
        
        // make the query
        $result = mysqli_query($this->connect, $query);
        
        if ($num > 1) {            
            // array to return later if num isn't 1 or less
            $postID = array();
        
            // convert the strings to ints, and put them in the array to return
            while($row = mysqli_fetch_assoc($result)) {
                $row['id'] = (int) $row['id'];
                array_push($postID, $row['id']);
            }
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $postID = (int) $row['id'];
        }
        
        return $postID;
    }
    
    // gets all data associated with the blog post id given as a parameter
    function getBlogPost($iID) {
        // make sure the id was given, and is an integer
        if(!is_integer($iID))
            return null;
        
        // create an array for the blog posts, to be returned later
        $post_data = array();
        
        // get all of the blog_posts data
        $query_blog_posts = "SELECT *
                             FROM blog_posts
                             WHERE id = $iID;";
        $result_blog_posts = mysqli_query($this->connect, $query_blog_posts);
        $row_blog_posts = mysqli_fetch_assoc($result_blog_posts);
        
        // put the title and post text in the array
        $post_data['title'] = $row_blog_posts['title'];
        $post_data['post'] = $row_blog_posts['post'];
        
        // get the author name
        $query_authors = "SELECT authorname
                          FROM authors
                          WHERE id = ".$row_blog_posts['author'].";";
        $result_authors = mysqli_query($this->connect, $query_authors);
        $row_authors = mysqli_fetch_assoc($result_authors);
        
        // put the author next in the array, followed by the date
        $post_data['authorname'] = $row_authors['authorname'];
        $post_data['date'] = $row_blog_posts['date'];
            
        $descriptors = "None"; // in case there aren't any descriptors
        
        // get the descriptors and put them into an array
        if (!empty($row_blog_posts['descriptors'])) {
            $descriptorArray = array();
            $temp_descriptors = explode('~', $row_blog_posts['descriptors']);
            
            foreach ($temp_descriptors as $temp) {
                $temp = (int) $temp;
                $query_descriptors = "SELECT descriptor
                                      FROM descriptors
                                      WHERE id = $temp;";
                $result_descriptors = mysqli_query($this->connect, $query_descriptors);
                $row_descriptors = mysqli_fetch_assoc($result_descriptors);
                array_push($descriptorArray, $row_descriptors['descriptor']);
            }
            foreach ($descriptorArray as $descriptor) {
                if ($descriptors == "None") {
                    $descriptors = $descriptor;
                }
                else {
                    $descriptors = $descriptors . ", " . $descriptor;
                }
            }
        }
        
        // put the descriptor string in the array
        $post_data['descriptors'] = $descriptors;
        
        // put the comment number in the array
        $post_data['comments'] = $row_blog_posts['comments'];
        
        // return the $post_data array
        return $post_data;
    }
    
    // function to submit the blog posts into the database
    function submitBlogPost($bpTitle, $bpPost, $bpAuthor, $bpDescriptors) {
        $insert =  "INSERT INTO blog_posts (title, post, author, date, descriptors)
                    VALUES ('$bpTitle', '$bpPost', '$bpAuthor', CURDATE(), '$bpDescriptors');";
        $result = mysqli_query($this->connect, $insert)
            or die('blog post insert did not work'.mysqli_error($this->connect));
    }
    
    // automatically prints the post of the input id
    function printBlogPost($iID) {
        // get the data
        $data = $this->getBlogPost($iID);
        
        // make the data easily insertable into html to be echoed
        $title = stripcslashes($data['title']);
        $post = stripcslashes($data['post']);
        $authorname = $data['authorname'];
        $date = $data['date'];
        $descriptors = $data['descriptors'];
        $num = $data['comments'];
        $comments = "$num comments";
        
        // make the variable to echo, including layout, etc
        $toEcho =
        '<div class="post">
                <div class="title"><h2>'.$title.'<h2></div>
                <br />
                <div class="text">'.$post.'</div>
                <br />
                <div class="postFoot bar">By: '.$authorname.' &nbsp; On: '.$date.' &nbsp; Descriptors: '.$descriptors.' &nbsp <a href="'.absPrefix.'blog/index.php?id='.$iID.'">'.$comments.'</a></div>
            </div>';
        
        // print it
        echo $toEcho;
    }
    
    // gets the most recent blog post, likely not to be used
    function getNewestPostID() {
        $return = $this->getRecentPostIDs(1);
        return $return;
    }
    
    // checks to see if a descriptor is already in the database, if exists, returns the id, otherwise returns false.
    function checkDescriptor($descriptor) {
        $descriptor = mysqli_real_escape_string($this->connect, $descriptor);
        
        $query = "SELECT id
                  FROM descriptors
                  WHERE descriptor = '$descriptor';";
        // no die, because if query fails, no such descriptor exists
        
        $result = mysqli_query($this->connect, $query);
        
        // return the id if it exists
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return (int) $row['id'];
        }
        return (int) 0;
    }
    
    // insert a new descriptor in the database
    function insertDescriptor($descriptor) {
        if (!$this->checkDescriptor($descriptor)) {
            $descriptor = mysqli_real_escape_string($this->connect, $descriptor);
            $insert = "INSERT INTO descriptors (descriptor)
                       VALUES ('$descriptor');";
            
            $result = mysqli_query($this->connect, $insert)
                or die('insert descriptor query fail');
            return true;
        }
        else {
            return false;
        }
    }
}
?>