<!Doctype html>
<html>
	<head>
		<title><?php echo $title; ?></title>
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
			[form-login] input[type="text"] {
				margin-bottom: -1px;
				border-bottom-left-radius: 0;
				border-bottom-right-radius: 0;
			}
			[form-login] input[type="password"] {
				margin-bottom: 20px;
				border-top-left-radius: 0;
				border-top-right-radius: 0;
			}

			[form-registration] .form-control{
				border-bottom-left-radius: 0;
				border-bottom-right-radius: 0;
			}
			[form-registration]	.form-control:nth-child(3){
				border-radius: 0;
				border-top: 0px;
				border-bottom: 0px;
			}
			[form-registration] .form-control:nth-child(4){
				border-radius: 0;
				border-bottom: 0;
			}
			[form-registration] .form-control:nth-child(5){
				border-bottom-left-radius: .25rem;
				border-bottom-right-radius: .25rem;
				border-top-left-radius: 0;
				border-top-right-radius: 0;
				margin-bottom: 20px;
			}

			.notify{
				position: fixed;
				top: 70px;
				right: 10px;
				padding: 10px 20px;
				color: #fff;
				border-radius: 3px;
			}
			.notify.success{
				background: #007bff;
			}
			.notify.error{
				background: #f72424;
			}
			.lds-ring {
			  	display: inline-block;
			  	position: relative;
			  	width: 30px;
			  	height: 30px;
			}
			.lds-ring div {
				box-sizing: border-box;
			    display: block;
			    position: absolute;
			    width: 31px;
			    height: 31px;
			    margin: 3px;
			    border: 2px solid #fff;
			    border-radius: 100%;
			    animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
			    border-color: #fff transparent transparent transparent;
			}
			.lds-ring div:nth-child(1) {
			  animation-delay: -0.45s;
			}
			.lds-ring div:nth-child(2) {
			  animation-delay: -0.3s;
			}
			.lds-ring div:nth-child(3) {
			  animation-delay: -0.15s;
			}
			@keyframes lds-ring {
			  0% {
			    transform: rotate(0deg);
			  }
			  100% {
			    transform: rotate(360deg);
			  }
			}

		</style>
	</head>
	<body>
