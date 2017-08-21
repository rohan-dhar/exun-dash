$(document).ready(function(){
	
	function Student(name, event, std, email){
		this.name = name;
		this.event = event;
		this.std = std;
		this.email = email;
	}

	var students = [];

	function setClass(){
		var e = $("#reg-add-student-event").val();
		var html = "<option selected disabled value='Student Class'>Student Class</option>";
		for(var i = events[e].classes[0]; i <= events[e].classes[1]; i++){
			html += "<option value='" + i + "'>" + i + "</option>";
		}
		$("#reg-add-student-class").html(html);		
	}


	function isEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}		

	function getEventNum(e){
		var c = 0;
		for(i in students){
			if(students[i].event == e){
				c++;
			}
		}
		return c;
	}

	function setTableData(){

		var html1 = "<tr><th>S. No.</th><th>Name</th><th>Event</th><th>Class</th><th>Email</th></tr>", html2 = "", html3 = "";
		var c = 0;

		//Users table
		for (i in students){
			c++;
			html1 += "<tr>";
				html1 += "<td>"+c+"</td>";
				html1 += "<td>"+students[i].name+"</td>";
				html1 += "<td>"+events[students[i].event].name+"</td>";
				html1 += "<td>"+students[i].std+"</td>";
				html1 += "<td>"+students[i].email+"</td>";				
			html1 += "</tr>";			
		}

		$("#reg-students").html(html1);		

		//Events Table
		html2 = "<tr>";
		html3 = "<tr>";
		for(i in events){
			html2 += "<th>" + events[i].name + "</th>";	
			html3 += "<td>" + getEventNum(i) + " / <span class='reg-events-total'>" + events[i].participantCount+"</span> </td>";
		}
		html2 += "</tr>";
		html3 += "</tr>";

		html2 += html3;

		$("#reg-events").html(html2);

	}


	function addStutent(){

		var name = $("#reg-add-student-name").val(), event = $("#reg-add-student-event").val(), std = $("#reg-add-student-class").val(), email = $("#reg-add-student-email").val();

		if(!event){
			event = "";
		}
		if(!std){
			std = "";
		}

		name = name.trim();
		email = email.trim();
		event = event.trim();
		std = std.trim();

		var e = events[event];

		if(name == "" || event == "" || std == "" || email == ""){
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
		if(!e){			
			swal({
				title: "The student was not added!",
				text: "Invalid event selected. Refresh the page and try again.",
				type: "error",
			});				
			return false;
		}		
		if(std < e.classes[0] || std >> e.classes[1]){			
			swal({
				title: "The student was not added!",
				text: "Invalid class selected. Refresh the page and try again.",
				type: "error",
			});				
			return false;
		}		
		if(getEventNum(event) >= e.participantCount){
			swal({
				title: "The student was not added!",
				text: "Maximum students for "+e.name+" have been added. To add this student, remove a student from "+e.name+".",
				type: "error",
			});				
			return false;
		}

		students.push(new Student(name, event, std, email));
		swal({
			title: "Student Added!",
			text: "The student was added successfully!",
			type: "success",
		});

		setTableData();

		$("#reg-add-student-name").val("");
		$("#reg-add-student-event")[0].selectedIndex = 0;
		$("#reg-add-student-class").html("<option selected disabled value='Student Class'>Student Class</option>");
		$("#reg-add-student-email").val("");

		return true;
	}

	$("#reg-add-student-event").change(setClass);
	$("#reg-add-student").click(addStutent);

	setTableData();
});