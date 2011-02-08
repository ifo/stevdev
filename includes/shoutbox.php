<?php
class ShoutBox {
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
    
    // makes an id from the ip of the user and returns it
    function makeID() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $userID = md5($ip);
        $userID = substr($userID, 0, 10);
        return $userID;
    }
    
    // puts the shout in the database, returns true if successful
    function insertShout($shout) {
        $shout = mysqli_real_escape_string($this->connect, $shout);
        $shout = substr($shout, 0, 140);
        $userID = $this->makeID();
        $insert = "INSERT INTO shouts (userid, shout)
                    VALUES ('$userID', '$shout');";
        $result = mysqli_query($this->connect, $insert)
            or die('shout insert failed'.mysqli_error($this->connect));
        if (empty($result))
            return false;
        return true;
    }
    
    // returns all the shout data
    function getShoutIDs($shoutNum = null, $numShouts = 8) {
        if (is_integer($shoutNum)) {
            $select = "SELECT id
                        FROM shouts
                        WHERE id < $shoutNum
                        AND disabled = '0'
                        ORDER BY id
                        DESC LIMIT $numShouts;";
        }
        else {
            $select = "SELECT id
                        FROM shouts
                        WHERE disabled = '0'
                        ORDER BY id DESC LIMIT $numShouts;";
        }
        $result = mysqli_query($this->connect, $select)
            or die('shout select failed'.mysqli_error($this->connect));
        
        if ($numShouts > 1) {
            // create the variable to return later
            $shoutID = array();
            
            // convert ids to ints and put them in the array
            while ($row = mysqli_fetch_assoc($result)) {
                $row['id'] = (int) $row['id'];
                array_push($shoutID, $row['id']);
            }
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $shoutID = (int) $row['id'];
        }
        
        return $shoutID;
    }
    
    function getShoutData($iID) {
        // make sure a number was given for the id
        if (!is_integer($iID))
            return null;
        
        // create an array for the shout data, to be returned later
        $shoutData = array();
        
        // get all of the shouts data
        $query = "SELECT *
                  FROM shouts
                  WHERE id = $iID
                  AND disabled = '0';";
        $result = mysqli_query($this->connect, $query);
        $row = mysqli_fetch_assoc($result);
        
        $shoutData['userid'] = $row['userid'];
        $shoutData['shout'] = htmlspecialchars(stripcslashes($row['shout']));
        
        return $shoutData;
    }
    
    function printShout($iID) {
        // make sure a number was given for the id
        if (!is_integer($iID))
            return null;
        
        // get the shout data
        $data = $this->getShoutData($iID);
        $userid = $data['userid'];
        $shout = $data['shout'];
        
        // make a variable of the shout layout to echo
        $toEcho =
        '<li>
            <span class="userid">'.$userid.':</span>
            <span class="shout">'.$shout.'</span>
        </li>';
        
        echo $toEcho;
        return true;
    }
    
    function startShoutbox() {
        $toEcho =
        '<div class="shoutBox">
            <ul class="shouts">';
        
        echo $toEcho;
        return true;
    }
    
    function endShoutbox() {
        $toEcho =
        '   </ul>
        </div>';
        
        echo $toEcho;
        return true;
    }
    
    // a make all function that makes a shoutbox with the 8 most recent shouts in it
    function makeShoutbox($numShouts = 8) {
        // make sure the number of shouts is an integer
        if (!is_integer($numShouts))
            return null;
        
        // start the shoutbox
        $this->startShoutbox();
        
        // get and print the shouts
        $shoutIDs = $this->getShoutIDs();
        foreach ($shoutIDs as $sid) {
            $this->printShout($sid);
        }
        
        // end the shoutbox
        $this->endShoutbox();
        
        // eventually
        // this adds the form so others can also make shouts
        //$this->printShoutForm();
        
        return true;
    }
    
    // this will allow me to remove unwanted shouts
    function disableShout($iID) {
        // if disabled does not equal 0, it will not display
        $update = "UPDATE shouts
                   SET disabled = '1'
                   WHERE id = $iID;";
        mysqli_query($this->connect, $update);
    }
    
    // prints the form that allows people to make shouts
    function printShoutForm() {
        // once I make the form, this will have it in it
    }
    
    
}
?>