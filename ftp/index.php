<?php
	// Connection, query execution, and SQL error handling class
	class FTP Extends Instance {
		protected static $instance = NULL;
		
		// Database credentials
		protected static $defaults = array();
		protected $connection = array();
		
		// Query strings
		public $result;
		
		public static function setDefaults($host, $user, $pass) {
			self::$defaults = array(
				"host"=>$host,
				"user"=>$user,
				"pass"=>$pass
			);
		}
		
		public function connect() {
			if (func_num_args() > 0) {
				$args = func_get_args();
				$this->connection = array();
				$this->connection["host"] = $args[0];
				if(func_num_args() > 1) $this->connection["user"] = $args[1];
				if(func_num_args() > 2) $this->connection["pass"] = $args[2];
			}
			else $this->connection = self::$defaults;
			// Connect to the server
			try {
				$this->connection["handle"] = ftp_connect($this->connection["host"]);
				@ftp_login($this->connection["handle"], $this->connection["user"], $this->connection["pass"]);
				return Log::status(__CLASS__, __FUNCTION__, FALSE, "Level 1 (FTP Connection) Error.", array("connection"=>$this->connection));
			}
			catch(Exception $e) {
				return Log::status(__CLASS__, __FUNCTION__, TRUE, "Level 1 (FTP Connection) Successful.", array("handle"=>$this->connection));
			}
		}
		
		public function disconnect() {
			@ftp_close($this->connection["handle"]);
		}
		
		public function put() {
			$args = func_get_args();
			
			if(isset($args[0]) && !empty($args[0])) $from = $args[0];
			if(isset($args[1]) && !empty($args[1])) $to = $args[1];
			if(isset($args[2]) && !empty($args[2])) $mode = $args[2];
			else $mode = FTP_ASCII;
			
			if(ftp_put($this->connection["handle"], $to, $from, FTP_BINARY)) return Log::status(__CLASS__, __FUNCTION__, TRUE, "Level 2 (FTP Put) Successful.", array("handle"=>$this->connection["handle"], "from"=>$from, "to"=>$to, "mode"=>$mode));
			else return Log::status(__CLASS__, __FUNCTION__, FALSE, "Level 2 (FTP Put) Error.", array("handle"=>$this->connection["handle"], "from"=>$from, "to"=>$to, "mode"=>$mode));
		}
	}
?>
