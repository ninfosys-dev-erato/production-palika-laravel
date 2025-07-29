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

# Main function
main() {
    case "${1:-check}" in
        "check")
            check_current_state
            ;;
        "fix")
            print_warning "Applying emergency asset fix..."
            create_assets_manually
            restart_nginx
            check_current_state
            ;;
        "test")
            test_nginx_access
            ;;
        "full")
            print_status "Running full emergency fix..."
            check_current_state
            create_assets_manually
            restart_nginx
            test_nginx_access
            ;;
        "help"|"-h"|"--help")
            echo "Usage: $0 [command]"
            echo ""
            echo "Commands:"
            echo "  check  - Check current asset state (default)"
            echo "  fix    - Create assets manually and restart nginx"
            echo "  test   - Test nginx access to assets"
            echo "  full   - Run complete emergency fix procedure"
            echo "  help   - Show this help message"
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