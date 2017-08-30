<?php 

	require 'config.php';
	require 'School.php';

	$s = new School;
	$res = $s->register([
		"name" => "DPS RK Puram",
		"principalName" => "Ms. Vanita Sehgal",
		"teacherName" => "Mr. Mukesh Kumar",
		"teacherEmail" => "ikkumpal2@gmail.com",		
		"teacherPhone" => "9090909090",				
	], [
		["name" => "Rohan", "event" => "d", "email" => "test@text.com", "class" => "11"],
		["name" => "Test 1", "event" => "jq", "email" => "test@test2.com", "class" => "6"],
		["name" => "Test 2", "event" => "sq", "email" => "test@haha.com", "class" => "9"],
	]);


	echo "<pre>";
	var_dump($res);
	echo "</pre>";


?>