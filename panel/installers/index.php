<?php
session_start();
$safe=true;
$webroot=$_SERVER['DOCUMENT_ROOT'];
$title="Installers";
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
$app=$_GET['app'];
if(!isset($app) || $app == ""){
?>
<a class="button" href="?app=wordpress"><img class="img-button" src="/assets/images/wordpress.png"> <br> WordPress </a>
<?php
}
else{
?>
<form action="" method="post" id="hideOnSubmit">
Domain: <input id="comInput" type="text" name="domain" autocomplete="off">
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
     echo "\$(\"#frame\").load(\"/panel/installers/installers.php?app=$app#content\")";
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
