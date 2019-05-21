<?php

// 1. Check the validity of the encryption methods.
// 2. Check the database add function.
// 3. Write the checks for the character alphabets that we are getting from the user.
// 4. Finish the authentication.php file in terms of the database stuff.
// 5. Add the login functionality within in terms of the database stuff with login.php
// 6.

// Credentials for the PHP
require_once ("php_creds.php");
// The RC4 cipher
require_once "RC4.php";
// Simple Subsititution
require_once "SmpSubstitution";

session_start();

$datetime = new DateTime('2000-01-01');

// create the connection
function create_conn($hn, $un, $pw, $db)
{
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    return $conn;
}

// Function to add an entry into the database
function database_add($text, $option, $conn)
{
    // Don't forget to mysql_entities_fix_string before querying

}

// Function to sanitize SQL inputs
function sanitizeInputs($str){
    $str = stripslashes($str);
    $str = strip_tags($str);
    $str = htmlentities($str);
    return $str;
}

// Create the connection
#$conn = create_conn(DB_HOST,DB_USER,DB_PASSWORD, DB_DATABASE);

// Debugger for checking Post variables
function debug_post()
{
    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
}

$text = '';

//debug_post()


// HTML from this point on

echo <<< END

<center>

<h1>Sharan's Encryption and Decryption App</h1>

END;



# If the email and the password have been set already, then the user
if(!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {
    echo <<< END
    <div class="container" id=""login_form">
        Login, if you would like your data to be saved. <br><br>
        <form action="authentication.php" method="post">
            Email:<input name="email" type = "email" placeholder="email@email.com" cols="20" required> <br><br>
            Password: <input name="password" type = "password" placeholder="password" required> <br><br>
            <input type="submit" name="Login" value="Login" />
            <br><br>
        </form>
    </div>
END;
} else {
    echo <<< END
        You are logged in with {$_SESSION["email"]}
END;
}

echo <<<_END

<style>
html {
    min-height: 100%;
}
 
body {
    background: -webkit-linear-gradient(left, #5f2bb8, #dc32cc); 
    background: -o-linear-gradient(right, #5f2bb8, #dc32cc);
    background: -moz-linear-gradient(right, #5f2bb8, #dc32cc); 
    background: linear-gradient(to right, #5f2bb8, #dc32cc); 
    background-color: #7530b8; 
    color: ghostwhite;
}
</style> 

<form action="decrypt.php" method="post" enctype="multipart/form-data">
    
    <a align="right" href="signup.php" class="button">Click here to sign up for this awesome service </a> 
    <br><br>
    <a align="right" href="logout.php" class="button">Click here to Logout and clear the session </a>
    
    <br><br><br><br><br>
    Select Cipher: <select name="encypt_method">
        <option>Simple Substitution</option>
        <option>Double Transposition</option>
        <option>RC4</option>
    </select> <br>
    Select Type: <select name="option">
        <option>Encrypt</option>
        <option>Decrypt</option>
    </select>
    <br><br><br>
    
    <p>Enter Text here:</p>
    <textarea name="input_text" rows="10" cols="150"></textarea>
    <br>
    <input type="submit" name="submit_text" value="Submit Text" />
    
    <p>If you would like to use a custom cipher alphabet:</p>
    <textarea name="input_alphabet" rows="2" cols="100"></textarea>
    <br>
    <input type="submit" name="submit_alphabet" value="Submit Custom Alphabet" />
    
    <br><br><br><br>
    <p>Upload Text File Here:
    <input type="file" name='upload_file' id="upload_file">
    <input type="submit" name="submit_file" value="Submit File" />
    <br><br>
    
</form>

</center>
            
_END;

# The main encryption/decryption function
function main_crypt($input_text, $option, $encryption_method)
{
    global $SS;

    $text = '';

    $cipherAlphabetSS = 'yhkqgvxfoluapwmtzecjdbsnri';
    $cipherAlphabetDT = 'aaaa';

    // Check if there has been an input of an alphabet
    if(isset($_POST['submit_alphabet'])){

        if($_POST['invalid_alphabet']) {
            echo '<center>The input alphabet was wrong. Please check the length/characters.<center>'
        } else {
            $cipherAlphabetSS = $_POST['input_alphabet'];
            $cipherAlphabetDT = $_POST['input_alphabet'];
            $cipherAlphabetRC4 = $_POST['input_alphabet'];
        }
    }

    if($encryption_method == 'Simple Substitution') {

        // All the necessary checks for the input alphabet for SS
        if (strlen($cipherAlphabetSS) != strlen('yhkqgvxfoluapwmtzecjdbsnri')) {
            unset($_POST);
            $_POST['invalid_alphabet'] = 'The length of the Single cipher alphabet needs to be correct';
            header( "Location: decrypt.php" );
        }

        if ($option == 'Encrypt') {
            $text = SS_Encrypt($input_text, $cipherAlphabetSS);
        } else {
            $text = SS_Decrypt($input_text, $cipherAlphabetSS);
        }
    } else if($encryption_method == 'Double Transposition') {

        // All the necessary checks for the input alphabet for SS


        if ($option == 'Encrypt') {
            $text = DT_Encrypt($input_text, 'aaaa');
        } else {
            $text = DT_Decrypt($input_text, 'aaaa');
        }
    } else {

        // All the necessary checks for the input alphabet for SS


        if ($option == 'Encrypt') {
            $text = RC4_Encrypt($input_text, 'aaaa');
        } else {
            $text = RC4_Decrypt($input_text, 'aaaa');
        }
    }
    return $text;
}

# Checks when the submit text/submit file has been clicked on and then proceeds to encrypt/decrypt along with the send
# to the database.
if((isset($_POST['submit_text']) && isset($_POST['input_text'])) ||
    (isset($_POST['submit_file']) && isset($_FILES['upload_file'])))
{
    global $conn;

    $timestamp = $datetime->format('Y-m-d H:i:s');
    $cipher = ($_POST["encypt_method"]);

    # If it is written text
    if(isset($_POST['submit_text'])) {

        $text = main_crypt($_POST["input_text"], $_POST["option"], $_POST["encypt_method"]);
        unset($_POST['submit_text']);

        // Add it to the database
        database_add($conn, $cipher, $timestamp, $text);
    }

    # If it is a file that has been submitted
    if(isset($_POST['submit_file'])) {

        $filePath = realpath($_FILES["upload_file"]["tmp_name"]);
        if (mime_content_type($filePath) == "text/plain") {
            $text = main_crypt(file_get_contents($filePath), $_POST["option"], $_POST["encypt_method"]);
        } else {
            $message = "Only Text Files Accepted";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        unset($_POST['submit_file']);

        // Add it to the database
        database_add($conn, $cipher, $timestamp, $text);
    }

    # Some extra info for the user
    echo '<hr>';

    if($_POST["encypt_method"] == 'Simple Substitution') {
        echo '<center>The cipher alphabet used was yhkqgvxfoluapwmtzecjdbsnri<center> <br><br><br>';
    } else if($_POST["encypt_method"] == 'Double Transposition') {
        echo '<center>The cipher alphabet used was aaaa<center> <br><br><br>';
    } else {
        echo '<center>The cipher alphabet used was aaaa<center> <br><br><br>';
    }

    # Display for the encryption/decryption
    echo <<< END
    <center>
    <b>The {$_POST["option"]}ed text is: <br><br>
    $text </b>
    <center>
END;
}

?>
