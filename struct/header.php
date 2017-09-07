<header class="ui-header">
	<a href="http://exunclan.com"><img class="ui-header-logo" src="img/logo.png" /></a>
	<?php 
		if(@$loggedIn) {
			echo "<a class='ui-header-logout' href='logout.php'>Logout</a>";	
		}else{
			echo "<a class='ui-header-menu' href='index.php'>Home</a>";			
			echo "<a class='ui-header-menu' href='login.php'>Login</a>";			
			echo "<a class='ui-header-menu' href='register.php'>Register</a>";					
		}
	?>
</header>
<div class="ui-dis"></div>