<?php
/** 
 * flush directory
 * 
 * @param string $dir directory to flush
 */
 

 
function FlushDir($dir){

	$scan=scandir($dir);
	foreach($scan as $file){
	
		$path=$dir.$file;
		if(substr($file,0,1)!='.'){
		
			if(is_file($path)) unlink($path);
		
		}
	
	}

}



/** 
 * make directory
 * 
 * @param string $dir directory path to create
 */
function MakeDir($path,$dir){

	$dir=explode('/',$dir);
	
	foreach($dir as $d){
		if($d){
			if(!is_dir($path.'/'.$d)) mkdir($path.'/'.$d);
			$path.='/'.$d;
		}
	}

}

/** 
 * scan a directory and all sub directories
 * 
 * @param string $dir directory to scan
 * @param array $structure storage array for directories scanned
 * @return array directories and files found
 */
function Scan($dir,$structure=array()){

	$f=array(); $d=array();
	array_push($structure,array('tag'=>'ul'));
	
	// get directory structure
	$scan=scandir($dir);
	foreach($scan as $file){
	
		$path=$dir.$file;
		if(substr($file,0,1)!='.'){
		
			if(is_dir($path)) array_push($d,array('path'=>$path,'title'=>$file));
			if(is_file($path)) array_push($f,array('path'=>$path,'title'=>$file));
		
		}
	
	}
	sort($d); sort($f);
	
	// set html from template files
	foreach($d as $p){
	
		array_push($structure,array('tag'=>'li_dir','path'=>$p['path'],'title'=>$p['title']));
		$structure=Scan($p['path'].'/',$structure);
		array_push($structure,array('tag'=>'li_close'));
	
	}
	foreach($f as $p){
	
		array_push($structure,array('tag'=>'li_file','path'=>$p['path'],'title'=>$p['title']));
		array_push($structure,array('tag'=>'li_close'));
	
	}
	
	array_push($structure,array('tag'=>'ul_close'));
	
	return $structure;

}

/** 
 * get directory size
 * 
 * @param string $dir directory to scan
 * @param array $info storage array
 * @return array size=> filesize in bytes #, cnt=> file count, block=> filesize as block
 */
function Size($dir,$info=array('size'=>0,'cnt'=>0,'block'=>0)){

	$scan=scandir($dir);
	foreach($scan as $file){
	
		$path=$dir.$file;
		if(substr($file,0,1)!='.'){
		
			if(is_dir($path)) $size=Size($path,$info);
			if(is_file($path)){ $info['size']+=filesize($path); $info['cnt']++; }
		
		}
	
	}
	
	$info['block']=BytesToBlock($info['size']);
	return $info;

}