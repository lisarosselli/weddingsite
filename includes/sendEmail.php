<?php

	require("config.php");

	$firstname 	= $_GET["userName"];
	$email 		= $_GET["userEmail"];

	sendEmailConfirmation($firstname, $email);
?>