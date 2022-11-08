<?php
defined('_EXEC') or die;
?> 
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">User Edit</h1>
      </div>

      <div class='main'>
	<?php
	$id = intval($_REQUEST['id']);
	$username = $_REQUEST['username'];
	$email = $_REQUEST['email'];
	$phone = $_REQUEST['phone'];

	if($_REQUEST['action']=='save') { 
	
		if($id) { 
			$sql="update users set phone=?,email=? where id=?";
			$prep = $conn->prepare($sql);
			$prep->bind_param("ssi",$phone,$email,$id);
			$prep->execute();
		} else { 
			//check if exists
			$sql="select * from users where username=?";
			$prep = $conn->prepare($sql);
                        $prep->bind_param("s",$ip);
			$prep->execute();
			$check = $prep->get_result();  
			$check_r = $check->fetch_assoc();
			if($check_r) die("Duplicate IP");

			$sql="insert into users (status,created,username,phone,email) values (1,now(),?,?,?)";
			$prep = $conn->prepare($sql);
                        $prep->bind_param("sss",$username,$phone,$email);
                        $ret = $prep->execute();
			$id = $prep->insert_id;
		}	

		if($conn->error)  {
			echo "<h4 style='color: red;'>Error</h4>";
			echo "<pre>".print_r($conn->error)."</pre>";	
		} else { 
			echo "<h4 style='color: red;'>Saved</h4>";
		}	
	}

	$sql = "select * from users where id=? and status>0";
	$prep = $conn->prepare($sql);	
	$prep->bind_param("i",$id);
	$prep->execute();
	$result = $prep->get_result(); 	
	$row = $result->fetch_assoc();



	?>

	<form action="">
          <div class="mb-3 mt-3">
            <label for="name" class="form-label">Username: * (cannot be updated)</label>
            <input type="" class="form-control" id="username" placeholder="" name="username" required value="<?php echo $row['username']; ?>" <?php if($row['id']) echo "readonly"; ?>>
          </div>
	  <div class="mb-3">
	    <label for="phone" class="form-label">Phone:</label>
	    <input type="phone" class="form-control" id="phone" placeholder="" name="phone" value="<?php echo $row['phone']; ?>">
	  </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="" name="email" value="<?php echo $row['email']; ?>" >
          </div>
	  <input type='hidden' name='task' value='edituser'>
	  <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
	  <input type='hidden' name='action' value='save'>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
		



      </div>


