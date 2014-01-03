<?php

    /**
     *  functions.php
     *
     */
    
    require_once("constants.php");

    function sanitizeString( $value ) {
        $newStr = trim($value);
        $newStr = strip_tags($newStr);
        $newStr = strtolower($newStr);
        $newStr = htmlspecialchars($newStr);
        $newStr = addslashes($newStr);
        return $newStr;
    }

    function validateSTDCode( $value, $code ) {
    	if (strcmp(strtolower($value), $code) == 0) {
    		return 1;
    	}
    	return 0;
    }

    function extractFirstName( $value ) {
        $arr = explode(" ", $value);
        return $arr[0];
    }

    function extractLastName( $value ) {
        $arr = explode(" ", $value);
        return $arr[1];
    }

    function validateName( $value ) {
        // Looking for a name with a firstname, one space, and
        // last name or hyphenated lastname.
        $numOfSpaces = substr_count($value, " ");
        if ($numOfSpaces != 1) {
            return 0;
        }

        // Ensure user has only entered letters, space(s), and hypen
        $pattern = '/^[a-z A-Z-]+$/';
        $matchesPattern = preg_match($pattern, $value);
        if ($matchesPattern != 1) {
            return 0;
        } 

        return 1;
    }

    function validateLastName( $value ) {
        $rows = query("SELECT * FROM lastnames WHERE lastname = ?", $value);
        if (count($rows) == 1) {
            return 1;
        } 
        return 0;
    }

    function registerUser( $first, $last, $protein) {
        //$rows = query("INSERT INTO ")
    }

    function createResponseString( $successFlag ) {
        // 0 - db error/name error
        // 1 - success
        // 2 - code not valid
        // 3 - user not listed
    }

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

?>