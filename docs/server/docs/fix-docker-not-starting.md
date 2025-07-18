# Problem: `iptables` error preventing Docker from starting

Error:
```
failed to start daemon: Error initializing network controller: error obtaining controller instance: failed to create NAT chain DOCKER: iptables failed: iptables -t nat -N DOCKER: iptables v1.8.9 (nf_tables): Could not fetch rule set generation id: Invalid argument
```

Switch iptables to “legacy” mode. Select the `lgeacy` mode.

```bash
sudo update-alternatives --config iptables
sudo update-alternatives --config ip6tables
```

Verify the `iptables` version to see which is it using:
```bash
sudo iptables --version
```

Then restart the Docker service:
```bash
sudo systemctl restart docker
```
Also verify the status
```bash
sudo systemctl status docker
```

# Problem with docker container not being compatible with `runc` container runtime

Error:
```
error setting cgroup config for procHooks process: bpf_prog_query(BPF_CGROUP_DEVICE) failed: function not implemented
```

Update to the latest Docker CE:
```bash
sudo apt-get remove docker docker-engine docker.io containerd runc
```
Then install Docker’s official latest stable release:

```bash
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/debian/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg

echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/debian bookworm stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
```

Install the docker commands:
```bash
sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```
