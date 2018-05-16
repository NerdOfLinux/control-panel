<?php
session_start();
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
//Condense all CSS
$contents=file_get_contents("$webroot/assets/style.css");
echo preg_replace("*\s*", "", $contents);
?>
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>
