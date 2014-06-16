<?php
	
	// For Firebug PHP (FirePHP) logging
	class Log {
		// Default location to search for FirePHP core class file
		public static $FrameworkURL = './FirePHPCore/FirePHP.class.php';
		
		// By default, set to false for production, change with 'Log::$blnDebug = TRUE;' to enable all status messages to be shown
		public static $blnDebug = FALSE;
		public static $blnErrors = FALSE;
		
		// Status array
		public static $status = array();
		
		public static function status() {
			$args = func_get_args(/*class name, function name, success?, optional: error, optional: array(data)*/);
			$id = count(self::$status);
			if(count($args >= 3)) {
				self::$status[$id]["class"] = $args[0];
				self::$status[$id]["function"] = $args[1];
				self::$status[$id]["success"] = ($args[2] ? "TRUE" : "FALSE");
				if(isset($args[3]) && !empty($args[3]) && is_string($args[3])) {
					self::$status[$id]["message"] = $args[3];
					if(isset($args[4]) && !empty($args[4])) self::$status[$id]["data"] = $args[4];
				}
				elseif(isset($args[3]) && !empty($args[3])) self::$status[$id]["data"] = $args[3];
				
				if(self::$blnDebug || (self::$blnErrors && self::$status[$id]["success"] == "FALSE")) self::toScreen(self::$status[$id]);
				
				return $id;
			}
		}
		
		public static function toScreen($obj = '', $label = '') {
			
			if(file_exists(self::$FrameworkURL) && (self::$blnDebug|| self::$blnErrors)) {
				include_once(self::$FrameworkURL);
				$FirePHP = FirePHP::getInstance(true);
				$FirePHP->log($obj, $label);
			}
		}
	}
?>
