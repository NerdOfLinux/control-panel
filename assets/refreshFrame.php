function refreshFrame(){
     if(!$("#frame").is(":hover")){
          $("#frame").load("/assets/readfile.php?type=<?php echo $type;?>#content")
     }
}
