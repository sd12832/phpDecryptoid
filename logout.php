<?php
//check session details
session_start();
// logout
// function to destroy current session and log out the user
function destroy_session_and_data()
{
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
}

destroy_session_and_data();
// provide options to login again and signup
// signup option- if someone got the link and
echo "<p>You have been logged out!</p>";
echo "<p>Click here to go back to the <a href='decrypt.php'>main page</a></p>";
echo "<p>Click here to <a href='signuppage.php'>sign up</a></p>";
?>