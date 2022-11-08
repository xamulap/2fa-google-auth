<?php
defined('_EXEC') or die;
?> 
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Settings</h1>
      </div>

      <div class='main'>
	<?php
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$password = password_hash($password,PASSWORD_BCRYPT);

	$id = 1;

	if($_REQUEST['action']=='save') { 
	
		if($id) { 
			$sql="update admin set password=? where id=?";
			$prep = $conn->prepare($sql);
			$prep->bind_param("si",$password,$id);
			$prep->execute();
		}	

		if($conn->error)  {
			echo "<h4 style='color: red;'>Error</h4>";
			echo "<pre>".print_r($conn->error)."</pre>";	
		} else { 
			echo "<h4 style='color: red;'>Saved</h4>";
		}	
	}

	$sql = "select * from admin where id=?";
	$prep = $conn->prepare($sql);	
	$prep->bind_param("i",$id);
	$prep->execute();
	$result = $prep->get_result(); 	
	$row = $result->fetch_assoc();



	?>

	<form action="">
	  <div class="mb-3">
	    <label for="phone" class="form-label">Password</label>
	    <input type="password" class="form-control" id="phone" placeholder="" name="password" value="">
	  </div>
	  <input type='hidden' name='task' value='settings'>
	  <input type='hidden' name='action' value='save'>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
		



      </div>


