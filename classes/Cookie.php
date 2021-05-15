<?php 
class Cookie{
	public static function exists($name){
		return (isset($_COOKIE[$name])) ? true :false;
	}
	public static function put($name,$value){
		return setcookie($name,$value,time()+3600);
	}
	public static function get($name){
		return $_COOKIE[$name];
	}
	public static function delete($name){
		if(self::exists($name)){
			unset($_COOKIE[$name]);
		}
	}
}
?>