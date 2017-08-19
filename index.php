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
		<h1 class="ui-page-head"> <b> Exun 2017</b><br>Registration</h1>
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
				<option value="Name">Name</option>
				<option value="Name">Name</option>
				<option value="Name">Name</option>
				<option value="Name">Name</option>
			</select>
			<br>
			<input type="email" class="ui-inp-text reg-inp" id="reg-add-student-email" placeholder="Student Email">	
			<select class="ui-inp-text reg-inp" id="reg-add-student-class">							
				<option selected disabled value="Student Class">Student Class</option>			
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
			</select>
			<br>
			<button class="ui-btn reg-btn" id="reg-add-student">Add Student</button>

			<h2 class="ui-page-content-head" id="student-head">Students List</h2>
			<table id="reg-students">
				<tr>
					<th>S. No.</th>
					<th>Name</th>
					<th>Event</th>
					<th>Class</th>
					<th>Email</th>										
				</tr>
				<tr>
					<td>1</td>
					<td>Rohan Dhar</td>
					<td>Design</td>
					<td>12</td>
					<td>rohan.offi@gmail.com</td>										
				</tr>
				<tr>
					<td>1</td>
					<td>Rohan Dhar</td>
					<td>Design</td>
					<td>12</td>
					<td>rohan.offi@gmail.com</td>										
				</tr>
				<tr>
					<td>1</td>
					<td>Rohan Dhar</td>
					<td>Design</td>
					<td>12</td>
					<td>rohan.offi@gmail.com</td>										
				</tr>
				<tr>
					<td>1</td>
					<td>Rohan Dhar</td>
					<td>Design</td>
					<td>12</td>
					<td>rohan.offi@gmail.com</td>										
				</tr>
			</table>

			<h2 class="ui-page-content-head" id="event-head">Events List</h2>
			<table id="reg-students">
				<tr>					
					<th>Event 1</th>
					<th>Event 2</th>
					<th>Event 3</th>
					<th>Event 4</th>										
				</tr>
				<tr>
					<td>2/2</td>
					<td>5/10</td>
					<td>4/4</td>
					<td>7/10</td>
				</tr>
				<tr>
					<td>2/2</td>
					<td>5/10</td>
					<td>4/4</td>
					<td>7/10</td>
				</tr>
				<tr>
					<td>2/2</td>
					<td>5/10</td>
					<td>4/4</td>
					<td>7/10</td>
				</tr>
				<tr>
					<td>2/2</td>
					<td>5/10</td>
					<td>4/4</td>
					<td>7/10</td>
				</tr>
			</table>

		</div>
	</body>
</html>