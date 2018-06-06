<?php
if(!isset($safe)){
	exit();
}
	pclose(popen("sudo $backend restartnginx", "r"));
?>
<script>
document.getElementById("title").innerHTML="Restart NGINX";
function refreshFrame(){
     $("#frame").load("/assets/readfile.php?type=restartnginx#content")
}
</script>
<div id="frame"></div>
