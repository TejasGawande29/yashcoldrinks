# 🚀 InfinityFree Deployment Guide - YashColdrinks

## ✅ Pre-Deployment Checklist (Completed)

- [x] Removed test files (debug_netprofit.php, e2e_test.php, test_login.php, test_audit_functions.php)
- [x] Removed development files (gpt.html, index copy.php)
- [x] Removed incomplete downloads (.crdownload files)
- [x] Updated .gitignore
- [x] Verified database connection
- [x] Tested project locally on http://localhost:8000

## 📦 Files Ready for Upload

Your project is cleaned and ready! Total files: ~50MB (excluding node_modules)

## 🌐 InfinityFree Hosting Setup

### Step 1: Create InfinityFree Account
1. Go to https://infinityfree.com
2. Click "Sign Up" (it's free!)
3. Create your account
4. Verify your email

### Step 2: Create Website
1. After login, click "Create Account"
2. Choose your subdomain: `yourname.infinityfreeapp.com` (or use custom domain)
3. Wait for account creation (2-5 minutes)

### Step 3: Database Setup

#### A. Create MySQL Database
1. Go to Control Panel → MySQL Databases
2. Create new database: `yashcoldrinks` (or similar)
3. Create database user with password
4. **IMPORTANT**: Write down these credentials:
   ```
   Database Name: epizy_XXXXXXX_yashcoldrinks
   Database Host: sql###.infinityfree.com
   Username: epizy_XXXXXXX
   Password: [your password]
   ```

#### B. Import Database
1. Go to Control Panel → phpMyAdmin
2. Select your database
3. Click "Import" tab
4. Upload: `Backups/yashcoldrinks.sql`
5. Click "Go" to import

### Step 4: Update Configuration Files

**CRITICAL**: Before uploading, update these files with InfinityFree credentials:

#### File 1: `config/database.php`
```php
<?php
// InfinityFree Database Configuration
$servername = "sql###.infinityfree.com"; // Your DB host
$username = "epizy_XXXXXXX";            // Your DB username
$password = "your_db_password";         // Your DB password
$dbname = "epizy_XXXXXXX_yashcoldrinks"; // Your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Database Connection Failed: " . $conn->connect_error);
    die("Connection failed. Please try again later.");
}

$conn->set_charset("utf8mb4");
?>
```

#### File 2: `dbconnection.php`
```php
<?php
$servername = "sql###.infinityfree.com";
$username = "epizy_XXXXXXX";
$password = "your_db_password";
$dbname = "epizy_XXXXXXX_yashcoldrinks";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}
?>
```

#### File 3: `admin/includes/config.php`
Update the BASE_URL constants:
```php
// Change from:
define('BASE_URL', '/YashColdrinks');

// To:
define('BASE_URL', ''); // Empty for root domain

// Or if in subdirectory:
define('BASE_URL', '/subfolder');
```

### Step 5: Upload Files via FTP

#### Option A: Using FileZilla (Recommended)
1. Download FileZilla: https://filezilla-project.org
2. Get FTP credentials from InfinityFree Control Panel
3. Connect to FTP:
   - Host: `ftpupload.net`
   - Username: `epizy_XXXXXXX`
   - Password: Your account password
   - Port: 21
4. Navigate to `/htdocs/` folder (this is your web root)
5. Upload all project files to `/htdocs/`

#### Option B: Using Online File Manager
1. Go to Control Panel → Online File Manager
2. Navigate to `htdocs` folder
3. Upload files (slower, max 10MB per file)

### Step 6: Files to Upload

Upload these folders/files to `/htdocs/`:
```
htdocs/
├── admin/               ✅ Upload entire folder
├── assets/              ✅ Upload entire folder
├── Backups/             ❌ DO NOT upload (security)
├── config/              ✅ Upload (with updated database.php)
├── customer/            ✅ Upload entire folder
├── redirects/           ✅ Upload entire folder
├── src/                 ✅ Upload entire folder
├── all-products.php     ✅ Upload
├── cart.php             ✅ Upload
├── cart_action.php      ✅ Upload
├── dbconnection.php     ✅ Upload (with updated credentials)
├── footer.php           ✅ Upload
├── functions.php        ✅ Upload
├── header.php           ✅ Upload
├── index.php            ✅ Upload
├── order_success.php    ✅ Upload
├── product.php          ✅ Upload
├── .htaccess            ✅ Upload (if exists)
└── README.md            ✅ Optional
```

**DO NOT Upload:**
- `node_modules/` (too large, not needed)
- `Backups/` (security risk)
- `.git/` (not needed)
- `.vscode/` (not needed)
- `dist/` (build output)
- `Notes/` (not needed)
- `check_connection.php` (testing only)

### Step 7: Create .htaccess File

Create `.htaccess` in `/htdocs/` root:
```apache
# Prevent directory listing
Options -Indexes

# Enable error reporting (disable in production)
php_flag display_errors on
php_value error_reporting 32767

# Set default page
DirectoryIndex index.php

# Pretty URLs (optional)
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    
    # Redirect to HTTPS (if you have SSL)
    # RewriteCond %{HTTPS} off
    # RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>

# Protect sensitive files
<FilesMatch "^(config|dbconnection|\.git|\.env)">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### Step 8: Test Your Website

1. Visit: `http://yourname.infinityfreeapp.com`
2. Test customer site:
   - Browse products
   - Add to cart
   - Place order
3. Test admin panel: `http://yourname.infinityfreeapp.com/admin/`
   - Login: username: `Yash`, password: `123` (MD5: 202cb962ac59075b964b07152d234b70)

### Step 9: Post-Deployment Optimization

#### A. Enable SSL Certificate (Free)
1. Go to Control Panel → SSL Certificates
2. Install free SSL (Let's Encrypt compatible)
3. Update BASE_URL to use `https://`

#### B. Security Hardening
1. Change admin password immediately
2. Remove or password-protect phpMyAdmin access
3. Disable error display in production:
   ```php
   ini_set('display_errors', 0);
   error_reporting(0);
   ```

#### C. Performance Optimization
1. Enable caching in `.htaccess`:
   ```apache
   # Browser caching
   <IfModule mod_expires.c>
       ExpiresActive On
       ExpiresByType image/jpg "access plus 1 year"
       ExpiresByType image/jpeg "access plus 1 year"
       ExpiresByType image/png "access plus 1 year"
       ExpiresByType text/css "access plus 1 month"
       ExpiresByType application/javascript "access plus 1 month"
   </IfModule>
   ```

## 🚨 Common Issues & Solutions

### Issue 1: "Database Connection Failed"
**Solution**: Double-check database credentials in `config/database.php` and `dbconnection.php`

### Issue 2: "404 Not Found" for admin pages
**Solution**: Update BASE_URL in `admin/includes/config.php` to match your domain

### Issue 3: Images not loading
**Solution**: 
- Check image paths are relative (not absolute)
- Verify image files uploaded correctly
- Check file permissions (755 for folders, 644 for files)

### Issue 4: "Warning: session_start()"
**Solution**: InfinityFree has session restrictions. Use database sessions or ignore warnings.

### Issue 5: CSS not loading
**Solution**: Update asset paths in header.php to use relative URLs

## 📊 InfinityFree Limitations

- **Bandwidth**: 5GB/month (usually sufficient)
- **Storage**: Unlimited (fair use)
- **MySQL Databases**: 400 max
- **File Manager**: 10MB max file size
- **PHP**: Version 8.0+ available
- **Cron Jobs**: Not available on free plan
- **Email**: Limited (consider external SMTP)

## 🎯 Alternative Hosting (If Issues Arise)

If InfinityFree doesn't work well:
1. **000webhost.com** - Similar free hosting
2. **FreeHosting.com** - Another free option
3. **Heroku** - Free tier for PHP apps
4. **Railway.app** - Modern hosting platform

## 📝 Final Checklist

- [ ] Database created and imported
- [ ] Config files updated with credentials
- [ ] Files uploaded via FTP
- [ ] .htaccess file created
- [ ] Website accessible
- [ ] Admin panel working
- [ ] Products displaying
- [ ] Cart functionality working
- [ ] SSL certificate installed (optional)
- [ ] Admin password changed

## 🎉 Success!

Your YashColdrinks website should now be live at:
- Customer Site: `http://yourname.infinityfreeapp.com`
- Admin Panel: `http://yourname.infinityfreeapp.com/admin/`

Default Admin Login:
- Username: `Yash`
- Password: `123`

**IMPORTANT**: Change the admin password after first login!

---

Need help? Check InfinityFree support forum: https://forum.infinityfree.net
