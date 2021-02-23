<?php
 
/** @var \PDO $pdo */
require_once './pdo_ini.php';

/* Create new user */

if(isset($_POST['submit_new_user'])) {
    $userName = $_POST['user_name'];
	$sth = $pdo->prepare("SELECT name FROM users WHERE name = :name");
	$sth->execute(['name' => $userName]);
	$existingUser = $sth->fetch();
	if(!$existingUser) {
		$userPass = isset($_POST['user_password']) ? $_POST['user_password'] : '';
		$sth = $pdo->prepare("INSERT INTO users (name, password) VALUES (:name, :password)");
		$sth->bindValue(':name', $userName);
		$sth->bindValue(':password', $userPass);
		$sth->execute();
		session_start();
		$_SESSION['user_id'] = $pdo->lastInsertId();
		$_SESSION['user_name'] = $userName;
		header("Location: /");				
	} else {
		$errorMessage = "You can't use this name, we have already had such user!";
	}
}
	
include ("header.php");

?>

<main role="main" class="container">

	<section id="register_section">
		<h3 class="mt-3">Registration Form</h3>
		<div class="error_message_div"><?= $errorMessage ? $errorMessage : '' ?></div>	
		<form action="" method="POST">
		  <div class="form-group">
			<label for="user_name">User Name</label>
			<input type="text" class="form-control" id="user_name" name="user_name" aria-describedby="username" placeholder="Enter username" required>
		  </div>
		  <div class="form-group">
			<label for="user_password">Password</label>
			<input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password">
		  </div>
		  <button type="submit" name="submit_new_user" class="btn btn-primary">Add account</button>
		  <p class="mt-3">If you've already had an account  -> <a href="/">Login</a></p>
		</form>
	</section>
	
</main>
</html>