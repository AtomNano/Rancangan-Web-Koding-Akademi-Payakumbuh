#!/bin/bash
# Bash Script to Fix PHP Upload Limits (Linux/Mac)
# Run with: bash fix-upload-limits.sh
# Or: chmod +x fix-upload-limits.sh && ./fix-upload-limits.sh

echo "================================================"
echo "PHP Upload Limits Fix Script (Linux/Mac)"
echo "================================================"
echo ""

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo "⚠️  This script may need root privileges to edit php.ini"
    echo "   Run with: sudo bash fix-upload-limits.sh"
    echo ""
fi

# Find PHP installation
PHP_INI_PATH=""

# Try to find php.ini using php command
if command -v php &> /dev/null; then
    PHP_INI_PATH=$(php --ini | grep "Loaded Configuration File" | awk '{print $NF}')
    if [ -n "$PHP_INI_PATH" ] && [ -f "$PHP_INI_PATH" ]; then
        echo "✅ Found php.ini: $PHP_INI_PATH"
    else
        PHP_INI_PATH=""
    fi
fi

# Common paths if not found
if [ -z "$PHP_INI_PATH" ]; then
    COMMON_PATHS=(
        "/etc/php/8.2/apache2/php.ini"
        "/etc/php/8.1/apache2/php.ini"
        "/etc/php/8.0/apache2/php.ini"
        "/etc/php/8.2/fpm/php.ini"
        "/etc/php/8.1/fpm/php.ini"
        "/etc/php/8.0/fpm/php.ini"
        "/etc/php.ini"
        "/usr/local/etc/php/php.ini"
        "/opt/lampp/etc/php.ini"
    )
    
    for path in "${COMMON_PATHS[@]}"; do
        if [ -f "$path" ]; then
            PHP_INI_PATH="$path"
            echo "✅ Found php.ini: $PHP_INI_PATH"
            break
        fi
    done
fi

# If still not found, ask user
if [ -z "$PHP_INI_PATH" ]; then
    echo "❌ Could not find php.ini automatically."
    read -p "Please enter the full path to php.ini: " PHP_INI_PATH
    
    if [ ! -f "$PHP_INI_PATH" ]; then
        echo "❌ File not found: $PHP_INI_PATH"
        exit 1
    fi
fi

echo ""
echo "📋 Backing up php.ini..."
BACKUP_PATH="${PHP_INI_PATH}.backup.$(date +%Y%m%d_%H%M%S)"
sudo cp "$PHP_INI_PATH" "$BACKUP_PATH"
echo "✅ Backup created: $BACKUP_PATH"

echo ""
echo "🔧 Updating settings..."

# Create sed commands
sudo sed -i.backup "s/^\(upload_max_filesize\s*=\s*\).*/\1100M/" "$PHP_INI_PATH"
sudo sed -i.backup "s/^\(post_max_size\s*=\s*\).*/\1100M/" "$PHP_INI_PATH"
sudo sed -i.backup "s/^\(max_execution_time\s*=\s*\).*/\1300/" "$PHP_INI_PATH"
sudo sed -i.backup "s/^\(max_input_time\s*=\s*\).*/\1300/" "$PHP_INI_PATH"
sudo sed -i.backup "s/^\(memory_limit\s*=\s*\).*/\1256M/" "$PHP_INI_PATH"

# Remove duplicate .backup file created by sed
sudo rm -f "${PHP_INI_PATH}.backup"

echo "✅ Settings updated!"
echo ""
echo "================================================"
echo "⚠️  IMPORTANT: Restart Web Server!"
echo "================================================"
echo ""
echo "To restart Apache:"
echo "  sudo systemctl restart apache2"
echo "  # or"
echo "  sudo service apache2 restart"
echo ""
echo "To restart PHP-FPM + Nginx:"
echo "  sudo systemctl restart php8.2-fpm"
echo "  sudo systemctl restart nginx"
echo ""
echo "After restarting, verify with:"
echo "  http://localhost/check-upload-config.php"
echo ""
echo "✅ Script completed!"

