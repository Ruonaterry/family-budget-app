<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $category_id = $_POST['income_category_id'];
    $amount = $_POST['amount'];
    $date = $_POST['income_date'];
    $description = $_POST['description'];
    
    $sql = "INSERT INTO income (member_id, income_category_id, amount, income_date, description) 
            VALUES ('$member_id', '$category_id', '$amount', '$date', '$description')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Income added successfully!";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }
    
    header("Location: income.php");
    exit();
}

$income = mysqli_query($conn, "SELECT i.*, m.member_name, c.category_name 
                                FROM income i 
                                LEFT JOIN family_members m ON i.member_id = m.member_id 
                                LEFT JOIN income_categories c ON i.income_category_id = c.income_category_id 
                                ORDER BY i.income_date DESC");

$members = mysqli_query($conn, "SELECT * FROM family_members");

$categories = mysqli_query($conn, "SELECT * FROM income_categories");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Income Management</title>
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
            <h2>Add New Income</h2>
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
                    <label>Income Category</label>
                    <select name="income_category_id" required>
                        <option value="">Select Category</option>
                        <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?php echo $cat['income_category_id']; ?>">
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
                    <input type="date" name="income_date" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description">
                </div>

                <button type="submit" class="btn btn-success">Add Income</button>
            </form>
        </div>

        <div class="card">
            <h2>All Income</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($income)): ?>
                <tr>
                    <td><?php echo $row['income_id']; ?></td>
                    <td><?php echo $row['income_date']; ?></td>
                    <td><?php echo $row['member_name']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>$<?php echo number_format($row['amount'], 2); ?></td>
                    <td><?php echo $row['description']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
