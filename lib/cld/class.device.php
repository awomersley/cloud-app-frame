<?php
/** 
* Device class - gets device type
* 
* @author Andrew Womersley - aw1.me 
* @credit ua strings gathered from multiple sources
* @license http://www.gnu.org/licenses/gpl.html 
*/

class Cld_Device{
	
	public $type;
	
	public function __construct(){
		
		$regexp="mobile|android|blackberry|rim|iphone|ipod|ipad|palm|windows phone|kindle|pocket|psp|symbian|smartphone|wap|opera mini|crmo";
		$ua=strtolower($_SERVER['HTTP_USER_AGENT']);
		
		// perform check
		if(preg_match("/(".$regexp.")/i",$ua)) $this->type='mobile'; else $this->type='desktop';	
		
	}
	
	/** 
	 * checks if device is mobile
	 * 
	 * @return boolean is mobile (true|false)
	 */
	public function Mobile(){
	
		if($this->type=='mobile') return true; else return false;
	
	}
	
	/** 
	 * checks if device is desktop
	 * 
	 * @return boolean is desktop (true|false)
	 */
	public function Desktop(){
	
		if($this->type=='desktop') return true; else return false;
	
	}

}