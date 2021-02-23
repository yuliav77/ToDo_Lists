<?php
 
/** @var \PDO $pdo */
require_once './pdo_ini.php';
 
/* Check if user exists and redirect to index.php */

if(isset($_POST['submit_user'])) {
    $userName = $_POST['user_name'];
	$userPassword = $_POST['user_password'];
	$sth = $pdo->prepare("SELECT id, name, password FROM users WHERE name = :name AND password = :password");
	$sth->execute(['name' => $userName, 'password' => $userPassword]);
	$existingUser = $sth->fetch();
	if(!$existingUser) {
		$errorMessage = 'Incorrect login or password! Please, try again:';
	} else {
		session_start();
		$_SESSION['user_id'] = $existingUser['id'];
		$_SESSION['user_name'] = $existingUser['name'];
		header("Location: /");		
	}
}	

include ("header.php");

?>

<main role="main" class="container">

	<section id="login_section">
		<form action="" method="POST">
			<h3 class="mt-3">Login</h3>
			<div class="error_message_div mt-2 mb-2"><?= $errorMessage ? $errorMessage : '' ?></div>	
			<div class="form-group">
			<label for="user_name">User Name</label>
			<input type="text" class="form-control" id="user_name" name="user_name" aria-describedby="username" placeholder="Enter username" required>
		  </div>
		  <div class="form-group">
			<label for="InputPassword1">Password</label>
			<input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password">
		  </div>
		  <button type="submit" name="submit_user" class="btn btn-primary">Go!</button>
		  <br>
		  <p class="mt-3">If you have no account, please, <a href="/register.php">Register</a><p>
		</form>
	</section>
	
</main>
</html>