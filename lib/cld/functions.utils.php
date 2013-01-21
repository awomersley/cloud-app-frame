<?php

function a2o($a){

	if(is_array($a)){
	
		$o=new stdClass();
		foreach($a as $p=>$v){ if($p) $o->$p=Utils::a2o($v); }
		return $o;
	
	}else{ return $a; }

}


/** 
 * convert string to camel case
 * 
 * @param string $str string to convert
 * @return converted string
 */
function CamelCase($str){

	$cc=NULL;
	$str=str_replace(array('-','_')," ",$str);
	$words=explode(" ",$str);
	foreach($words as $w) $cc.=ucfirst($w);
	return $cc;

}

function Config($v){
	
	return Cld::Config()->Get($v);
	
}

/** 
 * app debugging
 * 
 * @param object $c class object
 * @param string $c debug message
 */
function Debug($c){

	if(is_object($c)) echo "Called class: ".get_class($c)."<br/>";
	else echo $c."<br/>";

}

/** 
 * error handler
 * 
 * @param string $erorr error type
 */
function Error($error=NULL){

	$code=303;
	
	switch($error){
	
		case 'db':
		  $url='/error/database'; break;
		case '404':
		  $url='/error/page-not-found'; $code=404; break;
		default:
		  $url='/error/server-says-no';
	
	}

	if(DEV_MODE) echo "Error: ".$url."<br/>"; 
	else Utils::Redirect($url,$code);

}

function Ext($file){

	return strtolower(substr(strrchr($file,"."),1));

}

/** 
 * fatal error handler
 * 
 * @param string $error error message
 */
function Fatal($error){
	
	header("Content-Encoding: none");
	ob_end_flush();
	echo "Fatal Error Occured: ".$error;
	exit;

}

function Lib($f){
  
  $path=PATH_LIB.'vendor/'.$f;

  if(is_file($path)) return $path;

  return false;
  
}


/** 
 * download file
 * 
 * @param string $file file to download
 */
function MimeType($file){

	switch(Ext($file)) {
		case "pdf": $ctype="application/pdf"; break;
		case "exe": $ctype="application/octet-stream"; break;
		case "zip": $ctype="application/zip"; break;
		case "doc": $ctype="application/msword"; break;
		case "xls": $ctype="application/vnd.ms-excel"; break;
		case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
		case "gif": $ctype="image/gif"; break;
		case "png": $ctype="image/png"; break;
		case "jpeg":
		case "jpg": $ctype="image/jpg"; break;
		case "mp3": $ctype="audio/mpeg"; break;
		case "wav": $ctype="audio/x-wav"; break;
		case "mpeg":
		case "mpg":
		case "mpe": $ctype="video/mpeg"; break;
		case "mov": $ctype="video/quicktime"; break;
		case "avi": $ctype="video/x-msvideo"; break;
		case "woff": $ctype="application/x-font-woff"; break;
		case "ttf": $ctype="application/x-font-ttf"; break;
		case "js": $ctype="application/javascript"; break;
		case "css": $ctype="text/css"; break;
		case "ico": $ctype="image/x-icon"; break;
		case "php": $ctype="application/x-httpd-php"; break;
		case "html": $ctype="text/html"; break;
		case "ajax": $ctype="text/html"; break;
		default: $ctype="application/force-download";
	}
	
	return $ctype;

}

/** 
 * minify code - strip comments, line breaks, whitespace
 * 
 * @param string $c string to minify
 * @return minified string 
 */
function Minify($c){

	$c=preg_replace("/(\\ |\t)\\/\\/.*\\\n/", '', $c); //removes these comments
	$c=preg_replace("/\\/\\*.*\\*\\/\\\n/", '', $c); /* removes these comments */
	$c=str_replace(array("\r\n", "\r", "\n","\t",'  ', '    ', '    '), '', $c);
	return $c;

}

/** 
 * http header redirect
 * 
 * @param string $url url to redirect to
 * @param string $code http response code
 */
function Redirect($url,$code=303){

	if($code==301) header("HTTP/1.1 301 Moved Permanently");
	if($code==303) header("HTTP/1.1 303 See Other");
	if($code==404) header("HTTP/1.1 404 Not Found");
	header("Location: ".$url);
	exit;

}

/** 
 * string replace
 * 
 * @param string $str string to examine
 * @param array $replace strings to find and replace
 * @return string modified string
 */
function Replace($str,$replace){

	foreach($replace as $r){
		$str=str_replace($r['str'],$r['rep'],$str);
	}
	
	return $str;

}

/** 
 * gets var from http post/get
 * 
 * @param string $x var to get
 * @param int $charset charachter set to parse variable with
 * @return mixed var
 */
function Request($x,$charset=1){

	if(!empty($_REQUEST[$x])){
	
		$v=$_REQUEST[$x];
		
		if($charset==1) $v=preg_replace("/[^A-Za-z0-9\\_\\ \\.\\/\\:\\%\\=\\?\\-]/i", "", $v); 
		if($charset==2) $v=preg_replace("/[^A-Za-z0-9\\_\\.\\/\\-]/i", "", $v); 
		
		return $v;
	
	}else{
		return FALSE;
	}

}

function Text($str){
	
	$str=strtolower(preg_replace("/[^A-Za-z0-9]/i", "", $str));
	return $str;

}

function Theme($f){
  
  $path=PATH_THEME.Config('Theme.theme').'/'.$f;

  if(is_file($path)) return $path;

  return false;
  
}




function Url($str){
	
	$str=strtolower(preg_replace("/[^A-Za-z0-9\\_\\.\\-]/i", "", $str));
	return $str;

}