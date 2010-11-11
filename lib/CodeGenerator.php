<?php

class CodeGenerator{

	private $_pattern;
	private $_codes;
	private $_quantity;
	private static $_chars = array('A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','T','U','V','W','X','Y');
	private static $_nums =  array(3,4,6,7,8,9);
	private static $_symbols = array('!','£','$','%','^','&','*','@','?','>','<','~','#');
	private static $_patterns = array('/(?<!\\\\)X/','/(?<!\\\\)x/','/(?<!\\\\)9/','/(?<!\\\\)\?/','/\\\\/');
	private static $_matchPattern = '/(\\\\[Xx9\?])|([^\\\\])/';

	public function __construct($pattern,$quantity){
		$this->_quantity = $quantity;
		$this->_pattern = $pattern;
	}

	public function generateCodes(){
		$this->_codes = array();

		for($n = 1; $n<=$this->_quantity;$n++){
			$code = $this->_generateCode();

			//if code already used keep generating codes until new unique code generated
			while(array_search($code,$this->_codes) != false){
				$code = $this->_generateCode();
			}
			$this->_codes[] = $code;
		}
	}

	public function outputCodes($format){
		switch($format){
			case 'csv' : $csv = new file_CSVHandler($this->_codes);
						 $csv->download($this->_quantity . "_unique_codes");
						 break;
		}
	}

	///////////////////
	//private methods//
	///////////////////
	private function _generateCode(){
		preg_match_all(self::$_matchPattern,$this->_pattern,$bits);
		foreach($bits[0] as &$char){
			$replacements = array(self::$_chars[rand(0,count(self::$_chars)-1)],strtolower(self::$_chars[rand(0,count(self::$_chars)-1)]),self::$_nums[rand(0,count(self::$_nums)-1)],self::$_symbols[rand(0,count(self::$_symbols)-1)],'');
			$char = preg_replace(self::$_patterns,$replacements,$char);
		}

		return implode('',$bits[0]);
	}

}
