<?php
$title="Admin Panel";
$webroot=$_SERVER['DOCUMENT_ROOT'];
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$backend="$webroot/assets/wrapper.sh $webroot/assets/backend.sh ";
?>
<center> <h1 id="title"> <?php echo gethostname();?> </h1> </center>
<hr>
<div id="hideOnClick">
<h3> Available Options: </h3>
<a href="installers/index.php" class="button"> <img class="img-button" src="/assets/images/installers.png"><br>Installers </a>
<a href="os/index.php" class="button"> <img class="img-button" src="/assets/images/server-management.png"><br>Server Management
<a href="nginx/index.php" class="button"><img class="img-button" src="/assets/images/nginx.png"><br> NGINX </a>
<a href="?action=update" class="button" style="color:blue" ><img class="img-button" src="/assets/images/update3.png"><br>Update Panel</a>
<a href="?action=logout" class="button"><img class="img-button" src="/assets/images/logout.png"> <br>Logout </a>
</div>
<?php
//Simple logout; destroy the session variable
if($_GET['action']=="logout"){
	session_unset($_SESSION['login']);
	header("Location: ../");
}else if($_GET['action']=="update"){
?>
<script>
document.getElementById("hideOnClick").style.display="none";
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
<?php
}
?>
