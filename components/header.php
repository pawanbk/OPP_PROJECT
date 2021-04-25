<head>
	<link rel="stylesheet" href="../mycss.css" >
	<link rel="stylesheet" href="../style/style_modal/style.css" >
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik&display=swap">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src='../js/app.js'></script>
	<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
	<nav class="navbar">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="../html_pages/index.php"><?php echo $config['app']['name'];?> </a>
			</div>
			<?php
				$user = new user();
				if($user->isLoggedIn())
	
			{
				?>
			<ul class='navbar-left'>
				<li><a href="../html_pages/index.php">Home</a></li>
				<li><a href="../task/setting.php">Setting</a></li>
			</ul>
			<ul class="navbar-right">
					<li><a href="../user/logout.php"><span class="glyphicon glyphicon-log-in"></span> logout</a></li>
			</ul>
				<?php } 
				else{?>
					<ul class="navbar-right">
						<li><a href="../user/register.php"><span class=""></span> Register / Login</a></li>
					</ul>
				<?php }?>
			
		</div>
	</nav>
</head>
<body>
	
