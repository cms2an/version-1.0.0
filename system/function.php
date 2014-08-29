<?php if (!defined("CMS")) die('Direct access to this location is not allowed.');
//register global harus mati
function unregister_globals(){
	$args = func_get_args();
  	foreach($args as $k => $v){
    	if(array_key_exists($k, $GLOBALS)) unset($GLOBALS[$k]);
	}
}
//Remove/Clean Magic Quote
function remove_magic_quotes($array){
  	foreach ($array as $k => $v){
  		$array[$k] = is_array($v) ? remove_magic_quotes($v) : stripslashes($v);
	}
  	return $array;
}
//Validate Hostname
function validate_hostname($host) {
	return preg_match('/^\[?(?:[a-z0-9-:\]_]+\.?)+$/', $host);
}
//FILTER SANITIZE
function filter($string, $trim = false, $int = false, $str = false){
	$string = filter_var($string, FILTER_SANITIZE_STRING);
    $string = trim($string);
    $string = stripslashes($string);
    $string = strip_tags($string);
    $string = str_replace(array('æ', 'Æ', 'ô', 'ö'), array("'", "'", '"', '"'), $string);      
	if ($trim) $string = substr($string, 0, $trim);
  	if ($int) $string = preg_replace("/[^0-9\s]/", "", $string);
  	if ($str) $string = preg_replace("/[^a-zA-Z\s]/", "", $string);	
	return $string;
}
//SEF TITLE
function seftitle($string) {
	$string = str_replace(' ', '-', $string);
	$string = preg_replace('/[^0-9a-zA-Z-_]/', '', $string);
	$string = str_replace('-', ' ', $string);
	$string = preg_replace('/^\s+|\s+$/', '', $string);
	$string = preg_replace('/\s+/', ' ', $string);
	$string = str_replace(' ', '-', $string);
	return strtolower($string);
}
//Redirect
function redirect_to($url){
	header("location: ".$url);
	exit;
}
//is Serialize Part 1
function isSerialized($s){
	if(	stristr($s, '{' ) != false && stristr($s, '}' ) != false && stristr($s, ';' ) != false && stristr($s, ':' ) != false){
    	return true;
	}else{
    	return false;
	}
}
//is Serialize Part 2
function is_serialized($value, &$result = null){
	// Bit of a give away this one
	if (!is_string($value)){
		return false;
	}
 	// Serialized false, return true. unserialize() returns false on an
	// invalid string or it could return false if the string is serialized
	// false, eliminate that possibility.
	if ($value === 'b:0;'){
		$result = false;
		return true;
	}
 	$length	= strlen($value);
	$end	= '';
 	switch ($value[0]){
		case 's':
		if ($value[$length - 2] !== '"'){
			return false;
		}
		case 'b':
		case 'i':
		case 'd':
			// This looks odd but it is quicker than isset()ing
			$end .= ';';
		case 'a':
		case 'O':
			$end .= '}';
 			if ($value[1] !== ':'){
				return false;
			}
 			switch ($value[2]){
				case 0:
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				break;
 				default:
					return false;
			}
		case 'N':
			$end .= ';';
 			if ($value[$length - 1] !== $end[0]){
				return false;
			}
		break;
 		default:
			return false;
	}
 	if (($result = @unserialize($value)) === false){
		$result = null;
		return false;
	}
	return true;
}
//Get Param Option pages
function param_option($str, $strShow)
{
	if(is_serialized($str)){
		$arr = unserialize($str);
		foreach($arr as $key => $value){
			if($strShow == $key) return $value;
		}
	}
}
//Check info status row
function check_info($row, $status){
	if ($row == $status) echo "checked=\"checked\"";
}
//pre for debugging code
function pre($arr){
	print '<pre>' . print_r($arr, true) . '</pre>';
}
?>
