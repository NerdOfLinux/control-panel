<?php
if(!isset($safe)){
	exit();
}
pclose(popen("sudo $backend upgrade", "r"));
?>
<script>
document.getElementById("title").innerHTML="Upgrade";
<?php
$type="upgrade";
include("$webroot/assets/refreshFrame.php");
?>

</script>
<div id="frame"></div>
