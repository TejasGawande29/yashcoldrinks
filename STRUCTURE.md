# YashColdrinks - Project Structure

## Overview
This is an e-commerce website for cold drinks with a customer-facing website and admin panel.

## Folder Structure

```
YashColdrinks/
├── config/                     # Global configuration
│   └── database.php            # Database connection
│
├── customer/                   # Customer-facing website
│   ├── index.php               # Homepage
│   ├── includes/               # Reusable components
│   │   ├── config.php          # Customer config (paths, session)
│   │   ├── header.php          # Navigation header
│   │   ├── footer.php          # Footer component
│   │   └── functions.php       # Helper functions
│   ├── pages/                  # Customer pages
│   │   ├── all-products.php    # Product listing
│   │   ├── cart.php            # Shopping cart
│   │   ├── product.php         # Product detail
│   │   └── order_success.php   # Order confirmation
│   └── ajax/                   # AJAX handlers
│       └── cart_action.php     # Cart operations
│
├── admin/                      # Admin panel
│   ├── index.php               # Admin dashboard entry
│   ├── adminlogin.php          # Login page
│   ├── includes/               # Reusable admin components
│   │   ├── config.php          # Admin config
│   │   ├── functions.php       # API functions
│   │   ├── functionsmy.php     # Additional functions
│   │   └── sidebar.php         # Sidebar navigation
│   ├── pages/                  # Admin pages
│   │   ├── dashboard.php       # Dashboard
│   │   ├── addStock.php        # Add inventory
│   │   ├── viewstocks.php      # View inventory
│   │   ├── account.php         # Account management
│   │   └── ...                 # Other admin pages
│   └── assets/                 # Admin-specific assets
│       ├── css/
│       └── js/
│
├── assets/                     # Shared assets
│   ├── css/                    # Stylesheets
│   │   └── output.css          # Compiled Tailwind CSS
│   ├── js/                     # JavaScript files
│   │   ├── jquery.js
│   │   └── cart.js
│   ├── images/                 # Product & site images
│   └── icons/                  # Icon files
│
├── redirects/                  # Backward compatibility redirects
│   ├── all-products.php
│   ├── cart.php
│   ├── product.php
│   └── order_success.php
│
├── Backups/                    # Database backups
│   └── yashcoldrinks.sql
│
├── src/                        # Source files (Tailwind)
│   └── input.css
│
└── index.php                   # Root redirect to customer site
```

## URLs

### Customer Website
- **Home**: `/YashColdrinks/customer/index.php`
- **Products**: `/YashColdrinks/customer/pages/all-products.php`
- **Cart**: `/YashColdrinks/customer/pages/cart.php`
- **Product Detail**: `/YashColdrinks/customer/pages/product.php?id=X`

### Admin Panel
- **Login**: `/YashColdrinks/admin/adminlogin.php`
- **Dashboard**: `/YashColdrinks/admin/dashboard.php`

## Configuration

### Database
Edit `config/database.php` to update database credentials:
```php
$servername = "localhost";
$username = "root";
$password = "";
$database = "yashcoldrinks";
```

### Path Constants
Both admin and customer sections use configuration files with path constants:
- `customer/includes/config.php`
- `admin/includes/config.php`

Constants available:
- `BASE_URL` - Root URL of the project
- `CUSTOMER_URL` - Customer section URL
- `ADMIN_URL` - Admin section URL
- `ASSETS_URL` - Shared assets URL

## Development

### Build CSS (Tailwind)
```bash
npm run build
```

### Watch Mode
```bash
npm run watch
```

## Admin Credentials
- **Mobile**: 9405416771
- **Password**: 123

## Technology Stack
- PHP 7.4+
- MySQL/MariaDB
- TailwindCSS v4
- jQuery
- Alpine.js
- Font Awesome
- Toastr.js (notifications)
- DataTables.js

## Author
Designed & Developed by Tejas Gawande
