#!/bin/bash
#DO NOT RUN MANUALLY!!!!
#This bash script is for use by the Control Panel only
if [ ! -d /tmp/panel ]
then
	mkdir /tmp/panel
fi

if [ $1 = "update" ]
then
	if ! ps -aux | grep "apt-get update" | grep -v "grep" >/dev/null
	then
		apt-get update > /tmp/panel/update.out
		echo " Available updates: " >> /tmp/panel/update.out
		apt list --upgradeable >> /tmp/panel/update.out
	fi
fi

if [ $1 = "upgrade" ]
then
     if ! ps -aux | grep "apt-get upgrade" | grep -v "grep" >/dev/null
     then
          apt-get upgrade > /tmp/panel/upgrade.out
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
	$2 > /tmp/panel/custom.out &
	echo "$!" > /tmp/panel/custom.pid
fi
