<?php

include CONTROLLER_PATH."classes/".$route['controller'].'.php';
include MODEL_PATH.'pfagos.php';	
include MODEL_PATH.'pagination.php';	
// Instantiating the new pfagos object
$pfagosNewUsersController = new pfagosUsers();
// URL Gate keeper for the pfagos all query strings
AppController::url_gate_keeper($_GET, $route['controller']);		
// Load the correct view mode	
$pfagosNewUsersController->process_the_correct_model($route['view'], $route['controller']);

?>