<?php

include_once ('database.php');

$get = $_GET['friends'];
$friendsArray[0] = $get;
echo json_encode($friendsArray);


function userLike(){
	alert('Hello world!');
}

function getUserName(){
	include 'database.php';

	$sql = "SELECT * FROM users WHERE  user_name LIKE 'a'";
    $result = mysqli_query($sql);
    if (mysqli_num_rows($result) > 0 ) {

        while($row = mysqli_fetch_assoc($result)){
            echo "<p>";
            echo $row['user_name'];
            echo "<p>";
        }

    }else {
        echo "There is no user";
    }

}