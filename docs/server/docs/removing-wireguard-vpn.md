# WireGuard VPN Removal Guide

This guide provides step-by-step instructions for completely removing WireGuard VPN from your system, including cleanup of configurations, keys, and network settings.

## Table of Contents
- [Overview](#overview)
- [Server Removal](#server-removal)
- [Client Removal](#client-removal)
- [Network Cleanup](#network-cleanup)
- [Verification](#verification)
- [Troubleshooting](#troubleshooting)

## Overview

This guide covers the complete removal of WireGuard VPN from:
- **Server**: Central hub that manages the VPN network
- **Clients**: Individual devices connected to the VPN
- **Network**: Cleanup of routing tables and firewall rules

## Server Removal

### Step 1: Stop WireGuard Service

```bash
# Stop the WireGuard service
sudo systemctl stop wg-quick@wg0

# Disable the service from starting on boot
sudo systemctl disable wg-quick@wg0

# Check if service is stopped
sudo systemctl status wg-quick@wg0
```

### Step 2: Remove WireGuard Interface

```bash
# Remove the WireGuard interface if it still exists
sudo wg-quick down wg0

# Check if interface is removed
ip addr show wg0
```

### Step 3: Remove WireGuard Configuration Files

```bash
# Remove configuration directory and files
sudo rm -rf /etc/wireguard/

# Remove any backup configurations
sudo rm -f /etc/wireguard.conf
sudo rm -f /etc/wireguard/wg0.conf
```

### Step 4: Remove WireGuard Package

```bash
# Remove WireGuard packages
sudo apt remove wireguard wireguard-tools -y

# Remove any remaining configuration files
sudo apt purge wireguard wireguard-tools -y

# Clean up any unused dependencies
sudo apt autoremove -y
```

### Step 5: Clean Up Firewall Rules

```bash
# Remove WireGuard port from UFW
sudo ufw delete allow 51820/udp

# Reload UFW
sudo ufw reload

# Check UFW status
sudo ufw status
```

### Step 6: Remove IP Forwarding (Optional)

If you want to disable IP forwarding that was enabled for WireGuard:

```bash
# Edit sysctl configuration
sudo nano /etc/sysctl.conf

# Remove or comment out these lines:
# net.ipv4.ip_forward=1
# net.ipv6.conf.all.forwarding=1

# Apply changes
sudo sysctl -p
```

## Client Removal

### Linux Clients

#### Step 1: Stop WireGuard Connection

```bash
# Stop WireGuard interface
sudo wg-quick down wg0

# Check if interface is removed
ip addr show wg0
```

#### Step 2: Remove Configuration Files

```bash
# Remove system configuration
sudo rm -f /etc/wireguard/wg0.conf

# Remove user configuration (if exists)
rm -rf ~/wireguard/

# Remove any backup configurations
rm -f ~/.wireguard/
```

#### Step 3: Remove WireGuard Package

```bash
# Remove WireGuard packages
sudo apt remove wireguard wireguard-tools -y

# Remove any remaining configuration files
sudo apt purge wireguard wireguard-tools -y

# Clean up unused dependencies
sudo apt autoremove -y
```

### macOS Clients

#### Step 1: Stop WireGuard Connection

```bash
# Stop WireGuard interface
sudo wg-quick down ~/wireguard/client.conf

# Or if using system configuration
sudo wg-quick down wg0
```

#### Step 2: Remove Configuration Files

```bash
# Remove user configuration
rm -rf ~/wireguard/

# Remove system configuration (if exists)
sudo rm -f /etc/wireguard/wg0.conf
```

#### Step 3: Remove WireGuard Tools

```bash
# If installed via Homebrew
brew uninstall wireguard-tools

# Remove any remaining files
sudo rm -rf /usr/local/etc/wireguard/
```

### Windows Clients

#### Step 1: Uninstall WireGuard

1. Open **Control Panel** → **Programs and Features**
2. Find **WireGuard** in the list
3. Click **Uninstall** and follow the wizard

#### Step 2: Remove Configuration Files

```cmd
# Remove configuration directory
rmdir /s "%PROGRAMDATA%\WireGuard"

# Remove user configuration
rmdir /s "%USERPROFILE%\WireGuard"
```

#### Step 3: Clean Registry (Optional)

```cmd
# Remove registry entries (run as Administrator)
reg delete "HKLM\SOFTWARE\WireGuard" /f
reg delete "HKCU\SOFTWARE\WireGuard" /f
```

## Network Cleanup

### Step 1: Check for Remaining Network Interfaces

```bash
# List all network interfaces
ip addr show

# Look for any remaining wg0 interfaces
ip link show wg0
```

### Step 2: Clean Up Routing Tables

```bash
# Check routing table for WireGuard routes
ip route show

# Remove any remaining WireGuard routes
sudo ip route del 169.254.1.0/24 dev wg0 2>/dev/null || true
```

### Step 3: Clean Up iptables Rules

```bash
# List current iptables rules
sudo iptables -L -n -v

# Remove WireGuard-related rules
sudo iptables -D FORWARD -i wg0 -j ACCEPT 2>/dev/null || true
sudo iptables -t nat -D POSTROUTING -o eth0 -j MASQUERADE 2>/dev/null || true

# Save iptables rules
sudo iptables-save > /etc/iptables/rules.v4
```

### Step 4: Restart Network Services

```bash
# Restart networking service
sudo systemctl restart networking

# Or restart NetworkManager
sudo systemctl restart NetworkManager
```

## Verification

### Step 1: Check for Remaining WireGuard Processes

```bash
# Check for running WireGuard processes
ps aux | grep wireguard
ps aux | grep wg

# Check for WireGuard kernel modules
lsmod | grep wireguard
```

### Step 2: Verify Network Interface Removal

```bash
# Check if wg0 interface is completely removed
ip addr show wg0 2>/dev/null || echo "WireGuard interface removed"

# Check network interfaces
ip addr show
```

### Step 3: Test Network Connectivity

```bash
# Test basic connectivity
ping -c 4 8.8.8.8

# Test DNS resolution
nslookup google.com

# Check routing table
ip route show
```

### Step 4: Verify Package Removal

```bash
# Check if WireGuard packages are removed
dpkg -l | grep wireguard

# Check for any remaining configuration files
find /etc -name "*wireguard*" 2>/dev/null
find /usr -name "*wireguard*" 2>/dev/null
```

## Troubleshooting

### Common Issues

1. **Interface Still Exists**
   ```bash
   # Force remove interface
   sudo ip link delete wg0
   
   # Reboot if necessary
   sudo reboot
   ```

2. **Service Won't Stop**
   ```bash
   # Force stop service
   sudo systemctl stop wg-quick@wg0
   
   # Kill any remaining processes
   sudo pkill -f wireguard
   ```

3. **Configuration Files Not Removed**
   ```bash
   # Find all WireGuard files
   sudo find / -name "*wireguard*" 2>/dev/null
   
   # Remove them manually
   sudo rm -rf /path/to/wireguard/files
   ```

4. **Network Issues After Removal**
   ```bash
   # Reset network configuration
   sudo systemctl restart networking
   
   # Or restart NetworkManager
   sudo systemctl restart NetworkManager
   
   # Check network status
   sudo systemctl status networking
   ```

### Complete System Reset (Nuclear Option)

If you're still having issues, you can perform a complete reset:

```bash
# Stop all services
sudo systemctl stop wg-quick@wg0

# Remove all WireGuard files
sudo find / -name "*wireguard*" -delete 2>/dev/null

# Remove packages
sudo apt purge wireguard* -y

# Clean up
sudo apt autoremove -y

# Reboot system
sudo reboot
```

## Post-Removal Checklist

After completing the removal process, verify:

- [ ] WireGuard service is stopped and disabled
- [ ] wg0 interface is removed
- [ ] Configuration files are deleted
- [ ] Packages are uninstalled
- [ ] Firewall rules are cleaned up
- [ ] Network connectivity is restored
- [ ] No WireGuard processes are running
- [ ] Routing table is clean

## Security Notes

1. **Key Cleanup**: Ensure all private keys are properly deleted
2. **Configuration Backup**: Remove any backup configuration files
3. **Network Security**: Verify firewall rules are properly configured
4. **System Integrity**: Check that system services are functioning normally

This guide ensures a complete removal of WireGuard VPN from your system while maintaining system stability and security.
