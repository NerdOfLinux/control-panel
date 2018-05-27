<?php
session_start();
$what=$_GET['what'];
$webroot=$_SERVER['DOCUMENT_ROOT'];
//Include the file based on argument, so everything can be done with just this file
include("$webroot/assets/locked.php");
$text=file_get_contents("/tmp/panel/$what/wordpress.out");

echo '<div id="content">';
echo $text;
echo '</div>';
?>
