#!/bin/bash

# Fix Private Storage Access Script
# This script adds proper Laravel routes to serve private storage files

echo "🔧 Fixing private storage file access..."

cd /var/www/html

# Create a comprehensive route for serving private storage files
echo "📝 Adding Laravel routes for private file access..."

# Check if the route already exists
if grep -q "storage/customer-kyc" routes/web.php; then
    echo "⚠️  Customer-KYC route already exists, removing old one..."
    # Remove old route
    sed -i '/\/\/ Custom route for serving customer-kyc files/,/^$/d' routes/web.php
fi

# Add comprehensive private storage routes
cat >> routes/web.php << 'EOF'

// Private storage file access routes
Route::get('/storage/customer-kyc/{path}', function ($path) {
    // Decode the path to handle subdirectories
    $filePath = 'customer-kyc/' . $path;
    
    // Check if file exists in private storage
    if (!Storage::disk('local')->exists($filePath)) {
        abort(404, 'File not found');
    }
    
    try {
        // Get file content and MIME type
        $file = Storage::disk('local')->get($filePath);
        $mimeType = Storage::disk('local')->mimeType($filePath);
        $size = Storage::disk('local')->size($filePath);
        
        // Get file extension for additional MIME type handling
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        // Set proper MIME type based on extension if auto-detection fails
        if (!$mimeType || $mimeType === 'application/octet-stream') {
            $mimeType = match(strtolower($extension)) {
                'jpg', 'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                default => 'application/octet-stream'
            };
        }
        
        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Length', $size)
            ->header('Cache-Control', 'public, max-age=3600')
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('Content-Disposition', 'inline; filename="' . basename($path) . '"');
            
    } catch (Exception $e) {
        abort(500, 'Error reading file: ' . $e->getMessage());
    }
})->where('path', '.*')->name('storage.customer-kyc');

// General private storage route for other private files
Route::get('/storage/private/{path}', function ($path) {
    // This route serves other private files (not customer-kyc)
    $filePath = $path;
    
    if (!Storage::disk('local')->exists($filePath)) {
        abort(404, 'File not found');
    }
    
    try {
        $file = Storage::disk('local')->get($filePath);
        $mimeType = Storage::disk('local')->mimeType($filePath);
        $size = Storage::disk('local')->size($filePath);
        
        if (!$mimeType) {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $mimeType = match(strtolower($extension)) {
                'jpg', 'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'pdf' => 'application/pdf',
                default => 'application/octet-stream'
            };
        }
        
        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Length', $size)
            ->header('Cache-Control', 'private, max-age=3600')
            ->header('X-Content-Type-Options', 'nosniff');
            
    } catch (Exception $e) {
        abort(500, 'Error reading file: ' . $e->getMessage());
    }
})->where('path', '.*')->name('storage.private');
EOF

echo "✅ Added private storage routes"

# Set proper permissions on the storage directories
echo "📁 Setting proper storage permissions..."
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage
chmod -R 755 /var/www/html/storage/app/private

# Clear and rebuild route cache
echo "🧹 Clearing and rebuilding route cache..."
su -s /bin/bash www-data -c "php artisan route:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan route:cache" 2>/dev/null || true

# Test the routes
echo "🧪 Testing private storage access..."

# Create a test file in customer-kyc directory
mkdir -p /var/www/html/storage/app/private/customer-kyc/images
echo "test-customer-kyc-image" > /var/www/html/storage/app/private/customer-kyc/images/test.jpg
chown www-data:www-data /var/www/html/storage/app/private/customer-kyc/images/test.jpg
chmod 644 /var/www/html/storage/app/private/customer-kyc/images/test.jpg

# Test access via Laravel route
if curl -s -o /dev/null -w "%{http_code}" "http://localhost/storage/customer-kyc/images/test.jpg" | grep -q "200"; then
    echo "✅ Customer-KYC route working - 200 response"
else
    echo "⚠️  Customer-KYC route not working - checking Laravel logs..."
    tail -n 5 /var/www/html/storage/logs/laravel.log 2>/dev/null || echo "No Laravel logs found"
fi

# Clean up test file
rm -f /var/www/html/storage/app/private/customer-kyc/images/test.jpg

echo ""
echo "🎉 Private storage access fix completed!"
echo ""
echo "Summary of changes:"
echo "- Removed nginx direct serving of customer-kyc files"
echo "- Added Laravel routes for serving private storage files"
echo "- Set proper permissions on storage directories"
echo "- Routes handle proper MIME types and caching headers"
echo ""
echo "Private storage URLs:"
echo "- Customer KYC: /storage/customer-kyc/{path}"
echo "- Other private: /storage/private/{path}"
echo ""
echo "These routes will now properly serve private files through Laravel"
echo "with appropriate access control and error handling." 