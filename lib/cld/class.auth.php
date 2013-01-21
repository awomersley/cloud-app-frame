<?php
/** 
* Pwd Auth Class - simple password verification
* 
* @author Andrew Womersley - aw1.me 
* @license http://www.gnu.org/licenses/gpl.html 
*/

class Cld_Auth{

	public $authed;
	public $password;
	public $hash;
	public $default;
	public $exceptions;
	
	
	/** 
	 * class construct
	 * 
	 
	 * @param string $default default security setting (secure|insercure)
	 * @param string $pwd encoded password
	 * @param array $exceptions urls excluded from default setting as reg exp
	 * @return login status 
	 */
	public function SetHash(){
		
		// create password/session hash - used to check page auth
		$this->hash=crypt(session_id(),$this->password);
	
	}
	
	/** 
	 * perform authorisation check and set var authed
	 * 
	 * @param string $page current page in 'controller/method' format
	 */
	public function Check($page){
		
		if(!$this->hash) $this->SetHash();
		
		$exception=false;
		
		foreach($this->exceptions as $e){
		
		  if(preg_match("/(".$e.")/i",$page)) $exception=true;
		  
		}
		
		if((!$this->req_password) || ($this->default=='secure' && $exception) || ($this->default=='insecure' && !$exception)){
		  
		  $this->authed=1;
		
		}else{
			
		  if(!empty($_SESSION['pwdAuth'])){
			  
			  // check hash's match - set log in
			  if($_SESSION['pwdAuth']==$this->hash) $this->authed=1; else $this->authed=0;
		  
		  }else{
		  
			  // if session isn't set - auth has to fail
			  $this->authed=0;
		  }
		
		}
		
		return $this->authed;
		
	}
	
	/** 
	 * login
	 * 
	 * @return string encoded password (if login true) 
	 * @return string password (if login false) 
	 */
	public function Login(){
	
		$pwd=Request('pwd');
		
		// check if user enter password matches stored password
		if(crypt($pwd,$this->password)==$this->password){
			
			// set session with hash
			session_start();
			$_SESSION['pwdAuth']=$this->hash;
			session_write_close();
			return $this->hash;
		
		}else{
			return $pwd; // return bad password for logging
		}
	
	}
	
	/** 
	 * updates session variable if user updates password via settings
	 * 
	 * @param string $pwd new crypted password
	 */
	public function Set($pwd){
	
		$_SESSION['pwdAuth']=crypt(session_id(),$pwd);
	
	}

}