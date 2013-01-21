<?php

/** 
 * convert bytes to block
 * 
 * @param integer $bytes filesize to convert
 * @param integer $force force the block units
 * @return string filesize as block
 */
function BytesToBlock($bytes,$force=FALSE){
	
	if(!$bytes) return 0;
	
	$blocksize=false;
	$block=array('b','kb','mb','gb','tb');
	
	$i=0;
	while($blocksize==false){
	
		if((floor($bytes/1024)==0 && !$force) || $block[$i]==$force || $i==(count($block)-1)){ $blocksize=round($bytes,2); $blockunit=$block[$i]; }else{ $bytes=$bytes/1024; }
		$i++;
		
	}

	return $blocksize.$blockunit;

}

/** 
 * convert url to filename
 * 
 * @param string $url url of file
 * @return string filename
 */
function UrlToFname($url){

	$p=explode("/",$url);
	$f=$p[count($p)-1];
	
	if(strstr($f,'?') && strstr($f,'=')){
		$p=explode("=",$f);
		$f=$p[1];
	}
	
	return $f;

}

/** 
 * get filesize of url
 * 
 * @param string $url url of file
 * @return string filesize of url 
 */
function UrlToFsize($url){

	$h=get_headers($url,1);
	$h=array_change_key_case($h,CASE_LOWER);
	
	if(is_array($h['content-length'])){
		return $h['content-length'][count($h['content-length'])-1];
	}else{
		return $h['content-length'];
	}

}

/** 
 * write to file
 * 
 * @param string $f file to write to
 * @param string $c data to write to file
 * @param string $a whether to apend to current data (1|0)
 * @return string status of write
 */
function WriteToFile($f,$c,$a=0){

	$e=NULL;
	if($a){
		$e=file_get_contents($f);
		if($e) $e.="\r";
	}
	$fh=fopen($f,'w');
	$status=fwrite($fh,$e.$c);
	fclose($fh);
	return $status;

}
