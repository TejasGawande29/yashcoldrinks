# 🚀 InfinityFree Deployment - Quick Reference Card

## 📋 Pre-Deployment (5 minutes)

1. **Create InfinityFree Account**: https://infinityfree.com
2. **Create Website**: Choose subdomain (e.g., yashdrinks.infinityfreeapp.com)
3. **Create Database**: Control Panel → MySQL Databases
4. **Import Database**: phpMyAdmin → Import → `Backups/yashcoldrinks.sql`

## ⚙️ Configuration (2 minutes)

Update these 2 files with your InfinityFree credentials:

### File 1: `config/database.php`
```php
$servername = "sql###.infinityfree.com";     // Your DB host
$username = "epizy_XXXXXXX";                 // Your DB user
$password = "your_db_password";              // Your DB pass
$dbname = "epizy_XXXXXXX_yashcoldrinks";    // Your DB name
```

### File 2: `dbconnection.php`
```php
// Same credentials as above
```

### File 3: `admin/includes/config.php`
```php
define('BASE_URL', '');  // Change from '/YashColdrinks' to empty
```

## 📤 Upload Files (10-20 minutes)

### FTP Details (from InfinityFree panel):
- Host: `ftpupload.net`
- Username: `epizy_XXXXXXX`
- Password: [your password]
- Port: `21`

### Upload to `/htdocs/`:
```
✅ admin/              (entire folder)
✅ assets/             (entire folder)
✅ config/             (entire folder - WITH updated database.php)
✅ customer/           (entire folder)
✅ redirects/          (entire folder)
✅ src/                (entire folder)
✅ .htaccess           (important!)
✅ *.php files in root (all PHP files)

❌ node_modules/       (DO NOT upload)
❌ Backups/            (DO NOT upload)
❌ .git/               (DO NOT upload)
❌ .vscode/            (DO NOT upload)
```

## ✅ Post-Deployment Testing (5 minutes)

1. Visit: `http://yourname.infinityfreeapp.com`
2. Test customer site (browse products, cart)
3. Test admin panel: `/admin/`
   - Login: `Yash` / `123`
4. **Change admin password immediately!**

## 🔒 Security (1 minute)

1. Change admin password
2. Verify Backups/ not uploaded
3. Test config files not accessible in browser

## 🎉 Done!

Your site is live at:
- **Customer**: http://yourname.infinityfreeapp.com
- **Admin**: http://yourname.infinityfreeapp.com/admin/

---

## 🆘 Quick Troubleshooting

| Issue | Solution |
|-------|----------|
| "Database connection failed" | Check credentials in config files |
| 404 on admin pages | Update BASE_URL in admin/includes/config.php |
| Images not loading | Check assets/ folder uploaded, paths correct |
| CSS not applied | Verify assets/css/ uploaded, clear cache |

---

## 📚 Full Documentation

- **Complete Guide**: [DEPLOYMENT.md](DEPLOYMENT.md)
- **Detailed Checklist**: [DEPLOYMENT_CHECKLIST.md](DEPLOYMENT_CHECKLIST.md)
- **Summary**: [DEPLOYMENT_SUMMARY.md](DEPLOYMENT_SUMMARY.md)

**Total Time**: ~30 minutes
**Difficulty**: ⭐⭐ (Easy-Moderate)
