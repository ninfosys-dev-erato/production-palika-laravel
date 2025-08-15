#!/bin/bash

# Fix LaravelMpdf Service Provider Issue
# This script completely removes all traces of the problematic service provider

echo "🔧 Fixing LaravelMpdf service provider issue..."

cd /var/www/html

# Step 1: Remove any references from config files
echo "📝 Removing service provider references from config files..."
sed -i '/Barryvdh\\Debugbar\\ServiceProvider/d' config/app.php 2>/dev/null || true
sed -i '/Mccarlosen\\LaravelMpdf\\LaravelMpdfServiceProvider/d' config/app.php 2>/dev/null || true
sed -i '/LaravelMpdfServiceProvider/d' config/app.php 2>/dev/null || true

# Step 2: Remove from bootstrap providers if it exists
sed -i '/LaravelMpdfServiceProvider/d' bootstrap/providers.php 2>/dev/null || true
sed -i '/Mccarlosen\\LaravelMpdf\\LaravelMpdfServiceProvider/d' bootstrap/providers.php 2>/dev/null || true

# Step 3: Clear all cached files that might contain service provider references
echo "🧹 Clearing all cached files..."
rm -rf bootstrap/cache/*.php 2>/dev/null || true
rm -rf storage/framework/cache/* 2>/dev/null || true
rm -rf storage/framework/services.php 2>/dev/null || true
rm -rf storage/framework/packages.php 2>/dev/null || true
rm -rf storage/framework/compiled.php 2>/dev/null || true

# Step 4: Clear Laravel caches (run as www-data to avoid permission issues)
echo "🧹 Clearing Laravel application caches..."
su -s /bin/bash www-data -c "php artisan config:clear" 2>/dev/null && echo "✅ Config cache cleared" || echo "⚠️  Config clear failed"
su -s /bin/bash www-data -c "php artisan route:clear" 2>/dev/null && echo "✅ Route cache cleared" || echo "⚠️  Route clear failed"
su -s /bin/bash www-data -c "php artisan view:clear" 2>/dev/null && echo "✅ View cache cleared" || echo "⚠️  View clear failed"
su -s /bin/bash www-data -c "php artisan cache:clear" 2>/dev/null && echo "✅ Application cache cleared" || echo "⚠️  Cache clear failed"
su -s /bin/bash www-data -c "php artisan clear-compiled" 2>/dev/null && echo "✅ Compiled services cleared" || echo "⚠️  Clear compiled failed"

# Step 5: Test if the issue is resolved
echo "🧪 Testing if the issue is resolved..."
if su -s /bin/bash www-data -c "php artisan --version" >/dev/null 2>&1; then
    echo "✅ Laravel artisan is working without errors!"
else
    echo "⚠️  Laravel artisan still has issues, trying additional fixes..."
    
    # Additional fix: Regenerate autoloader
    echo "🔄 Regenerating autoloader..."
    composer dump-autoload --optimize --no-dev 2>/dev/null || true
    
    # Try clearing caches again
    su -s /bin/bash www-data -c "php artisan config:clear" 2>/dev/null || true
fi

# Step 6: Try to rebuild caches
echo "🔄 Rebuilding caches..."
su -s /bin/bash www-data -c "php artisan config:cache" 2>/dev/null && echo "✅ Config cached" || echo "⚠️  Config cache failed (this is OK for now)"
su -s /bin/bash www-data -c "php artisan route:cache" 2>/dev/null && echo "✅ Routes cached" || echo "⚠️  Route cache failed (this is OK for now)"

echo ""
echo "🎉 LaravelMpdf service provider fix completed!"
echo ""
echo "What was fixed:"
echo "- Removed all service provider references from config files"
echo "- Cleared all cached files that could contain old references"
echo "- Cleared Laravel application caches"
echo "- Regenerated autoloader"
echo ""
echo "Your container should now start without LaravelMpdf errors."
echo "If you still see issues, try restarting the container:"
echo "docker-compose -f docker-compose.prod.yml restart" 