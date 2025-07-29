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

# Read APP_ABBREVIATION from .env file or use default
if [ -f ".env" ] && grep -q "^APP_ABBREVIATION=" .env; then
    APP_ABBREVIATION=$(grep "^APP_ABBREVIATION=" .env | cut -d '=' -f2 | tr -d '"')
else
    print_warning "APP_ABBREVIATION not found in .env, using default 'laravel-app'"
    APP_ABBREVIATION="laravel-app"
fi

print_status "Setting up directories for application: $APP_ABBREVIATION"

BASE_DIR="/mnt/data/digital-epalika/${APP_ABBREVIATION}"

# Create all required directories
print_status "Creating directory structure..."
sudo mkdir -p "$BASE_DIR/storage/app/public"
sudo mkdir -p "$BASE_DIR/storage/logs"
sudo mkdir -p "$BASE_DIR/storage/framework/cache"
sudo mkdir -p "$BASE_DIR/storage/framework/sessions"
sudo mkdir -p "$BASE_DIR/storage/framework/views"
sudo mkdir -p "$BASE_DIR/bootstrap/cache"
sudo mkdir -p "$BASE_DIR/logs/nginx"
sudo mkdir -p "$BASE_DIR/logs/php-fpm"
sudo mkdir -p "$BASE_DIR/logs/supervisor"

# Set proper ownership (1000:1000 matches Docker container's www-data)
print_status "Setting ownership to 1000:1000 (www-data in container)..."
sudo chown -R 1000:1000 "$BASE_DIR"

# Set proper permissions
print_status "Setting directory permissions..."
sudo chmod -R 755 "$BASE_DIR"
sudo chmod -R 775 "$BASE_DIR/storage"
sudo chmod -R 775 "$BASE_DIR/bootstrap/cache"
sudo chmod -R 755 "$BASE_DIR/logs"

# Create necessary files
print_status "Creating log files..."
sudo touch "$BASE_DIR/logs/nginx/access.log"
sudo touch "$BASE_DIR/logs/nginx/error.log"
sudo chown 1000:1000 "$BASE_DIR/logs/nginx/access.log" "$BASE_DIR/logs/nginx/error.log"
sudo chmod 644 "$BASE_DIR/logs/nginx/access.log" "$BASE_DIR/logs/nginx/error.log"

print_status "Host directory setup completed successfully!"
print_status "Base directory: $BASE_DIR"
print_status ""
print_status "You can now run: docker-compose -f docker-compose.prod.yml up"