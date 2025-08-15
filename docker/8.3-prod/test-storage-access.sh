#!/bin/bash

# Simple Storage Access Test Script
# Run this to quickly test if storage access is working

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_debug() {
    echo -e "${BLUE}[DEBUG]${NC} $1"
}

print_status "🧪 Storage Access Test"
print_status "====================="

cd /var/www/html

# Create a test file
print_status "Creating test file..."
mkdir -p /var/www/html/storage/app/private/customer-kyc/test
echo "test-file-content-$(date)" > /var/www/html/storage/app/private/customer-kyc/test/debug.jpg
chown -R www-data:www-data /var/www/html/storage/app/private/customer-kyc/test
chmod 644 /var/www/html/storage/app/private/customer-kyc/test/debug.jpg

print_status "Test file created: /var/www/html/storage/app/private/customer-kyc/test/debug.jpg"

# Test 1: Check if file exists
print_status "Test 1: Checking if file exists..."
if [ -f "/var/www/html/storage/app/private/customer-kyc/test/debug.jpg" ]; then
    print_status "✅ File exists physically"
    ls -la /var/www/html/storage/app/private/customer-kyc/test/debug.jpg
else
    print_error "❌ File does not exist"
    exit 1
fi

# Test 2: Check Laravel storage access
print_status "Test 2: Checking Laravel storage access..."
if su -s /bin/bash www-data -c "php -r \"echo Storage::disk('local')->exists('customer-kyc/test/debug.jpg') ? 'EXISTS' : 'NOT_FOUND';\" 2>/dev/null" | grep -q "EXISTS"; then
    print_status "✅ Laravel can access the file"
else
    print_error "❌ Laravel cannot access the file"
fi

# Test 3: Check if route exists
print_status "Test 3: Checking if route exists..."
if grep -q "storage/customer-kyc" /var/www/html/routes/web.php; then
    print_status "✅ Route exists in web.php"
else
    print_error "❌ Route does not exist in web.php"
fi

# Test 4: Check route cache
print_status "Test 4: Checking route cache..."
if su -s /bin/bash www-data -c "php artisan route:list | grep storage" 2>/dev/null; then
    print_status "✅ Storage routes are cached"
else
    print_warning "⚠️  Storage routes not found in cache"
fi

# Test 5: Test HTTP access
print_status "Test 5: Testing HTTP access..."
print_debug "Testing: http://localhost/storage/customer-kyc/test/debug.jpg"

# Test with curl
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost/storage/customer-kyc/test/debug.jpg")
print_debug "HTTP Response Code: $HTTP_CODE"

if [ "$HTTP_CODE" = "200" ]; then
    print_status "✅ HTTP access working - 200 response"
elif [ "$HTTP_CODE" = "404" ]; then
    print_error "❌ HTTP access failed - 404 response"
    print_debug "Checking nginx error logs..."
    tail -n 5 /tmp/nginx-error.log 2>/dev/null || echo "No nginx error logs found"
    print_debug "Checking Laravel logs..."
    tail -n 5 /var/www/html/storage/logs/laravel.log 2>/dev/null || echo "No Laravel logs found"
elif [ "$HTTP_CODE" = "403" ]; then
    print_error "❌ HTTP access failed - 403 Forbidden"
else
    print_warning "⚠️  HTTP access returned: $HTTP_CODE"
fi

# Test 6: Test direct Laravel access
print_status "Test 6: Testing direct Laravel access..."
print_debug "Testing: http://localhost/index.php?path=test/debug.jpg"

DIRECT_CODE=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost/index.php?path=test/debug.jpg")
print_debug "Direct Laravel Response Code: $DIRECT_CODE"

if [ "$DIRECT_CODE" = "200" ]; then
    print_status "✅ Direct Laravel access working"
elif [ "$DIRECT_CODE" = "404" ]; then
    print_error "❌ Direct Laravel access failed - 404"
else
    print_warning "⚠️  Direct Laravel access returned: $DIRECT_CODE"
fi

# Test 7: Check nginx configuration
print_status "Test 7: Checking nginx configuration..."
if nginx -t 2>/dev/null; then
    print_status "✅ Nginx configuration is valid"
else
    print_error "❌ Nginx configuration has errors"
    nginx -t 2>&1
fi

# Test 8: Check if nginx is serving static files instead of passing to Laravel
print_status "Test 8: Checking nginx location block order..."
if grep -A 10 -B 5 "storage.*customer-kyc" /etc/nginx/sites-available/default | grep -q "try_files.*index.php"; then
    print_status "✅ Nginx is configured to pass to Laravel"
else
    print_error "❌ Nginx might be serving static files instead of passing to Laravel"
fi

# Clean up
print_status "Cleaning up test file..."
rm -f /var/www/html/storage/app/private/customer-kyc/test/debug.jpg
rmdir /var/www/html/storage/app/private/customer-kyc/test 2>/dev/null || true

print_status ""
print_status "🎯 Test Summary:"
print_status "================"
if [ "$HTTP_CODE" = "200" ]; then
    print_status "✅ Storage access is working correctly!"
else
    print_error "❌ Storage access is not working"
    print_status ""
    print_status "Next steps:"
    print_status "1. Run: fix-storage-routes"
    print_status "2. Check: tail -f /var/www/html/storage/logs/laravel.log"
    print_status "3. Check: tail -f /tmp/nginx-error.log"
    print_status "4. Restart nginx: supervisorctl restart nginx"
fi 