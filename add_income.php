<?php include 'auth.php'; include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $source = $_POST['source'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $user_id = $_SESSION['user_id'];
    $conn->query("INSERT INTO income (user_id, source, amount, date) VALUES ($user_id, '$source', $amount, '$date')");
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="form-container">
    <h2>Add Income</h2>
    <form method="post">
        <input type="text" name="source" placeholder="Source" required><br>
        <input type="number" name="amount" step="0.01" placeholder="Amount" required><br>
        <input type="date" name="date" required><br>
        <input type="submit" value="Add">
    </form>
</div></body></html>
