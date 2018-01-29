<?php

class cfcp_model extends AppModel{
	
	/* THis function will do the validation for the PFAC general view */	
	function validate_general_view($posted){

		return AppModel::validate($posted);
	}
	/* End of the function */
	
	/* This function will return all player categories for PFAC clients */	
	function display_all_cfcp_categories($params){
	
		global $connection;
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT * FROM cfcp__players_categories"), $params);		
	}
	/* End of the function */

	/* This function will return all player categories for PFAC clients */	
	function display_all_cfcp_teams($params){
	
		global $connection;
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT * FROM cfcp__teams"), $params);		
	}
	/* End of the function */
	
	/* This function will insert pfac history session data to the pfagos_session_table */
	function keep_session_data($session_param_array){

		global $connection;
		$sql = "INSERT INTO pfagos__session_data (session_id, field_1, field_2, field_3, field_4) VALUES("; 
		$i=0;
		foreach($session_param_array as $field => $value){
			$i++;
			$sql .= "'".CommonFunctions::mysql_preperation(trim($value))."'"; 
			if ($i == 5){ break; } else { $sql .= ","; }
		}
		$sql .= ")";		
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */
	
	/* This fucntion will retrieve data from the pfagos_session_data table */
	function grab_session_data($session_id, $params){

		global $connection;
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT id, field_1, field_2, field_3, field_4 FROM pfagos__session_data WHERE session_id = '" . $session_id . "'"), $params);				
	}
	/* End of the fucntion */
	
	/* This fucntion will remove data from the pfagos_session_data table */
	function drop_session_data($id){

		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfagos__session_data WHERE id = " . $id);				
	}
	/* End of the fucntion */	

	/* This fucntion will remove data from the cfcp_history table */
	function drop_history_data($history_id){

		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM cfcp__players_history WHERE id = " . $history_id);				
	}
	/* End of the fucntion */

	/* This function will insert session data regarding to the general view in to database */
	function insert_general_info($general_info_required_param, $general_info_Non_required_param, $timeStamp){
		
		global $connection;
		$dob = $general_info_required_param['year']."-".$general_info_required_param['month']."-".$general_info_required_param['day'];
		$sql = "INSERT INTO cfcp__personel_details
							(team_id, first_name, last_name, nickname1, nickname2, date_of_birth, date_created) 
							VALUES(".
									$general_info_required_param['team_cat'].",'".							
									CommonFunctions::mysql_preperation(trim($general_info_required_param['firstname']))."','".
									CommonFunctions::mysql_preperation(trim($general_info_required_param['lastname']))."','".
									CommonFunctions::mysql_preperation(trim($general_info_Non_required_param['nickname1']))."','".									
									CommonFunctions::mysql_preperation(trim($general_info_Non_required_param['nickname2']))."','".																		
									$dob."','".
									$timeStamp.
							    "')";
		AppModel::grab_db_function_class()->execute_query($sql);
		return AppModel::grab_db_function_class()->return_last_inserted_id();				
	}
	/* End of the function */
	
	/* This function will insert session data regarding to the general view in to database */
	function update_general_info($cfcp_id, $general_info_required_param, $general_info_Non_required_param, $birth_certificate){

		global $connection;
		$dob = $general_info_required_param['year']."-".$general_info_required_param['month']."-".$general_info_required_param['day'];
		$sql = "UPDATE cfcp__personel_details
						SET
							team_id = ". $general_info_required_param['team_cat'] .",
							first_name 	 = '". CommonFunctions::mysql_preperation(trim($general_info_required_param['firstname'])) ."',
							last_name = '". CommonFunctions::mysql_preperation(trim($general_info_required_param['lastname'])) ."',
							nickname1 = '". CommonFunctions::mysql_preperation(trim($general_info_Non_required_param['nickname1'])) ."',																				
							nickname2 = '". CommonFunctions::mysql_preperation(trim($general_info_Non_required_param['nickname2'])) ."',																											
							date_of_birth = '". $dob ."'
						WHERE id = ". $cfcp_id;
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the function */	
	
	/* This function will insert session data regarding to the contact view in to the databse */
	function insert_senior_info($cfcp_id, $senior_info_required_param, $senior_info_non_required_param, $player_page, $media_details){		
		
		global $connection;
		$sql = "INSERT INTO cfcp__senior_palyer_details
							(CFCP_id, player_cat_id, height, weight, place_of_birth, position, coach_comment, player_web_page, video_url, photo_url, webpage_url) 
							VALUES(".
									$cfcp_id.",".
									CommonFunctions::mysql_preperation(trim($senior_info_required_param['player_cat'])).",'".
									CommonFunctions::mysql_preperation(trim($senior_info_required_param['height']))."','".
									CommonFunctions::mysql_preperation(trim($senior_info_required_param['weight']))."','".
									CommonFunctions::mysql_preperation(trim($senior_info_required_param['birth_place']))."','".
									CommonFunctions::mysql_preperation(trim($senior_info_required_param['pos']))."','".
									CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['coh_comment']))."','".
									CommonFunctions::mysql_preperation($player_page)."','".
									CommonFunctions::mysql_preperation(trim($media_details['video_url']))."','".
									CommonFunctions::mysql_preperation(trim($media_details['photo_url']))."','".
									CommonFunctions::mysql_preperation(trim($media_details['webpage_url'])).									
							"')"; 
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */
	
	/* This function will insert session data regarding to the contact view in to the databse */
	function insert_contact_info($cfcp_id, $contact_info_required_param, $contact_info_non_required_param){		
		
		global $connection;
		$sql = "INSERT INTO cfcp__contact_details
							(CFCP_id, home_address, mobile_no, email, father_name, father_contact_no, father_occupation, mother_name, mother_contact_no, mother_occupation,
							 parents_address, passport_no, exact_name_passport) 
							VALUES(".
									$cfcp_id.",'".
									CommonFunctions::mysql_preperation(trim($contact_info_required_param['homeadd']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['mob_no']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['email']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['father_name']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['father_con_no']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['father_occupation']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['mother_name']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['mother_con_no']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['mother_occupation']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['parent_add']))."','".								
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['passport_no']))."','".
									CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['exact_name_pass'])).																		
							"')"; 
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */
	
	/* This function will update senior details */
	function update_senior_player_info($senior_info_required_param, $senior_info_non_required_param, $webpage_url, $cfcp_id){						
;
		global $connection;
		$cfcp_id_in_db = $this->check_cfcp_has_previous_senior_details($cfcp_id);
		if ($cfcp_id_in_db == ""){
			$sql = "INSERT INTO cfcp__senior_palyer_details
								SET
									CFCP_id = ". $cfcp_id .",
									player_cat_id = ". CommonFunctions::mysql_preperation(trim($senior_info_required_param['player_cat'])) .",
									height = '". CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['height'])) ."',
									weight = '". CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['weight'])) ."',
									place_of_birth = '". CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['birth_place'])) ."',
									position = '". CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['pos'])) ."',
									coach_comment = '". CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['coh_comment'])) ."',
									player_web_page = '". $webpage_url ."'"; 
		}else{
			$sql = "UPDATE cfcp__senior_palyer_details
								SET
									player_cat_id = ". CommonFunctions::mysql_preperation(trim($senior_info_required_param['player_cat'])) .",
									height = '". CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['height'])) ."',
									weight = '". CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['weight'])) ."',
									place_of_birth = '". CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['birth_place'])) ."',
									position = '". CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['pos'])) ."',
									coach_comment = '". CommonFunctions::mysql_preperation(trim($senior_info_non_required_param['coh_comment'])) ."',
									player_web_page = '". $webpage_url ."'
								WHERE CFCP_id =". $cfcp_id; 
		}
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */
	
	/* This function will insert session data regarding to the contact view in to the databse */
	function update_contact_info($contact_info_non_required_param, $cfcp_id){		

		global $connection;
		$sql = "UPDATE cfcp__contact_details
							SET
								home_address = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['homeadd'])) ."',
								mobile_no = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['mob_no'])) ."',
								email = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['email'])) ."',
								father_name = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['father_name'])) ."',
								father_contact_no = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['father_con_no'])) ."',
								father_occupation = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['father_occupation'])) ."',
								mother_name = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['mother_name'])) ."',
								mother_contact_no = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['mother_con_no'])) ."',
								mother_occupation = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['mother_occupation'])) ."',
								parents_address = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['parent_add'])) ."',	
								passport_no = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['passport_no'])) ."',
								exact_name_passport = '". CommonFunctions::mysql_preperation(trim($contact_info_non_required_param['exact_name_pass'])) ."'
							WHERE CFCP_id = ". $cfcp_id; 
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */

	/* This function will insert session data regarding to the contact view in to the databse */
	function insert_other_info($cfcp_id, $other_info_required_param, $other_info_non_required_param, $uploaded_files_params, $reg_card_status){		
		
		global $connection;
		$boots_received = $other_info_non_required_param['year']."-".$other_info_non_required_param['month']."-".$other_info_non_required_param['day'];		
		$sql = "INSERT INTO cfcp__other_details
							(CFCP_id, school, current_class, boot_size, boots_received, position1, position2, birth_certificate_url, registration_card_status, 
									reg_card_url, passport_scan_url) 
							VALUES(".
									$cfcp_id.",'".
									CommonFunctions::mysql_preperation(trim($other_info_required_param['school']))."','".
									CommonFunctions::mysql_preperation(trim($other_info_required_param['curr_class']))."','".
									CommonFunctions::mysql_preperation(trim($other_info_non_required_param['boot_size']))."','".
									$boots_received."','".
									CommonFunctions::mysql_preperation(trim($other_info_required_param['position1']))."','".
									CommonFunctions::mysql_preperation(trim($other_info_non_required_param['position2']))."','".									
									$uploaded_files_params['birth_certificate']."','".
									$reg_card_status."','".
									$uploaded_files_params['reg_card']."','".
									$uploaded_files_params['passport_scan'].									
								"')"; 
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */
	
	/* This function will update other information */
	function update_other_info($other_info_param, $uploaded_files_params, $cfcp_id){		

		global $connection;
		$boots_received = $other_info_param['year']."-".$other_info_param['month']."-".$other_info_param['day'];		
		$sql = "UPDATE cfcp__other_details
							SET
								school = '". CommonFunctions::mysql_preperation(trim($other_info_param['school'])) ."',
								current_class = '". CommonFunctions::mysql_preperation(trim($other_info_param['curr_class'])) ."',
								boot_size = '". CommonFunctions::mysql_preperation(trim($other_info_param['boot_size'])) ."',
								boots_received  = '". $boots_received ."',
								position1 = '". CommonFunctions::mysql_preperation(trim($other_info_param['position1'])) ."',
								position2 = '". CommonFunctions::mysql_preperation(trim($other_info_param['position2'])) ."',								
								reg_card_url = '". CommonFunctions::mysql_preperation(trim($uploaded_files_params['reg_card'])) ."',
								birth_certificate_url = '". CommonFunctions::mysql_preperation(trim($uploaded_files_params['birth_certificate'])) ."',								
								passport_scan_url = '". CommonFunctions::mysql_preperation(trim($uploaded_files_params['passport_scan'])) ."'																
							WHERE CFCP_id = ". $cfcp_id; 
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the fucntion */
	
	/* This function will insert session data regarding to the contact view in to the databse */
	function insert_history_info($cfcp_id, $history_info, $mode=""){

		global $connection;
		if ($mode == "edit"){
			$sql = "INSERT INTO cfcp__players_history
					(CFCP_id, season, team, appearances, goals, newly_inserted)
					VALUES(".$cfcp_id.",'".CommonFunctions::mysql_preperation(trim($history_info['season']))."','".
										   CommonFunctions::mysql_preperation(trim($history_info['team']))."','".					
										   CommonFunctions::mysql_preperation(trim($history_info['appearances']))."','".
										   CommonFunctions::mysql_preperation(trim($history_info['goals']))."','yes')"; 
			AppModel::grab_db_function_class()->execute_query($sql);																		
		}else{			
			for($i=0; $i<count($history_info); $i++){		
				$sql = "INSERT INTO cfcp__players_history
								(CFCP_id, season, team, appearances, goals)
								VALUES(".$cfcp_id.",'".CommonFunctions::mysql_preperation(trim($history_info[$i]['field_1']))."','".
													   CommonFunctions::mysql_preperation(trim($history_info[$i]['field_2']))."','".								
													   CommonFunctions::mysql_preperation(trim($history_info[$i]['field_3']))."','".
													   CommonFunctions::mysql_preperation(trim($history_info[$i]['field_4'])).
									  "')"; 
			AppModel::grab_db_function_class()->execute_query($sql);													
			}					
		}					
	}
	/* End of the fucntion */

	/* This function will load html content for the player's single web page */
	function create_or_update_single_web_for_cfcp_player($mode="", $id=0){
	
		if ((($mode != "") && ($mode == "edit")) && ($id != 0)){
			$players_page_details = $this->grab_players_page_details($id);		
			$firstName = (isset($_SESSION['cfcp_general_reqired']['firstname'])) ? trim($_SESSION['cfcp_general_reqired']['firstname']) : $players_page_details[0]['first_name'];
			$lastName = (isset($_SESSION['cfcp_general_reqired']['lastname'])) ? trim($_SESSION['cfcp_general_reqired']['lastname']) : $players_page_details[0]['last_name'];
			if ((isset($_SESSION['cfcp_general_reqired']['year'])) && (isset($_SESSION['cfcp_general_reqired']['month'])) && (isset($_SESSION['cfcp_general_reqired']['day']))){
				$dob = App_Viewer::format_date($_SESSION['cfcp_general_reqired']['year']."-".$_SESSION['cfcp_general_reqired']['month']."-".$_SESSION['cfcp_general_reqired']['day']);			
			}else{	
				$dob = $players_page_details[0]['date_of_birth'];
			}	
			$height = (isset($_SESSION['cfcp_senior_reqired']['height'])) ? trim($_SESSION['cfcp_senior_reqired']['height']) : $players_page_details[0]['height'];
			$weight = (isset($_SESSION['cfcp_senior_reqired']['weight'])) ? trim($_SESSION['cfcp_senior_reqired']['weight']) : $players_page_details[0]['weight'];
			$place_of_birth = (isset($_SESSION['cfcp_senior_reqired']['birth_place'])) ? trim($_SESSION['cfcp_senior_reqired']['birth_place']) : $players_page_details[0]['place_of_birth'];			
			$position = (isset($_SESSION['cfcp_senior_reqired']['pos'])) ? trim($_SESSION['cfcp_senior_reqired']['pos']) : $players_page_details[0]['position'];
			$comment = (isset($_SESSION['cfcp_senior_non_reqired']['coh_comment'])) ? trim($_SESSION['cfcp_senior_non_reqired']['coh_comment']) : $players_page_details[0]['coach_comment'];																					
			$video_path = (isset($_SESSION['cfcp_preview_video'])) ? "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."videos".DS.trim($_SESSION['cfcp_preview_video']['name']) : $players_page_details[0]['video_url'];																					
			$img_path = (isset($_SESSION['cfcp_preview_img'])) ? "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."images".DS.trim($_SESSION['cfcp_preview_img']['name']) : $players_page_details[0]['photo_url'];																														
		}else{
			$firstName = trim($_SESSION['cfcp_general_reqired']['firstname']);
			$lastName = trim($_SESSION['cfcp_general_reqired']['lastname']);
			$dob = App_Viewer::format_date($_SESSION['cfcp_general_reqired']['year']."-".$_SESSION['cfcp_general_reqired']['month']."-".$_SESSION['cfcp_general_reqired']['day']);
			$height = trim($_SESSION['cfcp_senior_reqired']['height']);
			$weight = trim($_SESSION['cfcp_senior_reqired']['weight']);
			$place_of_birth = trim($_SESSION['cfcp_senior_reqired']['birth_place']);
			$position = trim($_SESSION['cfcp_senior_reqired']['pos']);
			$comment = $_SESSION['cfcp_senior_non_reqired']['coh_comment'];																					
			$video_path = "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."videos".DS.trim($_SESSION['cfcp_preview_video']['name']);																					
			$img_path = "http://".$_SERVER['HTTP_HOST'].DS."user_uploads".DS."images".DS.trim($_SESSION['cfcp_preview_img']['name']);																														
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
													<td class=\"info-blue-text\">Place of Birth</td>
													<td class=\"info-white-text\">".$place_of_birth."</td>
												</tr>
												<tr class=\"gray-row\">
													<td class=\"info-blue-text\">Height</td>
													<td class=\"info-white-text\">".$height."</td>
												</tr>
												<tr>
													<td class=\"info-blue-text\">Weight</td>
													<td class=\"info-white-text\">".$weight."</td>
												</tr>
												<tr class=\"gray-row\">
													<td class=\"info-blue-text\">Position</td>
													<td class=\"info-white-text\">".$position."</td>
												</tr>
											</tbody>
										</table>
									</div>
								   <!-- End of the module 2 -->                        
									
								   <!-- Start of the module 3 (Player History) -->                  
								   <div id=\"player-history-box\">
										<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"data-table\">
											<tbody><tr>
												<td class=\"history-blue-text-club\">Club</td>
												<td class=\"history-blue-text-appearences\">Appearences</td>
												<td class=\"history-blue-text-goals\">Goals</td>
											</tr>";
											
											if ((($mode != "") && ($mode == "edit")) && ($id != 0)){
											
												$param_array = array('season', 'appearances', 'goals');										
												$fullDetails = $this->retrive_history_details_for_single_cfcp($id, $param_array);																																
											
												for($i=0; $i<count($fullDetails); $i++){
													$trClass = (CommonFunctions::checkNum($i)) ? "" : "gray-row";
													
								$htmlContent_for_single_webpage .= "<tr class=".$trClass.">
													<td class=\"history-white-text-club\">".$fullDetails[$i]['season']."</td>
													<td class=\"history-white-text-appearences\">".$fullDetails[$i]['appearances']."</td>
													<td class=\"history-white-text-goals\">".$fullDetails[$i]['goals']."</td>
												</tr>";												
												}
											}else{											
												for($i=0; $i<count($_SESSION['cfcp_session_data']); $i++){
													$trClass = (CommonFunctions::checkNum($i)) ? "" : "gray-row";
													
								$htmlContent_for_single_webpage .= "<tr class=".$trClass.">
													<td class=\"history-white-text-club\">".trim($_SESSION['cfcp_session_data'][$i]['field_1'])."</td>
													<td class=\"history-white-text-appearences\">".trim($_SESSION['cfcp_session_data'][$i]['field_2'])."</td>
													<td class=\"history-white-text-goals\">".trim($_SESSION['cfcp_session_data'][$i]['field_3'])."</td>
												</tr>";												
												}
											}
												
								$htmlContent_for_single_webpage .=	"</tbody></table>
								   </div>
								   <!-- End of the module 3 -->        
												
								</div>
								<div id=\"profile-box-curve-down\"><!-- --></div>
							 </div>
							<div id=\"profile-box-bottom\">
							
								<!-- Start of the module 4 (video) -->        
								<div id=\"player-video\"><object width=\"450\" height=\"390\" flashvars=\"path=http://devel.profootballagency.com/_videos/video-player-grey.swf&amp;skinPath=http://devel.profootballagency.com/_videos/video-player-skin.swf&amp;videoPath=".$video_path."&amp;videoAutoPlay=false\" data=\"http://devel.profootballagency.com/_videos/video-player-grey.swf\" type=\"application/x-shockwave-flash\"><param value=\"http://devel.profootballagency.com/_videos/video-player-grey.swf\" name=\"movie\"><param value=\"path=http://devel.profootballagency.com/_videos/video-player-grey.swf&amp;skinPath=http://devel.profootballagency.com/_videos/video-player-skin.swf&amp;videoPath=".$video_path."&amp;videoAutoPlay=false\" name=\"FlashVars\"></object></div>
								<!-- End of the module 4 -->
											
								<!-- Start of the module 5 (comments and more) -->
								<div id=\"quote\">
									<span><!-- --></span>
									<p>".$comment."</p>
								</div>
								<div id=\"more-box\">
									<h2><em>More About</em></h2>
									<div class=\"more-box-data-row\">
										<span><a href=\"/contact-us/\" title=\"Contact Us\">Enquire about this player</a></span>										
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
	function display_cfc_categoryName_by_cfcp_id($cfcp_id){
		
		global $connection;
		$sql = "SELECT cfcp__players_categories.player_category_name 
				FROM cfcp__players_categories
				LEFT JOIN cfcp__senior_palyer_details ON cfcp__players_categories.id = cfcp__senior_palyer_details.player_Cat_id
				WHERE cfcp__senior_palyer_details.CFCP_id = {$cfcp_id}";
		return AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query($sql), 0);
	}
	/* End of the function */

	/* This function will return the player category name for a given id */
	function display_pfa_categoryName_by_id($id){
		
		global $connection;
		return AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query("SELECT player_category_name FROM cfcp__players_categories WHERE id = ".$id), 0);
	}
	/* End of the function */
	
	/* This function will retrieve all pfa clients in to display */
	function display_all_cfc_players($params, $curr_page_no = NULL, $sortBy = "", $sortMethod = ""){
	
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
			$sort = " ORDER BY cfcp__personel_details.id DESC";				
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";				
		$sql = "SELECT 
					cfcp__personel_details.id  AS cfcp_id, cfcp__teams.team_name as teamName, cfcp__personel_details.first_name AS firstName, 
					cfcp__personel_details.last_name AS lastName, cfcp__personel_details.date_of_birth AS dob, cfcp__personel_details.nickname1, cfcp__personel_details.nickname2, 
					cfcp__players_categories.player_category_name AS playerCatName, 
					cfcp__other_details.position1, cfcp__other_details.position2,
					cfcp__contact_details.home_address AS homeAdd, cfcp__other_details.school AS school, cfcp__other_details.current_class AS currClass
				FROM 
				cfcp__personel_details 
				LEFT JOIN cfcp__teams ON cfcp__teams.id = cfcp__personel_details.team_id
				LEFT JOIN cfcp__senior_palyer_details ON cfcp__senior_palyer_details.CFCP_id = cfcp__personel_details.id 				
				LEFT JOIN cfcp__contact_details ON cfcp__contact_details.CFCP_id = cfcp__personel_details.id 
				LEFT JOIN cfcp__other_details ON cfcp__other_details.CFCP_id = cfcp__personel_details.id 
				LEFT JOIN cfcp__players_categories ON cfcp__players_categories.id = cfcp__senior_palyer_details.player_cat_id {$sort}{$limit}";		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);				
	}
	/* End of the fucntion */
	
	/* This function will retrieve the count for all pfa clients in to display */
	function display_count_on_all_cfc_players(){
	
		global $connection;
		$sql = "SELECT 
					cfcp__personel_details.id  AS cfcp_id, cfcp__teams.team_name as teamName, cfcp__personel_details.first_name AS firstName, 
					cfcp__personel_details.last_name AS lastName, cfcp__personel_details.date_of_birth AS dob, cfcp__personel_details.nickname1, cfcp__personel_details.nickname2, 
					cfcp__players_categories.player_category_name AS playerCatName, 
					cfcp__other_details.position1, cfcp__other_details.position2,
					cfcp__contact_details.home_address AS homeAdd, cfcp__other_details.school AS school, cfcp__other_details.current_class AS currClass
				FROM 
				cfcp__personel_details 
				LEFT JOIN cfcp__teams ON cfcp__teams.id = cfcp__personel_details.team_id
				LEFT JOIN cfcp__senior_palyer_details ON cfcp__senior_palyer_details.CFCP_id = cfcp__personel_details.id 				
				LEFT JOIN cfcp__contact_details ON cfcp__contact_details.CFCP_id = cfcp__personel_details.id 
				LEFT JOIN cfcp__other_details ON cfcp__other_details.CFCP_id = cfcp__personel_details.id 
				LEFT JOIN cfcp__players_categories ON cfcp__players_categories.id = cfcp__senior_palyer_details.player_cat_id";		
		return AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query($sql));				
	}
	/* End of the fucntion */	
	
	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_general_details_for_single_cfcp($cfcp_id, $params){
	
		global $connection;
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT cfcp__personel_details.* FROM cfcp__personel_details WHERE cfcp__personel_details.id = {$cfcp_id}"), $params);				
	}
	/* End of the fucntion */

	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_senior_details_for_single_cfcp($cfcp_id, $params){
	
		global $connection;
		$sql = "SELECT CFCP_id, player_cat_id, height, weight, place_of_birth, position, coach_comment FROM cfcp__senior_palyer_details 
						WHERE cfcp__senior_palyer_details.CFCP_id = {$cfcp_id}";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);				
	}
	/* End of the fucntion */

	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_contact_details_for_single_cfcp($cfcp_id, $params){

		global $connection;
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT cfcp__contact_details.* FROM cfcp__contact_details WHERE cfcp__contact_details.CFCP_id = {$cfcp_id}"), $params);				
	}
	/* End of the fucntion */		

	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_other_details_for_single_cfcp($cfcp_id, $params){

		global $connection;
		$sql = "SELECT CFCP_id, school, current_class, boot_size, boots_received, position1, position2  FROM cfcp__other_details 
						WHERE cfcp__other_details.CFCP_id = {$cfcp_id}";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);				
	}
	/* End of the fucntion */		
	
	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_history_details_for_single_cfcp($cfcp_id, $params){
	
		global $connection;
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT * FROM cfcp__players_history WHERE cfcp__players_history.CFCP_id = {$cfcp_id}"), $params);				
	}
	/* End of the fucntion */			

	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_history_details_for_single_cfcp_for_the_pagination($cfcp_id, $param_array, $curr_page_no = NULL, $sortBy = "", $sortMethod = ""){
	
		global $connection;
		$sort = "";
		$limit = "";
	
		$display_items = 5;					
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
			$sort = " ORDER BY cfcp__players_history.id DESC";				
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";				
		$sql = "SELECT cfcp__players_history.* FROM cfcp__players_history 
						WHERE cfcp__players_history.CFCP_id = {$cfcp_id} {$sort}{$limit}";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $param_array);				
	}
	/* End of the fucntion */			
	
	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_media_details_for_single_pfac($cfcp_id, $params){
	
		global $connection;
		$sql = "SELECT cfcp__genral_details.cv_url, cfcp__genral_details.photo_url, cfcp__genral_details.video_url, cfcp__genral_details.webpage_url FROM cfcp__genral_details 
						WHERE cfcp__genral_details.id = {$cfcp_id}";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);				
	}
	/* End of the fucntion */				
	
	/* This function will delete the pfac general details for a given cfcp_id */
	function delete_record_in_general_view($cfcp_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM cfcp__personel_details WHERE cfcp__personel_details.id = {$cfcp_id}");						
	}
	/* End of the function */

	/* This function will delete the pfac general details for a given cfcp_id */
	function delete_record_in_senior_view($cfcp_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM cfcp__senior_palyer_details WHERE cfcp__senior_palyer_details.CFCP_id = {$cfcp_id}");						
	}
	/* End of the function */
	
	/* This function will delete the pfac general details for a given cfcp_id */
	function delete_record_in_contact_view($cfcp_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM cfcp__contact_details WHERE cfcp__contact_details.CFCP_id = {$cfcp_id}");						
	}
	/* End of the function */

	/* This function will delete the pfac general details for a given cfcp_id */
	function delete_record_in_other_view($cfcp_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM cfcp__other_details WHERE cfcp__other_details.CFCP_id = {$cfcp_id}");						
	}
	/* End of the function */

	/* This function will delete the pfac general details for a given cfcp_id */
	function delete_record_in_history_view($cfcp_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM cfcp__players_history WHERE cfcp__players_history.CFCP_id = {$cfcp_id}");						
	}
	/* End of the function */		
	
	/* This function will retrieve some details which reqired to display in the player's web page */
	function grab_players_page_details($cfcp_id){
	
		global $connection;
		$sql = "SELECT 
					cfcp__personel_details.first_name, cfcp__personel_details.last_name, cfcp__personel_details.date_of_birth, cfcp__players_categories.player_category_name,
					cfcp__senior_palyer_details.height, cfcp__senior_palyer_details.weight, cfcp__senior_palyer_details.place_of_birth, cfcp__senior_palyer_details.position, 
					cfcp__senior_palyer_details.coach_comment, cfcp__senior_palyer_details.video_url, cfcp__senior_palyer_details.photo_url, cfcp__senior_palyer_details.webpage_url 
				FROM cfcp__personel_details
				LEFT JOIN cfcp__senior_palyer_details ON cfcp__senior_palyer_details.CFCP_id = cfcp__personel_details.id
				LEFT JOIN cfcp__players_categories ON cfcp__players_categories.id = cfcp__senior_palyer_details.player_cat_id
				WHERE cfcp__personel_details.id = {$cfcp_id}";
		$params = array('first_name', 'last_name', 'date_of_birth', 'player_category_name', 'height', 'weight', 'place_of_birth', 'position', 'coach_comment', 
						'video_url', 'photo_url', 'webpage_url', 'webpage_url');		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);							
	}
	/* End of the function */
	
	/* This function will retrieve media details per each given parameter */
	function grab_player_single_information_for_the_cfcp($title, $table, $which, $cfcp_id){
	
		global $connection;
		return AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query("SELECT {$title} FROM {$table} WHERE {$which} = {$cfcp_id}"), 0);														
	}
	/* End of the fucntion */	
	
	/* This function will retireve the count of the player history details for restrict */
	function retrieve_count_of_player_history($cfcp_id){
	
		global $connection;
		return AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT * FROM cfcp__players_history WHERE CFCP_id =".$cfcp_id));																
	}
	/* End of the function */	
	
	/* This function will load all neccessary details for the single view */
	function grab_full_details_for_the_single_view($cfcp_id){
	
		global $connection;
		$sql = "SELECT 
					cfcp__personel_details.id , cfcp__teams.team_name, cfcp__personel_details.first_name, cfcp__personel_details.last_name, 
					cfcp__personel_details.nickname1, cfcp__personel_details.nickname2, cfcp__personel_details.date_of_birth, cfcp__personel_details.date_created, cfcp__players_categories.player_category_name, 
					cfcp__senior_palyer_details.place_of_birth, cfcp__senior_palyer_details.position AS seniorPos, cfcp__senior_palyer_details.height, cfcp__senior_palyer_details.weight, 
					cfcp__senior_palyer_details.coach_comment, cfcp__senior_palyer_details.video_url , cfcp__senior_palyer_details.photo_url, cfcp__senior_palyer_details.webpage_url, 
					cfcp__contact_details.*, cfcp__other_details.school, cfcp__other_details.current_class, cfcp__other_details.boot_size,  
					cfcp__other_details.boots_received, cfcp__other_details.position1, cfcp__other_details.position2, cfcp__other_details.registration_card_status,
					cfcp__other_details.passport_scan_url, cfcp__other_details.reg_card_url, cfcp__other_details.birth_certificate_url
				FROM 
				cfcp__personel_details 
				LEFT JOIN cfcp__teams ON cfcp__teams.id = cfcp__personel_details.team_id
				LEFT JOIN cfcp__senior_palyer_details ON cfcp__senior_palyer_details.CFCP_id = cfcp__personel_details.id 
				LEFT JOIN cfcp__contact_details ON cfcp__contact_details.CFCP_id = cfcp__personel_details.id 
				LEFT JOIN cfcp__other_details ON cfcp__other_details.CFCP_id = cfcp__personel_details.id 
				LEFT JOIN cfcp__players_categories ON cfcp__players_categories.id = cfcp__senior_palyer_details.player_cat_id 								
				WHERE cfcp__personel_details.id = ".$cfcp_id;	
		$params = array(
						'id', 'team_name', 'first_name', 'last_name', 'nickname1', 'nickname2', 'date_of_birth', 'date_created', 'player_category_name', 'place_of_birth', 'seniorPos', 'height', 'weight',
						'coach_comment', 'video_url', 'photo_url', 'webpage_url', 'home_address', 'mobile_no', 'email', 'father_name', 'father_contact_no', 'father_occupation',
						'mother_name', 'mother_contact_no', 'mother_occupation', 'parents_address', 'passport_no', 'exact_name_passport', 'school', 'current_class', 'boot_size',
						'boots_received', 'position1', 'position2', 'registration_card_status', 'passport_scan_url', 'reg_card_url', 'birth_certificate_url'
						);		
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $params);							
	}
	/* End of the fucntion */
	
	/* This function will load all notes categories related to the client type */
	function retrieve_all_notes_categories_related_to_client_type($clientType){
	
		global $connection;
		$params = array('id', 'note_cat_name');	
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT id, note_cat_name FROM pfagos__notes_categories WHERE agent_or_player_type = '{$clientType}'"), $params);									
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
	
	/* This function will delete the pfac general details for a given cfcp_id */
	function delete_selected_note($note_id, $cfcp_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfagos__notes WHERE pfagos__notes.note_id = {$note_id} AND pfagos__notes.note_owner_id = {$cfcp_id}");						
	}
	/* End of the function */		

	/* This function will delete all the notes which owned by given cfcp_id */
	function delete_owned_notes($cfcp_id){
	
		global $connection;
		AppModel::grab_db_function_class()->execute_query("DELETE FROM pfagos__notes WHERE pfagos__notes.note_owner_id = {$cfcp_id} AND note_owner_type = 'CFCP'");						
	}
	/* End of the function */		
	
	/* This function will retrieve all notes with other details regarding to the client */
	function retrieve_all_notes_owned_by_this_client($note_owner_id, $param_array){
	
		global $connection;
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query("SELECT * FROM pfagos__notes WHERE note_owner_id = {$note_owner_id} AND note_owner_type = 'CFCP' ORDER BY note_id DESC"), $param_array);									
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
		}else{
			$sort = " ORDER BY note_id DESC";				
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";		
		$sql = "SELECT pfagos__notes.note_id, pfagos__notes_categories.note_cat_name, pfagos__notes.note_owner_id, pfagos__notes.date_added, pfagos__notes.added_by,
					   pfagos__notes.note, pfagos__notes.date_modified, pfagos__notes.modified_by 
				FROM pfagos__notes 
				LEFT JOIN pfagos__notes_categories ON pfagos__notes_categories.id = pfagos__notes.note_cat_id
				WHERE pfagos__notes_categories.agent_or_player_type = 'CFCP' 
				AND pfagos__notes.note_owner_id = {$note_owner_id} {$sort}{$limit}";
		return AppModel::grab_db_function_class()->result_to_array_for_few_fields(AppModel::grab_db_function_class()->execute_query($sql), $param_array);									
	}
	/* End of the fucntion */

	/* This function will retrieve all notes count regarding to the client */
	function retrieve_all_notes_count_owned_by_this_client_only_for_the_edit_view($note_owner_id, $param_array){
	
		global $connection;
		$sql = "SELECT pfagos__notes.note_id, pfagos__notes_categories.note_cat_name, pfagos__notes.note_owner_id, pfagos__notes.date_added, pfagos__notes.added_by,
					   pfagos__notes.note, pfagos__notes.date_modified, pfagos__notes.modified_by 
				FROM pfagos__notes 
				LEFT JOIN pfagos__notes_categories ON pfagos__notes_categories.id = pfagos__notes.note_cat_id
				WHERE pfagos__notes_categories.agent_or_player_type = 'CFCP' 
				AND pfagos__notes.note_owner_id = {$note_owner_id}";	
		return AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query($sql));						
	}
	/* End of the fucntion */
	
	/* This function will retrieve note category name for the its cat id */
	function retrieve_full_details_of_selected_note($note_id, $param_array){
	
		global $connection;
		$sql = "SELECT pfagos__notes.note, pfagos__notes.note_cat_id, pfagos__notes_categories.note_cat_name, pfagos__notes.date_modified, pfagos__notes.modified_by, pfagos__notes.date_added, pfagos__notes.added_by  
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
	function check_cfcp_id_exist($id){
	
		global $connection;
		return (AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT id FROM cfcp__personel_details WHERE id = {$id}")) != "") ? true : false;																
	}
	/* End of the function */	
	
	/* This function will check whether the given pfac id from the get value is exist in database */
	function check_cfcp_id_exist_in_senior_details_table($id){
	
		global $connection;
		return (AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT CFCP_id FROM cfcp__senior_palyer_details WHERE CFCP_id = {$id}")) != "") ? true : false;																
	}
	/* End of the function */	

	/* This function will check whethr the client note id exist in the database before any further action */
	function check_note_id_exist($note_id){
	
		global $connection;
		return (AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT note_id FROM pfagos__notes WHERE note_id = {$note_id}")) != "") ? true : false;																
	}
	/* End of the fucntion */
	
	/* This function will check the given note id is owned by the given client */
	function check_note_id_owned_by_the_correct_client($cfcp_id, $note_id){	

		global $connection;
		$cfcp_id_in_db = AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query("SELECT note_owner_id FROM pfagos__notes WHERE note_id = {$note_id}"), 0);																
		return ($cfcp_id == $cfcp_id_in_db) ? true : false;
	}		
	/* End of the function */
	
	/* This function will retrieve the note cat name for the given note id */
	function retrieve_note_cat_name($note_id){
	
		global $connection;
		$sql = "SELECT pfagos__notes_categories.note_cat_name FROM pfagos__notes_categories 
				LEFT JOIN pfagos__notes ON pfagos__notes.note_cat_id = pfagos__notes_categories.id
				WHERE pfagos__notes.note_id = {$note_id}
				AND pfagos__notes_categories.agent_or_player_type = 'CFCP'";		
		return AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query($sql), 0);				
	} 
	/* End of the fucntion */
	
	/* This function will insert log details every time against the user action */
	function keep_track_of_activity_log_in_cfcp($logParmas){
	
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
	
	/* This function will check whether the given pfac id from the get value is exist in database */
	function check_cfcp_has_previous_senior_details($cfcp_id){
	
		global $connection;
		return (AppModel::grab_db_function_class()->return_num_of_rows_in_result(AppModel::grab_db_function_class()->execute_query("SELECT CFCP_id FROM cfcp__senior_palyer_details WHERE CFCP_id = {$cfcp_id}")) != "") ? true : false;																
	}
	/* End of the function */	
	
	/* This function will update senior player media detail regarding to the media view in to database */
	function update_senior_info_regarding_the_media_view_change($cfcp_id, $media_details){
		
		global $connection;
		$sql = "UPDATE cfcp__senior_palyer_details
						SET
							photo_url = '". CommonFunctions::mysql_preperation(trim($media_details['image_url'])) ."',
							video_url = '". CommonFunctions::mysql_preperation(trim($media_details['video_url'])) ."'
						WHERE CFCP_id  = ". $cfcp_id;
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the function */		
	
	/* This function will check the given note id is owned by the given client */
	function check_history_id_owned_by_the_correct_client($cfcp_id, $history_id){	

		global $connection;
		$cfcp_id_in_db = AppModel::grab_db_function_class()->return_single_result_from_mysql_resource(AppModel::grab_db_function_class()->execute_query("SELECT CFCP_id FROM cfcp__players_history WHERE id = {$history_id}"), 0);																
		return ($cfcp_id == $cfcp_id_in_db) ? true : false;
	}		
	/* End of the function */
	
	/* This function will update senior player media detail regarding to the media view in to database */
	function update_last_info_regarding_the_media_view_change($cfcp_id, $media_details){
		
		global $connection;
		$sql = "UPDATE cfcp__senior_palyer_details
						SET
							player_web_page = '". CommonFunctions::mysql_preperation(trim($media_details['web_page'])) ."'
						WHERE CFCP_id  = ". $cfcp_id;
		AppModel::grab_db_function_class()->execute_query($sql);		
	}
	/* End of the function */		
	
	/* This function will Configure the action panel with against user permissions */
	function generate_action_panel_with_user_related_permissions($logged_user_permissions, $site_config, $view, $mode="", $cfcp_id=""){

		$action_panel_menu = array();	
		$action_panel = array(
								array(
										"menu_id" => 1,
										"menu_text" => "Add / Edit Note",
										"menu_url" => $site_config['base_url']."cfcp/edit/?mode=notes".
										(
										(($_GET['mode'] != "general") && 
										($_GET['mode'] != "contact") && 
										($_GET['mode'] != "senior") && 										
										($_GET['mode'] != "edit-media") && 																				
										($_GET['mode'] != "other") && 										
										($_GET['mode'] != "history") && 
										($_GET['mode'] != "edit-media")										
										) ? $mode : ""),
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
										"menu_url" => $site_config['base_url']."cfcp/edit/?mode=".(($_GET['mode'] != "notes") ? ((($view == "view") || ($view == "show")) ? "general" : $mode) : "general"),
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
		return (($mode != "") ? $this->filter_action_panel_buttons_in_subview($action_panel_menu, $cfcp_id, $mode, $site_config) : $action_panel_menu);
	}
	/* End of the function */
	
	/* This function will again filter the action panel buttons according to correct sub view */
	function filter_action_panel_buttons_in_subview($action_panel_menu, $cfcp_id, $mode, $site_config){

		$filtered_action_panel_menu = "";
		foreach($action_panel_menu as $eachMenu){

			if (!strstr($eachMenu['menu_url'], $mode)){

				if ($eachMenu['menu_text'] == "Drop"){
		 
					$filtered_action_panel_menu	.= "<a href='#' onclick='return ask_for_delete_record(\"".$site_config['base_url']."cfcp/drop/?cfcp_id=".$cfcp_id."\");' 
													title='".$eachMenu['menu_text']."'>".$eachMenu['menu_img']."</a>";                    

				}else{

					$filtered_action_panel_menu .= " <a title='".$eachMenu['menu_text']."' href='".$eachMenu['menu_url'].
												   (((($eachMenu['menu_text'] == "Details") || ($eachMenu['menu_text'] == "Drop")) ? "?" : "&").("cfcp_id=".$cfcp_id)).
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