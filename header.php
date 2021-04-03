<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="mycss.css" >
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php"><?php echo $config['app']['name'];?> </a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<?php
				$user = new user();
				if($user->isLoggedIn())
				{
				?>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> logout</a></li>
				<?php } 
				else{?>
					<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> login</a></li>
				<?php }?>
			</ul>
		</div>
	</nav>
</head>
<body>