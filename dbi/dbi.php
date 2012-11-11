<?php
	// Connection, query execution, and SQL error handling class
	class DBI Extends Instance {
		protected static $instance = NULL;
		
		// Database credentials
		protected static $defaults = array();
		protected $connection = array();
		
		// Query strings
		public $query;
		public $queries;
		public $prepared;
		public $result;
		
		public static function setDefaults($host, $user, $pass, $database) {
			self::$defaults = array(
				"host"=>$host,
				"user"=>$user,
				"pass"=>$pass,
				"database"=>$database
			);
		}
		
		public function connect() {
			if (func_num_args() > 0) {
				$args = func_get_args();
				$this->connection = array(
				"host"=>$args[0],
				"user"=>$args[1],
				"pass"=>$args[2],
				"database"=>$args[3]
				);
			}
			else {
				$this->connection = self::$defaults;
			}
			
			// Connect to the database
			$this->connection["handle"] = @mysql_connect($this->connection["host"],$this->connection["user"],$this->connection["pass"]);
			if(!isset($this->connection["handle"])) return Log::status(__CLASS__, __FUNCTION__, FALSE, "Level 1 (Database Connection) Error: " . mysql_error(), array("query"=>$this->query));
			
			$this->connection["database"] = @mysql_select_db($this->connection["database"], $this->connection["handle"]);
			if(!isset($this->connection["database"])) return Log::status(__CLASS__, __FUNCTION__, FALSE, "Level 2 (Database Selection) Error: " . mysql_error(), array("query"=>$this->query));
		}
		
		public function disconnect() {
			$this->connect();
			@mysql_close($this->connection["handle"]);
		}
		
		public function executeBatch() {
			$args = func_get_args();
			
			$this->connect();
			if(isset($args[0]) && !empty($args[0])) $this->query = $args[0];
			if(isset($args[1]) && $args[1] == TRUE) {
				$this->queries = preg_split("#(?<!(\\\\))\;[\n\s\t]*#", $this->query, -1, PREG_SPLIT_NO_EMPTY);
				
				$i = 0;
				while($this->queries[$i]) {
					if(trim($this->queries[$i]) != '' && trim($this->queries[$i]) != ';') {
						$id = $this->prepare($this->queries[$i]);
						if(Log::$status[$id]["success"] == "TRUE") $id = $this->execute($this->prepared);
					}
					$i++;
				}
			}
			else {
				$id = $this->prepare($this->query);
				if(Log::$status[$id]["success"] == "TRUE") $id = $this->execute($this->prepared);
			}
		return $id;
		}
		
		public function prepare($var) {
			$this->query = $var;
			$this->prepared = @mysql_query($this->query);
			if(!isset($this->prepared)) $id = Log::status(__CLASS__, __FUNCTION__, FALSE, "Level 3 (Query Encode) Error: " . mysql_error(), array("query"=>$this->query));
			else $id = Log::status(__CLASS__, __FUNCTION__, TRUE, array("query"=>$this->query));
		return $id;
		}
		
		public function execute($var) {
			$this->prepared = $var;
			$this->result = @mysql_fetch_array($this->prepared);
			if(!isset($this->prepared) || empty($this->prepared)) $id = Log::status(__CLASS__, __FUNCTION__, FALSE, "Level 4 (Fetch Query) Error: " . mysql_error(), array("query"=>$this->query));
			else $id = Log::status(__CLASS__, __FUNCTION__, TRUE, array("query"=>$this->query));
		return $id;
		}
	}
?>