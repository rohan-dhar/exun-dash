<?php 
	
	require 'core/config.php';

	$styles = ["css/index.css"];
	$scripts = ["js/index.js"];
	$title = APP;
	$loggedIn = false;

?>
<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
	</body>
</html>