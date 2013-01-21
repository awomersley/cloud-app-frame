<?php
/** 
* Hash class - encodes/decodes a string
* 
* @author Andrew Womersley - aw1.me 
* @license http://www.gnu.org/licenses/gpl.html 
*/

class Cld_Hash{
	
	/** 
	 * class construct
	 * 
	 * @param string $key encoding key
	 * @param string $str string to encode
	 * @return encoded string 
	 */
	function Encode($str) {
	
		$hash=NULL;
		$cnt=0;
		
		for ($i=0;$i<strlen($str);$i++) {
		
			$ascii=ord(substr($str,$i,1))+ord(substr($key,$cnt,1));
			
			$hash.=chr($ascii);
			
			$cnt++;
			if($cnt==strlen($key)) $cnt=0;
		
		}
		
		// return url safe hash
		return str_replace(array('/','+','='),array('_','-',''),base64_encode($hash));
	
	}
	
	/** 
	 * class construct
	 * 
	 * @param string $key decoding key
	 * @param string $hash hash to decode
	 * @return decoded string 
	 */
	function Decode($hash) {
	
		$str=NULL;
		$cnt=0;
		
		// revert url safe chars
		$hash=base64_decode(str_replace(array('_','-'),array('/','+'),$hash));
		
		for($i=0;$i<strlen($hash);$i++){
		
			$ascii=ord(substr($hash,$i,1))-ord(substr($key,$cnt,1));
			
			$str.=chr($ascii);
			
			$cnt++;
			if($cnt==strlen($key)) $cnt=0;
		
		}
		
		return $str;
	
	}

}