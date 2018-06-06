<?php
if(!isset($safe)){
	exit();
}
?>
<script>
document.getElementById("title").innerHTML="Create NGINX Config File";
</script>
<form action="" method="get" id="hideOnClick">
<input style="display:none" name="action" value="createconfig">
Filename: <input type="text" name="file" class="fancyInput">
<input type="submit" value="Create" class="fancyButton" style='width: 50px;'>
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
?>
