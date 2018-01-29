<?php

include CONTROLLER_PATH."classes/".$route['controller'].'.php';	
include MODEL_PATH.'pfa-addbook.php';	
include MODEL_PATH.'pagination.php';	
// Instantiating the new pfac_addbook object
$pfacAddbook = new pfac_addbook_controller();
// URL Gate keeper for the pfac all query strings
AppController::url_gate_keeper($_GET, $route['controller']);		
// check the correct sub vie wloaded in add/edit 
if (isset($_GET['mode'])) $view_mode = $pfacAddbook->correct_sub_view_gate_keeper(trim($_GET['mode']));
// Load the correct view mode
$pfacAddbook->process_the_correct_model($route['view'], $route['controller'], $view_mode);

?>