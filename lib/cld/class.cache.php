<?php

class Cld_Cache{
  
  public $expires;
  
  
  public function Check($file){
	
	if(is_file($file) && time()<filemtime($file)+$this->Expires($file)) return true; else return false;
  
  }
  
  public function Expires($file){
  	
	$expires=0;
	
	foreach($this->files as $f){
		
		$p=str_replace('.','\\.',$p);
		$p=str_replace('*','.+',$f['file']);
				
		if(preg_match('/'.$p.'$/',$file)){
			
			$expires=$f['expires'];
			break 1;
		
		}
	
	}
	
	return $expires;
	
  }
  
  public function BuildFile($file,$contents,$encode=true){
		
		// minify contents
		if($this->Expires($file)>0){
			
			$contents=Minify($contents);
		
			// create normal file
			WriteToFile($file,$contents);
		
			if($encode){
			
				foreach($this->encoding as $enc){
					
					WriteToFile($file.'.'.$enc['type'],call_user_func($enc['function'],$contents));
				
				}
			
			}
			
			return true;
	
		}else return false;
	
	}
  
}