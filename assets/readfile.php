<?php
session_start();
$type=$_GET['type'];
$webroot=$_SERVER['DOCUMENT_ROOT'];
//Include the file based on argument, so everythin can be done with just this file
include("$webroot/assets/locked.php");
echo '<div id="content"><pre>';
echo file_get_contents("/tmp/panel/$type.out");
echo '</pre></div>';
?>
