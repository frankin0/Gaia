<?php
	
?>
<console class="console" id="Console" >
	<html>
		<head>
			<meta name="viewport" content="width=device-width, user-scalable=no,initial-scale=1, minimum-scale=1, maximum-scale=1">
			<meta name="HandheldFriendly" content="True">
			<meta name="apple-touch-fullscreen" content="yes">
			<meta name="apple-mobile-web-app-capable" content="yes">
			<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700&subset=latin-ext" rel="stylesheet">
			<link rel="stylesheet" href="<?php echo cons_dir; ?>style.css" >
		</head>
		<body>
			
			<div class="main">
				<div class="drag"><div class="icn"><i class="material-icons">more_horiz</i></div></div>
				<div class="header">
					<ul class="list-links">
						<li class="active"><a href="#elements" class="links">Elements</a></li>
						<li><a href="#log" class="links">Log</a></li>
						<li><a href="#ini" class="links">Settings</a></li>
						<li><a href="#informations" class="links">Informations</a></li>
					</ul>
					<ul class="right">
						<li><a class="hide-box"><i class="material-icons">keyboard_arrow_down</i></a></li>
						<li><a class="close-box"><i class="material-icons">clear</i></a></li>
					</ul>
				</div>
				<div class="body">
					<div id="elements" class="table"style="display: block;">
						<ul>
							<?php 
							foreach(glob('libraries/*', GLOB_ONLYDIR) as $dir) {
								$dir = str_replace('libraries/', '', $dir);
								if(strtolower($dir) == 'console'){
									$installed = "<button id='".$dir."' class='buttonUnistall'>Unistall</button>";
								}else{ 
									if(is_dir('app/views/'.$dir)){
										$installed = "<button id='".$dir."' class='buttonUnistall'>Unistall</button>";
									}else{
										$installed = "<button id='".$dir."' class='buttonInstall'>Install</button>";
									}
								}
								echo '<li><a>'.$dir.' <span class="right">'.$installed.'</span></a></li>';

							}	
							?>
						</ul>
					</div>
					<div id="log" class="table">
						<ul>
							<?php 
								foreach($GLOBALS['log'] as $key){
									echo '<li>'.$key.'</li>';
								}
							?>
						</ul>
					</div>
					<div id="ini" class="table" >
						<div class="tb_fhsy"> 
							<p>Check the file Class.ini.php in <b>Gaia/core/</b> directory</p><br>
							<h3 class="right">Update Plugin in Libraries</h3>
							<div>
								<label>
									<form enctype="multipart/form-data" id="load_file_form" >
										<input type="file" required name="file_plgs__" id="file_plgs__" accept='application/zip,application/rar' value="Load one rar file" />
										<input type="submit" name="submit" value="Send" />
									</form>
								</label>
							</div>
						</div> 
					</div>
					<div id="informations" class="table">
						<br><br>
						<center><h3>Gaia Console V.1.0</h3><br><p>Latest Version</p></center>
					</div>
				</div>
			</div>
			
			<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
			<script src="<?php echo cons_dir; ?>console.js"></script>
		</body>
	</html>
</console>