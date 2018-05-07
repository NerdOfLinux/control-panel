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
//If there is no action set, provide a list of actions
if($action == ""){

	echo '<a class="button" href="?action=update"> <img class="img-button" src="/assets/images/update.png"> <br>Update </a>';
	echo '<a class="button" href="?action=upgrade"> <img class="img-button" src="/assets/images/upgrade.png"><br>Upgrade </a>';
	echo '<a class="button" href="?action=custom"> <img class="img-button" src="/assets/images/bash.png"><br> Run Command </a>';
	echo '<a class="button" href="?action=reboot"> <img class="img-button" src="/assets/images/reboot.png"><br>Reboot';
	if(is_file("/var/run/reboot-required")){
		echo "(updates waiting)</a>";
	}else{
		echo "</a>";
	}

}
//If the action is set to update
else if($action == "update"){
	pclose(popen("sudo $backend update", "r"));
	echo '
<script>
document.getElementById("title").innerHTML="Update";
function refreshFrame(){
	$("#frame").load("/panel/os/actions.php?type=update#content")
}
</script>
<div id="frame"></div>
';
}
//If the action is set to upgrade
else if($action == "upgrade"){
     pclose(popen("sudo $backend upgrade", "r"));
     echo '
<script>
document.getElementById("title").innerHTML="Upgrade";
function refreshFrame(){
     $("#frame").load("/panel/os/actions.php?type=upgrade#content")
}
</script>
<div id="frame"></div>
';
}
//If the action is set to reboot
else if($action == "reboot"){
?>
<script>
document.getElementById("title").innerHTML="Reboot";
</script>
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
//If the action is set to custom
else if($action == "custom"){
?>
<script>
document.getElementById("title").innerHTML="Custom";
</script>
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
     $("#frame").load("/panel/os/actions.php?type=custom#content")
}
</script>
<pre>
<div id="frame"></div>
</pre>
';
	}
}
?>
