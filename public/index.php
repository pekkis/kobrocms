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
/*if(isset($_GET['g04753m135'])) {
	phpinfo();
	die();
}*/

// Require basic kobros klasses. Modules be using auto load so kobro cms very light!
require_once ROOT . '/inc/KobroCms.php'; 
require_once ROOT . '/inc/User.php';
require_once ROOT . '/inc/Module.php';
require_once ROOT . '/inc/View.php';
require_once ROOT . '/inc/Mailer.php';


/* Mighty KobroCMS be implemented with fantastic patterns! */

try {
	$app = KobroCms::getInstance();
        echo $app->run();
} catch(Exception $e) {
		
	echo "<h1>KobroCMS</h1>";

	// We kobros developers be very clever: we hide stack trace from customer if not devel mode!
	/*if($app->config['mode'] == 'development') {
		print "<pre>";
		print_r($e->getTrace());
		print "</pre>";
	}*/
	
}

// We done!