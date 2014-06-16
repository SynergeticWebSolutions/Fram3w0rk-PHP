<?php
	// Connection, query execution, and SQL error handling class
	class DBI Extends Instance {
		protected static $instance = NULL;
		
		// Database credentials
		protected static $defaults = array();
		protected $connection = array();
		
		// Query strings
		public $queries;
		public $query;
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
				$this->connection = array();
				$this->connection["host"] = $args[0];
				if(func_num_args() > 1) $this->connection["user"] = $args[1];
				if(func_num_args() > 2) $this->connection["pass"] = $args[2];
				if(func_num_args() > 3) $this->connection["database"] = $args[3];
			}
			else $this->connection = self::$defaults;
			// Connect to the database
			$this->connection["handle"] = new mysqli($this->connection["host"], $this->connection["user"], $this->connection["pass"], $this->connection["database"]);
			if($this->connection["handle"]->connect_errno) return Log::status(__CLASS__, __FUNCTION__, FALSE, "Level 1 (Database Connection) Error: " . $this->connection["handle"]->connect_error, array("connection"=>$this->connection));
			else return Log::status(__CLASS__, __FUNCTION__, TRUE, "Level 1 (Database Connection) Successful.", array("handle"=>$this->connection["handle"]));
		}
		
		public function disconnect() {
			@mysql_close($this->connection["handle"]->close());
		}
		
		public function executeBatch() {
			$args = func_get_args();
			
			if(isset($args[0]) && !empty($args[0])) $this->query = $args[0];
			if(isset($args[1]) && $args[1] == TRUE) {
				$this->queries = preg_split("#(?<!(\\\\))\;[\n\s\t]*#", $this->query, -1, PREG_SPLIT_NO_EMPTY);
				
				$i = 0;
				while($this->queries[$i]) {
					if(trim($this->queries[$i]) != '' && trim($this->queries[$i]) != ';') {
						$id = $this->execute($this->queries[$i]);
					}
					$i++;
				}
			}
			else $id = $this->execute($this->query);
		return $id;
		}
		
		public function execute() {
			$args = func_get_args();
			
			if(isset($args[0]) && !empty($args[0])) $this->query = $args[0];
			if(isset($args[1]) && !empty($args[1])) $format = $args[1];
			else $format = MYSQLI_BOTH;
			
			$result = $this->connection["handle"]->query($this->query);
			if($this->connection["handle"]->errno) return Log::status(__CLASS__, __FUNCTION__, FALSE, "Level 2 (Execute Query) Error:" . $this->connection["handle"]->error, array("query"=>$this->query));
			else {
				$this->result = array();
				if($result->num_rows > 0) {
					while($newRow = $result->fetch_array($format)) {
						if(!empty($newRow)) $this->result[] = $newRow;
					}
				}
				return Log::status(__CLASS__, __FUNCTION__, TRUE, array("query"=>$this->query,"result"=>$this->result));
			}
		}
	}
?>

