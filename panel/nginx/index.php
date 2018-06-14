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
<a class="button" href="?action=easysnippets"><img class="img-button" src="/assets/images/easysnippets.png"><br>Pre-made snippets</a>
<a class="button" href="?action=editconfig"><img class="img-button" src="/assets/images/edit.png"> <br> Edit Configs </a>
<a class="button" href="?action=createconfig"><img class="img-button" src="/assets/images/create.png"><br> Create Custom Config </a>
<a class="button" href="?action=editsnippets"><img class="img-button" src="/assets/images/edit2.png"><br>Edit Snippets</br></a>
<a class="button" href="?action=createsnippet"><img class="img-button" src="/assets/images/create2.png"><br>Create Custom Snippets</a>
<a class="button" href="?action=manage"><img class="img-button" src="/assets/images/activate.png"><br>Manage Sites</a>
<a class="button" href="?action=ssl"><img class="img-button" src="/assets/images/encryption.png"><br>Let's Encrypt</br></a>
<a class="button" href="?action=restart"><img class="img-button" src="/assets/images/restart.png"><br>Restart NGINX</a>

<?php
}else{
	if(!include("$action.php")){
		echo "Oops, $action does not appear to exist yet.";
	}
}
include("$webroot/assets/footer.php");
?>

