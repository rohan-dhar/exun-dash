$(document).ready(function(){

	function setClass(){
		var e = $("#add-participant-event").val();
		var html = "<option selected disabled value='Participant Class'>Participant Class</option>";
		for(var i = events[e].classes[0]; i <= events[e].classes[1]; i++){
			html += "<option value='" + i + "'>" + i + "</option>";
		}
		$("#add-participant-class").html(html);		
	}


	function getEventNum(e){
		var c = 0;
		for(var i in part){
			if(part[i].event == e){
				c++;
			}
		}
		return c;
	}

	function setTableData(){
		var html1 = "<tr><th>S. No.</th><th>Name</th><th>Event</th><th>Class</th><th>Email</th><th></th></tr>", html2 = "", html3 = "";
		var c = 0;

		//Users table
		for (i in part){
			c++;
			html1 += "<tr id='participant-"+i+"'>";
				html1 += "<td>"+c+"</td>";
				html1 += "<td>"+$("<div>").text(part[i].name).html()+"</td>";
				html1 += "<td>"+events[part[i].event].name+"</td>";
				html1 += "<td>"+part[i].class+"</td>";
				html1 += "<td>"+$("<div>").text(part[i].email).html()+"</td>";			
				html1 += "<td><img src='img/close.png' class='remove-participant'></td>";								
			html1 += "</tr>";			
		}
		$("#participants").html(html1);		

		//Events Table
		html2 = "<tr>";
		html3 = "<tr>";
		for(i in events){
			var p = events[i].participantCount;
			var name = events[i].name;
			var n = getEventNum(i);
			html2 += "<th>" + name + "</th>";	
			if(p == n){
				html3 += "<td><span class='events-complete'>"+ n +" / "+ p + "</span> </td>";
			}else{
				html3 += "<td>" + n + " / <span class='events-total'>" + p + "</span> </td>";			
			}
		}
		html2 += "</tr>";
		html3 += "</tr>";
		html2 += html3;
		$("#events").html(html2);
	}

	function addParticipant(){

		var name = $("#add-participant-name").val(), event = $("#add-participant-event").val(), std = $("#add-participant-class").val(), email = $("#add-participant-email").val();

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
				title: "The participant was not added!",
				text: "Participant's name, event, class and email, all are not provided.",
				type: "error",
			});				
			return false;
		}
		if(!isEmail(email)){
			swal({
				title: "The participant was not added!",
				text: "Invalid participant email provided.",
				type: "error",
			});				
			return false;
		}
		if(!e){			
			swal({
				title: "The participant was not added!",
				text: "Invalid event selected. Refresh the page and try again.",
				type: "error",
			});				
			return false;
		}		
		if(std < e.classes[0] || std >> e.classes[1]){			
			swal({
				title: "The participant was not added!",
				text: "Invalid class selected. Refresh the page and try again.",
				type: "error",
			});				
			return false;
		}		
		if(getEventNum(event) >= e.participantCount){
			swal({
				title: "The participant was not added!",
				text: "Maximum participants for "+e.name+" have been added. To add this participant, remove a participant from "+e.name+".",
				type: "error",
			});				
			return false;
		}

	}


	setTableData();
	$("#add-participant-event").change(setClass);
	$("#add-participant-go").click(addParticipant);	

});