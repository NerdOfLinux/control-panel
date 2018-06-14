<?php
$title="Panel Management";
$webroot=$_SERVER['DOCUMENT_ROOT'];
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$backend="$webroot/assets/wrapper.sh $webroot/assets/backend.sh ";
$action=$_GET['action'];
?>
<center> <h1 id="title"> Panel Management </h1> </center>
<hr>
<?php
if(!isset($action) || $action == ""){
?>
<h3> Available Options: </h3>
<a href="?action=update" class="button" style="border-color:blue" ><img class="img-button" src="/assets/images/update3.png"><br>Update Panel</a>
<a href="?action=password" class="button" style="border-color: blue"><img class="img-button" src="/assets/images/password.png"><br>Update Password</a>
</div>
<?php
}else{
	if(!include("$action.php")){
		echo "Oops, $action does not appear to exist yet.";
	}
}
include("$webroot/assets/footer.php");
?>

