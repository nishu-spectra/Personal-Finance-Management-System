<?php include 'auth.php'; ?>
<!DOCTYPE html>
<html><head><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="dashboard">
    <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
    <form action="add_income.php" method="get">
        <input type="submit" value="Add Income">
    </form>
    <form action="add_expense.php" method="get">
        <input type="submit" value="Add Expense">
    </form>
    <form action="budget.php" method="get">
        <input type="submit" value="Manage Budget">
    </form>
    <form action="charts.php" method="get">
        <input type="submit" value="View Charts">
    </form>
    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</div>
</body></html>