<?php

    /**
     * functions.php
     *
     */
    
    require_once("constants.php");

    function validateSTDCode( $value, $code ) {
    	if (strcmp(strtolower($value), $code) == 0) {
    		return 1;
    	}

    	return 0;
    }

    function extractFirstName( $value ) {

    }

    function extractLastName( $value ) {
        
    }

    function validateLastName( $value ) {

    }
?>