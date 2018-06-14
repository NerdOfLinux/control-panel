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
<a class="button" href="?what=install"><img class="img-button" src="/assets/images/installers.png"> <br> Install </a>
<a class="button" href="?what=remove"><img class="img-button" src="/assets/images/remove.png"><br> Remove </a>
<?php
}else{
	$action=$what;
     if(!include("$action.php")){
          echo "Oops, $action does not appear to exist yet.";
     }
}
include("$webroot/assets/footer.php");
?>
