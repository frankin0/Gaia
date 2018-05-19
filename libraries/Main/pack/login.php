	<?php Template::view("Main::head::header", [ 'title' => 'Login Demo' ]) ?>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="./signup">
					<img src="app/assets/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					Gaia
				</a>
			</div>
		</nav>

		<div class="wrapper">
			<form class="form-signin" form-login>
				<h2 class="form-signin-heading">Login</h2>
				<input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
				<input type="password" class="form-control" name="password" placeholder="Password" required=""/>
				<label class="checkbox">
					<input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
				</label>
				<button class="btn btn-lg btn-primary btn-block submit-log" type="submit" submit-log>Login</button>
				<a href="./signup"><p>Are you already registered?</p></a>
			</form>
		</div>
	<?php Template::view("Main::footer::bottom") ?>
