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
				echo "<script>scroolLog();</script>";
		
				echo "<li>In Preparation for the unpacking...</li>";
				echo "<script>scroolLog();</script>";
		
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
						echo "<script>scroolLog();</script>";
					}
					$zip->extractTo($folder_cryt);
					$zip->close();
				
					echo "<li>File Unpacking Successfully!</li>";
					echo "<script>scroolLog();</script>";

					unlink("$file_name");

					echo "<li>Copyng Directory!</li>";
					echo "<script>scroolLog();</script>";

					if(file_exists($folder_cryt."/config.php")){
						require($folder_cryt."/config.php");
					}

					echo "<li>Plugin Copied!</li>";
					echo "<script>scroolLog();</script>";

					try {
						self::delete_files($folder_cryt);
					} catch (Exception $e) {
						echo '<li><font color="red">Caught exception: '.$e->getMessage().'!</font><li>';
						echo "<script>scroolLog();</script>";
					}

					echo "<li>Refresh in 5 Seconds!</li>";
					echo "<script>scroolLog();</script>";
					
					echo '<meta http-equiv="refresh" content="5">';
					
				}else echo '<li><font color="red">Errore nell\'apertura</font><li>'; echo "<script>scroolLog();</script>";
			}
	
		}
		
		
	}

	public static function Settings_Update($data){
		$data_old_tx = $data['old_TX'];


		$path_to_file = __DIR__.'/../../core/Class.ini.php';
		$file_contents = file_get_contents($path_to_file);
		$startPos = strpos($file_contents, $data['id']);
		$subStr = substr($file_contents, $startPos);
		$subStrUpdated = preg_replace("/{$data_old_tx}/i", $data['text'], $subStr, 1);
		$file_contents = str_replace($subStr, $subStrUpdated, $file_contents);
		//file_put_contents($path_to_file,$file_contents);
		echo "Coming Soon";
	}

}