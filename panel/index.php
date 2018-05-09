<?php
$title="Admin Panel";
$webroot=$_SERVER['DOCUMENT_ROOT'];
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
?>
<center> <h1> <?php echo gethostname();?> </h1> </center>
<hr>
<h3> Available Options: </h3>
<ul>
<li> <a href="installers/index.php"> Installers </a> </li>
<li> <a href="os/index.php"> Server Management </a> </li>
<li> <a href="nginx/index.php"> NGINX </a> </li>
<li> <a href="?action=logout"> Logout </a> </li>
</ul>
<?php
//Simple logout; destroy the session variable
if($_GET['action']=="logout"){
	session_unset($_SESSION['login']);
	header("Location: ../");
}
?>
