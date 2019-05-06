<?php

// Function to check the validity of a username
function checkUser($username) {
    $VALID = False;
    $allowed = array("-", "_"); // you can add here more value, you want to allow.
    if(ctype_alnum(str_replace($allowed, '', $username ))) {
        $VALID = True;
    }
    return $VALID;
}

// Function to check the validity of a password
function oWasp($pass)
{
    $VALID = False;
    if (preg_match('/^\w{5,}$/', $pass)) {
        $VALID = True;
    }
    return $VALID;
}

?>