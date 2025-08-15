# Production Laravel Docker Container

This Docker configuration provides a hardened, production-ready Laravel application container with Nginx and PHP-FPM.

## Quick Start

### Prerequisites

1. Ensure you have Docker and Docker Compose installed
2. Create a `.env` file in your project root with all required environment variables
3. Set `APP_ABBREVIATION` in your `.env` file (used for directory naming)

### Setup Host Directories

**IMPORTANT**: Before running the container, you must set up the host directories with proper permissions:

```bash
# Run the setup script to create and configure host directories
./docker/8.3-prod/setup-host-directories.sh
```

This script will:
- Create all necessary directories in `/mnt/data/digital-epalika/${APP_ABBREVIATION}/`
- Set proper ownership (1000:1000 to match container's www-data user)
- Set appropriate permissions for Laravel storage and cache directories
- Create nginx log files

### Running the Container

```bash
# Build and start the container
docker-compose -f docker-compose.prod.yml up --build

# Or run in background
docker-compose -f docker-compose.prod.yml up -d --build
```

## Troubleshooting

### Permission Errors

If you see permission denied errors:

1. **Run the setup script first**: `./docker/8.3-prod/setup-host-directories.sh`
2. **Check directory ownership**: Ensure `/mnt/data/digital-epalika/` exists and is writable
3. **Verify APP_ABBREVIATION**: Check your `.env` file has the correct value

### Nginx Configuration Errors

If nginx fails to start:

1. **Missing fastcgi_params**: This is now included in the Docker build
2. **Log directory issues**: The setup script creates proper log directories

### Container Restart Loop

If the container keeps restarting:

1. Check logs: `docker-compose -f docker-compose.prod.yml logs`
2. Verify all required environment variables are set in `.env`
3. Ensure database connectivity (check `DB_HOST`, `DB_PORT`, etc.)

## Directory Structure

The container uses the following mounted volumes:

```
/mnt/data/digital-epalika/${APP_ABBREVIATION}/
├── storage/
│   ├── app/
│   ├── logs/
│   └── framework/
├── bootstrap/cache/
└── logs/
    ├── nginx/
    ├── php-fpm/
    └── supervisor/
```

## Security Features

- Non-root user execution (www-data)
- Security headers in nginx configuration
- Rate limiting
- File access restrictions
- OPcache optimization with blacklist
- Disabled unnecessary PHP functions

## Container Configuration

- **PHP Version**: 8.3
- **Web Server**: Nginx
- **Process Manager**: PHP-FPM
- **Supervisor**: For process management
- **Health Checks**: Built-in health endpoint

## Environment Variables

Key environment variables (set in `.env`):

- `APP_ABBREVIATION`: Used for directory naming and container identification
- `APP_PORT`: Port to expose the application (default: 3000)
- Database settings: `DB_HOST`, `DB_PORT`, `DB_DATABASE`, etc.
- Application settings: `APP_KEY`, `APP_URL`, etc.

## 📊 Monitoring

### Health Checks
- **Container health**: Docker health check every 30s
- **Application health**: `/health` endpoint
- **Process monitoring**: Supervisor manages all processes

### Logging
- **Nginx access logs**: `/tmp/nginx-access.log`
- **Nginx error logs**: `/tmp/nginx-error.log`
- **PHP-FPM logs**: `/tmp/php8.3-fpm*.log`
- **Laravel logs**: `/var/www/html/storage/logs/`
- **Supervisor logs**: `/tmp/*-supervisor.log`

### Log Management
- **Automatic rotation**: Daily log rotation with compression
- **Size limits**: Logs rotated when reaching size limits
- **Retention**: Configurable retention periods (3-14 days)
- **Emergency cleanup**: Automatic cleanup when disk usage > 80%
- **Manual tools**: `log-cleanup` command for manual management

### Performance Monitoring
- **Slow query logging**: PHP-FPM slow log enabled
- **OPcache statistics**: Available via PHP
- **Nginx status**: Can be enabled if needed

## 🔒 Security Checklist

- [x] Non-root user execution
- [x] Capability restrictions
- [x] Security headers
- [x] Rate limiting
- [x] File access control
- [x] PHP function restrictions
- [x] Session security
- [x] Error handling
- [x] Logging and monitoring
- [x] Log rotation and cleanup
- [x] Disk space monitoring
- [x] Network hardening
- [x] Kernel parameter optimization

## ⚙️ Tuning

### Memory Optimization
Adjust PHP-FPM settings in `www.conf`:
```ini
pm.max_children = 50  # Adjust based on available memory
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
```

### OPcache Tuning
Modify `opcache.ini` for your application:
```ini
opcache.memory_consumption = 256  # Increase for larger applications
opcache.max_accelerated_files = 20000
```

### Nginx Tuning
Adjust worker processes in `nginx.conf`:
```nginx
worker_processes auto;  # Or specific number
worker_connections 1024;  # Adjust based on expected load
```

## 🆘 Troubleshooting

### Common Issues

1. **Permission errors**: Ensure volume mounts have correct ownership
   ```bash
   # Fix host directory permissions
   sudo chown -R 1000:1000 /mnt/data/digital-epalika/${APP_ABBREVIATION}/
   sudo chmod -R 755 /mnt/data/digital-epalika/${APP_ABBREVIATION}/
   ```

2. **Memory issues**: Adjust PHP-FPM and OPcache memory settings
3. **Performance issues**: Monitor logs and adjust worker processes
4. **Security alerts**: Check fail2ban logs if enabled
5. **Asset loading issues**: 
   - CSS/JS 403 Forbidden: Livewire and vendor assets are configured to be accessible
   - CSP violations: Content Security Policy allows common CDNs (jsdelivr, cdnjs, tailwindcss, buttons.github.io)
   - MIME type errors: Nginx serves JS/CSS with correct content types
   - Missing Livewire assets: Assets are published during container build
   - Laravel Livewire Tables 404s: Rappasoft assets are automatically created/published
   - Vendor assets: All vendor CSS/JS files are copied to public directory during build
   - Alpine.js errors: Laravel Livewire Tables JavaScript provides the missing functions
   - Versioned vendor files: Proper MIME types for files like nepali.datepicker.v4.0.8.min.js

6. **Rappasoft Laravel Livewire Tables 502/404 errors**:
   ```bash
   # Check current asset state
   docker exec -it container-name emergency-asset-fix check
   
   # Apply emergency fix (creates assets manually)
   docker exec -it container-name emergency-asset-fix fix
   
   # Full diagnostic and fix
   docker exec -it container-name emergency-asset-fix full
   
   # Test nginx access to assets
   docker exec -it container-name emergency-asset-fix test
   ```
   
   The container serves rappasoft assets from two paths for compatibility:
   - `/rappasoft/laravel-livewire-tables/` (primary)
   - `/vendor/rappasoft/laravel-livewire-tables/` (fallback)
   
   If you're getting 502 errors, it's likely due to nginx configuration conflicts.
   The emergency fix script creates minimal working assets and tests access.

7. **Storage files 403 Forbidden errors** (customer-kyc images, etc.):
   ```bash
   # Check storage configuration and symlinks
   docker exec -it container-name emergency-asset-fix storage
   
   # Fix storage configuration and test access
   docker exec -it container-name emergency-asset-fix storage-fix
   
   # Full check including storage
   docker exec -it container-name emergency-asset-fix check
   ```
   
   The container allows access to storage files in specific directories:
   - `/storage/app/public/` (standard Laravel public storage)
   - `/storage/customer-kyc/` (customer KYC documents and images)
   
   Storage files are served with proper MIME types:
   - `.jpg/.jpeg` → `image/jpeg`
   - `.png` → `image/png`
   - `.gif` → `image/gif`
   - `.pdf` → `application/pdf`
   
   If you're getting 403 errors for customer KYC images, the nginx rules now allow access
   to `/storage/customer-kyc/` paths while maintaining security for other storage areas.

### Debug Mode
For debugging, temporarily enable:
```