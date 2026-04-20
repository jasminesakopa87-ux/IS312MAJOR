<?php
$host = "HOST";
$username = "USERNAME";
$password = "PASSWORD";
$database = "DATABASE_NAME";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>