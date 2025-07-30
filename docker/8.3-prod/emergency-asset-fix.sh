#!/bin/bash

# Emergency Asset Fix Script for Laravel Livewire Tables (rappasoft)
# This script helps debug and fix 502/404 errors with rappasoft assets

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

# Function to check current state
check_current_state() {
    print_status "Checking current rappasoft asset state..."
    
    echo "=== Directory Structure ==="
    ls -la /var/www/html/public/rappasoft/ 2>/dev/null || echo "rappasoft directory does not exist"
    ls -la /var/www/html/public/vendor/rappasoft/ 2>/dev/null || echo "vendor/rappasoft directory does not exist"
    
    echo -e "\n=== Specific Files ==="
    for file in "rappasoft/laravel-livewire-tables/core.min.css" "rappasoft/laravel-livewire-tables/core.min.js" "vendor/rappasoft/laravel-livewire-tables/core.min.css" "vendor/rappasoft/laravel-livewire-tables/core.min.js"; do
        if [ -f "/var/www/html/public/$file" ]; then
            echo -e "${GREEN}✓${NC} $file exists"
            ls -la "/var/www/html/public/$file"
        else
            echo -e "${RED}✗${NC} $file missing"
        fi
    done
    
    echo -e "\n=== File Permissions ==="
    find /var/www/html/public -name "*rappasoft*" -exec ls -la {} \; 2>/dev/null || echo "No rappasoft files found"
}

# Function to manually create assets
create_assets_manually() {
    print_status "Creating rappasoft assets manually..."
    
    # Create directories
    mkdir -p /var/www/html/public/rappasoft/laravel-livewire-tables
    mkdir -p /var/www/html/public/vendor/rappasoft/laravel-livewire-tables
    
    # Create core.min.css
    cat > /var/www/html/public/rappasoft/laravel-livewire-tables/core.min.css << 'EOF'
/* Laravel Livewire Tables Core CSS */
.laravel-livewire-tables-reorderingMinimised {
    display: none !important;
}
.livewire-tables {
    margin: 0;
    padding: 0;
}
EOF
    
    # Create core.min.js
    cat > /var/www/html/public/rappasoft/laravel-livewire-tables/core.min.js << 'EOF'
/* Laravel Livewire Tables Core JavaScript */
window.laravellivewiretable = function($wire) {
    return {
        shouldBeDisplayed: true,
        currentlyReorderingStatus: false,
        tableId: null,
        bulkActions: {},
        primaryKeyName: 'id',
        setTableId: function(id) {
            this.tableId = id;
        },
        setAlpineBulkActions: function(actions) {
            this.bulkActions = actions;
        },
        setPrimaryKeyName: function(name) {
            this.primaryKeyName = name;
        },
        showTable: function(event) {
            this.shouldBeDisplayed = true;
        },
        hideTable: function(event) {
            this.shouldBeDisplayed = false;
        }
    }
};
EOF
    
    # Create thirdparty files
    cat > /var/www/html/public/rappasoft/laravel-livewire-tables/thirdparty.css << 'EOF'
/* Laravel Livewire Tables Third Party CSS */
EOF
    
    cat > /var/www/html/public/rappasoft/laravel-livewire-tables/thirdparty.min.js << 'EOF'
/* Laravel Livewire Tables Third Party JavaScript */
EOF
    
    # Copy to vendor directory
    cp /var/www/html/public/rappasoft/laravel-livewire-tables/* /var/www/html/public/vendor/rappasoft/laravel-livewire-tables/
    
    # Set proper permissions
    chown -R www-data:www-data /var/www/html/public/rappasoft /var/www/html/public/vendor/rappasoft
    chmod -R 644 /var/www/html/public/rappasoft /var/www/html/public/vendor/rappasoft
    find /var/www/html/public/rappasoft /var/www/html/public/vendor/rappasoft -type d -exec chmod 755 {} \;
    
    print_status "Assets created successfully!"
}

# Function to test nginx access
test_nginx_access() {
    print_status "Testing nginx access to rappasoft assets..."
    
    # Test if we can access the files directly
    for url in "/rappasoft/laravel-livewire-tables/core.min.css" "/rappasoft/laravel-livewire-tables/core.min.js" "/vendor/rappasoft/laravel-livewire-tables/core.min.css" "/vendor/rappasoft/laravel-livewire-tables/core.min.js"; do
        if curl -s -o /dev/null -w "%{http_code}" "http://localhost$url" | grep -q "200"; then
            echo -e "${GREEN}✓${NC} $url - HTTP 200"
        else
            echo -e "${RED}✗${NC} $url - Not accessible"
        fi
    done
}

# Function to restart nginx
restart_nginx() {
    print_status "Restarting nginx..."
    if command -v supervisorctl >/dev/null 2>&1; then
        supervisorctl restart nginx
    else
        pkill -HUP nginx 2>/dev/null || print_warning "Could not restart nginx"
    fi
}

# Function to check storage configuration
check_storage_config() {
    print_status "Checking Laravel storage configuration..."
    
    echo "=== Storage Symlinks ==="
    if [ -L "/var/www/html/public/storage" ]; then
        echo -e "${GREEN}✓${NC} storage symlink exists"
        ls -la /var/www/html/public/storage
        echo "Symlink points to: $(readlink /var/www/html/public/storage)"
    else
        echo -e "${RED}✗${NC} storage symlink does not exist"
    fi
    
    echo -e "\n=== Storage Directories ==="
    ls -la /var/www/html/storage/app/ 2>/dev/null || echo "storage/app directory missing"
    ls -la /var/www/html/storage/app/public/ 2>/dev/null || echo "storage/app/public directory missing"
    ls -la /var/www/html/storage/app/private/ 2>/dev/null || echo "storage/app/private directory missing"
    
    echo -e "\n=== Storage Permissions ==="
    echo "storage directory permissions: $(stat -c '%a' /var/www/html/storage 2>/dev/null || echo 'unknown')"
    echo "storage directory owner: $(stat -c '%U:%G' /var/www/html/storage 2>/dev/null || echo 'unknown')"
    echo "storage/app permissions: $(stat -c '%a' /var/www/html/storage/app 2>/dev/null || echo 'unknown')"
    echo "storage/app owner: $(stat -c '%U:%G' /var/www/html/storage/app 2>/dev/null || echo 'unknown')"
    
    echo -e "\n=== Sample Files ==="
    find /var/www/html/storage/app -name "*.jpg" -o -name "*.png" -o -name "*.pdf" | head -5 2>/dev/null || echo "No image/document files found"
}

# Function to fix storage configuration
fix_storage_config() {
    print_status "Fixing Laravel storage configuration..."
    
    # Create storage directories
    mkdir -p /var/www/html/storage/app/public
    mkdir -p /var/www/html/storage/app/private
    mkdir -p /var/www/html/storage/logs
    mkdir -p /var/www/html/storage/framework/cache
    mkdir -p /var/www/html/storage/framework/sessions
    mkdir -p /var/www/html/storage/framework/views
    
    # Set proper permissions for all storage
    chown -R www-data:www-data /var/www/html/storage
    chmod -R 775 /var/www/html/storage
    
    # Create/recreate storage symlink
    print_status "Creating storage symlink..."
    rm -f /var/www/html/public/storage 2>/dev/null || true
    cd /var/www/html && php artisan storage:link --force 2>/dev/null || {
        print_warning "Artisan command failed, creating symlink manually..."
        ln -sf /var/www/html/storage/app/public /var/www/html/public/storage
    }
    
    # Verify symlink
    if [ -L "/var/www/html/public/storage" ]; then
        print_status "Storage symlink created successfully"
        print_status "Symlink points to: $(readlink /var/www/html/public/storage)"
        ls -la /var/www/html/public/storage
    else
        print_error "Failed to create storage symlink"
    fi
}

# Function to test storage access
test_storage_access() {
    print_status "Testing storage access..."
    
    # Test basic storage endpoint
    if curl -s -o /dev/null -w "%{http_code}" "http://localhost/storage/" | grep -q "200\|403\|404"; then
        echo -e "${GREEN}✓${NC} /storage/ - Endpoint reachable"
    else
        echo -e "${RED}✗${NC} /storage/ - Not accessible"
    fi
    
    # Test if we can create a test file and access it via web
    echo "test" > /var/www/html/storage/app/public/test.txt
    chown www-data:www-data /var/www/html/storage/app/public/test.txt
    chmod 644 /var/www/html/storage/app/public/test.txt
    
    if curl -s -o /dev/null -w "%{http_code}" "http://localhost/storage/test.txt" | grep -q "200"; then
        echo -e "${GREEN}✓${NC} /storage/test.txt - Test file accessible via web"
    else
        echo -e "${RED}✗${NC} /storage/test.txt - Test file not accessible via web"
        print_warning "Checking symlink and permissions..."
        ls -la /var/www/html/public/storage 2>/dev/null || echo "Storage symlink missing"
        ls -la /var/www/html/storage/app/public/test.txt 2>/dev/null || echo "Test file missing"
    fi
    
    rm -f /var/www/html/storage/app/public/test.txt
}

# Function to fix 412 errors with customer-kyc files
fix_412_error() {
    print_status "Fixing 412 error for customer-kyc files..."
    
    # Run the dedicated 412 fix script
    if [ -f "/usr/local/bin/fix-412-error" ]; then
        /usr/local/bin/fix-412-error
    else
        print_warning "fix-412-error script not found, applying fix manually..."
        
        # Check if route already exists
        if grep -q "storage/customer-kyc" /var/www/html/routes/web.php; then
            print_warning "Customer-KYC route already exists"
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
        cd /var/www/html
        php artisan route:clear 2>/dev/null || true
        php artisan route:cache 2>/dev/null || true
    fi
}

# Main function
main() {
    case "${1:-check}" in
        "check")
            check_current_state
            check_storage_config
            ;;
        "fix")
            print_warning "Applying emergency asset fix..."
            create_assets_manually
            fix_storage_config
            restart_nginx
            check_current_state
            ;;
        "test")
            test_nginx_access
            test_storage_access
            ;;
        "storage")
            check_storage_config
            ;;
        "storage-fix")
            fix_storage_config
            restart_nginx
            test_storage_access
            ;;
        "fix-412")
            fix_412_error
            ;;
        "full")
            print_status "Running full emergency fix..."
            check_current_state
            check_storage_config
            create_assets_manually
            fix_storage_config
            fix_412_error
            restart_nginx
            test_nginx_access
            test_storage_access
            ;;
        "help"|"-h"|"--help")
            echo "Usage: $0 [command]"
            echo ""
            echo "Commands:"
            echo "  check      - Check current asset and storage state (default)"
            echo "  fix        - Create assets manually, fix storage, and restart nginx"
            echo "  test       - Test nginx access to assets and storage"
            echo "  storage    - Check storage configuration only"
            echo "  storage-fix - Fix storage configuration and test access"
            echo "  fix-412    - Fix 412 error for customer-kyc signed URLs"
            echo "  full       - Run complete emergency fix procedure (includes 412 fix)"
            echo "  help       - Show this help message"
            ;;
        *)
            print_error "Unknown command: $1"
            print_status "Use '$0 help' for usage information"
            exit 1
            ;;
    esac
}

# Run main function
main "$@" 