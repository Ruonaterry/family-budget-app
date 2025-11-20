<?php
include 'includes/db_connect.php';

$income_query = "SELECT SUM(amount) as total FROM income";
$income_result = mysqli_query($conn, $income_query);
$income_row = mysqli_fetch_assoc($income_result);
$total_income = $income_row['total'] ? $income_row['total'] : 0;

$expense_query = "SELECT SUM(amount) as total FROM expenses";
$expense_result = mysqli_query($conn, $expense_query);
$expense_row = mysqli_fetch_assoc($expense_result);
$total_expenses = $expense_row['total'] ? $expense_row['total'] : 0;

$balance = $total_income - $total_expenses;

$recent_income = mysqli_query($conn, "SELECT i.*, m.member_name, c.category_name 
                                       FROM income i 
                                       LEFT JOIN family_members m ON i.member_id = m.member_id 
                                       LEFT JOIN income_categories c ON i.income_category_id = c.income_category_id 
                                       ORDER BY i.income_date DESC LIMIT 5");

$recent_expenses = mysqli_query($conn, "SELECT e.*, m.member_name, c.category_name 
                                         FROM expenses e 
                                         LEFT JOIN family_members m ON e.member_id = m.member_id 
                                         LEFT JOIN expense_categories c ON e.expense_category_id = c.expense_category_id 
                                         ORDER BY e.expense_date DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Family Budget - Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>💰 Family Budget System</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="pages/income.php">Income</a></li>
            <li><a href="pages/expenses.php">Expenses</a></li>
            <li><a href="pages/budget.php">Budget</a></li>
            <li><a href="pages/savings.php">Savings Goals</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="stats">
            <div class="stat-box income">
                <h3>Total Income</h3>
                <div class="amount">$<?php echo number_format($total_income, 2); ?></div>
            </div>
            <div class="stat-box expense">
                <h3>Total Expenses</h3>
                <div class="amount">$<?php echo number_format($total_expenses, 2); ?></div>
            </div>
            <div class="stat-box balance">
                <h3>Balance</h3>
                <div class="amount">$<?php echo number_format($balance, 2); ?></div>
            </div>
        </div>

        <div class="card">
            <h2>Recent Income</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($recent_income)): ?>
                <tr>
                    <td><?php echo $row['income_date']; ?></td>
                    <td><?php echo $row['member_name']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>$<?php echo number_format($row['amount'], 2); ?></td>
                    <td><?php echo $row['description']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="card">
            <h2>Recent Expenses</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($recent_expenses)): ?>
                <tr>
                    <td><?php echo $row['expense_date']; ?></td>
                    <td><?php echo $row['member_name']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>$<?php echo number_format($row['amount'], 2); ?></td>
                    <td><?php echo $row['payment_method']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
