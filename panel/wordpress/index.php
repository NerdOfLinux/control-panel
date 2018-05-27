<?php
session_start();
$safe=true;
$webroot=$_SERVER['DOCUMENT_ROOT'];
$title="WordPress";
include("$webroot/assets/header.php");
include("$webroot/assets/locked.php");
$backend="$webroot/assets/wrapper.sh $webroot/assets/backend.sh ";
?>
<h1 class="center" id="title">Installers</h1>
<script>
$(function(){
setInterval(refreshFrame, 1000);
});
</script>
<hr>
<?php
$what=$_GET['what'];
$app="wordpress";
if(!isset($what) || $what == ""){
?>
<a class="button" href="?what=install"><img class="img-button" src="/assets/images/wordpress.png"> <br> Install </a>
<a class="button" href="?what=remove"><img class="img-button" src="/assets/images/remove.png"><br> Remove </a>
<?php
}else if($what=="install"){
?>
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
<?php
     echo "\$(\"#frame\").load(\"/panel/wordpress/installers.php?what=install#content\")";
?>
}
</script>
<?php
	}
}else if($what=="remove"){
?>
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
<?php
     echo "\$(\"#frame\").load(\"/panel/wordpress/installers.php?what=remove#content\")";
?>
}
</script>
<?php
        }
}
?>
<pre>
<div id="frame"></div>
</pre>
</body>
</html>
