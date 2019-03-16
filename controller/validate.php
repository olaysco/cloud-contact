<?php

/********
**
**This class is used for form input validation
**
*********/
class Validate{


	/* 
	*  validates if arguments is of string type
	*  and also checks the length is upto min value
	*  and lesser or equal to maximum value
	*/
	static function isString($val, $min=null, $max=null){
		$val = filter_var($val, FILTER_SANITIZE_STRING);
		$bool = false;
		if(!empty($val) && is_string($val)){
			$bool = true;
			$length = strlen($val);

			if($min !== null){ $bool = ($length>=$min); };	

			if($max !== null){ $bool = ($length<=$max); };
		}
		return $bool;
	}

	/* validates if arguments passed
	*  is empty
	*/
	static function isEmpty($val){
		$bool = false;
		if(empty($val) || is_null($val) || $val == ''){
			$bool = true;
		}
		return $bool;
	}

	/* validates if arguments is a valid email
	*/
	static function isEmail($val){
		$val = filter_var($val, FILTER_SANITIZE_EMAIL);
		$bool = false;
		if(self::isEmpty($val)){
			$bool = false;
		}else if(filter_var($val, FILTER_VALIDATE_EMAIL)){
			$bool = true;
		}

		return $bool;
	}

	/* 
	* validates if arguments is of int type
	*  and meets specified min and max value
	* if passed as parameters
	*/
	static function isInt($val, $min=null, $max=null){
		$val = filter_var($val, FILTER_SANITIZE_NUMBER_INT);
		$bool = false;
		
		if(filter_var($val, FILTER_VALIDATE_INT)){
			$bool = true;
			$length = strlen($val);
			if($min !== null){ $bool = ($length>=$min);	}

			if($max !== null){ $bool = ($length<=$max); }
		}
		return $bool;
	}
	
	static function isPhone($val){
		$val = filter_var($val, FILTER_SANITIZE_NUMBER_INT);
		$bool = false;
		$length = strlen($val);
		var_dump($length);
		if($length >=10 && $length <=14 ){
			$bool = preg_match("/^[0-9]{10,14}+$/", $val);
		}
		return $bool;
	}

	/* validates if arguments is of boolean type
	*  notes this doesnt check the boolean value either
	*  true or false
	*/
	static function isBoolean($val){
		return is_bool($val);
	}

	/* validates if arguments is a valid password
	*  contains uppercase
	*  contains lowercase
	*  contains number
	*  contains chars
	*  legth of 8 or more
	*/
	static function isValidPassword($val){
		$bool = false;
		$val = filter_var($val, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		if(self::isEmpty($val) || strlen($val)<8){
			$bool = false;
		}else{
			$uppercase = preg_match('@[A-Z]@', $val);
			$lowercase = preg_match('@[a-z]@', $val);
			$number = preg_match('@[0-9]@', $val);
			$chars = preg_match('@[^\w]@', $val);

			if(!$uppercase || !$lowercase || !$number || !$chars){
				$bool = false;
			}else{
				$bool = true;
			}
	}

		return $bool;
	}
}

?>