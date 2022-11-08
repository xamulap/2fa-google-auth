<?php
defined('_EXEC') or die;
?><body>
	<div class="container-fluid ">
	<?php
		include("./includes/menu.php");
	?>	
	  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
		<?php
			switch($_REQUEST['task']) { 
				case 'logout' : $_SESSION['admin']=false;break;
				case 'logs' : include('./includes/logs.php');break;
				case 'settings' : include('./includes/settings.php');break;

				case 'listclient': include('./includes/listclient.php');break;
				case 'addclient' : include('./includes/editclient.php');break;
				case 'editclient': include('./includes/editclient.php');break;
				case 'deleteclient': include('./includes/deleteclient.php');break;
				
				case 'listuser': include('./includes/listuser.php');break;
                                case 'edituser': include('./includes/edituser.php');break;
				case 'adduser' : include('./includes/edituser.php');break;
                                case 'deleteuser': include('./includes/deleteuser.php');break;

				case 'showqr' : include('./includes/showqr.php');break;
				
				default: include('./includes/listuser.php');
			}
		?>
	    </main>
	  </div>
	</div>
<!--
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
-->
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>



