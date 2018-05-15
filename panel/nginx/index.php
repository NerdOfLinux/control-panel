<?php
session_start();
$safe=true;
$webroot=$_SERVER['DOCUMENT_ROOT'];
$title="VPS Management";
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$backend="$webroot/assets/wrapper.sh $webroot/assets/backend.sh ";
?>
<h1 class="center" id="title">NGINX Config</h1>
<hr>
<?php
$action=$_GET['action'];
//If there is no action set, provide a list of actions
if($action == ""){
?>
<a class="button" href="?action=edit"><img class="img-button" src="/assets/images/edit.png"> <br> Edit Configs </a>
<?php
}
if($action == "edit"){
	if(isset($_GET['file'])){
		$file=$_GET['file'];
		include("$webroot/assets/edit.php");
		exit();
	}
	foreach(scandir("/etc/nginx/sites-enabled/") as $file){
		if($file[0] != "." && is_file("/etc/nginx/sites-enabled/$file")){
			$path=urlencode("/etc/nginx/sites-enabled/$file");
			echo "<a href='?action=edit&file=$path'> $file </a><br>";
		}
	}
}
?>
