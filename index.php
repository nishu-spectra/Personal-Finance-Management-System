<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $res = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");
    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        header("Location: dashboard.php");
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html><head><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="form-container">
    <h2>Login</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Login">
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>
</body></html>