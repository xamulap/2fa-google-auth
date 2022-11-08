<?php 
defined('_EXEC') or die;
?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">User Edit</h1>
      </div>

      <div class='main'>
	<?php
	$id = intval($_REQUEST['id']);


	$sql = "select * from users where id=? and status=3 and token!=''";
	$prep = $conn->prepare($sql);	
	$prep->bind_param("i",$id);
	$prep->execute();
	$result = $prep->get_result(); 	
	$row = $result->fetch_assoc();
	if($row) { 


		$gen = "otpauth://totp/".$row['username']."?secret=".$row['token']."&issuer=".$config['domain'];
		$cmd = "qrencode -o- -d 300 -s 10 \"".$gen."\"";
		$ret = shell_exec($cmd);

		$sql="update users set status=4,updated=now(),token='' where id='".$row['id']."'";
		$conn->query($sql);

		?>

		  <div class="mb-3 mt-3">
		    <label for="name" class="form-label">Username: </label>
		    <?php echo $row['username']; ?>
		  </div>
		  <div class="mb-3">
		    <label for="phone" class="form-label">Phone:</label>
		    <?php echo $row['phone']; ?>
		  </div>
		  <div class="mb-3">
		    <label for="email" class="form-label">Email:</label>
		    <?php echo $row['email']; ?>
		  </div>

		  <div class="mb-3 mt-3">
		  
			<img src="data:image/png;base64,<?php echo base64_encode($ret); ?>">
		  </div>
		
		<span style='color:red'>This Token is visible only while this window is opened.</span>	
	<?php
	} else { 
		echo "Token already shared";
	}
	?>


      </div>


