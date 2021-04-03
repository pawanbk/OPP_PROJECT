<!DOCTYPE html>
<html>	
	<?php
		require_once 'core/init.php';
		include 'header.php';
		if (Session::exists('success'))
		{
			echo '<div class="alert alert-success" role="alert">'
			.Session::flash('success').
			'</div>';
		}
		if ($user->IsLoggedIn())
		{
			include 'activity.php';
		}
		else 
		{
			include 'register.php';
		}
		
	?>

	</body>
</html>



