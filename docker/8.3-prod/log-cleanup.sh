#!/bin/bash

# Log cleanup script for Laravel production container
# Provides emergency cleanup and manual log management

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

# Function to get disk usage
get_disk_usage() {
    df -h /tmp /var/www/html 2>/dev/null || echo "Unable to get disk usage"
}

# Function to get log sizes
get_log_sizes() {
    print_status "Current log file sizes:"
    find /tmp -name "*.log" -type f -exec ls -lh {} \; 2>/dev/null | awk '{print $5 " " $9}'
    find /var/www/html/storage/logs -name "*.log" -type f -exec ls -lh {} \; 2>/dev/null | awk '{print $5 " " $9}'
}

# Emergency cleanup function - truncates logs immediately
emergency_cleanup() {
    print_warning "Performing emergency log cleanup..."
    
    # Truncate all log files instead of deleting to maintain file handles
    find /tmp -name "*.log" -type f -exec truncate -s 0 {} \; 2>/dev/null
    find /var/www/html/storage/logs -name "*.log" -type f -exec truncate -s 0 {} \; 2>/dev/null
    
    # Clean up old compressed logs
    find /tmp -name "*.log.*.gz" -type f -delete 2>/dev/null
    find /var/www/html/storage/logs -name "*.log.*.gz" -type f -delete 2>/dev/null
    
    print_status "Emergency cleanup completed"
}

# Graceful cleanup function - rotates logs properly
graceful_cleanup() {
    print_status "Performing graceful log rotation..."
    
    # Run logrotate with our configuration
    if command -v logrotate >/dev/null 2>&1; then
        logrotate -f /etc/logrotate.d/laravel
    else
        print_warning "Logrotate not available, performing manual rotation..."
        manual_rotation
    fi
    
    print_status "Graceful cleanup completed"
}

# Manual rotation when logrotate is not available
manual_rotation() {
    local timestamp=$(date +%Y%m%d_%H%M%S)
    
    # Rotate nginx logs
    for log in /tmp/nginx-access.log /tmp/nginx-error.log; do
        if [ -f "$log" ] && [ -s "$log" ]; then
            cp "$log" "$log.$timestamp"
            truncate -s 0 "$log"
            gzip "$log.$timestamp" 2>/dev/null || true
        fi
    done
    
    # Rotate PHP-FPM logs
    for log in /tmp/php8.3-fpm*.log; do
        if [ -f "$log" ] && [ -s "$log" ]; then
            cp "$log" "$log.$timestamp"
            truncate -s 0 "$log"
            gzip "$log.$timestamp" 2>/dev/null || true
        fi
    done
    
    # Rotate Laravel logs
    for log in /var/www/html/storage/logs/*.log; do
        if [ -f "$log" ] && [ -s "$log" ]; then
            cp "$log" "$log.$timestamp"
            truncate -s 0 "$log"
            gzip "$log.$timestamp" 2>/dev/null || true
        fi
    done
    
    # Clean up old rotated logs (keep last 7 days)
    find /tmp /var/www/html/storage/logs -name "*.log.*.gz" -type f -mtime +7 -delete 2>/dev/null
}

# Check disk space and warn if getting low
check_disk_space() {
    local usage=$(df /tmp | tail -1 | awk '{print $5}' | sed 's/%//')
    if [ "$usage" -gt 80 ]; then
        print_warning "Disk usage is at ${usage}%, consider running cleanup"
        return 1
    fi
    return 0
}

# Clean old compressed logs
clean_old_logs() {
    local days=${1:-7}
    print_status "Cleaning compressed logs older than $days days..."
    
    find /tmp -name "*.log.*.gz" -type f -mtime +$days -delete 2>/dev/null
    find /var/www/html/storage/logs -name "*.log.*.gz" -type f -mtime +$days -delete 2>/dev/null
    
    print_status "Old log cleanup completed"
}

# Main function
main() {
    case "${1:-status}" in
        "emergency")
            print_warning "Running emergency cleanup - this will truncate all logs immediately!"
            emergency_cleanup
            ;;
        "rotate")
            graceful_cleanup
            ;;
        "clean")
            clean_old_logs "${2:-7}"
            ;;
        "status")
            print_status "Log Status Report"
            echo "===================="
            get_disk_usage
            echo ""
            get_log_sizes
            echo ""
            check_disk_space
            ;;
        "help"|"-h"|"--help")
            echo "Usage: $0 [command] [options]"
            echo ""
            echo "Commands:"
            echo "  status     - Show current log status (default)"
            echo "  emergency  - Emergency cleanup (truncate all logs immediately)"
            echo "  rotate     - Graceful log rotation"
            echo "  clean [N]  - Clean compressed logs older than N days (default: 7)"
            echo "  help       - Show this help message"
            echo ""
            echo "Examples:"
            echo "  $0                    # Show status"
            echo "  $0 emergency          # Emergency cleanup"
            echo "  $0 clean 14           # Clean logs older than 14 days"
            ;;
        *)
            print_error "Unknown command: $1"
            print_status "Use '$0 help' for usage information"
            exit 1
            ;;
    esac
}

# Run main function with all arguments
main "$@" 