<?php
if(!isset($safe)){
	exit();
}
?>
<script>
document.getElementById("title").innerHTML="Update Password";
</script>
<form action="" method="post">
<pre>
New Password:    <input type="password" name="password" class="fancyInput">
Verify Password: <input type="password" name="verify" class="fancyInput">
<input type="submit" name="submit" class="fancyButton">
</pre>
</form>
<?php
	if(isset($_POST['submit'])){
		$password=$_POST['password'];
		$verify=$_POST['verify'];
		if($password != $verify){
			echo "<br>Passwords don't match!";
			exit();
		}
		$contents=file_get_contents("$webroot/.ht.users.json");
		$data=json_decode($contents, true);
		$newdata=[];
		$newdata['username']=$data['username'];
		$newdata['password']=password_hash($password, PASSWORD_DEFAULT);
		$json=json_encode($newdata);
		file_put_contents("$webroot/.ht.users.json", "$json");
		echo "<br> Password Updated!";
	}
?>
