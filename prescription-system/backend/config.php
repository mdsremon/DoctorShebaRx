<?php
$host = "localhost";
$user = "root"; // Default MySQL user
$pass = ""; // Default no password
$dbname = "prescriptions_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
