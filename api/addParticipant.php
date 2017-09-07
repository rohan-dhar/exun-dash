<?php 

	require '../core/config.php';
	require '../core/School.php';
	$s = new School;
	$s->startSess(true);
	$u = $s->authSess();
	
	if(!$u[0]){
		exit(json_encode([false, "LOGOUT"]));
	}
	
	exit(json_encode( $s->addParticipant(@$_POST["name"], @$_POST["email"], @$_POST["class"], @$_POST["event"]) ));

?>