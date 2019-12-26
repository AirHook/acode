<?php if(!function_exists('debug')){
	function debug($data=null){
		if($data!=null){
			 echo '<pre>',print_r($data),'</pre>';
			 exit();
		}else{
			exit();
		}
	}
}

