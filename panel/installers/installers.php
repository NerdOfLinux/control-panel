<?php
session_start();
$type=$_GET['app'];
$webroot=$_SERVER['DOCUMENT_ROOT'];
//Include the file based on argument, so everything can be done with just this file
include("$webroot/assets/locked.php");
$file=fopen("/tmp/panel/install/$type.out", "r");
$text = fread($file, filesize("/tmp/panel/install/$type.out"));
echo '<div id="content">';
echo nl2br($text);
echo '</div>';
?>
