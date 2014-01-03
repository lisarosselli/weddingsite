<?php

	/**
	 *	validateCode.php
	 *
	 */

	require("config.php");

	$userCode 	= $_GET["userCode"];
	$fullname 	= $_GET["userName"];
	$email 		= $_GET["userEmail"];
	$entree 	= $_GET["userEntree"];
	$firstname	= null;
	$lastname 	= null;

	$codeCheckResult 	= 0;
	$nameCheckResult 	= 0;
	$emailValResult 	= 0;
	$userIsListed 		= 0;
	$successfulReg 		= 0;
	$responseString		= null;

	$codeCheckResult 	= validateSTDCode($userCode, SAVETHEDATECODE);
	$fullname			= sanitizeString($fullname);
	$nameCheckResult 	= validateName($fullname);
	$entree				= sanitizeString($entree);


	// Split into first/last names if fullname is formatted correctly
	if ($nameCheckResult == 1) {
		$firstname = extractFirstName($fullname);
		$lastname = extractLastName($fullname);
	}

	// Check to see if last name is in the database
	if ($lastname) {
		$userIsListed = validateLastName($lastname);
	}

	// If user is in db and code is good, register them
	if ($userIsListed && $codeCheckResult) {
		$successfulReg = registerUser($firstname, $lastname, $entree);
	}

	$rawJson = array("successfulReg" => $successfulReg, 
					"codeCheckResult" => $codeCheckResult, 
					"userIsListed" => $userIsListed, 
					"userName" => $fullname, 
					"firstname" => $firstname, 
					"lastname" => $lastname
					);

	$cleanJson = json_encode($rawJson);

	echo $cleanJson;
?>