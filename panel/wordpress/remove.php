<form action="" method="post" id="hideOnSubmit">
Domain: <input id="comInput" type="text" name="domain" autocomplete="off" required>
<br>
<input type="checkbox" required>I understand this will delete the WordPress install, and the install will not be recoverable<br>
<input id="comButton" type="submit" name="submit" value="Remove!" style="width: 70px">
</form>
<?php
        if(isset($_POST['submit'])){
                $domain=$_POST['domain'];
                pclose(popen("sudo $backend remove $app $domain", "r"));
?>
<script>
document.getElementById("title").innerHTML="Delete a WordPress install";
document.getElementById("hideOnSubmit").style.display="none";
function refreshFrame(){
	if(!("#frame").is(":hover")){
<?php
     echo "\$(\"#frame\").load(\"/panel/wordpress/installers.php?what=remove#content\")";
?>
	}
}
</script>
<?php
        }
?>
