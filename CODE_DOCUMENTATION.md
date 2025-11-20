# Family Budget System - Code Documentation

**Project:** Database Systems  
**Date:** November 2024

---

## Table of Contents
1. [Project Overview](#project-overview)
2. [Database Structure](#database-structure)
3. [File Structure](#file-structure)
4. [Code Explanation](#code-explanation)
5. [How Everything Works Together](#how-everything-works-together)

---

## Project Overview

The Family Budget System is a web application that helps families track their income, expenses, budgets, and savings goals. It's built using:
- **Frontend:** HTML, CSS
- **Backend:** PHP
- **Database:** MySQL
- **Server:** Apache (XAMPP)

---

## Database Structure

### Tables

#### 1. family_members
Stores information about family members who use the system.
```sql
member_id (INT, PRIMARY KEY, AUTO_INCREMENT)
member_name (VARCHAR 100)
relationship (VARCHAR 50) - e.g., Father, Mother, Son
email (VARCHAR 100)
phone (VARCHAR 20)
```

#### 2. income_categories
Categories for different types of income.
```sql
income_category_id (INT, PRIMARY KEY, AUTO_INCREMENT)
category_name (VARCHAR 100) - e.g., Salary, Freelance
description (VARCHAR 255)
```

#### 3. income
Records all income transactions.
```sql
income_id (INT, PRIMARY KEY, AUTO_INCREMENT)
member_id (INT, FOREIGN KEY → family_members)
income_category_id (INT, FOREIGN KEY → income_categories)
amount (DECIMAL 10,2)
income_date (DATE)
description (VARCHAR 255)
```

#### 4. expense_categories
Categories for expenses with monthly budgets.
```sql
expense_category_id (INT, PRIMARY KEY, AUTO_INCREMENT)
category_name (VARCHAR 100) - e.g., Groceries, Housing
budget_amount (DECIMAL 10,2) - Monthly budget
description (VARCHAR 255)
```

#### 5. expenses
Records all expense transactions.
```sql
expense_id (INT, PRIMARY KEY, AUTO_INCREMENT)
member_id (INT, FOREIGN KEY → family_members)
expense_category_id (INT, FOREIGN KEY → expense_categories)
amount (DECIMAL 10,2)
expense_date (DATE)
payment_method (VARCHAR 50) - e.g., Cash, Credit Card
description (VARCHAR 255)
```

#### 6. savings_goals
Family savings goals with progress tracking.
```sql
goal_id (INT, PRIMARY KEY, AUTO_INCREMENT)
goal_name (VARCHAR 100) - e.g., Emergency Fund
target_amount (DECIMAL 10,2)
current_amount (DECIMAL 10,2)
start_date (DATE)
target_date (DATE)
status (VARCHAR 20) - Active, Achieved, Cancelled
description (VARCHAR 255)
```

### Relationships
- One family member → Many income entries
- One income category → Many income entries
- One family member → Many expense entries
- One expense category → Many expense entries

---

## File Structure

```
family_budget_system/
├── index.php                          # Main dashboard
├── css/
│   └── style.css                      # All styling
├── includes/
│   └── db_connect.php                 # Database connection
├── pages/
│   ├── income.php                     # Income management
│   ├── expenses.php                   # Expense management
│   ├── budget.php                     # Budget monitoring
│   └── savings.php                    # Savings goals display
├── database_schema.sql                # Database creation script
├── BUSINESS_INFORMATION_REQUIREMENTS.md
└── ERD_SPECIFICATION.md
```

---

## Code Explanation

### 1. Database Connection (includes/db_connect.php)

```php
<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'family_budget';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

**What it does:**
- Sets database credentials (host, username, password, database name)
- Creates connection to MySQL using `mysqli_connect()`
- If connection fails, stops execution and shows error
- `$conn` variable is used throughout the app to run queries

**Why it's important:**
- Every page needs database access
- Centralized connection = change once, affects all pages
- Error handling prevents app from breaking silently

---

### 2. Main Dashboard (index.php)

#### Part 1: Calculate Statistics
```php
$income_query = "SELECT SUM(amount) as total FROM income";
$income_result = mysqli_query($conn, $income_query);
$income_row = mysqli_fetch_assoc($income_result);
$total_income = $income_row['total'] ? $income_row['total'] : 0;
```

**What it does:**
1. Creates SQL query to sum all income amounts
2. Executes query using `mysqli_query()`
3. Fetches result as associative array
4. Stores total income (or 0 if no income exists)

**Same process for expenses:**
```php
$expense_query = "SELECT SUM(amount) as total FROM expenses";
// ... same process ...
$total_expenses = $expense_row['total'] ? $expense_row['total'] : 0;
```

**Calculate balance:**
```php
$balance = $total_income - $total_expenses;
```

#### Part 2: Get Recent Transactions
```php
$recent_income = mysqli_query($conn, "SELECT i.*, m.member_name, c.category_name 
                                       FROM income i 
                                       LEFT JOIN family_members m ON i.member_id = m.member_id 
                                       LEFT JOIN income_categories c ON i.income_category_id = c.income_category_id 
                                       ORDER BY i.income_date DESC LIMIT 5");
```

**What it does:**
- Selects all income columns (i.*)
- Joins with family_members to get member name
- Joins with income_categories to get category name
- Orders by date (newest first)
- Limits to 5 most recent

#### Part 3: Display Data
```php
<div class="amount">$<?php echo number_format($total_income, 2); ?></div>
```
- `number_format()` formats number with 2 decimal places
- Shows as: $1,234.56

```php
<?php while($row = mysqli_fetch_assoc($recent_income)): ?>
<tr>
    <td><?php echo $row['income_date']; ?></td>
    <td><?php echo $row['member_name']; ?></td>
    <td><?php echo $row['category_name']; ?></td>
    <td>$<?php echo number_format($row['amount'], 2); ?></td>
    <td><?php echo $row['description']; ?></td>
</tr>
<?php endwhile; ?>
```
- Loop through each row in result
- Display data in table cells
- Continues until no more rows

---

### 3. Income Page (pages/income.php)

#### Part 1: Handle Form Submission
```php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $category_id = $_POST['income_category_id'];
    $amount = $_POST['amount'];
    $date = $_POST['income_date'];
    $description = $_POST['description'];
```

**What it does:**
- Checks if form was submitted (POST request)
- Gets all form data from `$_POST` array
- Stores in variables for easier use

```php
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
```

**What it does:**
1. Creates INSERT SQL query
2. Executes query
3. If successful: saves success message in session
4. If failed: saves error message in session
5. Redirects back to income.php
6. `exit()` stops further execution

**Why use sessions?**
- Messages survive the redirect
- Can display message after page reloads

#### Part 2: Get Data for Dropdowns
```php
$members = mysqli_query($conn, "SELECT * FROM family_members");
$categories = mysqli_query($conn, "SELECT * FROM income_categories");
```
- Gets all family members for dropdown
- Gets all income categories for dropdown

#### Part 3: Display Form
```php
<select name="member_id" required>
    <option value="">Select Member</option>
    <?php while($member = mysqli_fetch_assoc($members)): ?>
        <option value="<?php echo $member['member_id']; ?>">
            <?php echo $member['member_name']; ?>
        </option>
    <?php endwhile; ?>
</select>
```

**What it does:**
- Creates dropdown select
- Loops through all members
- Creates option for each with ID as value and name as display

#### Part 4: Display All Income
```php
$income = mysqli_query($conn, "SELECT i.*, m.member_name, c.category_name 
                                FROM income i 
                                LEFT JOIN family_members m ON i.member_id = m.member_id 
                                LEFT JOIN income_categories c ON i.income_category_id = c.income_category_id 
                                ORDER BY i.income_date DESC");
```
- Same as dashboard but gets ALL income (no LIMIT)
- Displays in table format

---

### 4. Expenses Page (pages/expenses.php)

**Works exactly like income.php but with expenses:**
- Form has extra field: `payment_method`
- Inserts into `expenses` table
- Joins with `expense_categories` instead of income categories
- Payment method dropdown has predefined options: Cash, Credit Card, Debit Card, Bank Transfer

---

### 5. Budget Page (pages/budget.php)

#### The Query
```php
$budget_query = "SELECT c.category_name, c.budget_amount, 
                 COALESCE(SUM(e.amount), 0) as actual_spent,
                 (c.budget_amount - COALESCE(SUM(e.amount), 0)) as difference
                 FROM expense_categories c
                 LEFT JOIN expenses e ON c.expense_category_id = e.expense_category_id
                 GROUP BY c.expense_category_id, c.category_name, c.budget_amount";
```

**What it does:**
1. Selects category name and budget amount
2. `COALESCE(SUM(e.amount), 0)` = sum expenses or 0 if none
3. Calculates difference (budget - actual)
4. LEFT JOIN = includes categories with no expenses
5. GROUP BY = aggregates expenses by category

#### Display Status Badges
```php
<?php if($row['difference'] < 0): ?>
    <span class="badge badge-danger">Over Budget</span>
<?php elseif($row['difference'] < ($row['budget_amount'] * 0.2)): ?>
    <span class="badge badge-warning">Near Limit</span>
<?php else: ?>
    <span class="badge badge-success">On Track</span>
<?php endif; ?>
```

**Logic:**
- If difference < 0: Over budget (spent more than allowed)
- If difference < 20% of budget: Near limit (warning)
- Otherwise: On track (green)

---

### 6. Savings Goals Page (pages/savings.php)

#### Calculate Progress
```php
<?php while($goal = mysqli_fetch_assoc($goals)): 
    $progress = ($goal['current_amount'] / $goal['target_amount']) * 100;
?>
```
- Divides current by target
- Multiplies by 100 to get percentage

#### Display Progress Bar
```php
<div class="progress-bar">
    <div class="progress-fill" style="width: <?php echo $progress; ?>%"></div>
</div>
<?php echo round($progress, 1); ?>%
```
- Inner div width set to progress percentage
- `round($progress, 1)` = rounds to 1 decimal place
- Shows visual bar + percentage number

---

### 7. CSS Styling (css/style.css)

#### Key CSS Concepts Used:

**1. CSS Reset**
```css
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
```
- Removes default browser spacing
- `box-sizing` makes width/height calculations easier

**2. Layout Structure**
```css
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}
```
- Centers content
- Max width prevents it being too wide
- Adds padding for spacing

**3. Grid Layout for Stats**
```css
.stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}
```
- Creates responsive grid
- Columns auto-fit based on screen size
- Each column minimum 250px wide
- Equal width columns (1fr)

**4. Card Design**
```css
.card {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
```
- White background
- Padding for internal spacing
- Rounded corners
- Subtle shadow for depth

**5. Form Styling**
```css
.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
```
- Full width inputs
- Consistent padding
- Light border
- Slightly rounded

**6. Button Styles**
```css
.btn-primary {
    background-color: #3498db;
    color: white;
}
.btn-primary:hover {
    background-color: #2980b9;
}
```
- Blue button
- White text
- Darker blue on hover

**7. Table Styling**
```css
table th {
    background-color: #34495e;
    color: white;
}
table tr:hover {
    background-color: #f8f9fa;
}
```
- Dark header
- Highlight row on hover

---

## How Everything Works Together

### 1. User Opens Dashboard (index.php)

```
Browser → index.php
         ↓
    includes db_connect.php (connects to MySQL)
         ↓
    Runs queries (total income, total expenses, recent transactions)
         ↓
    Calculates balance
         ↓
    Displays HTML with PHP data embedded
         ↓
    Loads style.css for styling
         ↓
    Shows to user
```

### 2. User Clicks "Income" in Navigation

```
Browser → pages/income.php
         ↓
    includes ../includes/db_connect.php
         ↓
    Gets members and categories for dropdowns
         ↓
    Gets all income for table
         ↓
    Displays form + table
```

### 3. User Submits Income Form

```
User fills form → clicks "Add Income"
         ↓
    Browser sends POST request to income.php
         ↓
    PHP checks: if ($_SERVER['REQUEST_METHOD'] == 'POST')
         ↓
    Gets form data from $_POST
         ↓
    Creates INSERT query
         ↓
    Executes query with mysqli_query()
         ↓
    Sets success/error message in $_SESSION
         ↓
    Redirects to income.php (header("Location:..."))
         ↓
    Page reloads, shows message
         ↓
    New income appears in table
```

### 4. Data Flow Diagram

```
┌─────────────┐
│   Browser   │
└─────┬───────┘
      │
      │ HTTP Request
      ↓
┌─────────────┐
│  Apache     │
│  (XAMPP)    │
└─────┬───────┘
      │
      │ Executes PHP
      ↓
┌─────────────┐
│   PHP       │ ←─── includes db_connect.php
│   Files     │
└─────┬───────┘
      │
      │ SQL Queries
      ↓
┌─────────────┐
│   MySQL     │
│  Database   │
└─────┬───────┘
      │
      │ Results
      ↓
┌─────────────┐
│   PHP       │ ←─── Processes data
│   Files     │
└─────┬───────┘
      │
      │ HTML + Data
      ↓
┌─────────────┐
│   Browser   │ ←─── Displays to user
└─────────────┘
```

---

## Key Programming Concepts Used

### 1. Sessions
```php
session_start();
$_SESSION['message'] = "Success!";
```
- Stores data across page requests
- Used for success/error messages
- Each user has separate session

### 2. POST vs GET
- **POST:** Used for forms (submitting data)
- **GET:** Used for links (retrieving data)

### 3. SQL Queries
- **SELECT:** Get data from database
- **INSERT:** Add new data
- **SUM():** Add up numbers
- **LEFT JOIN:** Combine tables
- **GROUP BY:** Group results

### 4. PHP-HTML Integration
```php
<p>Total: $<?php echo number_format($total, 2); ?></p>
```
- PHP embedded in HTML
- Calculates/fetches data
- Displays dynamically

### 5. Form Handling
```html
<form method="POST">
    <input name="amount">
    <button type="submit">Submit</button>
</form>
```
```php
$amount = $_POST['amount'];
```
- Form sends data on submit
- PHP receives in $_POST array

---


---

## Troubleshooting Common Issues

### "Connection failed"
- Check XAMPP MySQL is running
- Verify database name is correct
- Check username/password in db_connect.php

### "Field doesn't have a default value"
- Make sure AUTO_INCREMENT is added to all primary keys
- Re-import database_schema.sql

### Form doesn't submit
- Check form `method="POST"`
- Verify input `name` attributes match $_POST variables
- Check for PHP errors in XAMPP logs

### Styles not loading
- Check CSS file path is correct
- Clear browser cache
- Verify Apache is running

---


