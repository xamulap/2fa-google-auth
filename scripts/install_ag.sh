#####
# install script 2faotp
#####


#chmod -R 640 /var/www/html
#chmod 750 /var/www/html/
#chmod 750 /var/www/html/includes

##toto som musel rucne
chgrp -R www-data /opt/2fa/web

#let logs be readable for apache
chgrp www-data /var/log/auth.log #todo - check if not rewritern on logrotate

touch /tmp/2falogs.txt
chown freerad /tmp/2falogs.txt


