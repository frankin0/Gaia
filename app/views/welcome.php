<?php

	use Gaia\core\config\Template;
?>

	<?php Template::view("layout::header") ?>


		<div>
			<div class="container container-xlarge">
				<div class="col m6 ">
					<div class="">
				
						<h1>Gaia<span>V <?=self::$ini['version']?></span></h1>

						<h1>wishes you a good welcome!</h1>

						<ul>

							<li><a href="https://www.facebook.com/espowebcom/" target="_blank">Facebook</a></li>

							<li><a href="https://github.com/frankin0/Gaia">GitHub</a></li>

							<li><a href="https://espoweb.it" target="_blank">espoweb.it</a></li>

							<li><p >&copy; 2017-2020</p></li>

						</ul>
					</div>
				</div>
				<div class="col m6 m_color">
					<div class="m_color">
						<a href="https://espoweb.it">
							<img src="app/assets/img/logo.png" width="200px" alt="espoweb" title="espoweb.it">
						</a>
						
					</div>
				</div>
			</div>
		</div>

	<?php Template::view("layout::bottom") ?>