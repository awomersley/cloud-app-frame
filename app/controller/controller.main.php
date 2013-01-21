<?
class Controller_Main extends Cld_Controller{
	
	public function __construct(){
		
		parent::__construct();

		$this->_Output->_Head->SetTitle('Cld Dir');
		$this->_Output->_Head->SetDesc('Cloud Dir');
		
		/* set js */
		$this->_Output->_Head->AddJs('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
		
	
		/* set css */
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
		
		$this->_Output->SetVar('ftpuser','ftp');
		$this->_Output->SetVar('ftpip','aw1.me');
		$this->_Output->SetVar('ftppath','/var/www/html/cld.aw1.me/html/');
		
		$this->_Output->SetHooks(array(
									'page-top'=>		array(),
									'pre-head'=>		array(''),
									'post-head'=>		array(''),
									'header'=>			array('template/header'),
									'col1'=>			array('clide/sites'),
									'col2'=>			array('clide/files'),
									'col3'=>			array('clide/editor-holder'),
									'footer'=>			array(),
									'page-btottom'=>	array()
								)
						);
		
		
	}
	
	public function Edit(){
		
		$this->_Output->_Head->AddJs('/lib/ace/src/ace.js');
		
		$this->_Output->_Res->Add('js','clide_editor.js');
		
		$this->_Output->_Res->Add('css','clide_editor.css');
		
		
		
		$Ftp=Cld::FileManager();
		$sites=Config('sites');	
		
				
		$this->_Output->SetHooks(array(
									'page-top'=>		array(),
									'pre-head'=>		array(),
									'post-head'=>		array(),
									'header'=>			array(),
									'col1'=>			array('clide/editor'),
									'col2'=>			array(),
									'col3'=>			array(),
									'footer'=>			array(),
									'page-btottom'=>	array()
								)
						);
		
		
	}

}