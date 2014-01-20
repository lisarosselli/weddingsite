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

    function registerUser( $first, $last, $email, $protein) {
        $name = ucfirst($first)." ".ucfirst($last);
        $result = query("INSERT INTO rsvp (name, email, protein) values (?, ?, ?);", $name, $email, $protein);
        if ($result !== false) {
            return 1;
        }
        return 0;
    }

    function checkPrevReg( $first, $last, $email ) {
        $name = ucfirst($first)." ".ucfirst($last);
        $rows = query("SELECT * FROM rsvp WHERE name=? AND email=?;", $name, $email);
        if (count($rows) == 1) {
            return 1;
        }
        return 0;
    }

    function regretThis( $first, $last, $email ) {
        $name = ucfirst($first)." ".ucfirst($last);
        $result = query("INSERT INTO regrets (name, email) values(?, ?);", $name, $email);
        if ($result !== false) {
            return 1;
        }
        return 0;
    }

    function previouslyRegretted( $first, $last, $email) {
        $name = ucfirst($first)." ".ucfirst($last);
        $rows = query("SELECT * FROM regrets WHERE name=? AND email=?;", $name, $email);
        if (count($rows) == 1) {
            return 1;
        }
        return 0;
    }

    function sendEmailConfirmation( $firstname, $email ) {
        $to = $email;
        $subject = "RSVP Confirmation: Eileen + Lisa's Wedding";
        
        $body = "<table width='600px' style='cell-padding:20px;'>
                <tr>
                    <td style='background-color:#F2ECEB; height:150px'>
                        <h1 style='font-family:Helvetica,Helvetica Neue,sans-serif; color:#FCF6F5; font-size:5em; font-weight:100;'>RSVP</h1>
                    </td>
                </tr>
                <tr>
                    <td style='padding:25px; font-family:Georgia,New York,serif;'>
                        <p>Hello ".$firstname.",</p>
                        <p >We can't wait to see you on our wedding day! Sunday, August 3rd, 2014 will prove to be a big day for us all. Ceremony and reception will take place upstairs in the Brewer's Lounge at Revolution Brewing.</p>
                        <p>
                        Revolution Brewing is located at 2323 N. Milwaukee Ave, Chicago, Illinois. It's right off the California Blue Line stop or can be accessed off the I-90/94 Fullerton exit. Happily, street parking is not metered on Sundays in the area.
                        </p>

                        <p>Feel free to check back at <a href='http://eandlwedding.lisarosselli.com/' target='_blank'>the website</a> for updates.

                        <p>Thank you for your response. We can't wait to take this huge step in our lives and for you to be a part of it!</p>
                        <p>Cheers!</p>
                        <p>&nbsp;&nbsp;&nbsp;-- Eileen &amp; Lisa</p>
                    </td>
                </tr>
                <tr>
                    <td style='background-color:#F2ECEB; height:30px'></td>
                </tr>
            </table>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $headers .= "From: <studio1809@gmail.com>" . "\r\n";

        mail($to, $subject, $body, $headers);
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