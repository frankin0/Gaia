	<?php Template::view("Main::head::header", [ 'title' => 'Register Demo' ]) ?>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="./signin">
					<img src="app/assets/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					Gaia
				</a>
			</div>
		</nav>

		<div class="wrapper">
			<form class="form-signin" form-registration>
				<h2 class="form-signin-heading">Registration</h2>
				<input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
				<input type="email" class="form-control" name="email" placeholder="Email" required=""/>
				<input type="password" class="form-control" name="password" placeholder="Password" required=""/>
				<input type="password" class="form-control" name="repeatpassword" placeholder="Repeat Password" required=""/>
				<a href="./signin"><p>You are not registered?</p></a>
				<button class="btn btn-lg btn-primary btn-block" type="submit" submit-ck>SignUp</button>
			</form>
		</div>

	<?php Template::view("Main::footer::bottom") ?>
