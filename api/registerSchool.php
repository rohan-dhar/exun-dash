<?php 

	require '../core/config.php';
	require '../core/School.php';

	$s = new School;
	
	$part = @$_POST["participants"];
	$part = @json_decode($part);

	if(!is_array($part) || count($part) < 1){
		exit(json_encode([false, "MISSING_PARTICIPANT_DATA"]));
	}

	exit(json_encode( $s->register([
		"name" => @$_POST["name"],
		"principal" => @$_POST["principal"],
		"teacher" => @$_POST["teacher"],
		"teacherPhone" => @$_POST["teacherPhone"],
		"teacherEmail" => @$_POST["teacherEmail"],		
	], $part)));

?>