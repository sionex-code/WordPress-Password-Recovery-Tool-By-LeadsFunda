<?php
/**
 * WordPress Recovery & Management Tool By LEadsFunda
 *
 * USE WITH EXTREME CAUTION!
 * This script provides direct access to powerful WordPress functions.
 *
 * !! CRITICAL SECURITY WARNING !!
 * This version has NO secret key. Anyone who finds this file can take over your site.
 * 1. RENAME THIS FILE to something unpredictable (e.g., `_my_recovery_28a9b3c.php`).
 * 2. DELETE THIS FILE FROM YOUR SERVER IMMEDIATELY after you are finished.
 *    The easiest way is to use the "Self-Destruct" button at the top of the page.
 *
 * How to use:
 * 1. Upload this file to your WordPress root directory.
 * 2. Access it in your browser: https://yourdomain.com/your-random-filename.php
 * 3. When finished, click the "Self-Destruct" button.
 */

// Action: Self-Destruct (This must be the very first action)
if (isset($_GET['action']) && $_GET['action'] === 'self_destruct') {
    // Attempt to delete this file
    if (@unlink(__FILE__)) {
        // If successful, output a success message and die.
        die('<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Success</title><style>body{font-family:sans-serif;background:#f0f2f5;color:#333;text-align:center;padding-top:50px;}div{background:white;padding:30px;border-radius:5px;display:inline-block;border:1px solid #ddd;}</style></head><body><div><h1>✅ Success</h1><p>This recovery script has been successfully deleted from the server.</p><p>It is now safe to close this window.</p></div></body></html>');
    } else {
        // If it fails, output an error and die.
        die('<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Error</title><style>body{font-family:sans-serif;background:#f0f2f5;color:#333;text-align:center;padding-top:50px;}div{background:white;padding:30px;border-radius:5px;display:inline-block;border:1px solid #ddd;background-color:#f2dede;border-color:#ebccd1;color:#a94442;}</style></head><body><div><h1>❌ Error</h1><p>Could not self-destruct. This is likely due to file permissions.</p><p><strong>You must delete this file manually via FTP or your hosting control panel.</strong></p></div></body></html>');
    }
}


// --- BOOTSTRAP ---
// Turn on error reporting, essential for a recovery tool
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load WordPress environment
// This path assumes the script is in the WordPress root directory.
if (file_exists('wp-load.php')) {
    require_once('wp-load.php');
} else {
    die('<h1>Error</h1><p><strong>wp-load.php</strong> not found. Please ensure this script is in the root directory of your WordPress installation.</p>');
}

global $wpdb;

// --- SCRIPT ACTIONS (Process requests before any HTML is output) ---
$message = '';
$message_type = 'info'; // 'success', 'error', 'warning'

// Action: Create new admin user
if (isset($_POST['action']) && $_POST['action'] === 'create_user') {
    $username = sanitize_user($_POST['username'], true);
    $password = $_POST['password'];
    $email = sanitize_email($_POST['email']);

    if (empty($username) || empty($password) || empty($email)) {
        $message = 'Error: All fields are required to create a user.';
        $message_type = 'error';
    } elseif (username_exists($username)) {
        $message = "Error: Username '{$username}' already exists.";
        $message_type = 'error';
    } elseif (!is_email($email)) {
        $message = "Error: The email address '{$email}' is not valid.";
        $message_type = 'error';
    } else {
        $user_id = wp_create_user($username, $password, $email);
        if (is_wp_error($user_id)) {
            $message = 'Error creating user: ' . $user_id->get_error_message();
            $message_type = 'error';
        } else {
            $user = new WP_User($user_id);
            $user->set_role('administrator');
            $message = "Success! Administrator '{$username}' created.";
            $message_type = 'success';
        }
    }
}

// Action: Delete user
if (isset($_GET['action']) && $_GET['action'] === 'delete_user') {
    $uid = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    if ($uid === 1) {
        $message = 'Error: Deleting User ID 1 is not permitted.';
        $message_type = 'error';
    } elseif ($uid > 0) {
        require_once(ABSPATH . 'wp-admin/includes/user.php');
        if (wp_delete_user($uid)) {
            $message = "Success! User ID {$uid} has been deleted.";
            $message_type = 'success';
        } else {
            $message = "Error: Could not delete User ID {$uid}. They may not exist.";
            $message_type = 'error';
        }
    }
    // Redirect to clean the URL
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?msg=' . urlencode($message) . '&type=' . $message_type);
    exit;
}

// Action: Login as user
if (isset($_GET['action']) && $_GET['action'] === 'login_as') {
    $uid = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    if ($uid > 0) {
        wp_set_current_user($uid);
        wp_set_auth_cookie($uid);
        wp_redirect(admin_url());
        exit;
    }
}

// Action: Reset Password
if (isset($_POST['action']) && $_POST['action'] === 'reset_password') {
    $uid = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $new_password = $_POST['new_password'];

    if ($uid > 0 && !empty($new_password)) {
        wp_set_password($new_password, $uid);
        $message = "Success! Password for User ID {$uid} has been reset.";
        $message_type = 'success';
    } else {
        $message = 'Error: User ID and a new password are required.';
        $message_type = 'error';
    }
}

// Action: Deactivate all plugins
if (isset($_GET['action']) && $_GET['action'] === 'deactivate_plugins') {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    $active_plugins = get_option('active_plugins');
    if (!empty($active_plugins)) {
        deactivate_plugins($active_plugins);
        $message = 'Success! All plugins have been deactivated.';
        $message_type = 'success';
    } else {
        $message = 'Info: No active plugins to deactivate.';
        $message_type = 'info';
    }
     // Redirect to clean the URL
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?msg=' . urlencode($message) . '&type=' . $message_type);
    exit;
}


// Check for messages from redirects
if (isset($_GET['msg'])) {
    $message = esc_html(urldecode($_GET['msg']));
    $message_type = isset($_GET['type']) ? esc_attr($_GET['type']) : 'info';
}


// --- DATA GATHERING (For display) ---
$admins = get_users(['role' => 'administrator']);
$plugins = get_plugins();
$admin_url = admin_url();
$self_url = strtok($_SERVER['REQUEST_URI'], '?');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPress Recovery Tool</title>
    <style>
        :root {
            --bg-color: #f0f2f5;
            --box-bg-color: #ffffff;
            --text-color: #333;
            --border-color: #ddd;
            --header-color: #23282d;
            --accent-color: #0073aa;
            --accent-hover-color: #005a87;
            --red-color: #d63638;
            --red-hover-color: #a02122;
            --green-color: #46b450;
            --yellow-color: #ffb900;
        }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; background-color: var(--bg-color); color: var(--text-color); margin: 0; padding: 20px; }
        .container { max-width: 960px; margin: 0 auto; }
        .box { background-color: var(--box-bg-color); border: 1px solid var(--border-color); border-radius: 4px; margin-bottom: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .box-header { background-color: var(--header-color); color: white; padding: 15px 20px; border-radius: 4px 4px 0 0; }
        .box-header h2 { margin: 0; font-size: 18px; }
        .box-content { padding: 20px; }
        .alert { padding: 15px 20px; margin-bottom: 20px; border-radius: 4px; border: 1px solid transparent; }
        .alert-success { background-color: #dff0d8; border-color: #d6e9c6; color: #3c763d; }
        .alert-error { background-color: #f2dede; border-color: #ebccd1; color: #a94442; }
        .alert-warning { background-color: #fcf8e3; border-color: #faebcc; color: #8a6d3b; }
        .alert-info { background-color: #d9edf7; border-color: #bce8f1; color: #31708f; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td, th { border: 1px solid var(--border-color); padding: 12px; text-align: left; vertical-align: middle; }
        th { background-color: #f9f9f9; font-weight: 600; }
        tr:nth-child(even) { background-color: #fcfcfc; }
        label { display: block; margin-bottom: 5px; font-weight: 600; }
        input[type="text"], input[type="email"], input[type="password"], select { padding: 10px; margin-bottom: 15px; width: 100%; box-sizing: border-box; border: 1px solid var(--border-color); border-radius: 4px; }
        .btn { display: inline-block; text-decoration: none; font-size: 13px; padding: 8px 15px; border-radius: 3px; border: 1px solid transparent; cursor: pointer; margin-right: 5px; white-space: nowrap; }
        .btn-primary { background-color: var(--accent-color); color: white; border-color: var(--accent-color); }
        .btn-primary:hover { background-color: var(--accent-hover-color); }
        .btn-danger { background-color: var(--red-color); color: white; border-color: var(--red-color); }
        .btn-danger:hover { background-color: var(--red-hover-color); }
        button.btn { width: 100%; font-size: 16px; padding: 12px; }
        .plugin-status { padding: 4px 8px; border-radius: 10px; color: white; font-size: 12px; font-weight: bold; }
        .status-active { background-color: var(--green-color); }
        .status-inactive { background-color: #777; }
        .flex-group { display: flex; gap: 15px; align-items: flex-end; }
        .flex-group > div { flex-grow: 1; }
        .self-destruct-wrapper { text-align: center; margin-top: 20px; }
    </style>
    <script>
        function confirmDelete(username) {
            return confirm('Are you sure you want to permanently delete the user "' + username + '"? This action cannot be undone.');
        }
        function confirmSelfDestruct() {
            return confirm('Are you absolutely sure you want to permanently delete this recovery script from the server?\n\nYou will not be able to use it again unless you re-upload it.');
        }
    </script>
</head>
<body>
<div class="container">

    <div class="box">
        <div class="box-header"><h2>🛠️ WordPress Recovery Tool</h2></div>
        <div class="box-content">
            <p>This tool allows you to perform emergency recovery tasks on your WordPress site.</p>
            <p><strong>Admin URL:</strong> <a href="<?= esc_url($admin_url) ?>" target="_blank"><?= esc_html($admin_url) ?></a></p>
            <div class="alert alert-warning">
                <strong>CRITICAL SECURITY WARNING:</strong> This is a powerful script. Please <strong style="color:var(--red-color);">DELETE THIS FILE FROM YOUR SERVER IMMEDIATELY</strong> after you are finished using it.
            </div>
            <div class="self-destruct-wrapper">
                 <a href="<?= esc_url($self_url . '?action=self_destruct') ?>" class="btn btn-danger" onclick="return confirmSelfDestruct();">💣 Self-Destruct This Script Now</a>
            </div>
        </div>
    </div>
    
    <?php if (!empty($message)): ?>
    <div class="alert alert-<?= $message_type; ?>" role="alert">
        <?= $message; ?>
    </div>
    <?php endif; ?>

    <div class="box">
        <div class="box-header"><h2>👤 Administrator Users</h2></div>
        <div class="box-content">
            <table>
                <thead>
                    <tr><th>ID</th><th>Username</th><th>Email</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $user): ?>
                    <tr>
                        <td><?= $user->ID ?></td>
                        <td><?= esc_html($user->user_login) ?></td>
                        <td><?= esc_html($user->user_email) ?></td>
                        <td>
                            <a href="<?= esc_url($self_url . '?action=login_as&user_id=' . $user->ID) ?>" class="btn btn-primary">Login as</a>
                            <?php if ($user->ID != 1): ?>
                            <a href="<?= esc_url($self_url . '?action=delete_user&user_id=' . $user->ID) ?>" 
                               class="btn btn-danger" 
                               onclick="return confirmDelete('<?= esc_js($user->user_login) ?>')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="box">
        <div class="box-header"><h2>🔑 Reset Admin Password</h2></div>
        <div class="box-content">
            <form method="post" action="<?= esc_url($self_url) ?>">
                <input type="hidden" name="action" value="reset_password">
                <div class="flex-group">
                    <div>
                        <label for="reset-user">Select User:</label>
                        <select id="reset-user" name="user_id" required>
                            <?php foreach ($admins as $user): ?>
                                <option value="<?= $user->ID ?>"><?= esc_html($user->user_login) ?> (ID: <?= $user->ID ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="new-pass">New Password:</label>
                        <input type="text" id="new-pass" name="new_password" placeholder="Enter new strong password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header"><h2>➕ Create New Admin</h2></div>
        <div class="box-content">
            <form method="post" action="<?= esc_url($self_url) ?>">
                <input type="hidden" name="action" value="create_user">
                <label for="new-username">Username:</label>
                <input type="text" id="new-username" name="username" placeholder="e.g., newadmin" required>
                <label for="new-email">Email:</label>
                <input type="email" id="new-email" name="email" placeholder="e.g., admin@example.com" required>
                <label for="new-password">Password:</label>
                <input type="text" id="new-password" name="password" placeholder="Enter a strong password" required>
                <button type="submit" class="btn btn-primary">Create New Admin</button>
            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header"><h2>🔌 Installed Plugins</h2></div>
        <div class="box-content">
             <p>A common cause of site failure is a faulty plugin. You can deactivate all plugins here to test.</p>
             <a href="<?= esc_url($self_url . '?action=deactivate_plugins') ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to deactivate ALL plugins?');">Deactivate All Plugins</a>
            <table>
                <thead>
                    <tr><th>Name</th><th>Status</th><th>Version</th><th>Description</th></tr>
                </thead>
                <tbody>
                <?php 
                if(!function_exists('is_plugin_active')) {
                    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                }
                foreach ($plugins as $path => $plugin): 
                ?>
                    <tr>
                        <td><strong><?= esc_html($plugin['Name']) ?></strong></td>
                        <td>
                            <?php if (is_plugin_active($path)): ?>
                                <span class="plugin-status status-active">Active</span>
                            <?php else: ?>
                                <span class="plugin-status status-inactive">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc_html($plugin['Version']) ?></td>
                        <td><?= esc_html($plugin['Description']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>
