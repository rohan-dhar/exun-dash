<?php 
	
	require 'core/config.php';

	$styles = ["css/int.css"];
	$scripts = ["js/int.js"];
	$title = APP;
	$loggedIn = false;

	if(@$_GET["pass"] != "pass_123"){
		header("Location: index.php");
		exit();
	}

	$e = @$_GET["event"];


	$qry = $db->prepare("SELECT participants.*, schools.name as schoolName FROM participants LEFT JOIN schools ON schools.id = participants.schoolId WHERE participants.event = :e ");
	$qry->execute([":e" => $e]);
	$res = $qry->fetchAll(PDO::FETCH_ASSOC);

	$tHtml = "<tr> <th>S. No.</th><th>Name</th><th>School</th><th>Class</th><th>Email</th> </tr>";
	$i = 0;

	foreach($res as $p){
		$i++;
		$tHtml .= "<tr> <td>".$i."</td> <td>".$p["name"]."</td> <td>".$p["schoolName"]."</td> <td>".$p["class"]."</td> <td>".$p["email"]."</td> </tr>";
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h1>Event - <?php echo @$events[$e]["name"]; ?></h1>
		<table>
			<?php echo $tHtml; ?>
		</table>
	</body>
</html>