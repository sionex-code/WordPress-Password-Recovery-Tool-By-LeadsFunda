# WordPress Recovery & Management Tool

A powerful emergency recovery script for WordPress websites that provides direct access to critical WordPress functions when you're locked out of your admin panel.

## ⚠️ CRITICAL SECURITY WARNING

**This tool is extremely powerful and poses significant security risks if misused.**

- 🔴 **NO AUTHENTICATION**: This version has no secret key or password protection
- 🔴 **FULL ADMIN ACCESS**: Anyone who finds this file can take complete control of your website
- 🔴 **DELETE IMMEDIATELY**: Remove this file from your server as soon as you're finished using it

## 🎯 What This Tool Does

This recovery script provides emergency access to essential WordPress management functions:

### User Management
- **View all administrator users** with their IDs, usernames, and email addresses
- **Create new admin users** with full administrator privileges
- **Reset passwords** for any existing admin user
- **Delete users** (except User ID 1 for safety)
- **Login as any user** instantly without knowing their password

### Plugin Management
- **View all installed plugins** with their status, versions, and descriptions
- **Deactivate all plugins** at once (useful for troubleshooting plugin conflicts)
- **Identify active vs inactive plugins** visually

### Site Recovery
- **Bypass login issues** when locked out of WordPress admin
- **Troubleshoot plugin conflicts** by mass-deactivating plugins
- **Emergency admin access** when credentials are lost or compromised

## 🚀 How to Use

### Step 1: Upload the Script
1. Download the PHP file
2. **RENAME IT** to something unpredictable (e.g., `my_recovery_x7k2m9.php`)
3. Upload it to your WordPress root directory (same folder as `wp-config.php`)

### Step 2: Access the Tool
Visit the script in your browser:
```
https://yourdomain.com/your-random-filename.php
```

### Step 3: Perform Recovery Tasks
- Create a new admin user if you're locked out
- Reset passwords for existing administrators
- Deactivate all plugins if your site is broken
- Login as any user to access the WordPress admin panel

### Step 4: Self-Destruct (CRITICAL)
**Always click the "Self-Destruct" button** when finished, or manually delete the file via FTP.

## 🔧 Technical Requirements

- **PHP 7.0+**
- **WordPress 4.0+**
- **File write permissions** (for self-destruct functionality)
- **WordPress root directory access**

## 📋 Use Cases

### Emergency Scenarios
- 🔒 **Locked out of WordPress admin** due to lost credentials
- 🔌 **Plugin conflicts** causing site crashes or admin inaccessibility
- 👤 **Compromised admin accounts** requiring immediate password resets
- 🛡️ **Malicious user accounts** that need to be removed quickly
- 🔧 **Site maintenance** requiring temporary admin access

### Troubleshooting Workflows
1. **Plugin Issues**: Deactivate all plugins → Test site functionality → Reactivate plugins one by one
2. **User Access**: Create temporary admin → Fix original account → Remove temporary admin
3. **Security Incidents**: Reset all admin passwords → Remove unauthorized users → Audit site

## 🛡️ Security Best Practices

### Before Using
- [ ] Rename the file to something unpredictable
- [ ] Only upload when absolutely necessary
- [ ] Ensure you have FTP/hosting panel access to delete the file

### During Use
- [ ] Work quickly and efficiently
- [ ] Don't leave the browser tab open unattended
- [ ] Use strong passwords for any new accounts created

### After Use
- [ ] **IMMEDIATELY** click "Self-Destruct" or manually delete the file
- [ ] Verify the file has been completely removed from the server
- [ ] Consider changing passwords for any accounts you accessed

## ⚡ Features

### User Interface
- **Responsive design** that works on desktop and mobile
- **Clean, professional styling** similar to WordPress admin
- **Confirmation dialogs** for destructive actions
- **Success/error messaging** for all operations
- **Real-time status updates** for plugins and users

### Safety Features
- **User ID 1 protection** (prevents deletion of the primary admin)
- **Input validation** and sanitization
- **Confirmation prompts** for dangerous operations
- **Self-destruct functionality** for easy cleanup
- **Error handling** with descriptive messages

## 🔍 Code Structure

```
├── Self-Destruct Handler (Priority #1)
├── WordPress Bootstrap & Environment Loading
├── Action Handlers (POST/GET request processing)
├── Data Gathering (Users, Plugins, Settings)
└── HTML Interface (Forms, Tables, Styling)
```

## ⚠️ Important Warnings

### DO NOT USE THIS TOOL IF:
- You're not comfortable with the security implications
- You don't have a way to securely delete the file afterward
- You're on a shared hosting environment where others might find it
- You're not sure what you're doing

### ALWAYS REMEMBER:
- This tool bypasses ALL WordPress security measures
- It provides the same access level as the database
- Malicious actors can use it to completely compromise your site
- It should be treated like a loaded weapon

## 🤝 Contributing

This tool is designed for emergency use only. If you have suggestions for improvements:

1. Focus on security enhancements
2. Consider additional safety measures
3. Improve error handling and user feedback
4. Ensure backward compatibility with older WordPress versions

## 📄 License

Use at your own risk. This tool is provided as-is without any warranty. The authors are not responsible for any damage caused by its use.

## 🆘 Support

This is an emergency recovery tool. For general WordPress support, consult:
- [WordPress.org Support Forums](https://wordpress.org/support/)
- [WordPress Codex](https://codex.wordpress.org/)
- Your hosting provider's support team

---

**Remember: Security is your responsibility. Use this tool wisely and delete it immediately when finished.**

---

<div align="center">

**🔧 More Professional WordPress Tools & Scripts**

Visit **[LeadsFunda](https://leadsfunda.com)** for additional premium WordPress utilities, automation scripts, and development tools.

---

<p>
  <strong>WordPress Recovery Tool</strong><br>
  © 2024 LeadsFunda. All rights reserved.<br>
  <em>Remember: Security is your responsibility. Use this tool wisely and delete it immediately when finished.</em>
</p>

![LeadsFunda](https://img.shields.io/badge/LeadsFunda-WordPress%20Tools-blue?style=flat-square&logo=wordpress)
[![MIT License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](https://choosealicense.com/licenses/mit/)
[![Professional Support](https://img.shields.io/badge/Support-Professional-orange?style=flat-square)](https://leadsfunda.com)

</div>
