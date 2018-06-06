<?php
if(!isset($safe)){
	exit();
}
?>
<script>
document.getElementById("title").innerHTML="Reboot";
</script>
<form method="post" action="">
<input id="rebootButton" type="submit" value="Reboot Now" name="submit">
</form>
<?php
if(isset($_POST['submit'])){
		echo '
<script>
setTimeout(function(){
	window.location.href = "/panel";
}, 15000);
</script>
';
		echo "<h2> Going down! </h2>";
		echo "You will be redirected to the home page in 15 seconds.";
		shell_exec("sudo $backend reboot");
	}
?>
