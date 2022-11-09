#####sshd

check=`cat /etc/ssh/sshd_config | grep -v "#" |  grep ChallengeResponseAuthentication`
if [ "$check" != "" ] && [ "$check" == "ChallengeResponseAuthentication yes" ]; then
        echo "sshd already updated"
else
	sed -i 's/ChallengeResponseAuthentication.*/ChallengeResponseAuthentication yes/' /etc/ssh/sshd_config
fi


