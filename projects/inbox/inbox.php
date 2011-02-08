<?php
class Inbox {
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
    
    // puts the task into the database
    function addTask($title, $description) {
        $insert = "INSERT INTO tasklist (title, description)
                   VALUES ('$title', '$description')";
        
        $result = mysqli_query($this->connect, $insert)
            or die('insert query failed'.mysqli_error($this->connect));
        
        // use the query's result to determine what to return
        if ($result) {
            return true;
        }
        return false;
    }
    
    // gets the task data for the given id
    function getTask($iID) {
        $query = "SELECT *
                  FROM tasklist
                  WHERE id = $iID;";
        
        $result = mysqli_query($this->connect, $query);
        
        if ($result) {
            // array to return later
            $task = array();
            
            $row = mysqli_fetch_assoc($result);
            $task['title'] = $row['title'];
            $task['description'] = $row['description'];
            
            return $task;
        }
        return false;
    }
    
    // gets task ids and returns an array of them
    function getTaskIDs($completed = 0) {
        $query = "SELECT id
                  FROM tasklist
                  WHERE completed = $completed
                  ORDER BY id;";
        
        $result = mysqli_query($this->connect, $query);
        
        // the array of ids to return later
        $idArray = array();
        
        while ($row = mysqli_fetch_assoc($result)) {
            $row['id'] = (int) $row['id'];
            array_push($idArray, $row['id']);
        }
        
        return $idArray;
    }
    
    // prints out the task based on the id given
    function printTask($iID) {
        $data = $this->getTask($iID);
        $title = $data['title'];
        $description = $data['description'];
        
        $toEcho =
        '<div class="task">
        <span class="title">'.$title.'</span>
        <span class="description">'.$description.'</span>
    </div>';
        
        echo $toEcho;
    }
    
    // marks a task as complete
    function markCompleted($iID) {
        $dbcon = mysqli_connect("localhost","inbox","ib","inbox")
        or die("Didn't work: database connection");
        
        if(isset($_POST['taskNumber'])) {
            $taskid = $_POST['taskNumber'];
            $change = "UPDATE tasklist
                       SET complete = '1'
                       WHERE taskid = $taskid;";
            $result = mysqli_query($this->connect, $change)
                or die("Didn't work: database update");
        }
    }
}
?>