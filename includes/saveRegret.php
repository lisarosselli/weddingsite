<?php

	/**
	 * 	saveRegret.php
	 *
	 */

	require("config.php");

	$userCode 	= $_GET["userCode"];
	$fullname 	= $_GET["userName"];
	$email 		= $_GET["userEmail"];
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

	if ($nameCheckResult) {
		$firstname = extractFirstName($fullname);
		$lastname = extractLastName($fullname);
	}

	if ($nameCheckResult && $codeCheckResult) {
		$successfulReg = regretThis($firstname, $lastname, $email);	
	}

	if ($successfulReg == 0) {
		$isPrevReg = previouslyRegretted($firstname, $lastname, $email);
	}

	if ($successfulReg == 1) {
			$responseString = "<div class='container small'><p>Ok, ".ucfirst($firstname).". We understand you are not attending.</p></div>";
	} else if ($isPrevReg == 1) {
		$responseString = "<div class='container small'><p>Deja vu all over again ".ucfirst($firstname).". You've already told us you're not attending.</p></div>";
	} else if ($codeCheckResult == 0) {
		$responseString = "<div class='container small'><p>".ucfirst($firstname).", either you didn't type in the code correctly or you have not received a Save The Date card. Refresh the page for another chance or contact Eileen and Lisa to regret.</p></div>";
	} else {
		$responseString = "<div class='container small'><p>".ucfirst($firstname).", sometimes technology disappoints us. Something went awry in the RSVP process. Contact Eileen and Lisa to regret your attendance.</p></div>";
	}

	$rawJson = array("successfulReg" => $successfulReg, 
					"codeCheckResult" => $codeCheckResult, 
					"isPrevReg" => $isPrevReg,
					"userName" => $fullname, 
					"firstname" => $firstname, 
					"lastname" => $lastname,
					"responseString" => $responseString
					);

	$cleanJson = json_encode($rawJson);

	echo $cleanJson;
?>