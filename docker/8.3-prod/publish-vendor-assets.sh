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
    
    # Check for livewire-tables assets
    if [ -d "vendor/rappasoft/laravel-livewire-tables" ]; then
        mkdir -p public/vendor/rappasoft/laravel-livewire-tables
        
        # Look for assets in common locations
        for asset_dir in "resources/assets" "assets" "dist" "public" "src/assets"; do
            if [ -d "vendor/rappasoft/laravel-livewire-tables/$asset_dir" ]; then
                print_status "Found assets in $asset_dir"
                cp -r vendor/rappasoft/laravel-livewire-tables/$asset_dir/* public/vendor/rappasoft/laravel-livewire-tables/ 2>/dev/null || true
            fi
        done
        
        # Create default CSS/JS files if they don't exist
        mkdir -p public/rappasoft/laravel-livewire-tables
        
        # Create minimal CSS files if not found
        if [ ! -f "public/rappasoft/laravel-livewire-tables/core.min.css" ]; then
            echo "/* Laravel Livewire Tables Core CSS - Auto-generated */" > public/rappasoft/laravel-livewire-tables/core.min.css
        fi
        
        if [ ! -f "public/rappasoft/laravel-livewire-tables/thirdparty.css" ]; then
            echo "/* Laravel Livewire Tables Third Party CSS - Auto-generated */" > public/rappasoft/laravel-livewire-tables/thirdparty.css
        fi
        
        # Create minimal JS files if not found
        if [ ! -f "public/rappasoft/laravel-livewire-tables/core.min.js" ]; then
            echo "/* Laravel Livewire Tables Core JS - Auto-generated */" > public/rappasoft/laravel-livewire-tables/core.min.js
        fi
        
        if [ ! -f "public/rappasoft/laravel-livewire-tables/thirdparty.min.js" ]; then
            echo "/* Laravel Livewire Tables Third Party JS - Auto-generated */" > public/rappasoft/laravel-livewire-tables/thirdparty.min.js
        fi
    fi
    
    # Copy other vendor CSS/JS files to public directory
    print_status "Copying additional vendor assets..."
    
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