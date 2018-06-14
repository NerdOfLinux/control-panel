<?php
if(!isset($safe)){
	exit();
}
?>
<script>
document.getElementById("title").innerHTML="Pre-made snippets";
</script>
<?php
	//If the GET variables 'file' is set, assume the form has been filled out
	$file=$_GET['file'];
	if(isset($file)){
		//If the file is not active, then activate. Otherwise, deactivate
		if(!is_file("$webroot/assets/snippets/.$file.active")){
			pclose(popen("sudo $backend nginxsnippet add $file", "r"));
		}else{
			pclose(popen("sudo $backend nginxsnippet remove $file", "r"));
		}
?>
<script>
function refreshFrame(){
     $("#frame").load("/assets/readfile.php?type=easysnippets#content")
}
</script>
<div id="frame"></div>

<?php
		header("refresh:5;url=/panel/nginx/?action=easysnippets");
		exit("</body></html>");
	}
?>
<h3> Available: </h3>
<ul>
<?php
	//For each file in the folder sites-enabled, create an unordered list
	foreach(scandir("$webroot/assets/snippets") as $file){
		if($file[0] != "." && is_file("$webroot/assets/snippets/$file") && $file){
			if(is_file("$webroot/assets/snippets/.$file.active")){
				echo "<li> <a href='?action=easysnippets&file=$file' style='color:darkgreen'> $file(active) </a></li>";
			}else{
				echo "<li> <a href='?action=easysnippets&file=$file' style='color:darkred'> $file(<span style='font-weight: bold'>NOT</span> active) </a></li>";
			}
		}
	}
	echo "</ul>";
?>
