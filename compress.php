<?php
	$servername = "localhost";
	$username = "root";
	$password = "NVnUtsn8spZBmkBp";
	$dbname = "portalbaseline";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$foldername2 = 'public/images/kinetisense/';
	if ($handle2 = opendir($foldername2)) {

		while (false !== ($entry2 = readdir($handle2))) {
			
			$foldername = 'public/images/kinetisense/'.$entry2."/";
			
			if ($handle = opendir($foldername)) {

				while (false !== ($entry = readdir($handle))) {
					
					echo $entry."::::<br/>";

					if ($entry != "." && $entry != "..") {

						if (strpos($entry, '.zip') !== false)
						{
							
							$p_id = str_replace("public/images/kinetisense/","",$foldername);
							$zipfd = str_replace(".zip","",$entry);
							$sql = "INSERT INTO cronimages (patient_id, zip_video, status) VALUES ('".$p_id."', '".$zipfd."', '1')";
							if ($conn->query($sql) === TRUE) {
							  echo "record added successfully";
							}

							$entry = $foldername.$entry;
							$fname =  str_replace(".zip","",$entry);
							$zip = new ZipArchive();
							$zip->open($entry, ZipArchive::CREATE);
							$zip->extractTo($fname.'/');
							$zip->close();
							
							$dir = $foldername.$fname;
							
							
							/* print_r($dir.':::this is a zip path<br/>');
							$foo = getFilesFromDir($dir);
							echo '<pre>';
							print_r($foo);
							foreach($foo as $img){
								print_r($img.':::this is a image path<br/>');
								if (strpos($img, '.jpg') !== false && ( strpos($img, 'frame_')!== false ||  strpos($img, 'compressed_')!== false))
								{
									print_r($img.':::this is a rotating<br/>');
									$entry22 = $img;
									$imageResource = imagecreatefromjpeg($entry22);
									$image = imagerotate($imageResource, 180, 0);
									imagejpeg($image, $entry22, 90);
									print_r($entry22.' ::: this image is rotated.<br/>');
								}
							} */

							unlink($entry);
							print_r($entry.'this is a zip archive<br/>');
						}
						else
						{
							print_r($entry.'this is not a zip or rar archive<br/>');
						}
					}
				}

				closedir($handle);
			}
		}
	}
	
	$conn->close();
	
	function getFilesFromDir($dir) {
		print_r($dir.':::Here is a getFilesFromDir path<br/>');
	  $files = array();
	  if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if(is_dir($dir.'/'.$file)) {
					$dir2 = $dir.'/'.$file;
					$files[] = getFilesFromDir($dir2);
				}
				else {
				  $files[] = $dir.'/'.$file;
				}
			}
		}
		closedir($handle);
	  }

	  return array_flat($files);
	}

	function array_flat($array) {
		$tmp = array();
		foreach($array as $a) {
			if(is_array($a)) {
				$tmp = array_merge($tmp, array_flat($a));
			} else {
				$tmp[] = $a;
			}
		}
		return $tmp;
	}
?>