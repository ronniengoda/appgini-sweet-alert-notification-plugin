<?php 
/**
 * include important things first
 */
define("PREPEND_PATH", "../../");
$hooks_dir = dirname(__FILE__);
include("../../defaultLang.php");
include("../../language.php");
include("../../lib.php");
include_once("../../header.php");
include '../../config.php';
?>
<?php 
$info=getMemberInfo();
$group=$info['group'];
if ($group!=="Admins") {
    # code...
    echo error_message("Access denied please login as admin to continue.");exit;
}
$file_pointer='../../hooks/replace-appgini-functions.php';
if (file_exists($file_pointer)) {
	?>
<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Appgini Sweet Alert Manager</strong></div>
			<div class="panel-body">
				<div class="btn-group btn-group-justified">
					<a href="../../hooks/insertswal.php" class="btn btn-warning">Insert SWAL Script In Header</a>
					<a href="../../hooks/replace-appgini-functions.php" class="btn btn-primary">Replace Show Notification Function</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else{?>
<div>
	<form method="POST" action="">
	<button type="submit" name="install" class="btn btn-success">Install SWAL</button>
	</form>
</div>
<?php } ?>
<?php if (isset($_POST['install'])) {
	# code...
	copy("insertswal.php", "../../hooks/insertswal.php");
	copy("replace-appgini-functions.php", "../../hooks/replace-appgini-functions.php");
	copy("mod.showNotifications.php", "../../hooks/mod.showNotifications.php");

	echo '<div class="alert alert-success"><b>SWAL successfully installed. You can now perform neccessary actions.</b></div>';
	echo "<meta http-equiv='refresh' content='3'>";
} ?>