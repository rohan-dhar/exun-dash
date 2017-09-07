$(document).ready(function(){

	function Student(name, event, std, email){
		this.name = name;
		this.event = event;
		this.std = std;
		this.email = email;
	}

	Student.prototype.getDataObject = function(first_argument) {
		var obj = {};
		obj["name"] = this.name;
		obj["event"] = this.event;
		obj["class"] = this.std;		
		obj["email"] = this.email;				
		return obj;		
	};

	window.students = [];

	function addStudentToList(name, event, std, email){
		for(var i = 0; i < event.length; i++){
			students.push(new Student(name, event[i], std, email));
		}
	}

	function setEvent(){
		var std = Number($("#reg-add-student-class").val());
		$(".reg-add-student-event").prop("checked", false);
		for(i in events){
			var e = events[i];
			if(e.classes[0] <= std && e.classes[1] >= std){
				$("#reg-add-student-event-"+i).prop("disabled", false);
			}else{
				$("#reg-add-student-event-"+i).prop("disabled", true);				
			}
		}
	}


	function getEvents(std){
		
		var ret = [];

		for(i in events){
			if( $("#reg-add-student-event-"+i).prop("checked") ){
				if(events[i].classes[0] <= std && events[i].classes[1] >= std){
					ret.push(i);	
				}else{
					return false;
				}
			}
		}

		return ret;
	}

	function getEventNum(e){
		var c = 0;
		for(var i in students){
			if(students[i].event == e){
				c++;
			}
		}
		return c;
	}

	function setTableData(){

		var html1 = "<tr><th>S. No.</th><th>Name</th><th>Event</th><th>Class</th><th>Email</th><th></th></tr>", html2 = "", html3 = "";
		var c = 0;

		//Users table
		for (i in students){
			c++;
			html1 += "<tr id='student-"+i+"'>";
				html1 += "<td>"+c+"</td>";
				html1 += "<td>"+$("<div>").text(students[i].name).html()+"</td>";
				html1 += "<td>"+events[students[i].event].name+"</td>";
				html1 += "<td>"+students[i].std+"</td>";
				html1 += "<td>"+$("<div>").text(students[i].email).html()+"</td>";			
				html1 += "<td><img src='img/close.png' class='remove-student'></td>";								
			html1 += "</tr>";			
		}

		$("#reg-students").html(html1);		

		//Events Table
		html2 = "<tr>";
		html3 = "<tr>";
		for(i in events){
			var p = events[i].participantCount;
			var name = events[i].name;
			var n = getEventNum(i);
			html2 += "<th>" + name + "</th>";	
			if(p == n){
				html3 += "<td><span class='reg-events-complete'>"+ n +" / "+ p + "</span> </td>";
			}else{
				html3 += "<td>" + n + " / <span class='reg-events-total'>" + p + "</span> </td>";			
			}
		}
		html2 += "</tr>";
		html3 += "</tr>";

		html2 += html3;

		$("#reg-events").html(html2);

	}


	function addStutent(){

		var name = $("#reg-add-student-name").val(), std = $("#reg-add-student-class").val(), email = $("#reg-add-student-email").val();

		if(!std){
			std = "";
		}

		name = name.trim();
		email = email.trim();
		std = Number(std.trim());

		if(name == "" || std == "" || email == ""){
			swal({
				title: "The student was not added!",
				text: "Student's name, event, class and email, all are not provided.",
				type: "error",
			});				
			return false;
		}
		if(!isEmail(email)){
			swal({
				title: "The student was not added!",
				text: "Invalid student email provided.",
				type: "error",
			});				
			return false;
		}
		if(isNaN(std)){
			swal({
				title: "The student was not added!",
				text: "Invalid student class provided.",
				type: "error",
			});				
			return false;
		}		

		var event = getEvents(std);

		if(event.length < 1){
			swal({
				title: "The student was not added!",
				text: "Please select at least one event to add the student.",
				type: "error",
			});				
			return false;			
		}
		if(!event){
			swal({
				title: "The student was not added!",
				text: "Invalid student events provided. Refresh and try again.",
				type: "error",
			});				
			return false;			
		}


		addStudentToList(name, event, std, email);
		swal({
			title: "Student Added!",
			text: "The student was added successfully!",
			type: "success",
		});

		setTableData();

		$("#reg-add-student-name").val("");
		$("#reg-add-student-class")[0].selectedIndex = 0;
		setEvent();
		$("#reg-add-student-email").val("");

		return true;
	}


	function getEventsRegistered(){
		var ev = [], count = 0;
		for(i in students){
			var s = students[i];
			if(ev[s.event]){
				ev[s.event]++;
			}else{
				ev[s.event] = 1;
			}
		}
		for(i in ev){
			if(ev[i] == events[i].participantCount){
				count++;
			}
		}
		return count;
	}


	function register(){
		var name = $("#reg-school-name").val().trim();
		var principal = $("#reg-principal-name").val().trim();
		var teacher = $("#reg-teacher-name").val().trim();
		var teacherEmail = $("#reg-teacher-email").val().trim();
		var teacherPhone = $("#reg-teacher-num").val().trim();

		if(name.length < 1 || principal.length < 1 || teacher.length < 1 || teacherEmail.length < 1 || teacherPhone.length < 1){
			swal({
				title: "Whoops!",
				text: "Please provide all the schools details to register!",
				type: "error",
			});				
			return false;
		}else if(!isEmail(teacherEmail)){
			swal({
				title: "Whoops!",
				text: "Please enter a valid teacher's email to register!",
				type: "error",
			});				
			return false;
		}else if(!isPhone(teacherPhone)){			
			swal({
				title: "Whoops!",
				html: "Please enter a valid <b style='color: #555;'>10 digit</b> teacher's phone number to register!",
				type: "error",
			});							
			return false;
		}else if(getEventsRegistered() < 3){
			swal({
				title: "Whoops!",
				html: "Please add all the participants for at least <b style='color: #555;'>3 events</b> to register!",
				type: "error",
			});
			return false;
		}

		var participants = [];

		for(i in students){
			participants.push(students[i].getDataObject());
		}

		$.ajax({
			url: "api/registerSchool.php",
			type: "post",
			data: {
				"name": name,
				"teacher": teacher,
				"principal": principal,
				"teacherPhone": teacherPhone,				
				"teacherEmail": teacherEmail,								
				"participants": JSON.stringify(participants),
			},
			dataType: "json",
			beforeSend: function(){
				swal({
					title: "Registering...",
					text: "Please wait while we register you...",
				});
				swal.showLoading();				
			},
			success: function(d){					
				if(d[0]){
					swal({
						title: "Success!",
						html: "You have been registered successfully. You can click <a href='login.php'>here</a> to login and access your dashboard.",
						type: "success",
					}).then(function(){
						location.reload();
					});
				}else if(d[1] == "ALREADY_REGISTERED"){
					swal({
						title: "Whoops!",
						html: "You have already registered for Exun 2016. You can click <a href='login.php'>here</a> to login and access your dashboard.",
						type: "error",
					}).then(function(){
						location.reload();
					});
				}else{
					swal({
						title: "Whoops!",
						html: "An error occured! Refresh and try again.",
						type: "error",
					}).then(function(){
						location.reload();
					});					
				}
			},
			error: function(){
				swal({
					title: "Whoops!",
					html: "You are not connected to the internet. Could not register you.",
					type: "error",
				});
			}
		});


	}

	$("#reg-add-student-class").change(setEvent);
	$("#reg-add-student").click(addStutent);
	$("#reg-go").click(register);
	$("#reg-students").on("click", ".remove-student", function(){
		var n = $(this).parent().parent().attr("id").substr(8);
		students.splice(n, 1);
		setTableData();
	});



	setTableData();
});