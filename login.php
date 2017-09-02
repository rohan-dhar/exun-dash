<?php 
	
	require 'core/config.php';
	require 'core/School.php';

	$s = new School;
	$s->startSess();

	if($s->authSess()[0]){
		header("Location: dashboard.php");
		exit();
	}

	$styles = ["css/login.css"];
	$scripts = ["js/login.js"];
	$title = APP;

?>
<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<div class="login-box">
			<h3 class="login-head">Login</h3>
			<input type = "email" id="login-email" class="login-inp ui-inp-text" placeholder="Email"></input>
			<input type = "password" id="login-pass" class="login-inp ui-inp-text" placeholder="Password"></input>
			<button class="login-inp ui-btn" id="login-go">Login</button>
		</div>
	</body>
</html>