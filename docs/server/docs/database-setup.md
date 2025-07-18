# Database Setup for Digital Epalika

Using the root user, you need to set up the database for Digital Epalika. Follow these steps:
Install `mariadb-server` using:
```bash
sudo apt install mariadb-server
```

Secure the MariaDB installation by running:
```bash
sudo mysql_secure_installation
```

Then login to the MariaDB server:
```bash
sudo mariadb
```

Now we need to create a different database for each palika and a user for each palika with priveleges specific to that palika only.

But first since all our instances are containerized, we need to configure the MariaDB server to allow connections from the Docker network. Edit the MariaDB configuration file:
```bash
sudo vim /etc/mysql/mariadb.conf.d/50-server.cnf
```
Find the line that says `bind-address = 127.0.0.1` and change it to `bind-address = 0.0.0.0`.

This allows the MariaDB server to accept connections from any IP address, including those from Docker containers.
After saving the changes, restart the MariaDB service:
```bash
sudo systemctl restart mariadb
```

Now, create a new database for each palika using the following commands:
```sql
-- Create the database
CREATE DATABASE <palika_name> CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Replace `<palika_name>` with the actual name of the palika. Repeat this for each palika you need to set up.


Next, create a user for each palika and grant them privileges on their respective database:
```sql
-- Create the user 
CREATE USER '<palika_user>'@'%' IDENTIFIED BY '<password>';
-- Grant privileges to the user
GRANT ALL PRIVILEGES ON <palika_name>.* TO '<palika_user>'@'%';
-- Flush privileges to ensure that the changes take effect
FLUSH PRIVILEGES;
```
Replace `<palika_user>` with the username for the palika and `<password>` with a secure password. Again, repeat this for each palika.

If you have a dump file for the palika's database, you can import it using:
```bash
mysql -u <palika_user> -p <palika_name> < /path/to/dumpfile.sql
```
Replace `/path/to/dumpfile.sql` with the actual path to the SQL dump file for the palika.


Now in the laravel `.env` file of each palika, you need to set the database connection details:
```env
DB_CONNECTION=mysql
DB_HOST=<mariadb_host>
DB_PORT=3306
DB_DATABASE=<palika_name>
DB_USERNAME=<palika_user>
DB_PASSWORD=<password>
```
Replace `<mariadb_host>` with the IP address of the MariaDB server, `<palika_name>` with the name of the palika's database, `<palika_user>` with the palika's username, and `<password>` with the corresponding password.   

If you are using docker for the mariadb server, with the server configured to listen at the `localhost` address, you should set the host as
```env
DB_HOST=host.docker.internal
``` 
