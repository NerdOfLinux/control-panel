<?php
if(!isset($safe)){
	exit();
}

pclose(popen("sudo $backend clean", "r"));
?>
<script>
document.getElementById("title").innerHTML="Clean up packages";
<?php
$type="clean";
include("$webroot/assets/refreshFrame.php");
?>
</script>
<pre>
<div id="frame"></div>
</pre>
