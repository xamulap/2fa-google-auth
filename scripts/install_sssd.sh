#####sssd

check=`cat /etc/sssd/sssd.conf | grep -v "#" |  grep "use_fully_qualified_names = False"`
if [ "$check" != "" ] && [ "$check" == "use_fully_qualified_names = False" ]; then
        echo "use_fully_qualified_names already updated"
else
	sed -i 's/use_fully_qualified_names = True.*/use_fully_qualified_names = False/' /etc/sssd/sssd.conf
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

#access_provider = ad
#this is enabled by default when domain is joined
check=`cat /etc/sssd/sssd.conf | grep "#access_provider = ad"`

if [ "$check" != "" ] && [ "$check" == "#access_provider = ad" ]; then
        echo "access_provider already updated"
else
	sed -i 's/access_provider = ad/#access_provider = ad/' /etc/sssd/sssd.conf	
fi

