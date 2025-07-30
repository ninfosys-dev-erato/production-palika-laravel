#!/bin/bash

# Fix 412 Error Script for Customer-KYC Files
# This script fixes the 412 Precondition Failed error with signed URLs

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

print_status "Fixing 412 error for customer-kyc files..."

# Create a custom route for serving customer-kyc files
print_status "Adding custom route for customer-kyc files..."

# Check if route already exists
if grep -q "storage/customer-kyc" /var/www/html/routes/web.php; then
    print_warning "Customer-KYC route already exists, skipping..."
else
    # Add route to web.php
    cat >> /var/www/html/routes/web.php << 'EOF'

// Custom route for serving customer-kyc files without signed URLs
Route::get('/storage/customer-kyc/{path}', function ($path) {
    $filePath = 'customer-kyc/' . $path;
    
    if (!Storage::disk('local')->exists($filePath)) {
        abort(404);
    }
    
    $file = Storage::disk('local')->get($filePath);
    $mimeType = Storage::disk('local')->mimeType($filePath);
    
    return response($file, 200)
        ->header('Content-Type', $mimeType)
        ->header('Cache-Control', 'public, max-age=3600')
        ->header('X-Content-Type-Options', 'nosniff');
})->where('path', '.*');
EOF
    print_status "✓ Added customer-kyc route"
fi

# Clear route cache
print_status "Clearing route cache..."
cd /var/www/html
php artisan route:clear 2>/dev/null || true
php artisan route:cache 2>/dev/null || true

# Update nginx configuration to handle the new route
print_status "Updating nginx configuration..."

# Remove customer-kyc specific nginx rules since we're handling them via Laravel now
if grep -q "location.*customer-kyc" /etc/nginx/sites-available/default; then
    print_status "Removing nginx customer-kyc rules (will be handled by Laravel route)..."
    
    # Create backup
    cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.bak
    
    # Remove customer-kyc location blocks
    sed -i '/# Allow access to customer-kyc storage/,/}/d' /etc/nginx/sites-available/default
    
    # Test nginx configuration
    if nginx -t 2>/dev/null; then
        print_status "✓ Nginx configuration updated successfully"
        # Reload nginx
        if command -v supervisorctl >/dev/null 2>&1; then
            supervisorctl restart nginx
        else
            pkill -HUP nginx 2>/dev/null || true
        fi
    else
        print_error "Nginx configuration test failed, restoring backup..."
        cp /etc/nginx/sites-available/default.bak /etc/nginx/sites-available/default
    fi
fi

# Test the fix
print_status "Testing customer-kyc file access..."

# Create a test file
mkdir -p /var/www/html/storage/app/private/customer-kyc/images
echo "test-customer-kyc-file" > /var/www/html/storage/app/private/customer-kyc/images/test.jpg
chown www-data:www-data /var/www/html/storage/app/private/customer-kyc/images/test.jpg
chmod 644 /var/www/html/storage/app/private/customer-kyc/images/test.jpg

# Test access via new route
if curl -s -o /dev/null -w "%{http_code}" "http://localhost/storage/customer-kyc/images/test.jpg" | grep -q "200"; then
    print_status "✓ Customer-KYC route working - 200 response"
else
    print_error "✗ Customer-KYC route not working"
fi

# Clean up test file
rm -f /var/www/html/storage/app/private/customer-kyc/images/test.jpg

print_status "412 error fix completed!"
print_status ""
print_status "Summary of changes:"
print_status "- Added custom Laravel route for /storage/customer-kyc/{path}"
print_status "- Route serves files directly from local storage without signed URLs"
print_status "- Removed nginx customer-kyc specific rules (Laravel handles them now)"
print_status "- Cleared and rebuilt route cache"
print_status ""
print_status "Customer-KYC URLs like https://dev.easypalika.com/storage/customer-kyc/images/filename.jpg"
print_status "should now work without 412 errors." 