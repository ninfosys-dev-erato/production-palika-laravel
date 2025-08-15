#!/bin/bash

# Quick Fix for Private Storage Permissions
# Run this script inside your container to immediately fix private file access

echo "🔧 Fixing private storage permissions immediately..."

cd /var/www/html

# Step 1: Set proper permissions on all storage directories
echo "📁 Setting storage permissions..."
chown -R www-data:www-data storage/
chmod -R 775 storage/
chmod -R 755 storage/app/private/

# Step 2: Ensure the private directory structure exists
echo "📂 Creating private storage directories..."
mkdir -p storage/app/private/customer-kyc/images
chown -R www-data:www-data storage/app/private/
chmod -R 755 storage/app/private/

# Step 3: Add Laravel routes for private file serving (if not exists)
echo "🛣️  Adding Laravel routes for private files..."
if ! grep -q "storage/customer-kyc" routes/web.php; then
    cat >> routes/web.php << 'EOF'

// Route for serving customer-kyc private files
Route::get('/storage/customer-kyc/{path}', function ($path) {
    $filePath = 'customer-kyc/' . $path;
    
    if (!Storage::disk('local')->exists($filePath)) {
        abort(404, 'File not found');
    }
    
    $file = Storage::disk('local')->get($filePath);
    $mimeType = Storage::disk('local')->mimeType($filePath) ?: 'application/octet-stream';
    
    // Set MIME type based on extension if detection fails
    if ($mimeType === 'application/octet-stream') {
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
        ->header('Cache-Control', 'public, max-age=3600')
        ->header('X-Content-Type-Options', 'nosniff');
})->where('path', '.*');
EOF
    echo "✅ Added customer-kyc route"
else
    echo "✅ Customer-kyc route already exists"
fi

# Step 4: Clear route cache
echo "🧹 Clearing route cache..."
su -s /bin/bash www-data -c "php artisan route:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan route:cache" 2>/dev/null || true

# Step 5: Test permissions
echo "🧪 Testing permissions..."
echo "Storage directory owner: $(stat -c '%U:%G' storage/)"
echo "Storage directory permissions: $(stat -c '%a' storage/)"
echo "Private directory owner: $(stat -c '%U:%G' storage/app/private/)"
echo "Private directory permissions: $(stat -c '%a' storage/app/private/)"

echo ""
echo "🎉 Private storage permissions fix completed!"
echo ""
echo "What was fixed:"
echo "- Set proper ownership (www-data:www-data) on all storage directories"
echo "- Set proper permissions (775 for storage, 755 for private)"
echo "- Added Laravel route for serving customer-kyc files"
echo "- Cleared and rebuilt route cache"
echo ""
echo "Private files should now be accessible through:"
echo "https://your-domain.com/storage/customer-kyc/images/filename.jpg" 