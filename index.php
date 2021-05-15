<?php
	require_once 'core/init.php';
	include "components/header.php";
	if (Session::exists('success'))
	{
		echo '<div class="alert alert-success" role="alert">'
		.Session::flash('success').
		'</div>';
	}
	if ($user->IsLoggedIn())
	{
		include 'project/view.php';
	}
	else 
	{
		include 'user/login.php';
	}
	
?>
</body>
	<?php include "components/footer.php"; ?>
</html>



