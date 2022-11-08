check=`cat /etc/sssd/sssd.conf | grep -v "#" |  grep "use_fully_qualified_names = True"`
if [ "$check" != "" ] && [ "$check" == "use_fully_qualified_names = True" ]; then
        echo "use_fully_qualified_names already updated"
else
	sed -i 's/use_fully_qualified_names = False.*/use_fully_qualified_names = True/' /etc/sssd/sssd.conf
fi

check=`cat /etc/sssd/sssd.conf | grep -v "#" |  grep "override_homedir"`
if [ "$check" != "" ]; then
        echo "override_homedir already updated"
else
	echo "override_homedir = /home/%u" >> /etc/sssd/sssd.conf
fi

check=`cat /etc/sssd/sssd.conf | grep -v "#" |  grep "override_shell"`
if [ "$check" != "" ]; then
        echo "override_shell already updated"
else
        echo "override_shell = /bin/bash" >> /etc/sssd/sssd.conf
fi


