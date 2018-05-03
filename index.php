<?php
$title="Login";
include("assets/header.php");
/*
    Control Panel- A simple control panel to install WordPress and manage a VPS
    Copyright (C) 2018  NerdOfLinux
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
    You can also find the full copy of the license at https://goo.gl/ksUg99
*/
session_start();
if($_SESSION["login"]==1){
	echo "Already signed in.";
	exit();
}
?>
<form action="" method="post">
<pre>
UserName: <input type="text" required name="username">
Password: <input type="password" required name="password">
<input type="submit" name="submit" value="Sign In">
</pre>
</from>
<?php
if(!isset($_POST['submit'])){
	exit();
}
//Get the file contents
$file=fopen(".ht.users.json", "r") or die("Please run install.php");
$json=fread($file,filesize(".ht.users.json"));
fclose($file);
$data=json_decode($json, true);
//Check against input
if($_POST['username'] != $data["username"]){
	echo "Username or password is incorrect.";
	exit();
}
if(password_verify($_POST['password'], $data["password"])){
	echo "Success!";
	$_SESSION["login"]=1;
}else{
	echo "Username or password is incorrect.";
	exit();
}
?>
