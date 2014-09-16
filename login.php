<?php
session_start();
if (isset($_SESSION) || !empty($_SESSION)) {
	unset($_SESSION);
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>Login</title>

		<!-- Compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		
		<!-- Minified jQuery 2.1.1 -->
		<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		
		<!-- Compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<script type="text/javascript">
			$(document).ready(function() {
				$('form').on('submit', function(e) {
					e.preventDefault();
					var formData = $('#login').serialize();
					$.ajax({
						type: 'POST',
						url: 'api/user.php',
						data: formData,
						async: 'true'
					}).done(function(response) {
						$('#welcome').html(response);
					});
				});
			});
		</script>
		
	</head>

	<body>
		<div class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Website!</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="index.php">Home</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">About</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
		
		<div class="container">
		
			<div class="text-center">
				<h1 id="welcome">Login</h1>
				<form id="login" class="form-horizontal" action="api/user.php" method="post">
					<fieldset>

						<!-- Form Name -->
						<legend>Welcome Back</legend>

						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="username">Username</label>	
							<div class="col-md-5">
								<input id="username" name="username" placeholder="please enter your email" class="form-control input-md" required="" type="text">
	
							</div>
						</div>

						<!-- Password input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="password">Password</label>
							<div class="col-md-5">
								<input id="password" name="password" placeholder="Please enter your password" class="form-control input-md" required="" type="password">
	
							</div>
						</div>


						<!-- Button -->
						<div class="form-group">
							<label class="col-md-4 control-label" for="submit"></label>
							<div class="col-md-1">
								<button id="submit" name="submit" class="btn btn-primary">Login</button>
							</div>
						</div>

					</fieldset>
				</form>

			</div>
		</div><!-- /.container -->
	
	</body>

</html>
