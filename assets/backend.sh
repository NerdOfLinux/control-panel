#!/bin/bash
#DO NOT RUN MANUALLY!!!!
#This bash script is for use by the Control Panel only
if [ ! -d /tmp/panel ]
then
	mkdir /tmp/panel
fi
if [ ! -d /tmp/panel/install ]
then
	mkdir /tmp/panel/install
fi

if [ $1 = "update" ]
then
	if ! lsof | grep /tmp/panel/update.out > /dev/null
	then
		apt-get update > /tmp/panel/update.out
		echo "<h3> Available updates: </h3>" >> /tmp/panel/update.out 2>&1
		apt list --upgradeable >> /tmp/panel/update.out
	fi
fi

if [ $1 = "upgrade" ]
then
	if ! lsof | grep /tmp/panel/upgrade.out > /dev/null
     then
          apt-get -y upgrade > /tmp/panel/upgrade.out 2>&1
     fi
fi
if [ $1 = "reboot" ]
then
	echo "yes" > /tmp/panel/reboot.out
fi
if [ $1 = "custom" ]
then
	kill $(cat /tmp/panel/custom.pid)
	echo "" > /tmp/panel/custom.out
	$2 > /tmp/panel/custom.out 2>&1 &
	echo "$!" > /tmp/panel/custom.pid
fi
if [ $1 = "write" ]
then
	if [ ! -f "$3" ]
	then
		touch "$3"
		chmod 604 "$3"
	fi
	cp "$2" "$3" 2>&1
fi
if [ $1 = "install" ]
then
	bash $env/installers/$2.sh ${@:3} >/tmp/panel/install/$2.out 2>&1
fi
if [ $1 = "restartnginx" ]
then
	if nginx -t > /tmp/panel/restartnginx.out 2>&1
	then
		echo "Restarting NGINX..." >> /tmp/panel/restartnginx.out
		if service nginx restart >> /tmp/panel/restartnginx.out 2>&1
		then
			echo "NGINX Restarted" >> /tmp/panel/restartnginx.out
		fi
	fi
fi
if [ $1 = "nginx" ]
then
	echo "$@" > /tmp/test.out
	if [ $2 = "activate" ]
	then
		ln -s $3 /etc/nginx/sites-enabled/
	elif [ $2 = "deactivate" ]
	then
		echo "deleting $3" >> /tmp/test.out
		rm $3 >/tmp/test.out 2>&1
	fi
fi
