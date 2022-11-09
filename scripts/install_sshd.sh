#####sshd

check=`cat /etc/ssh/sshd_config | grep -v "#" |  grep ChallengeResponseAuthentication`
if [ "$check" != "" ] && [ "$check" == "ChallengeResponseAuthentication yes" ]; then
        echo "sshd already updated"
else
	sed -i 's/ChallengeResponseAuthentication.*/ChallengeResponseAuthentication yes/' /etc/ssh/sshd_config
fi

###pamd

check=`cat /etc/pam.d/sshd | grep -v "#" | grep pam_google_authenticator.so`
if [ "$check" != "" ]; then
	echo "pam ssh already updated"
else
	sed -i "5i\auth required pam_google_authenticator.so nullok secret=/etc/freeradius/users/\${USER}/.google_authenticator user=freerad debug" /etc/pam.d/sshd
	
fi
