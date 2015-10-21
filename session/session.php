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
			if(!isset($args[4])) $args[4] = (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);
			if(!isset($args[5])) $args[5] = 0;
			setcookie($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
			return Log::status(__CLASS__, __FUNCTION__, TRUE, array("args"=>$args, "cookie"=>$_COOKIE[$args[0]]));
		}
		
		public static function unsetCookies() {
			$args = func_get_args();
			if(!isset($args[1])) $args[1] = "/";
			if(!isset($args[2])) $args[2] = (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);
			if(!isset($args[3])) $args[3] = 0;
			setcookie($args[0], '', 1, $args[1], $args[2], $args[3]);
			unset($_COOKIE[$args[0]]);
			return Log::status(__CLASS__, __FUNCTION__, TRUE);
		}
	}
?>
