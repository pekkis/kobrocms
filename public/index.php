<?php
/**
 * This be the main Kobro-Script.
 * 
 * @copyright Dr. Kobros Foundation!
 * @author Devadutt Chattopadhyay
 * @author Rajanigandha Balasubramanium
 * @author Lalitchandra Pakalomattam
 *   
 */
$root = realpath(dirname(__FILE__));
define('ROOT', $root);

// Add secret devel parameter to query string for devel info.
/*
 * HAl: Removed way to reveal phpinfo
if(isset($_GET['g04753m135'])) {
	phpinfo();
	die();
}
 * 
 */

// Require basic kobros klasses. Modules be using auto load so kobro cms very light!
// HAl: Modules moved outside of web scope
require_once ROOT . '/../inc/KobroCms.php'; 
require_once ROOT . '/../inc/User.php';
require_once ROOT . '/../inc/Module.php';
require_once ROOT . '/../inc/View.php';
require_once ROOT . '/../inc/Mailer.php';
require_once ROOT . '/../inc/BCrypt.php';


/* Mighty KobroCMS be implemented with fantastic patterns! */

try {
	$app = KobroCms::getInstance();
	echo $app->run();
} catch(Exception $e) {
		
	echo "<h1>KobroCMS Fatal Error</h1>";
	
        // HAl: Do not reveal unnecessary information to end user
	//echo "<em>" . $e . "</em>";

	// We kobros developers be very clever: we hide stack trace from customer if not devel mode!
	if($app->config['mode'] == 'development') {
		print "<pre>";
		print_r($e->getTrace());
		print "</pre>";
	}
	
}

// We done!