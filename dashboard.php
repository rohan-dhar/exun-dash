<?php 
	
	require 'core/config.php';
	require 'core/School.php';

	$s = new School;
	$s->startSess();

	$det = $s->authSess();

	if(!$det[0]){
		header("Location: index.php");
		exit();
	}

	$det = $det[1];
	$part = $s->getParticipants();

	$styles = ["css/dashboard.css"];
	$scripts = ["js/dashboard.js"];
	$title = APP;	

?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript">
			window.part = <?php echo json_encode($part); ?>;
		</script>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h1 class="ui-page-head"><b>Exun 2017</b><br>Dashboard</h1>
		<div class="ui-page-content">
			<h2 id="school-name">Welcome, <b><?php echo $det["name"];?></b></h2>			


			<h2 class="ui-page-content-head" id="participant-head">Participants List</h2>
			<table id="participants">
			</table>

			<h2 class="ui-page-content-head" id="event-head">Events List</h2>
			<table id="events">
			</table>

			<h2 class="ui-page-content-head" id="add-head">Add Participant</h2>
			<input type="text" class="ui-inp-text add-inp" id="add-participant-name" placeholder="Participant Name">
			<select class="ui-inp-text add-inp" id="add-participant-event">							
				<option selected disabled value="Participant Event">Participant Event</option>			
				<?php 
					foreach($events as $k => $e){				
						echo "<option value='".$k."'>".$e["name"]."</option>";
					}
				?>
			</select>
			<br>
			<input type="email" class="ui-inp-text add-inp" id="add-participant-email" placeholder="Participant Email">	
			<select class="ui-inp-text add-inp" id="add-participant-class">							
				<option selected disabled value="Participant Class">Participant Class</option>			
			</select>
			<br>
			<button class="ui-btn add-btn" id="add-participant-go">Add Participant</button>

		</div>
	</body>
</html>