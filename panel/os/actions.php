<?php
session_start();
$type=$_GET['type'];
$webroot=$_SERVER['DOCUMENT_ROOT'];
//include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$file=fopen("/tmp/panel/$type.out", "r");
$text = fread($file, filesize("/tmp/panel/$type.out"));
echo '<div id="content">';
echo nl2br($text);
echo '</div>';
?>
