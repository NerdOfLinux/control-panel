<?php
if($_SESSION['login']!=1){
	echo "Please log in";
	header("Location: /");
	exit();
}
?>
