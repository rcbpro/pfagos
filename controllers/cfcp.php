<?php

include CONTROLLER_PATH."classes/".$route['controller'].'.php';
include MODEL_PATH.$route['controller'].'.php';	
include MODEL_PATH.'pagination.php';
include ('lib/ImageCreate.php');
// Instantiating the new cfcp object
$cfcpCon = new cfcp_controller();
// URL Gate keeper for the cfcp all query strings
AppController::url_gate_keeper($_GET, $route['controller']);		
// check the correct sub view loaded in add/edit 
if (isset($_GET['mode'])) $view_mode = $cfcpCon->correct_sub_view_gate_keeper(trim($_GET['mode']));
// Load the correct view mode	
$cfcpCon->process_the_correct_model($route['controller'], $route['view'], $view_mode);				

?>