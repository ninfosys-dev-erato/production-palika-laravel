#!/bin/bash

# Quick Fix for Current Container Issues
# Run this script inside your running container to fix permission and debugbar issues

echo "🔧 Fixing current container issues..."

# Fix permissions
echo "📁 Setting proper permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/public
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/public

# Fix storage symlink
echo "🔗 Fixing storage symlink..."
rm -f /var/www/html/public/storage 2>/dev/null || true
cd /var/www/html

if su -s /bin/bash www-data -c "php artisan storage:link --force" 2>/dev/null; then
    echo "✅ Storage symlink created successfully"
else
    echo "⚠️  Artisan failed, creating manual symlink..."
    ln -sf /var/www/html/storage/app/public /var/www/html/public/storage
    chown -h www-data:www-data /var/www/html/public/storage 2>/dev/null || true
    echo "✅ Manual symlink created"
fi

# Clear Laravel caches to fix debugbar/service provider issues
echo "🧹 Clearing Laravel caches..."
su -s /bin/bash www-data -c "php artisan config:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan route:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan view:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan cache:clear" 2>/dev/null || true

# Rebuild caches
echo "🔄 Rebuilding caches..."
su -s /bin/bash www-data -c "php artisan config:cache" 2>/dev/null && echo "✅ Config cached" || echo "⚠️  Config cache failed"
su -s /bin/bash www-data -c "php artisan route:cache" 2>/dev/null && echo "✅ Routes cached" || echo "⚠️  Route cache failed"

echo ""
echo "🎉 Fix completed! Your container should now work properly."
echo ""
echo "If you still see issues, try restarting the container:"
echo "docker-compose -f docker-compose.prod.yml restart" 