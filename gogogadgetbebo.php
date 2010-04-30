<?php
	require 'includes/bebo_api.php';
	require 'includes/functions.php';
	
	if ($_GET['stepone']) {
		// Define Keys
		$api_key = "V5WsJimqOlDzbvTmMQKpuoNWEkZboQYyxXMu";
		$api_secret = "AkCOPaCW97r74qUVtfsz036ueWpHk5Ev5utz";
  	// instantiate api
		$bebo = new Bebo($api_key, $api_secret);
		// Require that user authorise app on their profile -> punts them to Bebo website
		$userID = $bebo->require_add();
		// Main function which generates page on Bebo with a full list of their image URL's
		displayPics($bebo); 
	} else {
		header("Location: index.php");
	}
?>