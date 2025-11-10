<?php
/**
 * Script untuk mengecek konfigurasi upload file
 * Akses via browser: http://your-domain/check-upload-config.php
 * HAPUS file ini setelah selesai mengecek untuk keamanan!
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Check Upload Configuration</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        table { border-collapse: collapse; width: 100%; max-width: 800px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>PHP Upload Configuration Check</h1>
    <p><strong>PENTING:</strong> Hapus file ini setelah selesai mengecek untuk keamanan!</p>
    
    <table>
        <tr>
            <th>Setting</th>
            <th>Current Value</th>
            <th>Recommended</th>
            <th>Status</th>
        </tr>
        <tr>
            <td>upload_max_filesize</td>
            <td><?php echo ini_get('upload_max_filesize'); ?></td>
            <td>100M</td>
            <td class="<?php echo (ini_get('upload_max_filesize') >= '100M') ? 'success' : 'error'; ?>">
                <?php echo (ini_get('upload_max_filesize') >= '100M') ? '✓ OK' : '✗ Perlu Diperbaiki'; ?>
            </td>
        </tr>
        <tr>
            <td>post_max_size</td>
            <td><?php echo ini_get('post_max_size'); ?></td>
            <td>100M</td>
            <td class="<?php echo (ini_get('post_max_size') >= '100M') ? 'success' : 'error'; ?>">
                <?php echo (ini_get('post_max_size') >= '100M') ? '✓ OK' : '✗ Perlu Diperbaiki'; ?>
            </td>
        </tr>
        <tr>
            <td>max_execution_time</td>
            <td><?php echo ini_get('max_execution_time'); ?> seconds</td>
            <td>300 seconds</td>
            <td class="<?php echo (ini_get('max_execution_time') >= 300) ? 'success' : 'warning'; ?>">
                <?php echo (ini_get('max_execution_time') >= 300) ? '✓ OK' : '⚠ Perlu Diperbaiki'; ?>
            </td>
        </tr>
        <tr>
            <td>max_input_time</td>
            <td><?php echo ini_get('max_input_time'); ?> seconds</td>
            <td>300 seconds</td>
            <td class="<?php echo (ini_get('max_input_time') >= 300) ? 'success' : 'warning'; ?>">
                <?php echo (ini_get('max_input_time') >= 300) ? '✓ OK' : '⚠ Perlu Diperbaiki'; ?>
            </td>
        </tr>
        <tr>
            <td>memory_limit</td>
            <td><?php echo ini_get('memory_limit'); ?></td>
            <td>256M</td>
            <td class="<?php echo (ini_get('memory_limit') >= '256M') ? 'success' : 'warning'; ?>">
                <?php echo (ini_get('memory_limit') >= '256M') ? '✓ OK' : '⚠ Perlu Diperbaiki'; ?>
            </td>
        </tr>
    </table>
    
    <h2>File Info</h2>
    <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
    <p><strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></p>
    <p><strong>PHP SAPI:</strong> <?php echo php_sapi_name(); ?></p>
    
    <h2>Tips</h2>
    <ul>
        <li>Jika menggunakan Apache, pastikan mod_php atau mod_php7 aktif</li>
        <li>Jika menggunakan PHP-FPM dengan Nginx, edit php.ini langsung</li>
        <li>Setelah mengubah php.ini, restart web server</li>
        <li>Pastikan post_max_size >= upload_max_filesize</li>
    </ul>
    
    <p style="color: red;"><strong>JANGAN LUPA:</strong> Hapus file ini setelah selesai!</p>
</body>
</html>

