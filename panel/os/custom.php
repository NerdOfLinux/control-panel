<?php
session_start();
$webroot=$_SERVER['DOCUMENT_ROOT'];
//include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$file=fopen("/tmp/panel/custom.out", "r");
$text = fread($file, filesize("/tmp/panel/custom.out"));
echo '<div id="content">';
echo nl2br($text);
echo '</div>';
?>
