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

	if ($nameCheckResult && $codeCheckResult) {
		
	}
?>