<?php

include "database.php";

//$u_id = $_POST["uid"];

$u_id=10;
getRecentPosts($u_id);

function getRecentPosts($u_id)
{
    global $connection;
    connect();
    $limit_posts_num = 8;


    $sql = "SELECT * FROM posts WHERE (posts.user_id IN (SELECT friends.friend_id FROM friends WHERE friends.user_id='$u_id') AND posts.is_public='0') OR (posts.user_id='$u_id') ORDER BY posts.post_id DESC LIMIT 8";
    $posts=mysqli_query($connection, $sql);
    $resultCheck = mysqli_num_rows($posts);

    if ($resultCheck < 1) {
        echo "NOOOOO POSTS WERE FOUND..............";
        echo $posts;
    }
    else{
        while($post=mysqli_fetch_assoc($posts)) {
            //get user name and last name
            $u_id = $post['user_id'];
            $user_details_q = "SELECT users.user_name, users.user_last_name FROM users WHERE users.user_id='$u_id'";
            $user_details=mysqli_query($connection, $user_details_q);
            $resultCheckD = mysqli_num_rows($user_details);
            if($resultCheckD < 1){
                echo "cant find user name";
                break;
            }
            $row = mysqli_fetch_array($user_details);
            $fname = $row["user_name"];
            $lname = $row["user_last_name"];


            // write each record details
            echo "</br><a name=\"postNo" . $post['post_id'] . "\"></a> ";
            echo "<div style=\"background-color: pink;\">" . $fname . " - " . $lname . "</div> ";
            echo "<div>" . $post['is_public'] . "</div> ";
            // if private post and not my post - don't show
            echo "<div>" . $post['content'] . "</div>";
            echo "<div>" . $post['post_date'] . "</div>";
            echo "<div>" . $post['like_counter'] . " Likes</div>";


            $allImages = explode("#", $post['images']);
            foreach ($allImages as $i => $img) {
                // if record has an image - show it, or an error msg
                if ($img != "no-image" && $img != "" && $img != "err") {
                    echo "<div>";
                    echo "<a href=\"FaceAfeka/images/" . $img . "\">";
                    echo "<img src=\"thumbs/" . $img . "\" style=\"width:100px;height:100px;\">";
                    echo "</a>";
                    echo "</div>";
                } else if ($img == "err") {
                    echo "<div>";
                    echo "<p>error while uploading the file...".$img;
                    echo "</p>";
                    echo "</div>";
                }
            }//foreach $img

            $pid = $post['post_id'];

            echo "<div style=\"background-color: yellow;\"> <u><strong>Comments:</strong></u> <br/>";
            $query="SELECT comments.comment_data, users.user_name, users.user_last_name FROM comments, users WHERE comments.post_id='$pid' AND comments.user_id=users.user_id ORDER by comments.comment_id DESC";
            $comments=mysqli_query($connection,$query);
            while($comment=mysqli_fetch_assoc($comments)) {
                echo "<div><u>".$comment['user_name']."</u>&nbsp;: &nbsp;&nbsp;&nbsp;".$comment['comment_data']."</div>";
            }
            echo "</div>";
        }//while $post
    }//else
    close();
}
?>