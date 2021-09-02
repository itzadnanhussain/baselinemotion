<?php
	$servername = "localhost";
	$username = "root";
	$password = "NVnUtsn8spZBmkBp";
	$dbname = "portalbaseline";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	function getFilesFromDir($dir) {

		$files = array();
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if(is_dir($dir.'/'.$file)) {
						$dir2 = $dir.'/'.$file;
						$files[] = getFilesFromDir($dir2);
					} else {
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
	
	// Usage
	$dir = 'public/images/kinetisense';
	$sql = "SELECT id, patient_id, zip_video FROM cronimages limit 0,2";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$id = $row["id"];
			$dir = 'public/images/kinetisense/'.$row["patient_id"].$row["zip_video"];
			$foo = getFilesFromDir($dir);

			$sql2 = "DELETE FROM cronimages WHERE id=".$id;

			if ($conn->query($sql2) === TRUE) {
			  echo "Record deleted successfully";
			}
			
			echo '<pre>';
			print_r($foo);
			foreach($foo as $img){
				if (strpos($img, '.jpg') !== false && ( strpos($img, 'frame_')!== false ||  strpos($img, 'compressed_')!== false))
				{
					$entry22 = $img;
					$imageResource = imagecreatefromjpeg($entry22);
					$image = imagerotate($imageResource, 180, 0);
					imagejpeg($image, $entry22, 90);
					print_r($entry22.' ::: this image is rotated.<br/>');
				}
			}
			
			
		}
	}
	$conn->close();
	
?>