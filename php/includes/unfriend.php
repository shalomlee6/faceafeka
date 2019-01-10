<?php

include 'database.php';
connect();


if(isset($_POST['unfriend_list']) and isset($_POST['uid'])){
    $uid = $_POST['uid'];
    $unfriend = $_POST['unfriend_list'];
    foreach ($unfriend as $fid){
        $first_query = mysqli_query($connection,"DELETE FROM friends WHERE friends.user_id = '$uid' AND friends.friend_id = '$fid'");
        $second_query = mysqli_query($connection,"DELETE FROM friends WHERE friends.user_id = '$fid' AND friends.friend_id = '$uid'");
        mysqli_query($connection, $first_query);
        mysqli_query($connection, $second_query);
    }
}
close();

