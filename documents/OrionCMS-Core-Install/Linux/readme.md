# Linux Ubuntu installation document for OrionCMS

Install a fresh copy of Ubuntu Server (22.04 is the curent stable release and will be used) on to your VPS/Server or use it on your windows (WSL)
More info on how to install WSL on windows can be found here : https://learn.microsoft.com/en-us/windows/wsl/install
For running a Retro hotel i do recomend to use a Linux operating system as this has more advantages then the Windows platform.
Example : 
- NGINX is Build for Linux system and has been ported to Windows but will perform less due to the file system.
- Running linux dockers to add functions like the habbo imager, on busy hotels NGINX Proxy manager
- Better support for running ARC or any other emulator as a Linux service
- We see much better performance on Linux then on Windows, specialy the CMS
- Opensource, so there are many more resources avalible to tune the Kernel / TCP Stack.

Always keep in mind to use an CDN (Cloudflare / Akamai / Fastly and many more), we advise you to start with Cloudflare and use the Free version to start.
When you hotel is >50 users online then start thinking about Cloudflare Pro or a better fit to your needs.
Some advise never use the "Cloudflare Zero Trust" option to reach your VPS, as this will NOT protect you when using the Cloudflare Proxy option.
This is however a nice feature, but this is for a Home NAS / Application like Home Assist etc. but never for a production system !

We will be installing the follwing on to the system.
- NGINX high perfomance webserver
- MariaDB 10.11 latest stable version, please do not install version 11 as this can cause problems with the emulators at the moment

## Setup the infra for OrionCMS

We are going to install all the requirements for the OrionCMS, and also make it ready for any kind of Habbo Emulator.
The following is a requirement on your local laptop/desktop:

- SSH client, for this i do reccomend MobaXterm https://mobaxterm.mobatek.net/download.html this is a free version
- MySQL Workbench, for this i reccomend to use Heidi (make it your self easy don't use a pirat copy of Navicat, this is just bad software and alot cracked versions come with spyware) https://www.heidisql.com/
- WinSCP, a free tool to quicly transfer files from your machine to the server https://winscp.net/eng/download.php


#### NGINX

```cmd
apt install curl gnupg2 ca-certificates lsb-release dirmngr software-properties-common apt-transport-https -y
curl -fSsL https://nginx.org/keys/nginx_signing.key | sudo gpg --dearmor | sudo tee /usr/share/keyrings/nginx-archive-keyring.gpg >/dev/null
gpg --dry-run --quiet --import --import-options import-show /usr/share/keyrings/nginx-archive-keyring.gpg
echo "deb [arch=amd64,arm64 signed-by=/usr/share/keyrings/nginx-archive-keyring.gpg] http://nginx.org/packages/mainline/ubuntu `lsb_release -cs` nginx" | sudo tee /etc/apt/sources.list.d/nginx.list
echo -e "Package: *\nPin: origin nginx.org\nPin: release o=nginx\nPin-Priority: 900\n" | sudo tee /etc/apt/preferences.d/99nginx
apt update -y
apt install nginx-common -y
apt install nginx -y
```
When there are popup screens just pres OK

#### NGINX PHP-FPM 8.2

```cmd
sudo add-apt-repository ppa:ondrej/php -y
sudo apt install php8.2-fpm php8.2 php8.2-common php8.2-mysql php8.2-xml php8.2-xmlrpc php8.2-curl php8.2-gd php8.2-imagick php8.2-cli php8.2-imap php8.2-mbstring php8.2-opcache php8.2-soap php8.2-zip php8.2-intl php8.2-bcmath unzip -y
```
When there are popup screens just pres OK

#### MariaDB

```cmd
apt-get install apt-transport-https curl -y
mkdir -p /etc/apt/keyrings
curl -o /etc/apt/keyrings/mariadb-keyring.pgp 'https://mariadb.org/mariadb_release_signing_key.pgp'
```
When there are popup screens just pres OK

create the following file: ```vi /etc/apt/sources.list.d/mariadb.sources``` (First press the letter i before paste you will the see in the left corner the text -- INSERT --)

```config
# MariaDB 10.11 repository list - created 2023-07-11 05:47 UTC
# https://mariadb.org/download/
X-Repolib-Name: MariaDB
Types: deb
# deb.mariadb.org is a dynamic mirror if your preferred mirror goes offline. See https://mariadb.org/mirrorbits/ for details.
# URIs: https://deb.mariadb.org/10.11/ubuntu
URIs: https://mirrors.xtom.de/mariadb/repo/10.11/ubuntu
Suites: jammy
Components: main main/debug
Signed-By: /etc/apt/keyrings/mariadb-keyring.pgp
```

When pasted press [ESC] then type ```:wq``` <-- make sure that there are no capitals

```cmd
apt-get update -y
apt-get install mariadb-server -y
```

#### Composer and NodeJS

```cmd
curl -sL https://deb.nodesource.com/setup_19.x | sudo -E bash -
apt install nodejs -y
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
sudo php /tmp/composer-setup.php --install-dir=/usr/bin --filename=composer
```
When there are popup screens just pres OK


## Setup Database and secure your server

### SSH Security 

First we want to secure the server by removing password authentication, and use KEY authication with your own password.
We will also use the same key to get connected to the Database, this way only the SSH port needs to be open to the internet and port 3306 will not be needed.
Therefore way more secure and also much better to maintain, by just adding a key the user will get access.

#### Step 1 :
- Open MobaXterm
- In the window select Tools (this is on top in the menu section)
- Select "MobaKeyGen (SSH Key generator)"
- Select Generate <-- Move your mouse until the generate is compleet
- Copy the content of the key to a file on your PC/Laptop example (don't press the Save public key this will not work!)
create a file ```C:\Key\Public.key``` and then paste the content (like this below)
```SSH-Key
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDJXTjI5gozMN8XmFwIdC76h8zv/tDc5l5kLNdaplEgpRtcrVj+zJZ1/IT/L1gUWGZbrat/UoCD0eIdXi5o7GwXrBszkIoQA26GN5MNmvZU/JQSWDwfaXzCI1rYnZxXCXf+eRThBfdW8rHzXEiG9bvsq9ppz7T75pB5Pv6Qem/lzuiUm3wbvh4wpCkMkBDLepyAXOBGu4T+sARCPkoW4In4fP1pMzzkRqMhXCLnFPhqY692kSsChXbeIeuVls5iBnf55jM5ZJKIOFebdxZNoSkb4/nq7VepzrByWeoYcjfZM8/ZjZ0EBd8DmFgpTD0AQBqwc3oZUo+sikyFoFUDkJNp rsa-key-20230711
```
- Enter a password in "Key passphrase" and the same password in "Confirm passphrase" <-- VERY IMPORTANT
- Press the "Save private key" button and save this in the same location as the public.key ```c:\Key\Privatekey.pkk```

Login to Your VPS/Server and we are going to set the SSH key, i will set it as root user this can ofcourse can also be done for normal user accounts
#### Step 2 :
- ```vi /root/.ssh/authorized_keys```
- Paste the content of the Public.key into the editor (First press the letter i before paste you will the see in the left corner the text -- INSERT --)
- When pasted press [ESC] then type ```:wq``` <-- make sure that there are no capitals
- run the following command ```service ssh restart```

#### Step 3 :
Now we will test the use of the SSHkey before we make the SSH secure as we do not want to lose access to the server :)
Open the MobaXterm and duplicate your current server so you get a copy of the server.
Now edit the settings by right click the newly copied and select "Edit settings"
In the Session settings screen now select "Advanced SSH settings" and enable "Use Private key"
After this you can select the file "C:\Key\Privatekey.pkk" in the "Use private key" field
When you have selected it press OK

Now use the newly copied object that will connect to your server using the SSHKey, you will be prompted for username "root" and password "This is the password that you have set in the generate of the key so not the server password"
When this is connected then all went well if not you did something wrong and needs fixing before continuing.

#### Step 3 :
Connect now with your newly created SSH session and using the Key (remove the old one !)
- ```>/etc/ssh/sshd_config```
- ```vi /etc/ssh/sshd_config```
paste the following into the sshd_config (First press the letter i before paste you will the see in the left corner the text -- INSERT --)
```config
Include /etc/ssh/sshd_config.d/*.conf
Port 22
PermitRootLogin yes
PasswordAuthentication no
PubkeyAuthentication yes
KbdInteractiveAuthentication no
UsePAM yes
X11Forwarding yes
PrintMotd no
AcceptEnv LANG LC_*
Subsystem       sftp    /usr/lib/openssh/sftp-server
```
When pasted press [ESC] then type ```:wq``` <-- make sure that there are no capitals

now reboot the server by the command : ```reboot```
And always make a backup of both keys in a secure place, because if you lose the keys there is no way to get access remote to the server !!!
Your only option then is by using a VNC / Terminal / KVM etc.

### Database setup
First we need to finalyze the setup of MariaDB.
```cmd
mariadb-secure-installation
```
```Text
Enter current password for root (enter for none):   <---- Press ENTER
Switch to unix_socket authentication [Y/n] n  <---- Press n
Change the root password? [Y/n] n  <---- Press n
Remove anonymous users? [Y/n] Y  <---- Press Y
Disallow root login remotely? [Y/n] n  <---- Press n
Remove test database and access to it? [Y/n] Y  <---- Press Y
Reload privilege tables now? [Y/n] Y  <---- Press Y
```

now we need to allow connections to the Database:
```cmd
vi /etc/mysql/mariadb.conf.d/50-server.cnf
```
Edit the following setting (First press the letter i before edit you will the see in the left corner the text -- INSERT --):
```
bind-address            = 127.0.0.1
``` 
Change this to:
```
bind-address            = 0.0.0.0
```

Now we are able to connect from anywhere, but keep in mind only with SSH so it is not a direct connection over port 3306

We now need to add a root user and CMS user to the database, and for the CMS user we will use the database name habbo (you can change this whatever you want ofcourse!).
Also change the password to whatever you like.

Run the following command:
```cmd
mariadb
```
Now paste the following SQL (after changing the passwords!)
```sql
CREATE USER 'root'@'%' IDENTIFIED BY 'CHANGE THIS TO YOUR DB ROOT PASSWORD';
CREATE USER 'cms'@'%' IDENTIFIED BY 'CHANGE THIS TO YOUR DB CMS PASSWORD';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;
CREATE SCHEMA `habbo` ; # This is the database
GRANT EXECUTE, SELECT, SHOW VIEW, ALTER, ALTER ROUTINE, CREATE, CREATE ROUTINE, CREATE TEMPORARY TABLES, CREATE VIEW, DELETE, DROP, EVENT, INDEX, INSERT, REFERENCES, TRIGGER, UPDATE, LOCK TABLES  ON `habbo`.* TO 'cms'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```
To make sure all is ready to go run : ```reboot```

You are now able to connect to the Database using your SSH-Key with the use of HeidiSQL, how to set this up use the following link : https://www.enovision.net/mysql-ssh-tunnel-heidisql here it is in detail explained how to connect

You can now import the Database from ARC or any other one you like expl : https://git.krews.org/morningstar/ms4-base-database/-/releases <== ms4db-all-init.sql

## OrionCMS

```cmd
cd /var/www/
rm -r html
git clone https://github.com/nicollassilva/orioncms.git
cd orioncms
cp .env.example .env
```
No edit all the settings like URL / Database settings etc. in the .env : ```vi /var/www/orioncms/.env```

Make it look like so:

```
APP_NAME=habbo
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://mydomain.com
APP_TIMEZONE='Europe/Amsterdam' #CHANGE THIS TO YOUR TIMEZONE

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Change those to match your database settings
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=habbo
DB_USERNAME=cms
DB_PASSWORD=#YOUR PASSWORD#
```

Next install the CMS:
```cmd
composer install # Press enter by [yes]
npm install --global yarn
yarn install
yarn build
`` 

## NGINX Setup

```cmd
cd /etc/nginx
>nginx.conf
rm sites-available/default
rm sites-enabled/default
vi /etc/nginx/nginx.conf
```

paste the following in the nginx.comf (First press the letter i before paste you will the see in the left corner the text -- INSERT --)
```config
user www-data;
worker_processes auto;
worker_rlimit_nofile 20000;
pid /run/nginx.pid;
include /etc/nginx/modules-enabled/*.conf;

events {
        worker_connections 1024;
        multi_accept off;
}

http {

        ##
        # Basic Settings
        ##

        sendfile on;
        tcp_nopush on;
        tcp_nodelay on;
        keepalive_timeout 65;
        types_hash_max_size 2048;
        client_max_body_size 100M;
        # server_tokens off;
        # server_names_hash_bucket_size 64;
        # server_name_in_redirect off;

        include /etc/nginx/mime.types;
        default_type application/octet-stream;

        # Rate limiting
        limit_conn_zone $binary_remote_addr zone=addr:10m;
        limit_req_zone $binary_remote_addr zone=req_limit_per_ip:10m rate=25r/s;
        # SSL Settings

        log_format custom '$remote_user [$time_local] - $remote_addr :'
        '"$request" $status $body_bytes_sent - '
        'Refer:"$http_referer" Country:"$http_cf_ipcountry"';

        ssl_protocols TLSv1 TLSv1.1 TLSv1.2 TLSv1.3;

        # Dropping SSLv3, ref: POODLE
        ssl_prefer_server_ciphers on;

        # Logging Settings
        access_log /var/log/nginx/access.log;
        error_log /var/log/nginx/error.log;

        # Gzip Settings

        #gzip on;

        # Virtual Host Configs

        include /etc/nginx/cloudflare;
        include /etc/nginx/conf.d/*.conf;
        include /etc/nginx/sites-enabled/*;
}
```
When pasted press [ESC] then type ```:wq``` <-- make sure that there are no capitals

```vi /etc/nginx/sites-available/cms.conf```cmd
Paste the following in the cms.conf file, And change the ###URL### to your domain

```
server {
        listen 80;
        listen [::]:80;
        
        index index.php index.html index.htm;

        autoindex off;
        server_tokens off;
        add_header X-Frame-Options SAMEORIGIN;
        add_header OrionCMS "This is an SpongeBob server";
        add_header X-Content-Type-Options "nosniff" always;
        add_header Referrer-Policy "strict-origin";
        add_header X-XSS-Protection "1; mode=block";
        add_header Permissions-Policy "autoplay=(self), encrypted-media=(), fullscreen=(), geolocation=(), microphone=(), midi=()";
        add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
        
        access_log /var/log/nginx/cms.log custom;
        error_log /var/log/nginx/cms_error.log;

        server_name ###URL###;

        root /var/www/orioncms/public;
        index index.php index.html index.htm;

        location / {
        try_files $uri $uri/ /index.php?$query_string;
        limit_conn addr 10;
        autoindex off;
        }

        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_param PHP_ADMIN_VALUE "allow_url_fopen=1";
                fastcgi_param PHP_ADMIN_VALUE "file_uploads=0";
                fastcgi_param PHP_VALUE open_basedir="/var/www/orioncms/:/tmp/";
                fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        }
}
```
We will make a script for Cloudflare to access with RealIP in the logs
```
mkdir /var/scripts
vi /var/scripts/CF_Refresh.cf
```
Paste the following config:
```
#!/bin/bash

CLOUDFLARE_FILE_PATH=/etc/nginx/cloudflare

echo "#Cloudflare" > $CLOUDFLARE_FILE_PATH;
echo "" >> $CLOUDFLARE_FILE_PATH;

echo "# - IPv4" >> $CLOUDFLARE_FILE_PATH;
for i in `curl https://www.cloudflare.com/ips-v4`; do
    echo "set_real_ip_from $i;" >> $CLOUDFLARE_FILE_PATH;
done

echo "" >> $CLOUDFLARE_FILE_PATH;
echo "# - IPv6" >> $CLOUDFLARE_FILE_PATH;
for i in `curl https://www.cloudflare.com/ips-v6`; do
    echo "set_real_ip_from $i;" >> $CLOUDFLARE_FILE_PATH;
done

echo "" >> $CLOUDFLARE_FILE_PATH;
echo "real_ip_header CF-Connecting-IP;" >> $CLOUDFLARE_FILE_PATH;

#test configuration and reload nginx
nginx -t && systemctl reload nginx
```
Now make it executable and run the script
```cmd
chmod +x /var/scripts/CF_Refresh.cf

now lets bind the config to nginx: 
```cmd
ln -s /etc/nginx/sites-available/cms.conf /etc/nginx/sites-enabled/
```