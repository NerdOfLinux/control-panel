<?php
if(!isset($safe)){
	exit();
}
?>
<script>
document.getElementById("title").innerHTML="Panel Update";
</script>
<script>
$(function(){
setInterval(refreshFrame, 1000);
});
</script>
<?php
	pclose(popen("sudo $backend panelupdate $webroot", "r"));
?>
<script>
<?php
$type="panelupdate";
include("$webroot/assets/refreshFrame.php");
?>
</script>
<div id="frame"></div>

