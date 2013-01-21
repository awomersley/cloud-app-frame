<?
class Controller_Ajax extends Cld_Controller{
	
	public function __construct(){
		
		parent::__construct();
		
		$this->_Output->SetTemplate('ajax');
		
	}
	
	public function ScanDir(){
		
		$sites=Config('sites');
		
		$Ftp=Cld::FileManager();
				
		$site=$Ftp->SetPath($sites[Cld::Request()->site]);
		
		$this->SetVar('filelist',$Ftp->Scan($site,Cld::Request()->path,false));
		
		$this->_Output->SetHook('ajax','clide/files-list');
		
	}
	
}