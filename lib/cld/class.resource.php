<?php

class Cld_Resource{
	
	protected $_Res=array('js'=>array(),'css'=>array());
	public $Paths;
	
	public function __construct(){
	
		$this->_Cache=Cld::Cache();		
	
	}
	
	/** 
	 * adds asset in to template
	 * 
	 * @param string $t type of assets (css|js|fav|img|font)
	 * @param string $f path to asset
	 * @param string $m minify the asset (true|false)
	 */
	public function Add($t,$f){
		
		array_push($this->_Res[$t],array('file'=>$f));
	
	}
	
	/** 
	 * gets filename of needed assets
	 * 
	 * @param string $type type of assets to get (js|css)
	 */
	public function Set($type){
	
		$mod=NULL;
		
		// calculates the last modifed time for each needed asset
		foreach($this->_Res[$type] as $a){

			if(is_file($a['file'])) $mod+=filemtime($a['file']);
			else if(Theme($type.'/'.$a['file'])) $mod+=filemtime(Theme($type.'/'.$a['file']));
		
		}
		
		$file=$mod.'.'.$type;
		
		// check if asset file exists - if not make
		if(!is_file(PATH_CACHE.$file)) $this->Make($type,$file);
		
		return '/res/'.$file;
	
	}
	
	/** 
	 * creates asset
	 * 
	 * @param string $type type of assets to make (js|css)
	 * @param string $file filename to write assets to
	 */
	public function Make($type,$file){
	
		$contents=NULL;
		
		// get contents of each needed asset
		foreach($this->_Res[$type] as $a){
			
			if(is_file($a['file'])) $c=file_get_contents($a['file']);
			else if(Theme($type.'/'.$a['file'])) $c=file_get_contents(Theme($type.'/'.$a['file']));
		  
			$contents.=$c;
		
		}
		
		if($contents) $this->_Cache->BuildFile(PATH_CACHE.$file,$contents);
		
	}

}