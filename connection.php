<?php

/*
 * add database credentials
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '1997');
define('DB_NAME', 'resumebuilder');


function connect() {

    // Creating a connection using defined constants
    $connect = mysqli_connect('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME');

    if (mysqli_connect_errno($connect)) {
        // If connection failed, display an error message and terminate
        die("Failed to connect to the DB: " . mysqli_connect_error());
    }

    // Set character set for the connection to utf8
    mysqli_set_charset($connect, "utf8");

    // Return the established connection
    return $connect;
}

// Call the connect function and store the connection in $conn variable
$conn = connect();


?>
