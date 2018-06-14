<?php
session_start();
//Set vars
$safe=true;
$webroot=$_SERVER['DOCUMENT_ROOT'];
$title="VPS Management";
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$backend="$webroot/assets/wrapper.sh $webroot/assets/backend.sh ";
?>
<h1 class="center" id="title">Server Management</h1>
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

	echo '<a class="button" href="?action=upgrade"> <img class="img-button" src="/assets/images/update.png"><br>Upgrade </a>';
	echo '<a class="button" href="?action=custom"> <img class="img-button" src="/assets/images/bash.png"><br> Run Command </a>';
	echo '<a class="button" href="?action=clean"> <img class="img-button" src="/assets/images/clean.png"><br>Remove Unused Packages</a>';
	echo '<a class="button" href="?action=reboot"> <img class="img-button" src="/assets/images/reboot.png"><br>Reboot';
	if(is_file("/var/run/reboot-required")){
		echo "(updates waiting)</a>";
	}else{
		echo "</a>";
	}

}else{
	if(!include("$action.php")){
		echo "Oops, $action does not appear to exist yet.";
	}
}
include("$webroot/assets/footer.php");
?>

