<?php
/** 
* 
* 
* @author Andrew Womersley - aw1.me 
* @license http://www.gnu.org/licenses/gpl.html 
*/

class Cld_Request{

	public $Var=array();
	
	public function __construct(){
		
		foreach($_POST as $key=>$val) $this->Var[$key]=$val;
		
		foreach($_GET as $key=>$val) $this->Var[$key]=$val;
		
		foreach($this->Var as $key=>$val) $this->$key=$val;
		
	}
	
	function clean($var){
		
		$v=$this->{$var};
		
		$v=strip_tags($v);
		$v=htmlentities($v,ENT_QUOTES,"utf-8");
		$v=str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br/>", $v);
		$v=stripslashes($v);
		
		//STUPID WORD CHARS ‘ ’ “ ” -
		$v=str_replace("&amp;#8217;","&#39;",$v);
		$v=str_replace("&amp;#8216;","&#39;",$v);
		$v=str_replace("&amp;#8220;",'"',$v);
		$v=str_replace("&amp;#8221;",'"',$v);
		$v=str_replace("&amp;#8211;","-",$v);
		$v=str_replace("&amp;#8226;","&bull;",$v);
		$v=str_replace("&amp;#8230;","...",$v);
		
		return $v;
		
	}
	
}