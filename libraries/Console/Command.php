<?php

namespace Gaia\libraries\Console;
use Gaia\core\classes\Router;
use Gaia\libraries\Console\Co;

require_once '../../core/classes/Router.php';
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