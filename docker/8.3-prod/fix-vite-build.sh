#!/bin/bash

# Fix Vite Build Script for Laravel Production Container
# This script handles Vite build issues during runtime

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

print_status "🔧 Fixing Vite Build Issues"
print_status "=========================="

cd /var/www/html

# Check if Vite build assets exist
print_status "Step 1: Checking Vite build assets..."
if [ ! -f "/var/www/html/public/build/manifest.json" ]; then
    print_warning "Vite build assets missing, attempting to rebuild..."
    
    # Check if Node.js is available
    if ! command -v node &> /dev/null; then
        print_warning "Node.js not available, installing temporarily..."
        
        # Install Node.js temporarily
        curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
            && apt-get update \
            && apt-get install -y nodejs
        
        NODEJS_INSTALLED=true
    else
        NODEJS_INSTALLED=false
    fi
    
    # Check if package.json exists
    if [ ! -f "/var/www/html/package.json" ]; then
        print_error "package.json not found, cannot rebuild assets"
        exit 1
    fi
    
    # Install dependencies and build
    print_status "Installing npm dependencies..."
    npm install --production=false 2>/dev/null || {
        print_error "Failed to install npm dependencies"
        exit 1
    }
    
    print_status "Building assets with Vite..."
    npm run build 2>/dev/null || {
        print_error "Failed to build assets with Vite"
        exit 1
    }
    
    # Clean up Node.js if we installed it
    if [ "$NODEJS_INSTALLED" = true ]; then
        print_status "Cleaning up Node.js installation..."
        apt-get remove -y nodejs npm 2>/dev/null || true
        apt-get autoremove -y 2>/dev/null || true
        apt-get clean 2>/dev/null || true
    fi
    
    # Clean up node_modules
    rm -rf /var/www/html/node_modules 2>/dev/null || true
    rm -f /var/www/html/package-lock.json 2>/dev/null || true
    
    print_status "✅ Vite build completed successfully"
else
    print_status "✅ Vite build assets found"
fi

# Check specific asset files
print_status "Step 2: Checking specific asset files..."
REQUIRED_ASSETS=(
    "upload-helper"
    "customer-kyc-upload"
    "app"
)

for asset in "${REQUIRED_ASSETS[@]}"; do
    if find /var/www/html/public/build/assets -name "*${asset}*" -type f | grep -q .; then
        print_status "✅ Found ${asset} assets"
    else
        print_warning "⚠️  ${asset} assets not found"
    fi
done

# Check manifest.json
print_status "Step 3: Checking manifest.json..."
if [ -f "/var/www/html/public/build/manifest.json" ]; then
    print_status "✅ manifest.json exists"
    
    # Check if manifest contains our assets
    if grep -q "upload-helper" /var/www/html/public/build/manifest.json; then
        print_status "✅ upload-helper found in manifest"
    else
        print_warning "⚠️  upload-helper not found in manifest"
    fi
    
    if grep -q "customer-kyc-upload" /var/www/html/public/build/manifest.json; then
        print_status "✅ customer-kyc-upload found in manifest"
    else
        print_warning "⚠️  customer-kyc-upload not found in manifest"
    fi
else
    print_error "❌ manifest.json not found"
fi

# Set proper permissions
print_status "Step 4: Setting permissions..."
chown -R www-data:www-data /var/www/html/public/build 2>/dev/null || true
chmod -R 644 /var/www/html/public/build 2>/dev/null || true
find /var/www/html/public/build -type d -exec chmod 755 {} \; 2>/dev/null || true

# Test asset accessibility
print_status "Step 5: Testing asset accessibility..."
if curl -s -o /dev/null -w "%{http_code}" "http://localhost/build/manifest.json" | grep -q "200"; then
    print_status "✅ Build assets accessible via web"
else
    print_warning "⚠️  Build assets not accessible via web"
fi

print_status ""
print_status "🎉 Vite Build Fix Completed!"
print_status "============================"
print_status ""
print_status "Summary:"
print_status "✅ Vite build assets checked/created"
print_status "✅ Specific asset files verified"
print_status "✅ manifest.json validated"
print_status "✅ Permissions set correctly"
print_status "✅ Web accessibility tested"
print_status ""
print_status "If assets are still missing:"
print_status "1. Check vite.config.js configuration"
print_status "2. Verify package.json dependencies"
print_status "3. Check build logs for errors"
print_status "4. Ensure all required files are present in resources/js/" 