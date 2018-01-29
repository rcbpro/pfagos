<?php

class cfcp_controller extends AppController{	

	/* This function will check the correct sub view provided else redirect to the home page */
	function correct_sub_view_gate_keeper($subView){
	
		if (isset($subView)){
			$modes_array = array("general", "senior", "edit-media", "media", "contact", "other", "history", "notes");
			if (!in_array($subView, $modes_array)){
				global $site_config;
				AppController::redirect_to($site_config['base_url']."cfcp/view/");
			}else{
				$view_mode = $subView;
			}		
		}else{
			$view_mode = "";	
		}
		return $view_mode;
	} 
	/* End of the fucntion */

	/* This function will process the correct model for the given view */
	function process_the_correct_model($controller, $view, $mode=""){

		switch($view) {
		
			case "add":
				// global variables used in the pfac add
				global $printHtml;				
				global $cfcp_players_cats;
				global $cfcp_team_cats;
				global $headerDivMsg;
				global $submitStatus;
				global $whichFormToInclude;
				global $history_details;
				global $site_config;
				global $breadcrumb;	
				global $notes_categories;
				global $all_notes_to_this_client;		
				global $cfcp_id;
				global $postions_in_cfcp;
				global $reg_card_type;
				$headerDivMsg = "";									
				$breadcrumb = "";
				$email_validity = true;
				$valid_date = true;
				// Instantiating the used objects							
				$cfcpModel = new cfcp_model();
				// At first clear the session
				if (isset($_SESSION['cfcp_files_has_uploaded'])) $_SESSION['cfcp_files_has_uploaded'] == "false";													
				unset($_SESSION['cfcp_reqired_errors']);				
				unset($_SESSION['cfcp_history_non_reqired']);																											
				unset($_SESSION['cfcp_history_reqired']);
				// When the page get first loaded clears the session
				if (isset($_GET['p'])){	
					unset($_SESSION['cfcp_general_reqired']);
					unset($_SESSION['cfcp_general_non_reqired']);
					if (isset($_SESSION['cfcp_senior_reqired'])) unset($_SESSION['cfcp_senior_reqired']);
					if (isset($_SESSION['cfcp_senior_non_reqired'])) unset($_SESSION['cfcp_senior_non_reqired']);
					unset($_SESSION['cfcp_contact_reqired']);
					unset($_SESSION['cfcp_contact_non_reqired']);
					unset($_SESSION['cfcp_other_reqired']);
					unset($_SESSION['cfcp_other_non_reqired']);
					unset($_SESSION['cfcp_history_reqired']);
					unset($_SESSION['cfcp_history_non_reqired']);
					unset($_SESSION['cfcp_files_has_uploaded']);
					unset($_SESSION['cfcp_senior_submit_success']);
					$cfcpModel->clear_session_info_regard_to_this_agent($_SESSION['id']);							
					unset($_SESSION['id']);
					unset($_SESSION['cfcp_general_submit_success']);
					unset($_SESSION['cfcp_senior_submit_success']);				
					unset($_SESSION['cfcp_senior_media_submit_success']);
					unset($_SESSION['cfcp_contact_submit_success']);
					unset($_SESSION['cfcp_other_submit_success']);
					unset($_SESSION['cfcp_history_submit_success']);
					unset($_SESSION['cfcp_senior_player']);												
					unset($_SESSION['cfcp_session_data']);
					unset($_SESSION['cfcp_preview_bc']);
					unset($_SESSION['cfcp_preview_ps']);
					unset($_SESSION['cfcp_preview_reg']);
					unset($_SESSION['cfcp_preview_img']);					
					unset($_SESSION['cfcp_preview_video']);
					unset($_SESSION['pre_cfcp_preview_img']);
					unset($_SESSION['pre_cfcp_preview_img']);
					unset($_SESSION['pre_cfcp_preview_video']);					
					unset($_SESSION['newly_inserted_cfcp_id']);
					unset($_SESSION['date_input_error']);
					unset($_SESSION['date_input_error_2']);				
					unset($_SESSION['id_for_preview_cfcp']);
				}					
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']."\" class=\"headerLink\">Home</a> &rsaquo; ".(((isset($_GET['mode'])) && ($_GET['mode'] == "notes")) ? "Add Note for client" : "Add CFC Player")."</div>";
				// Displaying the player categories in the drop down
				$params = array('id', 'player_category_name');
				$cfcp_players_cats = $cfcpModel->display_all_cfcp_categories($params);	
				// Displaying the players teams
				$params = array('id', 'team_name');
				$cfcp_team_cats = $cfcpModel->display_all_cfcp_teams($params);	
				// Generate the top header menu
				if (($_POST['cfcp_general_reqired']['team_cat'] == 5) || ($_SESSION['cfcp_general_reqired']['team_cat'] == 5) || ($_SESSION['cfcp_senior_player'])){
					$brTag = "<br />";
					$spaces1 = "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					$spaces2 = "&nbsp;&nbsp;&nbsp;&nbsp;";
				}else{
					$brTag = "";
					$spaces1 = "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					$spaces2 = "";
				}
				$printHtml = "";
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "general")) ? "<span class=\"specializedTexts\">General Details</span>" : "<span class=\"disabledHrefLinks\">General Details</span>";					
				$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				if (($_POST['cfcp_general_reqired']['team_cat'] == 5) || ($_SESSION['cfcp_general_reqired']['team_cat'] == 5) || ($_SESSION['cfcp_senior_player'])){
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "senior")) ? "<span class=\"specializedTexts\">Senior Player Details</span>" : "<span class=\"disabledHrefLinks\">Senior Player Details</span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "media")) ? "<span class=\"specializedTexts\">Senior Player Media Details</span>" : "<span class=\"disabledHrefLinks\">Senior Player Media Details</span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				}
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "contact")) ? "<span class=\"specializedTexts\">Contact Details</span>{$brTag}" : "<span class=\"disabledHrefLinks\">Contact Details</span>{$spaces2}{$brTag}";					
				$printHtml .= "{$spaces1}";
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "other")) ? "<span class=\"specializedTexts\">Other Details</span>" : "<span class=\"disabledHrefLinks\">Other Details</span>";					
				$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "history")) ? "<span class=\"specializedTexts\">Player History</span>" : "<span class=\"disabledHrefLinks\">Player History</span>";					
				$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "notes")) ? "<span class=\"headerTopicSelected\">Add Note</span>" : "<span class=\"disabledHrefLinks\">Add Note</span>";					

				// Switch to the correct sub view
				switch($mode){

					case "general": $whichFormToInclude = "general"; break;
					case "senior": $whichFormToInclude = "senior"; break;
					case "media": 
						$whichFormToInclude = "media"; 
						// This is valuable for the preview history data
						unset($_SESSION['id_for_preview_cfcp']);						
					break;
					case "contact": $whichFormToInclude = "contact"; break;										
					case "other": 
						$whichFormToInclude = "other";
						$postions_in_cfcp = CommonFunctions::retrieve_cfcp_positions(); 
						switch($_SESSION['cfcp_general_reqired']['team_cat']){
							case "1": $reg_card_type = "Under 10"; break;
							case "2": $reg_card_type = "Under 12"; break;
							case "3": $reg_card_type = "Under 14"; break;
							case "4": $reg_card_type = "Under 17"; break;
							case "5": $reg_card_type = "Senior Team"; break;																												
						} 
					break;										
					case "history": $whichFormToInclude = "history"; break;
					case "notes":
						$whichFormToInclude = "notes"; 
						// Display the success message in adding cfc player
						if ($_SESSION['cfcp_data_updated'] == "true"){					
							$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">New CFC Player was addedd successfully. <a href='".$site_config['base_url'].
								"cfcp/show/?cfcp_id=".$_SESSION['newly_inserted_cfcp_id']."' class='edtingMenusLink_in_view'>View details</a></div>";																																									
						}
						unset($_SESSION['cfcp_data_updated']);	
						// Display the success message in adding new note for cfc player
						if ($_SESSION['new_note_created_cfcp'] == "true"){
							$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">New note has been created.</div>";																																									
						}
						unset($_SESSION['new_note_created_cfcp']);							
						// Display the success message after succesul deletion
						if ($_SESSION['current_note_deleted']){
							$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Note has been deleted.</div>";																																									
						}
						unset($_SESSION['current_note_deleted']);							
						// Grab the current cfcp id
						$cfcp_id = $_SESSION['newly_inserted_cfcp_id'];
						// Load last inserted notes by last inserted user
						$notes_array = array('note_id', 'note_cat_id', 'note_owner_id', 'note');					
						$all_notes_to_this_client = $cfcpModel->retrieve_all_notes_owned_by_this_client($_SESSION['newly_inserted_cfcp_id'], $notes_array);
						$notes_categories = $cfcpModel->retrieve_all_notes_categories_related_to_client_type("CFCP");						
						// Delete the selected note	
						if ((isset($_GET['opt'])) && ($_GET['opt'] == "drop")){
							$cfcpModel->delete_selected_note($_GET['note_id'], $cfcp_id);
							// Log keeping
							$log_params = array(
												"user_id" => $_SESSION['logged_user']['id'], 
												"action_desc" => "Deleted the last inserted note of CFC Player id {$cfcp_id}",
												"date_crated" => date("Y-m-d-H:i:s")
												);
							$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
							$_SESSION['current_note_deleted'] = true;
							AppController::redirect_to($site_config['base_url']."cfcp/add/?mode=notes");
						}								
					break;										
				}				

				// If the correct post back not submitted then redirect the user to the correct page
				if ((($mode == "contact") || ($mode == "senior") )  && ($_SESSION['cfcp_general_submit_success'] != "true")){
					AppController::redirect_to($site_config['base_url'] ."cfcp/add/?p=1&mode=general");
				}					
				if (($mode == "media") && ($_SESSION['cfcp_senior_submit_success'] != "true")){
					//AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=senior");
				}				
				if (($_POST['cfcp_general_reqired']['team_cat'] == 5) || ($_SESSION['cfcp_general_reqired']['team_cat'] == 5)){
					if (($mode == "contact") && ($_SESSION['cfcp_senior_media_submit_success'] != "true")){
						AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=media");
					}
				}				
				if (($mode == "other") && ($_SESSION['cfcp_contact_submit_success'] != "true")){
					AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=contact");				
				}				
				if (($mode == "history") && ($_SESSION['cfcp_other_submit_success'] != "true")){
					AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=other");				
				}				
				if (($mode == "notes") && (!isset($_SESSION['newly_inserted_cfcp_id']))){
					AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=history");				
				}				
				// Start to validate and other main function
				if ("POST" == $_SERVER['REQUEST_METHOD']){
					$submitStatus = true;					
					// Data Grabbing and validating for the required in general view
					if (isset($_POST['cfcp_general_reqired'])) { 
						$_SESSION['cfcp_general_reqired'] = $_POST['cfcp_general_reqired']; 
						$errors = $cfcpModel->validate_general_view($_POST['cfcp_general_reqired']);
						// Data Grabbing and validating for the non required in general view					
						if (isset($_POST['cfcp_general_non_reqired'])) { 
							$_SESSION['cfcp_general_non_reqired'] = $_POST['cfcp_general_non_reqired']; 
						}
						// Check data is valid
						if (!@checkdate($_POST['cfcp_general_reqired']['month'], $_POST['cfcp_general_reqired']['day'], $_POST['cfcp_general_reqired']['year'])){
							$_SESSION['date_input_error'] = true;
						}else{
							$_SESSION['date_input_error'] = false;							
						}
					}
					// If the general form does not have any errors then redirect it to the next level	
					if (isset($_POST['cfcp_general_submit'])){
						// checking having errors and if not redirect to senior/other
						if ($errors){	
							$_SESSION['cfcp_reqired_errors'] = $errors;
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
						}elseif ($_SESSION['date_input_error'] == 1){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid date for Birth day.</div>";																		
						}else{
							$_SESSION['cfcp_general_submit_success'] = "true";						
							$location = ($_POST['cfcp_general_reqired']['team_cat'] == 5) ? "senior" : "contact";
							AppController::redirect_to($site_config['base_url']."cfcp/add/?mode=".$location);
						}						
					}
					// Data Grabbing and validating for the required in senior view										
					if (isset($_POST['cfcp_senior_reqired'])) {
						$_SESSION['cfcp_senior_reqired'] = $_POST['cfcp_senior_reqired'];					
						$errors = $cfcpModel->validate_general_view($_POST['cfcp_senior_reqired']);						
						// Data Grabbing and validating for the required in contact view										
						if (isset($_POST['cfcp_senior_non_reqired'])) {
							$_SESSION['cfcp_senior_non_reqired'] = $_POST['cfcp_senior_non_reqired'];					
						}						
					}
					// If the senior form does not have any errors then redirect it to the next level	
					if (isset($_POST['cfcp_senior_submit'])){
						if ($errors){	
							$_SESSION['cfcp_reqired_errors'] = $errors;
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
						}else{
							$_SESSION['cfcp_senior_submit_success'] = true;						
							$_SESSION['cfcp_senior_player'] = true;
							AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=media");				
						}						
					}	
					// If the contact form does not have any errors then redirect it to the next level	
					if (isset($_POST['cfcp_senior_media_submit'])){
						if(is_file($_SESSION['cfcp_preview_img']['file_path_thumb'])){
							//$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Photo is required.</div>";																		
						//}else{
						}						
							$_SESSION['cfcp_senior_media_submit_success'] = "true";												
							AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=contact");										
					}
					// Data Grabbing and validating for the required in contact view										
					// Data Grabbing and validating for the required in contact view										
					if (isset($_POST['cfcp_contact_non_reqired'])) {
						$_SESSION['cfcp_contact_non_reqired'] = $_POST['cfcp_contact_non_reqired'];					
					}
					if (!empty($_POST['cfcp_contact_non_reqired']['email'])){
						$email_validity = CommonFunctions::check_email_address($_POST['cfcp_contact_non_reqired']['email']);
					}	
					// If the contact form does not have any errors then redirect it to the next level	
					if (isset($_POST['cfcp_contact_submit'])){
						if ($errors){	
							$_SESSION['cfcp_reqired_errors'] = $errors;
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
						}elseif (!$email_validity){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid Email.</div>";																																
						}else{
							$_SESSION['cfcp_contact_submit_success'] = "true";						
							AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=other");				
						}						
					}	
					// Data Grabbing and validating for the required in contact view										
					// Data Grabbing and validating for the required in contact view										
					if (isset($_POST['cfcp_other_non_reqired'])) {
						$_SESSION['cfcp_other_non_reqired'] = $_POST['cfcp_other_non_reqired'];					
						// Check data is valid
						if ((!empty($_POST['cfcp_other_non_reqired']['day'])) && (!empty($_POST['cfcp_other_non_reqired']['month'])) && (!empty($_POST['cfcp_other_non_reqired']['year']))){
							$_SESSION['cfcp_other_non_reqired'] = $_POST['cfcp_other_non_reqired'];							
							if (!@checkdate($_POST['cfcp_other_non_reqired']['month'], $_POST['cfcp_other_non_reqired']['day'], $_POST['cfcp_other_non_reqired']['year'])){
								$valid_date = false;
								$_SESSION['date_input_error_2'] = true;
							}else{
								$valid_date = true;							
								$_SESSION['date_input_error_2'] = false;							
							}
						}
					}
					// If the contact form does not have any errors then redirect it to the next level	
					if (isset($_POST['cfcp_other_submit'])){
						if ($errors){	
							$_SESSION['cfcp_reqired_errors'] = $errors;
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
						}elseif (!$valid_date){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid date for Boots received date.</div>";																		
						}else{
							$_SESSION['cfcp_other_submit_success'] = "true";						
							AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=history");				
						}						
					}	
					// If history button has been clicked and having no errors keeping the session data with the database					
					if (isset($_POST['cfcp_history_submit'])){	
						// Data grabbing in to the session and validation in cfcp_history
						if (isset($_POST['cfcp_history_reqired'])) {
							$_SESSION['cfcp_history_reqired'] = $_POST['cfcp_history_reqired'];					
							$errors = $cfcpModel->validate_general_view($_SESSION['cfcp_history_reqired']);		
							// Data grabbing in to the session cfcp_history_non_required					
							if (isset($_POST['cfcp_history_non_reqired'])) {
								$_SESSION['cfcp_history_non_reqired'] = $_POST['cfcp_history_non_reqired'];					
							}
						}
						unset($_SESSION['id']);	
						$_SESSION['id'] = $session_id['id'] = session_id();						
						// If the history form does not have any errors then redirect it to the next level							
						if ($errors['total_errors'] == 0){
							$cfcpModel->keep_session_data(array_merge($session_id, $_SESSION['cfcp_history_reqired'], $_SESSION['cfcp_history_non_reqired']));																																		
							// Displaing those session data
							unset($_SESSION['cfcp_session_data']);
							unset($_SESSION['cfcp_history_reqired']);
							unset($_SESSION['cfcp_history_non_reqired']);
							$param_array = array('id', 'field_1', 'field_2', 'field_3', 'field_4');
							$_SESSION['cfcp_session_data'] = $cfcpModel->grab_session_data($_SESSION['id'], $param_array);									
							for($i=0; $i<count($_SESSION['cfcp_session_data']); $i++){
								$history_details .= "<tr>
														   <td align=\"center\"><span class=\"defaultFont\"><a href='".$site_config['base_url'].
																	"cfcp/add/?mode=history&drop_id=".$_SESSION['cfcp_session_data'][$i]['id'].
																	"'><img src='../../public/images/b_drop.png' border='0' /></a></span></td>						
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_1']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_2']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_3']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_4']."</span></td>	
													</tr>";                						
							}
							unset($_SESSION['cfcp_history_reqired']);
							if (isset($_SESSION['cfcp_history_non_reqired'])) unset($_SESSION['cfcp_history_non_reqired']);
							$_SESSION['cfcp_history_submit_success'] = "true";
						}else{
							unset($_SESSION['cfcp_session_data']);
							$_SESSION['cfcp_reqired_errors'] = $errors;
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
							$param_array = array('id', 'field_1', 'field_2', 'field_3', 'field_4');
							$_SESSION['cfcp_session_data'] = $cfcpModel->grab_session_data($_SESSION['id'], $param_array);									
							for($i=0; $i<count($_SESSION['cfcp_session_data']); $i++){
								$history_details .= "<tr>
														   <td align=\"center\"><span class=\"defaultFont\"><a href='".$site_config['base_url'].
																	"cfcp/add/?mode=history&drop_id=".$_SESSION['cfcp_session_data'][$i]['id'].
																	"'><img src='../../public/images/b_drop.png' border='0' /></a></span></td>						
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_1']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_2']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_3']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_4']."</span></td>	
													</tr>";                						
							}						
						}	
					}
					// If Player adding button clicked
					if (isset($_POST['cfcp_player_save_submit'])){
					
/*						// Even if the final save button clicked still need to display the player last added histtory
						$param_array = array('id', 'field_1', 'field_2', 'field_3', 'field_4');
						$_SESSION['cfcp_session_data'] = $cfcpModel->grab_session_data($_SESSION['id'], $param_array);									
						for($i=0; $i<count($_SESSION['cfcp_session_data']); $i++){
							$history_details .= "<tr>
													   <td align=\"center\"><span class=\"defaultFont\"><a href='".$site_config['base_url'].
																"cfcp/add/?mode=history&drop_id=".$_SESSION['session_data'][$i]['id'].
																"'><img src='../../public/images/b_drop.png' border='0' /></a></span></td>						
													   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_1']."</span></td>
													   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_2']."</span></td>
													   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_3']."</span></td>
													   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_4']."</span></td>													   
												</tr>";                						
						}					
*/						
						$birth_certificate = $_SESSION['cfcp_preview_bc']['name'];						
						rename($_SESSION['cfcp_preview_bc']['file_path_bc'], $_SERVER['DOCUMENT_ROOT'].'/user_uploads/birth_certificates/'.$birth_certificate);
						
						// Insert general view data
						$_SESSION['newly_inserted_cfcp_id'] = $newly_inserted_cfcp_id = $cfcpModel->insert_general_info($_SESSION['cfcp_general_reqired'], $_SESSION['cfcp_general_non_reqired'], date("Y-m-d-H:i:s"));

						if ($_SESSION['cfcp_general_reqired']['team_cat'] == 5){
							// make images
							$small = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/small/'.$_SESSION['cfcp_preview_img']['name'];
							$medium = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/medium/'.$_SESSION['cfcp_preview_img']['name'];
							$large = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/large/'.$_SESSION['cfcp_preview_img']['name'];
							$ori = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/'.$_SESSION['cfcp_preview_img']['name'];
							$thumb = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/thumb/'.$_SESSION['cfcp_preview_img']['name'];
							$video_path = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/videos/'.$_SESSION['cfcp_preview_video']['name'];
							
							$imageCreate = new ImageCreate();
							$imageCreate->make_thumb($_SESSION['cfcp_preview_img']['file_path_ori'], $small , $_SESSION['cfcp_preview_img']['width'], $_SESSION['cfcp_preview_img']['height'], 60, 60);
							$imageCreate->make_thumb($_SESSION['cfcp_preview_img']['file_path_ori'], $medium , $_SESSION['cfcp_preview_img']['width'], $_SESSION['cfcp_preview_img']['height'], 70, 58);
							$imageCreate->make_thumb($_SESSION['cfcp_preview_img']['file_path_ori'], $large , $_SESSION['cfcp_preview_img']['width'], $_SESSION['cfcp_preview_img']['height'], Null, 275);
							
							rename($_SESSION['cfcp_preview_img']['file_path_ori'], $ori);
							rename($_SESSION['cfcp_preview_video']['file_path_video'],$video_path);
							rename($_SESSION['cfcp_preview_img']['file_path_thumb'],$thumb);
							unlink($_SESSION['cfcp_preview_img']['file_path_prew']);
								
							$photo_url = $_SESSION['cfcp_preview_img']['name'];
							$video_url = $_SESSION['cfcp_preview_video']['name'];
						
							if (
							   (!empty($_SESSION['cfcp_senior_non_reqired']['position'])) && 
							   (!empty($_SESSION['cfcp_senior_non_reqired']['height'])) && 
							   (!empty($_SESSION['cfcp_senior_non_reqired']['weight']))
							   ){					
								$mediaDetails = array(
														'photo_url' => $photo_url,
														'video_url' => $video_url,
														'webpage_url' => ""
													);
							   		   							   					 
								// Load the player html web page
								$htmlContentForSinglePage = $cfcpModel->create_or_update_single_web_for_cfcp_player();
							}else{
								$mediaDetails = array(
														'photo_url' => $photo_url,
														'video_url' => $video_url,
														'webpage_url' => str_replace("admin.", "", $site_config['base_url'])."players/".strtolower($cfcpModel->display_pfa_categoryName_by_id($_SESSION['cfcp_senior_reqired']['player_cat']))."/".
																		trim(strtolower($_SESSION['cfcp_general_reqired']['firstname']))."-".trim(strtolower($_SESSION['cfcp_general_reqired']['lastname']))."/"
													 );	
							}	
							// Insert senior player details if the cfc is a senior player
							$cfcpModel->insert_senior_info($newly_inserted_cfcp_id, $_SESSION['cfcp_senior_reqired'], $_SESSION['cfcp_senior_non_reqired'], $htmlContentForSinglePage, $mediaDetails);						
						}							
						// Insert contact view data														
						$cfcpModel->insert_contact_info($newly_inserted_cfcp_id, $_SESSION['cfcp_contact_reqired'], $_SESSION['cfcp_contact_non_reqired']);						
						// Insert other view data														
						switch($_SESSION['cfcp_general_reqired']['team_cat']){
							case "1": $reg_card_status = "U10 Card"; break;
							case "2": $reg_card_status = "U12 Card"; break;
							case "3": $reg_card_status = "U14 Card"; break;
							case "4": $reg_card_status = "U17 Card"; break;																					
							case "5": $reg_card_status = "Senior Card"; break;							
						}						
						$reg_card_url = $_SESSION['cfcp_preview_reg']['name'];
						rename($_SESSION['cfcp_preview_reg']['file_path_reg'], $_SERVER['DOCUMENT_ROOT'].'/user_uploads/reg_cards/'.$reg_card_url);
						
						$registration_card = $_SESSION['cfcp_preview_reg']['name'];		
						$passport_scan = $_SESSION['cfcp_preview_ps']['name'];
						rename($_SESSION['cfcp_preview_ps']['file_path_ps'], $_SERVER['DOCUMENT_ROOT'].'/user_uploads/passport_scans/'.$passport_scan);
						
						$uploaded_files_params = array(
															"reg_card" => $registration_card,
															"birth_certificate" => $birth_certificate,
															"passport_scan" => $passport_scan
													  );
													  
						
						$cfcpModel->insert_other_info($newly_inserted_cfcp_id, $_SESSION['cfcp_other_reqired'], $_SESSION['cfcp_other_non_reqired'], $uploaded_files_params, $reg_card_status);						
						// Insert history view data		
						if (empty($_SESSION['cfcp_session_data'])){

							$param_array = array('field_1', 'field_2', 'field_3', 'field_4');						
							$_SESSION['session_data'] = $cfcpModel->grab_session_data($_SESSION['id'], $param_array);																						
						}	
						$cfcpModel->insert_history_info($newly_inserted_cfcp_id, $_SESSION['cfcp_session_data']);
						// Log keeping
						$log_params = array(
											"user_id" => $_SESSION['logged_user']['id'], 
											"action_desc" => "New Address book contact was added as a CFC Player",
											"date_crated" => date("Y-m-d-H:i:s")
											);
						$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);												
						// Log keeping
						$log_params = array(
											"user_id" => $_SESSION['logged_user']['id'], 
											"action_desc" => "New CFC Player was added",
											"date_crated" => date("Y-m-d-H:i:s")
											);
						$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
						// Clear the session data according to this agenct from the db
						$_SESSION['cfcp_data_updated'] = "true";
						// Unset all session data and other loaded objects that used to PFA add section
						unset($_SESSION['cfcp_general_reqired']);
						unset($_SESSION['cfcp_general_non_reqired']);
						if (isset($_SESSION['cfcp_senior_reqired'])) unset($_SESSION['cfcp_senior_reqired']);
						if (isset($_SESSION['cfcp_senior_non_reqired'])) unset($_SESSION['cfcp_senior_non_reqired']);
						unset($_SESSION['cfcp_contact_reqired']);
						unset($_SESSION['cfcp_contact_non_reqired']);
						unset($_SESSION['cfcp_other_reqired']);
						unset($_SESSION['cfcp_other_non_reqired']);						
						unset($_SESSION['cfcp_files_has_uploaded']);
						$cfcpModel->clear_session_info_regard_to_this_agent($_SESSION['id']);	
						unset($_SESSION['id']);
						unset($_SESSION['cfcp_general_submit_success']);
						unset($_SESSION['cfcp_senior_submit_success']);				
						unset($_SESSION['cfcp_senior_media_submit_success']);
						unset($_SESSION['cfcp_contact_submit_success']);
						unset($_SESSION['cfcp_other_submit_success']);
						unset($_SESSION['cfcp_history_submit_success']);						
//						unset($_SESSION['cfcp_senior_player']);
						unset($_SESSION['cfcp_session_data']);
						unset($_SESSION['cfcp_preview_bc']);
						unset($_SESSION['cfcp_preview_ps']);
						unset($_SESSION['cfcp_preview_reg']);
						unset($_SESSION['date_input_error_2']);
						unset($history_details);
						unset($cfcpModel);
						unset($session_id);	
						AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=notes");											
					}	
					// If notes form has been submitted
					if (isset($_POST['cfcp_notes_submit'])){
						// If no value has been submitted regarding the notes section
						if ((empty($_POST['cfcp_note_required']['note_cat'])) && (empty($_POST['cfcp_note_required']['note_text']))){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category and fill the note text box.</div>";		
						// If both values has been submitted	
						}else{
							if (empty($_POST['cfcp_note_required']['note_cat'])){
								$_SESSION['cfcp_note_required']['note_text'] = $_POST['cfcp_note_required']['note_text'];
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category.</div>";																							
							}elseif (empty($_POST['cfcp_note_required']['note_text'])){
								$_SESSION['cfcp_note_required']['note_cat'] = $_POST['cfcp_note_required']['note_cat'];							
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please fill the note text box.</div>";																														
							}else{
								$_SESSION['cfcp_note_required']['note_text'] = $_POST['cfcp_note_required']['note_text'];							
								$_SESSION['cfcp_note_required']['note_cat'] = $_POST['cfcp_note_required']['note_cat'];									
								$notes_inputting_array = array(
													"note_cat_id" => $_SESSION['cfcp_note_required']['note_cat'],								
													"note_owner_id" => $_SESSION['newly_inserted_cfcp_id'],
													"note_owner_type" => "CFCP",													
													"note_text" => $_SESSION['cfcp_note_required']['note_text'],
													"date_added" => date("Y-m-d-H:i:s"),
													"added_by" => $_SESSION['logged_user']['id']
													);
								$cfcpModel->insert_new_note($notes_inputting_array);
								// Log keeping
								$log_params = array(
													"user_id" => $_SESSION['logged_user']['id'], 
													"action_desc" => "Created a new note to CFC Player id {$_SESSION['newly_inserted_cfcp_id']}",
													"date_crated" => date("Y-m-d-H:i:s")
													);
								$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
								$notes_array = array('note_id', 'note_cat_id', 'note_owner_id', 'note');					
								$all_notes_to_this_client = $cfcpModel->retrieve_all_notes_owned_by_this_client($_SESSION['newly_inserted_cfcp_id'], $notes_array);
								$_SESSION['new_note_created_cfcp'] = "true";
								unset($_POST);									
								unset($_SESSION['cfcp_note_required']['note_cat']);
								unset($_SESSION['cfcp_note_required']['note_text']);
								AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=notes");									
							}
						}
						$notes_array = array('note_id', 'note_cat_id', 'note_owner_id', 'note');					
						$all_notes_to_this_client = $cfcpModel->retrieve_all_notes_owned_by_this_client($_SESSION['newly_inserted_cfcp_id'], $notes_array);
					}
				}else{
					// Load the session data even after the dropping the last record and if there is not a post back
					$param_array = array('id', 'field_1', 'field_2', 'field_3', 'field_4');
					$_SESSION['cfcp_session_data'] = $cfcpModel->grab_session_data(@$_SESSION['id'], $param_array);									
					for($i=0; $i<count($_SESSION['cfcp_session_data']); $i++){
						$history_details .= "<tr>
												   <td align=\"center\"><span class=\"defaultFont\"><a href='".$site_config['base_url'].
															"cfcp/add/?mode=history&drop_id=".$_SESSION['cfcp_session_data'][$i]['id'].
															"'><img src='../../public/images/b_drop.png' border='0' /></a></span></td>						
												   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_1']."</span></td>
												   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_2']."</span></td>
												   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_3']."</span></td>
												   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['cfcp_session_data'][$i]['field_4']."</span></td>												   
											</tr>";                						
					}
					// If someone wants to remove session history values					
					if (isset($_GET['drop_id'])){
						$cfcpModel->drop_session_data($_GET['drop_id']);
						AppController::redirect_to($site_config['base_url'] ."cfcp/add/?mode=history");											
					}
					// If no further errors found in the current mode
					if (isset($_SESSION['still_errors_in_the_form']) && ($_SESSION['still_errors_in_the_form'] == "true")){
						$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please correct the following indicated errors.</div>";																
					}
					// Unset some neccessary session data at the moment
					unset($_SESSION['cfcp_reqired_errors']);
					unset($_SESSION['still_errors_in_the_form']);
					if ((@$_SESSION['cfcp_general_submit_success'] != "true") && (!isset($_GET['drop_id']))){
						unset($_SESSION['cfcp_general_reqired']);
						unset($_SESSION['cfcp_general_non_reqired']);
					}
					if ((@$_SESSION['cfcp_contact_submit_success'] != "true") && (!isset($_GET['drop_id']))){
						unset($_SESSION['cfcp_contact_reqired']);
						unset($_SESSION['cfcp_contact_not_reqired']);
					}	
					unset($_SESSION['date_input_error_2']);					
					unset($history_details);
					unset($cfcpModel);
					unset($session_id);					
					$submitStatus = false;				
				}
			break;
			
			case "view":
				// global declaration for the view section
				global $site_config;				
				global $cfcp_all; 
				global $pagination;
				global $tot_page_count;
				global $cur_page;
				global $cfcp_all_count;	
				global $img;							
				global $breadcrumb;
				global $invalidPage;
				global $action_panel_menu;
				global $headerDivMsg;
				$sortBy = "";
				$sortPath = "";
				$breadcrumb = "";
				$action_panel_menu = array();
				// objects instantiation
				$cfcpModel = new cfcp_model();			
				$pagination_obj = new Pagination();				
				// Unset all session data and other loaded objects that used to PFA add section
				unset($_SESSION['cfcp_general_reqired']);
				unset($_SESSION['cfcp_general_non_reqired']);
				unset($_SESSION['cfcp_preview_bc']);
				unset($_SESSION['cfcp_preview_ps']);
				if (isset($_SESSION['cfcp_senior_reqired'])) unset($_SESSION['cfcp_senior_reqired']);
				if (isset($_SESSION['cfcp_senior_non_reqired'])) unset($_SESSION['cfcp_senior_non_reqired']);
				unset($_SESSION['cfcp_contact_reqired']);
				unset($_SESSION['cfcp_contact_non_reqired']);
				unset($_SESSION['cfcp_other_reqired']);
				unset($_SESSION['cfcp_other_non_reqired']);
				unset($_SESSION['cfcp_history_reqired']);
				unset($_SESSION['cfcp_history_non_reqired']);
				unset($_SESSION['cfcp_files_has_uploaded']);
				unset($_SESSION['id_for_preview_cfcp']);				
				if (isset($_SESSION['id'])) $cfcpModel->clear_session_info_regard_to_this_agent($_SESSION['id']);					
				unset($_SESSION['id']);
				unset($_SESSION['cfcp_general_submit_success']);
				unset($_SESSION['cfcp_senior_submit_success']);				
				unset($_SESSION['cfcp_senior_media_submit_success']);
				unset($_SESSION['cfcp_contact_submit_success']);
				unset($_SESSION['cfcp_other_submit_success']);
				unset($_SESSION['cfcp_history_submit_success']);
				unset($_SESSION['cfcp_senior_player']);												
				unset($_SESSION['cfcp_session_data']);
				unset($_SESSION['temm_id']);
				unset($_SESSION['cfcp_preview_bc']);
				unset($_SESSION['cfcp_preview_ps']);
				unset($_SESSION['cfcp_preview_reg']);
				unset($_SESSION['cfcp_preview_img']);
				unset($_SESSION['cfcp_preview_video']);
				unset($_SESSION['newly_inserted_cfcp_id']);
				unset($_SESSION['date_input_error']);
				unset($_SESSION['date_input_error_2']);	
				// Display the success message after successfull deletion of a cfcp client				
				if ($_SESSION['selected_cfcp_id_deleted']){
					$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Successfully deleted the CFC Player.</div>";															
				}
				unset($_SESSION['selected_cfcp_id_deleted']);
				// Display the error message if the requested cfc player id not exist in deletion
				if ($_SESSION['cfcp_id_not_exist']){
					$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Requested CFC Player doesn't exist !.</div>";															
				}
				unset($_SESSION['cfcp_id_not_exist']);
				// Configure the action panel with against user permissions 
				$action_panel_menu = $cfcpModel->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, $view);
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']."\" class=\"headerLink\">Home</a> &rsaquo; View All CFC Players</div>";
				// grab the current page no
				$cur_page = ((isset($_GET['page'])) && ($_GET['page'] != "") && ($_GET['page'] != 0)) ? $_GET['page'] : 1; 				
				$param_array = array('cfcp_id', 'teamName', 'firstName', 'lastName', 'dob', 'playerCatName', 'nickname1', 'nickname2', 'school', 'currClass', 'position1', 'position2');				
				// Display all cfcp_records	
				if (isset($_GET['sort'])){	
				
					$imgDefault = "<a href=\"".$site_config['base_url']."cfcp/view/?sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
					$imgAsc = "<a href=\"".$site_config['base_url']."cfcp/view/?sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
					$imgDesc = "<a href=\"".$site_config['base_url']."cfcp/view/?sort=".$_GET['sort']."&by=desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_desc.png\" border=\"0\" /></a>";								
					$img = (!isset($_GET['by'])) ? ($imgDefault) : (($_GET['by'] == "asc") ? $imgDesc : $imgAsc);

					$sort_param_array = array(
											  "f_name" => "first_name", "l_name" => "last_name", "playercat" => "playerCatName", "dob" => "dob", "teamname" => "teamName", 
											  "nick1" => "nickname1", "nick2" => "nickname2", "school" => "school", "class" => "currClass", "pos1" => "position1",  "pos2" => "position2"
											 );
					foreach($sort_param_array as $key => $value) {
						if ($key == $_GET['sort']) {
							$sortBy = $value;
						}
					}
					$sortPath = "sort=".$_GET['sort'];					 
					if (isset($_GET['by'])) $sortPath .= "&by=".$_GET['by']."&";
				}				
				$cfcp_all = $cfcpModel->display_all_cfc_players($param_array, $cur_page, $sortBy, (isset($_GET['by'])) ? $_GET['by'] : "");
				$cfcp_all_count = $cfcpModel->display_count_on_all_cfc_players();				
				// create the pagination
				$pagination = $pagination_obj->generate_pagination($cfcp_all_count, $_SERVER['REQUEST_URI'], NO_OF_RECORDS_PER_PAGE);				
				$tot_page_count = ceil($cfcp_all_count/NO_OF_RECORDS_PER_PAGE);		
				// If no records found or no pages found
				$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
				if (($page > $tot_page_count) || ($page == 0)){
					$invalidPage = true;	
				}
				// Unset all objects and other large variables used to view section data
				unset($cfcpModel);				
				unset($pagination_obj);								
			break;
			
			case "edit":
				// global declaration for the view section			
				global $whichFormToInclude;
				global $printHtml;
				global $fullDetails;
				global $cfcp_players_cats;
				global $cfcp_team_cats;
				global $history_details;
				global $headerDivMsg;
				global $site_config;
				global $breadcrumb;
				global $all_notes_to_this_client_in_edit;
				global $notes_categories;
				global $note_full_details;
				global $cfcp_id;
				global $pagination;
				global $tot_page_count;
				global $img;
				global $upload_mb;
				global $reg_card_type;
				global $cfcpModel;
				global $action_panel_menu;
				$sortBy ="";
				$pagePath="";
				$breadcrumb = "";
				$valid_date = true;				
				$email_validity = true;								
				// objects instantiation
				$cfcpModel = new cfcp_model();
						
/*				 If still form is having errors then not to proceed
				if (isset($_SESSION['still_errors_in_the_form']) && ($_SESSION['still_errors_in_the_form'] == "true")){
					$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please correct the following indicated errors.</div>";																
				}					
*/				
				//unset($_SESSION['temm_id']);
				$submitStatus = false;	
				// Check whether the address book id is exist in the database		
				if ($cfcpModel->check_cfcp_id_exist(trim($_GET['cfcp_id']))){															
					$params = array('id', 'player_category_name');													
					$cfcp_players_cats = $cfcpModel->display_all_cfcp_categories($params);	
					// Displaying the players teams
					$params = array('id', 'team_name');
					$cfcp_team_cats = $cfcpModel->display_all_cfcp_teams($params);
					// Retreive All notes for this client	
					$notes_categories = $cfcpModel->retrieve_all_notes_categories_related_to_client_type("CFCP");
					// Switch to the correct sub view							
					if (!isset($_GET['mode'])) $mode = "general";
					// At first galance load the cfcp data
					$param_array = array('id', 'team_id', 'first_name', 'last_name', 'nickname1', 'nickname2', 'date_of_birth');																
					$fullDetails = $cfcpModel->retrive_general_details_for_single_cfcp(trim($_GET['cfcp_id']), $param_array);	
					// Grab the team id for further changes
					$_SESSION['temm_id'] = $fullDetails[0]['team_id'];
					$_SESSION['posted_team_id'] = $_POST['cfcp_general_reqired']['team_cat'];
					$cfcp_id = $fullDetails[0]['id'];																
					$_SESSION['id_for_preview_cfcp'] = $cfcp_id;
					// Generate the top header menu
					if (
						($_POST['cfcp_general_reqired']['team_cat'] == 5) || 
						($_SESSION['temm_id'] == 5) || 
						($_SESSION['cfcp_general_reqired']['team_cat'] == 5) || 
						($_SESSION['cfcp_senior_player']) || 
						($_SESSION['posted_team_id'] == 5)
						){
						$brTag = "<br />";
						$spaces1 = "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
						$spaces2 = "&nbsp;&nbsp;&nbsp;&nbsp;";
					}else{
						$brTag = "";
						$spaces1 = "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
						$spaces2 = "";
					}
					$printHtml = "";
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "general")) ? "<span class=\"headerTopicSelected\">General Details</span>" : "<span><a href=\"?mode=general&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">General Details</a></span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					if (
						($_SESSION['temm_id'] == 5) || 
						($_SESSION['cfcp_general_reqired']['team_cat'] == 5) ||
						($_SESSION['posted_team_id'] == 5)
						){
						if ($_SESSION['temm_id'] == 5) $edit_mode = "edit-media";
						if ($_SESSION['cfcp_general_reqired']['team_cat'] == 5) $edit_mode = "media";						
						$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "senior")) ? "<span class=\"headerTopicSelected\">Senior Player Details</span>" : "<span><a href=\"?mode=senior&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Senior Player Details</a></span>";					
						$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
						$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == $edit_mode)) ? "<span class=\"headerTopicSelected\">Senior Player Media Details</span>" : "<span><a href=\"?mode={$edit_mode}&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Senior Player Media Details</a></span>";					
						$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					}
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "contact")) ? "<span class=\"headerTopicSelected\">Contact Details</span>{$brTag}" : "<span><a href=\"?mode=contact&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Contact Details</a></span>{$spaces2}{$brTag}";					
					$printHtml .= "{$spaces1}";
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "other")) ? "<span class=\"headerTopicSelected\">Other Details</span>" : "<span><a href=\"?mode=other&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Other Details</a></span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "history")) ? "<span class=\"headerTopicSelected\">Player History</span>" : "<span><a href=\"?mode=history&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['history_page'])) ? "&history_page=".$_GET['history_page'] : "&history_page=1")."\">Player History</a></span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "notes")) ? "<span class=\"headerTopicSelected\">Add / Edit Notes</span>" : "<span><a href=\"?mode=notes&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Add / Edit Notes</a></span>";					
					// Configure the action panel with against user permissions 
					$action_panel_menu = $cfcpModel->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, $view, $_GET['mode'], trim($_GET['cfcp_id']));
					// Bredcrmb to the pfa section				
					$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']
									."\" class=\"headerLink\">Home</a> ";
					// Load the sub view according to the mode
					switch($mode){
						
						case "general": 
							$whichFormToInclude = "general"; 
							// Display success message after successfull details updations of general
							if ($_SESSION['cfcp_personel_details_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Personel details were updated successfully. <a href='".$site_config['base_url'].
								"cfcp/show/?cfcp_id=".$cfcp_id."#general' class='edtingMenusLink_in_view'>View details</a></div>"; 
							}	
							unset($_SESSION['cfcp_personel_details_updated']);
						break;
						case "senior":
							$whichFormToInclude = "senior"; 
							// Display success message after successfull details updations of senior
							if ($_SESSION['cfcp_senior_details_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Player senior details were updated successfully. <a href='".$site_config['base_url'].
								"cfcp/show/?cfcp_id=".$cfcp_id."#senior' class='edtingMenusLink_in_view'>View details</a></div>"; 									
							}
							unset($_SESSION['cfcp_senior_details_updated']);	
							if ($_SESSION['temm_id'] == 5){
								unset($_SESSION['cfcp_personel_details_updated']);
								$param_array = array('CFCP_id', 'player_cat_id', 'height', 'weight', 'place_of_birth', 'position', 'coach_comment');		
								$fullDetails = $cfcpModel->retrive_senior_details_for_single_cfcp(trim($_GET['cfcp_id']), $param_array);	
								$cfcp_id = ($fullDetails[0]['CFCP_id'] != "") ? $fullDetails[0]['CFCP_id'] : trim($_GET['cfcp_id']);	
								$_SESSION['id_for_preview_cfcp'] = $cfcp_id;											
							}	
						break;
						case "edit-media":
							$whichFormToInclude = "edit-media";
							// Display success message after successfull details updations of media													
							if ($_SESSION['cfcp_senior_media_details_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Senior Media details were updated successfully.</div>"; 								
							}
							unset($_SESSION['cfcp_senior_media_details_updated']);
							if ($_SESSION['temm_id'] == 5){
								$cfcp_id = $_GET['cfcp_id'];							
								$_SESSION['id_for_preview_cfcp'] = $cfcp_id;						
								$max_upload = (int)(ini_get('upload_max_filesize'));
								$max_post = (int)(ini_get('post_max_size'));
								$memory_limit = (int)(ini_get('memory_limit'));
								$upload_mb = min($max_upload, $max_post, $memory_limit);				
							}	
						break;
						case "contact": 
							$whichFormToInclude = "contact";
							// Display success message after successfull details updations of media													
							if ($_SESSION['cfcp_senior_media_details_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Senior Media details were updated successfully.</div>"; 								
							}
							unset($_SESSION['cfcp_senior_media_details_updated']);
							// Display the succes message after successfull contact details updation
							if ($_SESSION['cfcp_contact_details_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Contact details were updated successfully. <a href='".$site_config['base_url'].
								"cfcp/show/?cfcp_id=".$cfcp_id."#contact' class='edtingMenusLink_in_view'>View details</a></div>";																																											
							}	
							unset($_SESSION['cfcp_contact_details_updated']);																		
							$param_array = array('CFCP_id', 'home_address', 'mobile_no', 'email', 'father_name', 'father_contact_no', 'father_occupation', 'mother_name', 
												'mother_contact_no', 'mother_occupation', 'parents_address', 'passport_no', 'exact_name_passport');		
							$fullDetails = $cfcpModel->retrive_contact_details_for_single_cfcp(trim($_GET['cfcp_id']), $param_array);	
							$cfcp_id = $fullDetails[0]['CFCP_id'];	
							$_SESSION['id_for_preview_cfcp'] = $cfcp_id;											
							
						break;
						case "other": 
							$whichFormToInclude = "other";
							global $pre_bc_name;
							global $pre_reg_name;
							global $pre_ps_name;
							global $postions_in_cfcp;
							// Display the success message after updating the media details regarding the senior player
							if ($_SESSION['cfcp_other_details_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Other Information was updated successfully. <a href='".$site_config['base_url'].
								"cfcp/show/?cfcp_id=".$cfcp_id."#other' class='edtingMenusLink_in_view'>View details</a></div>";																																			
							}
							unset($_SESSION['cfcp_other_details_updated']);
							$postions_in_cfcp = CommonFunctions::retrieve_cfcp_positions(); 							
							$param_array = array('CFCP_id', 'school', 'current_class', 'boot_size', 'boots_received', 'position1', 'position2');		
							$fullDetails = $cfcpModel->retrive_other_details_for_single_cfcp(trim($_GET['cfcp_id']), $param_array);	
							$cfcp_id = (isset($_GET['cfcp_id'])) ? trim($_GET['cfcp_id']) : $fullDetails[0]['CFCP_id'];	
							$_SESSION['id_for_preview_cfcp'] = $cfcp_id;											
							$pre_bc_name = $cfcpModel->grab_player_single_information_for_the_cfcp('birth_certificate_url', "cfcp__other_details", "CFCP_id", $cfcp_id);
							$pre_reg_name = $cfcpModel->grab_player_single_information_for_the_cfcp('reg_card_url', 'cfcp__other_details', "CFCP_id", $cfcp_id);							
							$pre_ps_name = $cfcpModel->grab_player_single_information_for_the_cfcp('passport_scan_url', 'cfcp__other_details', "CFCP_id", $cfcp_id);							
							switch($_SESSION['temm_id']){
								case "1": $reg_card_type = "Under 10"; break;
								case "2": $reg_card_type = "Under 12"; break;
								case "3": $reg_card_type = "Under 14"; break;
								case "4": $reg_card_type = "Under 17"; break;
								case "5": $reg_card_type = "Senior Team"; break;																												
							} 
						break;										
						case "history": 
							$whichFormToInclude = "history";
							if ($_SESSION['cfcp_other_details_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Other details were updated successfully.</div>";																																											
							}	
							unset($_SESSION['cfcp_other_details_updated']);																		
							if ($_SESSION['history_data_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Player History details were updated successfully. <a href='".$site_config['base_url'].
								"cfcp/show/?cfcp_id=".$cfcp_id."#history' class='edtingMenusLink_in_view'>View details</a></div>";																																																			
							}
							unset($_SESSION['history_data_updated']);
							$pagination_obj = new Pagination();	 					
							// grab the current page no							
							$cur_page = ((isset($_GET['history_page'])) && ($_GET['history_page'] != "") && ($_GET['history_page'] != 0)) ? $_GET['history_page'] : 1; 	
							$param_array = array('id', 'CFCP_id', 'season', 'team', 'appearances', 'goals', 'newly_inserted');										
							$fullDetails = $cfcpModel->retrive_history_details_for_single_cfcp_for_the_pagination(trim($_GET['cfcp_id']), $param_array, $cur_page, $sortBy, ((isset($_GET['by'])) ? $_GET['by'] : ""));																																
							$cfcp_id = $fullDetails[0]['CFCP_id'];
							$_SESSION['id_for_preview_cfcp'] = $cfcp_id;																					
							// Grab the history record count for each agent
							$history_records_limit = $cfcpModel->retrieve_count_of_player_history($cfcp_id);
							// Apply the pagination for the CFCP history
							$pagination = $pagination_obj->generate_pagination($history_records_limit, $_SERVER['REQUEST_URI'], 5);				
							$tot_page_count = ceil($history_records_limit/5);
							// Display old history records								
							for($i=0; $i<count($fullDetails); $i++){
								if ($fullDetails[$i]['newly_inserted'] == "yes"){
									$history_details .= "<tr>
															   <td align=\"center\"><span class=\"defaultFont\"><a onclick=\"ask_for_delete_record('".
															   $site_config['base_url']."cfcp/edit/?mode=history&opt=history_drop&cfcp_id=".
															   $cfcp_id."&history_id=".$fullDetails[$i]['id']."');\" title=\"Drop\" href=\"#\"><img src=\"../../public/images/b_drop.png\" border=\"0\" alt=\"Drop\" /></a></span></td>						
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['season']."</span></td>
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['team']."</span></td>															   
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['appearances']."</span></td>
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['goals']."</span></td>
														</tr>";                
								}else{
								
									$history_details .= "<tr>
															   <td align=\"center\">&nbsp;</td>						
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['season']."</span></td>
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['team']."</span></td>															   															   
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['appearances']."</span></td>
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['goals']."</span></td>
														</tr>";                								
								}						
							}
							// Drop the newly inserted history records
							if ($_GET['opt'] == "history_drop"){
								if ($cfcpModel->check_history_id_owned_by_the_correct_client($cfcp_id, trim($_GET['history_id'])) != ""){
									$cfcpModel->drop_history_data(trim($_GET['history_id']));
									// Log keeping
									$log_params = array(
														"user_id" => $_SESSION['logged_user']['id'], 
														"action_desc" => "Deleted the last inserted history record of CFC Player id {$cfcp_id}",
														"date_crated" => date("Y-m-d-H:i:s")
														);
									$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
									AppController::redirect_to($site_config['base_url'] ."cfcp/edit/?mode=history&cfcp_id=".
										$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1").
										((isset($_GET['history_page'])) ? "&history_page=".$_GET['history_page'] : "&history_page=1"));																			
								}else{
									AppController::redirect_to($site_config['base_url'] ."cfcp/view/");
								}		
							}	
						break;										
						case "notes":
							$whichFormToInclude = "notes"; 
							// Display the success message after a note adding
							if ($_SESSION['new_note_for_cfcp_created'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">New note has been created successfully.</div>";																																			
							}
							unset($_SESSION['new_note_for_cfcp_created']);
							// Disply the succes message after successful updation of existing note
							if ($_SESSION['cfcp_note_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Note has been updated successfully.</div>";																																			
							}
							unset($_SESSION['cfcp_note_updated']);							
							// Dislpay the success message after note deletion
							if ($_SESSION['cfcp_note_deleted'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Note has been deleted.</div>";																																											
							}
							unset($_SESSION['cfcp_note_deleted']);
							// Pagination object
							$pagination_obj = new Pagination();
							if (!isset($_GET['notes_page'])){ 
								$cur_path = "?".(isset($_GET['sort'])) ? "sort=".@$_GET['sort'].((isset($_GET['by'])) ? "&by=".$_GET['by'] : "") : ""; 
							}else{ 
								$cur_path = $_SERVER['REQUEST_URI']; 						
							}
							// Load all notes regarding to this client						
							$notes_array = array('note_id', 'note_cat_name', 'note_owner_id', 'note', 'date_modified', 'modified_by', 'date_added', 'added_by');						
							// Grab the current page
							$cur_page = ((isset($_GET['notes_page'])) && ($_GET['notes_page'] != "") && ($_GET['notes_page'] != 0)) ? $_GET['notes_page'] : 1; 												
							// Grab the pfac id
							$cfcp_id = ($all_notes_to_this_client_in_edit[0]['note_owner_id'] != "") ? $all_notes_to_this_client_in_edit[0]['note_owner_id'] : $_GET['cfcp_id'];	
							$_SESSION['id_for_preview_cfcp'] = $cfcp_id;						
							if (isset($_GET['sort'])){	
							
								$imgDefault = "<a href=\"".$site_config['base_url']."cfcp/edit/?mode=notes&cfcp_id=".$cfcp_id."&opt=sorting&sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
								$imgAsc = "<a href=\"".$site_config['base_url']."cfcp/edit/?mode=notes&cfcp_id=".$cfcp_id."&opt=sorting&sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
								$imgDesc = "<a href=\"".$site_config['base_url']."cfcp/edit/?mode=notes&cfcp_id=".$cfcp_id."&opt=sorting&sort=".$_GET['sort']."&by=desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\"><img src=\"../../public/images/s_desc.png\" border=\"0\" /></a>";								
								$img = (!isset($_GET['by'])) ? ($imgDefault) : (($_GET['by'] == "asc") ? $imgDesc : $imgAsc);
			
								$sort_param_array = array("notecat" => "note_cat_name", "desc" => "note", "mod_date" => "date_modified", "mod_by" => "modified_by", "add_date" => "date_added", "add_by" => "added_by");
								foreach($sort_param_array as $key => $value) {
									if ($key == $_GET['sort']) {
										$sortBy = $value;
									}
								}
							}
							// retrieve all notes and all notes couunt to this client
							$all_notes_to_this_client_in_edit = $cfcpModel->retrieve_all_notes_owned_by_this_client_only_for_the_edit_view($notes_array, $cur_page, $sortBy, ((isset($_GET['by'])) ? $_GET['by'] : ""), $_GET['cfcp_id']);
							$all_notes_count_to_this_client_in_edit = $cfcpModel->retrieve_all_notes_count_owned_by_this_client_only_for_the_edit_view($_GET['cfcp_id'], $notes_array);
							$pagination = $pagination_obj->generate_pagination($all_notes_count_to_this_client_in_edit, $cur_path, $cur_page, NO_OF_RECORDS_PER_PAGE);				
							$tot_page_count = ceil($all_notes_count_to_this_client_in_edit/NO_OF_RECORDS_PER_PAGE);				
							// Delete the selected note	
							if ((isset($_GET['opt'])) && ($_GET['opt'] == "drop")){
								// Check the note id exist in the db
								if ($cfcpModel->check_note_id_exist(trim($_GET['note_id']))){
									// Check the note is owned by him self
									if ($cfcpModel->check_note_id_owned_by_the_correct_client(trim($_GET['cfcp_id']), trim($_GET['note_id']))){								
										$cfcpModel->delete_selected_note($_GET['note_id'], $cfcp_id);
										// Log keeping
										$log_params = array(
															"user_id" => $_SESSION['logged_user']['id'], 
															"action_desc" => "Deleted a note of CFC Player id {$cfcp_id}",
															"date_crated" => date("Y-m-d-H:i:s")
															);
										$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
										$_SESSION['cfcp_note_deleted'] = "true";
										AppController::redirect_to($site_config['base_url']."cfcp/edit/?mode=notes&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1"));
									}else{
										AppController::redirect_to($site_config['base_url'] ."cfcp/view/");
									}
								}else{
									AppController::redirect_to($site_config['base_url'] ."cfcp/view/");
								}	
							}
							// Show full details of the above client selected note
							if ((isset($_GET['opt'])) && (($_GET['opt'] == "view") || ($_GET['opt'] == "edit"))){						
	
								// Check the note id exist in the db
								if ($cfcpModel->check_note_id_exist(trim($_GET['note_id']))){						
									if ($cfcpModel->check_note_id_owned_by_the_correct_client(trim($_GET['cfcp_id']), trim($_GET['note_id']))){
										$note_param = array("note", "note_cat_id", "note_cat_name", "date_modified", "modified_by", "date_added", "added_by");
										$note_full_details = $cfcpModel->retrieve_full_details_of_selected_note($_GET['note_id'], $note_param);				
									}else{
										AppController::redirect_to($site_config['base_url'] ."cfcp/view/");	
									}	
								}else{
									AppController::redirect_to($site_config['base_url'] ."cfcp/view/");																						
								}	
							}	
						break;					
					}
					if (isset($_GET['opt'])){
						$breadcrumb .= "&rsaquo; <a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/view/\">All Clients</a> &rsaquo; <a class=\"headerLink\" href=\"".
											$site_config['base_url']."cfcp/edit/?mode=general&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Edit CFC Player</a> &rsaquo; ".
											"<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/edit/?mode=notes&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."&notes_page=1"."\">Your all notes</a>";
						if ($_GET['opt'] == "view"){
							$breadcrumb	.= " &rsaquo;&nbsp;View single note";				
						}else{
							$breadcrumb	.= " &rsaquo;&nbsp;Edit single note";				
						}										
					}else{
						$breadcrumb .= "&rsaquo; <a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/view/\">All CFC Players</a> &rsaquo; Edit CFC Player";					
					}
					$breadcrumb .= "</div>";												
									
					// Start to validate and other main function				
					if ("POST" == $_SERVER['REQUEST_METHOD']){
						$submitStatus = true;					
						// Data Grabbing and validating for the required in general view
						if (isset($_POST['cfcp_general_reqired'])) { 
							$_SESSION['cfcp_general_reqired'] = $_POST['cfcp_general_reqired']; 
							// Check data is valid
							if (!@checkdate($_POST['cfcp_general_reqired']['month'], $_POST['cfcp_general_reqired']['day'], $_POST['cfcp_general_reqired']['year'])){
								$_SESSION['date_input_error'] = true;
							}else{
								$_SESSION['date_input_error'] = false;							
							}
							$errors = $cfcpModel->validate_general_view($_POST['cfcp_general_reqired']);
							// Data Grabbing and validating for the non required in general view					
							if (isset($_POST['cfcp_general_non_reqired'])) { 
								$_SESSION['cfcp_general_non_reqired'] = $_POST['cfcp_general_non_reqired']; 
							}
						}
						// If the general form does not have any errors then redirect it to the next level	
						if (isset($_POST['cfcp_general_submit'])){
							if ($errors){	
								$_SESSION['cfcp_reqired_errors'] = $errors;
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
							}elseif ($_SESSION['date_input_error'] == 1){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid date for Birth day.</div>";																		
							}else{
								// If general view and the contact view data has been changed
								if ((!empty($_SESSION['cfcp_general_reqired'])) || (!empty($_SESSION['cfcp_general_non_reqired']))){
									$cfcpModel->update_general_info($cfcp_id, $_SESSION['cfcp_general_reqired'], $_SESSION['cfcp_general_non_reqired'], $birth_certificate);
									// Log keeping
									$log_params = array(
														"user_id" => $_SESSION['logged_user']['id'], 
														"action_desc" => "Updated General details of CFC Player id {$cfcp_id}",
														"date_crated" => date("Y-m-d-H:i:s")
														);
									$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
									$_SESSION['cfcp_personel_details_updated'] = "true";																																											
									unset($_SESSION['cfcp_general_reqired']);
									unset($_SESSION['cfcp_general_non_reqired']);
								}
								AppController::redirect_to($site_config['base_url']."cfcp/edit/?mode=general&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));											
							}						
						}	
						// Data Grabbing and validating for the required in senior view										
						if (isset($_POST['cfcp_senior_reqired'])) {
							$_SESSION['cfcp_senior_reqired'] = $_POST['cfcp_senior_reqired'];					
							$errors = $cfcpModel->validate_general_view($_POST['cfcp_senior_reqired']);						
							// Data Grabbing and validating for the required in contact view										
							if (isset($_POST['cfcp_senior_non_reqired'])) {
								$_SESSION['cfcp_senior_non_reqired'] = $_POST['cfcp_senior_non_reqired'];					
							}						
						}
						// If the contact form does not have any errors then redirect it to the next level	
						if (isset($_POST['cfcp_senior_submit'])){
							if ($errors){	
								$_SESSION['cfcp_reqired_errors'] = $errors;
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
							}else{
									// Created the player web page url									
									$webpage_url = $site_config['base_url']."players/".strtolower($cfcpModel->display_cfc_categoryName_by_cfcp_id($cfcp_id))."/".
													strtolower($cfcpModel->grab_player_single_information_for_the_cfcp('first_name', "cfcp__personel_details", "id", $cfcp_id))."-".strtolower($cfcpModel->grab_player_single_information_for_the_cfcp('last_name', "cfcp__personel_details", "id", $cfcp_id))."/";
									// Update the senior player information
									$cfcpModel->update_senior_player_info($_SESSION['cfcp_senior_reqired'], $_SESSION['cfcp_senior_non_reqired'], $webpage_url, $cfcp_id);						
									// Log keeping
									$log_params = array(
														"user_id" => $_SESSION['logged_user']['id'], 
														"action_desc" => "Updated Senior Player details of CFC Player id {$cfcp_id}",
														"date_crated" => date("Y-m-d-H:i:s")
														);
									$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
									$_SESSION['cfcp_senior_details_updated'] = "true";									
									unset($_SESSION['cfcp_senior_reqired']);
									unset($_SESSION['cfcp_senior_non_reqired']);
									AppController::redirect_to($site_config['base_url']."cfcp/edit/?mode=senior&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));																				
								}	
							}
							// File has uploaded and then update the senior player details view
							if (isset($_POST['cfcp_senior_media_submit'])){		
								 $img_in_db = $cfcpModel->grab_player_single_information_for_the_cfcp("photo_url", "cfcp__senior_palyer_details", "CFCP_id", $cfcp_id);				
								if (isset($_SESSION['cfcp_preview_img'])){
									// if the senior media form has submitted
									if (isset($_SESSION['cfcp_preview_img']['name'])){
										// make images
										$small = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/small/'.$_SESSION['cfcp_preview_img']['name'];
										$medium = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/medium/'.$_SESSION['cfcp_preview_img']['name'];
										$large = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/large/'.$_SESSION['cfcp_preview_img']['name'];
										$ori = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/'.$_SESSION['cfcp_preview_img']['name'];
										$thumb = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/thumb/'.$_SESSION['cfcp_preview_img']['name'];
										
//										$video_path = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/videos/'.$_SESSION['cfcp_preview_video']['name'];
										
										if(is_file($_SESSION['cfcp_preview_img']['file_path_thumb'])){
											$imageCreate = new ImageCreate();
											$imageCreate->make_thumb($_SESSION['cfcp_preview_img']['file_path_ori'], $small , $_SESSION['cfcp_preview_img']['width'], $_SESSION['cfcp_preview_img']['height'], 60, 60);
											$imageCreate->make_thumb($_SESSION['cfcp_preview_img']['file_path_ori'], $medium , $_SESSION['cfcp_preview_img']['width'], $_SESSION['cfcp_preview_img']['height'], 70, 58);
											$imageCreate->make_thumb($_SESSION['cfcp_preview_img']['file_path_ori'], $large , $_SESSION['cfcp_preview_img']['width'], $_SESSION['cfcp_preview_img']['height'], Null, 275);
											
											rename($_SESSION['cfcp_preview_img']['file_path_thumb'],$thumb);
											rename($_SESSION['cfcp_preview_img']['file_path_ori'], $ori);
											unlink($_SESSION['cfcp_preview_img']['file_path_prew']);
										}
										
										if(is_file($_SESSION['cfcp_preview_video']['file_path_video'])){
											rename($_SESSION['cfcp_preview_video']['file_path_video'],$video_path);
										}
										
										$image_url = (!isset($_SESSION['cfcp_preview_img'])) ? $cfcpModel->grab_player_single_information_for_the_cfcp("photo_url", "cfcp__senior_palyer_details", "CFCP_id", $cfcp_id) : $_SESSION['cfcp_preview_img']['name'];
//										$video_url = (!isset($_SESSION['cfcp_preview_video'])) ? $cfcpModel->grab_player_single_information_for_the_cfcp("video_url", "cfcp__senior_palyer_details", "CFCP_id", $cfcp_id) : $_SESSION['cfcp_preview_video']['name'];
										// Update the senior player information
										$media_details = array(
																'image_url' => $image_url,
																'video_url' => $video_url
															  );
										$cfcpModel->update_senior_info_regarding_the_media_view_change($cfcp_id, $media_details);	
//										unset($_SESSION['cfcp_preview_video']);
//										unset($_SESSION['cfcp_preview_cv']);
										// Log keeping
										$log_params = array(
															"user_id" => $_SESSION['logged_user']['id'], 
															"action_desc" => "Updated Media details of CFC Player id {$cfcp_id}",
															"date_crated" => date("Y-m-d-H:i:s")
															);
										$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
										$_SESSION['cfcp_senior_media_details_updated'] = "true";									
										unset($_SESSION['cfcp_senior_reqired']);
										unset($_SESSION['cfcp_senior_non_reqired']);
										$location = "contact";
									}else{
										$location = "edit-media";
									}									
								}else{
									$location = "contact";		
									$_SESSION['cfcp_senior_media_details_updated'] = "true";												
								}								
								AppController::redirect_to($site_config['base_url']."cfcp/edit/?mode={$location}&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));																				
							}
							// If the contact form does not have any errors then redirect it to the next level	
							if (isset($_POST['cfcp_contact_submit'])){
							
								// Data Grabbing and validating for the required in contact view										
								// Data Grabbing and validating for the required in contact view										
								if (isset($_POST['cfcp_contact_non_reqired'])) {
									$_SESSION['cfcp_contact_non_reqired'] = $_POST['cfcp_contact_non_reqired'];					
								}	
								if (!empty($_POST['cfcp_contact_non_reqired']['email'])){
									$email_validity = CommonFunctions::check_email_address($_POST['cfcp_contact_non_reqired']['email']);
								}	
							
								if (!$email_validity){
									$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid Email.</div>";																																
								}else{

									// Update contact view data																				
									$cfcpModel->update_contact_info($_SESSION['cfcp_contact_non_reqired'], $cfcp_id);						
									// Log keeping
									$log_params = array(
														"user_id" => $_SESSION['logged_user']['id'], 
														"action_desc" => "Updated Contact details of CFC Player id {$cfcp_id}",
														"date_crated" => date("Y-m-d-H:i:s")
														);
									$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
									$_SESSION['cfcp_contact_details_updated'] = "true";																		
									unset($_SESSION['cfcp_contact_reqir ed']);
									unset($_SESSION['cfcp_contact_non_reqired']);
									AppController::redirect_to($site_config['base_url']."cfcp/edit/?mode=contact&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));
								}
							}
						// Data Grabbing and validating for the required in other view										
						if (isset($_POST['cfcp_other_reqired'])){
							$_SESSION['cfcp_other_reqired'] = $_POST['cfcp_other_reqired'];					
							$errors = $cfcpModel->validate_general_view($_POST['cfcp_other_reqired']);						
							// Check data is valid
							if ((!empty($_POST['cfcp_other_non_reqired']['day'])) && (!empty($_POST['cfcp_other_non_reqired']['month'])) && (!empty($_POST['cfcp_other_non_reqired']['year']))){
								$_SESSION['cfcp_other_non_reqired'] = $_POST['cfcp_other_non_reqired'];							
								if (!@checkdate($_POST['cfcp_other_non_reqired']['month'], $_POST['cfcp_other_non_reqired']['day'], $_POST['cfcp_other_non_reqired']['year'])){
									$_SESSION['date_input_error_3'] = true;
									$valid_date = false;
								}else{
									$_SESSION['date_input_error_3'] = false;
									$valid_date = true;																
								}
							}
							// Data Grabbing and validating for the required in contact view										
							if (isset($_POST['cfcp_other_non_reqired'])) {
								$_SESSION['cfcp_other_non_reqired'] = $_POST['cfcp_other_non_reqired'];					
							}						
						}
						// If the contact form does not have any errors then redirect it to the next level	
						if (isset($_POST['cfcp_other_submit'])){
	
							if ($errors){	
								$_SESSION['cfcp_reqired_errors'] = $errors;
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please correct the following indicated errors.</div>";											
							}elseif ((!is_file($_SESSION['cfcp_preview_bc']['file_path_bc'])) && (!isset($_SESSION['pre_cfcp_preview_bc']['name']))){
								$_SESSION['cfcp_reqired_errors'] = "birth_certificate";
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Birth Certificate is required.</div>";																		
							}elseif ((!is_file($_SESSION['cfcp_preview_reg']['file_path_reg'])) && (!isset($_SESSION['pre_cfcp_preview_reg']['name']))){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Registration card is required.</div>";
								$_SESSION['cfcp_reqired_errors'] = "reg_card";																			
							}elseif (!$valid_date){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid date for Boots received date.</div>";																		
							}else{
								// Birth certificate upload
								if (is_file($_SESSION['cfcp_preview_bc']['file_path_bc'])){
									$birth_certificate = $_SESSION['cfcp_preview_bc']['name'];
									rename($_SESSION['cfcp_preview_bc']['file_path_bc'], $_SERVER['DOCUMENT_ROOT'].'/user_uploads/birth_certificates/'.$birth_certificate);
								}else{
									$birth_certificate = $cfcpModel->grab_player_single_information_for_the_cfcp("birth_certificate_url", "cfcp__other_details", "CFCP_id", $cfcp_id);
								}
								// Registration card upload
								if (is_file($_SESSION['cfcp_preview_reg']['file_path_reg'])){
									$registration_card = $_SESSION['cfcp_preview_reg']['name'];		
									rename($_SESSION['cfcp_preview_reg']['file_path_reg'], $_SERVER['DOCUMENT_ROOT'].'/user_uploads/reg_cards/'.$registration_card);
								}else{
									$registration_card = $cfcpModel->grab_player_single_information_for_the_cfcp("reg_card_url", "cfcp__other_details", "CFCP_id", $cfcp_id);;																		
								}
								// Passport Scan upload
								if (is_file($_SESSION['cfcp_preview_ps']['file_path_ps'])){
									$passport_scan = $_SESSION['cfcp_preview_ps']['name'];
									rename($_SESSION['cfcp_preview_ps']['file_path_ps'], $_SERVER['DOCUMENT_ROOT'].'/user_uploads/passport_scans/'.$passport_scan);
								}else{
									$passport_scan = $cfcpModel->grab_player_single_information_for_the_cfcp("passport_scan_url", "cfcp__other_details", "CFCP_id", $cfcp_id);
								}
								$uploaded_files_params = array(
																	"reg_card" => $registration_card,
																	"birth_certificate" => $birth_certificate,
																	"passport_scan" => $passport_scan
															  );
								// Update contact view data										
								$cfcpModel->update_other_info(array_merge($_SESSION['cfcp_other_reqired'], $_SESSION['cfcp_other_non_reqired']), $uploaded_files_params, $cfcp_id);						
								// Log keeping
								$log_params = array(
													"user_id" => $_SESSION['logged_user']['id'], 
													"action_desc" => "Updated Other details of CFC Player id {$cfcp_id}",
													"date_crated" => date("Y-m-d-H:i:s")
													);
								$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
								$_SESSION['cfcp_other_details_updated'] = "true";																		
								unset($_SESSION['cfcp_preview_bc']);
								unset($_SESSION['cfcp_preview_ps']);				
								unset($_SESSION['cfcp_other_reqired']);
								unset($_SESSION['cfcp_other_non_reqired']);
								unset($_SESSION['cfcp_preview_reg']);
								AppController::redirect_to($site_config['base_url']."cfcp/edit/?mode=other&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));
							}						
						}
					// Data grabbing in to the session and validation in cfcp_history
					if (isset($_POST['cfcp_history_reqired'])) {
						$_SESSION['cfcp_history_reqired'] = $_POST['cfcp_history_reqired'];					
						$errors = $cfcpModel->validate_general_view($_POST['cfcp_history_reqired']);						
						// Data grabbing in to the session cfcp_history_non_required					
						if (isset($_POST['cfcp_history_non_reqired'])) {
							$_SESSION['cfcp_history_non_reqired'] = $_POST['cfcp_history_non_reqired'];					
						}	
					}

					// If the history form does not have any errors then redirect it to the next level	
					if (isset($_POST['cfcp_history_submit'])){
						if ($errors){
							$_SESSION['cfcp_reqired_errors'] = $errors;
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please correct the following indicated errors.</div>";											
						}else{
							$cfcpModel->insert_history_info($_GET['cfcp_id'], array_merge($_SESSION['cfcp_history_reqired'], $_SESSION['cfcp_history_non_reqired']), "edit");
							// Log keeping
							$log_params = array(
												"user_id" => $_SESSION['logged_user']['id'], 
												"action_desc" => "Inserted new history details of CFC Player id {$cfcp_id}",
												"date_crated" => date("Y-m-d-H:i:s")
												);
							$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
							$_SESSION['history_data_updated'] = "true";
							unset($_SESSION['cfcp_history_reqired']);
							unset($_SESSION['cfcp_history_non_reqired']);								
							AppController::redirect_to($site_config['base_url'] ."cfcp/edit/?mode=history&cfcp_id=".$_GET['cfcp_id'].((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['history_page'])) ? "&history_page=".$_GET['history_page'] : "&history_page=1"));										
						}											
					}
					
					// If the media view data has been updated
					if (isset($_POST['cfcp_player_save_submit'])){
	
						$data_updated = false;	
						$media_details = array();				 					
						// If media view data has been changed					
						if ((isset($_SESSION['cfcp_preview_img'])) || (isset($_SESSION['cfcp_preview_video']))){
							//Image path
							$img_path = (!isset($_SESSION['cfcp_preview_img'])) ? $cfcpModel->grab_player_single_information_for_the_cfcp("photo_url", "cfcp__senior_palyer_details", "CFCP_id", $cfcp_id) : $_SESSION['cfcp_preview_img']['name'];
							//Video path						
							$video_path = (!isset($_SESSION['cfcp_preview_video'])) ? $cfcpModel->grab_player_single_information_for_the_cfcp("video_url", "cfcp__senior_palyer_details", "CFCP_id", $cfcp_id) : $_SESSION['cfcp_preview_video']['name'];							
							//Database param array
							$media_details = array('web_page' => $cfcpModel->create_or_update_single_web_for_cfcp_player("edit", $cfcp_id));
							//Update the general media details only regarding the media view changes											 
							$data_updated = true;							
							$cfcpModel->update_last_info_regarding_the_media_view_change($_SESSION['id_for_preview_cfcp'], $media_details);
							// Log keeping
							$log_params = array(
												"user_id" => $_SESSION['logged_user']['id'], 
												"action_desc" => "Updated media details of CFC Player id {$cfcp_id}",
												"date_crated" => date("Y-m-d-H:i:s")
												);
							$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
						}else{						
							//Database param array					
							$media_details = array(
													'photo_url' => $cfcpModel->grab_player_single_information_for_the_cfcp("photo_url", "cfcp__senior_palyer_details", "photo_url", "CFCP_id", $cfcp_id),
													'video_url' => $cfcpModel->grab_player_single_information_for_the_cfcp("video_url", "cfcp__senior_palyer_details", "video_url", "CFCP_id", $cfcp_id),
													'web_page' => $cfcpModel->create_or_update_single_web_for_cfcp_player("edit", $cfcp_id)
												 );
							$data_updated = true;												 
						}	
						// If data updated in the media view
						if ($data_updated){
							// Unset all session data and other loaded objects that used to PFA add section
							$_SESSION['last_information_updated'] = "true";
							unset($_SESSION['cfcp_preview_img']);
							unset($_SESSION['cfcp_preview_video']);
							unset($_SESSION['cfcp_preview_cv']);
							unset($_SESSION['id_for_preview_cfcp']);
							AppController::redirect_to($site_config['base_url']."cfcp/edit/?mode=notes&cfcp_id=".$_GET['cfcp_id'].((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."&notes_page=1");								
						}else{
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please correct the errors in the form(s).</div>";																							
						}
					}	
					// If notes form has been submitted in add new note section
					if (isset($_POST['cfcp_notes_submit'])){
						// If no value has been submitted regarding the notes section
						if ((empty($_POST['cfcp_note_required']['note_cat'])) && (empty($_POST['cfcp_note_required']['note_text']))){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category and fill the note text box.</div>";		
						// If both values has been submitted	
						}else{
							if (empty($_POST['cfcp_note_required']['note_cat'])){
								$_SESSION['cfcp_note_required']['note_text'] = $_POST['cfcp_note_required']['note_text'];
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category.</div>";																							
							}elseif (empty($_POST['cfcp_note_required']['note_text'])){
								$_SESSION['cfcp_note_required']['note_cat'] = $_POST['cfcp_note_required']['note_cat'];							
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please fill the note text box.</div>";		
							}else{
								$_SESSION['cfcp_note_required']['note_text'] = $_POST['cfcp_note_required']['note_text'];							
								$_SESSION['cfcp_note_required']['note_cat'] = $_POST['cfcp_note_required']['note_cat'];									
								$notes_inputting_array = array(
																"note_cat_id" => $_SESSION['cfcp_note_required']['note_cat'],								
																"note_owner_id" => $cfcp_id,
																"note_owner_type" => "CFCP",
																"note_text" => $_SESSION['cfcp_note_required']['note_text'],
																"date_added" => date("Y-m-d-H:i:s"),
																"added_by" => $_SESSION['logged_user']['id']
															  );
								$cfcpModel->insert_new_note($notes_inputting_array);
								// Log keeping
								$log_params = array(
													"user_id" => $_SESSION['logged_user']['id'], 
													"action_desc" => "New note inserted to CFC Player id {$cfcp_id}",
													"date_crated" => date("Y-m-d-H:i:s")
													);
								$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">New Note has been created.</div>";	
								// Load all notes regarding to this client						
								$notes_array = array('note_id', 'note_cat_name', 'note_owner_id', 'note', 'date_modified', 'modified_by', 'date_added', 'added_by');						
								// Grab the current page
								$cur_page = ((isset($_GET['notes_page'])) && ($_GET['notes_page'] != "") && ($_GET['notes_page'] != 0)) ? $_GET['notes_page'] : 1; 												
								// retrieve all notes and all notes couunt to this client
								$all_notes_to_this_client_in_edit = $cfcpModel->retrieve_all_notes_owned_by_this_client_only_for_the_edit_view($notes_array, $cur_page, $sortBy, ((isset($_GET['by'])) ? $_GET['by'] : ""), $_GET['cfcp_id']);
								$all_notes_count_to_this_client_in_edit = $cfcpModel->retrieve_all_notes_count_owned_by_this_client_only_for_the_edit_view($_GET['cfcp_id'], $notes_array);
								$pagination = $pagination_obj->generate_pagination($all_notes_count_to_this_client_in_edit, $cur_path, $cur_page, NO_OF_RECORDS_PER_PAGE);				
								$tot_page_count = ceil($all_notes_count_to_this_client_in_edit/NO_OF_RECORDS_PER_PAGE);				
								$_SESSION['new_note_for_cfcp_created'] = "true";
								AppController::redirect_to($site_config['base_url']."cfcp/edit/?mode=notes&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1"));										
								unset($_POST);									
								unset($_SESSION['cfcp_note_required']['note_cat']);
								unset($_SESSION['cfcp_note_required']['note_text']);
							}
						}
					}
					// If notes form has been submitted in edit note section
					if (isset($_POST['cfcp_notes_update_submit'])){
						// Check the note id exist in the db
						if ($cfcpModel->check_note_id_exist(trim($_GET['note_id'])) != ""){
							// Check the note is owned by him self
							if ($cfcpModel->check_note_id_owned_by_the_correct_client(trim($_GET['cfcp_id']), trim($_GET['note_id'])) != ""){								
								// If no value has been submitted regarding the notes section
								if ((empty($_POST['cfcp_note_required']['note_cat'])) && (empty($_POST['cfcp_note_required']['note_text']))){
									$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category and fill the note text box.</div>";		
								// If both values has been submitted	
								}else{
									if (empty($_POST['cfcp_note_required']['note_cat'])){
										$_SESSION['cfcp_note_required']['note_text'] = $_POST['cfcp_note_required']['note_text'];
										$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category.</div>";																							
									}elseif (empty($_POST['cfcp_note_required']['note_text'])){
										$_SESSION['cfcp_note_required']['note_cat'] = $_POST['cfcp_note_required']['note_cat'];							
										$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please fill the note text box.</div>";		
									}else{
										$_SESSION['cfcp_note_required']['note_text'] = $_POST['cfcp_note_required']['note_text'];							
										$_SESSION['cfcp_note_required']['note_cat'] = $_POST['cfcp_note_required']['note_cat'];									
										$notes_inputting_array = array(
																		"note_cat_id" => $_SESSION['cfcp_note_required']['note_cat'],								
																		"note_owner_id" => $cfcp_id,
																		"note_owner_type" => "CFCP",
																		"note_text" => $_SESSION['cfcp_note_required']['note_text'],
																		"date_modified" => date("Y-m-d-H:i:s"),
																		"modified_by" => $_SESSION['logged_user']['id']
																		);
										$cfcpModel->update_the_exsiting_note($notes_inputting_array, $_GET['note_id']);
										// Log keeping
										$log_params = array(
															"user_id" => $_SESSION['logged_user']['id'], 
															"action_desc" => "Update one of existing notes of CFC Player id {$cfcp_id}",
															"date_crated" => date("Y-m-d-H:i:s")
															);
										$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
										$notes_array = array('note_id', 'note_cat_name', 'note_owner_id', 'note', 'date_modified', 'modified_by', 'date_added', 'added_by');						
										$note_full_details = $cfcpModel->retrieve_full_details_of_selected_note($_GET['note_id'], $note_param);				
										$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">The above note was updated successfully.</div>";																																											
										$_SESSION['cfcp_note_updated'] = "true";
										AppController::redirect_to($site_config['base_url']."cfcp/edit/?mode=notes&cfcp_id=".$cfcp_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1"));										
										unset($_POST);
										unset($_SESSION['cfcp_note_required']['note_cat']);
										unset($_SESSION['cfcp_note_required']['note_text']);

									}
								}
							// If note id is not owned by him self																				
							}else{
								unset($_SESSION['cfcp_note_required']['note_cat']);
								unset($_SESSION['cfcp_note_required']['note_text']);
								AppController::redirect_to($site_config['base_url'] ."pfac/view/");	
							}
						// If wrong note id										
						}else{
							unset($_SESSION['cfcp_note_required']['note_cat']);
							unset($_SESSION['cfcp_note_required']['note_text']);
							AppController::redirect_to($site_config['base_url'] ."pfac/view/");	
						}	
					}
				}else{
					unset($_SESSION['cfcp_reqired_errors']);
					unset($_SESSION['still_errors_in_the_form']);
					unset($_SESSION['cfcp_general_reqired']);
					unset($_SESSION['cfcp_general_non_reqired']);
					unset($_SESSION['cfcp_contact_reqired']);
					unset($_SESSION['cfcp_contact_not_reqired']);
					unset($_SESSION['cfcp_other_reqired']);
					unset($_SESSION['cfcp_other_non_reqired']);
					unset($_SESSION['cfcp_history_reqired']);
					unset($_SESSION['cfcp_history_non_reqired']);
					unset($_SESSION['cfcp_session_data']);
				}
			}else{
				AppController::redirect_to($site_config['base_url'] ."cfcp/view/");																				
			}	
			break;
			
			case "drop":
				// All global variables		
				global $site_config;
				// objects instantiation
				$cfcpModel = new cfcp_model();	
				// Check whether the cfcp id is exist in the database		
				if (!$cfcpModel->check_cfcp_id_exist(trim($_GET['cfcp_id']))){	
					$_SESSION['cfcp_id_not_exist'] = true;
					$deletion = false;
				}else{
					$deletion = true;
				}
				if ($deletion){
				
					$cfcpModel->delete_record_in_general_view($_GET['cfcp_id']);
					if ($cfcpModel->check_cfcp_id_exist_in_senior_details_table(trim($_GET['cfcp_id']))){
						$cfcpModel->delete_record_in_senior_view(trim($_GET['cfcp_id']));
					}
					$cfcpModel->delete_record_in_contact_view($_GET['cfcp_id']);
					$cfcpModel->delete_record_in_other_view($_GET['cfcp_id']);
					$cfcpModel->delete_record_in_history_view($_GET['cfcp_id']);
					$cfcpModel->delete_owned_notes($_GET['cfcp_id']);
					$_SESSION['selected_cfcp_id_deleted'] = true;					
					// Log keeping
					$log_params = array(
										"user_id" => $_SESSION['logged_user']['id'], 
										"action_desc" => "Deleted the CFC Player id {$_GET['cfcp_id']} and its all details",
										"date_crated" => date("Y-m-d-H:i:s")
										);
					$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
				}
				AppController::redirect_to($site_config['base_url'] ."cfcp/view/");																				
				unset($cfcpModel);
			break;
		
			case "show":
				// All global variables		
				global $fullDetails;
				global $historyDetails;
				global $breadcrumb;
				global $site_config;
				global $action_panel_menu;
				global $cfcp_id;
				global $ps_name_real;
				$breadcrumb = "";
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']
								."\" class=\"headerLink\">Home</a> &rsaquo; "."<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/view/\">All Players</a> &rsaquo; Details</div>";
				// objects instantiation
				$cfcpModel = new cfcp_model();	
				// Check whether the address book id is exist in the database		
				if ($cfcpModel->check_cfcp_id_exist(trim($_GET['cfcp_id'])) != ""){															
					// Configure the action panel with against user permissions 
					$action_panel_menu = $cfcpModel->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, $view);
					$fullDetails = $cfcpModel->grab_full_details_for_the_single_view(trim($_GET['cfcp_id']));		
					$cfcp_id = $fullDetails[0]['id'];
					$params = array("season", "team", "appearances", "goals");
					$historyDetails = $cfcpModel->retrive_history_details_for_single_cfcp(trim($_GET['cfcp_id']), $params);
					// Passport scan files
					
					// Log keeping
					$log_params = array(
										"user_id" => $_SESSION['logged_user']['id'], 
										"action_desc" => "Viewed details of CFC Player id {$_GET['cfcp_id']}",
										"date_crated" => date("Y-m-d-H:i:s")
										);
					$cfcpModel->keep_track_of_activity_log_in_cfcp($log_params);
					unset($cfcpModel);
					unset($fullDetails);
					unset($historyDetails);	
				// If wrong id	
				}else{
					AppController::redirect_to($site_config['base_url'] ."cfcp/view/");																				
				}	
			break;
			
			case "download":

				$filename = $_GET['filename'];
				$file_path = SERVER_ROOT.'/user_uploads/'.$_GET['where'].DS.$filename;

				$ary = explode('_', $filename, 2);
				$filename = $ary[1];
				if(is_file($file_path)){						
					// fix for IE catching or PHP bug issue
					header("Pragma: public");
					header("Expires: 0"); // set expiration time
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					
					// force download dialog
					header("Content-Type: application/force-download");
					header("Content-Type: application/octet-stream");
					header("Content-Type: application/download");
					
					// use the Content-Disposition header to supply a recommended filename and
					// force the browser to display the save dialog.
					header("Content-Disposition: attachment; filename=".basename(str_replace(' ','_',$filename)).";");
					
					header("Content-Transfer-Encoding: binary");
					header("Content-Length: ".filesize($file_path));					
					readfile($file_path);
				}
			break;
		}					
	}	
	/* End of the function */
}
?>