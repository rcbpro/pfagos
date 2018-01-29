<?php

class search_controller extends AppController{

	/* This function will check the correct sub view provided else redirect to the home page */
	function correct_sub_view_gate_keeper($subView, $controller){

		global $site_config;
		$modes_array = array("sname", "fname", "page", "f_name", "l_name", "cat", "dob", "nationality", "club", "con_start", "con_end", "weburl", "sort", "by");
		foreach($subView as $key => $value){
			if (!in_array($key, $modes_array)){
				AppController::redirect_to($site_config['base_url']."{$controller}/view/");
				break;
			}
		}
	} 
	/* End of the fucntion */

	/* This function will process the correct model for the given view */
	function process_the_correct_model($view){

		switch($view) {
		
			case "view":
				// All Global variables
				global $site_config;
				global $all_search_results;
				global $all_search_results_count;
				global $pagination;
				global $tot_page_count;
				global $cur_page;
				global $img;															
				global $searchQ;
				global $pathToJump;
				global $breadcrumb;	
				global $splittedUrl;
				global $action_panel_menu;																			
				$sortBy = "";															
				$query = "";														
				$searchQ = "";
				$breadcrumb = "";
				$sortPath = "";
				$divInternalMessage = "";
				$action_panel_menu = array();
				// Object Instantiation
				$searchModel = new search_model();
				$pagination_obj = new Pagination();				
				// Viewing all contacts in the table
				$cur_page = ((isset($_GET['page'])) && ($_GET['page'] != "") && ($_GET['page'] != 0)) ? $_GET['page'] : 1; 												
				// Providing the neccessary message as for the given controller
				switch($_SESSION['Controller_to_search']){
				
					case "pfa-addbook": 
						$divInternalMessage = "Address Book";
						// Configuring the PFAC action panel with against user permissions
						$action_panel = array(
												array(
														"menu_id" => 1,
														"menu_text" => "Add / Edit Note",
														"menu_url" => $site_config['base_url']."pfa-addbook/edit/?mode=notes",
														"menu_img" => "<img src=\"../../public/images/notepadicon.png\" border=\"0\" alt=\"New / Edit Note\" />",
														"menu_permissions" => array(11, 12)
													),	
												array(
														"menu_id" => 2,
														"menu_text" => "Details",
														"menu_url" => $site_config['base_url']."pfa-addbook/show/",
														"menu_img" => "<img src=\"../../public/images/b_browse.png\" border=\"0\" alt=\"Browse\" />",
														"menu_permissions" => array(9)
													),	
												array(
														"menu_id" => 3,
														"menu_text" => "Edit",
														"menu_url" => $site_config['base_url']."pfa-addbook/edit/?mode=main",
														"menu_img" => "<img src=\"../../public/images/b_edit.png\" border=\"0\" alt=\"Edit\" />",
														"menu_permissions" => array(11, 12)
													),	
												array(
														"menu_id" => 4,
														"menu_text" => "Drop",
														"menu_url" => $site_config['base_url']."pfa-addbook/drop/",
														"menu_img" => "<img src=\"../../public/images/b_drop.png\" border=\"0\" alt=\"Drop\" />",
														"menu_permissions" => array(11, 12)
													)	
												);	
					break;					
					case "pfac": 
						$divInternalMessage = "PFA"; 
						// Configuring the PFAC action panel with against user permissions
						$action_panel = array(
												array(
														"menu_id" => 1,
														"menu_text" => "Add / Edit Note",
														"menu_url" => $site_config['base_url']."pfac/edit/?mode=notes",
														"menu_img" => "<img src=\"../../public/images/notepadicon.png\" border=\"0\" alt=\"New / Edit Note\" />",
														"menu_permissions" => array(2, 3, 4)
													),	
												array(
														"menu_id" => 2,
														"menu_text" => "Details",
														"menu_url" => $site_config['base_url']."pfac/show/",
														"menu_img" => "<img src=\"../../public/images/b_browse.png\" border=\"0\" alt=\"Browse\" />",
														"menu_permissions" => array(1)
													),	
												array(
														"menu_id" => 3,
														"menu_text" => "Edit",
														"menu_url" => $site_config['base_url']."pfac/edit/?mode=general",
														"menu_img" => "<img src=\"../../public/images/b_edit.png\" border=\"0\" alt=\"Edit\" />",
														"menu_permissions" => array(2, 3, 4)
													),	
												array(
														"menu_id" => 4,
														"menu_text" => "Drop",
														"menu_url" => $site_config['base_url']."pfac/drop/",
														"menu_img" => "<img src=\"../../public/images/b_drop.png\" border=\"0\" alt=\"Drop\" />",
														"menu_permissions" => array(2, 3, 4)
													)	
												);	
					break;
					case "cfcp": 
						$divInternalMessage = "CFCP"; 
						// Configuring the CFCP action panel with against user permissions
						$action_panel = array(
												array(
														"menu_id" => 1,
														"menu_text" => "Add / Edit Note",
														"menu_url" => $site_config['base_url']."cfcp/edit/?mode=notes",
														"menu_img" => "<img src=\"../../public/images/notepadicon.png\" border=\"0\" alt=\"New / Edit Note\" />",
														"menu_permissions" => array(6, 7, 8)
													),	
												array(
														"menu_id" => 2,
														"menu_text" => "Details",
														"menu_url" => $site_config['base_url']."cfcp/show/",
														"menu_img" => "<img src=\"../../public/images/b_browse.png\" border=\"0\" alt=\"Browse\" />",
														"menu_permissions" => array(5)
													),	
												array(
														"menu_id" => 3,
														"menu_text" => "Edit",
														"menu_url" => $site_config['base_url']."cfcp/edit/?mode=general",
														"menu_img" => "<img src=\"../../public/images/b_edit.png\" border=\"0\" alt=\"Edit\" />",
														"menu_permissions" => array(6, 7, 8)
													),	
												array(
														"menu_id" => 4,
														"menu_text" => "Drop",
														"menu_url" => $site_config['base_url']."cfcp/drop/",
														"menu_img" => "<img src=\"../../public/images/b_drop.png\" border=\"0\" alt=\"Drop\" />",
														"menu_permissions" => array(8)
													)	
												);	
					break;
					case "pfagos": 
						$divInternalMessage = "PFAGOS"; 
						// Configuring the action panel with against user permissions
						$action_panel = array(
												array(
														"menu_id" => 1,
														"menu_text" => "Details",
														"menu_url" => $site_config['base_url']."pfagos/show/?",
														"menu_img" => " <img src=\"../../public/images/b_browse.png\" border=\"0\" alt=\"Browse\" />",
														"menu_permissions" => array(14)
													),	
												array(
														"menu_id" => 2,
														"menu_text" => "Edit",
														"menu_url" => $site_config['base_url']."pfagos/edit/?",
														"menu_img" => " <img src=\"../../public/images/b_edit.png\" border=\"0\" alt=\"Edit\" />",
														"menu_permissions" => array(14)
													),	
												array(
														"menu_id" => 3,
														"menu_text" => "Drop",
														"menu_url" => $site_config['base_url']."pfagos/drop/?",
														"menu_img" => " <img src=\"../../public/images/b_drop.png\" border=\"0\" alt=\"Drop\" />",
														"menu_permissions" => array(14)
													)	
												);	
					break;
					case "system": 
						$divInternalMessage = "Users Activities"; 
					break;					
				}
				// Filtering the action panel which menu to be displayed against the user permissions
				for($n=0; $n<count($action_panel); $n++){
				
					for($i=0; $i<count($_SESSION['logged_user']['permissions']); $i++){
		
						if (in_array($action_panel[$n]['menu_permissions'][$i], $_SESSION['logged_user']['permissions'])){
							$action_panel_menu[$n]['menu_text'] = $action_panel[$n]['menu_text'];
							$action_panel_menu[$n]['menu_url'] = $action_panel[$n]['menu_url'];
							$action_panel_menu[$n]['menu_img'] = $action_panel[$n]['menu_img'];							
						}
					}
				}
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']."\" class=\"headerLink\">Home</a> &rsaquo; {$divInternalMessage} Search Results</div>";
				// Load the neccassary table according to the suitable controller								
				$controllers = array(
									 	"pfa-addbook" => array("pfa__address_book", "pfa__addbook_categories"),
									 	"pfac" => array("pfac__genral_details", "pfac__contact_details", "pfac__players_categories"),											
										"pfagos" => "pfagos__user",
										"system" => "pfagos__log"
									);
				foreach($controllers as $controller => $table){
					if ($controller == $_SESSION['Controller_to_search']){
						$searchTable[] = $table;
					}
				}					
				// Creating the search query
				if ((isset($_GET['fname'])) && (isset($_GET['sname']))){
					$query = array("fname" => $_GET['fname'], "sname" => $_GET['sname']);				
					$searchQ = "?fname=".$_GET['fname']."&sname=".$_GET['sname'];
				}elseif (isset($_GET['fname'])){
					$query = array("fname" => $_GET['fname']);
					$searchQ = "?fname=".$_GET['fname'];					
				}elseif (isset($_GET['sname'])){
					$query = array("sname" => $_GET['sname']);			
					$searchQ = "?sname=".$_GET['sname'];												
				}
				// Providing the param array as neccessary to the given controller
				switch($_SESSION['Controller_to_search']){
				
					case "pfa-addbook": $param_array = array('id', 'first_name', 'last_name', 'Client_category_name', 'nationality', 'location', 'ability_of_english', 'pref_language', 'organization');
					break;
					
					case "pfac": $param_array = array('id', 'first_name', 'last_name', 'player_category_name', 'date_of_birth', 'nationality', 'club', 'contract_start_date', 'contract_end_date', 'webpage_url');
					break;

					case "cfcp": $param_array = array('id', 'team_name', 'first_name', 'last_name', 'date_of_birth', 'player_category_name', 'position1', 'position2', 'current_class', 
											'school', 'place_of_birth');
					break;

					case "pfagos": $param_array = array('id', 'first_name', 'last_name', 'username', 'email', 'created_at', 'last_login');
					break;
					
					case "system": $param_array = array('username', 'action_type_desc', 'date_time');
					break;
				}				
				// if SORTED then generate the neccessary sorting param array														
				$jumpPath .= $site_config['base_url']."search/view/";								
				if (isset($_GET['sort'])){	
				
					$imgDefault = "<a href=\"".$site_config['base_url']."{$_SESSION['Controller_to_search']}/search/".$searchQ."&sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
					$imgAsc = "<a href=\"".$site_config['base_url']."{$_SESSION['Controller_to_search']}/search/".$searchQ."&sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
					$imgDesc = "<a href=\"".$site_config['base_url']."{$_SESSION['Controller_to_search']}/search/".$searchQ."&sort=".$_GET['sort']."&by=desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_desc.png\" border=\"0\" /></a>";								
					$img = (!isset($_GET['by'])) ? ($imgDefault) : (($_GET['by'] == "asc") ? $imgDesc : $imgAsc);

					switch($_SESSION['Controller_to_search']){
					
						case "pfa-addbook":
							$sort_param_array = array(
													  "f_name" => "first_name", "l_name" => "last_name", "cat" => "Client_category_name", "org" => "organization", 
													  "loc" => "location", "eng" => "ability_of_english", "pref_lan" => "pref_language", "nation" => "nationality"
													 );		
							$param_array = array('id', 'first_name', 'last_name', 'Client_category_name', 'organization', 'location', 'ability_of_english', 'pref_language', 'nationality');
						break;
						
						case "pfac":
							$sort_param_array = array(
													  "f_name" => "first_name", "l_name" => "last_name", "cat" => "player_category_name", "dob" => "date_of_birth", 
													  "nationality" => "nationality", "club" => "club", "con_start" => "contract_start_date", "con_end" => "contract_end_date",
													  "weburl" => "webpage_url"
													 );							
							$param_array = array('id', 'first_name', 'last_name', 'date_of_birth', 'player_category_name', 'nationality', 'club', 'contract_start_date', 'contract_end_date',
												 'webpage_url');
						break;

						case "cfcp":
							$sort_param_array = array(
													  "f_name" => "first_name", "l_name" => "last_name", "cat" => "player_category_name", "dob" => "date_of_birth", 
													  "team" => "team_name", "pos1" => "position1", "pos2" => "position2", 
													  "class" => "current_class", "school" => "school", "birth_place" => "place_of_birth"
													 );							
							$param_array = array('id', 'team_name', 'first_name', 'last_name', 'date_of_birth', 'player_category_name', 
											'current_class', 'school', 'position2', 'position1', 'place_of_birth');
						break;

						case "pfagos":
							$sort_param_array = array(
													  "f_name" => "first_name", "l_name" => "last_name", "uname" => "username", "email" => "email", 
													  "created_at" => "created_at", "last_log" => "last_login"
													 );							
							$param_array = array('first_name', 'last_name', 'username', 'email', 'created_at', 'last_login');
						break;
						
						case "system":
							$sort_param_array = array("u_name" => "username", "act_desc" => "action_type_desc", "time" => "date_time");							
							$param_array = array('username', 'action_type_desc', 'date_time');
						break;
					}
	
					foreach($sort_param_array as $key => $value) {
						if ($key == $_GET['sort']) {
							$sortBy = $value;
						}
					}					 
					$sortPath = "&sort=".$_GET['sort'].((isset($_GET['by'])) ? "&by=".$_GET['by'] : "");					
					$jumpPath .= "?sort=".$_GET['sort'].((isset($_GET['by'])) ? "&by=".$_GET['by'] : "");															 
				}
				// Creating the path for pagintion
				$pagePath .= (isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=";
				$pathToJump	.= $site_config['base_url']."search/view/".$searchQ.$sortPath."&page=";
				if (!isset($_GET['page'])){ 
					$cur_path = "?".(isset($_GET['sort'])) ? "sort=".$_GET['sort'].((isset($_GET['by'])) ? "&by=".$_GET['by'] : "") : ""; 
				}else{ 
					$cur_path = $_SERVER['REQUEST_URI']; 
				} 
				$jumpPath .= ((isset($_GET['page'])) && (!isset($_GET['sort']))) ? "?page=" : "&page=";																																																		
				// Display all the records
				$all_search_results = $searchModel->display_all_search_results($_SESSION['Controller_to_search'], $searchTable, $query, $param_array, $cur_page, $sortBy, @$_GET['by']);
				$all_search_results_count = $searchModel->display_count_on_all_search_results($_SESSION['Controller_to_search'], $searchTable, $query, $param_array, $cur_page, $sortBy, @$_GET['by']);
				// Pagination load
				$pagination = $pagination_obj->generate_pagination($all_search_results_count, $cur_path, $cur_page, (($controller == "system") ? 100 : NO_OF_RECORDS_PER_PAGE));				
				$tot_page_count = ceil($all_search_results_count/(($controller == "system") ? 100 : NO_OF_RECORDS_PER_PAGE));	
				// Log keeping
				$log_params = array(
									"user_id" => $_SESSION['logged_user']['id'], 
									"action_desc" => "Searched for a {$_SESSION['Controller_to_search']} contact",
									"date_crated" => date("Y-m-d-H:i:s")
									);
				$searchModel->keep_track_of_activity_log_in_search($log_params);
				// Unset all used variables
				unset($searchModel);
				unset($pagination_obj);
				unset($site_config);
				unset($all_search_results);
				unset($all_search_results_count);
				unset($pagination);
				unset($tot_page_count);
				unset($cur_page);
				unset($img);															
				unset($searchQ);
				unset($pathToJump);
				unset($breadcrumb);	
				unset($splittedUrl);
				unset($jumpPath);
				unset($pagePath);																			
			break;					
		}	
	}
}
?>