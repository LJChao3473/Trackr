#!/bin/bash

apt-get update

# Instal·lació Apache2
apt-get install -y apache2
ufw allow 'Apache'
a2enmod rewrite
a2enmod actions
sed -i '170,174 s/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Creació de carpetes compartides
mkdir -p /www/var/html/css
mkdir -p /www/var/html/js
mkdir -p /www/var/html/img
mkdir -p /www/var/html/includes
mkdir -p /www/var/html/operacions

# Instal·lació php
apt-get install -y php
apt-get install -y php-mysqli

# Instal·lació MariaDB i creació usuari admin
apt-get install -y mariadb-server mariadb-client

mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin';"
mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

mysql -e "SOURCE /db/trackr.sql"
mysql -e "SOURCE /db/trackr-insert.sql"