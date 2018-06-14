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
<a href="wordpress/index.php" class="button"> <img class="img-button" src="/assets/images/wordpress.png"><br> WordPress </a>
<a href="os/index.php" class="button"> <img class="img-button" src="/assets/images/server-management.png"><br>Server Management
<a href="nginx/index.php" class="button"><img class="img-button" src="/assets/images/nginx.png"><br> NGINX </a>
<a href="panelstuff/index.php" class="button"><img class="img-button" src="/assets/images/panelstuff.png"><br>Manage Panel</a>
<a href="?action=logout" class="button"><img class="img-button" src="/assets/images/logout.png"> <br>Logout </a>
</div>
<?php
//Simple logout; destroy the session variable
if($_GET['action']=="logout"){
	session_unset($_SESSION['login']);
	header("Location: ../");
}
include("$webroot/assets/footer.php");
?>

