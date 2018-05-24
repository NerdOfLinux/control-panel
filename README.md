# Control Panel
A simple control panel designed for WordPress VPS hosters.

##  Why not [insert control panel name here]?
This control panel is **NOT** meant to replace all other control panels, but is desgined to work as a simple one that allows users to install Wordpress **and** manage their servers. 

I could not find a control panel that had both installers *and* a way to see if a VPS requires updates, or a restart to install those updates. 

# Installation
Please check [the wiki](https://github.com/NerdOfLinux/control-panel/wiki/Install)

# Notes
## This is NOT ready for use
Please do **NOT** use this yet. It won't help you with anything, and adds a huge security hole if someone bypasses the login.

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
Please see [the wiki](https://github.com/NerdOfLinux/control-panel/wiki/WordPress)

## More coming soon...
Let me know what other installers you want, and I'll work on making them.

## Create your own installer
To create your own installer(and submit a pull request, please), simple create an installation shell script in the `assets/installers` folder. In the script, the first and only argument will be the domain name the user would like to install to. 

