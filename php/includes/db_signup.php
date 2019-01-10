<?php

if(isset($_POST['submit'])){
	include_once 'database.php';
    connect();
	$first = mysqli_real_escape_string($connection,$_POST['first']);
	$last = mysqli_real_escape_string($connection,$_POST['last']);
	$email = mysqli_real_escape_string($connection,$_POST['email']);
	$pass = mysqli_real_escape_string($connection,$_POST['pass']);

	//check for empty fields
	if(empty($first) || empty($last) || empty($email) || empty($pass) ){
		header("Location: ../signup.php?signup=empty");
		close();
		exit();
	}else {
		//check if input characters are valid
		if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last) ) {
			header("Location: ../signup.php?signup=invalidtext");
            close();
			exit();
		} else {
			//check if email is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				header("Location: ../signup.php?signup=invalidemail");
                close();
				exit();
			} else {
				// Hashing the password
				$Hashpass = password_hash($pass, PASSWORD_DEFAULT);
				//Insert the user into the database
				$sql = "INSERT INTO users (user_name, user_last_name, email, password) VALUES ('$first', '$last', '$email', '$Hashpass')";

				mysqli_query($connection, $sql);

				//start the session
                session_start();
                $sql = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($connection, $sql);
                $resultCheck = mysqli_num_rows($result);
                if ($resultCheck < 1) {
                    header("Location: ../index.php?login=errorresultcheck");
                    exit();
                }else{
                    if ($row = mysqli_fetch_assoc($result)){
                        $_SESSION['u_id'] = $row['user_id'];
                        $_SESSION['u_name'] = $row['user_name'];
                        $_SESSION['u_last_name'] = $row['user_last_name'];
                        $_SESSION['u_email'] = $row['email'];
                        close();
                        header("Location: ../home.php");
                        close();
                        exit();
                    }

                }
			}
		}

	}
}else {
	header("Location: ../signup.php");
    close();
	exit();
}
