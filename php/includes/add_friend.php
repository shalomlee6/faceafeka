<?php

include 'database.php';

$fid = $_POST['fid'];
$uid = $_POST['uid'];


if (friendsCheck($uid,$fid) and $uid != $fid){
    addFriendToDB($uid, $fid);
}else{
    if($uid == $fid){
        echo "You cant be friend with yourself..";
    }else{
        echo "You are already friends!";
    }

}




function friendsCheck($uid,$fid){
    global $connection;
    connect();
    $sql = "SELECT user_id, friend_id FROM friends WHERE (friends.user_id = '$uid' AND friends.friend_id = '$fid') OR (friends.user_id = '$fid' AND friends.friend_id = '$uid') ;";
    $result = mysqli_query($connection, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck < 1){
        return true;
    }else{
        return false;
    }

}


function addFriendToDB($uid,$fid){
    global $connection;
    connect();
    $sql = "INSERT INTO friends (user_id, friend_id) VALUES ('$uid','$fid'),('$fid','$uid');";
    //mysqli_query($connection, $sql);
    if ( mysqli_query($connection, $sql)) {
        echo "You Are Now Friends!";
    } else {

        echo "There was an Error: " . $sql . "<br>" . mysqli_error($connection);
    }
    close();


}

?>