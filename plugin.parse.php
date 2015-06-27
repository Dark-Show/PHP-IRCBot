<?php

if(is_dir($ROOT."plugin")){
	if($dh=opendir($ROOT."plugin")){
        	while(($file=readdir($dh))!==false){
            		if(is_file($ROOT."plugin/".$file)){
				if(substr($file,-3)=="php"){
					if(substr($file,0,3)!=="inc"){
						include($ROOT."plugin/".$file);
					}
			   	}
			 }
		}
		closedir($dh);
	}	
}

?>
