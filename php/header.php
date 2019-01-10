<?php
	session_start();
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../css/index.css">
</head>
<body>
	<header>
		<nav>
			<div class="main">
				<ul>
					<li><a href="index.php">Home</a></li>
				</ul>
				<div class="login-nav">
					<form action="includes/login.php" method="POST">
						<input type="text" name="uid" placeholder="e-mail">
						<input type="password" name="pass" placeholder="password">
						<button type="submit" name="submit" >Login</button>
					</form>
					<a href="signup.php">Sign up</a>
				</div>
			</div>
		</nav>
	</header>