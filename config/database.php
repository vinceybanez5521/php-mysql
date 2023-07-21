<?php
include_once "constants.php";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

if(!$conn) {
    die("Connection Failed! " . mysqli_connect_error());
}

// echo "Connection Successful!";