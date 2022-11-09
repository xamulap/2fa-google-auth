#####final

FILE=/etc/2fa.conf

if [ -f "$FILE" ]; then
        echo "Config exists - not creating db etc..."

else
        ####generate password for mysql
        pwd=`tr -dc A-Za-z0-9 </dev/urandom | head -c 13 ; echo ''`
        cp /etc/2fa.default.conf /etc/2fa.conf
        sed -i "s/radpass/$pwd/" /etc/2fa.conf


        chgrp www-data /etc/2fa.conf
        chmod 640 /etc/2fa.conf


	###update radius pass

	sed -i "s/radpass/$pwd/" /etc/freeradius/3.0/mods-enabled/sql

	###create db for fardius

	mysql -e "CREATE DATABASE radius;"
	mysql -e "DROP USER 'radius'@'localhost';"
        mysql -e "CREATE USER 'radius'@'localhost' IDENTIFIED BY '$pwd';"
	mysql -e "GRANT ALL ON radius.* TO radius@localhost IDENTIFIED BY '$pwd';"
	mysql -e "FLUSH PRIVILEGES;"

	mysql radius < /etc/freeradius/3.0/mods-config/sql/main/mysql/schema.sql

	###create db for 2fa gui	

	mysql radius < /opt/2fa/misc/users.sql
	mysql radius < /opt/2fa/misc/admin.sql

fi

#reload services
systemctl restart sssd
systemctl restart freeradius
systemctl restart sshd

##reinstall cleanup

rm /tmp/2faworker

chown freerad /etc/2fa.conf
exit 0
