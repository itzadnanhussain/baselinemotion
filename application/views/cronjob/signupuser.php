<?php
	if($status == 1){
		echo "<pre>";
		print_r($olduser);
		
		echo "</pre><br/><br/>===================================================================<br/><br/>";
		print_r($outputstr);
	}else{
		print_r($error);
	}
?>