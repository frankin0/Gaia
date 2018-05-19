<?php
	use Gaia\core\classes\Template;
?>

	<?php Template::view("layout::header") ?>

		<div class="container">

			<h1>Gaia<span>V 1.2 Beta</span></h1>

			<h1>wishes you a good welcome!<?=$this->var?></h1>

			<ul>

				<li><a href="https://www.facebook.com/espoweb/" target="_blank">Facebook</a></li>

				<li><a href="https://github.com/frankin0/Gaia">GitHub</a></li>

				<li><a href="https://espoweb.com" target="_blank">espoweb.com</a></li>

				<li><p >&copy; 2017</p></li>

			</ul>

		</div>

	<?php Template::view("layout::bottom") ?>