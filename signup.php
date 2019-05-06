<?php
echo <<<_END
        <html>
            <body>
            <center>
            <h1> Sign up for Sharan's Encryption service </h1>
                <form method = "post" action ="authentication.php" enctype='multipart/form-data'>
                    <p>
                    Username <input type = "text" name = "username" text = null>
                    </p>
                    <p>
                    Password <input type = "password" name = "password" text = null>
                    </p>
                    <p>
                    Email Address <input type = "text" name = "email" text = null>
                    </p>
                    <input type = "hidden" value = "signup" name="sign" >
                    <input type = "submit">
                </form>
                <center>
            </body>
        </html>

_END;

?>