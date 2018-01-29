<?php

require './define.inc';
require './lib/database.php';
require './lib/common_functions.php';
require './lib/controller.php';
require './lib/model.php';
require './lib/view.php';

class Configuration{

	var $db_settings = NULL;
	var $db = NULL;
	var $controllers_routes = array("pfac", "cfcp", "pfa-addbook", "pfagos", "serach");	
	var $views_routes =	array("add", "view", "edit", "show", "drop", "index", "search", "download");	
	var $constable_routes = array(
								  array('url' => '/^\/$/', 'controller' => 'system', 'view' => 'home'),	
								  array('url' => '/^\/index.php$/', 'controller' => 'system', 'view' => 'home'),						  
								  // Route for Logged url with the username after loging
								  array('url' => '/^\/logged\/([a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)\/$/', 'controller' => 'system', 'view' => 'index'),						  					  
								  array('url' => '/^\/logged\/([a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)$/', 'controller' => 'system', 'view' => 'index'),						  					  					  
								  // Route for Logging url with the before loging
								  array('url' => '/^\/system\/login\/$/', 'controller' => 'system', 'view' => 'login'),						  					  
								  array('url' => '/^\/system\/login$/', 'controller' => 'system', 'view' => 'login'),						  					  					  
								  // Route for Logged url with the username after loging and the activity log
								  array('url' => '/^\/system\/logout\/$/', 'controller' => 'system', 'view' => 'logout'),						  					  
								  array('url' => '/^\/system\/logout$/', 'controller' => 'system', 'view' => 'logout'),						  					  					  
								  array('url' => '/^\/system\/activity-log\/$/', 'controller' => 'system', 'view' => 'activity-log'),						  					  					  
								  array('url' => '/^\/system\/activity-log$/', 'controller' => 'system', 'view' => 'activity-log'),						  					  					  					  
								  // Routes for System log with Query Strins						  
								  array('url' => '/^\/system\/activity-log\/(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?$/', 'controller' => 'system', 'view' => 'activity-log'),						  					  					  					  
								  // Route for Logged url with the username after loging and the activity log with search
								  array('url' => '/^\/system\/search\/(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?$/', 'controller' => 'search', 'view' => 'view'),						  					  					  					  
								  array('url' => '/^\/system\/search$(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?/', 'controller' => 'search', 'view' => 'view'),						  					  					  					  					  
								  // Routes whci use for the account changing purposes
								  array('url' => "/^\/pfagos\/acc-edit(\?[A-Za-z+&\$_.-][A-Za-z0-9;:@&%=+\/\$_.-]*)?$/", 'controller' => 'pfagos', 'view' => 'acc-edit'),
								  array('url' => "/^\/pfagos\/acc-edit\/(\?[A-Za-z+&\$_.-][A-Za-z0-9;:@&%=+\/\$_.-]*)?$/", 'controller' => 'pfagos', 'view' => 'acc-edit')
								 );					  					  					  					  

	/* This function will return the database connection */
	function return_db_connection(){
		
		$this->db_settings = new pfagos_settings();		
		$this->db = new DBFunctions();
		return $this->db->db_connect($this->db_settings->db_settings);
	}
	/* End of the function */
	
	/* This function will return the pfagos web url */
	function return_site_base_details(){

		$this->db = new DBFunctions();		
		return reset($this->db->result_to_array_for_few_fields($this->db->execute_query("SELECT * FROM pfagos__site_access"), array("title", "base_url")));
	}
	/* End of the function */			
	
	/* This function will return check the requested url exist */
	function check_routes_map($url){
	
		global $site_config;
		global $allow_pahro_access;
		$route = array();
		// Holds the names captured
		$params = CommonFunctions::parse_param();
		// Becomes true if $route['url'] matches $url
		$route_match = false;
		// If match found append $matches to $params
		// Sets $route_match to true and also exit from the loop
		foreach($this->controllers_routes as $each_controller){
	
			foreach($this->views_routes as $each_view){
			
				$defined_url = '/^\/'.$each_controller.'\/'.$each_view.'\/(\?[A-Za-z+&\$_.-][A-Za-z0-9;:@&%=+\/\$_.-]*)?$/';			
				if(preg_match($defined_url, $url, $matches)){
					$params = (is_array($params)) ? array_merge($params, $matches) : null;
					$route_match = true;
					if ($each_view == "search"){
						$route['controller'] = "search";
						$route['view'] = "view";											
					}else{
						$route['controller'] = $each_controller;					
						$route['view'] = $each_view;										
					}
					$route['url'] = $matches[0];										
					break;
				}			
			}
		}
		if (!$route_match){

			foreach($this->constable_routes as $each_route){
				if(preg_match($each_route['url'], $url, $matches)){
					$params = (is_array($params)) ? array_merge($params, $matches) : null;
					$route['controller'] = $each_route['controller'];
					$route['view'] = $each_route['view'];					
					$route['url'] = $each_route['url'];										
					$route_match = true;									
					break;
				}
			}
		}	
		// If no matches found display error
		$allow_pahro_access = $this->display_welcome_link();
		if(!$route_match){							 
			//redirect_to($site_config['base_url']);
		}else{
			// Include controller	
			include CONTROLLER_PATH.$route['controller'].'.php';
			return VIEW_PATH.$route['controller'].DS.$route['view'].'.php';	
		}
	}
	/* End of the function */
	
	/* This function will act as the admin gate keeper for the permissions and redirections */
	function admin_gate_keeper($uri, $user_permissions){
	
		$match_against_routes = array(
									  "pfac/view" => 1, "pfac/add" => 2, "pfac/edit" => 3, "pfac/drop" => 4, "pfac/show" => 1, 
									  "cfcp/view" => 5, "cfcp/add" => 6, "cfcp/edit" => 7, "cfcp/drop" => 8, "cfcp/show" => 5, 
									  "pfa-addbook/view" => 9, "pfa-addbook/add" => 10, "pfa-addbook/edit" => 11, "pfa-addbook/drop" => 12, "pfa-addbook/show" => 9, 
									  "system/activity_log" => 13,
									  "pfagos/view" => 14, "pfagos/add" => 14, "pfagos/edit" => 14, "pfagos/drop" => 14, "pfagos/show" => 14, 
									  "pfac/search" => 1, "cfcp/search" => 5, "pfagos/search" => 14, "pfa-addbook/search" => 9
									);	  
		
		foreach($match_against_routes as $key => $value){
			
			if (strstr($uri, $key)){
				if (!@in_array($value, $user_permissions)){
					AppController::redirect_to("http://".$_SERVER['HTTP_HOST']."/");
					exit();
				}
			}
		}							   
	}
	/* End of the fucntion */
	
	/* This function will load the with the permission granted left menu for each user */
	function load_left_menu_for_given_permissions($logged_user_permissions){

		global $connection;
		global $site_config;
		$this->db = new DBFunctions();
		$html_menu = array();
		$left_menu_html = array();
		$params = array("menu_id", "menu_text", "menu_url");
		// Read the menus from the menu table
		$left_menu = $this->db->result_to_array_for_few_fields($this->db->execute_query("SELECT * FROM pfagos__menu_system WHERE status = 1 ORDER BY menu_id"), $params);
		$i=0;
		// Puttiing all menus internal items with collecting their relevant permission ids
		foreach($left_menu as $menu){
			$left_menu_html[$i]['menu_text'] = $menu['menu_text'];
			$left_menu_html[$i]['menu_url'] = $menu['menu_url'];
			$left_menu_html[$i]['permissions'] = $this->retrieve_all_permissions_for_the_menu($menu['menu_id']);
			$i++;
		}
		
		// Finally filtering those menu items against logged user permission ids
		$n=0;		
		foreach($left_menu_html as $each_left_menu){
	
			for($i=0; $i<count($logged_user_permissions); $i++){

				if (in_array($each_left_menu['permissions'][$i], $logged_user_permissions)){
					$html_menu[$n]['menu_text'] = $each_left_menu['menu_text'];
					$html_menu[$n]['menu_url'] = $each_left_menu['menu_url'];
				}
			}
			if ($each_left_menu['permissions'][0] == 0){

				$html_menu[$n]['menu_text'] = $each_left_menu['menu_text'];
				$html_menu[$n]['menu_url'] = $each_left_menu['menu_url'];
			} 	
			$n++;
		}
		return $html_menu;
	}
	/* End of the function */
	
	/* This function will load all permissions related to given menu id */
	function retrieve_all_permissions_for_the_menu($menu_id){
	
		$this->db = new DBFunctions();
		global $connection;
		return $this->db->result_to_single_array_of_data($this->db->execute_query("SELECT permission_id FROM pfagos__menu_system_permissions WHERE menu_id = {$menu_id}"), "permission_id");
	}
	/* End of the function */
	
	/* This function will change the left menu slected style agasinst the visited url */
	function is_current_url($cur_url, $loaded_menu){

		$cur_url = explode("/", $_SERVER['REQUEST_URI']);
		$cur_url_to_check = $cur_url[1].DS.$cur_url[2];
		if ($cur_url_to_check != "/") $visited = (strstr($loaded_menu, $cur_url_to_check)) ? true : false;
		if (!$visited){
		
			switch($cur_url_to_check){
				case "pfac/show": case "pfac/edit": case "pfac/search": $visited = (strstr($loaded_menu, "pfac/view")) ? true : false; break;				
				case "cfcp/show": case "cfcp/edit": case "cfcp/search": $visited = (strstr($loaded_menu, "cfcp/view")) ? true : false; break;
				case "pfa-addbook/show": case "pfa-addbook/edit": case "pfa-addbook/search": $visited = (strstr($loaded_menu, "pfa-addbook/view")) ? true : false; break;
				case "pfagos/show": case "pfagos/edit": case "pfagos/search": $visited = (strstr($loaded_menu, "pfagos/view")) ? true : false; break;
				case "system/search": case "pfagos/search": $visited = (strstr($loaded_menu, "system/activity_log")) ? true : false; break;				
				default: $visited  = false;
			}
		}
		return $visited;
	} 
	/* End of the function */
	
	/* This function load the permissions regrading to the currently logging user */
	function retrieve_all_permissions_for_the_logged_user($user_id){
	
		global $connection;
		$sql = "SELECT pfagos__user_group_permission_rel.permission_id
				FROM pfagos__user_group_permission_rel 
				LEFT JOIN pfagos__user_group_rel ON pfagos__user_group_rel.group_id = pfagos__user_group_permission_rel.group_id 
				WHERE pfagos__user_group_rel.user_id = {$user_id}";	
		return AppModel::grab_db_function_class()->result_to_single_array_of_data(AppModel::grab_db_function_class()->execute_query($sql), 'permission_id');				
	}
	/* End of the function */
	
	/* This function will display the header text as according to the url in the main find form */
	function display_the_main_find_form_header($url){
	
		$exploded_url = explode("/", $url);
		switch($exploded_url[1]){
		
			case "pfac": $headerText = "PFA Clients"; break;
			case "cfcp": $headerText = "CFC Players"; break;
			case "pfa-addbook": $headerText = "Contacts"; break;
			case "pfagos": $headerText = "Users"; break;						
			case "system": $headerText = "Activities"; break;		
			default: $headerText = "Contacts"; break;																	
		}
		return $headerText;
	}
	/* End of the function */
	
	/* This function will grab all names for search suggestions */
	static function grab_names_for_search_suggestions($controller, $name_type){
	
		global $connection;
		$searchStr = "";
		switch($controller){
		
			case "pfac": $table_name = "pfac__genral_details"; break;	
			case "cfcp": $table_name = "cfcp__personel_details"; break;	
			case "pfa-addbook": $table_name = "pfa__address_book"; break;
			case "pfagos": $table_name = "pfagos__user"; break;					
			case "system": $table_name = "pfagos__user"; break;								
			default: $table_name = "pfa__address_book"; break;							
		}
		$which_field = ($name_type == "first_name") ? "first_name" : "last_name";
		$names = AppModel::grab_db_function_class()->result_to_single_array_of_data(AppModel::grab_db_function_class()->execute_query("SELECT {$which_field} FROM {$table_name}"), $which_field);				
		foreach($names as $each_name){
			$searchStr .= $each_name . "|";
		}		
		return substr($searchStr, 0, -1);
	}
	/* End of the function */
	
	/* This function will check the permissions and then apply the welcome link for each user's account edting */
	function display_welcome_link(){
	
		if (
			(!in_array(14, $_SESSION['logged_user']['permissions']))
		   ){
				$allow_pahro_access = false;
		}else{
				$allow_pahro_access = true;			
		}
		return $allow_pahro_access;
	}
	/* End of the fucntion */
	//https://mail.google.com/mail/?shva=1#inbox/p257
}
?>