<?php
include "db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html><head><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="form-container">
    <h2>Register</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="index.php">Login here</a></p>
</div>
</body></html>