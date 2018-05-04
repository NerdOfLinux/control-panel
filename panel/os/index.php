<?php
session_start();
$safe=true;
$webroot=$_SERVER['DOCUMENT_ROOT'];
$title="VPS Management";
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$backend="$webroot/assets/wrapper.sh $webroot/assets/backend.sh ";
?>
<center><h1 id="title">Server Management</h1></center>
<hr>
<script>
$(function(){
setInterval(refreshFrame, 1000);
});
</script>
<?php
$action=$_GET['action'];
if($action == ""){

	echo '<a href="?action=update"> Update </a>';
	echo '<br><a href="?action=upgrade"> Upgrade </a>';
	echo '<br><a href="?action=custom"> Run Command </a>';
	echo '<br><a href="?action=reboot"> Reboot';
	if(is_file("/var/run/reboot-required")){
		echo "(updates waiting)</a>";
	}else{
		echo "</a>";
	}

}
else if($action == "update"){
	pclose(popen("sudo $backend update", "r"));
	echo '
<script>
document.getElementById("title").innerHTML="Update";
function refreshFrame(){
	$("#frame").load("/panel/os/update.php#content")
}
</script>
<div id="frame"></div>
';
}
else if($action == "upgrade"){
     pclose(popen("sudo $backend upgrade", "r"));
     echo '
<script>
document.getElementById("title").innerHTML="Upgrade";
function refreshFrame(){
     $("#frame").load("/panel/os/upgrade.php#content")
}
</script>
<div id="frame"></div>
';
}
else if($action == "reboot"){
?>
<form method="post" action="">
<input type="submit" value="Reboot Now" name="submit">
</form>
<?php
if(isset($_POST['submit'])){
		echo '
<script>
setTimeout(function(){
	window.location.href = "/panel";
}, 15000);
</script>
';
		echo "<h2> Going down! </h2>";
		echo "You will be redirected to the home page in 15 seconds.";
		shell_exec("sudo $backend reboot");
	}
}
else if($action == "custom"){
?>
<form action="" method="post">
Command: <input type="text" name="com">
<input type="submit" value="Run!" name="submit">
</form>
<?php
	if(isset($_POST['submit'])){
		$com=$_POST['com'];
		pclose(popen("sudo $backend custom \"$com\"", "r"));
		echo '
<script>
document.getElementById("title").innerHTML="Update";
function refreshFrame(){
     $("#frame").load("/panel/os/custom.php#content")
}
</script>
<pre>
<div id="frame"></div>
</pre>
';
	}
}
?>
