<?php

spl_autoload_register(
	function($classname) {
		switch ($classname[0]) {
			case 'C':
				require_once "inc/c/$classname.php";
				break;
			case 'M':
				require_once "inc/m/$classname.php";
				break;		
		}	
	}
);

define('BASE_URL', '/');
// нужно для IE 7 и ниже
define('DOMEN', 'blog.andreiikachanov.loc');

define('MYSQL_SERVER', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', 'admin');
define('MYSQL_DB', 'blog_new');
define('TABLE_PREFIX', 'bg717s_');
define('HASH_KEY', '35445344dgfdg15d1gfdgdfgdf4545478%^&%^&%');

define('RULES_PATH', 'inc/m/maps/rules.php');
define('MESSAGES_PATH', 'inc/m/maps/messages.php');

define('CSS_DIR', 'css/');
define('JS_DIR', 'js/');