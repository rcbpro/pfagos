<?php

class PfacModel extends AppModel{
	
	/* THis function will do the validation for the PFAC general view */	
	function validate_general_view($posted){

		return AppModel::validate($posted);
	}
	/* End of the function */
	
	/* This function will return all player categories for PFAC clients */	
	function display_all_pfac_categories($params){
	
		global $connection;
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT * FROM pfac__players_categories"), $params);		
	}
	/* End of the function */
	
	/* This function will insert pfac history session data to the pfagos_session_table */
	function keep_session_data($session_param_array){

		global $connection;
		$sql = "";
		if (count($session_param_array) == 3){
			$sql .= "INSERT INTO pfagos__session_data (session_id, field_1, field_2) VALUES("; 			
		}else{
			$sql .= "INSERT INTO pfagos__session_data (session_id, field_1, field_2, field_3) VALUES("; 
		}	
		$i=0;
		foreach($session_param_array as $field => $value){
			$i++;
			$sql .= "'".CommonFunctions::mysql_preperation(trim($value))."'"; 
			if (($i == 3) || ($i == 4)){ break; } else { $sql .= ","; }
		}
		$sql .= ")";
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */
	
	/* This fucntion will retrieve data from the pfagos_session_data table */
	function grab_session_data($session_id, $params){

		global $connection;
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT id, field_1, field_2, field_3 FROM pfagos__session_data WHERE session_id = '" . $session_id . "'"), $params);				
	}
	/* End of the fucntion */
	
	/* This fucntion will remove data from the pfagos_session_data table */
	function drop_session_data($id){

		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfagos__session_data WHERE id = " . $id);				
	}
	/* End of the fucntion */	

	/* This fucntion will remove data from the pfac_history table */
	function drop_history_data($history_id){

		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfac__players_history WHERE pfac_history_id = " . $history_id);				
	}
	/* End of the fucntion */

	/* This function will insert session data regarding to the general view in to database */
	function insert_general_info($general_info_required_param, $htmlContent, $extra_information, $media_details, $timeStamp, $pfa_type){
		
		global $connection;
		$dob = $general_info_required_param['year']."-".$general_info_required_param['month']."-".$general_info_required_param['day'];
		if ($pfa_type == 5){
			
			$sql = "INSERT INTO pfac__genral_details
								(first_name, last_name, player_web_page, player_Cat_id, date_of_birth, nationality, club, comment, 
										qualifications, career_highlights, photo_url, cv_url, webpage_url, date_created) 
								VALUES('".
										CommonFunctions::mysql_preperation(trim($general_info_required_param['firstname']))."','".
										CommonFunctions::mysql_preperation(trim($general_info_required_param['lastname']))."','".
										$htmlContent."',".
										$general_info_required_param['player_cat'].",'".
										$dob."','".
										$general_info_required_param['nationality']."','".
										CommonFunctions::mysql_preperation(trim($extra_information['club']))."','".
										CommonFunctions::mysql_preperation(trim($extra_information['comment']))."','".
										CommonFunctions::mysql_preperation(trim($extra_information['qualifications']))."','".
										CommonFunctions::mysql_preperation(trim($extra_information['careers']))."','".										
										CommonFunctions::mysql_preperation(trim($media_details['photo_url']))."','".
										CommonFunctions::mysql_preperation(trim($media_details['cv_url']))."','".
										CommonFunctions::mysql_preperation(trim($media_details['webpage_url']))."','".
										$timeStamp.
									"')";
		}else{
		
			$sql = "INSERT INTO pfac__genral_details
								(first_name, last_name, player_web_page, player_Cat_id, date_of_birth, nationality, club, height, weight, 
										position, comment, photo_url, video_url, cv_url, webpage_url, date_created) 
								VALUES('".
										CommonFunctions::mysql_preperation(trim($general_info_required_param['firstname']))."','".
										CommonFunctions::mysql_preperation(trim($general_info_required_param['lastname']))."','".
										$htmlContent."',".
										$general_info_required_param['player_cat'].",'".
										$dob."','".
										$general_info_required_param['nationality']."','".
										CommonFunctions::mysql_preperation(trim($extra_information['club']))."','".
										CommonFunctions::mysql_preperation(trim($extra_information['height']))."','".
										CommonFunctions::mysql_preperation(trim($extra_information['weight']))."','".
										CommonFunctions::mysql_preperation(trim($extra_information['position']))."','".
										CommonFunctions::mysql_preperation(trim($extra_information['comment']))."','".
										CommonFunctions::mysql_preperation(trim($media_details['photo_url']))."','".
										CommonFunctions::mysql_preperation(trim($media_details['video_url']))."','".
										CommonFunctions::mysql_preperation(trim($media_details['cv_url']))."','".
										CommonFunctions::mysql_preperation(trim($media_details['webpage_url']))."','".
										$timeStamp.
									"')";
		}
		AppModel::grab_db_function_class()->execute_query($sql);
		return AppModel::grab_db_function_class()->return_last_inserted_id();			
	}
	/* End of the function */
	
	/* This function will insert session data regarding to the general view in to database */
	function update_general_info($general_info_required_param, $pfac_id, $htmlContent, $general_info_Non_required_param, $media_details){
		
		global $connection;
		$dob = $general_info_required_param['year']."-".$general_info_required_param['month']."-".$general_info_required_param['day'];
		$sql = "UPDATE pfac__genral_details
						SET
							first_name = '". CommonFunctions::mysql_preperation(trim($general_info_required_param['firstname'])) ."',
							last_name = '". CommonFunctions::mysql_preperation(trim($general_info_required_param['lastname'])) ."',
							date_of_birth = '". $dob ."',
							nationality = '". $general_info_required_param['nationality'] ."',																				
							player_web_page = '". $htmlContent ."',
							player_Cat_id = ". $general_info_required_param['player_cat'] .",
							club = '". CommonFunctions::mysql_preperation(trim($general_info_Non_required_param['club'])) ."',
							height = '". CommonFunctions::mysql_preperation(trim($general_info_Non_required_param['height'])) ."',
							weight = '". CommonFunctions::mysql_preperation(trim($general_info_Non_required_param['weight'])) ."',
							position = '". CommonFunctions::mysql_preperation(trim($general_info_Non_required_param['position'])) ."',
							comment = '". CommonFunctions::mysql_preperation(trim($general_info_Non_required_param['comment'])) ."',
							webpage_url = '". trim($media_details['webpage_url']) ."'
						WHERE id = ". $pfac_id;
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the function */	
	
	/* This function will insert session data regarding to the contact view in to the databse */
	function insert_contact_info($pfac_id, $contact_info_non_required_param, $contract_start_date, $contract_end_date){		
		
		global $connection;
		$contract_start_date = $contract_start_date['year']."-".$contract_start_date['month']."-".$contract_start_date['day'];
		$contract_end_date = $contract_end_date['year']."-".$contract_end_date['month']."-".$contract_end_date['day'];
		$sql = "INSERT INTO pfac__contact_details
							(PFAC_id, home_address, home_phone, home_mobile, overseas_address, overseas_phone, overseas_mobile, contract_start_date, contract_end_date, 
								email, passport_no, exact_name_on_passport, emergency_contact_name, emergency_contact_no) 
							VALUES(".
									$pfac_id.",'".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['homeaddress']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['home_phone']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['home_mobile']))."','".									
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['overseas_address']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['overseas_phone']))."','".									
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['overseas_mobile']))."','".
									$contract_start_date."','".
									$contract_end_date."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['email']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['passport_no']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['exact_name_on_passport']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['emerg_contact_name']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['emerg_contact_no'])).
							"')";
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */
	
	/* This function will insert session data regarding to the contact view in to the databse */
	function update_contact_info($contact_info_non_required_param, $pfac_id, $contract_start_date, $contract_end_date){		
		
		global $connection;
		$contract_start_date = $contract_start_date['year']."-".$contract_start_date['month']."-".$contract_start_date['day'];
		$contract_end_date = $contract_end_date['year']."-".$contract_end_date['month']."-".$contract_end_date['day'];
		$sql = "UPDATE pfac__contact_details
							SET
								home_address = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['homeaddress'])) ."',
								home_phone = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['home_phone'])) ."',
								home_mobile = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['home_mobile'])) ."',
								overseas_address = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['overseas_address'])) ."',
								overseas_phone = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['overseas_phone'])) ."',								
								overseas_mobile = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['overseas_mobile'])) ."',
								contract_start_date = '". $contract_start_date ."',
								contract_end_date = '". $contract_end_date ."',																
								email = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['email'])) ."',
								passport_no = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['passport_no'])) ."',
								exact_name_on_passport = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['exact_name_on_passport'])) ."',
								emergency_contact_name = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['emerg_contact_name'])) ."',
								emergency_contact_no = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['emerg_contact_no'])) ."'
							WHERE PFAC_id =". $pfac_id; 
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */
	
	/* This function will insert session data regarding to the contact view in to the databse */
	function insert_history_info($pfac_id, $history_info, $mode=""){

		global $connection;
		if ($mode == "edit"){
			$sql = "INSERT INTO pfac__players_history
					(PFAC_id, club, appearances, goals, newly_inserted)
					VALUES(".$pfac_id.",'".CommonFunctions::mysql_preperation(trim($history_info['clubs']))."','".
										   CommonFunctions::mysql_preperation(trim($history_info['appearances']))."','".
										   CommonFunctions::mysql_preperation(trim($history_info['goals']))."','yes')"; 
			AppModel::grab_db_function_class()->execute_query($sql);																		
		}else{			
			for($i=0; $i<count($history_info); $i++){		
				$sql = "INSERT INTO pfac__players_history
								(PFAC_id, club, appearances, goals)
								VALUES(".$pfac_id.",'".CommonFunctions::mysql_preperation(trim($history_info[$i]['field_1']))."','".
													   CommonFunctions::mysql_preperation(trim($history_info[$i]['field_2']))."','".
													   CommonFunctions::mysql_preperation(trim($history_info[$i]['field_3'])).
									  "')"; 
				AppModel::grab_db_function_class()->execute_query($sql);													
			}					
		}					
	}
	/* End of the fucntion */

	/* This function will insert session data regarding to the contact view in to the databse */
	function insert_history_info_for_coach($pfac_id, $history_info, $mode=""){

		global $connection;
		if ($mode == "edit"){
			$sql = "INSERT INTO pfac__coaches_history
					(PFAC_id, club, position, newly_inserted)
					VALUES(".$pfac_id.",'".CommonFunctions::mysql_preperation(trim($history_info['clubs']))."','".
										   CommonFunctions::mysql_preperation(trim($history_info['position']))."','yes')"; 
			AppModel::grab_db_function_class()->execute_query($sql);																		
		}else{			
			for($i=0; $i<count($history_info); $i++){		
				$sql = "INSERT INTO pfac__coaches_history
								(PFAC_id, club, position)
								VALUES(".$pfac_id.",'".CommonFunctions::mysql_preperation(trim($history_info[$i]['field_1']))."','".
													   CommonFunctions::mysql_preperation(trim($history_info[$i]['field_2'])).
									  "')"; 
				AppModel::grab_db_function_class()->execute_query($sql);													
			}					
		}					
	}
	/* End of the fucntion */

	/* This function will load html content for the player's single web page */
	function create_or_update_single_web_for_pfac_player($mode="", $id=0, $pfac_type){

		if ($_SESSION['pfac_general_reqired']['player_cat'] != 5){

			if ((($mode != "") && ($mode == "edit")) && ($id != 0)){
				$players_page_details = $this->grab_players_page_details($id);		
				$firstName = (isset($_SESSION['pfac_general_reqired']['firstname'])) ? trim($_SESSION['pfac_general_reqired']['firstname']) : $players_page_details[0]['first_name'];
				$lastName = (isset($_SESSION['pfac_general_reqired']['lastname'])) ? trim($_SESSION['pfac_general_reqired']['lastname']) : $players_page_details[0]['last_name'];
				if ((isset($_SESSION['pfac_general_reqired']['year'])) && (isset($_SESSION['pfac_general_reqired']['month'])) && (isset($_SESSION['pfac_general_reqired']['day']))){
					$dob = App_Viewer::format_date($_SESSION['pfac_general_reqired']['year']."-".$_SESSION['pfac_general_reqired']['month']."-".$_SESSION['pfac_general_reqired']['day']);			
				}else{	
					$dob = $players_page_details[0]['date_of_birth'];
				}	
				$nationality = (isset($_SESSION['pfac_general_reqired']['nationality'])) ? trim($_SESSION['pfac_general_reqired']['nationality']) : $players_page_details[0]['nationality'];
				$club = (isset($_SESSION['pfac_player_info_non_reqired']['club'])) ? trim($_SESSION['pfac_player_info_non_reqired']['club']) : $players_page_details[0]['club'];
				$height = (isset($_SESSION['pfac_player_info_non_reqired']['height'])) ? trim($_SESSION['pfac_player_info_non_reqired']['height']) : $players_page_details[0]['height'];
				$weight = (isset($_SESSION['pfac_player_info_non_reqired']['weight'])) ? trim($_SESSION['pfac_player_info_non_reqired']['weight']) : $players_page_details[0]['weight'];
				$position = (isset($_SESSION['pfac_player_info_non_reqired']['position'])) ? trim($_SESSION['pfac_player_info_non_reqired']['position']) : $players_page_details[0]['position'];
				$comment = (isset($_SESSION['pfac_player_info_non_reqired']['comment'])) ? trim($_SESSION['pfac_player_info_non_reqired']['comment']) : $players_page_details[0]['comment'];																					
				$cv_path = (isset($_SESSION['pfac_preview_cv'])) ? "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."cvs".DS.trim($_SESSION['pfac_preview_cv']['name']) : $players_page_details[0]['cv_url'];																					
				$video_path = (isset($_SESSION['pfac_preview_video'])) ? "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."videos".DS.trim($_SESSION['pfac_preview_video']['name']) : $players_page_details[0]['video_url'];																					
				$img_path = (isset($_SESSION['pfac_preview_img'])) ? "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."images".DS.trim($_SESSION['pfac_preview_img']['name']) : $players_page_details[0]['photo_url'];																														
			}else{
				$firstName = trim($_SESSION['pfac_general_reqired']['firstname']);
				$lastName = trim($_SESSION['pfac_general_reqired']['lastname']);
				$dob = App_Viewer::format_date($_SESSION['pfac_general_reqired']['year']."-".$_SESSION['pfac_general_reqired']['month']."-".$_SESSION['pfac_general_reqired']['day']);
				$nationality = $_SESSION['pfac_general_reqired']['nationality'];
				$club = trim($_SESSION['pfac_player_info_non_reqired']['club']);
				$height = trim($_SESSION['pfac_player_info_non_reqired']['height']);
				$weight = trim($_SESSION['pfac_player_info_non_reqired']['weight']);
				$position = trim($_SESSION['pfac_player_info_non_reqired']['position']);
				$comment = $_SESSION['pfac_player_info_non_reqired']['comment'];																					
				$cv_path = "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."cvs".DS.trim($_SESSION['pfac_preview_cv']['name']);																					
				$video_path = "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."videos".DS.trim($_SESSION['pfac_preview_video']['name']);																					
				$img_path = "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."images".DS.trim($_SESSION['pfac_preview_img']['name']);																														
			}	
			
		}else{
		
			if ((($mode != "") && ($mode == "edit")) && ($id != 0)){
				$players_page_details = $this->grab_players_page_details($id);		
				$firstName = (isset($_SESSION['pfac_general_reqired']['firstname'])) ? trim($_SESSION['pfac_general_reqired']['firstname']) : $players_page_details[0]['first_name'];
				$lastName = (isset($_SESSION['pfac_general_reqired']['lastname'])) ? trim($_SESSION['pfac_general_reqired']['lastname']) : $players_page_details[0]['last_name'];
				if ((isset($_SESSION['pfac_general_reqired']['year'])) && (isset($_SESSION['pfac_general_reqired']['month'])) && (isset($_SESSION['pfac_general_reqired']['day']))){
					$dob = App_Viewer::format_date($_SESSION['pfac_general_reqired']['year']."-".$_SESSION['pfac_general_reqired']['month']."-".$_SESSION['pfac_general_reqired']['day']);			
				}else{	
					$dob = $players_page_details[0]['date_of_birth'];
				}	
				$nationality = (isset($_SESSION['pfac_general_reqired']['nationality'])) ? trim($_SESSION['pfac_general_reqired']['nationality']) : $players_page_details[0]['nationality'];
				$club = (isset($_SESSION['pfac_coachs_info_non_reqired']['club'])) ? trim($_SESSION['pfac_general_reqired']['club']) : $players_page_details[0]['club'];
				$comment = (isset($_SESSION['pfac_coachs_info_non_reqired']['comment'])) ? trim($_SESSION['pfac_general_non_reqired']['comment']) : $players_page_details[0]['comment'];																					
				$careers = (isset($_SESSION['pfac_coachs_info_non_reqired']['careers'])) ? trim($_SESSION['pfac_general_non_reqired']['careers']) : $players_page_details[0]['careers'];																									
				$qualifications = (isset($_SESSION['pfac_coachs_info_non_reqired']['qualifications'])) ? trim($_SESSION['pfac_general_non_reqired']['qualifications']) : $players_page_details[0]['qualifications'];																									
				$cv_path = (isset($_SESSION['pfac_preview_cv'])) ? "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."cvs".DS.trim($_SESSION['pfac_preview_cv']['name']) : $players_page_details[0]['cv_url'];																					
				$img_path = (isset($_SESSION['pfac_preview_img'])) ? "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."images".DS.trim($_SESSION['pfac_preview_img']['name']) : $players_page_details[0]['photo_url'];																														
			}else{
				$firstName = trim($_SESSION['pfac_general_reqired']['firstname']);
				$lastName = trim($_SESSION['pfac_general_reqired']['lastname']);
				$dob = App_Viewer::format_date($_SESSION['pfac_general_reqired']['year']."-".$_SESSION['pfac_general_reqired']['month']."-".$_SESSION['pfac_general_reqired']['day']);
				$nationality = $_SESSION['pfac_general_reqired']['nationality'];
				$club = trim($_SESSION['pfac_coachs_info_non_reqired']['club']);
				$qualifications = trim($_SESSION['pfac_coachs_info_non_reqired']['qualifications']);
				$comment = $_SESSION['pfac_coachs_info_non_reqired']['comment'];																					
				$careers = $_SESSION['pfac_coachs_info_non_reqired']['careers'];																					
				$cv_path = "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."cvs".DS.trim($_SESSION['pfac_preview_cv']['name']);																					
				$img_path = "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."images".DS.trim($_SESSION['pfac_preview_img']['name']);																														
			}	
			
		}
			$htmlContent_for_single_webpage = "";
			$htmlContent_for_single_webpage .= "		
						<div id=\"right-column-wide\">
							<div id=\"page-content-wide\">
								<div id=\"profile-box\">
									<div id=\"profile-box-curve-up\"><!-- --></div>
									<div id=\"profile-box-middle\">
									
									   <!-- Start of the module 1 (Photo) -->                                             
									   <img title=".$firstName." ".$lastName." 
									   src=\"".$img_path."\">
									   <!-- End of the module 2 -->                                       
									   
									   <!-- Start of the module 2 (Genral Information) -->                                 
									   <div id=\"player-infomation-box\">
											<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"data-table\">
												<tbody>
													<tr>
														<td class=\"info-blue-text\">Name</td>
														<td class=\"info-white-text\">".$firstName."&nbsp".$lastName."</td>
													</tr>
													<tr class=\"gray-row\">
														<td class=\"info-blue-text\">D.O.B.</td>
														<td class=\"info-white-text\">".$dob."</td>
													</tr>
													<tr>
														<td class=\"info-blue-text\">Nationality</td>
														<td class=\"info-white-text\">".$nationality."</td>
													</tr>";
												
												if ($_SESSION['pfac_general_reqired']['player_cat'] == 5){
													
				$htmlContent_for_single_webpage .= "<tr class=\"gray-row\">
														<td class=\"info-blue-text\">Club</td>
														<td class=\"info-white-text\">".$club."</td>
													</tr>
													<tr>
														<td class=\"info-blue-text\">Height</td>
														<td class=\"info-white-text\">".$qualifications."</td>
													</tr>";
													
												}else{
													
				$htmlContent_for_single_webpage .= "<tr class=\"gray-row\">
														<td class=\"info-blue-text\">Club</td>
														<td class=\"info-white-text\">".$club."</td>
													</tr>
													<tr>
														<td class=\"info-blue-text\">Height</td>
														<td class=\"info-white-text\">".$height."</td>
													</tr>
													<tr class=\"gray-row\">
														<td class=\"info-blue-text\">Weight</td>
														<td class=\"info-white-text\">".$weight."</td>
													</tr>
													<tr>
														<td class=\"info-blue-text\">Position</td>
														<td class=\"info-white-text\">".$position."</td>
													</tr>";
													
												}
												 
				$htmlContent_for_single_webpage	.= "</tbody>
											</table>
										</div>
									   <!-- End of the module 2 -->";                        
										
												if ($_SESSION['pfac_general_reqired']['player_cat'] != 5){
												
				$htmlContent_for_single_webpage	.= "<!-- Start of the module 3 (Player History) -->                  
									   <div id=\"player-history-box\">
											<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"data-table\">
												<tbody>
													<tr>
														<td class=\"history-blue-text-club\">Club</td>
														<td class=\"history-blue-text-appearences\">Appearences</td>
														<td class=\"history-blue-text-goals\">Goals</td>
													</tr>";
												
													if ((($mode != "") && ($mode == "edit")) && ($id != 0)){
													
														$param_array = array('club', 'appearances', 'goals');										
														$fullDetails = $this->retrive_history_details_for_single_pfac($id, $param_array, $pfac_type);																																
													
														for($i=0; $i<count($fullDetails); $i++){
															$trClass = (CommonFunctions::checkNum($i)) ? "" : "gray-row";
															
										$htmlContent_for_single_webpage .= "<tr class=".$trClass.">
															<td class=\"history-white-text-club\">".$fullDetails[$i]['club']."</td>
															<td class=\"history-white-text-appearences\">".$fullDetails[$i]['appearances']."</td>
															<td class=\"history-white-text-goals\">".$fullDetails[$i]['goals']."</td>
														</tr>";												
														}
													}else{											
														for($i=0; $i<count($_SESSION['session_data']); $i++){
															$trClass = (CommonFunctions::checkNum($i)) ? "" : "gray-row";
															
										$htmlContent_for_single_webpage .= "<tr class=".$trClass.">
															<td class=\"history-white-text-club\">".trim($_SESSION['session_data'][$i]['field_1'])."</td>
															<td class=\"history-white-text-appearences\">".trim($_SESSION['session_data'][$i]['field_2'])."</td>
															<td class=\"history-white-text-goals\">".trim($_SESSION['session_data'][$i]['field_3'])."</td>
														</tr>";												
														}
													}
												
												}else{
												
				$htmlContent_for_single_webpage	.= "<!-- Start of the module 3 (Player History) -->                  
									   <div id=\"player-history-box\">
											<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"data-table\">
												<tbody>
													<tr>
														<td class=\"history-blue-text-club\">Club</td>
														<td class=\"history-blue-text-appearences\">Position</td>
													</tr>";
												
													if ((($mode != "") && ($mode == "edit")) && ($id != 0)){
													
														$param_array = array('club', 'position');										
														$fullDetails = $this->retrive_history_details_for_single_pfac($id, $param_array, $pfac_type);																																
													
														for($i=0; $i<count($fullDetails); $i++){
															$trClass = (CommonFunctions::checkNum($i)) ? "" : "gray-row";
															
										$htmlContent_for_single_webpage .= "<tr class=".$trClass.">
															<td class=\"history-white-text-club\">".$fullDetails[$i]['club']."</td>
															<td class=\"history-white-text-appearences\">".$fullDetails[$i]['position']."</td>
														</tr>";												
														}
													}else{											
														for($i=0; $i<count($_SESSION['session_data']); $i++){
															$trClass = (CommonFunctions::checkNum($i)) ? "" : "gray-row";
															
										$htmlContent_for_single_webpage .= "<tr class=".$trClass.">
															<td class=\"history-white-text-club\">".trim($_SESSION['session_data'][$i]['field_1'])."</td>
															<td class=\"history-white-text-appearences\">".trim($_SESSION['session_data'][$i]['field_2'])."</td>
														</tr>";												
														}
													}
													
												}
													
			$htmlContent_for_single_webpage .=	"</tbody>
											</table>
									   </div>
									   <!-- End of the module 3 -->        
													
									</div>
									<div id=\"profile-box-curve-down\"><!-- --></div>
								 </div>
								<div id=\"profile-box-bottom\">";
								
								if ($_SESSION['pfac_general_reqired']['player_cat'] != 5){								
								
$htmlContent_for_single_webpage	.= "<!-- Start of the module 4 (video) -->        
									<div id=\"player-video\"><object width=\"450\" height=\"390\" flashvars=\"path=http://devel.profootballagency.com/_videos/video-player-grey.swf&amp;skinPath=http://devel.profootballagency.com/_videos/video-player-skin.swf&amp;videoPath=".$video_path."&amp;videoAutoPlay=false\" data=\"http://devel.profootballagency.com/_videos/video-player-grey.swf\" type=\"application/x-shockwave-flash\"><param value=\"http://devel.profootballagency.com/_videos/video-player-grey.swf\" name=\"movie\"><param value=\"path=http://devel.profootballagency.com/_videos/video-player-grey.swf&amp;skinPath=http://devel.profootballagency.com/_videos/video-player-skin.swf&amp;videoPath=".$video_path."&amp;videoAutoPlay=false\" name=\"FlashVars\"></object></div>
									<!-- End of the module 4 -->";
									
								}else{
											
$htmlContent_for_single_webpage	.= "<div id=\"career-highlights\" class=\"ul_simillar\" style=\"padding-top:35px;\">{$careers}</div>";
								
								}
												
$htmlContent_for_single_webpage	.= "<!-- Start of the module 5 (comments and more) -->
									<div id=\"quote\">
										<span><!-- --></span>
										<p>".$comment."</p>
									</div>
									<div id=\"more-box\">
										<h2><em>More About</em></h2>
										<div class=\"more-box-data-row\">
											<span><a href=\"/contact-us/\" title=\"Contact Us\">Enquire about this player</a></span>
											<span><a target=\"_blank\" title=\"Download CV\" href=\"".$cv_path.">Download CV</a></span>
										</div>
									</div>
									<!-- End of the module 5 -->
									
								</div>
							</div>
						</div>";
					
			return $htmlContent_for_single_webpage;
	}
	/* End of the function */
	
	/* This function will return the player category name for a given id */
	function display_pfa_categoryName_by_pfac_id($id){
		
		global $connection;
		$sql = "SELECT pfac__players_categories.player_category_name 
				FROM pfac__players_categories
				JOIN pfac__genral_details ON pfac__players_categories.id = pfac__genral_details.player_Cat_id
				WHERE pfac__genral_details.id = ".$id;
		return AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query($sql), 0);
	}
	/* End of the function */

	/* This function will return the player category name for a given id */
	function display_pfa_categoryName_by_id($id){
		
		global $connection;
		$sql = "SELECT player_category_name FROM pfac__players_categories WHERE id = ".$id;
		return AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query($sql), 0);
	}
	/* End of the function */
	
	/* This function will retrieve all pfa clients in to display */
	function display_all_pfa_clients($params, $curr_page_no = NULL, $sortBy = "", $sortMethod = ""){
	
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
			$sort = " ORDER BY pfac__genral_details.id DESC";				
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";				
		$sql = "SELECT pfac__genral_details.id AS pfac_id, pfac__genral_details.first_name AS firstName, pfac__genral_details.last_name AS lastName, pfac__genral_details.date_of_birth AS dob, 
					   pfac__genral_details.webpage_url, 
					   pfac__genral_details.nationality AS Nationality, pfac__genral_details.club AS Club,
					   pfac__contact_details.contract_start_date, pfac__contact_details.contract_end_date, 
					   pfac__players_categories.player_category_name as playerCatName 
				FROM 
					  pfac__genral_details JOIN pfac__contact_details ON pfac__contact_details.PFAC_id = pfac__genral_details.id
					  JOIN pfac__players_categories ON pfac__players_categories.id = pfac__genral_details.player_Cat_id {$sort}{$limit}";								
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);				
	}
	/* End of the fucntion */
	
	/* This function will retrieve the count for all pfa clients in to display */
	function display_count_on_all_pfa_clients(){
	
		global $connection;
		$sql = "SELECT pfac__genral_details.id AS pfac_id, pfac__genral_details.first_name AS firstName, pfac__genral_details.last_name AS lastName, pfac__genral_details.date_of_birth AS dob, 
					   pfac__genral_details.nationality AS Nationality, pfac__genral_details.club AS Club, pfac__contact_details.home_address AS homeAddress, 
					   pfac__genral_details.webpage_url, 					   
					   pfac__genral_details.nationality AS Nationality, pfac__genral_details.club AS Club,
					   pfac__contact_details.contract_start_date, pfac__contact_details.contract_end_date, 
					   pfac__players_categories.player_category_name as playerCatName 
				FROM 
					  pfac__genral_details JOIN pfac__contact_details ON pfac__contact_details.PFAC_id = pfac__genral_details.id
					  JOIN pfac__players_categories ON pfac__players_categories.id = pfac__genral_details.player_Cat_id ORDER BY pfac__genral_details.id DESC";								
		return AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query($sql));				
	}
	/* End of the fucntion */	
	
	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_general_details_for_single_pfac($pfac_id, $params){
	
		global $connection;
		$sql = "SELECT pfac__genral_details.* FROM pfac__genral_details 
						WHERE pfac__genral_details.id = {$pfac_id}";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);				
	}
	/* End of the fucntion */

	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_contact_details_for_single_pfac($pfac_id, $params){

		global $connection;
		$sql = "SELECT pfac__contact_details.* FROM pfac__contact_details 
						WHERE pfac__contact_details.PFAC_id = {$pfac_id}";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);				
	}
	/* End of the fucntion */		
	
	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_history_details_for_single_pfac($pfac_id, $params, $pfac_type){
	
		global $connection;
		$table_name = ($pfac_type == 5) ? "pfac__coaches_history" : "pfac__players_history";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT * FROM {$table_name} WHERE PFAC_id = {$pfac_id}"), $params);				
	}
	/* End of the fucntion */			
	
	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_media_details_for_single_pfac($pfac_id, $params){
	
		global $connection;
		$sql = "SELECT pfac__genral_details.cv_url, pfac__genral_details.photo_url, pfac__genral_details.video_url, pfac__genral_details.webpage_url FROM pfac__genral_details 
						WHERE pfac__genral_details.id = {$pfac_id}";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);				
	}
	/* End of the fucntion */				
	
	/* This function will delete the pfac general details for a given pfac_id */
	function delete_record_in_general_view($pfac_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfac__genral_details WHERE pfac__genral_details.id = {$pfac_id}");						
	}
	/* End of the function */
	
	/* This function will delete the pfac general details for a given pfac_id */
	function delete_record_in_contact_view($pfac_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfac__contact_details WHERE pfac__contact_details.PFAC_id = {$pfac_id}");						
	}
	/* End of the function */

	/* This function will delete the pfac general details for a given pfac_id */
	function delete_record_in_history_view($pfac_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfac__players_history WHERE pfac__players_history.PFAC_id = {$pfac_id}");						
	}
	/* End of the function */		
	
	/* This function will retrieve some details which reqired to display in the player's web page */
	function grab_players_page_details($id){
	
		global $connection;
		$sql = "SELECT 
					pfac__genral_details.first_name, pfac__genral_details.last_name, pfac__genral_details.date_of_birth, pfac__genral_details.nationality,
					pfac__genral_details.club, pfac__genral_details.height, pfac__genral_details.weight, pfac__genral_details.position, 
					pfac__genral_details.comment, pfac__genral_details.photo_url, pfac__genral_details.video_url, pfac__genral_details.cv_url, 
					pfac__genral_details.webpage_url, pfac__players_categories.player_category_name 
				FROM pfac__genral_details
				LEFT JOIN pfac__players_categories ON  pfac__players_categories.id = pfac__genral_details.player_Cat_id
				WHERE pfac__genral_details.id = ".$id;
		$params = array('first_name', 'last_name', 'date_of_birth', 'nationality', 'club', 'height', 'weight', 'position', 'comment', 'photo_url', 'video_url', 'cv_url', 'webpage_url', 'player_category_name');		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);							
	}
	/* End of the function */
	
	/* This function will retrieve media details per each given parameter */
	function grab_player_single_information_for_the_pfac($title, $pfac_id){
	
		global $connection;
		return AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query("SELECT {$title} FROM pfac__genral_details WHERE id = {$pfac_id}"), 0);														
	}
	/* End of the fucntion */	
	
	/* This function will retireve the count of the player history details for restrict */
	function retrieve_count_of_player_history($pfac_id){
	
		global $connection;
		return AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT * FROM pfac__players_history WHERE PFAC_id =".$pfac_id));																
	}
	/* End of the function */	
	
	/* This function will load all neccessary details for the single view */
	function grab_full_details_for_the_single_view($pfac_id){
	
		global $connection;
		$sql = "SELECT 
					pfac__genral_details.id, pfac__genral_details.first_name, pfac__genral_details.last_name, pfac__genral_details.date_of_birth, pfac__genral_details.nationality,
					pfac__genral_details.club, pfac__genral_details.height, pfac__genral_details.weight, pfac__genral_details.position, 
					pfac__genral_details.cv_url, pfac__genral_details.video_url, pfac__genral_details.photo_url,
					pfac__genral_details.comment, pfac__genral_details.webpage_url, pfac__players_categories.player_category_name,
					pfac__contact_details.home_address, pfac__contact_details.home_phone, pfac__contact_details.overseas_address, pfac__contact_details.overseas_mobile,  
					pfac__contact_details.email, pfac__contact_details.passport_no, pfac__contact_details.exact_name_on_passport, pfac__contact_details.emergency_contact_name,  					   
					pfac__contact_details.emergency_contact_no
				FROM pfac__genral_details
				LEFT JOIN pfac__players_categories ON  pfac__players_categories.id = pfac__genral_details.player_Cat_id
				LEFT JOIN pfac__contact_details ON  pfac__contact_details.PFAC_id = pfac__genral_details.id				
				WHERE pfac__genral_details.id = ".$pfac_id;
		$params = array(
						'id', 'first_name', 'last_name', 'date_of_birth', 'nationality', 'club', 'height', 'weight', 'position', 'comment', 'webpage_url', 'player_category_name',
						'home_address', 'home_phone', 'overseas_address', 'overseas_mobile', 'email', 'passport_no', 'exact_name_on_passport', 'emergency_contact_name', 
						'emergency_contact_no', 'photo_url', 'video_url', 'cv_url'
						);		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);							
	}
	/* End of the fucntion */
	
	/* This function will load all notes categories related to the client type */
	function retrieve_all_notes_categories_related_to_client_type($clientType){
	
		global $connection;
		$params = array('id', 'note_cat_name');	
		$sql = "SELECT id, note_cat_name FROM pfagos__notes_categories WHERE agent_or_player_type = '{$clientType}'";	
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);									
	}
	/* End of the function */
	
	/* This function will insert a new note to the datbase */
	function insert_new_note($notes_params){
	
		global $connection;
		$sql = "INSERT INTO pfagos__notes
							(note_cat_id, note_owner_id, note_owner_type, note, date_added, added_by) 
							VALUES(".
									$notes_params['note_cat_id'].",".
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
							note_cat_id = ". $notes_params['note_cat_id'] .",			
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

	/* This function will delete all the notes which owned by given pfac_id */
	function delete_owned_notes($pfac_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfagos__notes WHERE pfagos__notes.note_owner_id = {$pfac_id}");						
	}
	/* End of the function */		
	
	/* This function will retrieve all notes with other details regarding to the client */
	function retrieve_all_notes_owned_by_this_client($note_owner_id, $param_array){
	
		global $connection;
		$sql = "SELECT * FROM pfagos__notes WHERE note_owner_id = {$note_owner_id} AND note_owner_type = 'PFAC'";	
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
		$sql = "SELECT pfagos__notes.note_id, pfagos__notes_categories.note_cat_name, pfagos__notes.note_owner_id, 
					   pfagos__notes.note, pfagos__notes.date_modified, pfagos__notes.modified_by, pfagos__notes.date_added, pfagos__notes.added_by 
				FROM pfagos__notes 
				LEFT JOIN pfagos__notes_categories ON pfagos__notes_categories.id = pfagos__notes.note_cat_id
				WHERE pfagos__notes_categories.agent_or_player_type = 'PFAC' 
				AND pfagos__notes.note_owner_id = {$note_owner_id} {$sort}{$limit}";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $param_array);									
	}
	/* End of the fucntion */

	/* This function will retrieve all notes count regarding to the client */
	function retrieve_all_notes_count_owned_by_this_client_only_for_the_edit_view($note_owner_id, $param_array){
	
		global $connection;
		$sql = "SELECT pfagos__notes.note_id, pfagos__notes_categories.note_cat_name, pfagos__notes.note_owner_id, 
					   pfagos__notes.note, pfagos__notes.date_modified, pfagos__notes.modified_by 
				FROM pfagos__notes 
				LEFT JOIN pfagos__notes_categories ON pfagos__notes_categories.id = pfagos__notes.note_cat_id
				WHERE pfagos__notes_categories.agent_or_player_type = 'PFAC' 
				AND pfagos__notes.note_owner_id = {$note_owner_id}";	
		return AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query($sql));						
	}
	/* End of the fucntion */
	
	/* This function will insert session data regarding to the general view in to database */
	function update_general_info_regarding_the_media_view_change($pfac_id, $media_details){
		
		global $connection;
		$sql = "UPDATE pfac__genral_details
						SET
							photo_url = '". CommonFunctions::mysql_preperation(trim($media_details['photo_url'])) ."',
							video_url = '". CommonFunctions::mysql_preperation(trim($media_details['video_url'])) ."',
							cv_url = '". CommonFunctions::mysql_preperation(trim($media_details['cv_url'])) ."',
							webpage_url = '". CommonFunctions::mysql_preperation(trim($media_details['webpage_url'])) ."'
						WHERE id = ". $pfac_id;
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the function */		
	
	/* This function will retrieve note category name for the its cat id */
	function retrieve_full_details_of_selected_note($note_id, $param_array){
	
		global $connection;
		$sql = "SELECT pfagos__notes.note, pfagos__notes.note_cat_id, pfagos__notes_categories.note_cat_name, pfagos__notes.date_modified, 
					   pfagos__notes.modified_by, pfagos__notes.date_added, pfagos__notes.added_by 
				FROM pfagos__notes 
				LEFT JOIN pfagos__notes_categories ON pfagos__notes_categories.id = pfagos__notes.note_cat_id
				WHERE pfagos__notes.note_id = {$note_id}";	
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $param_array);									
	}
	/* End of the function */
	
	/* This function will clear session data regrd to currently inserting agent */
	function clear_session_info_regard_to_this_agent($session_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfagos__session_data WHERE session_id = '{$session_id}'");		
	}
	/* End of the function */
	
	/* This function will check whether the given pfac id from the get value is exist in database */
	function check_pfac_id_exist($id){
	
		global $connection;
		return (AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT id FROM pfac__genral_details WHERE id = {$id}")) != "") ? true : false;																
	}
	/* End of the function */	
	
	/* This function will check whethr the client note id exist in the database before any further action */
	function check_note_id_exist($note_id){
	
		global $connection;
		return (AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT note_id FROM pfagos__notes WHERE note_id = {$note_id}")) != "") ? true : false;																
	}
	/* End of the fucntion */
	
	/* This function will check the given note id is owned by the given client */
	function check_note_id_owned_by_the_correct_client($pfac_id, $note_id){	

		global $connection;
		$pfac_id_in_db = AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query("SELECT note_owner_id FROM pfagos__notes WHERE note_id = {$note_id}"), 0);																
		return ($pfac_id == $pfac_id_in_db) ? true : false;
	}		
	/* End of the function */
	
	/* This function will retrieve the note cat name for the given note id */
	function retrieve_note_cat_name($note_id){
	
		global $connection;
		$sql = "SELECT pfagos__notes_categories.note_cat_name FROM pfagos__notes_categories 
				LEFT JOIN pfagos__notes ON pfagos__notes.note_cat_id = pfagos__notes_categories.id
				WHERE pfagos__notes.note_id = {$note_id}
				AND pfagos__notes_categories.agent_or_player_type = 'PFAC'";		
		return AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query($sql), 0);				
	} 
	/* End of the fucntion */
	
	/* This function will insert log details every time against the user action */
	function keep_track_of_activity_log_in_pfac($logParmas){
	
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
	
	/* This function will check the given note id is owned by the given client */
	function check_history_id_owned_by_the_correct_client($pfac_id, $history_id){	

		global $connection;
		$pfac_id_in_db = AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query("SELECT PFAC_id FROM pfac__players_history WHERE pfac_history_id = {$history_id}"), 0);																
		return ($pfac_id == $pfac_id_in_db) ? true : false;
	}		
	/* End of the function */
	
	/* This function will Configure the action panel with against user permissions */
	function generate_action_panel_with_user_related_permissions($logged_user_permissions, $site_config, $view, $mode="", $pfac_id=""){

		$action_panel_menu = array();	
		$action_panel = array(
								array(
										"menu_id" => 1,
										"menu_text" => "Add / Edit Note",
										"menu_url" => $site_config['base_url']."pfac/edit/?mode=notes".
										(
										(($_GET['mode'] != "general") && 
										($_GET['mode'] != "contact") && 
										($_GET['mode'] != "history") && 
										($_GET['mode'] != "edit-media")										
										) ? $mode : ""),
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
										"menu_url" => $site_config['base_url']."pfac/edit/?mode=".(($_GET['mode'] != "notes") ? ((($view == "view") || ($view == "show")) ? "general" : $mode) : "general"),
										"menu_img" => "<img src=\"../../public/images/b_edit.png\" border=\"0\" alt=\"Edit\" />",
										"menu_permissions" => array(2, 3, 4)
									),	
								array(
										"menu_id" => 4,
										"menu_text" => "Drop",
										"menu_url" => $site_config['base_url']."pfac/drop/",
										"menu_img" => "<img src=\"../../public/images/b_drop.png\" border=\"0\" alt=\"Drop\" />",
										"menu_permissions" => array(4)
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
		return (($mode != "") ? $this->filter_action_panel_buttons_in_subview($action_panel_menu, $pfac_id, $mode, $site_config) : $action_panel_menu);
	}
	/* End of the function */
	
	/* This function will again filter the action panel buttons according to correct sub view */
	function filter_action_panel_buttons_in_subview($action_panel_menu, $pfac_id, $mode, $site_config){

		$filtered_action_panel_menu = "";
		foreach($action_panel_menu as $eachMenu){

				if (!strstr($eachMenu['menu_url'], $mode)){

					if ($eachMenu['menu_text'] == "Drop"){
             
						$filtered_action_panel_menu	.= "<a href='#' onclick='return ask_for_delete_record(\"".$site_config['base_url']."pfac/drop/?pfac_id=".$pfac_id."\");' 
														title='".$eachMenu['menu_text']."'>".$eachMenu['menu_img']."</a>";                    
	
					}else{

						$filtered_action_panel_menu .= " <a title='".$eachMenu['menu_text']."' href='".$eachMenu['menu_url'].
													   (((($eachMenu['menu_text'] == "Details") || ($eachMenu['menu_text'] == "Drop")) ? "?" : "&").("pfac_id=".$pfac_id)).
													   (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
													   (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "").
													   "'>".$eachMenu['menu_img']." </a>";
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
}
?>