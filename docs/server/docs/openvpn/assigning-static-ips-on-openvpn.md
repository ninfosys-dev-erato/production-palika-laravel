# Assigning Static IPs to OpenVPN Clients

This guide explains how to assign static IP addresses to specific OpenVPN clients using the `client-config-dir` feature. This is useful when you need clients to have predictable IP addresses for firewall rules, routing, or application requirements.

## Table of Contents
- [Overview](#overview)
- [Prerequisites](#prerequisites)
- [Server Configuration](#server-configuration)
- [Client Configuration Directory](#client-configuration-directory)
- [Static IP Assignment](#static-ip-assignment)
- [Multiple Client Setup](#multiple-client-setup)
- [Verification](#verification)
- [Troubleshooting](#troubleshooting)
- [Advanced Configuration](#advanced-configuration)

## Overview

OpenVPN's `client-config-dir` feature allows you to:
- Assign static IP addresses to specific clients
- Apply client-specific routing rules
- Set custom DNS servers per client
- Configure client-specific firewall rules
- Override default client settings

**Important Distinction:**
- `/etc/openvpn/clients/` - Stores client certificates and .ovpn files for client download
- `/etc/openvpn/ccd/` - Server-side directory for client-specific configurations (you create this)

## Prerequisites

- OpenVPN server already configured and running
- Root/sudo access on the server
- Client certificates already generated
- Understanding of your VPN network range (e.g., 169.254.100.0/24)

## Server Configuration

### Step 1: Add Client Config Directory to Server Config

Edit your server configuration file:

```bash
sudo nano /etc/openvpn/server.conf
```

Add this line to enable client-specific configurations:

```ini
# Client-specific configuration directory
client-config-dir /etc/openvpn/ccd
```

### Step 2: Create the Client Config Directory

```bash
# Create the client configuration directory
sudo mkdir -p /etc/openvpn/ccd

# Set proper permissions
sudo chown root:root /etc/openvpn/ccd
sudo chmod 755 /etc/openvpn/ccd
```

## Client Configuration Directory

### Directory Structure

```
/etc/openvpn/ccd/
├── client1          # File named after client's Common Name (CN)
├── client2
├── suryabinayak
└── workstation01
```

### File Naming Convention

The files in `/etc/openvpn/ccd/` must be named exactly after the client's **Common Name (CN)** from their certificate. This is the name you used when generating the client certificate.

**Example:**
- If you generated a certificate with CN "suryabinayak", create file `/etc/openvpn/ccd/suryabinayak`
- If you generated a certificate with CN "workstation01", create file `/etc/openvpn/ccd/workstation01`

## Static IP Assignment

### Step 1: Find Client Common Name

First, determine the exact Common Name (CN) of your client certificate:

```bash
# Check the client certificate
openssl x509 -in /etc/openvpn/clients/CLIENT_NAME/CLIENT_NAME.crt -subject -noout
```

**Example output:**
```
subject= /C=US/ST=CA/L=San Francisco/O=My Company/CN=suryabinayak
```

The CN is "suryabinayak" in this example.

### Step 2: Create Client Config File

Create a file named after the client's CN:

```bash
sudo nano /etc/openvpn/ccd/suryabinayak
```

### Step 3: Add Static IP Configuration

Add the static IP assignment to the file:

```ini
# Static IP assignment for client
ifconfig-push 169.254.100.10 169.254.100.11
```

**IP Address Format:**
- `169.254.100.10` - Client's IP address
- `169.254.100.11` - Client's network mask (usually the same as server's network)

### Step 4: Set File Permissions

```bash
# Set proper permissions
sudo chown root:root /etc/openvpn/ccd/suryabinayak
sudo chmod 644 /etc/openvpn/ccd/suryabinayak
```

### Step 5: Restart OpenVPN Service

```bash
# Restart OpenVPN to apply changes
sudo systemctl restart openvpn@server

# Check service status
sudo systemctl status openvpn@server
```

## Multiple Client Setup

### Example: Multiple Static IPs

Create separate files for each client:

**File: `/etc/openvpn/ccd/suryabinayak`**
```ini
ifconfig-push 169.254.100.10 169.254.100.11
```

**File: `/etc/openvpn/ccd/workstation01`**
```ini
ifconfig-push 169.254.100.20 169.254.100.11
```

**File: `/etc/openvpn/ccd/mobile01`**
```ini
ifconfig-push 169.254.100.30 169.254.100.11
```

### IP Address Planning

Plan your static IP assignments to avoid conflicts:

```
169.254.100.1   - Server (Hub)
169.254.100.10  - Client: suryabinayak
169.254.100.20  - Client: workstation01
169.254.100.30  - Client: mobile01
169.254.100.40  - Client: laptop01
169.254.100.50  - Client: server02
...
169.254.100.254 - Last available IP
```

## Verification

### Step 1: Check Server Configuration

```bash
# Verify client-config-dir is in server.conf
grep "client-config-dir" /etc/openvpn/server.conf

# Check ccd directory exists
ls -la /etc/openvpn/ccd/
```

### Step 2: Connect Client and Verify IP

**On the client machine:**
```bash
# Connect to VPN
sudo openvpn --config client.ovpn

# Check assigned IP
ip addr show tun0
```

**Expected output:**
```
3: tun0: <POINTOPOINT,MULTICAST,NOARP,UP,LOWER_UP> mtu 1500 qdisc fq_codel state UNKNOWN group default qlen 100
    link/none
    inet 169.254.100.10/24 scope global tun0
       valid_lft forever preferred_lft forever
```

### Step 3: Check Server Logs

```bash
# Monitor OpenVPN logs
sudo tail -f /var/log/openvpn/openvpn.log

# Check status file
sudo cat /var/log/openvpn/openvpn-status.log
```

**Look for lines like:**
```
suryabinayak/192.168.1.100:1194 MULTI: Learn: 169.254.100.10 -> suryabinayak/192.168.1.100:1194
```

## Troubleshooting

### Common Issues

1. **Client Gets Dynamic IP Instead of Static**
   - Verify file name matches client's CN exactly (case-sensitive)
   - Check file permissions (644)
   - Ensure `client-config-dir` is in server.conf
   - Restart OpenVPN service

2. **File Not Found Errors**
   ```bash
   # Check if file exists and has correct name
   ls -la /etc/openvpn/ccd/
   
   # Verify client CN
   openssl x509 -in /path/to/client.crt -subject -noout
   ```

3. **Permission Denied**
   ```bash
   # Fix permissions
   sudo chown root:root /etc/openvpn/ccd/*
   sudo chmod 644 /etc/openvpn/ccd/*
   ```

4. **IP Address Conflict**
   - Check if IP is already in use
   - Verify IP range doesn't conflict with existing assignments
   - Check server logs for conflicts

### Debug Commands

```bash
# Check OpenVPN status
sudo systemctl status openvpn@server

# View detailed logs
sudo tail -f /var/log/openvpn/openvpn.log

# Check connected clients
sudo cat /var/log/openvpn/openvpn-status.log

# Verify configuration
sudo openvpn --config /etc/openvpn/server.conf --test-crypto

# Check IP assignments
ip addr show tun0
```

## Advanced Configuration

### Client-Specific Routing

Add routing rules to client config files:

**File: `/etc/openvpn/ccd/suryabinayak`**
```ini
ifconfig-push 169.254.100.10 169.254.100.11
iroute 192.168.1.0 255.255.255.0
```

### Custom DNS for Specific Clients

```ini
ifconfig-push 169.254.100.10 169.254.100.11
push "dhcp-option DNS 1.1.1.1"
push "dhcp-option DNS 1.0.0.1"
```

### Client-Specific Firewall Rules

```ini
ifconfig-push 169.254.100.10 169.254.100.11
push "route 10.0.0.0 255.255.255.0"
```

### Multiple IP Ranges

If using different VPN networks:

**File: `/etc/openvpn/ccd/client1`**
```ini
ifconfig-push 169.254.100.10 169.254.100.11
```

**File: `/etc/openvpn/ccd/client2`**
```ini
ifconfig-push 169.254.200.10 169.254.200.11
```

## Automation Scripts

### Generate Static IP Files Automatically

Create a script to automate static IP assignment:

```bash
#!/bin/bash
# generate-static-ips.sh

CLIENT_NAME=$1
STATIC_IP=$2

if [ -z "$CLIENT_NAME" ] || [ -z "$STATIC_IP" ]; then
    echo "Usage: $0 <client_name> <static_ip>"
    echo "Example: $0 suryabinayak 169.254.100.10"
    exit 1
fi

# Create ccd directory if it doesn't exist
sudo mkdir -p /etc/openvpn/ccd

# Create client config file
sudo tee /etc/openvpn/ccd/$CLIENT_NAME > /dev/null <<EOF
ifconfig-push $STATIC_IP 169.254.100.11
EOF

# Set permissions
sudo chown root:root /etc/openvpn/ccd/$CLIENT_NAME
sudo chmod 644 /etc/openvpn/ccd/$CLIENT_NAME

echo "Static IP $STATIC_IP assigned to client $CLIENT_NAME"
echo "Restart OpenVPN service to apply changes:"
echo "sudo systemctl restart openvpn@server"
```

**Usage:**
```bash
chmod +x generate-static-ips.sh
./generate-static-ips.sh suryabinayak 169.254.100.10
```

### Bulk IP Assignment

For multiple clients:

```bash
#!/bin/bash
# bulk-static-ips.sh

declare -A clients=(
    ["suryabinayak"]="169.254.100.10"
    ["workstation01"]="169.254.100.20"
    ["mobile01"]="169.254.100.30"
    ["laptop01"]="169.254.100.40"
)

for client in "${!clients[@]}"; do
    ip="${clients[$client]}"
    echo "Assigning $ip to $client"
    
    sudo tee /etc/openvpn/ccd/$client > /dev/null <<EOF
ifconfig-push $ip 169.254.100.11
EOF
    
    sudo chown root:root /etc/openvpn/ccd/$client
    sudo chmod 644 /etc/openvpn/ccd/$client
done

echo "All static IPs assigned. Restart OpenVPN:"
echo "sudo systemctl restart openvpn@server"
```

## Security Considerations

1. **File Permissions**: Ensure ccd files are readable only by root
2. **IP Range Validation**: Validate static IPs are within your VPN range
3. **Certificate Verification**: Always verify client CN matches file names
4. **Backup Configuration**: Backup ccd directory before making changes
5. **Monitoring**: Monitor logs for unauthorized connection attempts

## Backup and Recovery

### Backup Static IP Configurations

```bash
# Create backup
sudo tar -czf /opt/openvpn-ccd-backup-$(date +%Y%m%d).tar.gz -C /etc/openvpn ccd/

# Restore from backup
sudo tar -xzf /opt/openvpn-ccd-backup-YYYYMMDD.tar.gz -C /etc/openvpn/
```

### Export Current Assignments

```bash
# List all current static IP assignments
for file in /etc/openvpn/ccd/*; do
    if [ -f "$file" ]; then
        client=$(basename "$file")
        ip=$(grep "ifconfig-push" "$file" | awk '{print $2}')
        echo "$client: $ip"
    fi
done
```

This guide provides comprehensive instructions for assigning static IPs to OpenVPN clients using the client-config-dir feature, including troubleshooting, automation, and security considerations.
