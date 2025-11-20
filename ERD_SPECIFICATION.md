# ENTITY-RELATIONSHIP DIAGRAM (ERD) SPECIFICATION
## Family Budget Application System - Oracle Notation

**Project:** Database Systems  
**Topic:** Family Budget Management System  
**Date:** November 2024

---

## OVERVIEW

This document provides complete specifications for creating the Entity-Relationship Diagram (ERD) using Oracle notation (crow's foot notation). This ERD is based on the Business Information Requirements document and represents the conceptual data model of the Family Budget Application System.

---

## ENTITIES AND ATTRIBUTES

### Entity 1: FAMILY_MEMBERS
**Description:** Family members who use the budget system

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| member_id | Integer | PK | Yes | Unique identifier for family member |
| member_name | String(100) | - | Yes | Full name of family member |
| relationship | String(50) | - | Yes | Relationship to household |
| email | String(100) | - | No | Email address |
| phone | String(20) | - | No | Phone number |

### Entity 2: INCOME_CATEGORIES
**Description:** Categories for different types of income

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| income_category_id | Integer | PK | Yes | Unique identifier for income category |
| category_name | String(100) | - | Yes | Name of income category |
| description | String(255) | - | No | Description of category |

### Entity 3: INCOME
**Description:** Income transactions received by family members

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| income_id | Integer | PK | Yes | Unique identifier for income |
| member_id | Integer | FK | No | Reference to family member |
| income_category_id | Integer | FK | No | Reference to income category |
| amount | Decimal(10,2) | - | Yes | Amount of income |
| income_date | Date | - | Yes | Date income was received |
| description | String(255) | - | No | Additional details |

### Entity 4: EXPENSE_CATEGORIES
**Description:** Categories for different types of expenses with budget amounts

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| expense_category_id | Integer | PK | Yes | Unique identifier for expense category |
| category_name | String(100) | - | Yes | Name of expense category |
| budget_amount | Decimal(10,2) | - | Yes | Monthly budget for category |
| description | String(255) | - | No | Description of category |

### Entity 5: EXPENSES
**Description:** Expense transactions made by family members

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| expense_id | Integer | PK | Yes | Unique identifier for expense |
| member_id | Integer | FK | No | Reference to family member |
| expense_category_id | Integer | FK | No | Reference to expense category |
| amount | Decimal(10,2) | - | Yes | Amount of expense |
| expense_date | Date | - | Yes | Date expense was made |
| payment_method | String(50) | - | Yes | How payment was made |
| description | String(255) | - | No | Additional details |

### Entity 6: SAVINGS_GOALS
**Description:** Financial savings goals for the family

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| goal_id | Integer | PK | Yes | Unique identifier for savings goal |
| goal_name | String(100) | - | Yes | Name of savings goal |
| target_amount | Decimal(10,2) | - | Yes | Target amount to save |
| current_amount | Decimal(10,2) | - | Yes | Current saved amount |
| start_date | Date | - | Yes | Date goal was created |
| target_date | Date | - | No | Target completion date |
| status | String(20) | - | Yes | Status of goal |
| description | String(255) | - | No | Additional details |

---

## RELATIONSHIPS

### Relationship 1: FAMILY_MEMBERS to INCOME
- **Name:** "receives" / "received by"
- **Entities:** FAMILY_MEMBERS (1) ——< INCOME (Many)
- **Type:** One-to-Many
- **Cardinality:** 
  - One family member can receive zero or many income entries (0..*)
  - Each income entry is received by zero or one family member (0..1)
- **Oracle Notation:** 
  - FAMILY_MEMBERS side: Single line with circle (optional one)
  - INCOME side: Crow's foot with circle (optional many)
- **Participation:**
  - FAMILY_MEMBERS: Optional (member can exist without income)
  - INCOME: Optional (income can exist without member reference)
- **Foreign Key:** member_id in INCOME references member_id in FAMILY_MEMBERS

### Relationship 2: INCOME_CATEGORIES to INCOME
- **Name:** "classifies" / "belongs to"
- **Entities:** INCOME_CATEGORIES (1) ——< INCOME (Many)
- **Type:** One-to-Many
- **Cardinality:**
  - One income category can have zero or many income entries (0..*)
  - Each income entry belongs to zero or one income category (0..1)
- **Oracle Notation:**
  - INCOME_CATEGORIES side: Single line with circle (optional one)
  - INCOME side: Crow's foot with circle (optional many)
- **Participation:**
  - INCOME_CATEGORIES: Optional (category can exist without income)
  - INCOME: Optional (income can exist without category)
- **Foreign Key:** income_category_id in INCOME references income_category_id in INCOME_CATEGORIES

### Relationship 3: FAMILY_MEMBERS to EXPENSES
- **Name:** "makes" / "made by"
- **Entities:** FAMILY_MEMBERS (1) ——< EXPENSES (Many)
- **Type:** One-to-Many
- **Cardinality:**
  - One family member can make zero or many expenses (0..*)
  - Each expense is made by zero or one family member (0..1)
- **Oracle Notation:**
  - FAMILY_MEMBERS side: Single line with circle (optional one)
  - EXPENSES side: Crow's foot with circle (optional many)
- **Participation:**
  - FAMILY_MEMBERS: Optional (member can exist without expenses)
  - EXPENSES: Optional (expense can exist without member reference)
- **Foreign Key:** member_id in EXPENSES references member_id in FAMILY_MEMBERS

### Relationship 4: EXPENSE_CATEGORIES to EXPENSES
- **Name:** "categorizes" / "belongs to"
- **Entities:** EXPENSE_CATEGORIES (1) ——< EXPENSES (Many)
- **Type:** One-to-Many
- **Cardinality:**
  - One expense category can have zero or many expenses (0..*)
  - Each expense belongs to zero or one expense category (0..1)
- **Oracle Notation:**
  - EXPENSE_CATEGORIES side: Single line with circle (optional one)
  - EXPENSES side: Crow's foot with circle (optional many)
- **Participation:**
  - EXPENSE_CATEGORIES: Optional (category can exist without expenses)
  - EXPENSES: Optional (expense can exist without category)
- **Foreign Key:** expense_category_id in EXPENSES references expense_category_id in EXPENSE_CATEGORIES

---

## ERD LAYOUT INSTRUCTIONS FOR DRAW.IO

### Step-by-Step Guide:

#### 1. Open Draw.io
- Go to https://app.diagrams.net/
- Select "Create New Diagram"
- Choose "Blank Diagram"

#### 2. Enable Entity-Relationship Shapes
- Click on "More Shapes" at the bottom of the left panel
- Check "Entity Relation" or "ER Diagram"
- Click "Apply"

#### 3. Create Entities (Rectangles)
Create six entity boxes with the following layout suggestion:

```
Top Row:
[INCOME_CATEGORIES]                    [EXPENSE_CATEGORIES]

Middle Row:
        [FAMILY_MEMBERS]

Lower-Middle Row:
[INCOME]                               [EXPENSES]

Bottom Row:
        [SAVINGS_GOALS]
```

#### 4. Add Attributes to Each Entity
For each entity, list all attributes inside the box:
- **Bold** or underline Primary Keys (PK)
- Mark Foreign Keys with (FK)
- Use format: attribute_name : data_type

Example for INCOME entity:
```
┌─────────────────────────┐
│        INCOME           │
├─────────────────────────┤
│ PK: income_id          │
│ FK: member_id          │
│ FK: income_category_id │
│     amount             │
│     income_date        │
│     description        │
└─────────────────────────┘
```

#### 5. Draw Relationships
Use the connector tool with crow's foot notation:

**Notation Symbols:**
- **One (mandatory):** Single line with perpendicular line |—
- **One (optional):** Single line with circle ○—
- **Many (mandatory):** Crow's foot with perpendicular line |<
- **Many (optional):** Crow's foot with circle ○<

**Draw these connections:**

1. **FAMILY_MEMBERS to INCOME**
   - From FAMILY_MEMBERS: ○— (optional one)
   - To INCOME: ○< (optional many)

2. **INCOME_CATEGORIES to INCOME**
   - From INCOME_CATEGORIES: ○— (optional one)
   - To INCOME: ○< (optional many)

3. **FAMILY_MEMBERS to EXPENSES**
   - From FAMILY_MEMBERS: ○— (optional one)
   - To EXPENSES: ○< (optional many)

4. **EXPENSE_CATEGORIES to EXPENSES**
   - From EXPENSE_CATEGORIES: ○— (optional one)
   - To EXPENSES: ○< (optional many)

#### 6. Label Relationships
Add text labels above/below each relationship line:
- FAMILY_MEMBERS ——< INCOME: "receives"
- INCOME_CATEGORIES ——< INCOME: "classifies"
- FAMILY_MEMBERS ——< EXPENSES: "makes"
- EXPENSE_CATEGORIES ——< EXPENSES: "categorizes"

#### 7. Add Title and Legend
- Add a title box at the top: "Family Budget System - ERD"
- Add your group information
- Add a legend explaining:
  - PK = Primary Key
  - FK = Foreign Key
  - Crow's foot notation symbols

#### 8. Formatting Tips
- Use consistent colors (e.g., light green for financial entities)
- Align entities neatly
- Keep relationship lines clean
- Use 12-14pt font for readability
- Export as PNG or PDF for submission

---

## CARDINALITY SUMMARY TABLE

| Relationship | Parent Entity | Child Entity | Parent Cardinality | Child Cardinality |
|-------------|---------------|--------------|-------------------|-------------------|
| Receives | FAMILY_MEMBERS | INCOME | 0..* (optional many) | 0..1 (optional one) |
| Classifies | INCOME_CATEGORIES | INCOME | 0..* (optional many) | 0..1 (optional one) |
| Makes | FAMILY_MEMBERS | EXPENSES | 0..* (optional many) | 0..1 (optional one) |
| Categorizes | EXPENSE_CATEGORIES | EXPENSES | 0..* (optional many) | 0..1 (optional one) |

---

## BUSINESS RULES REFLECTED IN ERD

1. **Income Tracking:** Family members receive income that is categorized, but income can exist without member or category assignment (optional relationships)

2. **Expense Tracking:** Family members make expenses that are categorized, but expenses can exist without member or category assignment (optional relationships)

3. **Category Independence:** Both income and expense categories can exist without any transactions, allowing categories to be set up before use

4. **Member Independence:** Family members can exist without income or expenses, allowing all family members to be registered even if they don't transact

5. **Savings Goals:** Savings goals are independent entities that don't directly relate to other entities in this simplified model (they represent household-level objectives)

---

## NORMALIZATION VERIFICATION

The ERD represents a database in **Third Normal Form (3NF)**:

### First Normal Form (1NF)
✓ All attributes contain atomic values  
✓ No repeating groups  
✓ Each table has a primary key

### Second Normal Form (2NF)
✓ In 1NF  
✓ No partial dependencies (all primary keys are single attributes)

### Third Normal Form (3NF)
✓ In 2NF  
✓ No transitive dependencies (foreign keys don't store derived data)

---

## ADDITIONAL NOTES

### Foreign Key Constraints
All foreign keys in the ERD have optional participation (NULL allowed):
- This allows flexibility in data entry
- Transactions can be recorded even if member/category is later deleted
- Categories and members can be set up before transactions occur

### Data Integrity
The ERD ensures:
- Referential integrity through foreign key relationships
- Entity integrity through primary keys
- Domain integrity through appropriate data types
- Flexibility for real-world budget scenarios

---

**Document Prepared By:** Family Budget System Team  
**Academic Institution:** Database Systems Course  
**Date:** November 2024

---

## SUBMISSION CHECKLIST

- [ ] ERD created in Draw.io or MS Visio
- [ ] All 6 entities included with complete attributes
- [ ] Primary keys clearly marked
- [ ] Foreign keys clearly marked
- [ ] All 4 relationships drawn with correct cardinality
- [ ] Crow's foot notation used correctly
- [ ] Relationship names added
- [ ] Mandatory/optional participation indicated
- [ ] Title and legend included
- [ ] Exported as high-resolution image or PDF
- [ ] ERD matches Business Information Requirements document
