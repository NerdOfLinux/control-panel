<?php
session_start();
$title="Admin Panel";
include("../assets/header.php");
include("../assets/locked.php");
?>
<center> <h1> <?php echo gethostname();?> </h1> </center>
<hr>
<a href="installers/index.php"> Installers </a>
<br>
<a href="os/index.php"> Server Management </a>
