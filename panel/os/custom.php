<?php
if(!isset($safe)){
	exit();
}
?>
<script>
document.getElementById("title").innerHTML="Custom";
</script>
<form action="" method="post">
Command: <input id="comInput" type="text" name="com" autocomplete="off">
<input id="comButton" type="submit" name="submit" value="Run!">
</form>
<?php
	if(isset($_POST['submit'])){
		$com=$_POST['com'];
		pclose(popen("sudo $backend custom \"$com\"", "r"));
?>
<script>
document.getElementById("title").innerHTML="Update";
function refreshFrame(){
     $("#frame").load("/assets/readfile.php?type=custom#content")
}
</script>
<pre>
<div id="frame"></div>
</pre>
<?php
}
?>
