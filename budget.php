<?php include 'auth.php'; include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $limit = $_POST['limit'];
    $period = $_POST['period'];
    $user_id = $_SESSION['user_id'];
    $conn->query("INSERT INTO budgets (user_id, category, limit_amount, period) VALUES ($user_id, '$category', $limit, '$period')");
}
$res = $conn->query("SELECT * FROM budgets WHERE user_id = " . $_SESSION['user_id']);
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="form-container">
    <h2>Manage Budgets</h2>
    <form method="post">
        <input type="text" name="category" placeholder="Category" required><br>
        <input type="number" name="limit" step="0.01" placeholder="Budget Limit" required><br>
        <select name="period">
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select><br>
        <input type="submit" value="Save">
    </form>
    <h3>Your Budgets</h3>
    <ul>
        <?php while($b = $res->fetch_assoc()) {
            echo "<li>{$b['category']} - Rs {$b['limit_amount']} ({$b['period']})</li>";
        } ?>
    </ul>
</div></body></html>
