#!/bin/bash
# Script Helper untuk Update di Server Hostinger
# Jalankan script ini via SSH setelah git pull

echo "========================================"
echo "  Hostinger Server Update Helper"
echo "========================================"
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Step 1: Install dependencies
echo -e "${YELLOW}[1/5] Installing composer dependencies...${NC}"
composer install --no-dev --optimize-autoloader

if [ $? -ne 0 ]; then
    echo -e "${RED}ERROR: Composer install failed!${NC}"
    exit 1
fi

echo -e "${GREEN}✓ Dependencies installed${NC}"
echo ""

# Step 2: Run migrations
echo -e "${YELLOW}[2/5] Running migrations...${NC}"
php artisan migrate --force

if [ $? -ne 0 ]; then
    echo -e "${RED}ERROR: Migration failed!${NC}"
    exit 1
fi

echo -e "${GREEN}✓ Migrations completed${NC}"
echo ""

# Step 3: Clear cache
echo -e "${YELLOW}[3/5] Clearing cache...${NC}"
php artisan optimize:clear
echo -e "${GREEN}✓ Cache cleared${NC}"
echo ""

# Step 4: Cache configuration
echo -e "${YELLOW}[4/5] Caching configuration...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✓ Configuration cached${NC}"
echo ""

# Step 5: Verify storage link
echo -e "${YELLOW}[5/5] Verifying storage link...${NC}"
if [ ! -L "public/storage" ]; then
    echo "Storage link not found, creating..."
    php artisan storage:link
fi
echo -e "${GREEN}✓ Storage link verified${NC}"
echo ""

# Summary
echo "========================================"
echo -e "${GREEN}  Update Completed Successfully!${NC}"
echo "========================================"
echo ""
echo "Please test your application:"
echo "- Check homepage loads correctly"
echo "- Test login functionality"
echo "- Verify assets (CSS/JS) are loading"
echo ""




