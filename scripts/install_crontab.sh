check=`crontab -l -u freerad | grep 2fa | awk '{ print $8 }' | head -1`
if [ "$check" != "" ] && [ "$check" == "/opt/2fa/bin/2faworker.php" ]; then
        echo "crontab already updated"
else
        crontab -l -u freerad > mycron
	cat /opt/2fa/misc/crontab >> mycron
        crontab -u freerad mycron
        rm mycron
fi

