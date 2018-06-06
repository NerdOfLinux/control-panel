<?php
if(!isset($safe)){
	exit();
}

pclose(popen("sudo $backend clean", "r"));
?>
<script>
document.getElementById("title").innerHTML="Clean up packages";
function refreshFrame(){
     $("#frame").load("/assets/readfile.php?type=clean#content")
}
</script>
<pre>
<div id="frame"></div>
</pre>
