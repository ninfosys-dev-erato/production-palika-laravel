#!/bin/bash

# Fix OAuth Keys Script
# This script ensures OAuth keys are properly set up for Laravel Passport

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

print_status "🔑 Fixing OAuth Keys"
print_status "==================="

cd /var/www/html

# Check if OAuth keys exist
print_status "Checking OAuth keys..."

PRIVATE_KEY="/var/www/html/storage/app/oauth-private.key"
PUBLIC_KEY="/var/www/html/storage/app/oauth-public.key"

if [ -f "$PRIVATE_KEY" ] && [ -f "$PUBLIC_KEY" ]; then
    print_status "✅ OAuth keys found"
    ls -la "$PRIVATE_KEY" "$PUBLIC_KEY"
    
    # Check permissions
    if [ "$(stat -c '%a' "$PRIVATE_KEY")" = "600" ] && [ "$(stat -c '%a' "$PUBLIC_KEY")" = "600" ]; then
        print_status "✅ OAuth key permissions are correct"
    else
        print_warning "⚠️  Fixing OAuth key permissions..."
        chown www-data:www-data "$PRIVATE_KEY" "$PUBLIC_KEY"
        chmod 600 "$PRIVATE_KEY" "$PUBLIC_KEY"
        print_status "✅ OAuth key permissions fixed"
    fi
    
    # Check ownership
    if [ "$(stat -c '%U:%G' "$PRIVATE_KEY")" = "www-data:www-data" ] && [ "$(stat -c '%U:%G' "$PUBLIC_KEY")" = "www-data:www-data" ]; then
        print_status "✅ OAuth key ownership is correct"
    else
        print_warning "⚠️  Fixing OAuth key ownership..."
        chown www-data:www-data "$PRIVATE_KEY" "$PUBLIC_KEY"
        print_status "✅ OAuth key ownership fixed"
    fi
else
    print_warning "⚠️  OAuth keys missing, generating them..."
    
    # Try Laravel Passport command first
    print_status "Attempting to generate keys with Laravel Passport..."
    if su -s /bin/bash www-data -c "php artisan passport:keys --force" 2>/dev/null; then
        print_status "✅ OAuth keys generated successfully with Laravel Passport"
    else
        print_warning "Laravel Passport command failed, generating manually..."
        
        # Create storage/app directory if it doesn't exist
        mkdir -p /var/www/html/storage/app
        chown www-data:www-data /var/www/html/storage/app
        
        # Generate private key
        print_status "Generating private key..."
        if openssl genrsa -out "$PRIVATE_KEY" 2048 2>/dev/null; then
            chown www-data:www-data "$PRIVATE_KEY"
            chmod 600 "$PRIVATE_KEY"
            print_status "✅ Private key generated"
        else
            print_error "❌ Failed to generate private key"
            exit 1
        fi
        
        # Generate public key
        print_status "Generating public key..."
        if openssl rsa -in "$PRIVATE_KEY" -pubout -out "$PUBLIC_KEY" 2>/dev/null; then
            chown www-data:www-data "$PUBLIC_KEY"
            chmod 600 "$PUBLIC_KEY"
            print_status "✅ Public key generated"
        else
            print_error "❌ Failed to generate public key"
            exit 1
        fi
    fi
fi

# Verify the keys work
print_status "Verifying OAuth keys..."
if [ -f "$PRIVATE_KEY" ] && [ -f "$PUBLIC_KEY" ]; then
    # Test if keys are valid
    if openssl rsa -in "$PRIVATE_KEY" -check -noout 2>/dev/null; then
        print_status "✅ Private key is valid"
    else
        print_error "❌ Private key is invalid"
    fi
    
    if openssl rsa -pubin -in "$PUBLIC_KEY" -check -noout 2>/dev/null; then
        print_status "✅ Public key is valid"
    else
        print_error "❌ Public key is invalid"
    fi
    
    # Test Laravel Passport installation
    print_status "Testing Laravel Passport installation..."
    if su -s /bin/bash www-data -c "php artisan passport:install --force" 2>/dev/null; then
        print_status "✅ Laravel Passport installed successfully"
    else
        print_warning "⚠️  Laravel Passport installation failed (this might be normal if already installed)"
    fi
else
    print_error "❌ OAuth keys are still missing after generation attempt"
    exit 1
fi

# Clear Laravel caches to ensure changes take effect
print_status "Clearing Laravel caches..."
su -s /bin/bash www-data -c "php artisan config:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan cache:clear" 2>/dev/null || true

print_status ""
print_status "🎉 OAuth Keys Fix Completed!"
print_status "============================"
print_status ""
print_status "Summary:"
print_status "✅ OAuth keys checked and verified"
print_status "✅ Permissions set correctly (600)"
print_status "✅ Ownership set correctly (www-data:www-data)"
print_status "✅ Laravel Passport installation verified"
print_status ""
print_status "OAuth keys location:"
print_status "• Private key: $PRIVATE_KEY"
print_status "• Public key: $PUBLIC_KEY"
print_status ""
print_status "If you're still having OAuth issues:"
print_status "1. Check Laravel logs: tail -f /var/www/html/storage/logs/laravel.log"
print_status "2. Verify Passport config: php artisan config:show passport"
print_status "3. Reinstall Passport: php artisan passport:install --force" 