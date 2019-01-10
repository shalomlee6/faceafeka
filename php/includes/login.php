<?php

session_start();

if (isset($_POST['submit'])) {
	
	include 'database.php';
    connect();
	$uid = mysqli_real_escape_string($connection,$_POST['uid']);
	$pass = mysqli_real_escape_string($connection,$_POST['pass']);

	// check input
	if (empty($uid) || empty($pass)) {
		header("Location: ../index.php?login=empty");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE email='$uid'";
		$result = mysqli_query($connection, $sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck < 1) {
			header("Location: ../index.php?login=errorresultcheck");
			exit();		
		} else {
			if ($row = mysqli_fetch_assoc($result)) {
				//De-Hashing the password
				$hashedPassCheck = password_verify($pass, $row['password']);
				if ($hashedPassCheck == false) {
					header("Location: ../index.php?login=passerror");
					exit();
				}elseif ($hashedPassCheck == true){
					//login succes
					$_SESSION['u_id'] = $row['user_id'];
					$_SESSION['u_name'] = $row['user_name'];
					$_SESSION['u_last_name'] = $row['user_last_name'];
					$_SESSION['u_email'] = $row['email'];
					close();
					header("Location: ../home.php?login=success");
					exit();
				}
			}
		}
	}
} else {
	header("Location: ../index.php?login=errorfirst");
	exit();
}