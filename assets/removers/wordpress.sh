domain="$1"
dir="/var/www/wp-$domain"
echo "Removing the WordPress install for $domain"
echo "Please DO NOT leave this page or refresh untill the process is complete!"
echo "Removing files"
rm -rvf $dir
rm /etc/nginx/sites-available/wp-$domain.conf
rm /etc/nginx/sites-enabled/wp-$domain.conf
echo "Removing DB"
safedomain=$(echo $domain | sed "s/\./_/g")
mysql --execute "DROP DATABASE wp_$safedomain"
echo "Done!"
echo "<h3> Please Restart NGINX </h3>"
