<?php
defined('_EXEC') or die;
?>     
 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Radius Client Edit</h1>
      </div>

      <div class='main'>
	<?php
	$id = intval($_REQUEST['id']);
	$ip = $_REQUEST['ip'];
	$name = $_REQUEST['name'];
	$secret = $_REQUEST['secret'];

	if($_REQUEST['action']=='save') { 
	
		if($id) { 
			$sql="update nas set nasname=?,shortname=?,secret=? where id=?";
			$prep = $conn->prepare($sql);
			$prep->bind_param("sssi",$ip,$name,$secret,$id);
			$prep->execute();
		} else { 
			//check if exists
			$sql="select * from nas where nasname=?";
			$prep = $conn->prepare($sql);
                        $prep->bind_param("s",$ip);
			$prep->execute();
			$check = $prep->get_result();  
			$check_r = $check->fetch_assoc();
			if($check_r) die("Duplicate IP");

			$sql="insert into nas (type,nasname,shortname,secret) values ('other',?,?,?)";
			$prep = $conn->prepare($sql);
                        $prep->bind_param("sss",$ip,$name,$secret);
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

	$sql = "select * from nas where id=?";
	$prep = $conn->prepare($sql);	
	$prep->bind_param("i",$id);
	$prep->execute();
	$result = $prep->get_result(); 	
	$row = $result->fetch_assoc();



	?>

	<form action="">
	  <div class="mb-3 mt-3">
	    <label for="ip" class="form-label">IP:</label>
	    <input type="ip" class="form-control" id="ip" placeholder="" name="ip" required minlength="7" maxlength="15" size="15" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value="<?php echo $row['nasname']; ?>">
	  </div>
          <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="name" class="form-control" id="name" placeholder="" name="name" required value="<?php echo $row['shortname']; ?>">
          </div>
	  <div class="mb-3">
	    <label for="secret" class="form-label">Secret:</label>
	    <input type="secret" class="form-control" id="secret" placeholder="" name="secret" required>
	  </div>
	  <input type='hidden' name='task' value='editclient'>
	  <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
	  <input type='hidden' name='action' value='save'>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
		



      </div>


