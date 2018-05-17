<?php
session_start();
$type=$_GET['type'];
$webroot=$_SERVER['DOCUMENT_ROOT'];
//Include the file based on argument, so everythin can be done with just this file
include("$webroot/assets/locked.php");
$file=fopen("/tmp/panel/$type.out", "r");
$text = fread($file, filesize("/tmp/panel/$type.out"));
echo '<div id="content">';
echo nl2br($text);
echo '</div>';
?>
