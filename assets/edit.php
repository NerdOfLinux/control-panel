<?php
if(!isset($webroot) || !isset($file)){
	exit();
}
if(!isset($backend)){
	$backend="$webroot/assets/wrapper.sh $webroot/assets/backend.sh ";
}
?>
<form action="" method="post">
<textarea rows="25" cols="100"  name="text"> <?php echo file_get_contents($file); ?> </textarea>
<input type="submit" name="submit" value="Update">
</form>
<?php
if(!isset($_POST['submit'])){
	exit();
}
$temp=exec("mktemp");
file_put_contents($temp, $_POST['text']);
exec("sudo $backend write $temp $file");
header("Refresh: 0");
?>
