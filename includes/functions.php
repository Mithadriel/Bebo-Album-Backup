<?php
	function displayPics($bebo) {
		// Set userid
      $userID = $bebo->user;
        
      // Display instructions
      echo "Hello <sn:name uid='$userID' useyou='false' />!<br/><br />If everything has gone as planned, you'll find below a list of URL's - these are the links to all of your images!<br /><br />";
        
      // Pull album list into array, then pull out each picture from every album - finally display a list of URL's for copy and pastage.
      $userAlbums = $bebo->photos_getAlbums($userID, null);
        
      echo "<b>Start copying from the next line ...</b><br />";  
        foreach ($userAlbums as $key => $row) {
        	$userPhotos = $bebo->photos_get(null, $row['aid'], null);
        	$photoURLS = array();        	
        	foreach ($userPhotos as $key => $row) {
        		// src_big can be altered, there are a few different options available from Bebo - print_r the $userPhotos array to see them
        		$photoURLS[] .= $row['src_big'];
        	}
        	$i = 0;
						foreach ($photoURLS as $key => $row) {
							echo $photoURLS[$i] . "<br />";
							$i++;
						}
        }
        
      echo "<b>Stop copying on the line above ...</b><br /><br /><b>Done?</b> <br /><br />Thank you for using our app to generate a list of your images. If you wish to download these images quickly and easily, use this page: <br /><br /><a href=\"http://www.weleasewodewick.com/bebo/get_images.php\">Let's go get your images!</a>";
	}
	
	function savePics($urlArray, $path) {
		$i = 0;
		foreach ($urlArray as $key => $url) {
			// gives a 99.9% chance for the image name to be unique, helps avoid but doesn't eliminate clashes if it's being processed a lot
			$salt = rand(9000000000,9999999999);
			// Build paths and clean URL's
			$img = $path.$i.$salt.".jpg";
			$clean_url = trim($url);
			// Get and Set
			$file = file_get_contents($clean_url);
			file_put_contents($img, $file);
			// Append to array to allow eventual deletion of new files
			$new_files[] .= $img;
			$i++;
		}
		return $new_files;
	}
	
	function create_zip($files = array(),$destination = 'zips/',$overwrite = false) {
		//if the zip file already exists and overwrite is false, return false
		if(file_exists($destination) && !$overwrite) { return false; }
		//vars
		$valid_files = array();
		//if files were passed in...
		if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
				if(file_exists($file)) {
					$valid_files[] = $file;
				}
			}
		}
		//if we have good files...
		if(count($valid_files)) {
			//create the archive
			$zip = new ZipArchive();
			if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
		//add the files
			foreach($valid_files as $file) {
				$zip->addFile($file,$file);
			}
		//debug
			echo '<p>Your download contains ',$zip->numFiles,' images.'; //' with a status of ',$zip->status;
			
		//close the zip -- done!
			$zip->close();
			
		//check to make sure the file exists
			return file_exists($destination);
		}
		else
		{
			return false;
		}
	}

	function deletePics($array) {
		$i = 0;
		foreach ($array as $key => $url) {
			unlink($url);
			$i++;
		}
	}
	
	function checkURL($array) {
		$pattern = "#^https?://([a-z0-9-]+\.)*bebo\.com(/.*)?$#";
		foreach ( $array as $url ) {
  		if ( preg_match( $pattern, $url ) ) {
    		$result[] .= "success";
  		} else {
  			$result[] .= "error";
  		}
		}
		
		foreach ($result as $key => $value) {
			if ($value == "success") {
				
			} elseif ($value == "error") {
				$final_result = "error";
			}
		}
		return $final_result;
	}
?>