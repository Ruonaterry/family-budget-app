CREATE DATABASE family_budget;
USE family_budget;

CREATE TABLE family_members (
    member_id INT,
    member_name VARCHAR(100),
    relationship VARCHAR(50),
    email VARCHAR(100),
    phone VARCHAR(20)
);

CREATE TABLE income_categories (
    income_category_id INT,
    category_name VARCHAR(100),
    description VARCHAR(255)
);

CREATE TABLE income (
    income_id INT,
    member_id INT,
    income_category_id INT,
    amount DECIMAL(10, 2),
    income_date DATE,
    description VARCHAR(255)
);

CREATE TABLE expense_categories (
    expense_category_id INT,
    category_name VARCHAR(100),
    budget_amount DECIMAL(10, 2),
    description VARCHAR(255)
);

CREATE TABLE expenses (
    expense_id INT,
    member_id INT,
    expense_category_id INT,
    amount DECIMAL(10, 2),
    expense_date DATE,
    payment_method VARCHAR(50),
    description VARCHAR(255)
);

CREATE TABLE savings_goals (
    goal_id INT,
    goal_name VARCHAR(100),
    target_amount DECIMAL(10, 2),
    current_amount DECIMAL(10, 2),
    start_date DATE,
    target_date DATE,
    status VARCHAR(20),
    description VARCHAR(255)
);

ALTER TABLE family_members
ADD PRIMARY KEY (member_id);

ALTER TABLE family_members
MODIFY member_id INT AUTO_INCREMENT;

ALTER TABLE income_categories
ADD PRIMARY KEY (income_category_id);

ALTER TABLE income_categories
MODIFY income_category_id INT AUTO_INCREMENT;

ALTER TABLE income
ADD PRIMARY KEY (income_id);

ALTER TABLE income
MODIFY income_id INT AUTO_INCREMENT;

ALTER TABLE expense_categories
ADD PRIMARY KEY (expense_category_id);

ALTER TABLE expense_categories
MODIFY expense_category_id INT AUTO_INCREMENT;

ALTER TABLE expenses
ADD PRIMARY KEY (expense_id);

ALTER TABLE expenses
MODIFY expense_id INT AUTO_INCREMENT;

ALTER TABLE savings_goals
ADD PRIMARY KEY (goal_id);

ALTER TABLE savings_goals
MODIFY goal_id INT AUTO_INCREMENT;

ALTER TABLE income
ADD FOREIGN KEY (member_id) REFERENCES family_members(member_id);

ALTER TABLE income
ADD FOREIGN KEY (income_category_id) REFERENCES income_categories(income_category_id);

ALTER TABLE expenses
ADD FOREIGN KEY (member_id) REFERENCES family_members(member_id);

ALTER TABLE expenses
ADD FOREIGN KEY (expense_category_id) REFERENCES expense_categories(expense_category_id);

INSERT INTO family_members VALUES (1, 'John Smith', 'Father', 'john@email.com', '555-1001');
INSERT INTO family_members VALUES (2, 'Mary Smith', 'Mother', 'mary@email.com', '555-1002');
INSERT INTO family_members VALUES (3, 'Sarah Smith', 'Daughter', 'sarah@email.com', '555-1003');
INSERT INTO family_members VALUES (4, 'Mike Smith', 'Son', 'mike@email.com', '555-1004');

INSERT INTO income_categories VALUES (1, 'Salary', 'Regular monthly salary');
INSERT INTO income_categories VALUES (2, 'Freelance', 'Freelance work income');
INSERT INTO income_categories VALUES (3, 'Investment', 'Investment returns');
INSERT INTO income_categories VALUES (4, 'Gift', 'Monetary gifts');

INSERT INTO expense_categories VALUES (1, 'Housing', 1500.00, 'Rent and mortgage');
INSERT INTO expense_categories VALUES (2, 'Groceries', 600.00, 'Food and household items');
INSERT INTO expense_categories VALUES (3, 'Transportation', 300.00, 'Gas and car expenses');
INSERT INTO expense_categories VALUES (4, 'Utilities', 200.00, 'Electricity, water, internet');
INSERT INTO expense_categories VALUES (5, 'Entertainment', 150.00, 'Movies, dining out, fun');
INSERT INTO expense_categories VALUES (6, 'Healthcare', 100.00, 'Medical expenses');
INSERT INTO expense_categories VALUES (7, 'Education', 200.00, 'School and courses');

INSERT INTO income VALUES (1, 1, 1, 4500.00, '2024-01-05', 'January salary');
INSERT INTO income VALUES (2, 2, 1, 3800.00, '2024-01-05', 'January salary');
INSERT INTO income VALUES (3, 1, 2, 800.00, '2024-01-15', 'Website project');
INSERT INTO income VALUES (4, 1, 1, 4500.00, '2024-02-05', 'February salary');
INSERT INTO income VALUES (5, 2, 1, 3800.00, '2024-02-05', 'February salary');
INSERT INTO income VALUES (6, 2, 4, 200.00, '2024-02-14', 'Birthday gift');
INSERT INTO income VALUES (7, 1, 1, 4500.00, '2024-03-05', 'March salary');
INSERT INTO income VALUES (8, 2, 1, 3800.00, '2024-03-05', 'March salary');

INSERT INTO expenses VALUES (1, 1, 1, 1500.00, '2024-01-01', 'Credit Card', 'Monthly rent');
INSERT INTO expenses VALUES (2, 2, 2, 150.00, '2024-01-03', 'Debit Card', 'Grocery shopping');
INSERT INTO expenses VALUES (3, 1, 3, 60.00, '2024-01-05', 'Cash', 'Gas');
INSERT INTO expenses VALUES (4, 2, 4, 180.00, '2024-01-10', 'Credit Card', 'Electric bill');
INSERT INTO expenses VALUES (5, 2, 2, 120.00, '2024-01-12', 'Debit Card', 'Grocery shopping');
INSERT INTO expenses VALUES (6, 1, 5, 80.00, '2024-01-15', 'Cash', 'Family dinner');
INSERT INTO expenses VALUES (7, 3, 5, 25.00, '2024-01-18', 'Cash', 'Movies');
INSERT INTO expenses VALUES (8, 2, 2, 135.00, '2024-01-20', 'Debit Card', 'Grocery shopping');
INSERT INTO expenses VALUES (9, 1, 3, 55.00, '2024-01-22', 'Cash', 'Gas');
INSERT INTO expenses VALUES (10, 2, 6, 45.00, '2024-01-25', 'Credit Card', 'Pharmacy');
INSERT INTO expenses VALUES (11, 1, 1, 1500.00, '2024-02-01', 'Credit Card', 'Monthly rent');
INSERT INTO expenses VALUES (12, 2, 2, 145.00, '2024-02-05', 'Debit Card', 'Grocery shopping');
INSERT INTO expenses VALUES (13, 1, 3, 65.00, '2024-02-08', 'Cash', 'Gas');
INSERT INTO expenses VALUES (14, 3, 7, 150.00, '2024-02-10', 'Debit Card', 'School supplies');
INSERT INTO expenses VALUES (15, 2, 5, 90.00, '2024-02-14', 'Credit Card', 'Valentine dinner');

INSERT INTO savings_goals VALUES (1, 'Emergency Fund', 5000.00, 2400.00, '2024-01-01', '2024-12-31', 'Active', 'For unexpected expenses');
INSERT INTO savings_goals VALUES (2, 'Family Vacation', 3000.00, 800.00, '2024-01-01', '2024-08-01', 'Active', 'Summer vacation fund');
INSERT INTO savings_goals VALUES (3, 'Car Down Payment', 10000.00, 4500.00, '2024-01-01', '2025-06-01', 'Active', 'New family car');
INSERT INTO savings_goals VALUES (4, 'Home Renovation', 15000.00, 1200.00, '2024-02-01', '2025-12-31', 'Active', 'Kitchen remodel');
