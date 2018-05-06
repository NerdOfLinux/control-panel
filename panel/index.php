<?php
$title="Admin Panel";
$webroot=$_SERVER['DOCUMENT_ROOT'];
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
?>
<center> <h1> <?php echo gethostname();?> </h1> </center>
<hr>
<a href="installers/index.php"> Installers </a>
<br>
<a href="os/index.php"> Server Management </a>
<br>
<a href="?action=logout"> Logout </a>
<?php
if($_GET['action']=="logout"){
	session_unset($_SESSION['login']);
	header("Location: ../");
}
?>
