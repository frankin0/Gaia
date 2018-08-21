<?php

namespace Gaia\libraries\Console;
use Gaia\core\config\Router;
use Gaia\libraries\Console\Co;



require_once '../../core/config/Router.php';
require_once 'Co.php';


Router::post('/console/unistall/{id}', function($data){
	if($data->id == 'Console'){
		echo "<li><font color='red'>Uninstallation failed.</font></li>";
		echo "<li>Disable it in the settings of Gaia</li>";	
	}else{
		echo "<li>Uninstall process, removing all files and database table... ...</li>";
		echo Co::delete_files('../../app/views/'.$data->id.'/');
	}
	exit();
}, true);

Router::post('/console/install/{id}', function($data){
	if($data->id != 'Console'){
		echo "<li>Installation process..</li>";
		
		echo Co::copy_dir('../../libraries/'.$data->id, '../../app/views/'.$data->id);
	}
	exit();
}, true);

Router::post('/console/terminal/versionFrm', function($data){
	echo json_encode(array('terminal_version'=> '2.0', 'framework_version'=> '1', 'current_framework_version' => '2'));
	exit();
}, true);

if(isset($_POST['route'])){
	$data = array("old_TX" => $_POST['old_TX'],"text" => $_POST['input_val'], "id" => $_POST['id']);
	echo Co::Settings_Update($data);
	exit();
}

if(isset($_FILES['file'])){
	echo Co::Upload($_FILES['file']);
	exit();
}