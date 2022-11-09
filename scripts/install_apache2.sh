########apache

a2enmod ssl
a2ensite default-ssl
a2enconf 2fa

systemctl restart apache2

