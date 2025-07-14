# WireGuard Hub-and-Spoke VPN Setup Guide

This guide provides step-by-step instructions for setting up a WireGuard VPN using a hub-and-spoke topology, where a central server acts as the hub and multiple clients connect as spokes.

## Table of Contents
- [Overview](#overview)
- [Prerequisites](#prerequisites)
- [Server Setup](#server-setup)
- [Client Setup](#client-setup)
- [Network Configuration](#network-configuration)
- [Testing the Connection](#testing-the-connection)
- [Troubleshooting](#troubleshooting)

## Overview

In a hub-and-spoke topology:
- **Hub (Server)**: Central node that routes traffic between all clients
- **Spokes (Clients)**: Individual nodes that connect to the hub
- All client-to-client communication goes through the hub
- The hub can access all clients, but clients can only access the hub and other clients through the hub

## Prerequisites

- Ubuntu/Debian server (for hub)
- Linux/macOS/Windows clients
- Root/sudo access on all machines
- Basic networking knowledge

## Server Setup

### Step 1: Install WireGuard on the Server

```bash
# Update package list
sudo apt update

# Install WireGuard
sudo apt install wireguard -y

# Install additional tools
sudo apt install wireguard-tools -y
```

### Step 2: Enable IP Forwarding

```bash
# Enable IP forwarding
echo 'net.ipv4.ip_forward=1' | sudo tee -a /etc/sysctl.conf
echo 'net.ipv6.conf.all.forwarding=1' | sudo tee -a /etc/sysctl.conf

# Apply changes
sudo sysctl -p
```

### Step 3: Generate Server Keys

```bash
# Create WireGuard directory
sudo mkdir -p /etc/wireguard
cd /etc/wireguard

# Generate private and public keys
wg genkey | sudo tee privatekey | wg pubkey | sudo tee publickey

# Set proper permissions
sudo chmod 600 privatekey
sudo chmod 644 publickey
```

### Step 4: Create Server Configuration

```bash
# Create server configuration file
sudo nano /etc/wireguard/wg0.conf
```

Add the following configuration:

```ini
[Interface]
PrivateKey = <SERVER_PRIVATE_KEY>
Address = 169.254.1.1/24
ListenPort = 51820
SaveConfig = true
PostUp = iptables -A FORWARD -i wg0 -j ACCEPT; iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
PostDown = iptables -D FORWARD -i wg0 -j ACCEPT; iptables -t nat -D POSTROUTING -o eth0 -j MASQUERADE
```

**Important Notes:**
- Replace `<SERVER_PRIVATE_KEY>` with the content of `/etc/wireguard/privatekey`
- Replace `eth0` with your actual network interface name (use `ip addr show` to find it)
- The `10.0.0.1/24` subnet can be changed to any private subnet you prefer

### Step 5: Start WireGuard Service

```bash
# Enable WireGuard service
sudo systemctl enable wg-quick@wg0

# Start WireGuard service
sudo systemctl start wg-quick@wg0

# Check status
sudo systemctl status wg-quick@wg0
```

### Step 6: Configure Firewall

```bash
# Allow WireGuard port
sudo ufw allow 51820/udp

# Allow forwarding
sudo ufw --force enable
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow ssh
sudo ufw allow 51820/udp
```

## Client Setup

### Step 1: Install WireGuard on Client

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install wireguard -y
```

**macOS:**
```bash
# Install via Homebrew
brew install wireguard-tools

# Or download from App Store
```

**Windows:**
- Download from https://www.wireguard.com/install/

### Step 2: Generate Client Keys

```bash
# Create directory
mkdir -p ~/wireguard
cd ~/wireguard

# Generate keys
wg genkey | tee client_privatekey | wg pubkey | tee client_publickey
```

### Step 3: Create Client Configuration

```bash
# Create client configuration
nano ~/wireguard/client.conf
```

Add the following configuration:

```ini
[Interface]
PrivateKey = <CLIENT_PRIVATE_KEY>
Address = 169.254.1.2/24
DNS = 8.8.8.8, 8.8.4.4

[Peer]
PublicKey = <SERVER_PUBLIC_KEY>
Endpoint = <SERVER_IP>:51820
AllowedIPs = 169.254.1.0/24
PersistentKeepalive = 25
```

**Important Notes:**
- Replace `<CLIENT_PRIVATE_KEY>` with the content of `client_privatekey`
- Replace `<SERVER_PUBLIC_KEY>` with the content of the server's `publickey`
- Replace `<SERVER_IP>` with your server's public IP address
- Use different IP addresses for each client (169.254.1.2, 169.254.1.3, etc.)

### Step 4: Add Client to Server

On the server, add the client configuration:

```bash
# Add client to server
sudo wg set wg0 peer <CLIENT_PUBLIC_KEY> allowed-ips 169.254.1.2/32
```

### Step 5: Connect Client

**Linux:**
```bash
# Copy configuration to system directory
sudo cp ~/wireguard/client.conf /etc/wireguard/wg0.conf

# Start connection
sudo wg-quick up wg0

# Check status
sudo wg show
```

**macOS:**
```bash
# Start connection
sudo wg-quick up ~/wireguard/client.conf
```

**Windows:**
- Import the configuration file through the WireGuard GUI

## Network Configuration

### Adding Multiple Clients

For each additional client, repeat the client setup process with:
- Unique IP address (169.254.1.3, 169.254.1.4, etc.)
- Unique private/public key pair
- Add to server using `wg set` command

### Server Configuration for Multiple Clients

Your server configuration will look like this after adding clients:

```ini
[Interface]
PrivateKey = <SERVER_PRIVATE_KEY>
Address = 169.254.1.1/24
ListenPort = 51820
SaveConfig = true
PostUp = iptables -A FORWARD -i wg0 -j ACCEPT; iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
PostDown = iptables -D FORWARD -i wg0 -j ACCEPT; iptables -t nat -D POSTROUTING -o eth0 -j MASQUERADE

[Peer]
PublicKey = <CLIENT1_PUBLIC_KEY>
AllowedIPs = 169.254.1.2/32

[Peer]
PublicKey = <CLIENT2_PUBLIC_KEY>
AllowedIPs = 169.254.1.3/32

[Peer]
PublicKey = <CLIENT3_PUBLIC_KEY>
AllowedIPs = 169.254.1.4/32
```

## Testing the Connection

### Step 1: Check Server Status

```bash
# On server
sudo wg show
```

You should see all connected peers listed.

### Step 2: Test Connectivity

```bash
# From client to server
ping 169.254.1.1

# From server to client
ping 169.254.1.2

# Between clients (through hub)
ping 169.254.1.3
```

### Step 3: Test Internet Access

```bash
# Check if client can access internet through VPN
curl ifconfig.me
```

## Troubleshooting

### Common Issues

1. **Connection Fails**
   - Check firewall settings
   - Verify port 51820 is open
   - Ensure server public key is correct

2. **No Internet Access**
   - Verify IP forwarding is enabled
   - Check iptables rules
   - Ensure correct network interface name

3. **Client Cannot Reach Other Clients**
   - Verify hub-and-spoke routing
   - Check AllowedIPs configuration
   - Ensure server is forwarding traffic

### Useful Commands

```bash
# Check WireGuard status
sudo wg show

# Check interface status
ip addr show wg0

# Check routing table
ip route show

# Check firewall rules
sudo iptables -L -n -v

# View WireGuard logs
sudo journalctl -u wg-quick@wg0 -f
```

### Removing Clients

```bash
# Remove client from server
sudo wg set wg0 peer <CLIENT_PUBLIC_KEY> remove
```

## Security Considerations

1. **Key Management**: Keep private keys secure and never share them
2. **Firewall**: Only allow necessary ports
3. **Updates**: Keep WireGuard updated
4. **Monitoring**: Monitor logs for suspicious activity
5. **Backup**: Regularly backup configurations

## Advanced Configuration

### Split Tunneling

To route only specific traffic through VPN, modify client AllowedIPs:

```ini
# Route only specific subnets
AllowedIPs = 169.254.1.0/24, 192.168.1.0/24

# Route all traffic
AllowedIPs = 0.0.0.0/0
```

### Persistent Configuration

To make configuration persistent across reboots:

```bash
# Save current configuration
sudo wg-quick save wg0
```

This guide provides a complete setup for a WireGuard hub-and-spoke VPN network. Each client can connect to the hub, and the hub can route traffic between all connected clients while providing internet access through NAT.
