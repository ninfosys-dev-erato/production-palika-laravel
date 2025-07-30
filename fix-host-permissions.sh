#!/bin/bash

# Fix Host Permissions Script
# Run this script on the host to fix permission issues before starting the container

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
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

print_status "🔧 Fixing Host Directory Permissions"
print_status "==================================="

# Check if running as root or with sudo
if [ "$EUID" -eq 0 ]; then
    SUDO=""
elif command -v sudo >/dev/null 2>&1; then
    SUDO="sudo"
    print_status "Using sudo for administrative operations"
else
    print_error "This script requires root access or sudo. Please run with sudo or as root."
    exit 1
fi

# Read APP_ABBREVIATION from .env file or use default
if [ -f ".env" ] && grep -q "^APP_ABBREVIATION=" .env; then
    APP_ABBREVIATION=$(grep "^APP_ABBREVIATION=" .env | cut -d '=' -f2 | tr -d '"' | tr -d "'")
else
    print_warning "APP_ABBREVIATION not found in .env, using default 'laravel-app'"
    APP_ABBREVIATION="laravel-app"
fi

print_status "Fixing permissions for application: $APP_ABBREVIATION"

BASE_DIR="/mnt/data/digital-epalika/${APP_ABBREVIATION}"

# Check if base directory exists
if [ ! -d "$BASE_DIR" ]; then
    print_error "Base directory $BASE_DIR does not exist!"
    print_status "Please run the setup script first: ./docker/8.3-prod/setup-host-directories.sh"
    exit 1
fi

print_status "Base directory: $BASE_DIR"

# Fix ownership to match Docker container (1000:1000)
print_status "Setting ownership to 1000:1000 (www-data in container)..."
$SUDO chown -R 1000:1000 "$BASE_DIR"

# Fix directory permissions
print_status "Setting directory permissions..."
$SUDO find "$BASE_DIR" -type d -exec chmod 755 {} \;
$SUDO find "$BASE_DIR" -type f -exec chmod 644 {} \;

# Set specific permissions for storage directories
print_status "Setting storage-specific permissions..."
$SUDO chmod -R 775 "$BASE_DIR/storage" 2>/dev/null || true
$SUDO chmod -R 775 "$BASE_DIR/bootstrap/cache" 2>/dev/null || true
$SUDO chmod -R 755 "$BASE_DIR/logs" 2>/dev/null || true

# Ensure all subdirectories are accessible
print_status "Ensuring all subdirectories are accessible..."
$SUDO find "$BASE_DIR/storage" -type d -exec chmod 755 {} \; 2>/dev/null || true
$SUDO find "$BASE_DIR/storage" -type f -exec chmod 644 {} \; 2>/dev/null || true

# Fix specific problematic directories
print_status "Fixing specific directories..."
$SUDO chmod -R 755 "$BASE_DIR/storage/app/private" 2>/dev/null || true
$SUDO chmod -R 755 "$BASE_DIR/storage/app/private/fileTracking" 2>/dev/null || true

# Verify the fix
print_status "Verifying permissions..."
if [ -r "$BASE_DIR/storage" ] && [ -w "$BASE_DIR/storage" ]; then
    print_status "✅ Storage directory is readable and writable"
else
    print_error "❌ Storage directory is still not accessible"
    print_status "Trying alternative approach..."
    $SUDO chmod -R 777 "$BASE_DIR/storage" 2>/dev/null || true
fi

# Check ownership
if [ "$(stat -c '%U:%G' "$BASE_DIR")" = "1000:1000" ]; then
    print_status "✅ Ownership is correct (1000:1000)"
else
    print_warning "⚠️  Ownership is not 1000:1000, but continuing..."
fi

print_status ""
print_status "🎉 Host Permissions Fix Completed!"
print_status "=================================="
print_status ""
print_status "You can now try starting the container:"
print_status "docker-compose -f docker-compose.prod.yml up"
print_status ""
print_status "If you still have issues, try:"
print_status "1. Stop the container: docker-compose -f docker-compose.prod.yml down"
print_status "2. Remove the container: docker-compose -f docker-compose.prod.yml rm -f"
print_status "3. Start again: docker-compose -f docker-compose.prod.yml up" 