<?php

class pfagos_users{

	/* This function will insert a new user to the system */
	function insert_new_pfagos_user($user_param_array){
	
		global $connection;
		$sql = "INSERT INTO pfagos__user(username , password, first_name, last_name, email, created_at, last_login) 
							VALUES('".
									CommonFunctions::mysql_preperation($user_param_array['username'])."','".
									$user_param_array['password']."','".
									CommonFunctions::mysql_preperation(trim($user_param_array['first_name']))."','".
									CommonFunctions::mysql_preperation(trim($user_param_array['last_name']))."','".
									CommonFunctions::mysql_preperation(trim($user_param_array['email']))."','".
									$user_param_array['created_at']."','".$user_param_array['last_login'].
								"')"; 
		AppModel::grab_db_function_class()->execute_query($sql);		
		return AppModel::grab_db_function_class()->return_last_inserted_id();		
	}
	/* End of the function */
	
	/* This function will retrieve all pfagos users in to display */
	function display_all_pfagos_users($params, $curr_page_no = NULL, $sortBy = "", $sortMethod = ""){
	
		global $connection;
		$sort = "";
		$limit = "";		
	
		$display_items = NO_OF_RECORDS_PER_PAGE;					
		if ($curr_page_no != NULL){
			if ($curr_page_no == 1){
				$start_no_sql = 0;
				$end_no_sql = $display_items;
			}else{							
				$start_no_sql = ($curr_page_no - 1) * $display_items;
				$end_no_sql = $display_items;				
			}
		}else{
			 $start_no_sql = 0;
			 $end_no_sql = $display_items;		
		}
		if ($sortBy != ""){
			if ($sortMethod == ""){
				$sortMethod = "asc";
			}
			$sort = " ORDER BY {$sortBy} {$sortMethod}";	
		}else{
			$sort = " ORDER BY pfagos__user.id DESC";				
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";				
		$sql = "SELECT pfagos__user.id, pfagos__user.username, pfagos__user.first_name, pfagos__user.last_name, pfagos__user.email , pfagos__user.created_at, pfagos__user.last_login 
				FROM pfagos__user {$sort}{$limit}";								
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);				
	}
	/* End of the fucntion */
	
	/* This function will retrieve the count for all pfagos users in to display */
	function display_count_on_all_pfagos(){
	
		global $connection;
		$sql = "SELECT pfagos__user.id, pfagos__user.username, pfagos__user.first_name, pfagos__user.last_name, pfagos__user.email , pfagos__user.created_at, pfagos__user.last_login 
				FROM pfagos__user ORDER BY pfagos__user.id DESC"; 
		return AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query($sql));				
	}
	/* End of the fucntion */		

	/* This function will check whether the given pfagos book id from the get value is exist in database */
	function check_pfagos_id_exist($id){
	
		global $connection;
		return (AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT id FROM pfagos__user WHERE id = {$id}")) != "") ? true : false;																
	}
	/* End of the function */

	/* This function will retrieve full details per each address book contact */
	function retrieve_full_details_per_each_pfagos_user($user_id){
	
		global $connection;
		$sql = "SELECT pfagos__user.id, pfagos__user.username, pfagos__user.first_name, pfagos__user.last_name, pfagos__user.email
				FROM pfagos__user
				WHERE pfagos__user.id = ".$user_id;								
		$params = array('id', 'address_book_id', 'username', 'first_name', 'last_name', 'email');		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);							
	}
	/* End of the function */	
	
	/* This function will check the username entered by the user is exist in the db */
	function check_username_exist_in_db($username){
	
		global $connection;
		return (AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT username FROM pfagos__user WHERE username = '{$username}'")) == 0) ? false : true;
	}
	/* End of the function */
	
	/* This function will check the user's previous password is correct when he tries to edit his profile */
	function check_previous_password_correct($username, $password){
	
		global $connection;
		$cur_password = AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query("SELECT password FROM pfagos__user WHERE username = '{$username}'"), 0);	
		return ($cur_password == $password)	? true : false;
	}
	/* End of the function */
	
	/* This function will update the user's details */
	function update_user_details($u_id, $user_details_params){

		global $connection;
		if ($user_details_params['password'] != ""){
			$sql = "UPDATE pfagos__user 
								SET 
									first_name = '".CommonFunctions::mysql_preperation(trim($user_details_params['first_name']))."', 
									last_name = '".CommonFunctions::mysql_preperation(trim($user_details_params['last_name']))."', 																						
									password = '".CommonFunctions::mysql_preperation(trim($user_details_params['password']))."',  
									email = '".CommonFunctions::mysql_preperation(trim($user_details_params['email']))."' 
								WHERE id = ".$u_id;		
		}else{
			$sql = "UPDATE pfagos__user 
								SET 
									first_name = '".CommonFunctions::mysql_preperation(trim($user_details_params['first_name']))."', 
									last_name = '".CommonFunctions::mysql_preperation(trim($user_details_params['last_name']))."', 																						
									email = '".CommonFunctions::mysql_preperation(trim($user_details_params['email']))."' 
								WHERE id = ".$u_id;		
		}			
		AppModel::grab_db_function_class()->execute_query($sql);							
	}
	/* End of the function */

	/* This function will update the user's details */
	function reset_password($u_id, $pass){

		global $connection;
		AppModel::grab_db_function_class()->execute_query("UPDATE pfagos__user SET password = '".md5($pass)."' WHERE id = ".$u_id);							
	}
	/* End of the function */
	
	/* This function will delete the user record from the users table */
	function delete_user_details_from_the_table($u_id){
	
		global $connection;
		if ($u_id != ""){ 
			AppModel::grab_db_function_class()->execute_query("DELETE FROM pfagos__user WHERE id = ".$u_id);								
		}	
	} 
	/* End of the function */
	
	/* This function will load all neccessary details for the single view */
	function grab_full_details_for_the_single_view_in_pfagos($pfagos_id){
	
		global $connection;
		$params = array('id', 'first_name', 'last_name', 'username', 'email', 'created_at', 'last_login');		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT pfagos__user.* FROM pfagos__user WHERE id = ".$pfagos_id), $params);							
	}
	/* End of the fucntion */	
	
	/* This function will insert log details every time against the user action */
	function keep_track_of_activity_log_in_pfagos($logParmas){
	
		global $connection;
		$sql = "INSERT INTO pfagos__log
							(user_id, action_type_desc, date_time) 
							VALUES(".
									$logParmas['user_id'].",'".
									CommonFunctions::mysql_preperation(trim($logParmas['action_desc']))."','".
									$logParmas['date_crated'].
							"')"; 
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */
	
	/* This function will load all user group permissions */
	function retrieve_all_user_groups(){
	
		global $connection;
		$params = array('group_id', 'group_name', 'group_description', 'status');		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT * FROM pfagos__user_group WHERE status = 1 ORDER BY group_id DESC"), $params);							
	}
	/* End of the function */
	
	/* This function will allocate the newly added user with the user groups what he has select */
	function insert_user_groups_to_newly_added_user($new_pagos_id, $user_groups_param){
	
		global $connection;
		for($i=0; $i<count($user_groups_param); $i++){
			$sql = "INSERT INTO pfagos__user_group_rel
								(user_id, group_id) 
								VALUES(".
										$new_pagos_id.",".
										$user_groups_param[$i]['group_id'].
								")"; 
			AppModel::grab_db_function_class()->execute_query($sql);		
		}	
	}
	/* End of the fucntion */
	
	/* This function will retrieve all user gruops which owned by a specific user */
	function grab_owned_user_gruops($pfagos_id){
	
		global $connection;
		return AppModel::grab_db_function_class()->result_to_single_array_of_data(AppModel::grab_db_function_class()->execute_query("SELECT group_id FROM pfagos__user_group_rel WHERE user_id = {$pfagos_id}"), "group_id");							
	}
	/* End of the function  */

	/* This function will retrieve all user gruops which owned by a specific user */
	function grab_owned_user_gruop_name_for_given_group_id($group_id){
	
		global $connection;
		return AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query("SELECT group_description FROM pfagos__user_group WHERE status = 1 AND group_id = {$group_id}"), 0);							
	}
	/* End of the function  */
	
	/* This function will clear the user previous user group details */
	function clear_user_previous_group_details($pfagos_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfagos__user_group_rel WHERE user_id = {$pfagos_id}");							
	}
	/* End of the function */
	
	/* This function will Configure the action panel with against user permissions */
	function generate_action_panel_with_user_related_permissions($logged_user_permissions, $site_config, $view, $mode="", $pfagos_id=""){

		$action_panel_menu = array();	
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
		return (($view != "") ? $this->filter_action_panel_buttons_in_subview($action_panel_menu, $pfagos_id, $view, $site_config) : $action_panel_menu);
	}
	/* End of the function */
	
	/* This function will again filter the action panel buttons according to correct sub view */
	function filter_action_panel_buttons_in_subview($action_panel_menu, $pfagos_id, $view, $site_config){

		$filtered_action_panel_menu = "";
		foreach($action_panel_menu as $eachMenu){

				if (!strstr($eachMenu['menu_url'], $view)){

					if ($eachMenu['menu_text'] == "Drop"){
             
						$filtered_action_panel_menu	.= "<a href='#' onclick='return ask_for_delete_record(\"".$site_config['base_url']."pfagos/drop/?pfagos_id=".$pfagos_id."\");' 
														title='".$eachMenu['menu_text']."'>".$eachMenu['menu_img']."</a>";                    
	
					}else{

						$filtered_action_panel_menu .= " <a title='".$eachMenu['menu_text']."' href='".$eachMenu['menu_url']."pfagos_id=".$pfagos_id.
													   (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
													   (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "").
													   "'>".$eachMenu['menu_img']." </a>";
					}												   
														   
				}								   
		}                    	
		return $filtered_action_panel_menu;            
	}
	/* End of the function */
}
?>