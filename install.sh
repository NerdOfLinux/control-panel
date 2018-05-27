#!/bin/bash
# Error codes:
#  1 = user didn't type "y" at prompt
#  2 = script was not run as root
#  3 = new sudoers file in /tmp is broken
# Install script for: https://github.com/NerdOfLinux/control-panel
# WARNING!!! This script has NOT been fully tested yet. Please only run on a clean install.
#Get confirmation
echo "Welcome to the install script for NerdOfLinux's Control Panel."
echo "Please run on a clean install, or your existing files may be deleted!"
if [ -z "$1" ]
then
	read -p "Type 'y' to continue: " confirm
	if [ $confirm != "y" ]
	then
		echo "Ok. Bye."
		exit 1
	fi
fi
#Check if running as root
if [ $(whoami) != "root" ]
then
	echo "Please run as root."
	exit 2
fi
if [ -z "$2" ]
then
     echo "Please enter your root domain(i.e. example.com)"
     read -p "domain: " domain
else
     domain="$2"
fi
#Check if the "apt" command is available
if ! which apt
then
	echo "Could not find apt. Make sure your path is properly configured, and if it is, you may not be on a supported distro :-("
fi
#Get dependencies
echo "Installing required packages..."
apt update
apt -y install git nginx php7.0-fpm php-json mariadb-client-10.0 mariadb-server-10.0 ssl-cert
#Move to proper directory
cd /var/www/
#Clone repository
echo "Getting files..."
git clone https://github.com/NerdOfLinux/control-panel.git
chown -R www-data:www-data control-panel
#Set hostname to domain
echo "Setting hostname to $domain"
hostname $domain
echo "$domain" > /etc/hostname
#Configure NGINX
echo "Configuring NGINX..."
cat > /etc/nginx/sites-available/panel.conf <<EOF
server {
        listen *:80;

        index index.php;
        root /var/www/control-panel;
        server_name panel.${domain};
        include /var/www/control-panel/nginx.conf;
        location /{
                try_files \$uri \$uri/ index.php;
        }

	   include snippets/php;
         location ~ /\.ht {
                deny all;
        }
       include snippets/ssl;
}
EOF
cat > /etc/nginx/snippets/php <<EOF
location ~ \.php$ {
        fastcgi_index index.php;
        try_files \$uri =404;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        include /etc/nginx/fastcgi.conf;
}
EOF
cat > /etc/nginx/snippets/ssl <<EOF
listen *:443 ssl;
listen [::]:443 ssl;
include snippets/snakeoil.conf;
EOF
ln -s /etc/nginx/sites-available/panel.conf /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
#Configure permissions
echo "Configuring permissions..."
file=$(mktemp)
cp /etc/sudoers $file
echo "www-data ALL=(ALL:ALL) NOPASSWD:/var/www/control-panel/assets/wrapper.sh" >> $file
#Only apply changes if the file is not broken
if visudo -c -f $file
then
	cp $file /etc/sudoers
else
	echo "CRITICAL ERROR: new sudoers file corrupt, exiting now!"
	exit 3
fi
rm $file
chmod +x /var/www/control-panel/assets/backend.sh
chmod +x /var/www/control-panel/assets/wrapper.sh
#Set correct login shell
sudo chsh www-data -s /bin/bash
#Tell user to complete install
echo "Please go to panel.${domain}/install.php to complete the install."
#!/bin/bash
# Error codes:
#  1 = user didn't type "y" at prompt
#  2 = script was not run as root
#  3 = new sudoers file in /tmp is broken
# Install script for: https://github.com/NerdOfLinux/control-panel
# WARNING!!! This script has NOT been fully tested yet. Please only run on a clean install.
#Get confirmation
echo "Welcome to the install script for NerdOfLinux's Control Panel."
echo "Please run on a clean install, or your existing files may be deleted!"
if [ -z "$1" ]
then
        read -p "Type 'y' to continue: " confirm
        if [ $confirm != "y" ]
        then
                echo "Ok. Bye."
                exit 1
        fi
fi
#Check if running as root
if [ $(whoami) != "root" ]
then
        echo "Please run as root."
        exit 2
fi
if [ -z "$2" ]
then
     echo "Please enter your root domain(i.e. example.com)"
     read -p "domain: " domain
else
     domain="$2"
fi
#Check if the "apt" command is available
if ! which apt
then
        echo "Could not find apt. Make sure your path is properly configured, and if it is, you may not be on a supported distro :-("
fi
#Get dependencies
echo "Installing required packages..."
apt update
apt -y install git nginx php7.0-fpm php-json mariadb-client-10.0 mariadb-server-10.0 ssl-cert
#Move to proper directory
cd /var/www/
#Clone repository
echo "Getting files..."
git clone https://github.com/NerdOfLinux/control-panel.git
chown -R www-data:www-data control-panel
#Set hostname to domain
echo "Setting hostname to $domain"
hostname $domain
echo "$domain" > /etc/hostname
#Configure NGINX
echo "Configuring NGINX..."
cat > /etc/nginx/sites-available/panel.conf <<EOF
server {
        listen *:80;

        index index.php;
        root /var/www/control-panel;
        server_name panel.${domain};
        include /var/www/control-panel/nginx.conf;
        location /{
                try_files \$uri \$uri/ index.php;
        }

           include snippets/php;
         location ~ /\.ht {
                deny all;
        }
       include snippets/ssl;
}
EOF
cat > /etc/nginx/snippets/php <<EOF
location ~ \.php$ {
        fastcgi_index index.php;
        try_files \$uri =404;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        include /etc/nginx/fastcgi.conf;
}
EOF
cat > /etc/nginx/snippets/ssl <<EOF
listen *:443 ssl;
listen [::]:443 ssl;
include snippets/snakeoil.conf;
EOF
ln -s /etc/nginx/sites-available/panel.conf /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
#Configure permissions
echo "Configuring permissions..."
file=$(mktemp)
cp /etc/sudoers $file
echo "www-data ALL=(ALL:ALL) NOPASSWD:/var/www/control-panel/assets/wrapper.sh" >> $file
#Only apply changes if the file is not broken
if visudo -c -f $file
then
        cp $file /etc/sudoers
else
        echo "CRITICAL ERROR: new sudoers file corrupt, exiting now!"
        exit 3
fi
rm $file
chmod +x /var/www/control-panel/assets/backend.sh
chmod +x /var/www/control-panel/assets/wrapper.sh
#Set correct login shell
sudo chsh www-data -s /bin/bash
#Restart NGINX
service nginx restart
#Tell user to complete install
echo "Please go to panel.${domain}/install.php to complete the install."
