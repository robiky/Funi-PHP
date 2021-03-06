<?php

/**
 * @Author Imoh
 * Intellectual Property of Oxygyn Upstream Services
 * 2017
 */

/**
* Front-end application entry point
*/

# define variable to allow access to the app
define("ACCESS", true);

# define application base Path
define ("PATH", realpath(__DIR__ . '/../'));

# define application parent directory
$parts = explode(DIRECTORY_SEPARATOR, PATH);
define("PARENT_DIR", $parts[count($parts) - 1]);


# define Environment
$env = stripos($_SERVER['HTTP_HOST'], 'localhost') === false
		? 'production' : 'development';

define("ENV", $env);



# set global Objects
global $registry, $session;

//include files
require_once PATH . '/core/libs/appError.class.php';
require_once PATH . '/core/libs/funiFactory.ini.php';
require_once PATH . '/core/libs/bootstrap.class.php';
require_once PATH . '/core/libs/session.class.php';


# Create Session Object
$session = new core\libs\Session(array(
								'name' => $registry->get('config')->get('appTitle'),
								'domain' => 'localhost',
								'httponly' => true
							));
$session->start();

$app = Application::getInstance($registry->get('autoLoader'), $session, $registry->get('router'));

# register session object
$registry->set('session', $session);


# include page where global classes have been registered
require_once PATH . '/application/libs/appFactory.ini.php';

require_once PATH . '/application/libs/functions.php';


# Execute Application
$app->boot();
