<?php

// Server Root
define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']);
// Application Root
// This following code need only to check in the localhost
//define('APP_ROOT', 'pfagos');
// Directory Structure
define('DS', '/');
// MVC Paths
define('MODEL_PATH', SERVER_ROOT.DS.'models'.DS);
define('CONTROLLER_PATH', SERVER_ROOT.DS.'controllers'.DS);
define('VIEW_PATH', SERVER_ROOT.DS.'views'.DS);

// This following code need only to check in the localhost
//define('MODEL_PATH', SERVER_ROOT.APP_ROOT.DS.'models'.DS);
//define('CONTROLLER_PATH', SERVER_ROOT.APP_ROOT.DS.'controllers'.DS);
//define('VIEW_PATH', SERVER_ROOT.APP_ROOT.DS.'views'.DS);
    
// Number of records per page 
define('NO_OF_RECORDS_PER_PAGE', 15);

class pfagos_settings{        

	var $db_settings = array(
								'host' => 'localhost', 
								'username' => 'tagos',
								'password' => '175r1LaNkA',
								'database' => 'pfagos'
							);
	}
?>