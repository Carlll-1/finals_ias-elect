<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "facelock_db"; // Palitan mo 'to ng actual name ng database mo

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>