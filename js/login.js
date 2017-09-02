$(document).ready(function(){

	function login(){
		var email = $("#login-email").val().trim();
		var pass = $("#login-pass").val().trim();

		if(email.length < 1 || pass.length < 1){
			swal({
				title: "Whoops!",
				text: "Please provide both the email and password to login!",
				type: "error",
			});				
			return false;
		}

		$.ajax({
			url: "api/login.php",
			type: "post",
			data: {
				"email": email,
				"password": pass,
			},
			dataType: "json",
			beforeSend: function(){
				swal({
					title: "Loggin you in...",
					text: "Please wait while we log you in...",
				});
				swal.showLoading();				
			},
			success: function(d){					
				if(d[0]){
					location = "dashboard.php";
				}else if(d[1] == "INC_EMAIL"){
					swal({
						title: "Whoops!",
						html: "The email entered is not correct. Try again.",
						type: "error",
					});
				}else if(d[1] == "INC_PASS"){
					swal({
						title: "Whoops!",
						html: "The password entered is not correct. Try again.",
						type: "error",
					});
				}else{
					swal({
						title: "Whoops!",
						html: "An error occured! Try again.",
						type: "error",
					});					
				}
			},
			error: function(){
				swal({
					title: "Whoops!",
					html: "You are not connected to the internet. Try again.",
					type: "error",
				});
			}
		});

	}

	$("#login-go").click(login);
});