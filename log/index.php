<?php
	
	// For Firebug PHP (FirePHP) logging
	class LOG {
		// Default location to search for FirePHP core class file
		public static $FirePHPCoreURL = "";
		
		// Save all logs and return IDs
		public static $blnLog = FALSE;
		
		// By default, set to false for production, change with 'Log::$blnDebug = TRUE;' to enable all status messages to be shown
		public static $blnDebug = FALSE;
		public static $blnErrors = FALSE;
		
		// Status array
		public static $status = array();
		public static $statusLast = NULL;
		
		public static function status() {
			$args = func_get_args(/* string __class__, string __function__, bool success[, error_message, array(data)] */);
			if(count($args >= 3)) {
				$status["class"] = $args[0];
				$status["function"] = $args[1];
				$status["success"] = ($args[2] ? "TRUE" : "FALSE");
				if(isset($args[3]) && !empty($args[3]) && is_string($args[3])) {
					$status["message"] = $args[3];
					if(isset($args[4]) && !empty($args[4])) $status["data"] = $args[4];
				}
				elseif(isset($args[3]) && !empty($args[3])) $status["data"] = $args[3];
				
				self::$statusLast = $status;
				if(self::$blnDebug || (self::$blnErrors && $status["success"] == "FALSE")) self::toConsole($status);
				if($blnLog) {
					$id = count(self::$status);
					self::$status[$id] = $status;
					return $id;
				}
				else {
					//self::$statusLast = $status;
					return $status;
				}
			}
		}
		// FirePHPCore
		public static function toConsole($obj, $type = '') {
			if(empty(self::$FirePHPCoreURL)) self::$FirePHPCoreURL = realpath(dirname(__file__) . '/FirePHPCore/FirePHP.class.php');
			if(file_exists(self::$FirePHPCoreURL) && (self::$blnDebug || self::$blnErrors) && !headers_sent()) {
				include_once(self::$FirePHPCoreURL);
				$FirePHPCore = FirePHP::getInstance(true);
				$FirePHPCore->fb($obj, (empty($type) ? (filter_var($obj["success"], FILTER_VALIDATE_BOOLEAN) ? FirePHP::LOG : FirePHP::ERROR) : $type));
			}
		}
	}
?>
