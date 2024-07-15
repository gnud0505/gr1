<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "05052003";
$dbName = "gr1";
$conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName)
        or die ('Could not connect to the database server' . mysqli_connect_error());
if (!$conn) {
    die("Something went wrong;");
}

?>