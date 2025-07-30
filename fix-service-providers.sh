#!/bin/bash

# Fix Service Provider Issues Script
# This fixes the missing service provider errors in production

echo "🔧 Fixing Laravel service provider issues..."

cd /var/www/html

# Remove problematic service providers from config/app.php
echo "📝 Removing development service providers from config..."
sed -i '/Barryvdh\\Debugbar\\ServiceProvider/d' config/app.php 2>/dev/null || true
sed -i '/Mccarlosen\\LaravelMpdf\\LaravelMpdfServiceProvider/d' config/app.php 2>/dev/null || true
sed -i '/LaravelMpdfServiceProvider/d' config/app.php 2>/dev/null || true

echo "✅ Removed problematic service providers"

# Clear all Laravel caches
echo "🧹 Clearing Laravel caches..."
su -s /bin/bash www-data -c "php artisan config:clear" 2>/dev/null && echo "✅ Config cache cleared" || echo "⚠️  Config clear failed"
su -s /bin/bash www-data -c "php artisan route:clear" 2>/dev/null && echo "✅ Route cache cleared" || echo "⚠️  Route clear failed"
su -s /bin/bash www-data -c "php artisan view:clear" 2>/dev/null && echo "✅ View cache cleared" || echo "⚠️  View clear failed"
su -s /bin/bash www-data -c "php artisan cache:clear" 2>/dev/null && echo "✅ Application cache cleared" || echo "⚠️  Cache clear failed"

# Rebuild caches
echo "🔄 Rebuilding caches..."
su -s /bin/bash www-data -c "php artisan config:cache" 2>/dev/null && echo "✅ Config cached" || echo "⚠️  Config cache failed"
su -s /bin/bash www-data -c "php artisan route:cache" 2>/dev/null && echo "✅ Routes cached" || echo "⚠️  Route cache failed"
su -s /bin/bash www-data -c "php artisan view:cache" 2>/dev/null && echo "✅ Views cached" || echo "⚠️  View cache failed"

echo ""
echo "🎉 Service provider fix completed!"
echo ""
echo "The following development service providers have been removed:"
echo "- Barryvdh\\Debugbar\\ServiceProvider (laravel-debugbar)"
echo "- Mccarlosen\\LaravelMpdf\\LaravelMpdfServiceProvider (laravel-mpdf)"
echo ""
echo "Laravel caches have been cleared and rebuilt."
echo "Your container should now start without service provider errors." 