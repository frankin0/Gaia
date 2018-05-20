<?php
namespace Gaia\libraries;
use Gaia\core\config\Template;

class GaiaTemplate extends Template{
	
	
	public function render($filename, $data){ 
		$path = $filename;

		if(file_exists($path)){
			$contents = file_get_contents($path);

			foreach($data as $key => $value){
				$contents = preg_replace('/\{{'.$key.'\}}/', $value, $contents); 
				echo $contents;
			}
			
			/*$contents = preg_replace('/\<\!\-\- if(.*) \-\-\>/', '<?php if($1) : ?>', $contents);
			$contents = preg_replace('/\<\!\-\- else \-\-\>/', '<?php else: ?>', $contents);
			$contents = preg_replace('/\<\!\-\- endif \-\-\>/', '<?php endif; ?>', $contents);*/
			/*
			$contents = preg_replace('/\@if(.*)/', '<?php if($1): ?>', $contents);
			$contents = preg_replace('/\@elseif(.*)/', '<?php elseif($1): ?>', $contents);
			$contents = preg_replace('/\@else/', '<?php else: ?>', $contents);
			$contents = preg_replace('/\@endif/', '<?php endif; ?>', $contents);
			$contents = preg_replace('/\@extends(.*)/', '<?php require("app/views/".explode(".", $1)[0]."/".explode(".", $1)[1].".html"); ?>', $contents);

			eval(' ?>'.$contents.'<?php ');*/
		}else{
			exit('<h1>Template Error</h1>');
		}
	}
	
}