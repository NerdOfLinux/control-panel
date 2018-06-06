<?php
if(!isset($safe)){
	exit();
}
?>
<script>
document.getElementById("title").innerHTML="Config Editor";
</script>
<?php
	//If the GET variables 'file' is set, assume the form has been filled out, and provide an editor
	if(isset($_GET['file'])){
		$file=$_GET['file'];
		include("$webroot/assets/edit.php");
		exit();
	}
?>
<h3> Enabled Configs: </h3>
<ul>
<?php
	//For each file in the folder sites-enabled, create an unordered list
	foreach(scandir("/etc/nginx/sites-available/") as $file){
		if($file[0] != "." && is_file("/etc/nginx/sites-available/$file")){
			$path=urlencode("/etc/nginx/sites-available/$file");
			if(is_file("/etc/nginx/sites-enabled/$file")){
				echo "<li> <a href='?action=editconfig&file=$path' style='color:darkgreen'> $file(active) </a></li>";
			}else{
				echo "<li> <a href='?action=editconfig&file=$path' style='color:darkred'> $file(<span style='font-weight: bold'>NOT</span> active) </a></li>";
			}
		}
	}
	echo "</ul>";
?>
