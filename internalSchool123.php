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

	$qry = $db->prepare("SELECT schools.*, COUNT(participants.id) as regCount FROM schools LEFT JOIN participants ON schools.id = participants.schoolId GROUP BY schools.id ORDER BY schools.created ASC");
	$qry->execute();
	$res = $qry->fetchAll(PDO::FETCH_ASSOC);

	$tHtml = "<tr> <th>S. No.</th><th>Id</th><th>Name</th><th>Teacher</th><th>Pricipal</th><th>Teacher Email</th><th>Teacher Phone</th><th>Registered Participants</th> </tr>";
	$i = 0;

	foreach($res as $s){
		$i++;
		$tHtml .= "<tr> <td>".$i."</td> <td>".$s["id"]."</td> <td>".$s["name"]."</td> <td>".$s["teacherName"]."</td> <td>".$s["principalName"]."</td> <td>".$s["teacherEmail"]."</td><td>".$s["teacherPhone"]."</td><td>".$s["regCount"]."</td> </tr>";
	}	

?>
<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h1>Schools</h1>
		<table>
			<?php echo $tHtml; ?>
		</table>
	</body>
</html>