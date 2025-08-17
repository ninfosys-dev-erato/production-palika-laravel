#!/bin/bash

# Performance Test Script for Laravel
# Tests various aspects of performance after optimization

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

print_status "🧪 Laravel Performance Test Suite"
print_status "================================="

# Test 1: System Resources
print_status "Test 1: System Resources"
echo "================================"
echo "CPU Cores: $(nproc)"
echo "Total Memory: $(free -h | grep Mem | awk '{print $2}')"
echo "Available Memory: $(free -h | grep Mem | awk '{print $7}')"
echo "Disk Space: $(df -h / | tail -1 | awk '{print $4}') available"
echo ""

# Test 2: PHP-FPM Status
print_status "Test 2: PHP-FPM Status"
echo "================================"
echo "PHP-FPM Processes: $(ps aux | grep php-fpm | grep -v grep | wc -l)"
echo "PHP Version: $(php -v | head -1)"
echo "PHP Memory Limit: $(php -r 'echo ini_get("memory_limit");')"
echo "PHP Max Execution Time: $(php -r 'echo ini_get("max_execution_time");')"
echo ""

# Test 3: OPcache Status
print_status "Test 3: OPcache Status"
echo "================================"
if php -m | grep -q opcache; then
    echo "OPcache: Enabled"
    php -r '
    if(function_exists("opcache_get_status")) {
        $status = opcache_get_status();
        echo "Memory Used: " . round($status["memory_usage"]["used_memory"]/1024/1024, 2) . "MB\n";
        echo "Memory Free: " . round($status["memory_usage"]["free_memory"]/1024/1024, 2) . "MB\n";
        echo "Hit Rate: " . round($status["opcache_statistics"]["opcache_hit_rate"], 2) . "%\n";
        echo "Cached Files: " . $status["opcache_statistics"]["num_cached_files"] . "\n";
        echo "Cached Keys: " . $status["opcache_statistics"]["num_cached_keys"] . "\n";
    } else {
        echo "OPcache status not available\n";
    }
    '
else
    echo "OPcache: Not enabled"
fi
echo ""

# Test 4: Nginx Status
print_status "Test 4: Nginx Status"
echo "================================"
echo "Nginx Processes: $(ps aux | grep nginx | grep -v grep | wc -l)"
echo "Nginx Version: $(nginx -v 2>&1)"
echo "Active Connections: $(netstat -an | grep :80 | grep ESTABLISHED | wc -l)"
echo ""

# Test 5: Laravel Cache Status
print_status "Test 5: Laravel Cache Status"
echo "================================"
cd /var/www/html
echo "Config Cache: $(ls -la bootstrap/cache/config.php 2>/dev/null | wc -l | sed 's/1/exists/' | sed 's/0/missing/')"
echo "Route Cache: $(ls -la bootstrap/cache/routes.php 2>/dev/null | wc -l | sed 's/1/exists/' | sed 's/0/missing/')"
echo "View Cache: $(ls -la bootstrap/cache/packages.php 2>/dev/null | wc -l | sed 's/1/exists/' | sed 's/0/missing/')"
echo "Storage Permissions: $(ls -ld storage | awk '{print $1}')"
echo "Bootstrap Cache Permissions: $(ls -ld bootstrap/cache | awk '{print $1}')"
echo ""

# Test 6: Response Time Test
print_status "Test 6: Response Time Test"
echo "================================"
echo "Testing homepage response time..."
for i in {1..5}; do
    response_time=$(curl -s -w "%{time_total}" -o /dev/null http://localhost/ 2>/dev/null)
    echo "Request $i: ${response_time}s"
done
echo ""

# Test 7: Concurrent Connection Test
print_status "Test 7: Concurrent Connection Test"
echo "================================"
echo "Testing 10 concurrent connections..."
start_time=$(date +%s.%N)
for i in {1..10}; do
    curl -s -o /dev/null http://localhost/ &
done
wait
end_time=$(date +%s.%N)
duration=$(echo "$end_time - $start_time" | bc -l 2>/dev/null || echo "0")
echo "10 concurrent requests completed in: ${duration}s"
echo ""

# Test 8: Database Connection Test (if applicable)
print_status "Test 8: Database Connection Test"
echo "================================"
if [ -f "/var/www/html/config/database.php" ]; then
    echo "Testing database connection..."
    if su -s /bin/bash www-data -c "php artisan tinker --execute='echo \"DB connected: \" . (DB::connection()->getPdo() ? \"Yes\" : \"No\");'" 2>/dev/null; then
        echo "Database: Connected successfully"
    else
        echo "Database: Connection failed or not configured"
    fi
else
    echo "Database configuration not found"
fi
echo ""

# Test 9: File System Performance
print_status "Test 9: File System Performance"
echo "================================"
echo "Testing file read performance..."
start_time=$(date +%s.%N)
for i in {1..100}; do
    cat /var/www/html/bootstrap/cache/config.php > /dev/null 2>/dev/null || true
done
end_time=$(date +%s.%N)
duration=$(echo "$end_time - $start_time" | bc -l 2>/dev/null || echo "0")
echo "100 file reads completed in: ${duration}s"
echo ""

# Test 10: Memory Usage Summary
print_status "Test 10: Memory Usage Summary"
echo "================================"
echo "System Memory:"
free -h
echo ""
echo "Process Memory Usage:"
ps aux --sort=-%mem | head -10 | awk '{print $2, $3, $4, $11}' | column -t
echo ""

print_status "🎯 Performance Test Complete!"
print_status "============================="
print_status ""
print_status "Performance Recommendations:"
print_status "• If response times > 1s: Check database queries and indexes"
print_status "• If memory usage > 80%: Consider increasing server memory"
print_status "• If OPcache hit rate < 90%: Check OPcache configuration"
print_status "• If concurrent requests slow: Check PHP-FPM settings"
print_status ""
print_status "Run 'monitor-performance' for real-time monitoring"
print_status "Run 'aggressive-performance-optimize' to apply optimizations" 