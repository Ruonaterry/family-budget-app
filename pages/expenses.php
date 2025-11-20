<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $category_id = $_POST['expense_category_id'];
    $amount = $_POST['amount'];
    $date = $_POST['expense_date'];
    $payment_method = $_POST['payment_method'];
    $description = $_POST['description'];
    
    $sql = "INSERT INTO expenses (member_id, expense_category_id, amount, expense_date, payment_method, description) 
            VALUES ('$member_id', '$category_id', '$amount', '$date', '$payment_method', '$description')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Expense added successfully!";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }
    
    header("Location: expenses.php");
    exit();
}

$expenses = mysqli_query($conn, "SELECT e.*, m.member_name, c.category_name 
                                  FROM expenses e 
                                  LEFT JOIN family_members m ON e.member_id = m.member_id 
                                  LEFT JOIN expense_categories c ON e.expense_category_id = c.expense_category_id 
                                  ORDER BY e.expense_date DESC");

$members = mysqli_query($conn, "SELECT * FROM family_members");

$categories = mysqli_query($conn, "SELECT * FROM expense_categories");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Expenses Management</title>
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
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="card">
            <h2>Add New Expense</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Family Member</label>
                    <select name="member_id" required>
                        <option value="">Select Member</option>
                        <?php while($member = mysqli_fetch_assoc($members)): ?>
                            <option value="<?php echo $member['member_id']; ?>">
                                <?php echo $member['member_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Expense Category</label>
                    <select name="expense_category_id" required>
                        <option value="">Select Category</option>
                        <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?php echo $cat['expense_category_id']; ?>">
                                <?php echo $cat['category_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="expense_date" required>
                </div>

                <div class="form-group">
                    <label>Payment Method</label>
                    <select name="payment_method" required>
                        <option value="">Select Method</option>
                        <option value="Cash">Cash</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Debit Card">Debit Card</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description">
                </div>

                <button type="submit" class="btn btn-danger">Add Expense</button>
            </form>
        </div>

        <div class="card">
            <h2>All Expenses</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Description</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($expenses)): ?>
                <tr>
                    <td><?php echo $row['expense_id']; ?></td>
                    <td><?php echo $row['expense_date']; ?></td>
                    <td><?php echo $row['member_name']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>$<?php echo number_format($row['amount'], 2); ?></td>
                    <td><?php echo $row['payment_method']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
