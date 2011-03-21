<?php
class Comments {
    // the variable holding the mysqli object
    // use in functions only with "$this->mysqli"
    private $mysqli;
    
    // makes an instance of the database class and creates the mysqli object
    function __construct($dbhost, $dbusername, $dbpassword, $database) {
        //require_once('../../includes/database.php');
        //require_once('../../includes/db.php');
        $database = new Database($dbhost, $dbusername, $dbpassword, $database);
        $this->mysqli = $database->getMysqli();
    }
    
    // grabs the replies from the database
    function getComments($iID) {
        // integer check (messes up mysqli query otherwise)
        if (!is_integer($iID)) {
            return false;
        }
        
        $query = "SELECT id, replytoid, name, email, website, comment
                  FROM comments
                  WHERE blogpostid = $iID
                  ORDER BY id;";
        $result = $this->mysqli->query($query);
        
        // this collects all of the rows, not just one
        while ($comment = $result->fetch_assoc()) {
            $comments[] = $comment;
        }
        
        return $comments;
    }
    
    // return either the comments ($list = 0) or the replies ($list = 1)
    function separateComments($comments, $list = 0) {
        $baseComments = new SplDoublyLinkedList();
        $replies = new SplDoublyLinkedList();
        
        // separate the replies from the base comments
        // push them into the corresponding doubly linked lists
        foreach ($comments as $comment) { 
            // base comments will have a 'replytoid' of 0
            if ($comment['replytoid'] != 0) {
                $replies->push($comment);
            }
            else {
                $baseComments->push($comment);
            }
        }
        
        // replies if $list isn't 0
        if ($list != 0) {
            return $replies;
        }
        return $baseComments;
    }
    
    // prints the comments recursively, in order
    /* do a time check on this function later, see if the lowest level if else
       statement makes it faster or slower than not having it */
    private function printRecursion($comment, $replies, $level) {
        if ($replies->isEmpty()) {
            if ($level == 0) {
                $toEcho = $comment;
                $this->printSingleComment($toEcho);
                $id = $toEcho['id'];
            }
        }
        else {
            if ($level == 0) {
                $toEcho = $comment;
                $this->printSingleComment($toEcho);
                $id = $toEcho['id'];
            }
            else {
                $toEcho = $replies->shift();
                $this->printSingleComment($toEcho, $level);
                $id = $toEcho['id'];
            }
            
            // recurse if there are replies to the current comment
            foreach ($replies as $reply) {
                if ($reply['replytoid'] == $id) {
                    $this->printRecursion($comment, $replies, $level + 1);
                }
            }
        }
    }
    
    // collects the necssary data and calls the printRecursion function
    function printComments($iID) {
        // make sure comments exist, while grabbing them in $start if they do
        if($start = $this->getComments($iID)) {
            $replies = $this->separateComments($start, 1);
            $comments = $this->separateComments($start, 0);
            
            // do once for each base level comment
            foreach ($comments as $comment) {
                $this->printRecursion($comment, $replies, 0);
            }
        }
        else {
            $toEcho = '
            <li class="reply">
                <span class="comment">There are currently no comments for this post</span>
            </li>';
            echo $toEcho;
        }
    }
    
    // prints a single comment (used in the print recursion only)
    private function printSingleComment($comment, $level = 0) {
        $name = $comment['name'];
        $text = $comment['comment'];
        $toEcho =
        '<li class="reply'.$level.'">
            <span class="userid">'.$name.'</span>
            <span class="comment">'.$text.'</span>
        </li>';
        
        echo $toEcho;
    }
    
    function startComments() {
        $toEcho =
        '<div class="commentBox">
            <ul class="comments">';
        
        echo $toEcho;
        return true;
    }
    
    function endComments() {
        $toEcho =
        '   </ul>
        </div>';
        
        echo $toEcho;
        return true;
    }
}
?>