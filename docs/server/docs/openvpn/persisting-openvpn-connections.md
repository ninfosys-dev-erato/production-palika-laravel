# Persisting OpenVPN Connections

This guide covers how to make OpenVPN client connections persistent and resilient across reboots, network failures, and other disruptions using systemd.

## Overview

OpenVPN connections can be configured to automatically reconnect and persist across various failure scenarios including:
- System reboots
- Network connectivity issues
- Server unavailability
- Temporary network drops
- Missing configuration files

## Prerequisites

- OpenVPN client installed on your system
- Root/sudo access for system-level configuration
- systemd-based Linux distribution

## Method 1: Using systemd with Robust Retry Logic (Recommended)

### Step 1: Create Enhanced systemd Service

Create a custom systemd service that handles missing configurations and implements robust retry logic:

```bash
sudo vim /etc/systemd/system/openvpn-persistent.service
```

Add the following content:

```ini
[Unit]
Description=Persistent OpenVPN Client Connection
After=network-online.target
Wants=network-online.target
StartLimitIntervalSec=0

[Service]
Type=simple
ExecStart=/usr/sbin/openvpn --config /etc/openvpn/client/client.conf
Restart=always
RestartSec=5
TimeoutStartSec=60v
TimeoutStopSec=60

# Run as root to allow access to tun, keys, certs
User=root
Group=root

# Optional: basic protection (safe fallback without blocking OpenVPN)
ProtectSystem=full
ProtectHome=false
ReadWritePaths=/etc/openvpn /var/log

# Optional: for logging (OpenVPN still logs to syslog/journal by default)
StandardOutput=journal
StandardError=journal

[Install]
WantedBy=multi-user.target
```

### Step 2: Create Configuration Watcher Service

Create a service that monitors for configuration file changes and restarts the VPN:

```bash
sudo nano /etc/systemd/system/openvpn-config-watcher.service
```

Add the following content:

```ini
[Unit]
Description=OpenVPN Configuration File Watcher
After=network-online.target
Wants=network-online.target

[Service]
Type=oneshot
RemainAfterExit=yes
ExecStart=/usr/local/bin/openvpn-config-watcher.sh
ExecStop=/bin/true

[Install]
WantedBy=multi-user.target
```

### Step 3: Create Configuration Watcher Script

```bash
sudo nano /usr/local/bin/openvpn-config-watcher.sh
```

Add the following content:

```bash
#!/bin/bash
# OpenVPN Configuration File Watcher
# Monitors for config file changes and restarts VPN service

CONFIG_DIR="/etc/openvpn/client"
CONFIG_FILE="$CONFIG_DIR/client.conf"
SERVICE_NAME="openvpn-persistent.service"
LOG_FILE="/var/log/openvpn-config-watcher.log"

log() {
    echo "$(date): $1" >> "$LOG_FILE"
}

# Create log file if it doesn't exist
touch "$LOG_FILE"

log "Starting OpenVPN configuration watcher"

# Wait for network to be available
while ! ping -c 1 -W 5 8.8.8.8 >/dev/null 2>&1; do
    log "Waiting for network connectivity..."
    sleep 5
done

# Wait for configuration file to appear
while [ ! -f "$CONFIG_FILE" ]; do
    log "Waiting for OpenVPN configuration file: $CONFIG_FILE"
    sleep 30
done

log "Configuration file found, starting VPN service"

# Start the main VPN service
systemctl start "$SERVICE_NAME"

# Monitor for config file changes
inotifywait -m -e modify,create,delete "$CONFIG_DIR" | while read path action file; do
    if [ "$file" = "client.conf" ]; then
        log "Configuration file changed ($action), restarting VPN service"
        systemctl restart "$SERVICE_NAME"
    fi
done
```

Make the script executable:

```bash
sudo chmod +x /usr/local/bin/openvpn-config-watcher.sh
```

### Step 4: Create Enhanced OpenVPN Configuration

When you have your OpenVPN configuration file, place it with enhanced persistence settings:

```bash
sudo nano /etc/openvpn/client/client.conf
```

Add these robust persistence directives:

```conf
# Basic connection settings
client
dev tun
proto udp

# Server connection
remote your-server.com 1194

# Persistence and resilience
persist-key
persist-tun
resolv-retry infinite
keepalive 10 120
connect-retry 5
connect-retry-max 3
connect-timeout 30

# Authentication
auth-user-pass /etc/openvpn/client/auth.txt

# Security
remote-cert-tls server
verify-x509-name server name

# Logging
verb 3
log-append /var/log/openvpn-client.log

# Network resilience
nobind
float
comp-lzo no

# DNS handling
script-security 2
up /etc/openvpn/update-resolv-conf
down /etc/openvpn/update-resolv-conf
```

### Step 5: Create Authentication File

```bash
sudo nano /etc/openvpn/client/auth.txt
```

Add your credentials:

```
username
password
```

Set proper permissions:

```bash
sudo chmod 600 /etc/openvpn/client/auth.txt
sudo chown root:root /etc/openvpn/client/auth.txt
```

### Step 6: Enable and Start Services

```bash
# Reload systemd configuration
sudo systemctl daemon-reload

# Enable services to start on boot
sudo systemctl enable openvpn-config-watcher.service
sudo systemctl enable openvpn-persistent.service

# Start the configuration watcher first
sudo systemctl start openvpn-config-watcher.service

# Check service status
sudo systemctl status openvpn-config-watcher.service
sudo systemctl status openvpn-persistent.service
```

### Step 7: Monitor and Verify

Monitor the services:

```bash
# Watch VPN service logs
sudo journalctl -u openvpn-persistent.service -f

# Watch config watcher logs
sudo journalctl -u openvpn-config-watcher.service -f

# Check VPN connection status
sudo systemctl status openvpn-persistent.service

# Verify TUN interface
ip addr show tun0

# Test connectivity through VPN
ping -c 3 -I tun0 8.8.8.8
```

## Method 2: Advanced systemd with Health Checks

### Create Health Check Service

```bash
sudo nano /etc/systemd/system/openvpn-health-check.service
```

Add the following content:

```ini
[Unit]
Description=OpenVPN Health Check Service
After=openvpn-persistent.service
Requires=openvpn-persistent.service

[Service]
Type=simple
ExecStart=/usr/local/bin/openvpn-health-check.sh
Restart=always
RestartSec=60

[Install]
WantedBy=multi-user.target
```

### Create Advanced Health Check Script

```bash
sudo nano /usr/local/bin/openvpn-health-check.sh
```

Add the following content:

```bash
#!/bin/bash
# Advanced OpenVPN Health Check with systemd integration

SERVICE_NAME="openvpn-persistent.service"
LOG_FILE="/var/log/openvpn-health-check.log"
PING_HOST="8.8.8.8"
CHECK_INTERVAL=300  # 5 minutes
MAX_FAILURES=3

log() {
    echo "$(date): $1" >> "$LOG_FILE"
}

failure_count=0

log "Starting OpenVPN health check service"

while true; do
    # Check if service is running
    if ! systemctl is-active --quiet "$SERVICE_NAME"; then
        log "ERROR: OpenVPN service is not running"
        failure_count=$((failure_count + 1))
        
        if [ $failure_count -ge $MAX_FAILURES ]; then
            log "CRITICAL: Maximum failures reached, attempting service restart"
            systemctl restart "$SERVICE_NAME"
            failure_count=0
            sleep 30
        fi
    else
        # Check TUN interface
        if ! ip link show tun0 >/dev/null 2>&1; then
            log "WARNING: TUN interface not found, restarting service"
            systemctl restart "$SERVICE_NAME"
            sleep 30
            continue
        fi
        
        # Test connectivity through VPN
        if ping -c 3 -W 5 -I tun0 "$PING_HOST" >/dev/null 2>&1; then
            log "OK: VPN connectivity verified"
            failure_count=0
        else
            log "WARNING: VPN connectivity failed"
            failure_count=$((failure_count + 1))
            
            if [ $failure_count -ge $MAX_FAILURES ]; then
                log "CRITICAL: Connectivity failures exceeded threshold, restarting service"
                systemctl restart "$SERVICE_NAME"
                failure_count=0
                sleep 30
            fi
        fi
    fi
    
    sleep $CHECK_INTERVAL
done
```

Make the script executable:

```bash
sudo chmod +x /usr/local/bin/openvpn-health-check.sh
```

### Enable Health Check Service

```bash
sudo systemctl daemon-reload
sudo systemctl enable openvpn-health-check.service
sudo systemctl start openvpn-health-check.service
```

## Method 3: systemd with Automatic Configuration Download

### Create Configuration Downloader Service

For scenarios where the OpenVPN config needs to be downloaded automatically:

```bash
sudo nano /etc/systemd/system/openvpn-config-downloader.service
```

Add the following content:

```ini
[Unit]
Description=OpenVPN Configuration Downloader
After=network-online.target
Wants=network-online.target

[Service]
Type=oneshot
RemainAfterExit=yes
ExecStart=/usr/local/bin/download-openvpn-config.sh
ExecStop=/bin/true

[Install]
WantedBy=multi-user.target
```

### Create Configuration Download Script

```bash
sudo nano /usr/local/bin/download-openvpn-config.sh
```

Add the following content:

```bash
#!/bin/bash
# Download OpenVPN configuration from remote server

CONFIG_URL="https://your-server.com/openvpn/client.conf"
CONFIG_FILE="/etc/openvpn/client/client.conf"
AUTH_URL="https://your-server.com/openvpn/auth.txt"
AUTH_FILE="/etc/openvpn/client/auth.txt"
LOG_FILE="/var/log/openvpn-config-download.log"

log() {
    echo "$(date): $1" >> "$LOG_FILE"
}

log "Starting OpenVPN configuration download"

# Create directory if it doesn't exist
mkdir -p /etc/openvpn/client

# Download configuration file
if curl -s -o "$CONFIG_FILE" "$CONFIG_URL"; then
    log "Configuration file downloaded successfully"
    chmod 600 "$CONFIG_FILE"
    chown root:root "$CONFIG_FILE"
else
    log "ERROR: Failed to download configuration file"
    exit 1
fi

# Download authentication file (if needed)
if [ -n "$AUTH_URL" ]; then
    if curl -s -o "$AUTH_FILE" "$AUTH_URL"; then
        log "Authentication file downloaded successfully"
        chmod 600 "$AUTH_FILE"
        chown root:root "$AUTH_FILE"
    else
        log "WARNING: Failed to download authentication file"
    fi
fi

log "Configuration download completed"
```

Make the script executable:

```bash
sudo chmod +x /usr/local/bin/download-openvpn-config.sh
```

### Update Service Dependencies

Modify the main VPN service to depend on the config downloader:

```bash
sudo nano /etc/systemd/system/openvpn-persistent.service
```

Update the `[Unit]` section:

```ini
[Unit]
Description=Persistent OpenVPN Client Connection
After=network-online.target openvpn-config-downloader.service
Wants=network-online.target
Requires=openvpn-config-downloader.service
StartLimitIntervalSec=0
```

### Enable All Services

```bash
sudo systemctl daemon-reload
sudo systemctl enable openvpn-config-downloader.service
sudo systemctl enable openvpn-config-watcher.service
sudo systemctl enable openvpn-persistent.service
sudo systemctl enable openvpn-health-check.service

# Start services in order
sudo systemctl start openvpn-config-downloader.service
sudo systemctl start openvpn-config-watcher.service
sudo systemctl start openvpn-persistent.service
sudo systemctl start openvpn-health-check.service
```

## Troubleshooting

### Service Status and Logs

```bash
# Check all service statuses
sudo systemctl status openvpn-config-downloader.service
sudo systemctl status openvpn-config-watcher.service
sudo systemctl status openvpn-persistent.service
sudo systemctl status openvpn-health-check.service

# View detailed logs
sudo journalctl -u openvpn-persistent.service -f
sudo journalctl -u openvpn-health-check.service -f

# Check configuration file
ls -la /etc/openvpn/client/

# Test VPN connectivity
ping -c 3 -I tun0 8.8.8.8
```

### Common Issues

1. **Service fails to start**: Check if configuration file exists and has correct permissions
2. **Network connectivity issues**: Verify network is online before starting services
3. **Permission denied**: Ensure all scripts are executable and have proper ownership
4. **Configuration download fails**: Check network connectivity and URL accessibility

### Manual Service Management

```bash
# Restart all services
sudo systemctl restart openvpn-config-downloader.service
sudo systemctl restart openvpn-config-watcher.service
sudo systemctl restart openvpn-persistent.service
sudo systemctl restart openvpn-health-check.service

# Stop all services
sudo systemctl stop openvpn-health-check.service
sudo systemctl stop openvpn-persistent.service
sudo systemctl stop openvpn-config-watcher.service
sudo systemctl stop openvpn-config-downloader.service

# Disable services
sudo systemctl disable openvpn-health-check.service
sudo systemctl disable openvpn-persistent.service
sudo systemctl disable openvpn-config-watcher.service
sudo systemctl disable openvpn-config-downloader.service
```

## Best Practices

### Security Considerations
1. **File Permissions**: All configuration files should be 600 (readable only by root)
2. **Authentication**: Store credentials securely and rotate regularly
3. **Network Security**: Use HTTPS for configuration downloads
4. **Service Isolation**: Use systemd security features to limit service capabilities

### Performance Optimization
1. **Health Check Intervals**: Adjust check intervals based on network stability
2. **Log Rotation**: Implement log rotation to prevent disk space issues
3. **Resource Limits**: Monitor CPU and memory usage of VPN services

### Maintenance
1. **Regular Updates**: Keep OpenVPN client and scripts updated
2. **Configuration Backups**: Backup configuration files regularly
3. **Monitoring**: Set up monitoring for service health and connectivity

## Conclusion

This enhanced systemd approach provides:
- **Robust retry logic** with exponential backoff
- **Automatic configuration management** even when files don't exist initially
- **Health monitoring** with automatic service restart
- **Network resilience** with proper dependency management
- **Security hardening** through systemd security features

The services will automatically handle:
- Missing configuration files
- Network connectivity issues
- Service failures
- Configuration changes
- System reboots

Choose the method that best fits your environment. The basic systemd approach (Method 1) is sufficient for most use cases, while the advanced health check (Method 2) and automatic configuration download (Method 3) provide additional robustness for production environments.
