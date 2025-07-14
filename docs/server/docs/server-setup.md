# User and Groups

For digital epalika related works a dedicated user with limited permissions and such is assigned to the digital epalika application user that has limited access rights and such and as access to the digital epalika system and files, but not to the backup, only to the limited user space and such things.

The root user needs to install the following things:
`sudo apt update && sudo apt upgrade`

Then install the following things:
`sudo apt install docker docker-compose`

Check if the `nginx` is available via `systemctl status nginx` and if not, install it using:
`sudo apt install nginx`
Enable  the nginx service using:   
`sudo systemctl enable --now nginx`

Update the `/etc/nginx/nginx.con`f` file to include the following line:
```
include /etc/nginx/sites-available/digital-epalika/*;
```

# Digital Epalika User Setup

- The group name will be `epalika` and the user name will be `epalikadmin`.
- The user will be added to the `docker` group to allow running Docker commands without `sudo`.
- The user will also have the accessibility to update the `/etc/nginx/sites-available/digital-epalika` file for Nginx configuration.

### User setup and docker permissions

```
sudo groupadd epalika
sudo useradd -m -s /bin/bash -g epalika epalikadmin
sudo passwd epalikadmin
sudo usermod -aG docker epalikadmin
```

### Nginx permissions
```
sudo chown root:epalika /etc/nginx/sites-available/digital-epalika
sudo chmod 664 /etc/nginx/sites-available/digital-epalika
```

### Installing PHP
Install PHP and required extensions:
```bash
sudo apt install php php-fpm php-mysql php-xml php-mbstring php-curl php-zip php-gd php-bcmath php-json
```
### Installing Composer
Install Composer:   
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```