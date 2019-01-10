<?php

session_start();
include "database.php";

// get all values
$content = cleanData($_POST['data']);
$name = $_POST['name'];
$u_id = $_POST['u_id'];


if ($content == "")	return;
$is_public = cleanData($_POST['permission']);
$likes = 0;




// get date
$my_date= getdate(date("U"));
$fullDate = "$my_date[month] $my_date[mday], $my_date[year]";

echo "date:   \n".$fullDate;
// add all data to DB
addData($u_id, $name, $content, $is_public, $likes, $fullDate);


function cleanData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    return $data;
}

function addData($u_id, $name, $content, $is_public, $likes, $date) {
    global $connection;
    $image = "";

    foreach ($_FILES['file']['name'] as $f => $fName) {

        $target_dir = "FaceAfeka/images/";
        $target_file = $target_dir . basename($_FILES["file"]["name"][$f]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        if(isset($_FILES['file'])) {

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["file"]["tmp_name"][$f]);
            if (!($check !== false)) {
                $image .= "err#";
                continue;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $image .= "{$_FILES['file']['name'][$f]}";
                $image .= "#";
                continue;
            }

            // Check file size
            if ($_FILES["file"]["size"][$f] > 500) {
                $image .= "err#";
                continue;
            }

            // if all good - try to move image to 'img' dir
            if (!move_uploaded_file($_FILES["file"]["tmp_name"][$f], $target_file))
            {
                $image .= "err#";
                continue;
            }

            // if all good - return image name
            $image .= "{$_FILES['file']['name'][$f]}";
            $image .= "#";
            continue;
        }
    }
    //$image = checkUpload($_FILES['file']['name'][$f]);
    connect();





    $sql="INSERT INTO posts(user_id, content, is_public, like_counter, post_date, images) VALUES('$u_id','$content', '$is_public', '$likes','$date', '$image')";
    $result=mysqli_query($connection, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck < 1) {
        header("Location: ../home.php?dont_insert_post");
    }
    else{
        echo $name."&".$is_public."&".$date."&".$likes."&".$content."&".$image;
        $msg ="";
        //store image
        echo "store imageeeeeeee";
        if (isset($_POST['upload'])){
            echo "yessssssssssssssssssssss";
            //path to store uploaded images
            $target = "images/".basename($_FILES['image']['name']);
            //get data from the form
            $image = $_FILES['image']['name'];
            $post_id = $result['post_id'];
            $image_query = "INSERT INTO images (image_path, post_id, user_id) VALUES ('$image','$post_id','$u_id')";
            mysqli_query($connection, $image_query);
            //move the image to images
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)){
                echo  "image uploded successfully";
            }else {
                echo  "problem uploding the image....";
            }



        }else{
            echo "------->  upload not set!!!!!!!!!!";
        }
    }

    close();

    echo "in php func";


}


