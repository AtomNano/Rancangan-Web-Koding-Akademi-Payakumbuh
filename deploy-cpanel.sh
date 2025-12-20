#!/bin/bash

################################################################################
# Script Deploy Laravel ke cPanel Niagahoster
# Jalankan script ini di Terminal cPanel setelah upload file
################################################################################

echo "=========================================="
echo "  Deploy Laravel to cPanel Niagahoster"
echo "=========================================="
echo ""

# Warna untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fungsi untuk print dengan warna
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ $1${NC}"
}

# Check apakah di home directory
cd ~ || exit

print_info "Current directory: $(pwd)"
echo ""

################################################################################
# STEP 1: Setup Struktur Folder
################################################################################

echo "Step 1: Setting up folder structure..."
echo ""

# Buat folder laravel_app jika belum ada
if [ ! -d "laravel_app" ]; then
    mkdir -p laravel_app
    print_success "Created laravel_app directory"
else
    print_info "laravel_app directory already exists"
fi

# Check apakah ada folder temporary upload
if [ -d "laravel_temp" ]; then
    print_info "Found laravel_temp directory, moving files..."
    
    # Pindahkan semua file kecuali public
    rsync -av --exclude='public' laravel_temp/ laravel_app/
    print_success "Moved Laravel files to laravel_app"
    
    # Pindahkan isi folder public ke public_html
    rsync -av laravel_temp/public/ public_html/
    print_success "Moved public files to public_html"
    
    # Hapus folder temporary
    rm -rf laravel_temp
    print_success "Cleaned up temporary folder"
else
    print_error "laravel_temp directory not found!"
    print_info "Please upload your Laravel project to ~/laravel_temp first"
    exit 1
fi

echo ""

################################################################################
# STEP 2: Edit index.php
################################################################################

echo "Step 2: Updating index.php..."
echo ""

cat > public_html/index.php << 'EOF'
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__.'/../laravel_app/vendor/autoload.php';

$app = require_once __DIR__.'/../laravel_app/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
EOF

print_success "Updated index.php with correct paths"
echo ""

################################################################################
# STEP 3: Setup Environment File
################################################################################

echo "Step 3: Setting up .env file..."
echo ""

cd laravel_app

if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        print_success "Created .env from .env.example"
    else
        print_error ".env.example not found!"
        exit 1
    fi
else
    print_info ".env already exists"
fi

echo ""

################################################################################
# STEP 4: Install Dependencies
################################################################################

echo "Step 4: Installing Composer dependencies..."
echo ""

if command -v composer &> /dev/null; then
    composer install --optimize-autoloader --no-dev
    print_success "Composer dependencies installed"
else
    print_error "Composer not found! Please install composer or run manually"
fi

echo ""

################################################################################
# STEP 5: Generate Application Key
################################################################################

echo "Step 5: Generating application key..."
echo ""

php artisan key:generate --force
print_success "Application key generated"

echo ""

################################################################################
# STEP 6: Set Permissions
################################################################################

echo "Step 6: Setting correct permissions..."
echo ""

# Storage permissions
chmod -R 755 storage bootstrap/cache
find storage -type f -exec chmod 644 {} \;
find storage -type d -exec chmod 755 {} \;

print_success "Permissions set correctly"

echo ""

################################################################################
# STEP 7: Create Storage Symlink
################################################################################

echo "Step 7: Creating storage symbolic link..."
echo ""

cd ~/public_html

# Remove old symlink if exists
if [ -L "storage" ]; then
    rm storage
    print_info "Removed old storage symlink"
fi

# Create new symlink
ln -s ../laravel_app/storage/app/public storage
print_success "Created storage symlink"

echo ""

################################################################################
# STEP 8: Setup .htaccess
################################################################################

echo "Step 8: Setting up .htaccess..."
echo ""

cat > ~/public_html/.htaccess << 'EOF'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>

# PHP Settings
<IfModule mod_php7.c>
    php_value upload_max_filesize 64M
    php_value post_max_size 64M
    php_value max_execution_time 300
    php_value max_input_time 300
</IfModule>
EOF

print_success "Created .htaccess file"

echo ""

################################################################################
# STEP 9: Cache Configuration
################################################################################

echo "Step 9: Caching configurations for production..."
echo ""

cd ~/laravel_app

# Clear all cache first
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

print_success "Configurations cached"

echo ""

################################################################################
# STEP 10: Database Migration (Optional)
################################################################################

echo "Step 10: Database migration (skipped - import SQL manually)..."
echo ""
print_info "Please import your database SQL file via phpMyAdmin"
print_info "Then update .env with correct database credentials"

echo ""

################################################################################
# Summary
################################################################################

echo "=========================================="
echo "  Deployment Complete! 🚀"
echo "=========================================="
echo ""
print_success "Laravel has been deployed successfully!"
echo ""
echo "Next steps:"
echo "  1. Edit ~/laravel_app/.env with correct settings:"
echo "     - APP_URL"
echo "     - Database credentials"
echo "     - Mail settings (if needed)"
echo ""
echo "  2. Import database via phpMyAdmin"
echo ""
echo "  3. Test your application at your domain"
echo ""
echo "  4. If you encounter issues, check:"
echo "     - ~/laravel_app/storage/logs/laravel.log"
echo "     - cPanel Error Log"
echo ""
echo "  5. Set APP_DEBUG=false in .env for production"
echo ""
print_info "Good luck! 🍀"
echo ""
