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
}, true);

Router::post('/console/install/{id}', function($data){
	if($data->id != 'Console'){
		echo "<li>Installation process..</li>";
		
		echo Co::copy_dir('../../libraries/'.$data->id, '../../app/views/'.$data->id);
	}
}, true);

Router::post('/console/settings/update/{text}/id/{id}', function($data){
	
});

if(isset($_POST['route'])){
	$data = array("old_TX" => $_POST['old_TX'],"text" => $_POST['input_val'], "id" => $_POST['id']);
	echo Co::Settings_Update($data);
}

if(isset($_FILES['file'])){
	echo Co::Upload($_FILES['file']);
}