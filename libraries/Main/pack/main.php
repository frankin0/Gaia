<!Doctype html>
<html>
	<head>
		<title>Home Demo</title>
		<meta name="viewport" content="width=device-width, user-scalable=no,initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="HandheldFriendly" content="True">
		<meta name="apple-touch-fullscreen" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<link href="app/assets/img/logo.png" rel="apple-touch-icon">
		<link href="app/assets/img/logo.png" rel="shortcut icon">
		<link href="app/assets/img/logo.ico" rel="ico">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700&subset=latin-ext" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<style>
			.form-signin {
				max-width: 380px;
				margin-top: 160px !important;
				padding: 15px 35px 45px;
				margin: 0 auto;
				background-color: #f8f9fa;
			}
			.form-signin h2{
			    font-weight: 300;
				text-align: center;
			}
			.form-signin .form-signin-heading,
			.form-signin .checkbox {
				margin-bottom: 30px;
			}
			.form-signin .checkbox {
				font-weight: normal;
			}
			.form-signin .form-control {
				position: relative;
				font-size: 16px;
				height: auto;
				padding: 10px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			.form-signin .form-control:focus {
				z-index: 2;
			}
			.form-signin input[type="text"] {
				margin-bottom: -1px;
				border-bottom-left-radius: 0;
				border-bottom-right-radius: 0;
			}
			.form-signin input[type="password"] {
				margin-bottom: 20px;
				border-top-left-radius: 0;
				border-top-right-radius: 0;
			}

		</style>
	</head>
	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="app/assets/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					Gaia
				</a>
				<a href="/logout" class="right">Logout</a>
			</div>
		</nav>

		<div class="wrapper">
			<form class="form-signin" form-login>
				<h2 class="form-signin-heading">User Connected!</h2>
				<p>Username: <b><?php echo $username; ?></b></p>
				<p>Email: <b><?php echo $email; ?></b></p>
				<p>IP: <b><?php echo $ip; ?></b></p>
				<p>Device: <b><?php echo $device; ?></b></p>
			</form>
		</div>


		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	</body>
</html>
