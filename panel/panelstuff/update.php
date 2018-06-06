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
function refreshFrame(){
     $("#frame").load("/assets/readfile.php?type=panelupdate#content")
}
</script>
<div id="frame"></div>

