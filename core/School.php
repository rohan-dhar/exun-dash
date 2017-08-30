<?php 

	class School{

		public function register($school, $participants){

			$events = $GLOBALS["events"];
			$db = $GLOBALS["db"];

			//Unwraping school data
			$name = @trim($school["name"]);
			$teacher = @trim($school["teacherName"]);
			$teacherEmail = @trim($school["teacherEmail"]);
			$teacherPhone = @trim($school["teacherPhone"]);
			$principal = @trim($school["principalName"]);

			//Emptyness Check
			if(strlen($name) < 1 || strlen($teacher) < 1 || strlen($teacherPhone) < 1 || strlen($teacherEmail) < 1 || strlen($principal) < 1){
				return [false, "MISSING_SCHOOL_DATA"];
			}

			//School Data validation
			if( (!ctype_digit($teacherPhone) || strlen($teacherPhone) != 10) || (!filter_var($teacherEmail, FILTER_VALIDATE_EMAIL)) ){
				return [false, "INC_SCHOOL_DATA"];
			}
	
			//To check if the school has already registered
			$qry = $db->prepare("SELECT * FROM schools WHERE teacherEmail = :email");
			$qry->execute([":email" => $teacherEmail]);
			$res = $qry->fetch(PDO::FETCH_ASSOC);
			if(@isset($res["id"])){
				return [false, "ALREADY_REGISTERED"];
			}

			//Participant Data Validation
			$registeredEvents = [];
			foreach ($participants as $p){
				
				//Unwrapping Participant Data
				$pName = @$p["name"];
				$pEvent = @$p["event"];
				$pClass = @$p["class"];
				$pEmail = @$p["email"];
				
				//Emptyness Check
				if(strlen($pName) < 1 || strlen($pEmail) < 1 || strlen($pEvent) < 1 || strlen($pClass) < 1){
					return [false, "MISSING_PARTICIPANT_DATA"];
				}

				//Data Validation
				if( (!@$events[$pEvent]["participantCount"]) || (!filter_var($pEmail, FILTER_VALIDATE_EMAIL)) || ((int)$pClass < @$events[$pEvent]["classes"][0] ||  (int)@$pClass > $events[$pEvent]["classes"][1]) ){
					return [false, "INC_PARTICIPANT_DATA"];
				}
				if($registeredEvents[$pEvent]){
					$registeredEvents[$pEvent]++;
				}else{
					$registeredEvents[$pEvent] = 1;					
				}
			}
			if(count($registeredEvents) < 3){
				return [false, "LESS_EVENTS"];
			}
			foreach ($registeredEvents as $k => $v) {
				if($v !== $events[$k]["participantCount"]){
					return [false, "LESS_EVENTS"];
				}
			}


			$qry = $db->prepare("INSERT INTO schools (name, principalName, teacherName, teacherEmail, teacherPhone) VALUES(:name, :principal, :teacher, :teacherEmail, :teacherPhone)");
			$qry->execute([
				":name" => $name,
				":principal" => $principal,
				":teacher" => $teacher,
				":teacherEmail" => $teacherEmail,
				":teacherPhone" => $teacherPhone,				
			]);
			$schoolId = $db->lastInsertId();

			if(count($participants) > 0){
				//Generating Students Querty String
				$pSql = "INSERT INTO participants (schoolId, name, email, event, class) VALUES";			
				$pSqlVars = []; 
				$i = 1;

				foreach($participants as $p){				
					$pName = @$p["name"];
					$pEvent = @$p["event"];
					$pClass = @$p["class"];
					$pEmail = @$p["email"];

					$pSql .= " (".$schoolId.", :name".$i.", :event".$i.", :class".$i.", :email".$i."),";
					$pSqlVars[":name".$i] = $pName;
					$pSqlVars[":event".$i] = $pEvent;
					$pSqlVars[":class".$i] = $pClass;
					$pSqlVars[":email".$i] = $pEmail;				

					$i++;
				}

				$pSql = substr($pSql, 0, -1);
				$qry = $db->prepare($pSql);
				$qry->execute($pSqlVars);
			
			}			
			return [true];
		}
	}

?>