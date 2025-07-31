#!/bin/bash

# Debug Access Script - Provides easy access to storage for debugging
# Run this script when you need to access storage directories for debugging

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

# Function to switch to www-data user
as_www_data() {
    print_status "Switching to www-data user for storage access..."
    print_status "You can now access all storage directories freely."
    print_status "Type 'exit' to return to root user."
    exec su - www-data -s /bin/bash
}

# Function to show storage info
show_storage_info() {
    print_status "Storage directory information:"
    echo "================================"
    
    echo "Current user: $(whoami)"
    echo "Current groups: $(groups)"
    echo ""
    
    echo "Main storage directory:"
    ls -la /var/www/html/storage/ 2>/dev/null || echo "Cannot access storage"
    echo ""
    
    echo "Storage/app directory:"
    ls -la /var/www/html/storage/app/ 2>/dev/null || echo "Cannot access storage/app"
    echo ""
    
    echo "Public storage:"
    ls -la /var/www/html/storage/app/public/ 2>/dev/null || echo "Cannot access public storage"
    echo ""
    
    echo "Private storage:"
    ls -la /var/www/html/storage/app/private/ 2>/dev/null || echo "Cannot access private storage"
    echo ""
    
    echo "Customer KYC directory:"
    ls -la /var/www/html/storage/app/private/customer-kyc/ 2>/dev/null || echo "Cannot access customer-kyc directory"
    echo ""

    echo "File Tracking directory:"
    ls -la /var/www/html/storage/app/private/fileTracking/ 2>/dev/null || echo "Cannot access File Tracking directory"
    echo ""
    
    echo "Laravel logs:"
    ls -la /var/www/html/storage/logs/ 2>/dev/null || echo "Cannot access logs directory"
    echo ""
    
    echo "Framework cache:"
    ls -la /var/www/html/storage/framework/ 2>/dev/null || echo "Cannot access framework directory"
    echo ""
    
    echo "Bootstrap cache:"
    ls -la /var/www/html/bootstrap/cache/ 2>/dev/null || echo "Cannot access bootstrap cache"
}

# Function to fix permissions temporarily for debugging
fix_debug_permissions() {
    print_warning "Temporarily making all storage more accessible for debugging..."
    print_warning "This should only be used for debugging, not in production!"
    
    # Add current user to www-data group
    usermod -a -G www-data root 2>/dev/null || true
    
    # Make storage directories group-writable and accessible
    chown -R www-data:www-data /var/www/html/storage 2>/dev/null || true
    chmod -R 775 /var/www/html/storage 2>/dev/null || true
    
    # Make bootstrap cache accessible
    chown -R www-data:www-data /var/www/html/bootstrap/cache 2>/dev/null || true
    chmod -R 775 /var/www/html/bootstrap/cache 2>/dev/null || true
    
    # Ensure all subdirectories are accessible
    find /var/www/html/storage -type d -exec chmod 775 {} \; 2>/dev/null || true
    find /var/www/html/storage -type f -exec chmod 664 {} \; 2>/dev/null || true
    
    print_status "Debug permissions applied. You should now be able to access storage directories."
    print_status "Run 'show_storage_info' to verify access."
}

# Function to restore production permissions
restore_production_permissions() {
    print_status "Restoring production-level permissions..."
    
    # Restore proper ownership
    chown -R www-data:www-data /var/www/html/storage 2>/dev/null || true
    chown -R www-data:www-data /var/www/html/bootstrap/cache 2>/dev/null || true
    
    # Set secure permissions for production
    chmod -R 775 /var/www/html/storage/app/public 2>/dev/null || true
    chmod -R 775 /var/www/html/storage/logs 2>/dev/null || true
    chmod -R 775 /var/www/html/storage/framework 2>/dev/null || true
    chmod -R 775 /var/www/html/bootstrap/cache 2>/dev/null || true
    
    # Private storage should be more restrictive in production
    chmod -R 755 /var/www/html/storage/app/private 2>/dev/null || true
    
    print_status "Production permissions restored."
}

# Function to create test files for debugging
create_test_files() {
    print_status "Creating test files in storage directories..."
    
    # Test file in public storage
    echo "test-public-file" > /var/www/html/storage/app/public/debug-test.txt
    chown www-data:www-data /var/www/html/storage/app/public/debug-test.txt
    chmod 664 /var/www/html/storage/app/public/debug-test.txt
    
    # Test file in private storage
    mkdir -p /var/www/html/storage/app/private/debug
    echo "test-private-file" > /var/www/html/storage/app/private/debug/test.txt
    chown www-data:www-data /var/www/html/storage/app/private/debug/test.txt
    chmod 664 /var/www/html/storage/app/private/debug/test.txt
    
    # Test file in customer-kyc
    mkdir -p /var/www/html/storage/app/private/customer-kyc/debug
    echo "test-kyc-file" > /var/www/html/storage/app/private/customer-kyc/debug/test.jpg
    chown www-data:www-data /var/www/html/storage/app/private/customer-kyc/debug/test.jpg
    chmod 664 /var/www/html/storage/app/private/customer-kyc/debug/test.jpg
    
    # Test log file
    echo "test-log-entry" > /var/www/html/storage/logs/debug.log
    chown www-data:www-data /var/www/html/storage/logs/debug.log
    chmod 664 /var/www/html/storage/logs/debug.log
    
    print_status "Test files created successfully!"
    print_status "- Public: /var/www/html/storage/app/public/debug-test.txt"
    print_status "- Private: /var/www/html/storage/app/private/debug/test.txt"
    print_status "- KYC: /var/www/html/storage/app/private/customer-kyc/debug/test.jpg"
    print_status "- Log: /var/www/html/storage/logs/debug.log"
}

# Function to clean up test files
cleanup_test_files() {
    print_status "Cleaning up test files..."
    
    rm -f /var/www/html/storage/app/public/debug-test.txt
    rm -rf /var/www/html/storage/app/private/debug
    rm -rf /var/www/html/storage/app/private/customer-kyc/debug
    rm -f /var/www/html/storage/logs/debug.log
    
    print_status "Test files cleaned up."
}

# Function to test web access to storage files
test_web_access() {
    print_status "Testing web access to storage files..."
    
    # Create a test file if it doesn't exist
    if [ ! -f "/var/www/html/storage/app/public/debug-test.txt" ]; then
        echo "web-test-file" > /var/www/html/storage/app/public/debug-test.txt
        chown www-data:www-data /var/www/html/storage/app/public/debug-test.txt
        chmod 664 /var/www/html/storage/app/public/debug-test.txt
    fi
    
    # Test public storage access via web
    if curl -s -o /dev/null -w "%{http_code}" "http://localhost/storage/debug-test.txt" | grep -q "200"; then
        print_status "✓ Public storage web access working"
    else
        print_error "✗ Public storage web access not working"
    fi
    
    # Test customer-kyc access via web (if route exists)
    if [ -f "/var/www/html/storage/app/private/customer-kyc/debug/test.jpg" ]; then
        if curl -s -o /dev/null -w "%{http_code}" "http://localhost/storage/customer-kyc/debug/test.jpg" | grep -q "200"; then
            print_status "✓ Customer-KYC web access working"
        else
            print_warning "⚠ Customer-KYC web access may not be configured"
        fi
    fi
}

# Main function
main() {
    case "${1:-help}" in
        "info"|"status")
            show_storage_info
            ;;
        "fix"|"debug")
            fix_debug_permissions
            show_storage_info
            ;;
        "restore"|"production")
            restore_production_permissions
            ;;
        "www"|"www-data")
            as_www_data
            ;;
        "test"|"create-test")
            create_test_files
            test_web_access
            ;;
        "clean"|"cleanup")
            cleanup_test_files
            ;;
        "web-test")
            test_web_access
            ;;
        "setup-upload")
            print_status "Setting up direct upload system..."
            /usr/local/bin/setup-direct-upload
            ;;
        "fix-vite")
            print_status "Fixing Vite build issues..."
            /usr/local/bin/fix-vite-build
            ;;
        "full"|"full-debug")
            print_status "Running full debug setup..."
            fix_debug_permissions
            create_test_files
            test_web_access
            show_storage_info
            ;;
        "help"|"-h"|"--help")
            echo "Debug Access Script for Laravel Storage"
            echo "======================================="
            echo ""
            echo "Usage: $0 [command]"
            echo ""
            echo "Commands:"
            echo "  info           - Show storage directory information and permissions"
            echo "  fix            - Fix permissions for debugging access"
            echo "  restore        - Restore production-level permissions"
            echo "  www            - Switch to www-data user for full access"
            echo "  test           - Create test files and test web access"
            echo "  clean          - Clean up test files"
            echo "  web-test       - Test web access to storage files"
            echo "  setup-upload   - Set up direct upload system for KYC forms"
            echo "  fix-vite       - Fix Vite build issues and rebuild assets"
            echo "  full           - Run complete debugging setup (fix + test + info)"
            echo "  help           - Show this help message"
            echo ""
            echo "Examples:"
            echo "  $0 info        # Check current permissions"
            echo "  $0 fix         # Fix permissions for debugging"
            echo "  $0 www         # Switch to www-data user"
            echo "  $0 full        # Complete debugging setup"
            echo ""
            echo "Quick debugging workflow:"
            echo "1. $0 info      # Check current state"
            echo "2. $0 fix       # Fix permissions if needed"
            echo "3. $0 www       # Switch to www-data for full access"
            echo "4. $0 restore   # Restore production permissions when done"
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