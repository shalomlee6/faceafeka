<?php
	include_once 'header.php';
?>

	<section class="main-container">
		<div class="main">
			<h2>Sign up</h2>
			<form class="signup-form" action="includes/db_signup.php" method="POST">
				<input type="text" name="first" placeholder="Firstname">
				<br>
				<input type="text" name="last" placeholder="Lastname">
				<br>
				<input type="text" name="email" placeholder="E-mail">
				<br>
				<input type="password" name="pass" placeholder="Password">
				<br>
				<button type="submit" name="submit">Sign up</button>
			</form>
		</div>
	</section>

<?php
	include_once 'footer.php';
?>
