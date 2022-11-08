<?php
$lock = "/tmp/2faworker";
$config = parse_ini_file("/etc/2fa.conf");


function logger($msg) {
        file_put_contents('/tmp/2falogs.txt', $msg.PHP_EOL , FILE_APPEND | LOCK_EX);
}

logger("2fa start ".date("Y-m-d H:i:s"));

if(file_exists($lock)) { 
	logger("locked");
	die('locked');
}


//create lock , not to run twice
file_put_contents($lock,date("Y-m-d H:i:s"));

//connect to mysql
$conn = new mysqli($config['mysql_host'],$config['mysql_user'],$config['mysql_pass'],$config['mysql_db']);

$sql="select * from users where status=2 or status=0";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()) { 

	$username=$row['username'];
	$folder = "/etc/freeradius/users/".$username;
        $file = $folder."/.google_authenticator";

	if($row['status']==2) { 

		//sanitize
		$username = preg_replace('/[^A-Za-z0-9-_.]/', '', $username);

		logger("creating token for user ".$username);

		if(!file_exists($folder)) { 
			$cmd="mkdir ".$folder;
			shell_exec($cmd);	
		}
		$cmd="/usr/bin/google-authenticator -f -t -D -W -u -q -s ".$file;
		$r=shell_exec($cmd);
		$cmd="chmod 600 ".$file;

		shell_exec($cmd);
		$cmd="chown -R freerad:freerad ".$folder;
		shell_exec($cmd);


		$token = file($file);
		$token = trim($token[0]);

		$sql="update users set token='".$token."',status=3,updated=now() where id='".$row['id']."'";
		$r = $conn->query($sql);

	}
	if($row['status']==0) { 
		logger("deleting ".$username);
		$ru = unlink($file);
		if($ru) { 		
			logger("del success");
			$sql="delete from users where id='".$row['id']."'";
			$r = $conn->query($sql);	
		}
	}
}

///remove lock

unlink($lock);

logger("done");



