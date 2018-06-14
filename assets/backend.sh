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
if [ ! -d /tmp/panel/remove ]
then
	mkdir /tmp/panel/remove
fi
if [ $1 = "upgrade" ]
then
	if ! lsof | grep /tmp/panel/upgrade.out > /dev/null
     then
		printf "<h3> Updating </h3>" >/tmp/panel/upgrade.out
		apt-get update >> /tmp/panel/upgrade.out 2>&1
		printf "<h3> Upgrading </h3>" >>/tmp/panel/upgrade.out
          apt-get -y upgrade >> /tmp/panel/upgrade.out 2>&1
     fi
fi
if [ $1 = "clean" ]
then
     if ! lsof | grep /tmp/panel/clean.out > /dev/null
     then
		printf "<h3>Removing unused packages</h3>" > /tmp/panel/clean.out
          apt-get -y autoremove >> /tmp/panel/clean.out 2>&1
		printf "<h3>Cleaning apt</h3>" >> /tmp/panel/clean.out
		apt-get -y clean >> /tmp/panel/clean.out
		apt-get -y autoclean >> /tmp/panel/clean.out
     fi
fi
if [ $1 = "reboot" ]
then
	shutdown -r now > /tmp/panel/reboot.out
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
if [ $1 = "remove" ]
then
	bash $env/removers/$2.sh ${@:3} >/tmp/panel/remove/$2.out 2>&1
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

if [ $1 = "nginxsnippet" ]
then
	filename=$env/snippets/$3
	if [ $2 = "add" ]
	then
		if [ -f $filename ]
		then
			if sed -i "/server_name*/i include $filename;" /etc/nginx/sites-available/*
			then
				touch $env/snippets/.$3.active
				echo "Activated $filename" > /tmp/panel/easysnippets.out
			fi
		else
			echo "Sorry, $3 not found" > /tmp/panel/easysnippets.out
		fi
	elif [ $2 = "remove" ]
	then
		if sed -i "s,include $filename;,,g" /etc/nginx/sites-available/*
		then
			rm $env/snippets/.$3.active
			echo "Deactivated $filename" > /tmp/panel/easysnippets.out
		fi
	fi
fi

if [ $1 = "panelupdate" ]
then
	if ! lsof | grep /tmp/panel/panelupdate.out > /dev/null
	then
		su - www-data -c "cd $2;git pull origin master" >/tmp/panel/panelupdate.out 2>&1
	fi
fi
if [ $1 = "letsencrypt" ]
then
	if ! lsof | grep /tmp/panel/letsencrypt.out > /dev/null
	then
		>/tmp/panel/letsencrypt.out
		domains=$(echo "-d $2" | sed "s/,/ -d /g")
		dns=$3
		email=$4
		key=$5
		if [ ! -d /var/www/.acme.sh ]
		then
			echo "Getting acme.sh" >/tmp/panel/letsencrypt.out
			su - www-data -c "wget -O -  https://get.acme.sh | sh" >>/tmp/panel/letsencrypt.out
		fi
		upper=$(echo $dns | awk '{print toupper($0)}')
		apt-get -y install python python-pip >> /tmp/panel/letsencrypt.out 2>&1
 		pip install dns-lexicon >> /tmp/panel/letsencrypt.out 2>&1
		su - www-data -c "PATH=$PATH:/var/www/.acme.sh;acme.sh --upgrade;export PROVIDER=$dns;export LEXICON_${upper}_USERNAME=\"$email\";export LEXICON_${upper}_TOKEN=\"$key\";acme.sh --issue $domains --dns dns_lexicon" >>/tmp/panel/letsencrypt.out 2>&1
		certname=$(echo $2 | cut -d "," -f 1)
		cat <<EOF >/etc/nginx/snippets/ssl
listen [::]:443 ssl;
listen *:443 ssl;
ssl_certificate /var/www/.acme.sh/${certname}/${certname}.cer;
ssl_certificate_key /var/www/.acme.sh/${certname}/${certname}.key;
EOF
		echo "Please restart NGINX" >> /tmp/panel/letsencrypt.out
	fi
fi
