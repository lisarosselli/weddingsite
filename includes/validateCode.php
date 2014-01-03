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

	$codeCheckResult 	= 1;
	$nameCheckResult 	= 0;
	$emailValResult 	= 1;
	$userIsListed 		= 1;
	$successfulReg 		= 1;

	$codeCheckResult = validateSTDCode($userCode, SAVETHEDATECODE);
	$nameCheckResult = checkName($fullname);


	function checkName( $value ) {
		return 0;
	}
	

	$rawJson = array("successfulReg" => $successfulReg, "codeCheckResult" => $codeCheckResult, "userIsListed" => $userIsListed, "firstname" => $firstname, "lastname" => $lastname);
	$cleanJson = json_encode($rawJson);

	echo $cleanJson;
?>