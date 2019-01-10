<?php

include 'database.php';
connect();
$uid = $_POST['uid'];

$sql = mysqli_query($connection,"SELECT user_name, user_last_name,friend_id FROM users, friends WHERE users.user_id = friends.friend_id AND friends.user_id='$uid'");

while($res = mysqli_fetch_array($sql)){

//    $res['friend_id']
//    echo '<input type="checkbox" name="'.$res['friend_id'].'" value="'.$res['friend_id'].'" id="'.$res['friend_id'].'">';
    echo '<input type="checkbox" name="friend_list_check_box" value="'.$res['friend_id'].'" id="'.$res['friend_id'].'">';
    echo '<label for="'.$res['friend_id'].'">';
    echo $res['user_name'].' '.$res['user_last_name'];
    echo '</label>';
    echo "<br>";


//    <input type="checkbox" name="love" value="love" id="love"><label for="love"> Check if you love this website!</label>


}
