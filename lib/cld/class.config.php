<?php

class Cld_Config{
	
	private $File=array();
	private $Config;

	
	public function Add($file){

		if(is_file($file)) $this->Load($file);
	
	}
	
	public function Load($file){
		
		switch(Ext($file)){
			case 'php':
			  include($file);
			  break;
			case 'json':
			  $config=json_decode(file_get_contents($file),true);
			  break;
		}
		
		foreach($config as $k0=>$c){
			
			foreach($c as $k1=>$v){
				
				$this->Config[$k0][$k1]=$v;
			
			}
		
		}
		
	}
	
	public function Get($p=NULL){
		
		$v=$this->Config;
		
		if($p){

			$p=explode(".",$p);
			foreach($p as $i){
				$v=$v[$i];
			}
			
		}
		
		return $v;
	
	}
	
	public function Set($p,$v){
	
		$p=explode(".",$p);
		
		switch(count($p)){
			
			case 1:
			$this->Config[$p[0]]=$v; break;
			case 2:
			$this->Config[$p[0]][$p[1]]=$v; break;
		
		}
				
	}
		
}