#!/bin/bash
domain="$1"
dir="/var/www/wp-$domain"
echo "Installing the latest version of WordPress to $domain"
echo "Please DO NOT leave this page or refresh untill the install is complete!"
echo "If the install fails, run the following command in the custom command section: "
echo "rm -rf $dir"
if [ -d "$dir" ]
then
	echo "$dir already exists, please delete it to continue."
	exit
fi
mkdir $dir
echo "Installing required PHP packages:"
apt-get -y install php-mysql php-curl php-imagick php-gd php-mbstring php-mcrypt php-pspell php-zip
echo "Moving to /tmp..."
cd /tmp
mkdir wp-tmp
cd wp-tmp
echo "Getting latest WordPress version..."
curl https://wordpress.org/latest.zip -o wordpress.zip
echo "Extracting into $dir..."
unzip wordpress.zip >/dev/null 2>&1
cp -R wordpress/* $dir
cd $dir
echo "Generating DB..."
password=$(openssl rand -base64 32)
safedomain=$(echo $domain | sed "s/\./_/g")
mysql --execute "CREATE DATABASE wp_$safedomain"
mysqlexec="GRANT ALL PRIVILEGES ON wp_$safedomain.* TO wp_user_$safedomain IDENTIFIED BY '$password';"
mysql --execute "$mysqlexec"
mysql --execute "FLUSH PRIVILEGES;"
echo "Generating wp-config.php..."
cat > wp-config.php <<EOF
<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_$safedomain');
/** MySQL database username */
define('DB_USER', 'wp_user_$safedomain');
/** MySQL database password */
define('DB_PASSWORD', '$password');
/** MySQL hostname */
define('DB_HOST', 'localhost');
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
$(curl https://api.wordpress.org/secret-key/1.1/salt/)
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
\$table_prefix  = '$(openssl rand -hex 8)_';
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
EOF
echo "Generating NGINX config..."
cat > /etc/nginx/sites-available/wp-$domain.conf <<EOF
server{
listen [::]:80;
listen *:80;

location ~ ^/\.user\.ini {
        deny all;
}

        index index.php;
        root $dir;
	   server_name $domain;

        location / {
               try_files \$uri \$uri/ /index.php?\$args;
        }
        include snippets/php;
        location ~ ^/\.user {
                deny all;
        }
        location ~ /\.ht {
                deny all;
        }
         location ~ /\. { 
                deny all; 
                return 404; 
         }
	include snippets/ssl;
}
EOF
echo "Enabling config..."
ln -s /etc/nginx/sites-available/wp-$domain.conf /etc/nginx/sites-enabled/
echo "Setting permissions, please be patient..."
chown -R www-data:www-data $dir
echo "Restarting NGINX..."
if nginx -t
then
	service nginx restart
	echo "Go to $domain to complete the install!"
else
	echo "NGINX config error, not restarting..."
fi
