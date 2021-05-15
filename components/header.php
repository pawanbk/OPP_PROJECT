<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php echo $config['base_url']?>mycss.css" >
		<link rel="stylesheet" href="<?php echo $config['base_url']?>style/style_modal/style.css" >
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="<?php echo $config['base_url']?>mycss.css" >
		<link rel="stylesheet" href="<?php echo $config['base_url']?>style/style_modal/style.css" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;1,500&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik&display=swap">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
		<script src='<?php echo $config['base_url']?>js/app.js'></script>

		<title>OOP_PROJECT</title>
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			<div class="container-fluid">
				<a class="navbar-brand" href="<?php  echo base_url('index.php')?>"><?php echo $config['app']['name'];?> </a>
				<div class="collapse navbar-collapse">
					<ul class="navbar-nav">
						<?php
						$user = new user();
						if($user->isLoggedIn()):
						?>
						<li class="nav-item">
							<a class="nav-link"  href="<?php echo base_url('index.php')?>">Home</a>
						</li>
						<li class="nav-item dropdown">
							<a id="dropdown-btn" class="nav-link dropdown-toggle">
							Settings
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="<?php echo base_url('task/status.php')?>">Status</a></li>
								<li><a class="dropdown-item" href="<?php echo base_url('task/type.php')?>">Type</a></li>
								<li><a class="dropdown-item" href="<?php echo base_url('task/priority.php')?>">Priority</a></li>
							</ul>
						</li>
						<li class="nav-item"><div class="right mr-10"><a class="nav-link" href="<?php echo base_url('user/logout.php')?>">logout</a></div></li>
						<?php else:
						endif;?>

					</ul>
				</div>
			</div>
		</nav>
		<script>
			$('.dropdown').mouseover(function(){
				$('.dropdown-menu').show();
			});
			$('.dropdown').mouseleave(function(){
				$('.dropdown-menu').hide();
			});


		</script>

