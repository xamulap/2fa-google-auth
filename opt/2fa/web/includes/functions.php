<?php
defined('_EXEC') or die;

function userstatus($status) { 

	switch($status) {
		case '0': $msg = "<span style='color: gray;'>Deleting</span>";break;
		case '1': $msg = "<span style='color: red;'>Not active</span>";break;
		case '2': $msg = "<span style='color: orange;'>Preparing</span>";break;
		case '3': $msg = "<span style='color: purple;'>Ready to activate</span>";break;
		case '4': $msg = "<span style='color: green;'>Active</span>";break;
	}

	return $msg;

}

function sendcode($id,$type = 'email') { 
	global $conn,$config;
	
	$id = intval($id);

        $sql = "select * from users where id=? and status=3 and token!=''";
        $prep = $conn->prepare($sql);
        $prep->bind_param("i",$id);
        $prep->execute();
        $result = $prep->get_result();
        $row = $result->fetch_assoc();
        if($row) {

                $gen = "otpauth://totp/".$row['username']."?secret=".$row['token']."&issuer=".$config['domain'];

		if($type == 'email') { 

			//Email example
			$headers  = "From: " . strip_tags("admin@".$config['domain']) . "\r\n";
			$headers .= "Reply-To: " . strip_tags("admin@".$config['domain']) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			$gen = "
			<a href='".$gen."'>Activation 2FA OTP</a>
			";	
			mail($row['email'],"2FA OTP Activation",$gen,$headers);

		}

		if($type == 'sms' && $row['phone']) { 

			//SMS example

			$cmd = 'curl --header "Content-Type: application/json; charset=utf-8" --header "Authorization: '.$config['smsgw_key'].'"  --data \'{"to":"'.$row['phone'].'","message":"'.$gen.'}\' '.$config['smsgw_url'];

			//for debug, keep commented in production
			error_log($cmd);

			shell_exec($cmd);


		}

	}	

}
