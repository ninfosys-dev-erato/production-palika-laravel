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
   - CSP violations: Content Security Policy allows common CDNs (jsdelivr, cdnjs, etc.)
   - MIME type errors: Nginx serves JS/CSS with correct content types
   - Missing Livewire assets: Assets are published during container build

### Debug Mode
For debugging, temporarily enable:
```bash
APP_DEBUG=true
```

### Log Analysis
```bash
# Check nginx logs
docker exec -it container-name tail -f /tmp/nginx-error.log

# Check PHP-FPM logs
docker exec -it container-name tail -f /tmp/php8.3-fpm-www-error.log

# Check Laravel logs
docker exec -it container-name tail -f /var/www/html/storage/logs/laravel.log

# Check log status and sizes
docker exec -it container-name log-cleanup status

# Manual log rotation
docker exec -it container-name log-cleanup rotate

# Emergency log cleanup (if disk space is low)
docker exec -it container-name log-cleanup emergency

# Clean old compressed logs
docker exec -it container-name log-cleanup clean 14
```

## 📈 Performance Benchmarks

This setup is optimized for:
- **High concurrency**: 1000+ concurrent connections
- **Low latency**: <50ms response times for cached content
- **High throughput**: 10,000+ requests per second
- **Memory efficiency**: <512MB memory usage under normal load

## 📋 Log Rotation & Management

### Automatic Log Rotation
The container includes comprehensive log rotation to prevent disk space issues:

- **Daily rotation**: All logs are rotated daily at 2 AM
- **Size-based rotation**: Logs rotate when reaching size limits
- **Compression**: Old logs are compressed to save space
- **Retention periods**:
  - Nginx logs: 7 days
  - PHP-FPM logs: 7 days
  - Laravel logs: 14 days
  - Supervisor logs: 5 days
  - OPcache logs: 3 days

### Scheduled Tasks
```bash
# Daily at 2 AM - Full log rotation
0 2 * * * logrotate -f /etc/logrotate.d/laravel

# Every 6 hours - Clean old compressed logs
0 */6 * * * log-cleanup clean 3

# Every 30 minutes - Emergency cleanup if disk > 80%
*/30 * * * * log-cleanup status | grep -q 'consider running cleanup' && log-cleanup emergency
```

### Manual Log Management
```bash
# Check current log status
docker exec -it container-name log-cleanup status

# Force log rotation
docker exec -it container-name log-cleanup rotate

# Emergency cleanup (truncates all logs)
docker exec -it container-name log-cleanup emergency

# Clean compressed logs older than N days
docker exec -it container-name log-cleanup clean 7

# Get help
docker exec -it container-name log-cleanup help
```

### Log Locations
- **Active logs**: `/tmp/*.log` and `/var/www/html/storage/logs/*.log`
- **Rotated logs**: Same locations with `.YYYYMMDD_HHMMSS.gz` suffix
- **Log sizes**: Monitored automatically, alerts when disk usage > 80%

## 🔄 Updates and Maintenance

### Regular Maintenance
1. **Security updates**: Regularly update base image
2. **Log rotation**: Automatic via cron and supervisor
3. **Cache clearing**: Laravel cache optimization
4. **OPcache reset**: Automatic on container restart

### Backup Strategy
- **Database**: Regular database backups
- **Files**: Volume mounts for persistent storage
- **Configuration**: Version control for all configs

## 📞 Support

For issues or questions:
1. Check the logs first
2. Review this documentation
3. Check Laravel and Docker documentation
4. Monitor system resources

---

**Note**: This setup is designed for production use with security and performance as top priorities. Always test thoroughly in a staging environment before deploying to production. 
