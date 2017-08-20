<?php 

	define('APP', "Exun 2017 Registrations");
	define('ROOT', substr(__DIR__, 0, strlen(__DIR__) - 4));
	define("HTML_ROOT", "http://localhost/exunDash/");

	define('ERROR_REP', true);
	error_reporting(E_ALL);

	define("DB_USER", "root");
	define("DB_PASS", "root");	
	define("DB_HOST", "127.0.0.1:8889");		
	define('DB_NAME', 'exunReg');


	$events = [

		"d" => [
			"name" => "Design",
			"participantCount" => 4,
			"classes" => [6, 12],
		],
	
		"jq" => [
			"name" => "Junior Quiz",
			"participantCount" => 2,
			"classes" => [6, 8],
		],
	
		"sq" => [
			"name" => "Senior Quiz",
			"participantCount" => 2,
			"classes" => [9, 12],
		],
	
		"jp" => [
			"name" => "Junior Programming",
			"participantCount" => 2,
			"classes" => [6, 8],
		],
	
		"sp" => [
			"name" => "Senior Programming",
			"participantCount" => 2,
			"classes" => [9, 12],
		],
	
	];


	require "autoload/db.php";	

?>