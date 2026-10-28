<?php include 'auth.php'; include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $notes = $_POST['notes'];
    $user_id = $_SESSION['user_id'];
    $conn->query("INSERT INTO expenses (user_id, category, amount, date, notes) VALUES ($user_id, '$category', $amount, '$date', '$notes')");
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="form-container">
    <h2>Add Expense</h2>
    <form method="post">
        <input type="text" name="category" placeholder="Category" required><br>
        <input type="number" name="amount" step="0.01" placeholder="Amount" required><br>
        <input type="date" name="date" required><br>
        <textarea name="notes" placeholder="Notes (optional)"></textarea><br>
        <input type="submit" value="Add">
    </form>
</div></body></html>