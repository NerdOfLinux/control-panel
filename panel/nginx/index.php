<?php
session_start();
//Set a bunch of vars
$safe=true;
$webroot=$_SERVER['DOCUMENT_ROOT'];
$title="NGINX Management";
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$backend="$webroot/assets/wrapper.sh $webroot/assets/backend.sh ";
?>
<h1 class="center" id="title">NGINX Config</h1>
<hr>
<script>
$(function(){
setInterval(refreshFrame, 1000);
});
</script>
<?php
$action=$_GET['action'];
//If there is no action set, provide a list of actions
if($action == ""){
?>
<a class="button" href="?action=editconfig"><img class="img-button" src="/assets/images/edit.png"> <br> Edit Configs </a>
<a class="button" href="?action=createconfig"><img class="img-button" src="/assets/images/create.png"><br> Create Config </a>
<a class="button" href="?action=editsnippets"><img class="img-button" src="/assets/images/edit2.png"><br>Edit Snippets</br></a>
<a class="button" href="?action=createsnippet"><img class="img-button" src="/assets/images/create2.png"><br>Create Snippets</a>
<a class="button" href="?action=manage"><img class="img-button" src="/assets/images/activate.png"><br>Manage Sites</a>
<a class="button" href="?action=ssl" style="border-color: blue"><img class="img-button" src="/assets/images/encryption.png"><br>Let's Encrypt</br></a>
<a class="button" href="?action=restart" style="border-color: blue"><img class="img-button" src="/assets/images/restart.png"><br>Restart NGINX</a>

<?php
}
//If the action equals something, then do stuff
if($action == "editconfig"){
?>
<script>
document.getElementById("title").innerHTML="Config Editor";
</script>
<?php
	//If the GET variables 'file' is set, assume the form has been filled out, and provide an editor
	if(isset($_GET['file'])){
		$file=$_GET['file'];
		include("$webroot/assets/edit.php");
		exit();
	}
	echo "<h3> Enabled Configs: </h3>";
	echo "<ul>";
	//For each file in the folder sites-enabled, create an unordered list
	foreach(scandir("/etc/nginx/sites-available/") as $file){
		if($file[0] != "." && is_file("/etc/nginx/sites-available/$file")){
			$path=urlencode("/etc/nginx/sites-available/$file");
			if(is_file("/etc/nginx/sites-enabled/$file")){
				echo "<li> <a href='?action=editconfig&file=$path' style='color:darkgreen'> $file(active) </a></li>";
			}else{
				echo "<li> <a href='?action=editconfig&file=$path' style='color:darkred'> $file(<span style='font-weight: bold'>NOT</span> active) </a></li>";
			}
		}
	}
	echo "</ul>";
}else if($action == "restart"){
	pclose(popen("sudo $backend restartnginx", "r"));
?>
<script>
document.getElementById("title").innerHTML="Restart NGINX";
function refreshFrame(){
     $("#frame").load("/assets/readfile.php?type=restartnginx#content")
}
</script>
<?php
}else if($action == "editsnippets"){
?>
<script>
document.getElementById("title").innerHTML="Snippet Editor";
</script>
<?php
	if(isset($_GET['file'])){
          $file=$_GET['file'];
          include("$webroot/assets/edit.php");
          exit();
     }
	echo "<ul>";
     foreach(scandir("/etc/nginx/snippets/") as $file){
          if($file[0] != "." && is_file("/etc/nginx/snippets/$file")){
               $path=urlencode("/etc/nginx/snippets/$file");
               echo "<li><a href='?action=editsnippets&file=$path'> $file </a></li>";
          }
     }
	echo "</ul>";
}else if($action == "manage"){
	if(isset($_GET['what']) && isset($_GET['file'])){
		$what=$_GET['what'];
		$file=$_GET['file'];
?>
<form action="" method="post">
<input type="submit" name="submit" value="<?php echo $what;?>">
</form>
<?php
		if(isset($_POST['submit'])){
			echo "<br>";
			exec("sudo $backend nginx $what $file");
			$filename=basename($file);
			if($what=="activate" && is_file("/etc/nginx/sites-enabled/$filename")){
				echo "$file has been activated<br>";
				echo "Please restart NGINX";
			}else if($what=="deactivate" && !is_file($file)){
				echo "$file has been deactivated<br>";
				echo "Please restart NGINX";
			}else{
				echo "Error, please try again.";
			}
		}
		exit();
	}
	echo "<ul>";
     foreach(scandir("/etc/nginx/sites-available/") as $file){
          if($file[0] != "." && is_file("/etc/nginx/sites-available/$file")){
               $path=urlencode("/etc/nginx/sites-available/$file");
			$path2=urlencode("/etc/nginx/sites-enabled/$file");
			if(is_file(urldecode($path2))){
				echo "<li><a style='color: green' href='?action=manage&what=deactivate&file=$path2'> $file(deactivate) </a></li>";
			}else{
               	echo "<li><a style='color: red' href='?action=manage&what=activate&file=$path'> $file(activate) </a></li>";
			}
          }
     }
     echo "</ul>";
}else if($action == "createconfig"){
?>
<script>
document.getElementById("title").innerHTML="Create NGINX Config File";
</script>
<form action="" method="get" id="hideOnClick">
<input style="display:none" name="action" value="createconfig">
Filename: <input type="text" name="file" class="fancyInput">
<input type="submit" value="Create" class="fancyButton" style='width: 50px;'>
</form>
<?php
	if(isset($_GET['file'])){
?>
<script>
document.getElementById("hideOnClick").style.display="none";
</script>
<?php
		$file=$_GET['file'];
		$file="/etc/nginx/sites-available/$file";
		include("$webroot/assets/edit.php");
	}
}else if($action == "createsnippet"){
?>
<script>
document.getElementById("title").innerHTML="Create NGINX Snippet";
</script>
<form action="" method="get" id="hideOnClick">
<input style="display:none" name="action" value="createsnippet">
Filename: <input type="text" name="file" class="fancyInput">
<input type="submit" value="Create" class="fancyButton" style="width: 50px">
</form>
<?php
     if(isset($_GET['file'])){
?>
<script>
document.getElementById("hideOnClick").style.display="none";
</script>
<?php
          $file=$_GET['file'];
          $file="/etc/nginx/snippets/$file";
          include("$webroot/assets/edit.php");
     }
}else if($action=="ssl"){
?>
<script>
document.getElementById("title").innerHTML="Let's Encrypt";
</script>
<pre>
<form action="" method="post" id="hideOnClick">
<span style="font-weight: bold">Note: </span>Separate domains with commas, and for wildcard certs, use: "example.com, *.example.com"
Domain Name:    <input type="text" class="fancyInput" name="domain" required>
DNS Provider:   <select name="dns">
<option value="cloudflare">Cloudflare</option>
<option value="digitalocean">DigitalOcean</option>
<option value="dnsimple">DNSimple</option>
<option value="dnsmadeeasy">DNSMadeEasy</option>
<option value="dnspark">DNSPark</option>
<option value="easydns">EasyDNS</option>
<option value="namesilo">Namesilo</option>
<option value="ns1">NS1</option>
<option value="pointHQ">PointHQ</option>
<option value="rage4">Rage4</option>
<option value="vultr">Vultr</options>
</select>
<?php
if(is_dir("/var/www/.acme.sh")){
?>
<input type="checkbox" required> I understand this may overwrite any existing certs.
<?php
}
?>
Email/Username: <input type="text" class="fancyInput" name="email" required>
API Key:        <input type="password" class="fancyInput" name="key" required>
<input type="submit" class="fancyButton" value="Create SSL Cert" name="submit">
</form>
</pre>
<br>
<?php
	if(isset($_POST['submit'])){
		$domain=$_POST['domain'];
		$email=$_POST['email'];
		$key=$_POST['key'];
		$dns=$_POST['dns'];
	echo "Setting up Let's Encrypt wildcard for $domain on $dns DNS";
	pclose(popen("sudo $backend letsencrypt $domain $dns $email $key", "r"));
?>
<script>
document.getElementById("hideOnClick").style.display="none";
function refreshFrame(){
     $("#frame").load("/assets/readfile.php?type=letsencrypt#content")
}
</script>
<?php
	}
}

?>
<div id="frame"></div>
