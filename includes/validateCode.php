<?php

	/**
	 *	validateCode.php
	 *
	 */

	require("config.php");

	//$saveTheDateCode = "ballatore";

	$userCode 	= $_GET["userCode"];
	$fullname 	= $_GET["userName"];
	$email 		= $_GET["userEmail"];
	$entree 	= $_GET["userEntree"];

	$codeCheckResult 	= 0;
	$nameCheckResult 	= 0;
	$emailValResult 	= 0;
	$userIsListed 		= 0;
	$successfulReg 		= 0;

	$codeCheckResult = validateSTDCode($userCode, SAVETHEDATECODE);
	$nameCheckResult = checkName($fullname);


	function checkName( $value ) {
		return 0;
	}
	

	$rawJson = array("codeCheckResult" => $codeCheckResult, "userName" => $fullname);
	$cleanJson = json_encode($rawJson);

	echo $cleanJson;
?>