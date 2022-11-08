<?php 
defined('_EXEC') or die;
?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Radius Clients</h1>
      </div>

      <div class='main'>

	<table class='table'>
		<tr>
			<th><a href="?task=addclient"><i class="bi bi-plus-circle"></i></a>
			<th>IP
			<th>Name
		</tr>
	<?php

	$sql = "select * from nas";
	$result = $conn->query($sql);

	while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo '<td>
			<a href="?task=editclient&id='.$row['id'].'"><i class="bi bi-pencil-square"></i></a>
			&nbsp;
			<a href="?task=deleteclient&id='.$row['id'].'"><i class="bi bi-trash"></i></a>
		';
		echo "<td>".$row['nasname'];
		echo "<td>".$row['shortname'];
		echo "</tr>";
	}


	?>



      </div>


