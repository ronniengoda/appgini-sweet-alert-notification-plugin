<?php // Save this file as 'hooks/replace-appgini-functions.php'

define("PREPEND_PATH", "../");
$hooks_dir = dirname(__FILE__);
include("../defaultLang.php");
include("../language.php");
include("../lib.php");
include("../header.php");

	// Step 1: Specify the file containing the function we want to overwrite
$appgini_file = "{$hooks_dir}/../incCommon.php";

	// Step 2: Specify the file containing our version of the function
$mod_file = "{$hooks_dir}/mod.showNotifications.php";

	// Step 3: Specify the name of the function we want to overwrite
$func_name = 'showNotifications';

//RESPOND TO USER
$overwriteresponse=replace_function($appgini_file, $func_name, $mod_file);
if($overwriteresponse!=='Function overwritten successfully.'){
	echo "<div class='alert alert-danger'><b>{$func_name}: " .$overwriteresponse."<b></div>";
}
else{
	echo "<div class='alert alert-success'><b>{$func_name}: " .$overwriteresponse."<b></div>";
}


	#######################################

function replace_function($appgini_file, $function_name, $mod_file) {
		// read the new code from the mod file
	$new_code = @file($mod_file);
	if(empty($new_code)) return 'No custom code found.';

		// remove the first line containing PHP opening tag and keep the rest as $new_snippet
	array_shift($new_code);
	$new_snippet = implode('', $new_code);

	$pattern1 = '/\s*function\s+' . $function_name . '\s*\(.*\).*(\R.*){200}/';
	$pattern2 = '/\t#+(.*\R)*/';

	$entire_code = file_get_contents($appgini_file);
	if(!$entire_code) return 'Invalid AppGini file.';

	$m = [];
	if(!preg_match_all($pattern1, $entire_code, $m)) return 'Function to replace not found.';
	$snippet = $m[0][0] . "\n";

	if(!preg_match_all($pattern2, $snippet, $m)) return 'Could not find the end of the function.';
	$snippet = str_replace($m[0][0], '', $snippet);

	$snippet_nocrlf = str_replace("\r\n", "\n", $snippet);
	$new_snippet_nocrlf = str_replace("\r\n", "\n", $new_snippet);
	if(trim($snippet_nocrlf) == trim($new_snippet_nocrlf)) return 'Function already replaced.';

		// back up the file before overwriting
	if(!@copy($appgini_file,'../logfiles/'.preg_replace('/\.php$/', '.backup.' . date('Y.m.d.H.i.s') .'.php',"incCommon.php")
	)) return 'Could not make a backup copy of file.';

		$new_code = str_replace(trim($snippet), trim($new_snippet), $entire_code);
		if(!@file_put_contents($appgini_file, $new_code)) return "Couldn't overwrite file.";

		return 'Function overwritten successfully.';
	}