<?php 
defined('_EXEC') or die;
?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Auth logs</h1>
      </div>

      <div class='main'>

	<pre><?php
	
	$file = file("/var/log/auth.log");
	$file = array_reverse($file);
	foreach($file as $f){
	    echo $f;
	}

	?>
	</pre>


      </div>


