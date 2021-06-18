<?php 
define("PREPEND_PATH", "../");
$hooks_dir = dirname(__FILE__);
include("../defaultLang.php");
include("../language.php");
include("../lib.php");
include("../header.php");

$file = "../header.php";
$targetline=getTargetLine($file);//target line in header.php to put extra js code
$content = file($file); //Read the file into an array. Line number => line content
foreach($content as $lineNumber => &$lineContent) { //Loop through the array (the "lines")
    if($lineNumber == $targetline) { //Remember we start at line 0.
    	$lineContent .= '<!--CODE INSERTED FOR SWEET ALERT-->
    	<script type="text/javascript" src="plugins/swal/sweetalert-dev.js"></script>
		<link rel="stylesheet" type="text/css" href="plugins/swal/sweetalert.css"><!--CODE INSERTED FOR SWEET ALERT-->' . PHP_EOL; //Modify the line. (We're adding another line by using PHP_EOL)
	}

}

$allContent = implode("", $content); //Put the array back into one string
if (checkIfCodeIsInserted($file)==TRUE) {
	# code...
	echo "<div class='alert alert-danger'><b>CODE ALREADY INSERTED IN HEADER.PHP<b></div>";exit;

}
file_put_contents($file, $allContent); //Overwrite the file with the new content
function getTargetLine($file){
	$content = file($file);
	foreach ($content as $line_num => $line) {
		$lineContent=htmlspecialchars($line);
		if (preg_match("/\/head\b/", $lineContent)){
			$targetline=$line_num-1;
			return  $targetline;
		}
	}
}
function checkIfCodeIsInserted($file){
	$content = file($file);
	foreach ($content as $line_num => $line) {
		$lineContent=htmlspecialchars($line);
		if (preg_match("/\CODE INSERTED FOR SWEET ALERT\b/", $lineContent)){
			return TRUE;
		}
	}
}
echo "<div class='alert alert-success'><b>CODE INSERTED IN HEADER.PHP SUCCESSFULLY!!!<b></div>";
