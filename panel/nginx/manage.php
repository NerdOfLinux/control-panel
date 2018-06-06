<?php
if(!isset($safe)){
	exit();
}
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
?>
