<?php 
	
	require 'core/config.php';
	require 'core/School.php';

	$s = new School;
	$s->startSess();
	$loggedIn = false;

	if($s->authSess()[0]){
		header("Location: dashboard.php");
		exit();
	}


	$styles = ["css/register.css"];
	$scripts = ["js/register.js"];
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
			<input type="email" class="ui-inp-text reg-inp" id="reg-add-student-email" placeholder="Student Email">	
			<br>
			<select class="ui-inp-text reg-inp" id="reg-add-student-class">							
				<option selected disabled value="Student Class">Student Class</option>			
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>				
				<option value="12">12</option>				
			</select>
			<table id="reg-add-student-event-table">
				<?php 
					$html1 = "<tr>"; $html2 = "<tr>";
					foreach ($events as $k => $v) {
						$html1 .= "<th>".$v["name"]."</th>";
						$html2 .= "<td> <input type='checkbox' class='reg-add-student-event' value='".$k."' id='reg-add-student-event-".$k."' disabled>";
					}
					$html1.="</tr>";$html2.="</tr>";
					echo $html1.$html2;
				?>				
			</table>

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