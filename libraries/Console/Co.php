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

	public static function Upload($file){
		if ( 0 < $file['error'] ) {
			echo "<li><font color='red'>Error: " . $file['error'] . ".</font></li>";
		}
		else {
			echo "<li>Upload Process..</li>";
	
			echo "<li>File Name: ".$file['name'].", size [".$file['size']."] ..</li>";
	
			if(move_uploaded_file($file['tmp_name'], './CookieApps/' . $file['name'])){
				
				echo "<li>Upload Successfully</li>";
		
				echo "<li>In Preparation for the unpacking...</li>";
		
				/**
				 *  Unpacking zip rar
				 */
		
				$file_name = './CookieApps/' .$file['name'];
				$folder_cryt = './CookieApps/' .md5($file['name']);
				$zip = new \ZipArchive;
				sleep(1);
				$res = $zip->open($file_name);

				if ($res === TRUE) {
					if (!mkdir($folder_cryt, 0777, true)) {
						echo '<li><font color="red">Failed to create folders...</font><li>';
					}
					$zip->extractTo($folder_cryt);
					$zip->close();
				
					echo "<li>File Unpacking Successfully!</li>";

					unlink("$file_name");

					
				}else echo '<li><font color="red">Errore nell\'apertura</font><li>';
			}
	
		}
		
		
	}

}