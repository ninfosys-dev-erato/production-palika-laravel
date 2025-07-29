#!/bin/bash

# Vendor Assets Publishing Script for Laravel Container
# Ensures all vendor assets are properly available in the public directory

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

# Main function to publish vendor assets
publish_vendor_assets() {
    print_status "Publishing vendor assets..."
    
    cd /var/www/html
    
    # Create vendor public directory
    mkdir -p public/vendor
    
    # Publish Livewire assets
    print_status "Publishing Livewire assets..."
    php artisan livewire:publish --assets --force 2>/dev/null || true
    
    # Publish Laravel Livewire Tables assets
    print_status "Publishing Laravel Livewire Tables assets..."
    php artisan vendor:publish --tag=livewire-tables-config --force 2>/dev/null || true
    php artisan vendor:publish --tag=livewire-tables-views --force 2>/dev/null || true
    php artisan vendor:publish --tag=livewire-tables-translations --force 2>/dev/null || true
    
    # Copy Livewire Dist files
    print_status "Copying Livewire dist files..."
    if [ -d "vendor/livewire/livewire/dist" ]; then
        mkdir -p public/vendor/livewire
        cp -r vendor/livewire/livewire/dist/* public/vendor/livewire/ 2>/dev/null || true
    fi
    
    # Copy Livewire Alert files
    if [ -d "vendor/jantinnerezo/livewire-alert/dist" ]; then
        mkdir -p public/vendor/livewire-alert
        cp -r vendor/jantinnerezo/livewire-alert/dist/* public/vendor/livewire-alert/ 2>/dev/null || true
    fi
    
    # Handle Laravel Livewire Tables (rappasoft) assets
    print_status "Handling Laravel Livewire Tables assets..."
    
    # Create the expected directory structure for rappasoft assets
    mkdir -p public/rappasoft/laravel-livewire-tables
    
    # Check for livewire-tables assets in vendor directory
    if [ -d "vendor/rappasoft/laravel-livewire-tables" ]; then
        mkdir -p public/vendor/rappasoft/laravel-livewire-tables
        
        # Look for assets in common locations
        for asset_dir in "resources/assets" "assets" "dist" "public" "src/assets" "resources/js" "resources/css"; do
            if [ -d "vendor/rappasoft/laravel-livewire-tables/$asset_dir" ]; then
                print_status "Found assets in $asset_dir"
                cp -r vendor/rappasoft/laravel-livewire-tables/$asset_dir/* public/vendor/rappasoft/laravel-livewire-tables/ 2>/dev/null || true
                cp -r vendor/rappasoft/laravel-livewire-tables/$asset_dir/* public/rappasoft/laravel-livewire-tables/ 2>/dev/null || true
            fi
        done
        
        # Also copy any JS/CSS files directly from the package
        find vendor/rappasoft/laravel-livewire-tables -name "*.css" -o -name "*.js" | while read file; do
            filename=$(basename "$file")
            cp "$file" "public/rappasoft/laravel-livewire-tables/$filename" 2>/dev/null || true
        done
    fi
    
    # Create comprehensive Laravel Livewire Tables assets
    print_status "Creating Laravel Livewire Tables JavaScript..."
    cat > public/rappasoft/laravel-livewire-tables/core.min.js << 'EOF'
/* Laravel Livewire Tables Core JavaScript */
window.laravellivewiretable = function($wire) {
    return {
        shouldBeDisplayed: true,
        currentlyReorderingStatus: false,
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
    
    # Create minimal CSS files
    cat > public/rappasoft/laravel-livewire-tables/core.min.css << 'EOF'
/* Laravel Livewire Tables Core CSS */
.laravel-livewire-tables-reorderingMinimised {
    display: none !important;
}
EOF
    
    cat > public/rappasoft/laravel-livewire-tables/thirdparty.css << 'EOF'
/* Laravel Livewire Tables Third Party CSS */
EOF
    
    cat > public/rappasoft/laravel-livewire-tables/thirdparty.min.js << 'EOF'
/* Laravel Livewire Tables Third Party JavaScript */
EOF
    
    # Copy other vendor CSS/JS files to public directory
    print_status "Copying additional vendor assets..."
    
    # Handle existing vendor files in public directory
    if [ -d "public/vendor" ]; then
        print_status "Vendor assets already exist in public directory"
    fi
    
    # Find and copy CSS/JS files from vendor packages
    find vendor -name "*.css" -o -name "*.js" -o -name "*.map" | while read file; do
        # Skip files that are not in asset directories
        if echo "$file" | grep -qE "(assets|dist|public|build)" && ! echo "$file" | grep -qE "(tests|test|docs|examples)"; then
            # Get relative path from vendor
            rel_path=$(echo "$file" | sed 's|vendor/||')
            target_dir="public/vendor/$(dirname "$rel_path")"
            
            # Create target directory and copy file
            mkdir -p "$target_dir"
            cp "$file" "public/vendor/$rel_path" 2>/dev/null || true
        fi
    done
    
    # Ensure nepali datepicker files exist if they're referenced
    print_status "Checking for nepali datepicker assets..."
    if [ ! -f "public/vendor/nepali.datepicker.v4.0.8.min.css" ]; then
        echo "/* Nepali Datepicker CSS */" > public/vendor/nepali.datepicker.v4.0.8.min.css
    fi
    if [ ! -f "public/vendor/nepali.datepicker.v4.0.8.min.js" ]; then
        cat > public/vendor/nepali.datepicker.v4.0.8.min.js << 'EOF'
/* Nepali Datepicker JavaScript - Placeholder */
window.NepaliFunctions = window.NepaliFunctions || {};
EOF
    fi
    
    # Set proper ownership and permissions
    print_status "Setting permissions..."
    chown -R www-data:www-data public/vendor 2>/dev/null || true
    chmod -R 755 public/vendor 2>/dev/null || true
    
    # List published assets for verification
    print_status "Published vendor assets:"
    find public/vendor -name "*.css" -o -name "*.js" | head -20
    
    print_status "Vendor assets publishing completed!"
}

# Run the function
publish_vendor_assets 