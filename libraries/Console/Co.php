<?php
namespace Gaia\libraries\Console;

class Co {
	
	public static function delete_files($dir) {
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file)){
				self::delete_files($file); 
				echo "<li>Removing ".$whatIWant = substr($file, strpos($file, "//") + 1)."/* dir </li>";
			}else{
				unlink($file); 
				echo "<li>Removing ".$whatIWant = substr($file, strpos($file, "//") + 1)." file</li>";
			}
		} rmdir($dir); 
	}
	
	
	public static function copy_dir($source, $destination ) {
		if ( is_dir( $source ) ) {
			@mkdir( $destination );
			$directory = dir( $source );
			while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
				if ( $readdirectory == '.' || $readdirectory == '..' ) {
					continue;
				}
				$PathDir = $source . '/' . $readdirectory; 
				if ( is_dir( $PathDir ) ) {
					self::copy_dir( $PathDir, $destination . '/' . $readdirectory );
					echo "<li>Coping file ".$readdirectory."...</li>";
					continue;
				}
				copy( $PathDir, $destination . '/' . $readdirectory );
				echo "<li>Coping file ".$readdirectory."...</li>";
			}

			$directory->close();
		}else {
			copy( $source, $destination );
		}
	}


}