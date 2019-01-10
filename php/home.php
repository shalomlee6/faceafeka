<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/home.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../javascript/home_manager.js"></script>


    <title>Bot FaceAfeka</title>
</head>
<body onload="load(<?php echo $_SESSION['u_id']; ?>);">

<h5 id="shalomisangry">dsvsdvsd</h5>

<div class="container">

    <header>
        <h1>FaceAfeka</h1>
    </header>

    <div id="userDetails">

        <form action="includes/logout.php" method="POST">
            <button type="submit" name="submit">Logout</button>
        </form>
        <h2 id="userName"><img id="profilePic" src="userProfile.png"><?=$_SESSION['u_name'].' '.$_SESSION['u_last_name']?></h2>
    </div>

    <div class="selectFriends">

        <input type="text" onkeyup="getFriends(this.value)" name="find_friends" placeholder="Find friends..." />
        <br>

        <select multiple id="find_friends_result" onclick="addFriend(this.value,<?php echo $_SESSION['u_id']; ?>)">
            <option value="">Select Friends</option>
        </select>

        <h7 id="added_friend"></h7>


    </div>


    <div class="row">
        <div id="side">
            <h2>Friends:</h2>
            <ol id="user_friends_list" onclick="showUnfriendBtn()">
                <li>None</li>
            </ol>
            <button hidden type="submit" id="unfriend_btn" name="submit"  onclick="unfriend(<?php echo $_SESSION['u_id']; ?>)">unfriend</button>
        </div>

        <div id="middle">
            <!--            ////////////////////////////////////////////post form////////////////////////////////////////////////////////-->
            <div class="post">
                <form id="post_form" enctype="multipart/form-data" action="#">
                    <table cellspacing="5">
                        <tr>
                            <td>
                                <p style="font-family: Comic Sans MS; font-size: 7">Enter Text:</p>
                            </td>
                            <td><input type="text" id="data" name="data" size="50" required
                                       pattern="^(?:\b\w+\b[\s\r\n]*){1,25}$" title="no more then 25 words."></td>
                        </tr>

                        <tr>
                            <td>
                                <p style="font-family: Comic Sans MS; font-size: 7">Permission:</p>
                            </td>
                            <td><input type="radio" id="permission" name="permission" value="public"
                                       checked="checked">Public &nbsp;&nbsp;<input type="radio"
                                                                                   name="permission" value="private">Private
                            </td>
                        </tr>
                    </table>


                    <input type="file" id="file" name="file[]" multiple="multiple" accept="image/*" />
                    <br />
                    <br />
                    <input type="submit" id="post_btn" name="upload" value="Upload Post!" onclick="uploadPost()" />
                    <input type="hidden" value="<?php echo $_SESSION['u_name'];?>" id="name" name="name" />
                    <input type="hidden" value="<?php echo $_SESSION['u_id'];?>" id="u_id" name="u_id" />
                </form>

                <span id="result"></span>
            </div>
            <div >
                <ol id="feed">
                    <li>None</li>
                </ol>


            </div>
        </div>

    </div>

    <footer>
        Copyright &copy; Ella & Shalom
    </footer>
</div>

</body>
</html>