# 🥤 YashColdrinks - Cold Drinks E-Commerce Platform

A comprehensive web-based e-commerce platform for managing and selling cold drinks, built with PHP and modern web technologies. This project features a complete admin panel for inventory management, order processing, expense tracking, and a customer-facing storefront.

![Project Status](https://img.shields.io/badge/status-active-success.svg)
![PHP](https://img.shields.io/badge/PHP-7.4+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC.svg)

## 📋 Table of Contents
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Screenshots](#screenshots)
- [Database Schema](#database-schema)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### Customer Features
- 🛍️ **Product Browsing**: Browse through a variety of cold drinks with detailed product pages
- 🛒 **Shopping Cart**: Add/remove items, update quantities with real-time cart management
- 📦 **Order Placement**: Simple and intuitive checkout process
- 🔍 **Product Search**: Find your favorite drinks quickly
- 📱 **Responsive Design**: Mobile-friendly interface built with TailwindCSS
- 🎨 **Modern UI/UX**: Smooth animations and interactive elements

### Admin Features
- 📊 **Dashboard**: Comprehensive analytics and business overview
- 📦 **Stock Management**: Add, update, and track inventory levels
- 🛍️ **Order Management**: Process and manage customer orders
- 💰 **Expense Tracking**: Monitor business expenses and maintain financial records
- 📈 **Sales Dashboard**: Real-time sales analytics and reporting
- 🧾 **Receipt Generation**: Generate and print sales receipts
- 👥 **Account Management**: Manage admin accounts and user roles
- 📋 **Audit Logs**: Track all system activities for accountability

## 🛠️ Tech Stack

### Backend
- **PHP** - Server-side scripting
- **MySQL** - Database management
- **XAMPP** - Local development environment

### Frontend
- **HTML5 & CSS3** - Structure and styling
- **TailwindCSS** - Utility-first CSS framework
- **JavaScript** - Client-side interactivity
- **jQuery** - DOM manipulation and AJAX
- **Alpine.js** - Lightweight JavaScript framework
- **Toastr.js** - Notification library
- **DataTables.js** - Advanced table management
- **Font Awesome** - Icon library
- **Lucide Icons** - Modern icon set

## 📁 Project Structure

```
YashColdrinks/
├── admin/                      # Admin panel
│   ├── dashboard.php          # Main admin dashboard
│   ├── sellDashboard.php      # Sales dashboard
│   ├── order_management.php   # Order processing
│   ├── viewstocks.php         # Stock viewing
│   ├── addStock.php           # Add new stock
│   ├── expense.php            # Expense management
│   ├── audit.php              # Audit logs
│   ├── account.php            # Account settings
│   ├── adminlogin.php         # Admin login
│   ├── sellReceipt.php        # Receipt generation
│   ├── functions.php          # Backend functions
│   ├── layouts/               # Admin layout components
│   │   └── sidebar.php        # Sidebar navigation
│   ├── js/                    # Admin JavaScript files
│   └── image/                 # Admin images
│
├── css/                        # Stylesheets
├── js/                        # JavaScript files
│   ├── cart.js                # Shopping cart logic
│   └── jquery.js              # jQuery library
│
├── image/                      # Product images
│   ├── cocacola2500.png
│   ├── fanta750.png
│   ├── sprite750.png
│   ├── thumsup750.png
│   ├── frooti750.png
│   └── heroBackground.png
│
├── icons/                      # Icon assets
├── Backups/                    # Database backups
│   └── yashcoldrinks.sql
│
├── index.php                   # Homepage
├── all-products.php           # Product listing page
├── product.php                # Individual product page
├── cart.php                   # Shopping cart page
├── cart_action.php            # Cart operations handler
├── order_success.php          # Order confirmation page
├── header.php                 # Header component
├── footer.php                 # Footer component
├── dbconnection.php           # Database connection
├── functions.php              # Core functions
└── README.md                  # Project documentation
```

## 🚀 Installation

### Prerequisites
- XAMPP (or similar LAMP/WAMP stack)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Node.js and npm (for TailwindCSS compilation)
- Web browser (Chrome, Firefox, Edge, etc.)

### Step-by-Step Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/YashColdrinks.git
   cd YashColdrinks
   ```

2. **Move to XAMPP htdocs**
   ```bash
   # Copy the project to your XAMPP htdocs folder
   # Windows: C:\xampp\htdocs\YashColdrinks
   # Linux/Mac: /opt/lampp/htdocs/YashColdrinks
   ```

3. **Import Database**
   - Start XAMPP and run Apache & MySQL
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create a new database named `yashcoldrinks`
   - Import the SQL file from `Backups/yashcoldrinks.sql`

4. **Configure Database Connection**
   - Open `dbconnection.php`
   - Update credentials if needed:
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "yashcoldrinks";
   ```

5. **Install Dependencies (Optional - for TailwindCSS development)**
   ```bash
   npm install
   npm run build
   ```

6. **Access the Application**
   - Customer Site: `http://localhost/YashColdrinks/`
   - Admin Panel: `http://localhost/YashColdrinks/admin/`

## ⚙️ Configuration

### Default Admin Credentials
After importing the database, use these credentials to access the admin panel:
- **URL**: `http://localhost/YashColdrinks/admin/adminlogin.php`
- **Username**: Check your database `admin_users` table
- **Password**: Check your database (should be hashed)

> ⚠️ **Security Note**: Change default credentials immediately after first login!

### TailwindCSS Configuration
The project uses TailwindCSS for styling. Configuration file is located at `tailwind.config.js`.

To rebuild CSS after changes:
```bash
npm run build
```

## 📱 Usage

### For Customers
1. Browse products on the homepage
2. Click on any product to view details
3. Add items to cart
4. Review cart and proceed to checkout
5. Complete order and receive confirmation

### For Administrators
1. Login to admin panel
2. View dashboard for business overview
3. Manage stock levels through Stock Management
4. Process orders through Order Management
5. Track expenses and generate reports
6. View sales analytics on Sales Dashboard
7. Generate receipts for completed orders

## 🎨 Screenshots

### Customer Interface
- Modern, responsive homepage with hero section
- Product catalog with search functionality
- Interactive shopping cart
- Smooth checkout process

### Admin Panel
- Comprehensive dashboard with analytics
- Intuitive stock management interface
- Order processing system
- Financial tracking and reporting

## 🗄️ Database Schema

The project uses a MySQL database with the following main tables:
- `products` - Product information and inventory
- `orders` - Customer order records
- `order_items` - Individual items in orders
- `admin_users` - Admin authentication
- `expenses` - Business expense tracking
- `audit_logs` - System activity logs

## 👨‍💻 My Work & Contributions

This project represents my work in building a full-stack e-commerce solution with the following key implementations:

### Technical Achievements
- ✅ Developed complete CRUD operations for inventory management
- ✅ Implemented secure session-based authentication system
- ✅ Created responsive UI using TailwindCSS and modern CSS techniques
- ✅ Built dynamic shopping cart with AJAX functionality
- ✅ Integrated real-time notifications using Toastr.js
- ✅ Designed and implemented normalized database schema
- ✅ Developed comprehensive admin dashboard with analytics
- ✅ Implemented expense tracking and financial reporting system
- ✅ Created receipt generation and printing functionality
- ✅ Added audit logging for security and accountability

### Design & User Experience
- 🎨 Modern, clean interface with smooth animations
- 📱 Mobile-first responsive design
- ⚡ Fast, interactive user experience
- 🎯 Intuitive navigation and user flow
- 🖼️ Professional product image management

### Code Quality
- 📝 Modular, reusable PHP functions
- 🔒 SQL injection prevention with prepared statements
- 🧩 Component-based architecture (header, footer, sidebar)
- 📊 Efficient database queries and optimization
- 🛡️ Input validation and sanitization

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 📞 Contact

**Developer**: Tejas  
**Project Link**: [https://github.com/YOUR_USERNAME/YashColdrinks](https://github.com/YOUR_USERNAME/YashColdrinks)

---

⭐ **If you find this project useful, please consider giving it a star!**

Built with ❤️ using PHP, MySQL, and TailwindCSS
