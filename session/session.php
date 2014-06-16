<?php
	// Connection, query execution, and SQL error handling class
	class Session Extends Instance {
		protected static $instance = NULL;
		
		public static function getCookies() {
			return Log::status(__CLASS__, __FUNCTION__, TRUE, array("cookie"=>$_COOKIE));
		}
		
		public static function setCookies() {
			$args = func_get_args();
			$args[2] = time() + $args[2] * 60;
			if(!isset($args[3])) $args[3] = "/";
			setcookie($args[0], $args[1], $args[2], $args[3]);
			return Log::status(__CLASS__, __FUNCTION__, TRUE, array("cookie"=>$_COOKIE));
		}
		
		public static function unsetCookies() {
			$args = func_get_args();
			if(!isset($args[1])) $args[1] = "/";
			setcookie($args[0], '', 1, $args[1]);
			unset($_COOKIE[$args[0]]);
			return Log::status(__CLASS__, __FUNCTION__, TRUE);
		}
	}
?>
