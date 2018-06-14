<?php
if($_SESSION['login']==1){
	$homeLink="/panel";
}else{
	$homeLink="/";
}
?>
<div id="footer">
<a href="<?php echo $homeLink ?>" id="homeLink"> Panel Home </a>
</div>
</body>
</html>
