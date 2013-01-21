<?php

class Controller_Display extends Cld_Controller{
	
	public function Cache(){
		
		$this->File=PATH_CACHE.$this->Args[1].'.'.$this->Args[3];
		
	}
	
	public function Theme(){
		
		$this->File=Theme($this->Args[1].'/'.$this->Args[2].'.'.$this->Args[3]);
		
	}
	
	public function Lib(){
		
		$this->File=Lib($this->Args[1].'/'.$this->Args[2].'.'.$this->Args[3]);
	
	}
	
}