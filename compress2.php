<?php

	$foldername2 = 'public/images/kinetisense/';
	if ($handle2 = opendir($foldername2)) {

		while (false !== ($entry2 = readdir($handle2))) {
			
			$foldername = 'public/images/kinetisense/'.$entry2."/";
			
			if ($handle = opendir($foldername)) {

				while (false !== ($entry = readdir($handle))) {

					if ($entry != ".") {

						if (!strpos($entry, '.'))
						{
							$foldername3 = $foldername.$entry;
							if ($handle3 = opendir($foldername3)) {
								while (false !== ($entry3 = readdir($handle3))) {
									$foldername4 = $foldername3.'/'.$entry3."/";
									if ($handle4 = opendir($foldername4)) {
										while (false !== ($entry5 = readdir($handle4))) {
											if ($entry5 != "." && $entry5 != "..") {
												if (strpos($entry5, '.jpg') !== false && strpos($entry5, 'frame_')!== false )
												{
													$entry22 = $foldername4.$entry5;
													$imageResource = imagecreatefromjpeg($entry22);
													$image = imagerotate($imageResource, 180, 0);
													imagejpeg($image, $entry22, 90);
													print_r($entry22.' ::: this image is rotated.<br/>');
												}
											}
										}
									}
								}
							}
							/*$fname =  str_replace(".zip","",$entry);
							$zip = new ZipArchive();
							$zip->open($entry, ZipArchive::CREATE);
							$zip->extractTo($fname.'/');
							$zip->close();
							unlink($entry);*/
						}
						else
						{
							$x= 1;
						}
					}
				}

				closedir($handle);
			}
		}
	}
?>