# BUSINESS INFORMATION REQUIREMENTS
## Family Budget Application System

**Project:** Database Systems  
**Topic:** Family Budget Management System  
**Date:** November 2024

---

## 1. BUSINESS OVERVIEW

### 1.1 System Purpose
The Family Budget Application System is designed to help families track their income, expenses, savings goals, and financial transactions. The system enables family members to manage their household finances effectively by recording all income sources, categorizing expenses, setting budgets for different spending categories, and monitoring savings goals to achieve financial objectives.

### 1.2 Business Objectives
- Track all family income from various sources
- Record and categorize all household expenses
- Set and monitor monthly budgets for different expense categories
- Track progress toward savings goals
- Maintain records of all financial transactions
- Generate reports to understand spending patterns
- Help families make better financial decisions

---

## 2. INFORMATION REQUIREMENTS

### 2.1 Family Member Information
The system must capture details about family members who participate in the budget:
- **Member Identification:** Unique member ID
- **Personal Information:** Full name, relationship to household (parent, child, etc.)
- **Contact Information:** Email address and phone number
- **Role:** Whether they can add/edit transactions or just view

### 2.2 Income Category Information
To organize different types of income, the system must track:
- **Category Identification:** Unique income category ID
- **Category Name:** Name of income type (e.g., Salary, Freelance, Investment, Gift)
- **Description:** Brief explanation of the income category

### 2.3 Income Information
For tracking money coming into the household, the system must maintain:
- **Income Identification:** Unique income ID
- **Member Reference:** Which family member received the income
- **Category Reference:** What type of income it is
- **Amount:** How much money was received
- **Date:** When the income was received
- **Description:** Additional details about the income source

### 2.4 Expense Category Information
To organize different types of spending, the system must track:
- **Category Identification:** Unique expense category ID
- **Category Name:** Name of expense type (e.g., Food, Rent, Transportation, Entertainment)
- **Description:** Brief explanation of the category
- **Budget Amount:** Monthly budget allocated for this category

### 2.5 Expense Information
For tracking money spent by the family, the system must capture:
- **Expense Identification:** Unique expense ID
- **Member Reference:** Which family member made the expense
- **Category Reference:** What type of expense it is
- **Amount:** How much money was spent
- **Date:** When the expense was made
- **Payment Method:** How payment was made (Cash, Credit Card, Debit Card, etc.)
- **Description:** Additional details about the expense

### 2.6 Savings Goal Information
To track financial objectives, the system must maintain:
- **Goal Identification:** Unique savings goal ID
- **Goal Name:** Name of the savings goal (e.g., Emergency Fund, Vacation, New Car)
- **Target Amount:** How much money is the goal
- **Current Amount:** How much has been saved so far
- **Start Date:** When the goal was created
- **Target Date:** When the goal should be achieved
- **Status:** Whether the goal is Active, Achieved, or Cancelled
- **Description:** Additional details about the goal

---

## 3. BUSINESS RULES AND RELATIONSHIPS

### 3.1 Family Member - Income Relationship
- One family member can have multiple income entries
- Each income entry is associated with one family member
- Family members can exist without income entries (e.g., children)

### 3.2 Income Category - Income Relationship
- One income category can be used for multiple income entries
- Each income entry belongs to one income category
- Income categories can exist without income entries

### 3.3 Family Member - Expense Relationship
- One family member can make multiple expense entries
- Each expense entry is made by one family member
- Family members can exist without expense entries

### 3.4 Expense Category - Expense Relationship
- One expense category can have multiple expense entries
- Each expense entry belongs to one expense category
- Expense categories must have a monthly budget amount
- Categories can exist without expense entries

### 3.5 Financial Calculations
- **Total Income** = Sum of all income entries
- **Total Expenses** = Sum of all expense entries
- **Net Balance** = Total Income - Total Expenses
- **Category Budget Status** = Budget Amount - Actual Spent
- **Savings Goal Progress** = (Current Amount / Target Amount) × 100%

---

## 4. OPERATIONAL REQUIREMENTS

### 4.1 Income Management
- Family members can record income when received
- Each income must be categorized
- System must track who received the income
- Income amounts must be positive numbers
- Income dates must be valid dates

### 4.2 Expense Management
- Family members can record expenses when made
- Each expense must be categorized
- System must track who made the expense
- Expense amounts must be positive numbers
- System must track payment method used

### 4.3 Budget Monitoring
- Each expense category has a monthly budget
- System must compare actual spending against budget
- System should alert when spending exceeds budget
- Budget amounts can be adjusted monthly

### 4.4 Savings Goal Tracking
- Family can set multiple savings goals
- Track progress toward each goal
- Goals have target amounts and dates
- Status shows if goal is active, achieved, or cancelled
- Current amount shows progress

### 4.5 Reporting Needs
- Monthly income summary by category
- Monthly expense summary by category
- Budget vs. actual spending comparison
- Savings goal progress report
- Overall financial summary (income, expenses, balance)
- Spending trends by category
- Payment method usage analysis

---

## 5. USER INFORMATION NEEDS

### 5.1 Family Budget Manager Needs
- View complete financial overview
- Add/edit/delete income entries
- Add/edit/delete expense entries
- Set and adjust budgets for categories
- Create and manage savings goals
- Generate financial reports
- View spending patterns

### 5.2 Family Member Needs
- Record personal income
- Record personal expenses
- View personal transaction history
- View family budget status
- Check savings goal progress
- View spending by category

### 5.3 Household Financial Analysis
- Compare income vs. expenses over time
- Identify highest spending categories
- Track budget adherence
- Monitor savings progress
- Understand financial health of household

---

## 6. DATA REQUIREMENTS

### 6.1 Transaction Volume
- System must handle multiple daily transactions
- Store historical data for trend analysis
- Support multiple family members
- Track numerous expense and income categories

### 6.2 Data Accuracy
- All monetary amounts must be stored with 2 decimal places
- Dates must be in standard format (YYYY-MM-DD)
- Amounts must be positive numbers
- All calculations must be accurate
- Budget comparisons must be real-time

### 6.3 Data Relationships
- Expenses must link to valid members and categories
- Income must link to valid members and categories
- All financial data must be traceable to specific family members
- Categories must maintain budget information

---

## 7. SAMPLE DATA STRUCTURE

### Family Members (Example)
- John Smith (Father) - Admin role
- Mary Smith (Mother) - Admin role
- Sarah Smith (Daughter, 16) - View only

### Income Categories (Example)
- Salary
- Freelance Work
- Investment Returns
- Gifts/Other

### Expense Categories with Budgets (Example)
- Housing (Rent/Mortgage) - $1,500/month
- Groceries - $600/month
- Transportation - $300/month
- Utilities - $200/month
- Entertainment - $150/month
- Healthcare - $100/month
- Education - $200/month
- Miscellaneous - $150/month

### Savings Goals (Example)
- Emergency Fund - Target: $5,000
- Family Vacation - Target: $3,000
- Car Down Payment - Target: $10,000

---

## 8. SYSTEM CONSTRAINTS

### 8.1 Data Entry Rules
- Income amounts must be greater than 0
- Expense amounts must be greater than 0
- Budget amounts must be greater than 0
- Dates cannot be in the future
- All required fields must be filled
- Payment methods must be from predefined list

### 8.2 Category Management
- Income categories can be added/modified
- Expense categories must have budget amounts
- Categories cannot be deleted if they have transactions
- Budget amounts can be updated monthly

### 8.3 Member Management
- Each household must have at least one admin member
- Members can be added or removed
- Deleted members' transactions remain in history
- Member roles control access levels

---

## 9. BUSINESS BENEFITS

### 9.1 Financial Awareness
- Clear visibility of income vs. expenses
- Understanding of spending patterns
- Identification of budget overspending
- Progress tracking toward financial goals

### 9.2 Better Decision Making
- Data-driven budget adjustments
- Informed spending decisions
- Goal-oriented savings
- Waste reduction through tracking

### 9.3 Family Financial Planning
- Collaborative budget management
- Shared financial goals
- Transparent household finances
- Improved financial discipline

---

## 10. SUMMARY

The Family Budget Application System provides comprehensive tracking and management of household finances. The system captures six main entities (Family Members, Income Categories, Income, Expense Categories, Expenses, and Savings Goals) with clear relationships between them. The information requirements support essential financial operations including income tracking, expense management, budget monitoring, and savings goal progress. The system helps families gain control over their finances through organized data capture, accurate tracking, and meaningful reporting capabilities.

---

**Document Prepared By:** Family Budget System Team  
**Academic Institution:** Database Systems Course  
**Date:** November 2024
