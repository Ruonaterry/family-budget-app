<?php
include '../includes/db_connect.php';

$goals = mysqli_query($conn, "SELECT * FROM savings_goals ORDER BY start_date DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Savings Goals</title>
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
            <h2>Savings Goals</h2>
            <table>
                <tr>
                    <th>Goal Name</th>
                    <th>Target Amount</th>
                    <th>Current Amount</th>
                    <th>Progress</th>
                    <th>Start Date</th>
                    <th>Target Date</th>
                    <th>Status</th>
                </tr>
                <?php while($goal = mysqli_fetch_assoc($goals)): 
                    $progress = ($goal['current_amount'] / $goal['target_amount']) * 100;
                ?>
                <tr>
                    <td><?php echo $goal['goal_name']; ?></td>
                    <td>$<?php echo number_format($goal['target_amount'], 2); ?></td>
                    <td>$<?php echo number_format($goal['current_amount'], 2); ?></td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo $progress; ?>%"></div>
                        </div>
                        <?php echo round($progress, 1); ?>%
                    </td>
                    <td><?php echo $goal['start_date']; ?></td>
                    <td><?php echo $goal['target_date']; ?></td>
                    <td>
                        <?php if($goal['status'] == 'Active'): ?>
                            <span class="badge badge-success"><?php echo $goal['status']; ?></span>
                        <?php else: ?>
                            <span class="badge badge-warning"><?php echo $goal['status']; ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
