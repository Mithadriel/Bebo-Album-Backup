<?php
	if ($_GET['filename']) {
		$path = "http://www.weleasewodewick.com/bebo/zips/";
		$server_path = "zips/";
		$server_filename = $server_path.$_GET['filename'];
		$filename = $path.$_GET['filename'];
		header('Content-type: application/zip');
		header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
		readfile($filename);
		
		unlink($server_filename);
		
	} else {
		echo "bad person, go away!";
	}
?>