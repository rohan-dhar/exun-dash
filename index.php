<?php 
	
	require 'core/config.php';

	$styles = ["css/index.css"];
	$scripts = ["js/index.js"];
	$title = APP;

?>
<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h1 class="ui-page-head"> <b> Exun 2017</b><br>Registration</h1><br>
		<div class="ui-page-desc">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur.
		</div>
		<div class="ui-page-content reg-content">
			<input type="text" class="ui-inp-text reg-inp" id="reg-school-name" placeholder="School Name">	
			<input type="text" class="ui-inp-text reg-inp" id="reg-principal-name" placeholder="Principal Name">	
			<br>
			<input type="text" class="ui-inp-text reg-inp" id="reg-teacher-name" placeholder="Teacher Name">	
			<input type="email" class="ui-inp-text reg-inp" id="reg-teacher-email" placeholder="Teacher Email">	
			<br>
			<input type="text" class="ui-inp-text reg-inp" id="reg-teacher-num" placeholder="Teacher Phone Number">				

			<h2 class="ui-page-content-head">Add Students</h2>

			<input type="text" class="ui-inp-text reg-inp" id="reg-add-student-name" placeholder="Student Name">				
			<select class="ui-inp-text reg-inp" id="reg-add-student-event">							
				<option selected disabled value="Student Event">Student Event</option>			
				<?php 
					foreach($events as $k => $e){				
						echo "<option value='".$k."'>".$e["name"]."</option>";
					}
				?>
			</select>
			<br>
			<input type="email" class="ui-inp-text reg-inp" id="reg-add-student-email" placeholder="Student Email">	
			<select class="ui-inp-text reg-inp" id="reg-add-student-class">							
				<option selected disabled value="Student Class">Student Class</option>			
			</select>
			<br>
			<button class="ui-btn reg-btn" id="reg-add-student">Add Student</button>

			<h2 class="ui-page-content-head" id="student-head">Students List</h2>

			<table id="reg-students">
			</table>

			<h2 class="ui-page-content-head" id="event-head">Events List</h2>

			<table id="reg-events">
			</table>

		<button class="ui-btn reg-btn" id="reg-go">Register</button>
		
		</div>

	</body>
</html>