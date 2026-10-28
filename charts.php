<?php include 'auth.php'; include 'db.php';
$user_id = $_SESSION['user_id'];
$incomeData = $conn->query("SELECT date, amount FROM income WHERE user_id = $user_id");
$expenseData = $conn->query("SELECT date, amount, category FROM expenses WHERE user_id = $user_id");

$incomePoints = [];
$expensePoints = [];
$categoryTotals = [];
while ($row = $incomeData->fetch_assoc()) $incomePoints[] = $row;
while ($row = $expenseData->fetch_assoc()) {
    $expensePoints[] = $row;
    $cat = $row['category'] ?? 'Uncategorized';
    $categoryTotals[$cat] = ($categoryTotals[$cat] ?? 0) + $row['amount'];
}

$totalIncome = array_sum(array_column($incomePoints, 'amount'));
$totalExpense = array_sum(array_column($expensePoints, 'amount'));
$balance = $totalIncome - $totalExpense;
$savingsRate = ($totalIncome > 0) ? round(($balance / $totalIncome) * 100, 2) : 0;

$recentExpenses = array_slice(array_column($expensePoints, 'amount'), -3);
$forecast = count($recentExpenses) ? round(array_sum($recentExpenses) / count($recentExpenses)) : 0;

function getSuggestion($balance, $savingsRate, $forecast) {
    if ($balance < 0) return "You're overspending! Reduce expenses or increase income.";
    if ($savingsRate < 10) return "Your savings rate is too low. Set a savings goal.";
    if ($forecast > $balance) return "Forecasted expenses exceed your balance. Adjust your budget.";
    if ($savingsRate > 30 && $balance > 0) return "Great savings discipline! Consider investing your surplus.";
    return "You're managing well. Keep reviewing your budget monthly.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/chart-style.css">
</head>
<body>
<div class="charts-container">
    <h2>Finance Overview</h2>
    <?php if (count($incomePoints) === 0 && count($expensePoints) === 0): ?>
        <p>No data available to display charts. Please add some income and expense entries.</p>
    <?php else: ?>
    <div class="charts-grid">
        <div class="summary-box">
            <h3>Summary</h3>
            <p><strong>Total Income:</strong> Rs. <?= $totalIncome ?></p>
            <p><strong>Total Expenses:</strong> Rs. <?= $totalExpense ?></p>
            <p><strong>Balance:</strong> Rs. <?= $balance ?></p>
            <p><strong>Savings Rate:</strong> <?= $savingsRate ?>%</p>
            <p><strong>Forecast Next Month Expense:</strong> Rs. <?= $forecast ?></p>

            <h3>Suggestions</h3>
            <p><?= getSuggestion($balance, $savingsRate, $forecast) ?></p>
        </div>
        <div class="chart-box">
            <h3>Income vs Expenses</h3>
            <canvas id="lineChart"></canvas>
        </div>
        <div class="chart-box">
            <h3>Expense Distribution</h3>
            <canvas id="pieChart"></canvas>
        </div>
    </div>
    <script>
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($incomePoints, 'date')) ?>,
                datasets: [
                    {
                        label: 'Income',
                        data: <?= json_encode(array_column($incomePoints, 'amount')) ?>,
                        borderColor: 'green',
                        fill: false
                    },
                    {
                        label: 'Expenses',
                        data: <?= json_encode(array_column($expensePoints, 'amount')) ?>,
                        borderColor: 'red',
                        fill: false
                    }
                ]
            }
        });

        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?= json_encode(array_keys($categoryTotals)) ?>,
                datasets: [{
                    label: 'Expenses by Category',
                    data: <?= json_encode(array_values($categoryTotals)) ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ]
                }]
            }
        });
    </script>
    <?php endif; ?>
</div>
</body>
</html>
