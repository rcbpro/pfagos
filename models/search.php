<?php

class search_model{

	/* This function will retrieve all pfagos users in to display */
	function display_all_search_results($controller, $searchTable, $searchQuery, $params, $curr_page_no = NULL, $sortBy = "", $sortMethod = ""){

		global $connection;
		$db = AppModel::grab_db_function_class();			
		$sort = "";
		$limit = "";		
		$where = "";
		$sql = "";		
		$no_of_records = ($controller == "system") ? 100 : NO_OF_RECORDS_PER_PAGE;
	
		$display_items = $no_of_records;					
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

		switch($controller){
			
			case "pfa-addbook":			
				$sql .= "SELECT 
							pfa__address_book.id, pfa__address_book.first_name, pfa__address_book.last_name, pfa__addbook_categories.Client_category_name, 
							pfa__address_book.organization, pfa__address_book.pref_language, pfa__address_book.ability_of_english, 
							pfa__address_book.location, pfa__address_book.nationality, pfa__address_book.email
						FROM pfa__address_book 
						LEFT JOIN pfa__addbook_categories ON pfa__addbook_categories.id = pfa__address_book.PFAC_addbook_cat_id ";								
				$mainSearchingTable = "pfa__address_book";		
			break;
			
			case "pfac":			
				$sql .= "SELECT 
							pfac__genral_details.id, pfac__genral_details.first_name, pfac__genral_details.last_name, pfac__genral_details.date_of_birth, pfac__genral_details.nationality, 
							pfac__genral_details.club, pfac__genral_details.webpage_url, pfac__contact_details.contract_start_date, pfac__contact_details.contract_end_date, 
							pfac__players_categories.player_category_name 
						FROM pfac__genral_details 
						LEFT JOIN pfac__contact_details ON pfac__contact_details.PFAC_id = pfac__genral_details.id
						LEFT JOIN pfac__players_categories ON pfac__players_categories.id = pfac__genral_details.player_Cat_id ";								
				$mainSearchingTable = "pfac__genral_details";								
			break;

			case "cfcp":			
				$sql .= "SELECT 
							cfcp__personel_details.id, cfcp__teams.team_name, cfcp__personel_details.first_name, cfcp__personel_details.last_name, 
							cfcp__personel_details.date_of_birth, cfcp__players_categories.player_category_name, cfcp__senior_palyer_details.place_of_birth, 
							cfcp__other_details.school, cfcp__other_details.current_class, cfcp__other_details.position1, cfcp__other_details.position2							
						FROM 
							cfcp__personel_details 
						LEFT JOIN cfcp__teams ON cfcp__teams.id = cfcp__personel_details.team_id
						LEFT JOIN cfcp__senior_palyer_details ON cfcp__senior_palyer_details.CFCP_id = cfcp__personel_details.id 
						LEFT JOIN cfcp__contact_details ON cfcp__contact_details.CFCP_id = cfcp__personel_details.id 
						LEFT JOIN cfcp__other_details ON cfcp__other_details.CFCP_id = cfcp__personel_details.id 
						LEFT JOIN cfcp__players_categories ON cfcp__players_categories.id = cfcp__senior_palyer_details.player_cat_id ";	
				$mainSearchingTable = "cfcp__personel_details";		
			break;			

			case "pfagos":			
				$sql .= "SELECT 
							pfagos__user.id, pfagos__user.first_name, pfagos__user.last_name, pfagos__user.username, pfagos__user.email, 
							pfagos__user.created_at, pfagos__user.last_login
						FROM pfagos__user ";
				$mainSearchingTable = "pfagos__user";																				
			break;		

			case "system":			
				$sql .= "SELECT pfagos__user.username, pfagos__log.action_type_desc, pfagos__log.date_time 
						 FROM pfagos__log
						 LEFT JOIN pfagos__user ON pfagos__user.id = pfagos__log.user_id ";
				$mainSearchingTable = "pfagos__user";																				
			break;		
			
			default:			
				$sql .= "";
				return false;
				exit();
			break;				
		}
				
		if ((array_key_exists("fname", $searchQuery)) && (array_key_exists("sname", $searchQuery))){
			$where .= " WHERE {$mainSearchingTable}.first_name LIKE '%".strtolower(trim($searchQuery['fname']))."%' {$mainSearchingTable}.last_name LIKE '%".strtolower(trim($searchQuery['sname']))."%'";				
		}elseif (array_key_exists("fname", $searchQuery)){
			$where .= " WHERE {$mainSearchingTable}.first_name LIKE '%".strtolower(trim($searchQuery['fname']))."%'";
		}elseif (array_key_exists("sname", $searchQuery)){
			$where .= " WHERE {$mainSearchingTable}.last_name LIKE '%".strtolower(trim($searchQuery['sname']))."%'";			
		}else{
			$where .= "";
		}		
		
		$sql .= "{$where}{$sort}{$limit}";
		return $db->result_to_array_for_few_fields($db->execute_query($sql), $params);				
		unset($db);		
	}
	/* End of the fucntion */
	
	/* This function will retrieve the count for all pfagos users in to display */
	function display_count_on_all_search_results($controller, $searchTable, $searchQuery, $params, $curr_page_no = NULL, $sortBy = "", $sortMethod = ""){
	
		global $connection;
		$db = AppModel::grab_db_function_class();	
		$where = "";
		$sort = "";
		$sql = "";		
		if ($sortBy != ""){
			if ($sortMethod == ""){
				$sortMethod = "asc";
			}
			$sort = " ORDER BY {$sortBy} {$sortMethod}";	
		}
		
		switch($controller){
			
			case "pfa-addbook":			
				$sql .= "SELECT 
							pfa__address_book.id, pfa__address_book.first_name, pfa__address_book.last_name, pfa__addbook_categories.Client_category_name, 
							pfa__address_book.organization, pfa__address_book.pref_language, pfa__address_book.ability_of_english, 
							pfa__address_book.location, pfa__address_book.nationality, pfa__address_book.email
						FROM pfa__address_book 
						LEFT JOIN pfa__addbook_categories ON pfa__addbook_categories.id = pfa__address_book.PFAC_addbook_cat_id ";								
				$mainSearchingTable = "pfa__address_book";		
			break;
			
			case "pfac":			
				$sql .= "SELECT 
							pfac__genral_details.id, pfac__genral_details.first_name, pfac__genral_details.last_name, pfac__genral_details.date_of_birth, pfac__genral_details.nationality, 
							pfac__genral_details.club, pfac__genral_details.webpage_url, pfac__contact_details.contract_start_date, pfac__contact_details.contract_end_date, 
							pfac__players_categories.player_category_name 
						FROM pfac__genral_details 
						LEFT JOIN pfac__contact_details ON pfac__contact_details.PFAC_id = pfac__genral_details.id
						LEFT JOIN pfac__players_categories ON pfac__players_categories.id = pfac__genral_details.player_Cat_id ";								
				$mainSearchingTable = "pfac__genral_details";								
			break;

			case "cfcp":			
				$sql .= "SELECT 
							cfcp__personel_details.id, cfcp__teams.team_name, cfcp__personel_details.first_name, cfcp__personel_details.last_name, 
							cfcp__personel_details.date_of_birth, cfcp__players_categories.player_category_name, cfcp__senior_palyer_details.place_of_birth, 
							cfcp__senior_palyer_details.position AS seniorPos, cfcp__senior_palyer_details.webpage_url, 
							cfcp__contact_details.home_address, cfcp__contact_details.mobile_no, cfcp__other_details.school, cfcp__other_details.position1 AS norPos
						FROM 
							cfcp__personel_details 
						LEFT JOIN cfcp__teams ON cfcp__teams.id = cfcp__personel_details.team_id
						LEFT JOIN cfcp__senior_palyer_details ON cfcp__senior_palyer_details.CFCP_id = cfcp__personel_details.id 
						LEFT JOIN cfcp__contact_details ON cfcp__contact_details.CFCP_id = cfcp__personel_details.id 
						LEFT JOIN cfcp__other_details ON cfcp__other_details.CFCP_id = cfcp__personel_details.id 
						LEFT JOIN cfcp__players_categories ON cfcp__players_categories.id = cfcp__senior_palyer_details.player_cat_id ";	
				$mainSearchingTable = "cfcp__personel_details";														
			break;			

			case "pfagos":			
				$sql .= "SELECT 
							pfagos__user.id, pfagos__user.first_name, pfagos__user.last_name, pfagos__user.username, pfagos__user.email, 
							pfagos__user.created_at, pfagos__user.last_login
						FROM pfagos__user ";
				$mainSearchingTable = "pfagos__user";																				
			break;		

			case "system":			
				$sql .= "SELECT pfagos__user.username, pfagos__log.action_type_desc, pfagos__log.date_time 
						 FROM pfagos__log
						 LEFT JOIN pfagos__user ON pfagos__user.id = pfagos__log.user_id ";
				$mainSearchingTable = "pfagos__user";																				
			break;		
			
			default:			
				$sql .= "";
				return false;
				exit();
			break;				
		}
				
		if ((array_key_exists("fname", $searchQuery)) && (array_key_exists("sname", $searchQuery))){
			$where .= " WHERE {$mainSearchingTable}.first_name LIKE '%".strtolower(trim($searchQuery['fname']))."%' {$mainSearchingTable}.last_name LIKE '%".strtolower($searchQuery['sname'])."%'";				
		}elseif (array_key_exists("fname", $searchQuery)){
			$where .= " WHERE {$mainSearchingTable}.first_name LIKE '%".strtolower(trim($searchQuery['fname']))."%'";
		}elseif (array_key_exists("sname", $searchQuery)){
			$where .= " WHERE {$mainSearchingTable}.last_name LIKE '%".strtolower(trim($searchQuery['sname']))."%'";			
		}else{
			$where .= "";
		}		
		
		$sql .= "{$where}{$sort}";
		return $db->return_num_of_rows_in_result($db->execute_query($sql));				
		unset($db);		
	}
	/* End of the fucntion */		
	
	/* This function will insert log details every time against the user action */
	function keep_track_of_activity_log_in_search($logParmas){

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
}
?>