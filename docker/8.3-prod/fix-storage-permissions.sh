#!/bin/bash

# Fix Storage Permissions Script
# Run this inside your container to fix storage permission issues

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_status "Fixing Laravel storage permissions..."

# Ensure all storage directories exist
print_status "Creating storage directories..."
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/storage/app/private
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/bootstrap/cache

# Fix ownership and permissions
print_status "Setting proper ownership and permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Remove and recreate storage symlink
print_status "Fixing storage symlink..."
rm -f /var/www/html/public/storage 2>/dev/null || true
cd /var/www/html

# Try artisan command first, fallback to manual symlink
if php artisan storage:link --force 2>/dev/null; then
    print_status "Storage symlink created using artisan command"
else
    print_warning "Artisan command failed, creating symlink manually..."
    ln -sf /var/www/html/storage/app/public /var/www/html/public/storage
fi

# Verify the symlink
if [ -L "/var/www/html/public/storage" ]; then
    print_status "✓ Storage symlink exists"
    print_status "Symlink points to: $(readlink /var/www/html/public/storage)"
    ls -la /var/www/html/public/storage
else
    print_error "✗ Storage symlink failed to create"
    exit 1
fi

# Test storage access
print_status "Testing storage access..."
echo "test" > /var/www/html/storage/app/public/test.txt
chown www-data:www-data /var/www/html/storage/app/public/test.txt
chmod 644 /var/www/html/storage/app/public/test.txt

if [ -f "/var/www/html/public/storage/test.txt" ]; then
    print_status "✓ Storage symlink is working - test file accessible"
else
    print_error "✗ Storage symlink not working - test file not accessible"
fi

rm -f /var/www/html/storage/app/public/test.txt

print_status "Storage permissions fix completed!"
print_status ""
print_status "Summary:"
print_status "- Storage directory: /var/www/html/storage (775 permissions, www-data:www-data)"
print_status "- Public symlink: /var/www/html/public/storage -> /var/www/html/storage/app/public"
print_status "- Bootstrap cache: /var/www/html/bootstrap/cache (775 permissions, www-data:www-data)" 