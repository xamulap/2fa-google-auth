<?php 
defined('_EXEC') or die;
?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">2FA Users</h1>
      </div>

      <div class='main'>

	<table class='table'>
		<tr>
			<th><a href="?task=adduser"><i class="bi bi-plus-circle"></i></a>
			<th>Username
			<th>Phone
			<th>Email
			<th>Created
			<th>Updated
			<th>Status
			<th>Activation
		</tr>
	<?php
	$is_preparing = 0;

	$id = intval($_REQUEST['id']);
	$action = $_REQUEST['action'];
	$type = $_REQUEST['type'];
	if($id && $action) { 
		if($action == 'generate') {  //from state 1 to 2
			$sql="update users set updated=now(),status=2 where id=?";

		}
		if($action == 'sendqr') { //from state 3 to 4
			if($type=='sms') 	
				sendcode($id,'sms');
			else 
				sendcode($id);			 
			$sql="update users set updated=now(),status=4 where id=?";
                }


		$prep = $conn->prepare($sql);
		$prep->bind_param("i",$id);
		$prep->execute();

	}
	///////////////////////
	
	$sql = "select * from users where status>-1";
	$result = $conn->query($sql);

	while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo '<td>
			<a href="?task=edituser&id='.$row['id'].'"><i class="bi bi-pencil-square"></i></a>
			&nbsp;
			<a href="?task=deleteuser&id='.$row['id'].'"><i class="bi bi-trash"></i></a>
		';
		echo "<td >".$row['username'];
		echo "<td>".$row['phone'];
		echo "<td>".$row['email'];
		echo "<td>".$row['created'];
		echo "<td>".$row['updated'];
		echo "<td>".userstatus($row['status']);
		echo "<td>";
		if($row['status']=='1') { 
			echo "<a href='?task=listuser&action=generate&id=".$row['id']."'><i class='bi bi-arrow-right-square'></i></a>";
		}
		if($row['status']=='2') {
			$is_preparing = 1;
			echo "<a href='?task=listuser'><i class='bi bi-hourglass'></i>";	
		}
		if($row['status']=='3') { 
			echo "<a href='?task=showqr&id=".$row['id']."'><i class='bi bi-qr-code'></i></a>";
			if($row['email']) 
	                        echo "&nbsp;&nbsp;<a href='?task=listuser&action=sendqr&id=".$row['id']."'><i class='bi bi-envelope'></i></a>";
			if($row['phone'])
                                echo "&nbsp;&nbsp;<a href='?task=listuser&action=sendqr&id=".$row['id']."&type=sms'><i class='bi bi-phone'></i></a>";
                }
		if($row['status']=='4') {
                        echo "<a href='?task=listuser&action=generate&id=".$row['id']."'><i class='bi bi-arrow-clockwise'></i>";
                }	
		echo "</tr>";
	}

	if($is_preparing) { 
	?>
	<script>
		setTimeout(function(){
	           console.log('refresh');
		   window.location = '/2fa';
		}, 10000);

	</script>

	<?php } ?>


      </div>


