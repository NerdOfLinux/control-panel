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
<script>
$(function(){
setInterval(refreshFrame, 1000);
});
</script>
<?php
$action=$_GET['action'];
//If there is no action set, provide a list of actions
if($action == ""){
?>
<a class="button" href="?action=editconfig"><img class="img-button" src="/assets/images/edit.png"> <br> Edit Configs </a>
<a class="button" href="?action=editsnippets"><img class="img-button" src="/assets/images/edit2.png"><br>Edit Snippets</br></a>
<a class="button" href="?action=restart"><img class="img-button" src="/assets/images/restart.png"><br>Restart NGINX</a>
<?php
}
if($action == "editconfig"){
	if(isset($_GET['file'])){
		$file=$_GET['file'];
		include("$webroot/assets/edit.php");
		exit();
	}
	foreach(scandir("/etc/nginx/sites-enabled/") as $file){
		if($file[0] != "." && is_file("/etc/nginx/sites-enabled/$file")){
			$path=urlencode("/etc/nginx/sites-enabled/$file");
			echo "<a href='?action=editconfig&file=$path'> $file </a><br>";
		}
	}
}else if($action == "restart"){
	pclose(popen("sudo $backend restartnginx", "r"));
?>
<script>
document.getElementById("title").innerHTML="Restart NGINX";
function refreshFrame(){
     $("#frame").load("/panel/nginx/actions.php?type=restartnginx#content")
}
</script>
<?php
}else if($action == "editsnippets"){
	if(isset($_GET['file'])){
          $file=$_GET['file'];
          include("$webroot/assets/edit.php");
          exit();
     }
     foreach(scandir("/etc/nginx/snippets/") as $file){
          if($file[0] != "." && is_file("/etc/nginx/snippets/$file")){
               $path=urlencode("/etc/nginx/snippets/$file");
               echo "<a href='?action=editsnippets&file=$path'> $file </a><br>";
          }
     }
}
?>
<pre>
<div id="frame"></div>
</pre>
