<?php

	require("config.php");

	$firstname 	= $_GET["firstname"];
	$email 		= $_GET["email"];

	$success = sendEmailConfirmation($firstname, $email);

	$rawJson = array("emailSuccess" => $success);

	$cleanJson = json_encode($rawJson);

	echo $cleanJson;
?>