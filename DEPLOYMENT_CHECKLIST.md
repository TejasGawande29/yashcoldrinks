# 📋 InfinityFree Deployment Checklist

## Before Deployment

### 1. InfinityFree Account Setup
- [ ] Created InfinityFree account at https://infinityfree.com
- [ ] Verified email address
- [ ] Created website/subdomain
- [ ] Noted FTP credentials:
  ```
  Host: ftpupload.net
  Username: epizy_________
  Password: ___________
  ```

### 2. Database Setup
- [ ] Created MySQL database in InfinityFree panel
- [ ] Noted database credentials:
  ```
  DB Host: sql___.infinityfree.com
  DB Name: epizy_________yashcoldrinks
  DB User: epizy_________
  DB Pass: ___________
  ```
- [ ] Imported `Backups/yashcoldrinks.sql` via phpMyAdmin
- [ ] Verified all 18 tables imported successfully

### 3. Configuration Files Updated
- [ ] Updated `config/database.php` with InfinityFree credentials
- [ ] Updated `dbconnection.php` with InfinityFree credentials
- [ ] Updated `admin/includes/config.php` BASE_URL to:
  ```php
  define('BASE_URL', ''); // For root domain
  ```

### 4. File Upload Preparation
- [ ] Removed test files (already done ✅)
- [ ] Removed development files (already done ✅)
- [ ] .htaccess file created (already done ✅)
- [ ] Verified all file permissions locally

## During Deployment

### 5. FTP Upload (using FileZilla or File Manager)
Upload these to `/htdocs/`:
- [ ] admin/ folder (entire)
- [ ] assets/ folder (entire)
- [ ] config/ folder (with updated database.php)
- [ ] customer/ folder (entire)
- [ ] redirects/ folder
- [ ] src/ folder
- [ ] All root PHP files (index.php, cart.php, etc.)
- [ ] .htaccess file

**DO NOT UPLOAD:**
- [ ] ❌ node_modules/
- [ ] ❌ Backups/
- [ ] ❌ .git/
- [ ] ❌ .vscode/
- [ ] ❌ dist/
- [ ] ❌ Notes/
- [ ] ❌ check_connection.php

### 6. File Verification
- [ ] All PHP files uploaded successfully
- [ ] All image files in assets/images/ uploaded
- [ ] All CSS files in assets/css/ uploaded
- [ ] All JavaScript files uploaded
- [ ] .htaccess file present in root

## After Deployment

### 7. Initial Testing
- [ ] Visit: http://yourname.infinityfreeapp.com
- [ ] Homepage loads correctly
- [ ] Navigation menu working
- [ ] Images displaying properly
- [ ] CSS styles applied

### 8. Customer Site Testing
- [ ] Product listing page works
- [ ] Product detail page displays correctly
- [ ] Add to cart functionality works
- [ ] Cart page shows items
- [ ] Checkout process completes
- [ ] Order confirmation page displays

### 9. Admin Panel Testing
- [ ] Admin login page accessible: /admin/
- [ ] Can login with credentials (username: Yash, password: 123)
- [ ] Dashboard displays data
- [ ] Stock management works
- [ ] Order management functional
- [ ] Expense tracking works
- [ ] Sales dashboard shows reports

### 10. Security Hardening
- [ ] Changed admin password from default
- [ ] Disabled PHP error display:
  ```php
  ini_set('display_errors', 0);
  error_reporting(0);
  ```
- [ ] Verified config files not accessible via browser
- [ ] Verified Backups/ folder not uploaded
- [ ] Set proper file permissions (755 folders, 644 files)

### 11. SSL Certificate (Optional but Recommended)
- [ ] Installed free SSL certificate in InfinityFree panel
- [ ] Updated BASE_URL to use https://
- [ ] Enabled HTTPS redirect in .htaccess
- [ ] Tested site with https://

### 12. Performance Optimization
- [ ] Browser caching enabled (.htaccess)
- [ ] GZIP compression enabled (.htaccess)
- [ ] Optimized images (if needed)
- [ ] Tested page load speed

### 13. Final Verification
- [ ] All pages accessible
- [ ] No broken links
- [ ] All images loading
- [ ] Forms submitting correctly
- [ ] Database operations working
- [ ] No PHP errors visible
- [ ] Mobile responsiveness checked

## Post-Deployment Maintenance

### 14. Regular Tasks
- [ ] Backup database weekly (download from phpMyAdmin)
- [ ] Monitor disk space usage
- [ ] Check for security updates
- [ ] Monitor error logs
- [ ] Update product inventory

### 15. Documentation
- [ ] Document admin login credentials (securely)
- [ ] Note database backup schedule
- [ ] Keep FTP credentials safe
- [ ] Document any customizations made

## 🚨 Troubleshooting Reference

### Common Issues:
1. **Database Connection Failed**
   - Recheck credentials in config files
   - Ensure database imported correctly
   - Verify DB host is correct

2. **404 Errors on Admin Pages**
   - Update BASE_URL in admin/includes/config.php
   - Check .htaccess uploaded

3. **Images Not Loading**
   - Verify image paths are relative
   - Check images uploaded to correct folders
   - Check file permissions

4. **CSS Not Applied**
   - Verify assets/css/ folder uploaded
   - Check asset paths in header.php
   - Clear browser cache

5. **Session Errors**
   - InfinityFree has session limitations
   - Use database sessions if needed
   - Can usually be ignored

## 📞 Support Resources

- InfinityFree Forum: https://forum.infinityfree.net
- InfinityFree Knowledge Base: https://forum.infinityfree.net/docs
- Project README: See README.md
- Deployment Guide: See DEPLOYMENT.md

## ✅ Deployment Complete!

Date deployed: __________
URL: http://________________________
Admin Panel: http://________________________/admin/

**Remember to:**
1. Change default admin password
2. Setup regular database backups
3. Monitor site performance
4. Keep documentation updated

---

🎉 Congratulations! Your YashColdrinks website is now live!
