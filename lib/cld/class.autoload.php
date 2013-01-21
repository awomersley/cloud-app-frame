<?php

class Cld_Autoload{

	public static function Init(){
	
		spl_autoload_extensions('.php');
		
		spl_autoload_register('self::Cld');
		spl_autoload_register('self::Controller');
		spl_autoload_register('self::Model');
		spl_autoload_register('self::Lib');
		
		self::Functions(PATH_CLD);
		
	}
	
	public static function Functions($dir){
		
		$files=scandir($dir);
		
		foreach($files as $f){
			
			if(strstr($f,'functions.')) self::Load($dir.$f);
		
		}
		
	}
	
	public static function Load($file){
	
		$file=strtolower($file);
		
		if(is_file($file)) return include($file); else return false;
	
	}
	
	public static function Cld($class){
	
		$file=PATH_CLD.'class.'.preg_replace('/Cld_/','',$class).'.php';
		return self::Load($file);
		
	}
	
	public static function Controller($class){
		
		$file=PATH_APP.'controller/'.preg_replace('/_/','.',$class).'.php';
			
		if(self::Load($file)) return true;
			
		return false;
				
	}
	
	public static function Model($class){
	
		$file=PATH_APP.'model/'.preg_replace('/_/','.',$class).'.php';
			
		if(self::Load($file)) return true;
			
		return false;
		
	}
	
	public static function Lib($class){
	
		$file=PATH_CLD.$class.'/'.$class.'.php';
		return self::Load($file);
		
	}
	
}