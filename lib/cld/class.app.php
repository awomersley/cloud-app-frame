<?php
/** 
* App class - handles loading, router, dispatch, auth, debug, errors
* 
* @author Andrew Womersley - aw1.me 
* @license http://www.gnu.org/licenses/gpl.html 
*/

class Cld_App{
	
	public $App;
	private $Controller;
	private $Method;
	private $Args=array();
	private $Url;
	
	
	
	/** 
	 * class construct
	 * 
	 */
	public function __construct(){
	
		// debug message
		Debug($this);
	
	}	
	
	
	/** 
	 * app dispatcher
	 * 
	 */
	public function Dispatch(){
		
		/* check controller exists - if not, set default for app */
		if(!class_exists($this->Controller)){
			
			$default=Config('App.default');
			
			$this->Controller='Controller_'.ucfirst($default['controller']);
			$this->ControllerShort=$default['controller'];
			$this->Method=CamelCase($default['method']);
			$this->View=$default['controller'].'/'.$default['method'];
			
		}
		
		/* the app routes */
		Cld::Config()->Set('Route.app',$this->App);
		Cld::Config()->Set('Route.controller',$this->Controller);
		Cld::Config()->Set('Route.controllershort',$this->ControllerShort);
		Cld::Config()->Set('Route.method',$this->Method);
		Cld::Config()->Set('Route.view',$this->View);
		Cld::Config()->Set('Route.args',$this->Args);
		Cld::Config()->Set('Route.file',$this->File);
		Cld::Config()->Set('Route.url',$this->Url);
		
		/* dispatch controller */
		$Controller=new $this->Controller();
		if(!Cld::Cache()->Check($this->File)) $Controller->{$this->Method}();
	
	}
	
	public function Auth(){
		
		$auth=Cld::Auth()->Check($this->_Args[0]);
		
		if(!$auth) Redirect('/login');
		
		session_write_close();
		
	}
	
	
	public function Environment(){
		
		// apply settings
		if(Config('Env.dev')){ ini_set('display_errors','On'); }
		if(Config('Log.error')){ ini_set('log_errors','On'); ini_set('error_log',PATH_LOG.'error'); }

	}
	
			
	/** 
	 * app router
	 * 
	 */
	public function Router(){
		
		// request url
		$this->Url=(isset($_REQUEST['requrl'])) ? Request('requrl') : '/default';

		$ext=(Ext($this->Url)) ? Ext($this->Url) : 'html';
		
		if(strstr($this->Url,'.')) $this->Url=strstr($this->Url,'.',TRUE);
		
		foreach($this->routes as $route){
		
			$a=$route['alias'];
			$r=$route['route'];
			
			$a=preg_replace('/\\//','\\/',$a);
			$a=preg_replace('/\\*/','[A-Za-z0-9\\-\\_]+',$a);
			
			if(preg_match("/^".$a."/i",$this->Url)){

				$ap=explode("/",$route['alias']);
				$pp=explode("/",$this->Url,count($ap));
				$id=1;
				foreach($ap as $cnt=>$p){
					
					if($p=='*' || $p=='*$') { $r=str_replace("*".$id,$pp[$cnt],$r); $id++; }
					
				}
				
				$this->Url=$r;
			
			}
			
		}

		// explode to parts
		$dir=explode("/",$this->Url,5);

		// set components
		$this->Controller='Controller_'.ucfirst($dir[1]);
		$this->ControllerShort=$dir[1];
		$this->Method=CamelCase($dir[2]);
		$this->View=$dir[1].'/'.$dir[2];
		$this->Args[1]=(isset($dir[3])) ? $dir[3] : NULL;
		$this->Args[2]=(isset($dir[4])) ? $dir[4] : NULL;
		$this->Args[3]=$ext;
		$this->File=PATH_CACHE.Url(Config('Theme.theme').str_replace("/",".",$this->Url).".".Cld::Device()->type).'.'.$this->Args[3];
				
	}
	
}