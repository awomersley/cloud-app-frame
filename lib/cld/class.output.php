<?php
/** 
* Template class - handles the dispatch of the output
* 
* @author Andrew Womersley - aw1.me 
* @license http://www.gnu.org/licenses/gpl.html 
*/

class Cld_Output{
	
	
	public $Var=array();
	public $Hooks=array();
	public $Template;
	public $View;
	public $Head;
	
	public function __construct(){
		
		/* debug message */
		Debug($this);
		
		/* init classes */
		$this->_Cache=Cld::Cache();	
		$this->_Head=Cld::Head();
		$this->_Res=Cld::Resource();
		
		/* set charset */
		$this->_Head->SetCharset('utf-8');
		
	}
	
	public function SetHooks($hooks){
				
		foreach($hooks as $key=>$hook){
			
			if(!is_array($this->Hooks[$key])) $this->Hooks[$key]=array();
			
			foreach($hook as $h) array_push($this->Hooks[$key],$h);
		
		}
	
	}
	
	public function SetHook($hook,$module){
				
		if(!is_array($this->Hooks[$hook])) $this->Hooks[$hook]=array();
			
		array_push($this->Hooks[$hook],$module);
		
	}
	
	public function SetTemplate($template){
		
		/* search assets for base template file */
		$this->Template=Theme('tmpl/'.$template.'.template.php');
		
		/* set filename for template file to store/load in cache */
		$this->TemplateFile=PATH_CACHE.Url(Config('Theme.theme').str_replace("/",".",Config('Route.url')).".".Cld::Device()->type.'.'.$template.'.template.php');
		
	}
	
	public function SetVar($var,$value,$array=false){
		
		if($array){
			if(!is_array($this->Var[$var]))	$this->Var[$var]=array();
			array_push($this->Var[$var],$value);
		}else{
			$this->Var[$var]=$value;
		}
		
	}
	
	public function BuildTmpl(){
		
		if(is_file($this->Template)) $output=file_get_contents($this->Template,FILE_USE_INCLUDE_PATH);
		else $output='{{template.view}}';
		
		
		preg_match_all('/({{hook.)([A-Za-z0-9\\_\\.\\-]+)/',$output,$hooks);
		
		foreach($hooks[2] as $hook){
			
				
			$inc="<?php ";
			
			foreach($this->Hooks[$hook] as $module){
				
				$parts=explode("/",$module);
				
				$path='modules/'.$parts[0].'/'.$parts[1].'/'.$parts[1].'.php';
				
				if(Theme($path)) $inc.="include('".Theme($path)."');";
				
			}
			
			$inc.=" ?>";
			
			$output=str_replace('{{hook.'.$hook.'}}',$inc,$output);

		}
		
		
		/** Set js/css files */
		$this->_Head->AddJs($this->_Res->Set('js'));
		$this->_Head->AddCss($this->_Res->Set('css'));
		
		/** Set cld vars */
		$this->SetVar('CLD_head',$this->_Head->Render());
        $this->SetVar('CLD_debug',ob_get_clean());
        
		
		$this->_Cache->BuildFile($this->TemplateFile,$output,false);
	
	}
	
	public function BuildPage(){
		
		/* ensure buffer is clean */
		ob_clean();
		
		/* turn on output buffering */
		ob_start();
		
		extract(Cld::Request()->Var,EXTR_PREFIX_ALL,'VAR_REQ');
		extract($this->Var,EXTR_PREFIX_ALL,'VAR');
		
		
		/* include built template file from cache */
		include($this->TemplateFile);
		
		/* get html */
		$html=ob_get_clean();
		
		/* atempts to save file in cache - sets HTML if not */
		if($this->_Cache->BuildFile(Config('Route.file'),$html)) $this->HTML=$html;
		
	}
	
	public function Render(){
		
		if(!empty($this->Hooks)){
			
			if(!$this->_Cache->Check($this->TemplateFile)) $this->BuildTmpl();
			
			/* build page output */
			$this->BuildPage();
		
		}
	
	}
	
}