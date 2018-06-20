<form action="" method="post" id="hideOnSubmit">
Domain: <input id="comInput" type="text" name="domain" autocomplete="off" required>
<input id="comButton" type="submit" name="submit" value="Install!">
</form>
<?php
	if(isset($_POST['submit'])){
		$domain=$_POST['domain'];
		pclose(popen("sudo $backend install $app $domain", "r"));
?>
<script>
document.getElementById("title").innerHTML="WordPress Install";
document.getElementById("hideOnSubmit").style.display="none";
function refreshFrame(){
	if(!$("#frame").is(":hover")){
<?php
     echo "\$(\"#frame\").load(\"/panel/wordpress/installers.php?what=install#content\")";
?>
	}
}
</script>
<?php
	}
?>
