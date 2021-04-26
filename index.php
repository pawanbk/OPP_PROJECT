<!DOCTYPE html>
<html>	
	<?php
		require_once '../core/init.php';
		include "{$config['path']['p3']}header.php";
		if (Session::exists('success'))
		{
			echo '<div class="alert alert-success" role="alert">'
			.Session::flash('success').
			'</div>';
		}
		if ($user->IsLoggedIn())
		{
			include '../project/view.php';
		}
		else 
		{
			include '../user/login.php';
		}
		
	?>
	</body>
	<?php include "{$config['path']['p3']}footer.php"; ?>
</html>



