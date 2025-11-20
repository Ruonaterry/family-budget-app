# Family Budget Application System

A database system to help families track income, expenses, budgets, and savings goals.

---

## Project Overview

This system allows families to:
- Track all income from various sources
- Record and categorize expenses
- Set monthly budgets for spending categories
- Monitor savings goals
- Generate financial reports

---

## Database Structure

### Tables
1. **family_members** - Family members using the system
2. **income_categories** - Types of income (Salary, Freelance, etc.)
3. **income** - Income transactions
4. **expense_categories** - Types of expenses with budgets
5. **expenses** - Expense transactions
6. **savings_goals** - Financial goals to achieve

### Sample Data
- 4 family members
- 4 income categories
- 7 expense categories with budgets
- 8 income entries
- 15 expense entries
- 4 savings goals

---

## Setup Instructions

### Using MySQL Workbench

1. **Start MySQL Server**
   - Make sure MySQL is running (via XAMPP or MySQL Workbench)

2. **Open MySQL Workbench**
   - Connect to your local MySQL server

3. **Import Database**
   - File → Open SQL Script
   - Select `database_schema.sql`
   - Click Execute (⚡ icon)

4. **Verify**
   - Refresh the Schemas panel
   - You should see `family_budget` database
   - Expand to see all 6 tables with data

---

## Documentation

- **BUSINESS_INFORMATION_REQUIREMENTS.md** - Complete business requirements and data needs
- **ERD_SPECIFICATION.md** - Entity-Relationship Diagram specifications with instructions
- **database_schema.sql** - Complete database with sample data

---

## Database Features

✅ Separate CREATE TABLE and ALTER TABLE statements  
✅ Primary keys added using ALTER TABLE  
✅ Foreign keys added using ALTER TABLE  
✅ Sufficient sample data for testing  
✅ All tables in 3rd Normal Form (3NF)  
✅ Clear relationships between entities  

---

## Sample Queries

### View all expenses with member and category names
```sql
SELECT e.expense_id, m.member_name, c.category_name, e.amount, e.expense_date
FROM expenses e
LEFT JOIN family_members m ON e.member_id = m.member_id
LEFT JOIN expense_categories c ON e.expense_category_id = c.expense_category_id;
```

### View total income by member
```sql
SELECT m.member_name, SUM(i.amount) as total_income
FROM income i
LEFT JOIN family_members m ON i.member_id = m.member_id
GROUP BY m.member_name;
```

### Check budget vs actual spending
```sql
SELECT c.category_name, c.budget_amount, SUM(e.amount) as actual_spent,
       (c.budget_amount - SUM(e.amount)) as difference
FROM expense_categories c
LEFT JOIN expenses e ON c.expense_category_id = e.expense_category_id
GROUP BY c.category_name, c.budget_amount;
```

### View savings goal progress
```sql
SELECT goal_name, target_amount, current_amount,
       ROUND((current_amount / target_amount) * 100, 2) as progress_percent,
       status
FROM savings_goals;
```

---

## Project Requirements Met

✅ **Requirement 1:** Business Information Requirements documented  
✅ **Requirement 2:** ERD with Oracle notation specifications  
✅ **Requirement 3:** Normalization (3NF) verified  
✅ **Requirement 4:** Database implemented with constraints  

---

**Created by:** Family Budget System Team  
**Course:** Database Systems  
**Date:** November 2024
