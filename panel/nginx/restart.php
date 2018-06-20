<?php
if(!isset($safe)){
	exit();
}
	pclose(popen("sudo $backend restartnginx", "r"));
?>
<script>
document.getElementById("title").innerHTML="Restart NGINX";
<?php
$type="restartnginx";
include("$webroot/assets/refreshFrame.php");
?>
</script>
<div id="frame"></div>
