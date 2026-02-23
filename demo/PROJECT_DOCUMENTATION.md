# Yash ColdDrinks - Project Documentation

> **A Web-Based Inventory & Business Management System for a Cold Drinks Distribution Shop**

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Terminology & Definitions](#2-terminology--definitions)
3. [Technology Stack](#3-technology-stack)
4. [Workspace File Structure](#4-workspace-file-structure)
5. [Database Schema](#5-database-schema)
6. [System Architecture](#6-system-architecture)
7. [Application Flow](#7-application-flow)
8. [Module-Wise Explanation](#8-module-wise-explanation)
9. [Authentication & Security](#9-authentication--security)
10. [Frontend Libraries Used](#10-frontend-libraries-used)
11. [How to Run the Project](#11-how-to-run-the-project)
12. [Development Progress](#12-development-progress)

---

## 1. Project Overview

**Yash ColdDrinks** is a web-based business management system built for a cold drinks distribution shop. The application helps the shop owner (admin) manage day-to-day operations including:

- **Stock/Inventory Management** — Track purchased stock from agencies (distributors)
- **Sales & Billing** — Create sell receipts and manage counter-based billing
- **Payment Tracking** — Monitor paid, unpaid, and partial payments to agencies
- **Expense Management** — Record and categorize business expenses
- **Salary Management** — Manage employee salaries and payment history
- **Audit & Reporting** — View financial summaries with charts and analytics
- **Order Management** — Track online/customer orders with status tracking
- **Account Management** — Manage admin/manager/staff user accounts

The system follows a **client-server architecture** using PHP as the backend, MySQL (MariaDB) as the database, and a modern responsive UI built with Tailwind CSS.

---

## 2. Terminology & Definitions

| Term | Definition |
|------|-----------|
| **XAMPP** | A free, open-source cross-platform web server solution stack containing Apache HTTP Server, MariaDB database, and PHP interpreter. Used to host this project locally. |
| **PHP** | *Hypertext Preprocessor* — A server-side scripting language used for web development. Handles all backend logic in this project. |
| **MySQL / MariaDB** | A relational database management system (RDBMS) used to store and manage all application data (stocks, bills, expenses, etc.). |
| **Tailwind CSS** | A utility-first CSS framework for rapidly building custom user interfaces without writing traditional CSS. |
| **jQuery** | A fast, lightweight JavaScript library that simplifies HTML DOM manipulation, AJAX calls, and event handling. |
| **AJAX** | *Asynchronous JavaScript and XML* — A technique for sending/receiving data from the server without refreshing the entire page. Used extensively for form submissions. |
| **DataTables** | A jQuery plugin that adds advanced features (search, sort, pagination) to HTML tables. |
| **Alpine.js** | A lightweight JavaScript framework for adding interactivity (dropdowns, modals, toggles) directly in HTML markup. |
| **Toastr** | A JavaScript library for showing non-blocking notification pop-ups (success, error, info messages). |
| **SweetAlert2** | A beautiful, responsive, customizable replacement for JavaScript's popup alert boxes. |
| **Lucide Icons** | An open-source icon library providing clean, consistent SVG icons used throughout the UI. |
| **AOS (Animate On Scroll)** | A CSS animation library that triggers animations when elements scroll into view. |
| **Chart.js** | A JavaScript charting library used to render bar charts and doughnut charts in the Audit Dashboard. |
| **Session** | A server-side mechanism to store user information (login state, role) across multiple page requests. |
| **MD5** | A cryptographic hash function used here to hash user passwords before storing in the database. |
| **CRUD** | *Create, Read, Update, Delete* — The four basic operations performed on database records. |
| **Stock** | Inventory of cold drink products (boxes) purchased from agencies/distributors. |
| **Agency** | A distributor/supplier from whom cold drinks are purchased (e.g., Coca-Cola Distributors, PepsiCo Agency). |
| **Counter** | A point-of-sale station in the shop where products are sold to customers. |
| **Bill** | A sales receipt generated when products are sold to a customer from a counter. |
| **Scheme** | Promotional offers where bonus bottles are given free with a purchase (e.g., buy X get Y free). |
| **Payment Status** | Tracks whether a stock purchase or bill has been *Paid*, *Unpaid*, or *Partially Paid*. |
| **Audit** | A financial review showing total sales, expenses, profit, and cash flow analytics. |

---

## 3. Technology Stack

| Layer | Technology | Purpose |
|-------|-----------|---------|
| **Server** | XAMPP (Apache) | Hosts the PHP application locally |
| **Backend** | PHP 8.x | Server-side logic, database queries, session management |
| **Database** | MariaDB 10.4 (MySQL) | Data storage and retrieval |
| **Frontend** | HTML5, Tailwind CSS | Page structure and responsive styling |
| **Interactivity** | jQuery, Alpine.js | DOM manipulation, AJAX, UI components |
| **Tables** | DataTables 2.3.0 | Sortable, searchable, paginated data tables |
| **Notifications** | Toastr, SweetAlert2 | User feedback messages and alerts |
| **Icons** | Lucide Icons | Scalable vector icons |
| **Charts** | Chart.js | Data visualization (bar, doughnut charts) |
| **Animations** | AOS, CSS Keyframes | Scroll and page-load animations |

---

## 4. Workspace File Structure

```
YashColdrinks/demo/
│
├── dbconnection.php              # Database connection configuration
├── yashcoldrinks_demo.sql        # Full database export (SQL dump for setup)
├── PROJECT_DOCUMENTATION.md      # This documentation file
│
├── admin/                        # Admin panel (main application)
│   ├── adminlogin.php            # Login page (mobile + password authentication)
│   ├── index.php                 # Dashboard - stock overview & progress tracker
│   ├── functions.php             # Backend API - all PHP functions & AJAX handler
│   ├── addStock.php              # Add new stock purchases from agencies
│   ├── viewstocks.php            # View all stock with payment management
│   ├── sellReceipt.php           # Create sales receipts (billing page)
│   ├── sellDashboard.php         # Payment management for bills
│   ├── order_management.php      # Online order tracking & management
│   ├── expense.php               # Expense tracking & recording
│   ├── salary.php                # Employee salary management
│   ├── audit.php                 # Financial audit dashboard with charts
│   ├── updateList.php            # Manage product, agency & counter lists
│   ├── account.php               # Admin/manager account management
│   ├── logout.php                # Session destruction & redirect
│   ├── logout_modal.php          # Animated logout confirmation page
│   ├── output.css                # Compiled Tailwind CSS stylesheet
│   │
│   └── layouts/
│       └── sidebar.php           # Shared sidebar navigation component
│
└── assets/
    ├── images/
    │   └── logo.png              # Application logo
    └── js/
        └── jquery.js             # Local jQuery fallback
```

### File Categorization

| Category | Files | Description |
|----------|-------|-------------|
| **Configuration** | `dbconnection.php` | Database credentials & connection setup |
| **Database** | `yashcoldrinks_demo.sql` | Complete SQL dump to recreate the database |
| **Authentication** | `adminlogin.php`, `logout.php`, `logout_modal.php` | Login/logout flow |
| **Backend API** | `functions.php` | Centralized PHP function handler (switch-case router) |
| **Dashboard** | `index.php` | Main landing page after login |
| **Stock Module** | `addStock.php`, `viewstocks.php` | Inventory management (fully functional) |
| **Sales Module** | `sellReceipt.php`, `sellDashboard.php` | Billing and payment (UI demo) |
| **Orders Module** | `order_management.php` | Online order tracking (UI demo) |
| **Finance Module** | `expense.php`, `salary.php`, `audit.php` | Financial management (UI demo) |
| **Settings** | `updateList.php`, `account.php` | Master data & user management (UI demo) |
| **Layout** | `layouts/sidebar.php` | Reusable navigation sidebar |
| **Assets** | `output.css`, `logo.png`, `jquery.js` | Static resources |

---

## 5. Database Schema

The database `yashcoldrinks_demo` contains **12 tables**:

### Core Tables

| Table | Purpose | Key Columns |
|-------|---------|-------------|
| `admin` | Store admin/manager user accounts | `id`, `username`, `password` (MD5), `mobile`, `role` |
| `stock` | Current stock inventory purchased from agencies | `id`, `productname`, `quantity`, `bottles`, `totalbottles`, `priceperbox`, `totalbillamount`, `paid_amount`, `payment_status`, `payment_mode`, `agencyname`, `buydate` |
| `totalstocksadded` | Audit log of all stock additions (historical copy of `stock`) | Same columns as `stock` |
| `productlist` | Master list of available products | `id`, `productname` |
| `agencylist` | Master list of supplier agencies | `id`, `agencyName` |
| `counterlist` | Master list of sale counters | `id`, `counterName` |

### Sales & Billing Tables

| Table | Purpose | Key Columns |
|-------|---------|-------------|
| `bills` | Sales bill header records | `id`, `counter_name`, `total_bill_amount`, `paid_amount`, `payment_status`, `bill_date`, `customer_name`, `customer_phone` |
| `bill_items` | Individual items within a bill | `id`, `bill_id` (FK → bills), `productname`, `quantity`, `scheme`, `schemebottles`, `priceperbox`, `totalamount` |
| `sell` | Sales transaction records | `id`, `bill_id`, `productname`, `quantity`, `scheme`, `priceperbox`, `totalbillamount`, `countername`, `paymentmethod` |
| `payments` | Payment records against bills | `id`, `bill_id` (FK → bills), `amount_paid`, `payment_method`, `payment_type`, `payment_date` |

### Other Tables

| Table | Purpose | Key Columns |
|-------|---------|-------------|
| `orders` | Customer online orders | `id`, `customer_name`, `phone`, `address`, `total_amount`, `status`, `order_date` |
| `order_items` | Items within each order | `id`, `order_id` (FK), `product_id`, `quantity`, `price` |
| `products` | Product catalog with descriptions | `id`, `name`, `description`, `price`, `category`, `stock_quantity`, `is_active` |
| `expenses` | Business expense records | `id`, `expense_date`, `expense_type`, `amount`, `description` |

### Sample Data Included

| Product | Stock (Boxes) | Price/Box | Agency |
|---------|--------------|-----------|--------|
| ThumsUp-250 | 20 | ₹520 | Coca-Cola Distributors |
| Sprite-250 | 15 | ₹500 | Coca-Cola Distributors |
| Fanta-250 | 10 | ₹480 | PepsiCo Agency |
| Coca-Cola-250 | 25 | ₹520 | Local Traders |
| Limca-250 | 12 | ₹460 | Coca-Cola Distributors |
| Maaza-250 | 18 | ₹540 | PepsiCo Agency |

---

## 6. System Architecture

The project uses a **three-tier architecture**:

```
┌─────────────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER (Frontend)                │
│                                                                 │
│   Browser (HTML + Tailwind CSS + jQuery + Alpine.js)            │
│   ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐         │
│   │Dashboard │ │Add Stock │ │View Stock│ │ Receipt  │  ...     │
│   └────┬─────┘ └────┬─────┘ └────┬─────┘ └────┬─────┘         │
│        │             │            │             │               │
│        └─────────────┴────────────┴─────────────┘               │
│                          │ AJAX ($.post)                        │
├──────────────────────────┼──────────────────────────────────────┤
│                    APPLICATION LAYER (Backend)                  │
│                          ▼                                      │
│              ┌──────────────────────┐                           │
│              │   functions.php      │   ← Central API Router   │
│              │   (Switch-Case)      │                           │
│              ├──────────────────────┤                           │
│              │ LOGIN                │                           │
│              │ GET_TOTAL_STOCK      │                           │
│              │ INSERT_STOCK         │                           │
│              │ GET_PRODUCT_NAME     │                           │
│              │ GET_AGENCY_NAME      │                           │
│              │ UPDATE_STOCK_PAYMENT │                           │
│              │ GET_PAYMENT_DETAILS  │                           │
│              │ ...more cases        │                           │
│              └──────────┬───────────┘                           │
│                         │ MySQLi (Prepared Statements)          │
├─────────────────────────┼───────────────────────────────────────┤
│                    DATA LAYER (Database)                        │
│                         ▼                                       │
│              ┌──────────────────────┐                           │
│              │  MariaDB / MySQL     │                           │
│              │  yashcoldrinks_demo  │                           │
│              ├──────────────────────┤                           │
│              │ admin  │ stock       │                           │
│              │ bills  │ sell        │                           │
│              │ orders │ expenses    │                           │
│              │ products│ payments   │                           │
│              └──────────────────────┘                           │
└─────────────────────────────────────────────────────────────────┘
```

### How Data Flows

1. **User interacts** with the frontend (clicks a button, fills a form)
2. **jQuery AJAX** sends a POST request to `functions.php` with a `RESULT_TYPE` parameter
3. **`functions.php`** uses a `switch-case` to route the request to the correct PHP function
4. The PHP function **executes a prepared SQL statement** against the MariaDB database
5. Results are **returned as JSON** to the frontend
6. **jQuery processes** the JSON response and updates the UI (tables, notifications, etc.)

---

## 7. Application Flow

### 7.1 Authentication Flow

```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│   User opens │     │  Login Page  │     │  functions.php│     │   Database   │
│   any page   │────▶│ adminlogin   │────▶│  LOGIN case  │────▶│ admin table  │
│              │     │  .php        │     │  MD5 hash    │     │ verify creds │
└──────────────┘     └──────────────┘     └──────────────┘     └──────┬───────┘
                                                                      │
                     ┌──────────────┐     ┌──────────────┐           │
                     │  Dashboard   │◀────│  Session Set │◀──────────┘
                     │  index.php   │     │  USERNAME,   │     (result: 1 = success)
                     │              │     │  ROLE stored │
                     └──────────────┘     └──────────────┘
```

- User enters **mobile number** and **password**
- Password is hashed with **MD5** and compared against database
- On success, **session variables** are set (`USERNAME`, `ROLE`, `LOGIN`)
- User is redirected to **Dashboard** (`index.php`)
- Every page checks `$_SESSION` — unauthenticated users are redirected to login

### 7.2 Stock Management Flow

```
Admin ──▶ Add Stock Page ──▶ Fill Form (Product, Qty, Price, Agency, Payment)
                │
                ▼
         AJAX POST to functions.php
         RESULT_TYPE: "INSERT_STOCK"
                │
                ▼
         ┌─────────────────────────────────┐
         │  1. Calculate total bottles     │
         │  2. Determine payment status    │
         │     - Cash/PhonePe → "Paid"     │
         │     - Partial → "Partial"       │
         │     - Unpaid → "Unpaid"         │
         │  3. INSERT into `stock` table   │
         │  4. INSERT into `totalstocks    │
         │     added` (audit log)          │
         └─────────────┬───────────────────┘
                       │
                       ▼
         Toastr notification: "Data inserted successfully!"
         DataTable refreshes with new data
```

### 7.3 Payment Update Flow

```
View Stock Page ──▶ Click "Pay" button on Unpaid/Partial row
        │
        ▼
  Payment Modal opens (shows remaining amount)
        │
        ▼
  Admin enters amount & selects payment method
        │
        ▼
  AJAX POST → RESULT_TYPE: "UPDATE_STOCK_PAYMENT"
        │
        ▼
  ┌────────────────────────────────────┐
  │  1. Fetch current paid_amount     │
  │  2. Add new payment amount        │
  │  3. Update payment_mode (append)  │
  │  4. Recalculate status:           │
  │     new_paid == total → "Paid"    │
  │     new_paid > 0     → "Partial"  │
  │     new_paid == 0    → "Unpaid"   │
  │  5. UPDATE `stock` table          │
  └────────────────────────────────────┘
        │
        ▼
  Table refreshes with updated payment info
```

### 7.4 Overall Page Navigation Flow

```
        ┌─────────────────┐
        │  Admin Login     │
        │  (adminlogin.php)│
        └────────┬────────┘
                 │ (on successful login)
                 ▼
        ┌─────────────────┐
        │   Dashboard      │◀──────────────────────────────────┐
        │   (index.php)    │                                    │
        └────────┬────────┘                                    │
                 │                                              │
     ┌───────────┼───────────┬───────────┬──────────┐          │
     ▼           ▼           ▼           ▼          ▼          │
┌─────────┐ ┌─────────┐ ┌─────────┐ ┌────────┐ ┌────────┐    │
│View     │ │Add      │ │Sell     │ │Payment │ │Online  │    │
│Stock    │ │Stock    │ │Receipt  │ │Mgmt    │ │Orders  │    │
└─────────┘ └─────────┘ └─────────┘ └────────┘ └────────┘    │
                                                               │
     ┌───────────┬───────────┬───────────┬──────────┐          │
     ▼           ▼           ▼           ▼          ▼          │
┌─────────┐ ┌─────────┐ ┌─────────┐ ┌────────┐ ┌────────┐    │
│Expenses │ │Salary   │ │Audit    │ │Manage  │ │Admin   │    │
│         │ │Mgmt     │ │Report   │ │Lists   │ │Accounts│    │
└─────────┘ └─────────┘ └─────────┘ └────────┘ └────────┘    │
                                                               │
     ┌──────────────────┐                                      │
     │ Logout Modal     │──────▶ Session Destroy ──▶ Login ────┘
     │ (logout_modal)   │
     └──────────────────┘
```

---

## 8. Module-Wise Explanation

### 8.1 Login Module (`adminlogin.php`)
- Beautiful split-screen login page with branding
- Authentication via **mobile number + password**
- Password hashed with MD5 before database comparison
- Supports **Enter key** to submit and **password visibility toggle**
- Role-based access control (admin, manager, staff)

### 8.2 Dashboard (`index.php`)
- Shows **total stock overview** (grouped by product name, with box counts)
- Fetches data via AJAX from `GET_TOTAL_STOCK_DASHBOARD`
- Displays development **progress bar** (30% complete)
- Includes **dark mode toggle** with `localStorage` persistence
- Placeholder cards for Today's Sales and Today's Earnings (coming soon)

### 8.3 Add Stock Module (`addStock.php`) — *Fully Functional*
- Form with dropdowns for **Product Name** and **Agency Name** (loaded from DB)
- Input fields: Quantity (boxes), Bottles per Box, Price per Box
- **Auto-calculates** Total Bill Amount (Quantity × Price per Box)
- Payment modes: Cash, PhonePe, Partial-Cash, Partial-PhonePe, Unpaid
- Partial payment reveals an additional input field for the partial amount
- Data inserted into both `stock` and `totalstocksadded` tables
- Below the form: **DataTable** showing all previously added stock records

### 8.4 View Stock Module (`viewstocks.php`) — *Fully Functional*
- Displays all stock data in a searchable, sortable **DataTable**
- Columns: ID, Product, Quantity, Total Bill, Paid Amount, Payment Status, Agency, Actions, Buy Date
- **Pay button** opens a modal for making payments on Unpaid/Partial records
- **View button** shows detailed payment information in a modal
- Supports **incremental payments** (multiple partial payments tracked)
- Payment methods can be combined (e.g., Cash + PhonePe)

### 8.5 Sell Receipt Module (`sellReceipt.php`) — *UI Demo*
- Multi-item billing interface for selling products from counters
- Select product, quantity, scheme (promotional offer), and price
- Scheme field allows tracking bonus bottles given with purchase
- Bill summary with counter selection and payment method
- Sales history table showing recent transactions

### 8.6 Payment Management (`sellDashboard.php`) — *UI Demo*
- Overview of all bills with payment status badges (Paid/Partial/Unpaid)
- Payment history summary cards: Total Bills, Total Amount, Pending Amount
- Action buttons to view individual bill details

### 8.7 Order Management (`order_management.php`) — *UI Demo*
- Order cards with color-coded status borders:
  - Yellow = Pending, Blue = Processing, Purple = Shipped, Green = Delivered
- Stats cards showing counts per status category
- Order details with customer info, products, phone number, and amount

### 8.8 Expense Management (`expense.php`) — *UI Demo*
- Form to add expenses with Date, Type, Amount, and Description
- Filter buttons: Today, This Week, This Month, All Expenses
- DataTable of expense records with delete actions
- Expense types: Supplies, Utilities, Rent, Transport, etc.

### 8.9 Salary Management (`salary.php`) — *UI Demo*
- Stats cards: Total Employees, Active, Monthly Payroll, Paid This Month
- Employee table with Name, Role, Monthly Salary, Status, Last Paid
- Salary payment history table
- Add Employee and Pay/Edit action buttons

### 8.10 Audit Dashboard (`audit.php`) — *UI Demo*
- Financial overview cards: Total Sales, Net Profit, Total Expenses, Cash Flow
- **Bar Chart** (Chart.js): Sales vs Expenses comparison by month
- **Doughnut Chart** (Chart.js): Category-wise expense breakdown
- Recent transactions table with type badges (Sale, Purchase, Expense, Salary)
- Period filter: This Month, Last Month, This Quarter, This Year

### 8.11 Manage Lists (`updateList.php`) — *UI Demo*
- Add/manage master data entries:
  - **Products** (e.g., ThumsUp-250, Sprite-250)
  - **Agencies** (e.g., Coca-Cola Distributors, PepsiCo Agency)
  - **Counters** (e.g., Counter 1, Counter 2)
- Three-column layout with input fields and DataTables

### 8.12 Account Management (`account.php`) — *UI Demo*
- Manage admin, manager, and staff accounts
- Table showing: ID, Username, Mobile, Role, Actions
- Modal form to add new accounts with role selection
- Edit and Delete actions for existing accounts

### 8.13 Sidebar (`layouts/sidebar.php`)
- Shared navigation component included in all admin pages
- Shows logged-in user info (username, role) with logo
- Menu organized into sections: Main Menu, Sales & Billing, Reports & Settings
- **Active page highlighting** using JavaScript URL detection
- Mobile-responsive with toggle button (Alpine.js)
- Logout button at the bottom

---

## 9. Authentication & Security

| Feature | Implementation |
|---------|---------------|
| **Login** | Mobile number + MD5 hashed password verified against `admin` table |
| **Session Management** | PHP `$_SESSION` stores `LOGIN`, `USERID`, `USERNAME`, `ROLE` |
| **Page Protection** | Every page checks session at the top; redirects to login if not authenticated |
| **Role-Based Access** | `admin` and `manager` can access Dashboard & Add Stock; `admin` only for View Stock, Settings |
| **Password Storage** | MD5 hash (Note: MD5 is used for demo; `bcrypt`/`password_hash()` is recommended for production) |
| **SQL Injection Prevention** | Prepared statements with `bind_param()` used for all database queries |
| **AJAX Security** | All AJAX calls use POST method; no sensitive data in URLs |

---

## 10. Frontend Libraries Used

| Library | Version | CDN Source | Purpose |
|---------|---------|-----------|---------|
| Tailwind CSS | v4 | Compiled locally (`output.css`) | Responsive UI styling |
| jQuery | 3.7.1 | `code.jquery.com` | DOM manipulation & AJAX |
| DataTables | 2.3.0 | `cdn.datatables.net` | Advanced data tables |
| Alpine.js | 3.x | `cdn.jsdelivr.net` | Reactive UI components |
| Toastr | Latest | `cdnjs.cloudflare.com` | Toast notifications |
| SweetAlert2 | 11 | `cdn.jsdelivr.net` | Dialog popups |
| Lucide Icons | Latest | `unpkg.com` | SVG icon library |
| AOS | 2.3.4 | `unpkg.com` | Scroll animations |
| Chart.js | Latest | `cdn.jsdelivr.net` | Data charts |

---

## 11. How to Run the Project

### Prerequisites
- **XAMPP** installed with Apache and MySQL running
- A web browser (Chrome, Firefox, Edge)

### Setup Steps

1. **Copy the project folder** to `C:\xampp\htdocs\YashColdrinks\demo\`

2. **Start XAMPP** — Enable Apache and MySQL services

3. **Import the database:**
   - Open `http://localhost/phpmyadmin`
   - Create a new database named `yashcoldrinks_demo` (or let the SQL file create it)
   - Import the file `yashcoldrinks_demo.sql`

4. **Access the application:**
   - Open `http://localhost/YashColdrinks/demo/admin/adminlogin.php`

5. **Login credentials:**
   - Mobile: `1234567890`
   - Password: `123`

### Database Connection Configuration
File: `dbconnection.php`
```php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "yashcoldrinks_demo";
```

---

## 12. Development Progress

| Module | Status | Backend | Frontend |
|--------|--------|---------|----------|
| Admin Login & Authentication | ✅ Complete | ✅ | ✅ |
| Dashboard with Stock Overview | ✅ Complete | ✅ | ✅ |
| Add Stock Module | ✅ Complete | ✅ | ✅ |
| View Stock & Payment Tracking | ✅ Complete | ✅ | ✅ |
| Sell Receipt / Billing | 🟡 UI Only | ❌ | ✅ |
| Payment Management | 🟡 UI Only | ❌ | ✅ |
| Online Order Management | 🟡 UI Only | ❌ | ✅ |
| Expense Management | 🟡 UI Only | ❌ | ✅ |
| Salary Management | 🟡 UI Only | ❌ | ✅ |
| Audit Dashboard | 🟡 UI Only | ❌ | ✅ |
| Manage Lists (Products/Agencies/Counters) | 🟡 UI Only | ❌ | ✅ |
| Account Management | 🟡 UI Only | ❌ | ✅ |
| Logout System | ✅ Complete | ✅ | ✅ |

**Overall Progress: ~30% backend complete | 100% frontend UI complete**

---

## Diagrams

> The following diagrams are described in Mermaid syntax and are also rendered below the documentation. They illustrate the Entity-Relationship model, system flow, and request lifecycle.

### Entity-Relationship Overview (see rendered diagrams)
### Application Flow (see rendered diagrams)
### AJAX Request Lifecycle (see rendered diagrams)

---

*Project: ColdDrinks — Web-Based Business Management System*
*Technology: PHP, MySQL (MariaDB), Tailwind CSS, jQuery, XAMPP*



