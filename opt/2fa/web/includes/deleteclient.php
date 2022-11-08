<?php
defined('_EXEC') or die;
?>     
 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Radius Client Delete</h1>
      </div>

      <div class='main'>
	<?php
	$id = intval($_REQUEST['id']);

	if($_REQUEST['action']=='delete') { 
	
		if($id) { 
			$sql="delete from nas  where id=?";
			$prep = $conn->prepare($sql);
			$prep->bind_param("i",$id);
			$prep->execute();
		}	

		if($conn->error)  {
			echo "<h4 style='color: red;'>Error</h4>";
			echo "<pre>".print_r($conn->error)."</pre>";	
		} else { 
			echo "<h4 style='color: red;'>Deleted</h4>";
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
	  Delete client ?
	  <div class="mb-3 mt-3">
	    <label for="ip" class="form-label">IP:</label>
	    <?php echo $row['nasname']; ?>
	  </div>
          <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
	    <?php echo $row['shortname']; ?>
          </div>
	  <input type='hidden' name='task' value='deleteclient'>
	  <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
	  <input type='hidden' name='action' value='delete'>
	  <button type="submit" class="btn btn-warning">Delete</button>
	</form>
		



      </div>


