<?php
$conn = new mysqli("localhost", "root", "", "personal_finance");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
?>
