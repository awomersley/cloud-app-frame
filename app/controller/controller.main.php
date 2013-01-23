<?
class Controller_Main extends Cld_Controller{
	
	public function __construct(){
		
		parent::__construct();
        
        /** Set page meta */
		$this->_Output->_Head->SetTitle('Cloud App Frame');
		$this->_Output->_Head->SetDesc('Cloud App Frame');
		
		/** Set js */
		$this->_Output->_Head->AddJs('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
		
	
		/** Set css */
		$this->_Output->_Res->Add('css','clide.css');
		$this->_Output->_Res->Add('css','fonts/open-sans-300.css');
		$this->_Output->_Res->Add('css','fonts/open-sans-400.css');
		$this->_Output->_Res->Add('css','fonts/open-sans-700.css');
		
		/* set template*/
		$this->_Output->SetTemplate('desktop');
		$this->_Output->SetVar('templatemode','2-col');
		
	}
	
	public function Index(){
		
		$this->_Output->_Res->Add('js','clide.js');
		
		$this->_Output->SetVar('pagetitle','Cloud App Frame');
		
		$this->_Output->SetHooks(array(
									'page-top'=>		array(),
                                    'head'=>    		array('template/head'),
									'header'=>			array('template/header'),
									'col1'=>			array(''),
									'col2'=>			array(''),
									'col3'=>			array(''),
									'footer'=>			array(),
									'page-bottom'=>	    array('template/debug')
								)
						);
		
		
	}

}