<?php
session_start();
$safe=true;
$webroot=$_SERVER['DOCUMENT_ROOT'];
$title="VPS Management";
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$backend="$webroot/assets/wrapper.sh $webroot/assets/backend.sh ";
?>
<center><h1>Server Management</h1></center>
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

}
else if($action == "update"){
	pclose(popen("sudo $backend update", "r"));
	echo '
<script>
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
function refreshFrame(){
     $("#frame").load("/panel/os/upgrade.php#content")
}
</script>
<div id="frame"></div>
';
}
?>
