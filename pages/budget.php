<?php
include '../includes/db_connect.php';

$budget_query = "SELECT c.category_name, c.budget_amount, 
                 COALESCE(SUM(e.amount), 0) as actual_spent,
                 (c.budget_amount - COALESCE(SUM(e.amount), 0)) as difference
                 FROM expense_categories c
                 LEFT JOIN expenses e ON c.expense_category_id = e.expense_category_id
                 GROUP BY c.expense_category_id, c.category_name, c.budget_amount";
$budget_result = mysqli_query($conn, $budget_query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Budget Monitoring</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>💰 Family Budget System</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Dashboard</a></li>
            <li><a href="income.php">Income</a></li>
            <li><a href="expenses.php">Expenses</a></li>
            <li><a href="budget.php">Budget</a></li>
            <li><a href="savings.php">Savings Goals</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Budget vs Actual Spending</h2>
            <table>
                <tr>
                    <th>Category</th>
                    <th>Budget Amount</th>
                    <th>Actual Spent</th>
                    <th>Remaining</th>
                    <th>Status</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($budget_result)): ?>
                <tr>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>$<?php echo number_format($row['budget_amount'], 2); ?></td>
                    <td>$<?php echo number_format($row['actual_spent'], 2); ?></td>
                    <td>$<?php echo number_format($row['difference'], 2); ?></td>
                    <td>
                        <?php if($row['difference'] < 0): ?>
                            <span class="badge badge-danger">Over Budget</span>
                        <?php elseif($row['difference'] < ($row['budget_amount'] * 0.2)): ?>
                            <span class="badge badge-warning">Near Limit</span>
                        <?php else: ?>
                            <span class="badge badge-success">On Track</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
