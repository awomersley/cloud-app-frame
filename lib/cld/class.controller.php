<?php
/** 
* Main controller class - sets all vars needed for page display 
* 
* @author Andrew Womersley - aw1.me 
* @license http://www.gnu.org/licenses/gpl.html 
*/

class Cld_Controller{
	
	protected $_Theme;
	protected $_View;
	protected $_Head=array('other'=>array());
	public $Headers=array();
	public $Encoding=array();
	
	public $Warnings=array();
	public $Var=array();
	public $Path;
	public $Env;
	public $Log;
	
	public $app;
	public $view;
	public $auth;
	public $device;
	public $args;
	public $resource=array('js'=>array(),'css'=>array());
	
	/** 
	 * global constructor for all controllers
	 * 
	 * @param object $app variable defined by App class
	 */
	public function __construct(){
		
		// debug message
		Debug($this);
		
		$this->Env=Config('Env');
		$this->Log=Config('Log');

		$this->Args=Config('Route.args');
		$this->File=Config('Route.file');
		
		$this->_Output=Cld::Output();
		
	}
	
	public function SetVar($var,$value){
		
		$this->_Output->SetVar($var,$value);
	
	}
	
	public function SetEncoding(){
		
		foreach(Cld::Cache()->encoding as $enc){
			
			if((is_file($this->File.$enc['ext']) || $this->_Output->Strg) && strstr($_SERVER['HTTP_ACCEPT_ENCODING'],$enc['type'])){
				$this->Encoding=$enc;
				$this->SetHeader('encoding',$enc['type']);
				break;
			}
			
		}
		
	}
	
	public function SetHeader($type,$header){

		$this->Headers[$type]=$header;
	
	}
	
	public function SendHeaders(){
		
		if($this->Headers['encoding']) 		header("Content-Encoding: ".$this->Headers['encoding']);
		if($this->Headers['attachment']) 	header("Content-Disposition: attachment; filename=".$this->Headers['attachment']);
		if($this->Headers['expires'])		header("Expires: ".date("D, d M Y H:i:s",$this->Headers['expires'])); 
		if($this->Headers['modified']) 		header("Last-Modified: ".date("D, d M Y H:i:s",$this->Headers['mod']));
		if($this->Headers['type']) 			header("Content-Type: ".$this->Headers['type']);
		if($this->Headers['length'])		header("Content-Length: ".$this->Headers['length']);
		
	}
	
	/** 
	 * initialises template display
	 */
	public function __destruct(){
		
		$this->_Output->Render();
		
		$this->SetHeader('type',MimeType($this->File));
		$this->SetEncoding();
		$this->SendHeaders();
 		ob_clean();
		
		if($this->_Output->HTML){
			
			if(function_exists($this->Encoding['function'])) echo call_user_func($this->Encoding['function'],$this->_Output->HTML);
			else echo $this->_Output->HTML;
		
		}else{
			
			readfile($this->File.$this->Encoding['ext']);
			
		}

	}
	
}