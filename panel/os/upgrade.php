<?php
if(!isset($safe)){
	exit();
}
pclose(popen("sudo $backend upgrade", "r"));
?>
<script>
document.getElementById("title").innerHTML="Upgrade";
function refreshFrame(){
     $("#frame").load("/assets/readfile.php?type=upgrade#content")
}
</script>
<div id="frame"></div>
