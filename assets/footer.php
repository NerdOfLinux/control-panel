<?php
if($_SESSION['login']==1){
	$homeLink="/panel";
}else{
	$homeLink="/";
}
?>
<div id="footer">
<a href="<?php echo $homeLink ?>" id="homeLink"> Panel Home</a> |
<a href="https://goo.gl/SWikTi" id="issueLink" target="_blank"> Report Bug</a>
</div>
</body>
</html>
