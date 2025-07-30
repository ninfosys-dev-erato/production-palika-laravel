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
chown -R www-data:www-data /var/www/html/public
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/public

# Remove and recreate storage symlink
print_status "Fixing storage symlink..."
rm -f /var/www/html/public/storage 2>/dev/null || true
cd /var/www/html

# Try artisan command first as www-data user, fallback to manual symlink
if su -s /bin/bash www-data -c "php artisan storage:link --force" 2>/dev/null; then
    print_status "Storage symlink created using artisan command"
else
    print_warning "Artisan command failed, creating symlink manually..."
    if su -s /bin/bash www-data -c "ln -sf /var/www/html/storage/app/public /var/www/html/public/storage" 2>/dev/null; then
        print_status "Manual symlink created as www-data user"
    else
        print_warning "www-data symlink failed, trying as root..."
        ln -sf /var/www/html/storage/app/public /var/www/html/public/storage
        chown -h www-data:www-data /var/www/html/public/storage 2>/dev/null || true
    fi
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

# Clear Laravel caches to fix service provider issues
print_status "Clearing Laravel caches..."
su -s /bin/bash www-data -c "php artisan config:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan route:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan view:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan cache:clear" 2>/dev/null || true

# Rebuild caches
print_status "Rebuilding Laravel caches..."
su -s /bin/bash www-data -c "php artisan config:cache" 2>/dev/null || print_warning "Config cache failed"
su -s /bin/bash www-data -c "php artisan route:cache" 2>/dev/null || print_warning "Route cache failed"
su -s /bin/bash www-data -c "php artisan view:cache" 2>/dev/null || print_warning "View cache failed"

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
print_status "- Public directory: /var/www/html/public (755 permissions, www-data:www-data)"
print_status "- Public symlink: /var/www/html/public/storage -> /var/www/html/storage/app/public"
print_status "- Bootstrap cache: /var/www/html/bootstrap/cache (775 permissions, www-data:www-data)"
print_status "- Laravel caches cleared and rebuilt"
print_status "- Service provider issues should be resolved" 