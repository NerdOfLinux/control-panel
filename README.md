# Control Panel
A simple control panel designed for WordPress VPS hosters.

##  Why not [insert control panel name here]?
This control panel is **NOT** meant to replace all other control panels, but is desgined to work as a simple one that allows users to install Wordpress **and** manage their servers. 

I could not find a control panel that had both installers *and* a way to see if a VPS requires updates, or a restart to install those updates. 

# Installation
This is still a work in progress and currently does nothing, but, if you want to give some feedback, here's how to install it:


## Clone the repo
```shell
cd /var/www/
git clone https://github.com/NerdOfLinux/control-panel.git
```

## Configure NGINX
This currently only supports the NGINX web server. Here's a sample config:

```nginx
server {
        listen *:80;

        index index.php;
        root /var/www/control-panel;
        server_name panel.example.com;
        include /var/www/control-panel/nginx.conf;
        location /{
                try_files $uri $uri/ index.php;
        }

        location ~ \.php$ {
               fastcgi_index index.php;
               try_files $uri =404;
               fastcgi_pass unix:/run/php/php7.0-fpm.sock;
               include /etc/nginx/fastcgi.conf;
        }
         location ~ /\.ht {
                deny all;
        }

}
```

## Run the installer
After the above steps, simply go to panel.example.com/install.php, and enter an email, username, and password. There is **no** email verification(you're the only person who's going to be using it), so be sure the email is correct. After the installtion is complete, there will be a file called `.ht.users.json` which contains your login info, which will lock the installer. You can now go to panel.example.com/panel/index.php. Be sure to put `index.php` at the end, otherwise you'll get a 403 error(this is for security reasons).

## visudo time!
With a `sudo` user, run

```shell
sudo visudo
```

and at the bottom add:

```visudo
www-data ALL=(ALL:ALL) NOPASSWD:/var/www/control-panel/assets/backend.sh
```

then exit and save. Be sure the script is executable with:

```shell
sudo chmod +x /var/www/control-panel/assets/backend.sh
```

# Notes
## This is NOT ready for use
Please do **NOT** use this yet. It won't help you with anything, and adds a huge security hole if someone bypasses the login.

## How to help
Install this on a [VPS](https://m.do.co/c/f941d4888bfb), and look for problems, and open an issue. Alternatively, you can fork this repository, update it, and then submit a pull request.
