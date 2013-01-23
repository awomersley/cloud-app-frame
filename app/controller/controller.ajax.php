<?
class Controller_Ajax extends Cld_Controller{
	
	public function __construct(){
		
		parent::__construct();
		
		$this->_Output->SetTemplate('ajax');
		
	}
	
	public function Foobar(){
		
		$this->_Output->SetHook('ajax','');
		
	}
	
}