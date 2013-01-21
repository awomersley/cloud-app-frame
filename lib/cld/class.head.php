<?php

class Cld_Head{
	
	public $Css=array();
	public $Js=array();
	public $Fav=array();
	public $Keywords=array();
	public $Other=array();
	public $Title;
	public $Desc;
	public $Charset;
			
	public function AddJs($js){
		
		array_push($this->Js,$js);
		
	}
	
	public function AddCss($css){
	
		array_push($this->Css,$css);
	
	}
	
	public function AddFav($href,$rel='shortcut icon'){
	
		array_push($this->Fav,array('href'=>$href,'rel'=>$rel));
		
	}
	
	public function SetTitle($title){
		
		$this->Title=$title;
		
	}
	
	public function SetCharset($charset){
		
		$this->Charset=$charset;
		
	}
	
	public function SetDesc($desc){
		
		$this->Desc=$desc;
		
	}
	
	public function AddKeyword($keyword){
		
		$keywords=explode(',',$keyword);
		foreach($keywords as $k) array_push($this->Keywords,$k);
	
	}
	
	public function Add($other){
		
		array_push($this->Other,$other);
	
	}
	
	public function Render(){
		
		if($this->Title) 		$head.="<title>".$this->Title."</title>";
		if($this->Charset) 		$head.="<meta charset='".$this->Charset."'>";
		if($this->Desc) 		$head.="<meta name='description' content='".$this->Desc."' />";
		
		if($this->Keywords[0]){
			foreach($this->Keywords as $k) $keywords.=$k.',';
			$head.="<meta name='keywords' content='".$keywords."' />";
		}
		
		if($this->Fav[0]){
			foreach($this->Fav as $fav) $head.="<link rel='".$fav['rel']."' href='".$fav['href']."' />";
		}
		
		if($this->Js[0]){
			foreach($this->Js as $js) $head.="<script src='".$js."'></script>";
		}
		
		if($this->Css[0]){
			foreach($this->Css as $css) $head.="<link href='".$css."' rel='stylesheet' type='text/css' />";
		}
		
		if($this->Other[0]){
			foreach($this->Other as $other) $head.=$other;
		}
		
		return $head;
			
	}

}