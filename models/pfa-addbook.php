<?php

class pfac_addbook{

	/* This function will insert addbook details in to datbase */
	function insert_addbook_details($addbook_details_param){
	
		global $connection;
		$sql = "INSERT INTO pfa__address_book(PFAC_addbook_cat_id, first_name, last_name, position, nationality, location, ability_of_english,
												pref_language, organization, address, phone, mobile, fax, email) 
							VALUES(".
									$addbook_details_param['PFAC_addbook_cat_id'].",'".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['first_name']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['last_name']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['position']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['nationality']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['location']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['ability_of_english']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['pref_language']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['organization']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['address']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['phone']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['mobile']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['fax']))."','".
									CommonFunctions::mysql_preperation(trim($addbook_details_param['email'])).
								"')"; 
		AppModel::grab_db_function_class()->execute_query($sql);
		return AppModel::grab_db_function_class()->return_last_inserted_id();		
	}
	/* End of the function */
	
	/* This function will insert addbook details in to datbase */
	function update_addbook_details($addbook_details_param, $id){

		global $connection;
		$sql = "UPDATE pfa__address_book 
						SET 							
							first_name = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['first_name'])) . "', 
							last_name = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['last_name'])) . "', 													
							PFAC_addbook_cat_id = ". $addbook_details_param['PFAC_addbook_cat_id'] . ",
							position = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['position'])) . "', 
							nationality = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['nationality'])) . "', 
							location = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['location'])) . "', 
							ability_of_english = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['ability_of_english'])) . "', 
							pref_language = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['pref_language'])) . "', 
							organization = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['organization'])) . "', 																																			
							address = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['address'])) . "', 
							phone = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['phone'])) ."', 
							mobile = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['mobile'])) ."',
							fax = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['fax'])) ."', 
							email = '". CommonFunctions::mysql_preperation(trim($addbook_details_param['email'])) . "' 
						 WHERE id = {$id}";
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the function */	
	
	/* This function will delete the pfac general details for a given pfac_id */
	function delete_record_in_addbook($id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfa__address_book WHERE pfa__address_book.id = {$id}");						
	}
	/* End of the function */			
	
	/* This function will load the address book categories from the database */
	function retrieve_addressbook_categories(){
	
		global $connection;
		$params = array('id', 'Client_category_name');
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT id, Client_category_name FROM pfa__addbook_categories"), $params);		
	}
	/* End of the function */
	
	/* This function will retrieve all pfa clients in to display */
	function display_all_pfa_addbook_contacts($params, $curr_page_no = NULL, $sortBy = "", $sortMethod = ""){
	
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
			$sort = " ORDER BY pfa__address_book.id DESC";				
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";				
		$sql = "SELECT 
					pfa__address_book.id, pfa__address_book.first_name, pfa__address_book.last_name, 
					pfa__addbook_categories.Client_category_name,
					pfa__address_book.organization, pfa__address_book.pref_language,
					pfa__address_book.nationality, pfa__address_book.location, pfa__address_book.ability_of_english
				FROM pfa__address_book
				LEFT JOIN pfa__addbook_categories ON pfa__addbook_categories.id = PFAC_addbook_cat_id {$sort}{$limit}";		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);				
	}
	/* End of the fucntion */
	
	/* This function will retrieve the count for all pfa clients in to display */
	function display_count_on_all_pfa_addbook_contacts(){
	
		global $connection;
		$sql = "SELECT 
					pfa__address_book.id, pfa__address_book.first_name, pfa__address_book.last_name, 
					pfa__addbook_categories.Client_category_name,
					pfa__address_book.organization, pfa__address_book.pref_language,
					pfa__address_book.nationality, pfa__address_book.location, pfa__address_book.ability_of_english
				FROM pfa__address_book
				LEFT JOIN pfa__addbook_categories ON pfa__addbook_categories.id = PFAC_addbook_cat_id ORDER BY pfa__address_book.id DESC";
		return AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query($sql));				
	}
	/* End of the fucntion */	
	
	/* This function will check whether the given address book id from the get value is exist in database */
	function check_addressbook_id_exist($id){
	
		global $connection;
		return (AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT id FROM pfa__address_book WHERE id = {$id}")) != "") ? true : false;																
	}
	/* End of the function */
	
	/* This function will retrieve full details per each address book contact */
	function retrieve_full_details_per_each_addbook_contact($addbook_id){
	
		global $connection;
		$sql = "SELECT 
					pfa__address_book.id, pfa__address_book.first_name, pfa__address_book.last_name, pfa__address_book.PFAC_addbook_cat_id AS addbookCatId, 
					pfa__addbook_categories.Client_category_name,
					pfa__address_book.nationality, pfa__address_book.location, pfa__address_book.ability_of_english, pfa__address_book.pref_language, pfa__address_book.organization, 
					pfa__address_book.position, pfa__address_book.address, pfa__address_book.phone,
					pfa__address_book.mobile, pfa__address_book.fax, pfa__address_book.email
				FROM pfa__address_book
				LEFT JOIN pfa__addbook_categories ON pfa__addbook_categories.id = PFAC_addbook_cat_id 
				WHERE pfa__address_book.id = ".$addbook_id;	
		$params = array('id', 'first_name', 'last_name', 'addbookCatId', 'position', 'address', 'phone', 'position', 'nationality', 'location', 'ability_of_english', 
						'pref_language', 'organization', 'mobile', 'fax', 'email');		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);							
	}
	/* End of the function */	
	
	/* This function will load all neccessary details for the single view */
	function grab_full_details_for_the_single_view_in_addressbook($addbook_id){
	
		global $connection;
		$sql = "SELECT 
					pfa__address_book.id, pfa__address_book.first_name, pfa__address_book.last_name, pfa__address_book.PFAC_addbook_cat_id AS addbookCatId,
					pfa__addbook_categories.Client_category_name,
					pfa__address_book.nationality, pfa__address_book.location, pfa__address_book.ability_of_english, pfa__address_book.pref_language, pfa__address_book.organization,
					pfa__address_book.position, pfa__address_book.address, pfa__address_book.phone,
					pfa__address_book.mobile, pfa__address_book.fax, pfa__address_book.email
				FROM pfa__address_book
				LEFT JOIN pfa__addbook_categories ON pfa__addbook_categories.id = PFAC_addbook_cat_id 
				WHERE pfa__address_book.id = ".$addbook_id;
		$params = array('id', 'first_name', 'last_name', 'addbookCatId', 'nationality', 'location', 'ability_of_english', 'pref_language', 'organization', 
						'position', 'address', 'phone', 'mobile', 'fax', 'email', 'Client_category_name');		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);							
	}
	/* End of the fucntion */		
	
	/* This function will retrieve address book category name by it's geiven id */
	function grab_addressbook_cat_name_by_cat_id($cat_id){
		
		global $connection;
		return $db->return_single_result_from_mysql_resource($db->execute_query("SELECT Client_category_name FROM pfa__addbook_categories WHERE id = {$cat_id}"), 0);																
	}
	/* End of the function */
	
	/* This function will insert log details every time against the user action */
	function keep_track_of_activity_log_in_pfa_addbook($logParmas){
	
		global $connection;
		$db = AppModel::grab_db_function_class();					
		$sql = "INSERT INTO pfagos__log
							(user_id, action_type_desc, date_time) 
							VALUES(".
									$logParmas['user_id'].",'".
									CommonFunctions::mysql_preperation(trim($logParmas['action_desc']))."','".
									$logParmas['date_crated'].
							"')"; 
		$db->execute_query($sql);		
		unset($db);				
	}
	/* End of the fucntion */
	
	/* This function will insert a new note to the datbase */
	function insert_new_note($notes_params){
	
		global $connection;
		$sql = "INSERT INTO pfagos__notes
							(note_owner_id, note_owner_type, note, date_added, added_by) 
							VALUES(".
									$notes_params['note_owner_id'].",'".
									$notes_params['note_owner_type']."','".
									CommonFunctions::mysql_preperation(trim($notes_params['note_text']))."','".
									$notes_params['date_added']."',".
									$notes_params['added_by'].
								")";
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the function */

	/* This function will insert a new note to the datbase */
	function update_the_exsiting_note($notes_params, $note_id){
	
		global $connection;
		$sql = "UPDATE pfagos__notes 
						SET 				
							note = '". CommonFunctions::mysql_preperation(trim($notes_params['note_text'])) . "', 
							date_modified = '". $notes_params['date_modified'] . "', 
							modified_by = ". $notes_params['modified_by'] ." 
						 WHERE note_id = {$note_id} AND note_owner_id = {$notes_params['note_owner_id']}";
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the function */
	
	/* This function will delete the pfac general details for a given pfac_id */
	function delete_selected_note($note_id, $pfac_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfagos__notes WHERE pfagos__notes.note_id = {$note_id} AND pfagos__notes.note_owner_id = {$pfac_id}");						
	}
	/* End of the function */		

	/* This function will retrieve all notes with other details regarding to the client */
	function retrieve_all_notes_owned_by_this_client($note_owner_id, $param_array){
	
		global $connection;
		$sql = "SELECT * FROM pfagos__notes WHERE note_owner_id = {$note_owner_id} AND note_owner_type = 'PFA_ADDBOOK'";	
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $param_array);									
	}
	/* End of the fucntion */

	/* This function will retrieve all notes with other details regarding to the client */
	function retrieve_all_notes_owned_by_this_client_only_for_the_edit_view($param_array, $curr_page_no = NULL, $sortBy = "", $sortMethod = "", $note_owner_id){

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
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";		
		$sql = "SELECT pfagos__notes.note_id, pfagos__notes.note_owner_id, 
					   pfagos__notes.note, pfagos__notes.date_modified, pfagos__notes.modified_by, pfagos__notes.added_by, pfagos__notes.date_added 
				FROM pfagos__notes 
				WHERE pfagos__notes.note_owner_type = 'PFA_ADDBOOK' 
				AND pfagos__notes.note_owner_id = {$note_owner_id} {$sort}{$limit}";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $param_array);									
	}
	/* End of the fucntion */

	/* This function will retrieve all notes count regarding to the client */
	function retrieve_all_notes_count_owned_by_this_client_only_for_the_edit_view($note_owner_id, $param_array){
	
		global $connection;
		$sql = "SELECT pfagos__notes.note_id, pfagos__notes.note_owner_id, 
					   pfagos__notes.note, pfagos__notes.date_modified, pfagos__notes.modified_by, pfagos__notes.added_by, pfagos__notes.date_added  
				FROM pfagos__notes 
				WHERE pfagos__notes.note_owner_type = 'PFA_ADDBOOK' 
				AND pfagos__notes.note_owner_id = {$note_owner_id}";	
		return AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query($sql));						
	}
	/* End of the fucntion */

	/* This function will check the given note id is owned by the given client */
	function check_note_id_owned_by_the_correct_client($pfa_addbook_id, $note_id){	

		global $connection;
		$pfa_addbook_id_in_db = AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query("SELECT note_owner_id FROM pfagos__notes WHERE note_id = {$note_id} AND note_owner_type = 'PFA_ADDBOOK'"), 0);																
		return ($pfa_addbook_id == $pfa_addbook_id_in_db) ? true : false;
	}		
	/* End of the function */

	/* This function will retrieve note category name for the its cat id */
	function retrieve_full_details_of_selected_note($note_id, $param_array){
	
		global $connection;
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT * FROM pfagos__notes WHERE note_id = {$note_id}"), $param_array);									
	}
	/* End of the function */
	
	/* This function will check whethr the client note id exist in the database before any further action */
	function check_note_id_exist($note_id){
	
		global $connection;
		return (AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT note_id FROM pfagos__notes WHERE note_id = {$note_id}")) != "") ? true : false;																
	}
	/* End of the fucntion */
	
	/* This function will Configure the action panel with against user permissions */
	function generate_action_panel_with_user_related_permissions($logged_user_permissions, $site_config, $view, $mode="", $addbook_id=""){

		$action_panel_menu = array();	
		$action_panel = array(
								array(
										"menu_id" => 1,
										"menu_text" => "Add / Edit Note",
										"menu_url" => $site_config['base_url']."pfa-addbook/edit/?mode=notes",
										"menu_img" => "<img src=\"../../public/images/notepadicon.png\" border=\"0\" alt=\"New / Edit Note\" />",
										"menu_permissions" => array(10, 11, 12)
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
										"menu_permissions" => array(10, 11, 12)
									),	
								array(
										"menu_id" => 4,
										"menu_text" => "Drop",
										"menu_url" => $site_config['base_url']."pfa-addbook/drop/",
										"menu_img" => "<img src=\"../../public/images/b_drop.png\" border=\"0\" alt=\"Drop\" />",
										"menu_permissions" => array(12)
									)	
								);	
		// Filtering the action panel which menu to be displayed against the user permissions
		for($n=0; $n<count($action_panel); $n++){
		
			for($i=0; $i<count($logged_user_permissions); $i++){
	
				if (in_array($action_panel[$n]['menu_permissions'][$i], $logged_user_permissions)){
					$action_panel_menu[$n]['menu_text'] = $action_panel[$n]['menu_text'];
					$action_panel_menu[$n]['menu_url'] = $action_panel[$n]['menu_url'];
					$action_panel_menu[$n]['menu_img'] = $action_panel[$n]['menu_img'];							
				}
			}
		}
		return (($mode != "") ? $this->filter_action_panel_buttons_in_subview($action_panel_menu, $addbook_id, $mode, $site_config) : $action_panel_menu);
	}
	/* End of the function */
	
	/* This function will again filter the action panel buttons according to correct sub view */
	function filter_action_panel_buttons_in_subview($action_panel_menu, $addbook_id, $mode, $site_config){

		$filtered_action_panel_menu = "";
		foreach($action_panel_menu as $eachMenu){

				if (!strstr($eachMenu['menu_url'], $mode)){

					if ($eachMenu['menu_text'] == "Drop"){
             
						$filtered_action_panel_menu	.= " <a href='#' onclick='return ask_for_delete_record(\"".$site_config['base_url']."pfa-addbook/drop/?addbook_id=".$addbook_id."\");' 
														title='".$eachMenu['menu_text']."'>".$eachMenu['menu_img']."</a>";                    
					
					}else{	
			
						$filtered_action_panel_menu .= " <a title='".$eachMenu['menu_text']."' href='".$eachMenu['menu_url'].
													   (((($eachMenu['menu_text'] == "Details") || ($eachMenu['menu_text'] == "Drop")) ? "?" : "&").("addbook_id=".$addbook_id)).
													   (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
													   (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "").
													   "'>".$eachMenu['menu_img']."</a>";
					}													   
				}								   
		}                    	
		return $filtered_action_panel_menu;            
	}
	/* End of the function */
	
	/* This function will retrieve media details per each given parameter */
	function grab_note_modified_or_added_person($title, $u_id){
	
		global $connection;
		$sql = "SELECT username 
				FROM pfagos__user 
				LEFT JOIN pfagos__notes ON pfagos__notes.{$title} = pfagos__user.id 
				WHERE pfagos__notes.{$title} = {$u_id}";
		return (AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query($sql), 0));																
	}
	/* End of the fucntion */	
	
	/* This function will delete all the notes which owned by given pfac_id */
	function delete_owned_notes($addbook_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfagos__notes WHERE pfagos__notes.note_owner_id = {$addbook_id}");						
	}
	/* End of the function */		
}
?>