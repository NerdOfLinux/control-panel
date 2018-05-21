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
<a class="button" href="?action=createconfig"><img class="img-button" src="/assets/images/create.png"><br> Create Config </a>
<a class="button" href="?action=editsnippets"><img class="img-button" src="/assets/images/edit2.png"><br>Edit Snippets</br></a>
<a class="button" href="?action=createsnippet"><img class="img-button" src="/assets/images/create2.png"><br>Create Snippets</a>
<a class="button" href="?action=manage"><img class="img-button" src="/assets/images/activate.png"><br>Manage Sites</a>
<a class="button" href="?action=restart"><img class="img-button" src="/assets/images/restart.png"><br>Restart NGINX</a>
<?php
}
if($action == "editconfig"){
?>
<script>
document.getElementById("title").innerHTML="Config Editor";
</script>
<?php
	if(isset($_GET['file'])){
		$file=$_GET['file'];
		include("$webroot/assets/edit.php");
		exit();
	}
	echo "<h3> Enabled Configs: </h3>";
	echo "<ul>";
	foreach(scandir("/etc/nginx/sites-enabled/") as $file){
		if($file[0] != "." && is_file("/etc/nginx/sites-enabled/$file")){
			$path=urlencode("/etc/nginx/sites-enabled/$file");
			echo "<li> <a href='?action=editconfig&file=$path'> $file </a></li>";
		}
	}
	echo "</ul>";
}else if($action == "restart"){
	pclose(popen("sudo $backend restartnginx", "r"));
?>
<script>
document.getElementById("title").innerHTML="Restart NGINX";
function refreshFrame(){
     $("#frame").load("/assets/readfile.php?type=restartnginx#content")
}
</script>
<?php
}else if($action == "editsnippets"){
?>
<script>
document.getElementById("title").innerHTML="Snippet Editor";
</script>
<?php
	if(isset($_GET['file'])){
          $file=$_GET['file'];
          include("$webroot/assets/edit.php");
          exit();
     }
	echo "<ul>";
     foreach(scandir("/etc/nginx/snippets/") as $file){
          if($file[0] != "." && is_file("/etc/nginx/snippets/$file")){
               $path=urlencode("/etc/nginx/snippets/$file");
               echo "<li><a href='?action=editsnippets&file=$path'> $file </a></li>";
          }
     }
	echo "</ul>";
}else if($action == "manage"){
	if(isset($_GET['what']) && isset($_GET['file'])){
		$what=$_GET['what'];
		$file=$_GET['file'];
?>
<form action="" method="post">
<input type="submit" name="submit" value="<?php echo $what;?>">
</form>
<?php
		if(isset($_POST['submit'])){
			echo "<br>";
			exec("sudo $backend nginx $what $file");
			$filename=basename($file);
			if($what=="activate" && is_file("/etc/nginx/sites-enabled/$filename")){
				echo "$file has been activated<br>";
				echo "Please restart NGINX";
			}else if($what=="deactivate" && !is_file($file)){
				echo "$file has been deactivated<br>";
				echo "Please restart NGINX";
			}else{
				echo "Error, please try again.";
			}
		}
		exit();
	}
	echo "<ul>";
     foreach(scandir("/etc/nginx/sites-available/") as $file){
          if($file[0] != "." && is_file("/etc/nginx/sites-available/$file")){
               $path=urlencode("/etc/nginx/sites-available/$file");
			$path2=urlencode("/etc/nginx/sites-enabled/$file");
			if(is_file(urldecode($path2))){
				echo "<li><a style='color: green' href='?action=manage&what=deactivate&file=$path2'> $file(deactivate) </a></li>";
			}else{
               	echo "<li><a style='color: red' href='?action=manage&what=activate&file=$path'> $file(activate) </a></li>";
			}
          }
     }
     echo "</ul>";
}else if($action == "createconfig"){
?>
<script>
document.getElementById("title").innerHTML="Create NGINX Config File";
</script>
<form action="" method="get" id="hideOnClick">
<input style="display:none" name="action" value="createconfig">
Filename: <input type="text" name="file">
<input type="submit" value="Create">
</form>
<?php
	if(isset($_GET['file'])){
?>
<script>
document.getElementById("hideOnClick").style.display="none";
</script>
<?php
		$file=$_GET['file'];
		$file="/etc/nginx/sites-available/$file";
		include("$webroot/assets/edit.php");
	}
}else if($action == "createsnippet"){
?>
<script>
document.getElementById("title").innerHTML="Create NGINX Snippet";
</script>
<form action="" method="get" id="hideOnClick">
<input style="display:none" name="action" value="createsnippet">
Filename: <input type="text" name="file">
<input type="submit" value="Create">
</form>
<?php
     if(isset($_GET['file'])){
?>
<script>
document.getElementById("hideOnClick").style.display="none";
</script>
<?php
          $file=$_GET['file'];
          $file="/etc/nginx/snippets/$file";
          include("$webroot/assets/edit.php");
     }
}

?>
<pre>
<div id="frame"></div>
</pre>
