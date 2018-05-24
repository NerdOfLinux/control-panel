<?php
$title="Panel Management";
$webroot=$_SERVER['DOCUMENT_ROOT'];
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$backend="$webroot/assets/wrapper.sh $webroot/assets/backend.sh ";
$action=$_GET['action'];
?>
<center> <h1 id="title"> Panel Management </h1> </center>
<hr>
<?php
if(!isset($action) || $action == ""){
?>
<h3> Available Options: </h3>
<a href="?action=update" class="button" style="border-color:blue" ><img class="img-button" src="/assets/images/update3.png"><br>Update Panel</a>
<a href="?action=password" class="button" style="border-color: blue"><img class="img-button" src="/assets/images/password.png"><br>Update Password</a>
</div>
<?php
}
if($action=="update"){
?>
<script>
document.getElementById("title").innerHTML="Panel Update";
</script>
<script>
$(function(){
setInterval(refreshFrame, 1000);
});
</script>
<?php
	pclose(popen("sudo $backend panelupdate $webroot", "r"));
?>
<script>
function refreshFrame(){
     $("#frame").load("/assets/readfile.php?type=panelupdate#content")
}
</script>
<div id="frame"></div>
<?php
}else if($action == "password"){
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
}
?>
