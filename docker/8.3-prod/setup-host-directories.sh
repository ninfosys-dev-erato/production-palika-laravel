#!/bin/bash

# Setup script for Palika production Docker environment
# This script creates and sets up host directories with proper permissions

set -e

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

# Check if running as root or with sudo
check_permissions() {
    if [ "$EUID" -eq 0 ]; then
        SUDO=""
    elif command -v sudo >/dev/null 2>&1; then
        SUDO="sudo"
        print_status "Using sudo for administrative operations"
    else
        print_error "This script requires root access or sudo. Please run with sudo or as root."
        exit 1
    fi
}

# Read APP_ABBREVIATION from .env file or use default
if [ -f ".env" ] && grep -q "^APP_ABBREVIATION=" .env; then
    APP_ABBREVIATION=$(grep "^APP_ABBREVIATION=" .env | cut -d '=' -f2 | tr -d '"' | tr -d "'")
else
    print_warning "APP_ABBREVIATION not found in .env, using default 'laravel-app'"
    APP_ABBREVIATION="laravel-app"
fi

print_status "Setting up directories for application: $APP_ABBREVIATION"

BASE_DIR="/mnt/data/digital-epalika/${APP_ABBREVIATION}"

# Check permissions
check_permissions

# Create base directory if it doesn't exist
print_status "Creating base directory: $BASE_DIR"
$SUDO mkdir -p "$BASE_DIR"

# Create all required directories
print_status "Creating directory structure..."
$SUDO mkdir -p "$BASE_DIR/storage/app/public"
$SUDO mkdir -p "$BASE_DIR/storage/logs"
$SUDO mkdir -p "$BASE_DIR/storage/framework/cache/data"
$SUDO mkdir -p "$BASE_DIR/storage/framework/sessions"
$SUDO mkdir -p "$BASE_DIR/storage/framework/views"
$SUDO mkdir -p "$BASE_DIR/bootstrap/cache"
$SUDO mkdir -p "$BASE_DIR/logs/nginx"
$SUDO mkdir -p "$BASE_DIR/logs/php-fpm"
$SUDO mkdir -p "$BASE_DIR/logs/supervisor"

# Set proper ownership (1000:1000 matches Docker container's www-data)
print_status "Setting ownership to 1000:1000 (www-data in container)..."
$SUDO chown -R 1000:1000 "$BASE_DIR"

# Set proper permissions
print_status "Setting directory permissions..."
$SUDO chmod -R 755 "$BASE_DIR"
$SUDO chmod -R 775 "$BASE_DIR/storage"
$SUDO chmod -R 775 "$BASE_DIR/bootstrap/cache"
$SUDO chmod -R 755 "$BASE_DIR/logs"

# Create necessary files
print_status "Creating log files..."
$SUDO touch "$BASE_DIR/logs/nginx/access.log"
$SUDO touch "$BASE_DIR/logs/nginx/error.log"
$SUDO touch "$BASE_DIR/logs/php-fpm/error.log"
$SUDO touch "$BASE_DIR/logs/php-fpm/access.log"
$SUDO touch "$BASE_DIR/logs/php-fpm/slow.log"
$SUDO touch "$BASE_DIR/logs/supervisor/supervisord.log"

# Set proper ownership for log files
$SUDO chown 1000:1000 "$BASE_DIR/logs/nginx/access.log" "$BASE_DIR/logs/nginx/error.log"
$SUDO chown 1000:1000 "$BASE_DIR/logs/php-fpm/"*.log
$SUDO chown 1000:1000 "$BASE_DIR/logs/supervisor/supervisord.log"
$SUDO chmod 644 "$BASE_DIR/logs/nginx/"*.log
$SUDO chmod 644 "$BASE_DIR/logs/php-fpm/"*.log
$SUDO chmod 644 "$BASE_DIR/logs/supervisor/"*.log

print_status "Host directory setup completed successfully!"
print_status "Base directory: $BASE_DIR"
print_status "Directory structure:"
print_status "  - storage/ (775 permissions)"
print_status "  - bootstrap/cache/ (775 permissions)"
print_status "  - logs/ (755 permissions)"
print_status ""
print_status "You can now run: docker-compose -f docker-compose.prod.yml up"