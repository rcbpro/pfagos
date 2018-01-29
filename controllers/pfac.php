<?php

include CONTROLLER_PATH."classes/".$route['controller'].'.php';	
include MODEL_PATH.$route['controller'].'.php';	
include MODEL_PATH.'pagination.php';
include ('lib/ImageCreate.php');
// Instantiating the new pfac object
$pfacCon = new PfacController();
// URL Gate keeper for the pfac all query strings
AppController::url_gate_keeper($_GET, $route['controller']);		
// check the correct sub vie wloaded in add/edit 
if (isset($_GET['mode'])) $view_mode = $pfacCon->correct_sub_view_gate_keeper(trim($_GET['mode']));
// Load the correct view mode
$pfacCon->process_the_correct_model($route['controller'], $route['view'], $view_mode);				

?>