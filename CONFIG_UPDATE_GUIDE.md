# ⚠️ IMPORTANT: Configuration Files to Update for InfinityFree

## 🔴 CRITICAL - Update These 3 Config Files Before Deployment

### 1. config/database.php
**Location**: `config/database.php`

**Current (Local)**:
```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yashcoldrinks";
```

**Update to (InfinityFree)**:
```php
$servername = "sql###.infinityfree.com";        // Your DB host
$username = "epizy_XXXXXXX";                    // Your DB user
$password = "YOUR_DB_PASSWORD";                 // Your DB pass
$dbname = "epizy_XXXXXXX_yashcoldrinks";       // Your DB name
```

---

### 2. dbconnection.php
**Location**: `dbconnection.php` (root folder)

**Current (Local)**:
```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yashcoldrinks";
```

**Update to (InfinityFree)**:
```php
$servername = "sql###.infinityfree.com";
$username = "epizy_XXXXXXX";
$password = "YOUR_DB_PASSWORD";
$dbname = "epizy_XXXXXXX_yashcoldrinks";
```

---

### 3. admin/includes/config.php
**Location**: `admin/includes/config.php`

**Current (Local)**:
```php
define('BASE_URL', '/YashColdrinks');
define('ADMIN_URL', BASE_URL . '/admin');
define('ASSETS_URL', BASE_URL . '/assets');
define('CUSTOMER_URL', BASE_URL . '/customer');
```

**Update to (InfinityFree - Root Domain)**:
```php
define('BASE_URL', '');                        // Empty for root
define('ADMIN_URL', '/admin');
define('ASSETS_URL', '/assets');
define('CUSTOMER_URL', '/customer');
```

**OR (InfinityFree - Subdirectory)**:
```php
define('BASE_URL', '/subfolder');              // If in subdirectory
define('ADMIN_URL', BASE_URL . '/admin');
define('ASSETS_URL', BASE_URL . '/assets');
define('CUSTOMER_URL', BASE_URL . '/customer');
```

---

### 4. customer/includes/config.php
**Location**: `customer/includes/config.php`

**Current (Local)**:
```php
define('BASE_URL', '/YashColdrinks');
define('CUSTOMER_URL', BASE_URL . '/customer');
define('ASSETS_URL', BASE_URL . '/assets');
define('ADMIN_URL', BASE_URL . '/admin');
```

**Update to (InfinityFree - Root Domain)**:
```php
define('BASE_URL', '');                        // Empty for root
define('CUSTOMER_URL', '/customer');
define('ASSETS_URL', '/assets');
define('ADMIN_URL', '/admin');
```

**OR (InfinityFree - Subdirectory)**:
```php
define('BASE_URL', '/subfolder');
define('CUSTOMER_URL', BASE_URL . '/customer');
define('ASSETS_URL', BASE_URL . '/assets');
define('ADMIN_URL', BASE_URL . '/admin');
```

---

### 5. index.php (Already Fixed)
**Location**: `index.php` (root folder)

Already updated to use dynamic redirect ✅

---

## 📝 Quick Update Process

### Step 1: Before Uploading
1. Open `config/database.php`
2. Replace database credentials with InfinityFree details
3. Save file

### Step 2: Update Connection File
1. Open `dbconnection.php`
2. Replace database credentials (same as above)
3. Save file

### Step 3: Update URL Paths
1. Open `admin/includes/config.php`
2. Change `BASE_URL` from `/YashColdrinks` to empty `''`
3. Update other URL constants
4. Save file

### Step 4: Update Customer Config
1. Open `customer/includes/config.php`
2. Change `BASE_URL` from `/YashColdrinks` to empty `''`
3. Update other URL constants
4. Save file

### Step 5: Upload All Files
Upload everything to `/htdocs/` on InfinityFree

---

## 🔍 How to Find Your InfinityFree Credentials

### Database Credentials:
1. Login to InfinityFree
2. Go to "Control Panel"
3. Click "MySQL Databases"
4. Look for:
   - **Database Host**: Usually `sql###.infinityfree.com` (e.g., sql212.infinityfree.com)
   - **Database Name**: Format: `epizy_XXXXXXX_yashcoldrinks`
   - **Username**: Format: `epizy_XXXXXXX` (8 digit number)
   - **Password**: The one you set when creating the database

### FTP Credentials:
1. Go to "Control Panel"
2. Click "FTP Details"
3. Look for:
   - **Host**: `ftpupload.net`
   - **Username**: Same as database (e.g., `epizy_XXXXXXX`)
   - **Password**: Your account password
   - **Port**: `21`

---

## ✅ Verification Checklist

After updating and uploading:

- [ ] Can access homepage: `http://yoursite.infinityfreeapp.com`
- [ ] Database connection works (no error messages)
- [ ] Images load correctly
- [ ] CSS styles applied
- [ ] Navigation links work
- [ ] Can access admin panel: `/admin/`
- [ ] Can login to admin
- [ ] Cart functionality works
- [ ] Products display correctly

---

## 🚨 Common Mistakes to Avoid

1. ❌ **Forgetting to update BASE_URL** → Results in 404 errors
2. ❌ **Using wrong database host** → Connection fails
3. ❌ **Not updating dbconnection.php** → Some pages won't work
4. ❌ **Leaving credentials as localhost** → Database connection fails
5. ❌ **Not clearing browser cache** → May see old styles/images

---

## 💡 Pro Tips

1. **Make a copy** of original files before editing
2. **Test locally** first (already done ✅)
3. **Use template files** provided (*.infinityfree.template.php)
4. **Update all 4 config files** before uploading
5. **Clear browser cache** after uploading
6. **Check error logs** in InfinityFree panel if issues arise

---

## 📞 Need Help?

If you encounter issues:
1. Check all 4 config files are updated
2. Verify database imported successfully
3. Check InfinityFree error logs
4. Visit: https://forum.infinityfree.net

---

**Last Updated**: February 2, 2026
**Status**: Ready for deployment after updating these files ✅
