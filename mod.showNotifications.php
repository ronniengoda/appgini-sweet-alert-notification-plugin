<?php
function showNotifications($msg = '', $class = '', $fadeout = true) {
		global $Translation;
		if($error_message = strip_tags($_REQUEST['error_message']))
			$error_message = '<div class="text-bold">' . $error_message . '</div>';

		if(!$msg) { // if no msg, use url to detect message to display
			if($_REQUEST['record-added-ok'] != '') {
				$msg=$_SESSION['custom_err_msg'];
				$msg = ($msg=='') ? $Translation['new record saved'] : $msg ;
				unset($_SESSION['custom_err_msg']);
				$class = 'success';
			} elseif($_REQUEST['record-added-error'] != '') {
				$msg=$_SESSION['custom_err_msg'];
				$msg = ($msg=='') ? $Translation['Couldn\'t save the new record'] : $msg ;
				unset($_SESSION['custom_err_msg']);
				$class = 'error';
			} elseif($_REQUEST['record-updated-ok'] != '') {
				$msg=$_SESSION['custom_err_msg'];
				$msg = ($msg=='') ? $Translation['record updated'] : $msg ;
				unset($_SESSION['custom_err_msg']);
				$class = 'success';
			} elseif($_REQUEST['record-updated-error'] != '') {
				$msg=$_SESSION['custom_err_msg'];
				$msg = ($msg=='') ? $Translation['Couldn\'t save changes to the record'] : $msg ;
				unset($_SESSION['custom_err_msg']);
				$class = 'error';
			} elseif($_REQUEST['record-deleted-ok'] != '') {
				$msg=$_SESSION['custom_err_msg'];
				$msg = ($msg=='') ? $Translation['The record has been deleted successfully'] : $msg ;
				unset($_SESSION['custom_err_msg']);
				$class = 'success';
			} elseif($_REQUEST['record-deleted-error'] != '') {
				$msg=$_SESSION['custom_err_msg'];
				$msg = ($msg=='') ? $Translation['Couldn\'t delete this record'] : $msg ;
				unset($_SESSION['custom_err_msg']);
				$class = 'error';
			} else {
				return '';
			}
		}
		$id = 'notification-' . rand();

		ob_start();
		// notification template
		?>

		<script type="text/javascript">swal("<?php echo $alerttitle = ($class=="success") ? "Congrats!" : "Oops!" ; ?>", "<?php echo $msg ?>", "<?php echo $class ?>");</script>

		<?php
		$out = ob_get_clean();

		return $out;
	}