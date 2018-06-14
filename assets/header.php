<?php
session_set_cookie_params("3600");
session_start();
include("$webroot/assets/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="/assets/favicon.png">
<meta name="viewport" content="initial-scale=1.0">
<?php
echo "<title>$title</title>";
?>
<!--
<link rel="stylesheet" href="/assets/style.css">
-->
<style>
<?php
//Disallow caching
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
//Inline CSS to prevent caching
echo file_get_contents("$webroot/assets/style.css");
?>
</style>
<!-- Get jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>
<?php
if(isset($webroot)){
	$safe="true";
}
?>
