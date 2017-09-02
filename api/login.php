<?php 

	require '../core/config.php';
	require '../core/School.php';
	$s = new School;
	$s->startSess(true);
	exit(json_encode( $s->login(@$_POST["email"], @$_POST["password"]) ));

?>