<?php
	/******************************************************************************
	
	Project: Fram3w0rk PHP 0.5 [Alpha]
	Website: http://www.fram3w0rk.com/
	Author: Jonathan Lawton (wanathan101@gmail.com)
	Contributers: none, yet :-(  (Come join in!)
	
	Copyright (c) 2012+, LawtonSoft. All rights reserved.
	
	TERMS AND CONDITIONS
	Revised: Oct 1, 2013
	
	"Source" includes all files and processes included in previous, current and
	future versions of this project except where 3rd party source may also be
	included. You must follow the terms and conditions of individual 3rd party
	sources as stated by their own accord.
	
	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:
	
		* Redistributions of source code must retain the above copyright
		  notice, this list of conditions and the following disclaimer.
		* Redistributions in binary form must reproduce the above copyright
		  notice, this list of conditions and the following disclaimer in the
		  documentation and/or other materials provided with the distribution.
		* Neither the name of Jonathan Lawton nor the names of its
		  contributors may be used to endorse or promote products derived from
		  this software without specific prior written permission.
		* These Terms and Conditions may change at any time without given
		  notice at which point these will become replaced and inherited by the
		  newest copy included in the source or at:
		  [http://www.fram3w0rk.com/software/terms/].
	
	
	WARRANTY
	This software is provided by the copyright holders and contributors "as is" and
	any express or implied warranties, including, but not limited to, the implied
	warranties of merchantability and fitness for a particular purpose are
	disclaimed. In no event shall the copyright owner or contributors of this
	Source be liable for any direct, indirect, incidental, special, exemplary, or
	consequential damages (including, but not limited to, procurement of substitute
	goods or services; loss of use, data, or profits; or business interruption)
	however caused and on any theory of liability, whether in contract, strict
	liability, or tort (including negligence or otherwise) arising in any way out
	of the use of this software, even if advised of the possibility of such damage.
	
	3rd party sources must be treated separately. Source used within the project
	but owned separately is void of this project and provided "as is" with
	attribution.
	
	*******************************************************************************
	
	Now that we're past all the boring stuff...
	
	Welcome to Fram3w0rk! Fram3w0rk is an open-source framework designed to connect
	and unify code across programming languages, making it easier to learn, retain,
	and code.
	
	Fram3w0rk PHP is the respective PHP framework for building PHP website
	applications.
	
	
	Copyright (c) 2012-2014, Jonathan Lawton. All Rights reserved.
	
	******************************************************************************/
	
	// Initite Fram3w0rk
	Instance::initiate();
	
	// Create instances for classes
	class Instance {
		// -- INITIATE FRAM3W0RK --
		public static function initiate() {
			error_reporting(E_ALL ^ E_NOTICE);
			define(__ROOT__, $_SERVER[HTTP_HOST]);
			
			self::$import = array(
				'log/index.php',
				
				'curl/index.php',
				'dbi/index.php',
				'ftp/index.php',
				'session/index.php'
			);
			
			self::load();
		}
		
		// -- LOAD FILES --
		// Use the following list to include additional classes
		public static $import = array();
		
		public static function load() {
			$args = func_get_args();
			if(isset(self::$import) && !empty(self::$import)) {
				$import = self::$import;
				foreach(self::$import as $file) {
					$file = (isset($args[0]) && !empty($args[0]) ? $args[0] : '') . $file;
					require_once($file);
				}
			}
		}
		
		// -- INSTANCES --
		private static $constructor = array();
		
		public static function get($class = null, $id = 0) {
			if(!isset($class::$instance[$id])) $class::$instance[$id] = new $class($constructor);
			return $class::$instance[$id];
		}
	}
	
	// If user loads in page.
	if(strtolower(realpath(__FILE__)) == strtolower(realpath($_SERVER['SCRIPT_FILENAME']))):
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Fram3w0rk</title>
		
		<!-- Latest compiled and minified jQuery -->
		<script src="//code.jquery.com/jquery.min.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<!-- Optional theme -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
<?php
	$files = scandir('.');
	foreach($files as $file) {
		if(!in_array($file, array('.', '..')) && file_exists($file . '/index.php')) echo "\t\t\t\t\t\t\t" . '<li><a href="#classes-' . $file . '" data-toggle="tab">' . strToUpper($file) . '</a></li>' . "\n";
	}
?>
						</ul>
					</li>
					<li><a href="#other-resources" data-toggle="tab">Other Resources</a></li>
					<li><a href="#credits" data-toggle="tab">Credits</a></li>
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
					<p>Fram3w0rk is based on the singleton pattern logic. The first thing you will need to do is impliment this file into your PHP script. Start with <code>&lt;?php&gt; require_once('{directory to Fram3w0rk}/index.php'); ?&gt;</code>. That is all that you need to do to start using Fram3w0rk!</p>
					<h2>Instantiating Class Instances</h2>
					<p>One core class will be implimented immediately upon implimentation. All others will need to be instantiated. Let's dig in. . .</p>
					<p>Upon implimenting the core Fram3w0rk PHP file into your code (as shown above), the <code>Log</code> class will be made immediately available. <a href="#classes-log" data-toggle="tab">This class</a> records logs for errors and successes used within other classes and can be used in other code such as your own. Read the documentation for more info.</p>
					<p>To impliment any class, use the static method <code>$className = Instance::get('className');</code> to return a new object instance of a class.</p>
				</div>
<?php
	$files = scandir('.');
	foreach($files as $file) {
		if(!in_array($file, array('.', '..')) && file_exists($file . '/index.php')) {
?>
			<div class="tab-pane" id="classes-<?php echo $file; ?>">
				<h1>Classes</h1>
				<h2><?php echo strToUpper($file); ?></h2>
<?php
	$handle = fopen($file . '/index.php', 'r');
	echo fread($handle, filesize($file . '/index.php'));
	fclose($handle);
?>
			</div>
<?php
		}
	}
?>
				<div class="tab-pane" id="other-resources">
					<h1>Other Resources</h1>
					<h6><a target="_blank" href="http://www.lawtonsoft.com/fram3work">Fram3w0rk</a></h6>
					<h6><a target="_blank" href="http://php.net/">PHP.net</a></h6>
				</div>
				<div class="tab-pane" id="credits">
					<h1>Credits</h1>
					<p>We would like to acknowledge the help of those who have contibuted to Fram3w0rk.</p>
					<dl>
						<dt>Created By</dt>
						<dd>Jonathan Lawton</dd>
						<dt>Project Manager</dt>
						<dd>Jonathan Lawton</dd>
						<dt>Lead Developer</dt>
						<dd>Jonathan Lawton</dd>
						<dt>Developers</dt>
						<dd></dd>
						<dd></dd>
						<dd><a target="_blank" href="http://lawtonsoft.com/projects/fram3w0rk/">Get involved today!</a></dd>
						<dt>Sponsored By</dt>
						<dd></dd>
						<dt>Special Thanks &amp; Acknowledgement</dt>
						<dd><a target="_blank" href="http://php.net/">The PHP Group</a></dd>
						<dd><a target="_blank" href="http://jquery.com/">The jQuery Foundation</a></dd>
						<dd><a target="_blank" href="http://getbootstrap.com/">Bootstrap</a></dd>
					</dl>
				</div>
			</div>
			<footer>
				<p>Copyright (c) 2012+, Jonathan Lawton. All Rights reserved.</p>
			</footer>
		</div>
	</body>
</html>

<?php endif; ?>
