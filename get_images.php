<?php
	require 'includes/functions.php';
	include 'includes/header.php';

	if ($_GET['download']) {
		// Zip File Name + Path Configuration
		$imagePath = "bebo_downloads/";
		$zipPath = "zips/";
		$salt = rand(9000000000,9999999999);
		$zip_name = $zipPath.$salt ."_bebo_pictures.zip";
		
		// Split out text input to seperate lines
		$urlArray = explode("\n", $_POST['lines']);
		$urlOutcome = checkURL($urlArray);
		
			if ($urlOutcome == FALSE) {
				// Pull images from POST into Array then generate zip file
				$new_pics = savePics($urlArray, $imagePath);
				$result = create_zip($new_pics,$zip_name);
				
				// Display success / fail message
				if ($result) {
					echo "<h1>Success!</h1>
					<div class=\"descr\">Your file is ready to be downloaded!</div>
					<p>Go <a href=\"download_images.php?filename=" . $salt . "_bebo_pictures.zip\">here</a> to retrieve it.<br /><br /><b>Note:</b> Once you have downloaded your file, it will be removed from our server immediately for security reasons. If you need to download it again please repeat the process.</p>";
				}	else {
					echo "Hmm, something didn't work quite right! Please report it to <a mailto:\"johnathan@weleasewodewick.com\">johnathan@weleasewodewick.com</a>";
				}
				
				// Tidy up pictures
				deletePics($new_pics);
			} else {
				echo "<h1>Error! :o(</h1>
					    <div class=\"descr\">Problem with your URLs</div>
					    <p>Oops ... one of your URL's doesn't look like a bebo.com address. Try copying and pasting from the Bebo App again. Or, if you think this is an error, email what you pasted to johnathan@weleasewodewick.com";
			}	
		} else {
			// display form to kick off the process
			echo "<h1>Process your images</h1>
				<div class=\"descr\">Just paste the lines of URL's into the box below, and click submit!</div>
					<p><b>Note:</b> This script will connect to Bebo's servers and download all the images that you specify - if you put in dozens/hundreds of pictures, expect it to take a few minutes to complete. If the page/script gives you a timeout error, consider doing half, or even quarter of your list at a time</p>
				<form action=\"get_images.php?download=yes\" method=\"post\">
				<textarea cols=\"65\" rows=\"8\" name=\"lines\"></textarea><br />
				<input type=\"submit\">
			";
		}
	
	include 'includes/footer.php';
?>