<?php

class Cld_Factory{
	
	
	public static $_class=array();
	public static $_object=array();
	
	public function __callStatic($instance,$args){
		
		$alias=(!$args[0]) ? $instance : $args[0];
		
		return self::Init($instance,$alias);
		
	}
	
	
	public function Install($alias,$class,$dep=array()){
		
		self::$_class[$alias]['class']=$class;
		self::$_class[$alias]['dependencies']=$dep;

	}
	
	public function Init($instance,$alias){
		
		
		if(!is_object(self::$_object[$instance])){ // check if instance already created
			
			if(array_key_exists($alias,self::$_class)){ // check class is installed
				
				self::$_object[$instance]=new self::$_class[$alias]['class'];
				
				self::SetDependencies(self::$_object[$instance],self::$_class[$alias]['dependencies']);

			}else{
				//error - class not installed
			}
			
		}
		
		return self::$_object[$instance];
	
	}

	
	public function SetDependencies($instance,$dependencies){

		foreach($dependencies as $d=>$v){
			
			$instance->$d=$v;
			
		}
	
	}

}
