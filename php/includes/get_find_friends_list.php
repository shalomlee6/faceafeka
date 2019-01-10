<?php

include 'database.php';


connect();
$query = $_POST['query'];

if ($query !=''){
    if($query == '*'){
        $sql = mysqli_query($connection,"SELECT user_id,user_name FROM users");
    }else {
        $sql = mysqli_query($connection,"SELECT user_id,user_name FROM users WHERE user_name LIKE '%$query%'");
    }


    while($res = mysqli_fetch_array($sql)){

        echo '<option type="hidden" value="'.$res["user_id"].'">';
        echo $res['user_name'];

        echo "</option>";

    }
}
close();

?>


