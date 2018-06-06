<?php
if(!isset($safe)){
	exit();
}
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
?>
