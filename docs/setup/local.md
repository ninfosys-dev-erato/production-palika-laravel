# Local Development Setup Guide

This guide will help you set up the Laravel application for local development without Docker.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP 8.1+** with required extensions
- **Composer** (PHP package manager)
- **MySQL 8.0+** or **MariaDB 10.5+**
- **Node.js** (for frontend assets compilation)
- **Git** (for cloning the repository)
- **Redis** (optional, for caching and queues)
- **Web Server** (Apache/Nginx) or use PHP's built-in server

## System Requirements

### PHP Extensions Required

Make sure your PHP installation includes these extensions:

```bash
# Required PHP extensions
php-bcmath
php-curl
php-dom
php-fileinfo
php-gd
php-intl
php-json
php-mbstring
php-mysql
php-opcache
php-pdo
php-sqlite3
php-xml
php-zip
php-redis (optional)
php-memcached (optional)
```

### Installing PHP Extensions (macOS)

```bash
# Using Homebrew
brew install php@8.3
brew install php@8.3-bcmath php@8.3-curl php@8.3-dom php@8.3-fileinfo php@8.3-gd php@8.3-intl php@8.3-json php@8.3-mbstring php@8.3-mysql php@8.3-opcache php@8.3-pdo php@8.3-sqlite3 php@8.3-xml php@8.3-zip php@8.3-redis php@8.3-memcached
```

### Installing PHP Extensions (Ubuntu/Debian)

```bash
# Install PHP and extensions
sudo apt update
sudo apt install php8.3 php8.3-cli php8.3-common php8.3-bcmath php8.3-curl php8.3-dom php8.3-fileinfo php8.3-gd php8.3-intl php8.3-json php8.3-mbstring php8.3-mysql php8.3-opcache php8.3-pdo php8.3-sqlite3 php8.3-xml php8.3-zip php8.3-redis php8.3-memcached
```

### Installing MySQL

#### macOS (using Homebrew)
```bash
brew install mysql
brew services start mysql
```

#### Ubuntu/Debian
```bash
sudo apt install mysql-server
sudo systemctl start mysql
sudo systemctl enable mysql
```

## Quick Start

### 1. Clone the Repository

```bash
git clone <repository-url>
cd production-palika
```

### 2. Environment Configuration

Copy the example environment file and configure it for your local setup:

```bash
cp .evn.suryabinayak .env
```

Edit the `.env` file with your local configuration:

```env
APP_NAME="Lalitpur Palika"
APP_ENV=local
APP_KEY=base64:tkzgOao13U2VAWUFGlZS616Q/nrLt6TjMf/gHOQ3MlU=
APP_DEBUG=true
APP_TIMEZONE=Asia/Kathmandu
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_local
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

# Other settings remain the same...
```

### 3. Install Dependencies

Install PHP dependencies using Composer:

```bash
# Install Composer dependencies
composer install

# Install NPM dependencies (if needed)
npm install
```

### 4. Database Setup

Create the database and set up tables:

```bash
# Create database (replace with your MySQL credentials)
mysql -u root -p -e "CREATE DATABASE laravel_local CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations
php artisan migrate

# Seed the database (optional)
php artisan db:seed

# Or run specific seeders
php artisan db:seed --class=AuthSeeder
```

### 5. Storage Setup

Set up Laravel storage:

```bash
# Create storage link
php artisan storage:link

# Set proper permissions
chmod -R 775 storage bootstrap/cache
```

### 6. Generate Application Key

If you don't have an application key:

```bash
php artisan key:generate
```

### 7. Cache Configuration

Clear and cache configuration:

```bash
# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache configuration for better performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Development Workflow

### Starting the Development Server

```bash
# Start Laravel's built-in development server
php artisan serve

# Or specify a different port
php artisan serve --port=8000

# Or bind to all interfaces
php artisan serve --host=0.0.0.0 --port=8000
```

### Running Artisan Commands

```bash
# General format
php artisan <command>

# Examples
php artisan make:controller UserController
php artisan make:migration create_users_table
php artisan migrate:status
php artisan list
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/UserTest.php

# Run tests with coverage
php artisan test --coverage
```

### Database Management

```bash
# Access MySQL CLI
mysql -u root -p laravel_local

# Create a new migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Reset database and run migrations
php artisan migrate:fresh

# Reset database, run migrations, and seed
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status
```

### Queue Management

```bash
# Start queue worker
php artisan queue:work

# Monitor queue
php artisan queue:monitor

# Clear failed jobs
php artisan queue:flush

# Restart queue workers
php artisan queue:restart
```

## Web Server Configuration

### Using Apache

Create a virtual host configuration:

```apache
<VirtualHost *:80>
    ServerName laravel.local
    DocumentRoot /path/to/production-palika/public
    
    <Directory /path/to/production-palika/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/laravel_error.log
    CustomLog ${APACHE_LOG_DIR}/laravel_access.log combined
</VirtualHost>
```

### Using Nginx

Create a server block configuration:

```nginx
server {
    listen 80;
    server_name laravel.local;
    root /path/to/production-palika/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Using PHP Built-in Server (Development Only)

```bash
# Start the development server
php artisan serve

# The application will be available at http://localhost:8000
```

## Additional Services Setup

### Redis Setup (Optional)

#### macOS
```bash
brew install redis
brew services start redis
```

#### Ubuntu/Debian
```bash
sudo apt install redis-server
sudo systemctl start redis
sudo systemctl enable redis
```

### Mail Testing with Mailpit

#### macOS
```bash
brew install mailpit
brew services start mailpit
```

#### Ubuntu/Debian
```bash
# Download and install Mailpit
wget https://github.com/axllent/mailpit/releases/download/v1.0.0/mailpit-linux-amd64
sudo mv mailpit-linux-amd64 /usr/local/bin/mailpit
sudo chmod +x /usr/local/bin/mailpit

# Create systemd service
sudo tee /etc/systemd/system/mailpit.service > /dev/null <<EOF
[Unit]
Description=Mailpit
After=network.target

[Service]
Type=simple
User=www-data
ExecStart=/usr/local/bin/mailpit
Restart=always

[Install]
WantedBy=multi-user.target
EOF

sudo systemctl enable mailpit
sudo systemctl start mailpit
```

## Troubleshooting

### Common Issues

#### 1. Permission Issues

If you encounter permission issues with storage or cache directories:

```bash
# Fix permissions
sudo chown -R $USER:$USER storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

#### 2. Database Connection Issues

If the application can't connect to the database:

```bash
# Check MySQL status
sudo systemctl status mysql

# Restart MySQL
sudo systemctl restart mysql

# Check MySQL connection
mysql -u root -p -e "SHOW DATABASES;"
```

#### 3. Port Conflicts

If port 8000 is already in use:

```bash
# Find what's using the port
lsof -i :8000

# Use a different port
php artisan serve --port=8001
```

#### 4. PHP Extension Issues

Check if all required PHP extensions are installed:

```bash
# Check PHP version
php -v

# Check installed extensions
php -m

# Check specific extension
php -m | grep -i mysql
```

#### 5. Composer Issues

If you encounter Composer issues:

```bash
# Clear Composer cache
composer clear-cache

# Update Composer
composer self-update

# Reinstall dependencies
rm -rf vendor composer.lock
composer install
```

### Useful Commands

```bash
# Check PHP configuration
php --ini

# Check PHP extensions
php -m

# Check Laravel requirements
php artisan about

# Clear all caches
php artisan optimize:clear

# Check application status
php artisan route:list
php artisan config:show
```

## Development Tools

### Xdebug Configuration

For debugging, configure Xdebug in your `php.ini`:

```ini
[xdebug]
zend_extension=xdebug.so
xdebug.mode=develop,debug
xdebug.client_host=127.0.0.1
xdebug.client_port=9003
xdebug.start_with_request=yes
```

### File Watching

For automatic asset compilation during development:

```bash
# Watch for changes and compile assets
npm run dev

# Or for production build
npm run build
```

## Environment Variables

Key environment variables for local development:

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_ENV` | Application environment | `local` |
| `APP_DEBUG` | Enable debug mode | `true` |
| `APP_URL` | Application URL | `http://localhost:8000` |
| `DB_HOST` | Database host | `127.0.0.1` |
| `DB_DATABASE` | Database name | `laravel_local` |
| `DB_USERNAME` | Database username | `root` |
| `DB_PASSWORD` | Database password | `your_password` |

## Next Steps

After setting up your local environment:

1. **Explore the Application**: Visit `http://localhost:8000` in your browser
2. **Check Logs**: Monitor application logs in `storage/logs/laravel.log`
3. **Run Tests**: Ensure all tests pass with `php artisan test`
4. **Set Up IDE**: Configure your IDE for Laravel development
5. **Read Documentation**: Review the application's source code and documentation

## Support

If you encounter any issues during setup:

1. Check the troubleshooting section above
2. Review Laravel logs in `storage/logs/laravel.log`
3. Ensure all prerequisites are properly installed
4. Verify your environment configuration

For additional help, refer to:
- [Laravel Documentation](https://laravel.com/docs)
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Composer Documentation](https://getcomposer.org/doc/)
