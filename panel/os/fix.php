<?php
if(!isset($safe)){
	exit();
}
pclose(popen("sudo $backend autofix", "r"));
?>
<script>
document.getElementById("title").innerHTML="Fix";
<?php
$type="autofix";
include("$webroot/assets/refreshFrame.php");
?>

</script>
<div id="frame"></div>
