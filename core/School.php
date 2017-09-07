<?php 

	class School{

		private $id;

		public function register($school, $participants){

			$events = $GLOBALS["events"];
			$db = $GLOBALS["db"];

			//Unwraping school data
			$name = @trim($school["name"]);
			$teacher = @trim($school["teacher"]);
			$teacherEmail = @trim($school["teacherEmail"]);
			$teacherPhone = @trim($school["teacherPhone"]);
			$principal = @trim($school["principal"]);

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
				$pName = @$p->name;
				$pEvent = @$p->event;
				$pClass = @$p->class;
				$pEmail = @$p->email;

				//Emptyness Check
				if(strlen($pName) < 1 || strlen($pEmail) < 1 || strlen($pEvent) < 1 || strlen($pClass) < 1){
					return [false, "MISSING_PARTICIPANT_DATA"];
				}

				//Data Validation
				if( (!@$events[$pEvent]["participantCount"]) || (!filter_var($pEmail, FILTER_VALIDATE_EMAIL)) || ((int)$pClass < @$events[$pEvent]["classes"][0] ||  (int)@$pClass > $events[$pEvent]["classes"][1]) ){
					return [false, "INC_PARTICIPANT_DATA"];
				}
				if(@$registeredEvents[$pEvent]){
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
					$pName = @$p->name;
					$pEvent = @$p->event;
					$pClass = @$p->class;
					$pEmail = @$p->email;

					$pSql .= " (".$schoolId.", :name".$i.", :email".$i.", :event".$i.", :class".$i."),";
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
			return [true, $schoolId];
		}

		public function startSess($login = false){
			session_start();
			if($login){
				session_regenerate_id();
			}
		}

		private function setSess($id){			
			$_SESSION["loggedIn"] = true;
			$_SESSION["schoolId"] = $id;
			$this->id = $id;
		}

		public function authSess(){
			
			$db = $GLOBALS["db"];
			
			if(@!$_SESSION["loggedIn"] || !@$_SESSION["schoolId"]){
				return [false, "NO_SESS"];
			}

			$id = $_SESSION["schoolId"];

			$qry = $db->prepare("SELECT * FROM schools WHERE id = :id LIMIT 1");
			$qry->execute([":id" => $id]);
			$res = $qry->fetch(PDO::FETCH_ASSOC);

			if(!@$res["id"]){
				return [false, "MISSING_DB"];
			}

			$this->id = $res["id"];

			return [true, $res];

		}

		public function getParticipants($id = false){			

			$db = $GLOBALS["db"];

			if($id === false){
				$id = $this->id;
			}

			$qry = $db->prepare("SELECT id, name, event, email, class FROM participants WHERE schoolId = :id ORDER BY event");
			$qry->execute([":id" => $id]);
			$res = $qry->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}

		public function login($email, $pass){

			$email = trim($email);
			$pass = trim($pass);			
			$db = $GLOBALS["db"];

			if(strlen($email) < 1 || strlen($pass) < 1){
				return [false, "MISSING_PARAM"];
			}

			$qry = $db->prepare("SELECT * FROM schools WHERE teacherEmail = :email LIMIT 1");
			$qry->execute([":email" => $email]);
			$res = $qry->fetch(PDO::FETCH_ASSOC);

			if(@!$res[id]){
				return [false, "INC_EMAIL"];
			}

			if($pass === $res["password"]){
				$this->setSess($res["id"]);
				return [true];	
			}else{
				return [false, "INC_PASS"];	
			}
		}		

		public function removeParticipant($pid, $sid = false){
			if(!$sid){
				$sid = $this->id;
			}
			$db = $GLOBALS["db"];

			if(strlen($pid) < 1){
				return [false, "MISSING_PARAM"];
			}

			$pid = (int)$pid;			

			$qry = $db->prepare("DELETE FROM participants WHERE id = :pid AND schoolId = :sid");
			$qry->execute([":pid" => $pid, ":sid" => $sid]);

			if($qry->rowCount()){
				return [true, $this->getParticipants()];
			}else{
				return [false, "NO_PART"];
			}
		}

		public function addParticipant($name, $email, $class, $evt, $sid = false){
			if(!$sid){
				$sid = $this->id;
			}
			$db = $GLOBALS["db"];
			$events = $GLOBALS["events"];

			if(strlen($name) < 1 || strlen($email) < 1 || strlen($class) < 1 || strlen($evt) < 1){
				return [false, "MISSING_PARAM"];
			}		


			$qry = $db->prepare("SELECT COUNT(*) FROM participants WHERE schoolId = :sid AND event = :evt");
			$qry->execute([":sid" => $sid, ":evt" => $evt]);
			$c = $qry->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];
			$c = (int)$c;

			// return $c;

			if( (!@$events[$evt]["participantCount"]) || (!filter_var($email, FILTER_VALIDATE_EMAIL)) || ((int)$class < @$events[$evt]["classes"][0] ||  (int)$class > $events[$evt]["classes"][1])){
				return [false, "INC_PARTICIPANT_DATA"];				
			}

			if($c >= @$events[$evt]["participantCount"]){
				return [false, "FULL_EVT_PARTICIPATION"];
			}

			$qry = $db->prepare("INSERT INTO participants (name, email, class, event, schoolId) VALUES (:name, :email, :class, :evt, ".$this->id.")");
			$qry->execute([
				":name" => $name,
				":email" => $email,
				":class" => $class,
				":evt" => $evt,				
			]);

			return [true, $this->getParticipants()];

		}


	}

?>