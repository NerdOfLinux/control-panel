<?php
//Installer
//Check if the set-up already exists
if(file_exists(".ht.users.json")){
	echo "This site already appears to be set up. If not, delete the users file.";
	exit();
}
?>
<form action="" method="post">
<pre>
UserName: <input type="text" required name="username">
Password: <input type="password" required name="password">
Verify:   <input type="password" required name="verify">
<input type="submit" name="submit" value="Set Up">
</pre>
</form>
<?php
//Only run once submit button is pressed
if(!isset($_POST['submit'])){
	exit();
}
//Verify passwords
if($_POST['password']!==$_POST['verify']){
	echo "Passwords don't match!";
	exit();
}
//Create an array
$data=[];
$data["username"] = $_POST['username'];
$data["password"] = password_hash($_POST['password'], PASSWORD_DEFAULT);
$json = json_encode($data);
file_put_contents(".ht.users.json", $json);
if(file_exists(".ht.users.json")){
	echo "Install complete.";
	header("Location: /");
}
?>
