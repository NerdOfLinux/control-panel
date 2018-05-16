# Control Panel
A simple control panel designed for WordPress VPS hosters.

##  Why not [insert control panel name here]?
This control panel is **NOT** meant to replace all other control panels, but is desgined to work as a simple one that allows users to install Wordpress **and** manage their servers. 

I could not find a control panel that had both installers *and* a way to see if a VPS requires updates, or a restart to install those updates. 

# Installation
This is still a work in progress and currently does nothing, but, if you want to give some feedback, here's how to install it:

## Install required thingies:
```shell
sudo apt install git nginx mariadb-client-10.0 mariadb-server-10.0 php7.0-fpm php-json
```

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

	   include snippets/php;
         location ~ /\.ht {
                deny all;
        }
       include snippets/ssl;
}
```

### Keep the includes
It's written with `include snippets/php` and `include snippets/ssl` on purpose, the installers rely on that. 
Put the following in `/etc/nginx/snippets/php`:
```nginx
location ~ \.php$ {
        fastcgi_index index.php;
        try_files $uri =404;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        include /etc/nginx/fastcgi.conf;
}
```
and just create(i.e. `touch` command) `/etc/nginx/snippets/ssl`. Or, put your SSL config there.

## Run the installer
After the above steps, simply go to panel.example.com/install.php, and enter a username and password. After the installtion is complete, there will be a file called .ht.users.json which contains your login info, which will lock the installer. You can now go to panel.example.com/panel/index.php and log in.

## visudo time!
With a `sudo` user, run

```shell
sudo visudo
```

and at the bottom add:

```visudo
www-data ALL=(ALL:ALL) NOPASSWD:/var/www/control-panel/assets/wrapper.sh
```

then exit and save. Be sure the script is executable with:

```shell
sudo chmod +x /var/www/control-panel/assets/backend.sh
sudo chmod +x /var/www/control-panel/assets/wrapper.sh
```

# Notes
## This is NOT ready for use
Please do **NOT** use this yet. It won't help you with anything, and adds a huge security hole if someone bypasses the login.

## What does work:
* Installer
* Updating
* Upgrading

## The reboot command doesn't work
The reboot command will work just fine if you edit the backend.sh file. The reason I didn't implement this yet is because I'm currently trying to see how long I can go without a reboot :-) .

## How to help
Install this on a [VPS](https://m.do.co/c/f941d4888bfb), look for problems, and open an issue. Alternatively, you can fork this repository, update it, and then submit a pull request.

## Supported distros
This is currently only tested on Ubuntu 16.04, but should work on other Ubuntu versions, debian, and even operating systems based off Ubuntu or Debian. If you'd like support for antoher operating system, please let me know by filing an issue.

## Images
All images,unless otherwise stated, are **NOT** made by me. Unless otherwise stated, they are all under licenses allowing commercial use with no attribution. Also, unless otherwise stated, the images are not a part of this panel and do NOT fall under the GPL license.

# Installers
## WordPress
This is currently the only installer. It asks you for the domain name, and does 99% of the work for you. It creates the database, and all you need to do is set up your site's name and your user. It uses many security features such as:
* Using random salts
* Custom database prefix
* Long database password 
all with the click of a button! 

## More coming soon...
Let me know what other installers you want, and I'll work on making them.

## Create your own installer
To create your own installer(and submit a pull request, please), simple create an installation shell script in the `assets/installers` folder. In the script, the first and only argument will be the domain name the user would like to install to. 

