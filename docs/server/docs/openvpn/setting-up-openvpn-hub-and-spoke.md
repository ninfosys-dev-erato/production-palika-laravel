# OpenVPN Hub-and-Spoke VPN Setup Guide (169.x.x.x Range)

This guide provides step-by-step instructions for setting up an OpenVPN server using a hub-and-spoke topology with a 169.x.x.x IP range, where a central server acts as the hub and multiple clients connect as spokes.

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
- **IP Range**: Using 169.254.100.0/24 for VPN network (customizable)

## Prerequisites

- Ubuntu/Debian server (for hub)
- Linux/macOS/Windows clients
- Root/sudo access on all machines
- Basic networking knowledge
- OpenSSL for certificate generation

## Server Setup

### Step 1: Install OpenVPN and Easy-RSA

```bash
# Update package list
sudo apt update

# Install OpenVPN and Easy-RSA
sudo apt install openvpn easy-rsa -y

# Install additional tools
sudo apt install iptables-persistent -y
```

### Step 2: Set Up Certificate Authority (CA)

```bash
# Create directory for certificates
sudo mkdir -p /etc/openvpn/easy-rsa
cd /etc/openvpn/easy-rsa

# Copy Easy-RSA scripts
sudo cp -r /usr/share/easy-rsa/* .

# Initialize PKI
sudo ./easyrsa init-pki

# Build CA (interactive - set Common Name to "OpenVPN-CA")
sudo ./easyrsa build-ca nopass

# Generate Diffie-Hellman parameters
sudo ./easyrsa gen-dh

# Generate HMAC key for additional security
sudo openvpn --genkey secret ta.key
```

### Step 3: Generate Server Certificate

```bash
# Generate server certificate and key
sudo ./easyrsa gen-req server nopass

# Sign server certificate
sudo ./easyrsa sign-req server server

# Copy certificates to OpenVPN directory
sudo cp pki/issued/server.crt /etc/openvpn/
sudo cp pki/ca.crt /etc/openvpn/
sudo cp pki/private/server.key /etc/openvpn/
sudo cp pki/dh.pem /etc/openvpn/
sudo cp ta.key /etc/openvpn/

# Set proper permissions
sudo chmod 644 /etc/openvpn/server.crt
sudo chmod 644 /etc/openvpn/ca.crt
sudo chmod 644 /etc/openvpn/dh.pem
sudo chmod 600 /etc/openvpn/server.key
sudo chmod 600 /etc/openvpn/ta.key
```

### Step 4: Enable IP Forwarding

```bash
# Enable IP forwarding
echo 'net.ipv4.ip_forward=1' | sudo tee -a /etc/sysctl.conf
echo 'net.ipv6.conf.all.forwarding=1' | sudo tee -a /etc/sysctl.conf

# Apply changes
sudo sysctl -p
```

### Step 5: Create Server Configuration

```bash
# Create server configuration file
sudo nano /etc/openvpn/server-udp1194.conf
```

Add the following configuration:

```ini
# Network Configuration
port 1194
proto udp
dev tun
ca ca.crt
cert server.crt
key server.key
dh dh.pem
auth SHA256
cipher AES-256-CBC

# Server Configuration - Using 169.254.100.0/24 range
server 169.254.100.0 255.255.255.0
ifconfig-pool-persist ipp.txt
# Enabling this will redirect all traffic to the VPN server and
# block all out traffic at the internet.
# Note that this will disrupt all existing SSH, HTTP, etc. traffic.
# push "redirect-gateway def1 bypass-dhcp"
push "dhcp-option DNS 8.8.8.8"
push "dhcp-option DNS 8.8.4.4"

# Security Settings
tls-crypt ta.key
user nobody
group nogroup
persist-key
persist-tun

# Logging
status openvpn-status.log
verb 3

# Client-to-Client Communication
client-to-client

# Keep Alive
keepalive 10 120

# Security
remote-cert-tls client
```

For TCP at port `993`, add the following configuration:

```bash
# Create server configuration file
sudo nano /etc/openvpn/server-tcp993.conf
```

```ini
port 993
proto tcp
dev tun
ca ca.crt
cert server.crt
key server.key
dh dh.pem
auth SHA256
cipher AES-256-CBC

server 169.254.101.0 255.255.255.0  # use a different subnet to avoid IP conflicts
ifconfig-pool-persist ipp-tcp993.txt
# push "redirect-gateway def1 bypass-dhcp"
push "dhcp-option DNS 8.8.8.8"
push "dhcp-option DNS 8.8.4.4"

tls-crypt ta.key
user nobody
group nogroup
persist-key
persist-tun

status openvpn-status-tcp993.log
verb 3

client-to-client
keepalive 10 120
remote-cert-tls client

```

### Step 6: Configure Firewall and Routing

```bash
# Create iptables rules for 169.254.100.0/24 network
sudo iptables -t nat -A POSTROUTING -s 169.254.100.0/24 -o eth0 -j MASQUERADE

# Allow forwarding for VPN traffic
sudo iptables -A FORWARD -s 169.254.100.0/24 -j ACCEPT
sudo iptables -A FORWARD -d 169.254.100.0/24 -j ACCEPT

# Save iptables rules
sudo netfilter-persistent save
sudo netfilter-persistent reload

# Configure UFW (if using)
sudo ufw allow 1194/udp
sudo ufw allow OpenSSH
sudo ufw --force enable
```

### Step 7: Start OpenVPN Service

```bash
# Enable OpenVPN service
sudo systemctl enable openvpn@server

# Start OpenVPN service
sudo systemctl start openvpn@server

# Check status
sudo systemctl status openvpn@server
```

## Client Setup

### Step 1: Install OpenVPN on Client

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install openvpn -y
```

**macOS:**
```bash
# Install via Homebrew
brew install openvpn

# Or download Tunnelblick from https://tunnelblick.net/
```

**Windows:**
- Download OpenVPN GUI from https://openvpn.net/community-downloads/

### Step 2: Generate Client Certificate

On the server, generate client certificates:

```bash
CLIENT_NAME="ghorahi"
# Navigate to Easy-RSA directory
cd /etc/openvpn/easy-rsa

# Generate client certificate
sudo ./easyrsa gen-req "${CLIENT_NAME}" nopass

# Sign client certificate
sudo ./easyrsa sign-req client "${CLIENT_NAME}"

# Create client directory
sudo mkdir -p "/etc/openvpn/clients/${CLIENT_NAME}"

# Copy client files
sudo cp "pki/issued/${CLIENT_NAME}.crt" "/etc/openvpn/clients/${CLIENT_NAME}/"
sudo cp "pki/private/${CLIENT_NAME}.key" "/etc/openvpn/clients/${CLIENT_NAME}/"
sudo cp pki/ca.crt "/etc/openvpn/clients/${CLIENT_NAME}/"
sudo cp ta.key "/etc/openvpn/clients/${CLIENT_NAME}/"

# Set permissions
sudo chmod 644 "/etc/openvpn/clients/${CLIENT_NAME}/"*.crt
sudo chmod 600 "/etc/openvpn/clients/${CLIENT_NAME}/"*.key
```

### Step 3: Create Client Configuration

```bash
# Create client configuration
sudo vim /etc/openvpn/clients/${CLIENT_NAME}/client.conf
```

Add the following configuration:

```ini
# Client Configuration
client
dev tun
proto udp
remote 85.10.199.16 1194
resolv-retry infinite
nobind
persist-key
persist-tun

# Certificate Files
ca /etc/openvpn/client/ca.crt
cert /etc/openvpn/client/CLIENT_NAME.crt
key /etc/openvpn/client/CLIENT_NAME.key

# Security Settings
remote-cert-tls server
auth SHA256
cipher AES-256-CBC
tls-crypt /etc/openvpn/client/ta.key

# Verbosity
verb 3

# Keep Alive
keepalive 10 120
```

**Important Notes:**
- Replace `<SERVER_IP>` with your server's public IP address
- Replace `CLIENT_NAME` with the actual client name used in certificate generation

### Step 4: Transfer Client Files

Securely transfer the client configuration and certificate files to the client machine:

```bash
# Create a compressed archive
sudo tar -czf /tmp/${CLIENT_NAME}-openvpn.tar.gz -C /etc/openvpn/clients/${CLIENT_NAME} .

# Transfer to client (use scp, rsync, or secure method)
scp /tmp/CLIENT_NAME-openvpn.tar.gz user@client-ip:/tmp/
```

### Step 5: Connect Client

**Linux:**
```bash
# Extract files
tar -xzf /tmp/CLIENT_NAME-openvpn.tar.gz -C ~/

# Connect using OpenVPN
sudo openvpn --config ~/client.ovpn
```

**macOS:**
```bash
# Extract files
tar -xzf /tmp/CLIENT_NAME-openvpn.tar.gz -C ~/

# Connect using OpenVPN
sudo openvpn --config ~/client.ovpn
```

**Windows:**
- Extract the files
- Import the `.ovpn` file through OpenVPN GUI

## Network Configuration

### IP Address Assignment

With the 169.254.100.0/24 network:
- **Server (Hub)**: 169.254.100.1
- **Client 1**: 169.254.100.2
- **Client 2**: 169.254.100.3
- **Client 3**: 169.254.100.4
- And so on...

### Adding Multiple Clients

For each additional client, repeat the client setup process:

```bash
# Generate new client certificate
sudo ./easyrsa gen-req CLIENT2_NAME nopass
sudo ./easyrsa sign-req client CLIENT2_NAME

# Create client directory and copy files
sudo mkdir -p /etc/openvpn/clients/CLIENT2_NAME
sudo cp pki/issued/CLIENT2_NAME.crt /etc/openvpn/clients/CLIENT2_NAME/
sudo cp pki/private/CLIENT2_NAME.key /etc/openvpn/clients/CLIENT2_NAME/
sudo cp pki/ca.crt /etc/openvpn/clients/CLIENT2_NAME/
sudo cp ta.key /etc/openvpn/clients/CLIENT2_NAME/
```

### Client-to-Client Communication

The `client-to-client` directive in the server configuration enables clients to communicate with each other through the hub. Each client will be assigned an IP from the 169.254.100.x range.

## Testing the Connection

### Step 1: Check Server Status

```bash
# Check OpenVPN status
sudo systemctl status openvpn@server

# View connected clients
sudo cat /var/log/openvpn/openvpn-status.log

# Check interface
ip addr show tun0
```

### Step 2: Test Connectivity

```bash
# From client to server (hub)
ping 169.254.100.1

# From server to client
ping 169.254.100.2

# Between clients (through hub)
ping 169.254.100.3
```

### Step 3: Test Internet Access

```bash
# Check if client can access internet through VPN
curl ifconfig.me

# Check routing table
ip route show
```

## Troubleshooting

### Common Issues

1. **Connection Fails**
   - Check firewall settings
   - Verify port 1194 is open
   - Ensure certificates are valid and properly configured

2. **No Internet Access**
   - Verify IP forwarding is enabled
   - Check iptables rules for 169.254.100.0/24 network
   - Ensure correct network interface name in MASQUERADE rule

3. **Client Cannot Reach Other Clients**
   - Verify `client-to-client` directive is in server config
   - Check routing table
   - Ensure server is forwarding traffic between 169.254.100.x addresses

4. **Certificate Errors**
   - Verify certificate expiration dates
   - Check certificate paths in configuration files
   - Ensure proper file permissions

### Useful Commands

```bash
# Check OpenVPN status
sudo systemctl status openvpn@server

# View OpenVPN logs
sudo tail -f /var/log/openvpn/openvpn.log

# Check interface status
ip addr show tun0

# Check routing table
ip route show

# Check firewall rules
sudo iptables -L -n -v

# Test certificate validity
openssl x509 -in /etc/openvpn/server.crt -text -noout

# Check VPN network connectivity
ping 169.254.100.1
```

### Revoking Client Certificates

```bash
# Revoke client certificate
cd /etc/openvpn/easy-rsa
sudo ./easyrsa revoke CLIENT_NAME

# Update CRL
sudo ./easyrsa gen-crl

# Copy CRL to OpenVPN directory
sudo cp pki/crl.pem /etc/openvpn/

# Add CRL to server configuration
echo "crl-verify crl.pem" | sudo tee -a /etc/openvpn/server.conf

# Restart OpenVPN
sudo systemctl restart openvpn@server
```

## Security Considerations

1. **Certificate Management**: Keep private keys secure and never share them
2. **Firewall**: Only allow necessary ports (1194/udp for OpenVPN)
3. **Updates**: Keep OpenVPN and system packages updated
4. **Monitoring**: Monitor logs for suspicious activity
5. **Backup**: Regularly backup configurations and certificates
6. **Certificate Expiration**: Monitor and renew certificates before expiration
7. **Network Isolation**: The 169.254.100.x range is isolated from typical network ranges

## Advanced Configuration

### Split Tunneling

To route only specific traffic through VPN, modify client configuration:

```ini
# Route only specific subnets
route 192.168.1.0 255.255.255.0

# Route all traffic (default)
redirect-gateway def1
```

### Custom DNS

```ini
# Push custom DNS servers
push "dhcp-option DNS 1.1.1.1"
push "dhcp-option DNS 1.0.0.1"
```

### Compression (if needed)

```ini
# Enable compression (use with caution)
comp-lzo
push "comp-lzo"
```

### Performance Tuning

```ini
# Optimize for performance
tun-mtu 1500
mssfix 1450
```

### Custom IP Pool Range

If you want to use a different 169.x.x.x range, modify the server configuration:

```ini
# Alternative 169.x.x.x ranges
server 169.254.200.0 255.255.255.0    # 169.254.200.1 - 169.254.200.254
# or
server 169.1.1.0 255.255.255.0        # 169.1.1.1 - 169.1.1.254
```

Remember to update the corresponding iptables rules:

```bash
# Update iptables for different range
sudo iptables -t nat -D POSTROUTING -s 169.254.100.0/24 -o eth0 -j MASQUERADE
sudo iptables -t nat -A POSTROUTING -s 169.1.1.0/24 -o eth0 -j MASQUERADE
```

## Backup and Recovery

### Backup Important Files

```bash
# Create backup directory
sudo mkdir -p /opt/openvpn-backup

# Backup certificates and configurations
sudo cp -r /etc/openvpn/easy-rsa /opt/openvpn-backup/
sudo cp -r /etc/openvpn/clients /opt/openvpn-backup/
sudo cp /etc/openvpn/server.conf /opt/openvpn-backup/
sudo cp /etc/openvpn/*.crt /opt/openvpn-backup/
sudo cp /etc/openvpn/*.key /opt/openvpn-backup/
sudo cp /etc/openvpn/*.pem /opt/openvpn-backup/

# Create backup archive
sudo tar -czf /opt/openvpn-backup-$(date +%Y%m%d).tar.gz -C /opt openvpn-backup/
```

## Network Topology Diagram

```
Internet
    |
[Server/Hub: 169.254.100.1]
    |
    +-- [Client 1: 169.254.100.2]
    |
    +-- [Client 2: 169.254.100.3]
    |
    +-- [Client 3: 169.254.100.4]
    |
    +-- [Client N: 169.254.100.x]
```

This guide provides a complete setup for an OpenVPN hub-and-spoke VPN network using the 169.254.100.0/24 IP range. Each client can connect to the hub, and the hub can route traffic between all connected clients while providing internet access through NAT. The setup includes proper certificate management, security configurations, and troubleshooting steps specific to the 169.x.x.x addressing scheme.