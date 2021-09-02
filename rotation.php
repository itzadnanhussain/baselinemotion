<?php
	
	//$dir = 'kinetisense/';

function getFilesFromDir($dir) {

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

// Usage
$dir = 'public/images/kinetisense';
if(isset($_REQUEST['id']) && $_REQUEST['id']!="")
	$dir = 'public/images/kinetisense/'.$_REQUEST['id'];
	
$foo = getFilesFromDir($dir);

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
?>