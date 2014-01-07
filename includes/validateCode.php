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
	$isPrevReg			= 0;
	$responseString		= null;

	$codeCheckResult 	= validateSTDCode($userCode, SAVETHEDATECODE);
	$fullname			= sanitizeString($fullname);
	$nameCheckResult 	= validateName($fullname);
	//$entree				= sanitizeString($entree);

	if ($nameCheckResult && is_numeric($entree)) {

		// Split into first/last names if fullname is formatted correctly
		$firstname = extractFirstName($fullname);
		$lastname = extractLastName($fullname);

		// Check to see if last name is in the database
		if ($lastname) {
			$userIsListed = validateLastName($lastname);
		}

		// If user is in db and code is good, register them
		if ($userIsListed && $codeCheckResult) {
			$successfulReg = registerUser($firstname, $lastname, $email, $entree);
		}

		if ($successfulReg == 0) {
			$isPrevReg = checkPrevReg($firstname, $lastname, $email);
		}

		if ($successfulReg == 1) {
			$responseString = "<div class='container small'><p>Ok, ".ucfirst($firstname)."! We've got you on our list! We can't wait to see you there!</p></div>";
		} else if ($isPrevReg == 1) {
			$responseString = "<div class='container small'><p>You've already RSVP'd, ".ucfirst($firstname)."! Thanks for your enthusiasm.</p></div>";
		} else if ($userIsListed == 0) {
			$responseString = "<div class='container small'><p>".ucfirst($firstname).", we don't have you on our list of projected attendees. Please contact Eileen and Lisa to RSVP.</p></div>";
		} else if ($codeCheckResult == 0) {
			$responseString = "<div class='container small'><p>".ucfirst($firstname).", either you didn't type in the code correctly or you have not received a Save The Date card. Refresh the page for another chance or contact Eileen and Lisa to RSVP.</p></div>";
		} else {
			$responseString = "<div class='container small'><p>".ucfirst($firstname).", sometimes technology disappoints us. Something went awry in the RSVP process. Contact Eileen and Lisa to RSVP.</p></div>";
		}
	} 

	$rawJson = array("successfulReg" => $successfulReg, 
					"codeCheckResult" => $codeCheckResult, 
					"userIsListed" => $userIsListed, 
					"isPrevReg" => $isPrevReg,
					"userName" => $fullname, 
					"firstname" => $firstname, 
					"lastname" => $lastname,
					"entree" => $entree,
					"responseString" => $responseString
					);

	$cleanJson = json_encode($rawJson);

	echo $cleanJson;
?>