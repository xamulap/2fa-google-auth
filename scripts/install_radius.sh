######### radius

mkdir /etc/freeradius/users
chown freerad:freerad /etc/freeradius/users
ln -s /etc/freeradius/3.0/mods-available/pam /etc/freeradius/3.0/mods-enabled/pam

check=`cat /etc/freeradius/3.0/sites-enabled/default | grep "#" | grep "pam"`

if [ "$check" != "" ]; then
	sed -i 's/#.pam.*/       pam/' /etc/freeradius/3.0/sites-enabled/default	
else
	echo "pam already updated"

fi


check=`cat /etc/freeradius/3.0/users | grep "PAM"`

if [ "$check" != "" ]; then
	echo "users pam already updated"
else
	echo "DEFAULT Auth-Type := PAM" >> /etc/freeradius/3.0/users
fi

###sql

ln -s /etc/freeradius/3.0/mods-available/sql /etc/freeradius/3.0/mods-enabled/

check=`cat  /etc/freeradius/3.0/mods-enabled/sql | grep -v "#" | grep -e "driver = \"rlm_sql_mysql\""`
if [ "$check" != "" ] && [ "$check" == "driver = \"rlm_sql_mysql\"" ]; then
	echo "freeradius mysql driver already enabled"
else
	sed -i 's/rlm_sql_null/rlm_sql_mysql/' /etc/freeradius/3.0/mods-enabled/sql
fi

check=`cat  /etc/freeradius/3.0/mods-enabled/sql | grep -v "#" | grep -e "dialect = \"mysql\""`
if [ "$check" != "" ] && [ "$check" == "driver = \"rlm_sql_mysql\"" ]; then
        echo "freeradius mysql dialect already enabled"
else
        sed -i 's/dialect = .*/dialect = "mysql"/' /etc/freeradius/3.0/mods-enabled/sql
fi


check=`cat  /etc/freeradius/3.0/mods-enabled/sql | grep -v "#" | grep -e "read_clients = yes" | xargs`
if [ "$check" != "" ] && [ "$check" == "read_clients = yes" ]; then
        echo "freeradius clients already enabled"
else
        sed -i 's/rlm_sql_null/rlm_sql_mysql/' /etc/freeradius/3.0/mods-enabled/sql
fi

#       server = "localhost"
#       port = 3306
#       login = "radius"
#       password = "radpass"

sed -i '/server = \"localhost\"/s/^#//' /etc/freeradius/3.0/mods-enabled/sql
sed -i '/port = \"3306\"/s/^#//' /etc/freeradius/3.0/mods-enabled/sql
sed -i '/login = \"radius\"/s/^#//' /etc/freeradius/3.0/mods-enabled/sql
sed -i '/password = \"radpass\"/s/^#//' /etc/freeradius/3.0/mods-enabled/sql

#tls

check=`cat  /etc/freeradius/3.0/mods-enabled/sql | grep -v "#" | grep /etc/ssl/certs/my_ca.crt | xargs | awk '{ print $3}'`
if [ "$check" != "" ] && [ "$check" == "/etc/ssl/certs/my_ca.crt" ]; then
	line_start=`grep -Fn 'tls {' /etc/freeradius/3.0/mods-enabled/sql |  awk '{print $1}' | cut -d':' -f 1 | head -1`
        line_end=$(($line_start + 15))
        sed -i "$line_start,$line_end{s/^/#/}" /etc/freeradius/3.0/mods-enabled/sql

else
	echo "freeradius tls already disabled"
fi




