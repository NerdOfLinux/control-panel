<?php
$title="Admin Panel";
$webroot=$_SERVER['DOCUMENT_ROOT'];
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
?>
<center> <h1> <?php echo gethostname();?> </h1> </center>
<hr>
<h3> Available Options: </h3>
<a href="installers/index.php" class="button"> <img class="img-button" src="/assets/images/installers.png"><br>Installers </a>
<a href="os/index.php" class="button"> <img class="img-button" src="/assets/images/server-management.png"><br>Server Management
<a href="nginx/index.php" class="button"><img class="img-button" src="/assets/images/nginx.png"><br> NGINX </a>
<a href="?action=logout" class="button"><img class="img-button" src="/assets/images/logout.png"> <br>Logout </a>
<?php
//Simple logout; destroy the session variable
if($_GET['action']=="logout"){
	session_unset($_SESSION['login']);
	header("Location: ../");
}
?>
