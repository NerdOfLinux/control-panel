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
Email:    <input type="email" required name="email">
UserName: <input type="text" required name="username">
Password: <input type="password" required name="password">
<input type="submit" name="submit" value="Set Up">
</pre>
</from>
<?php
//Only run once submit button is pressed
if(!isset($_POST['submit'])){
	exit();
}
//Create an array
$data=[];
$data["email"] = $_POST['email'];
$data["username"] = $_POST['username'];
$data["password"] = password_hash($_POST['password'], PASSWORD_DEFAULT);
$json = json_encode($data);
$file=fopen(".ht.users.json", "w");
fwrite($file, $json);
fclose($file);
if(file_exists(".ht.users.json")){
	echo "Install complete.";
}
?>
