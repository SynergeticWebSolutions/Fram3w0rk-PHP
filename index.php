<?php
	/******************************************************************************
	
	Project: Fram3w0rk PHP 0.5 [Alpha]
	Website: http://www.fram3w0rk.com/
	Last Modified: Nov 3, 2012
	Author: Jonathan Lawton (jlawton@jl-ectronics.com)
	Contributers: none, yet :(
	
	Copyright (c) 2012-2013, Jonathan Lawton. All rights reserved.
	
	TERMS AND CONDITIONS
	Revised: Nov 3, 2012
	
	"Source" includes all files and processes included in previous, current and
	future versions of this project except where 3rd party source may also be
	included. You must follow the terms and conditions of individual 3rd party
	sources as stated by their own accord.
	
	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:
	
		* Redistributions of source code must retain the above copyright notice,
		  this list of conditions and the following disclaimer.
		* Redistributions in binary form must reproduce the above copyright notice,
		  this list of conditions and the following disclaimer in the documentation
		  and/or other materials provided with the distribution.
		* Neither the name of Jonathan Lawton nor the names of its contributors may
		  be used to endorse or promote products derived from this software without
		  specific prior written permission.
		* These Terms and Conditions may change at any time without given notice at
		  which point these will become replaced and inherited by the newest copy
		  included in the source or at http://www.fram3w0rk.com/software/terms/ .
	
	
	WARRANTY
	This software is provided by the copyright holders and contributors "as is" and
	any express or implied warranties, including, but not limited to, the implied
	warranties of merchantability and fitness for a particular purpose are
	disclaimed. In no event shall the copyright owner or contributors be liable for
	any direct, indirect, incidental, special, exemplary, or consequential damages
	(including, but not limited to, procurement of substitute goods or services;
	loss of use, data, or profits; or business interruption) however caused and on
	any theory of liability, whether in contract, strict liability, or tort
	(including negligence or otherwise) arising in any way out of the use of this
	software, even if advised of the possibility of such damage.
	
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
	
	
	Copyright (c) 2012-2013, Jonathan Lawton. All Rights reserved.
	
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
				'logging/logger.php',
				'dbi/dbi.php'
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
				foreach($import as $file) {
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
	if(strtolower(realpath(__FILE__)) == strtolower(realpath($_SERVER['SCRIPT_FILENAME']))): ?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>Welcome to Fram3w0rk!</title>
		<link type="text/css" rel="stylesheet" href="manual/style.css">
	</head>
	<body>
		<div id="content">
			<header>
				<div id="logo"><p>Text</p></div>
				<ul id="header-menu">
					<li><a href="#">About</a></li>
					<li><a href="#">FAQ</a></li>
					<li><a href="#">Instances</a></li>
					<li><a href="#">Classes</a></li>
					<li><a href="#">Other Resources</a></li>
				</ul>
			</header>
			<article>
				<h1>Welcome to Fram3work!</h1>
				<p>Fram3w0rk is an open-source framework designed to connect and unify code across programming languages, making it easier to learn, retain, and code. Fram3w0rk PHP is the respective PHP framework for building PHP website applications.</p>
			</article>
			<footer>
				<p>Copyright (c) 2012-2013, Jonathan Lawton. All Rights reserved.</p>
			</footer>
		</div>
	</body>
</html>
<?php endif; ?>