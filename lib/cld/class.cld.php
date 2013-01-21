<?php

class Cld{
  
	private static $_Factories=array();
	private static $_Factory;

	public function __callStatic($instance,$args){
		
		$alias=(!$args[0]) ? $instance : $args[0];

		return self::$_Factory->Init($instance,$alias);
		
	}
	
	public function Factory(){

		return self::$_Factory;
	
	}
	
	public function SetFactory($alias){
	  
		self::$_Factory=self::$_Factories[$alias];
	
	}
	
	public function InstallFactory($alias,$class,$set=1){
	  
	  	self::$_Factories[$alias]=new $class;
	 	if($set) self::SetFactory($alias);
	
	}
	
	public function Install($factory){
		
		include($factory);
		
		foreach($CldClass as $v){
			
			Cld::Factory()->Install($v['Alias'],$v['Class'],$v['Properties']); //$props
		
		}
	
	}
	
}