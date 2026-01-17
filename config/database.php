<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Default XAMPP password
$db = 'managemensekolah'; // Corrected based on user input

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>