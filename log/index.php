<?php
	
	// For Firebug PHP (FirePHP) logging
	class LOG {
		// Default location to search for FirePHP core class file
		public static $FrameworkURL = './FirePHPCore/FirePHP.class.php';
		
		public static $blnLog = FALSE;
		
		// By default, set to false for production, change with 'Log::$blnDebug = TRUE;' to enable all status messages to be shown
		public static $blnDebug = FALSE;
		public static $blnErrors = FALSE;
		
		// Status array
		public static $status = array();
		public static $statusLast = NULL;
		
		public static function status() {
			$args = func_get_args(/*class name, function name, success[, error message, array(data)]*/);
			if(count($args >= 3)) {
				$status["class"] = $args[0];
				$status["function"] = $args[1];
				$status["success"] = ($args[2] ? "TRUE" : "FALSE");
				if(isset($args[3]) && !empty($args[3]) && is_string($args[3])) {
					self::$status["message"] = $args[3];
					if(isset($args[4]) && !empty($args[4])) $status["data"] = $args[4];
				}
				elseif(isset($args[3]) && !empty($args[3])) $status["data"] = $args[3];
				
				//if(self::$blnDebug || (self::$blnErrors && $status["success"] == "FALSE")) self::toScreen($status);
				if($blnLog) {
					$id = count(self::$status);
					self::$status[$id] = $status;
					//self::$statusLast = $status;
					return $id;
				}
				else {
					self::$statusLast = $status;
					return $status;
				}
			}
		}
		/*// FirePHPCore
		public static function toScreen($obj = '', $label = '') {
			
			if(file_exists(self::$FrameworkURL) && (self::$blnDebug || self::$blnErrors)) {
				include_once(self::$FrameworkURL);
				$FirePHP = FirePHP::getInstance(true);
				$FirePHP->log($obj, $label);
			}
		}*/
	}
?>
