<?php
	// Connection, query execution, and SQL error handling class
	class DBI Extends Instance {
		protected static $instance = NULL;
		
		// Database credentials
		protected static $defaults = array("lang"=>"mysql");
		protected $connection = array();
		
		// Query strings
		public $queries;
		public $query;
		public $result;
		
		public static function setDefaults() {
			$args = func_get_args();
			self::$defaults = $args[0];
		}
		
		public static function setDefaultLang($lang) {
			self::$defaults["lang"] = $lang;
		}
		
		public static function setDefaultHost($host) {
			self::$defaults["host"] = $host;
		}
		
		public static function setDefaultPort($port) {
			self::$defaults["port"] = $port;
		}
		
		public static function setDefaultUser($user) {
			self::$defaults["user"] = $user;
		}
		
		public static function setDefaultPassword($pass) {
			self::$defaults["pass"] = $pass;
		}
		
		public static function setDatabase($database) {
			self::$defaults["database"] = $database;
		}
		
		public function connect() {
			if (func_num_args() == 1) {
				$args = func_get_args();
				$this->connection = $args[0];
			}
			elseif (func_num_args() > 1) {
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
			if($this->connection["handle"]->connect_errno) return Log::status(__CLASS__, __FUNCTION__, FALSE, "Database Connection Error: " . $this->connection["handle"]->connect_error, array("connection"=>$this->connection));
			else return Log::status(__CLASS__, __FUNCTION__, TRUE, "Database Connection Successful.", array("handle"=>$this->connection["handle"]));
		}
		
		public function disconnect() {
			@mysql_close($this->connection["handle"]->close());
		}
		
		public function execute() {
			$args = func_get_args();
			
			if(isset($args[0]) && !empty($args[0])) $this->query = $args[0];
			if(isset($args[1]) && !empty($args[1])) $format = $args[1];
			else $format = MYSQLI_BOTH;
			
			$result = $this->connection["handle"]->query($this->query);
			if($this->connection["handle"]->errno) return Log::status(__CLASS__, __FUNCTION__, FALSE, "Execute Query Error:" . $this->connection["handle"]->error, array("query"=>$this->query));
			else {
				$this->result = array();
				if($result->num_rows > 0) {
					while($newRow = $result->fetch_array($format)) {
						if(!empty($newRow)) $this->result[] = $newRow;
					}
				}
				if($this->connection["handle"]->insert_id) return Log::status(__CLASS__, __FUNCTION__, TRUE, array("query"=>$this->query,"result"=>$this->result,"id"=>$this->connection["handle"]->insert_id));
				else return Log::status(__CLASS__, __FUNCTION__, TRUE, array("query"=>$this->query,"result"=>$this->result));
			}
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
		
		public function escape_string($mysqlString) {
			return $this->connection["handle"]->escape_string($mysqlString);
		}
	}
	
	// If user loads in page.
	if(strtolower(realpath(__FILE__)) == strtolower(realpath($_SERVER['SCRIPT_FILENAME']))):
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Welcome to Fram3w0rk!</title>
		
		<!-- Latest compiled and minified jQuery -->
		<script src="//code.jquery.com/jquery.min.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
		
		<!-- Optional theme -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="navbar navbar-default navbar-static-top navbar-inverse navbar-fixed-top" role="navigation">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Fram3w0rk</a>
			</div>
			<div class="collapse navbar-collapse bs-js-navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#home" data-toggle="tab">Home</a></li>
					<li><a href="#about" data-toggle="tab">About</a></li>
					<li><a href="#faq" data-toggle="tab">FAQ</a></li>
					<li><a href="#getting-started" data-toggle="tab">Getting Started</a></li>
					<li class="dropdown">
						<a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Classes<b class="caret"></b></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
							<li><a href="#classes-dbi" data-toggle="tab">DBI</a></li>
							<li><a href="#classes-log" data-toggle="tab">Log</a></li>
						</ul>
					</li>
					<li><a href="#other-resources" data-toggle="tab">Other Resources</a></li>
					<li><a href="#acknowledgements" data-toggle="tab">Acknowledgements</a></li>
				</ul>
				<a class="nav navbar-nav navbar-right navbar-brand" href="#">PHP v0.5 [Alpha]</a>
			</div><!--/.nav-collapse -->
		</div>
		<div class="container" style="padding-top: 50px">
			<div class="tab-content">
				<div class="tab-pane active" id="home">
					<article>
						<h1>Welcome to Fram3w0rk PHP!</h1>
						<p>Fram3w0rk is an open-source framework designed to connect and unify code across programming languages, making it easier to learn, retain, and code. Fram3w0rk PHP is the respective PHP framework for building PHP website applications.</p>
					</article>
				</div>
				<div class="tab-pane" id="about">
					<h1>About</h1>
				</div>
				<div class="tab-pane" id="faq">
					<h1>FAQ</h1>
				</div>
				<div class="tab-pane" id="getting-started">
					<h1>Getting Started</h1>
					<h2>Implementing Fram3w0rk</h2>
					<p>Fram3w0rk is based on the singleton pattern logic. The first thing you will need to do is implement this file into your PHP script. Start with <code>&lt;?php&gt; require_once('{directory to Fram3w0rk}/index.php'); ?&gt;</code>. That is all that you need to do to start using Fram3w0rk!</p>
					<h2>Instantiating Class Instances</h2>
					<p>One core class will be implemented immediately upon implementation. All others will need to be instantiated. Let's dig in. . .</p>
					<p>Upon implementing the core Fram3w0rk PHP file into your code (as shown above), the <code>Log</code> class will be made immediately available. <a href="#classes-log" data-toggle="tab">This class</a> records logs for errors and successes used within other classes and can be used in other code such as your own. Read the documentation for more info.</p>
					<p>To implement any class, use the static method <code>$className = Instance::get('className');</code> to return a new object instance of a class.</p>
				</div>
				<div class="tab-pane" id="classes-dbi">
					<h1>Classes</h1>
					<h2>DBI</h2>
				</div>
				<div class="tab-pane" id="classes-log">
					<h1>Classes</h1>
					<h2>Log</h2>
				</div>
				<div class="tab-pane" id="other-resources">
					<h1>Other Resources</h1>
					<h6><a target="_blank" href="http://www.lawtonsoft.com/fram3work">Fram3w0rk</a></h6>
					<h6><a target="_blank" href="http://php.net/">PHP.net</a></h6>
				</div>
				<div class="tab-pane" id="acknowledgements">
					<h1>Acknowledgements</h1>
					<p>We would like to acknowledge the help of those who have contibuted to Fram3w0rk.</p>
					<h5>[Created By]</h5>
					<h6>Jonathan Lawton</h6>
					<h5>[Project Manager]</h5>
					<h6>Jonathan Lawton</h6>
					<h5>[Lead Developer]</h5>
					<h6>Jonathan Lawton</h6>
					<h5>[Developers] (in ahabetical order)</h5>
					<h6></h6>
					<h6>Jonathan Lawton</h6>
					<h6></h6>
					<h6><a target="_blank" href="http://www.fram3w0rk.com/">Get involved today!</a></h6>
					<h5>[Sponsored By]</h5>
					<h6></h6>
					<h5>[Special Thanks]</h5>
					<h6><a target="_blank" href="http://php.net/">The PHP Group</a></h6>
					<h6><a target="_blank" href="http://jquery.com/">The jQuery Foundation</a></h6>
					<h6><a target="_blank" href="http://getbootstrap.com/">Bootstrap</a></h6>
				</div>
			</div>
			<footer>
				<p>Copyright (c) 2012-2014, Jonathan Lawton. All Rights reserved.</p>
			</footer>
		</div>
	</body>
</html>

<?php endif; ?>
