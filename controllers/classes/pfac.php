<?php

class PfacController extends AppController{	
	
	/* This function will check the correct sub view provided else redirect to the home page */
	function correct_sub_view_gate_keeper($subView){
	
		if (isset($subView)){
			$modes_array = array("general", "coach-info", "player-info", "contact", "history", "media", "notes", "edit-media", "coach-history");
			if (!in_array($subView, $modes_array)){
				global $site_config;
				AppController::redirect_to($site_config['base_url']."pfac/view/");
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
				global $pfac_players_cats;
				global $nationalityArray;
				global $headerDivMsg;
				global $submitStatus;
				global $whichFormToInclude;
				global $history_records_limit;				
				global $history_details;
				global $site_config;
				global $breadcrumb;	
				global $notes_categories;
				global $all_notes_to_this_client;		
				global $upload_mb;
				global $pfac_id;
				$headerDivMsg = "";									
				$breadcrumb = "";
				$contract_dates_ok = true;
				$email_validity = true;
				// At first clear the session
				if (isset($_SESSION['pfac_files_has_uploaded'])) $_SESSION['pfac_files_has_uploaded'] == "false";													
				unset($_SESSION['pfac_reqired_errors']);				
				unset($_SESSION['pfac_history_non_reqired']);																											
				unset($_SESSION['pfac_history_reqired']);
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']."\" class=\"headerLink\">Home</a> &rsaquo; ".(((isset($_GET['mode'])) && ($_GET['mode'] == "notes")) ? "Add Note for client" : "Add PFA Client")."</div>";
				// Instantiating the used objects							
				$pfacModel = new PfacModel();
				$nationalityArray = CommonFunctions::retrieve_nationality_list();				
				// Displaying the player categories in the drop down
				$params = array('id', 'player_category_name');
				$pfac_players_cats = $pfacModel->display_all_pfac_categories($params);	
				// Generate the top header menu
				$printHtml = "";
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "general")) ? "<span class=\"specializedTexts\">General Details</span>" : "<span class=\"disabledHrefLinks\">General Details</span>";					
				$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				
				if ($_SESSION['pfac_general_reqired']['player_cat'] == 5){				
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "coach-info")) ? "<span class=\"specializedTexts\">Coach's Information</span>" : "<span class=\"disabledHrefLinks\">Coach's Information</span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				}else{	
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "player-info")) ? "<span class=\"specializedTexts\">Player Information</span>" : "<span class=\"disabledHrefLinks\">Player Information</span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";					
				}
				
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "contact")) ? "<span class=\"specializedTexts\">Contact Details</span>" : "<span class=\"disabledHrefLinks\">Contact Details</span>";					
				$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				
				if ($_SESSION['pfac_general_reqired']['player_cat'] == 5){				
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "coach-history")) ? "<span class=\"specializedTexts\">Coach's History</span>" : "<span class=\"disabledHrefLinks\">Coach's History</span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				}else{				
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "history")) ? "<span class=\"specializedTexts\">Player History</span>" : "<span class=\"disabledHrefLinks\">Player History</span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				}
				
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "media")) ? "<span class=\"specializedTexts\">Add Photo / Video / CV</span>" : "<span class=\"disabledHrefLinks\">Add Photo / Video / CV</span>";					
				$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "notes")) ? "<span class=\"headerTopicSelected\">Add Note</span>" : "<span class=\"disabledHrefLinks\">Add Note</span>";					

				// Switch to the correct sub view
				switch($mode){
					
					case "general": $whichFormToInclude = "general"; break;
					case "player-info": $whichFormToInclude = "player-info"; break;
					case "coach-info": $whichFormToInclude = "coach-info"; break;										
					case "contact": $whichFormToInclude = "contact"; break;
					case "history": $whichFormToInclude = "history"; break;
					case "coach-history": $whichFormToInclude = "coach-history"; break;					
					case "media": 
						$whichFormToInclude = "media"; 
						// This is valuable for the preview history data
						unset($_SESSION['id_for_preview']);
					break;
					case "notes": 
						$whichFormToInclude = "notes"; 
						if ($_SESSION['selected_note_deleted']){
							$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Note deleted.</div>";																																																
						}
						unset($_SESSION['selected_note_deleted']);
						// Display the success message	
						if ($_SESSION['media_data_updated']){					
							$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">PFA Client was addedd successfully. <a href='".$site_config['base_url'].
								"pfac/show/?pfac_id=".$_SESSION['newly_inserted_pfac_id']."' class='edtingMenusLink_in_view'>View details</a></div>";																																									
						}
						unset($_SESSION['media_data_updated']);	
						if ($_SESSION['new_note_has_created']){
							$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">New Note has been created.</div>";							
						}
						unset($_SESSION['new_note_has_created']);
						$pfac_id = $_SESSION['newly_inserted_pfac_id'];
						// Load last inserted notes by last inserted user
						$notes_array = array('note_id', 'note_cat_id', 'note_owner_id', 'note');					
						$all_notes_to_this_client = $pfacModel->retrieve_all_notes_owned_by_this_client($_SESSION['newly_inserted_pfac_id'], $notes_array);
						$notes_categories = $pfacModel->retrieve_all_notes_categories_related_to_client_type("PFAC");						
						// Delete the selected note	
						if ((isset($_GET['opt'])) && ($_GET['opt'] == "drop")){
							$pfacModel->delete_selected_note($_GET['note_id'], $pfac_id);
							// Log keeping
							$log_params = array(
												"user_id" => $_SESSION['logged_user']['id'], 
												"action_desc" => "Deleted the last inserted note of PFA Client id {$pfac_id}",
												"date_crated" => date("Y-m-d-H:i:s")
												);
							$_SESSION['selected_note_deleted'] = true;					
							$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
							AppController::redirect_to($site_config['base_url']."pfac/add/?mode=notes");
						}								
					break;										
				}
				// If the correct post back not submitted then redirect the user to the correct page
				if (($mode == "contact") && ($_SESSION['pfac_general_submit_success'] != "true")){
					AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode=general");
				}
				if (($mode == "history") && ($_SESSION['pfac_contact_submit_success'] != "true")){
					//AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode=contact");
				}
				if (($mode == "notes") && (!isset($_SESSION['newly_inserted_pfac_id']))){
					AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode=media");				
				}				

				// Start to validate and other main function
				if ("POST" == $_SERVER['REQUEST_METHOD']){
					$submitStatus = true;					
					// Data Grabbing and validating for the required in general view
					if (isset($_POST['pfac_general_reqired'])) { 
						$_SESSION['pfac_general_reqired'] = $_POST['pfac_general_reqired']; 
						$errors = $pfacModel->validate_general_view($_POST['pfac_general_reqired']);
						// Data Grabbing and validating for the non required in general view					
						if (isset($_POST['pfac_general_non_reqired'])) { 
							$_SESSION['pfac_general_non_reqired'] = $_POST['pfac_general_non_reqired']; 
						}
						// Check the given date is valid for the birth day
						if (!@checkdate($_POST['pfac_general_reqired']['month'], $_POST['pfac_general_reqired']['day'], $_POST['pfac_general_reqired']['year'])){
							$_SESSION['date_input_error'] = true;
						}else{
							$_SESSION['date_input_error'] = false;							
						}
					}
					// If the general form does not have any errors then redirect it to the next level	
					if (isset($_POST['pfac_general_submit'])){
						// checking having errors and if not redirect to m
						if ($errors){	
							$_SESSION['pfac_reqired_errors'] = $errors;
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
						}elseif ($_SESSION['date_input_error'] == 1){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid date for Birth Day.</div>";																		
						}else{
							$_SESSION['pfac_general_submit_success'] = "true";		
							$location = ($_SESSION['pfac_general_reqired']['player_cat'] == 5)	? "coach-info" : "player-info";			
							AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode={$location}");				
						}						
					}					
					// If the player information form has been submitted
					if (isset($_POST['pfac_player_info_submit'])){
						$_SESSION['pfac_player_info_non_reqired'] = $_POST['pfac_player_info_non_reqired']; 					
						AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode=contact");				
					}
					// If the coach information form has been submitted
					if (isset($_POST['pfac_coach_info_submit'])){
						$_SESSION['pfac_coachs_info_non_reqired'] = $_POST['pfac_coachs_info_non_reqired']; 															
						AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode=contact");				
					}
					// Data Grabbing and validating for the required in contact view										
					if (isset($_POST['pfac_contact_not_reqired'])){
						// Data Grabbing and validating for the required in contact view										
						// Check the given date is valid for the birth day
						$_SESSION['pfac_contact_not_reqired'] = $_POST['pfac_contact_not_reqired'];					
						if ((!empty($_POST['contract_start_date']['day'])) && (!empty($_POST['contract_start_date']['month'])) && (!empty($_POST['contract_start_date']['year']))){
							$_SESSION['contract_start_date'] = $_POST['contract_start_date'];	
							if (!@checkdate($_POST['contract_start_date']['month'], $_POST['contract_start_date']['day'], $_POST['contract_start_date']['year'])){
								$_SESSION['date_input_error_2'] = true;
							}else{
								$_SESSION['date_input_error_2'] = false;							
							}
						}
						if ((!empty($_POST['contract_end_date']['day'])) && (!empty($_POST['contract_end_date']['month'])) && (!empty($_POST['contract_end_date']['year']))){
							$_SESSION['contract_end_date'] = $_POST['contract_end_date'];							
							if (!@checkdate($_POST['contract_end_date']['month'], $_POST['contract_end_date']['day'], $_POST['contract_end_date']['year'])){
								$_SESSION['date_input_error_3'] = true;
							}else{
								$_SESSION['date_input_error_3'] = false;							
							}
						}
						if (
							((!empty($_POST['contract_start_date']['day'])) && (!empty($_POST['contract_start_date']['month'])) && (!empty($_POST['contract_start_date']['year'])))						
								&& 
						    ((!empty($_POST['contract_end_date']['day'])) && (!empty($_POST['contract_end_date']['month'])) && (!empty($_POST['contract_end_date']['year'])))
						   )
						{
							$con_start_date = $_POST['contract_start_date']['year']."-".$_POST['contract_start_date']['month']."-".$_POST['contract_start_date']['day'];							
							$con_end_date = $_POST['contract_end_date']['year']."-".$_POST['contract_end_date']['month']."-".$_POST['contract_end_date']['day'];														
							$contract_dates_ok = CommonFunctions::check_date_greater_than_another($con_start_date, $con_end_date);
						}
						if (!empty($_POST['pfac_contact_not_reqired']['email'])){
							$email_validity = CommonFunctions::check_email_address($_POST['pfac_contact_not_reqired']['email']);
						}	
					}
					// If the contact form does not have any errors then redirect it to the next level	
					if (isset($_POST['pfac_contact_submit'])){
						if ($errors){	
							$_SESSION['pfac_reqired_errors'] = $errors;
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
						}elseif ($_SESSION['date_input_error_2'] == 1){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid date for Contract Start Date.</div>";																		
						}elseif ($_SESSION['date_input_error_3'] == 1){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid date for Contract End Date.</div>";																		
						}elseif (!$contract_dates_ok){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Contract End Date must be greater than the Contract Start Date.</div>";																									
						}elseif (!$email_validity){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid Email.</div>";																																
						}else{
							$_SESSION['pfac_contact_submit_success'] = "true";						
							$location = ($_SESSION['pfac_general_reqired']['player_cat'] == 5) ? "coach-history" : "history";										
							AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode={$location}");				
						}						
					}	
					// If history button has been clicked and having no errors keeping the session data with the database					
					if (isset($_POST['pfac_history_submit'])){	
						// Data grabbing in to the session and validation in pfac_history
						if (isset($_POST['pfac_history_reqired'])) {
							$_SESSION['pfac_history_reqired'] = $_POST['pfac_history_reqired'];					
							$errors = $pfacModel->validate_general_view($_SESSION['pfac_history_reqired']);		
							// Data grabbing in to the session pfac_history_non_required					
							if (isset($_POST['pfac_history_non_reqired'])) {
								$_SESSION['pfac_history_non_reqired'] = $_POST['pfac_history_non_reqired'];					
							}
						}
						unset($_SESSION['id']);	
						$_SESSION['id'] = $session_id['id'] = session_id();						
						// If the history form does not have any errors then redirect it to the next level							
						if ($errors['total_errors'] == 0){
							if (count($_SESSION['pfac_session_data']) < 4){							
								$pfacModel->keep_session_data(array_merge($session_id, $_SESSION['pfac_history_reqired'], $_SESSION['pfac_history_non_reqired']));																																		
							}	
							// Displaing those session data
							unset($_SESSION['pfac_session_data']);
							unset($_SESSION['pfac_history_reqired']);
							unset($_SESSION['pfac_history_non_reqired']);
							$param_array = array('id', 'field_1', 'field_2', 'field_3');
							$_SESSION['pfac_session_data'] = $pfacModel->grab_session_data($_SESSION['id'], $param_array);									
							for($i=0; $i<count($_SESSION['pfac_session_data']); $i++){
								$history_details .= "<tr>
														   <td align=\"center\"><span class=\"defaultFont\"><a href='".$site_config['base_url'].
																	"pfac/add/?mode=history&drop_id=".$_SESSION['pfac_session_data'][$i]['id'].
																	"'><img src='../../public/images/b_drop.png' border='0' /></a></span></td>						
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_1']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_2']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_3']."</span></td>
													</tr>";                						
							}
							if (count($_SESSION['pfac_session_data']) >= 4){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">History records exceeds the maximum limit.</div>";											
							}
							unset($_SESSION['pfac_history_reqired']);
							if (isset($_SESSION['pfac_history_non_reqired'])) unset($_SESSION['pfac_history_non_reqired']);
							$_SESSION['pfac_history_submit_success'] = "true";
						}else{
							unset($_SESSION['pfac_session_data']);
							$_SESSION['pfac_reqired_errors'] = $errors;
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
							$param_array = array('id', 'field_1', 'field_2', 'field_3');
							$_SESSION['pfac_session_data'] = $pfacModel->grab_session_data($_SESSION['id'], $param_array);									
							for($i=0; $i<count($_SESSION['pfac_session_data']); $i++){
								$history_details .= "<tr>
														   <td align=\"center\"><span class=\"defaultFont\"><a href='".$site_config['base_url'].
																	"pfac/add/?mode=history&drop_id=".$_SESSION['pfac_session_data'][$i]['id'].
																	"'><img src='../../public/images/b_drop.png' border='0' /></a></span></td>						
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_1']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_2']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_3']."</span></td>
													</tr>";                						
							}						
						}	
					}
					// If the media button clicked
					if (isset($_POST['pfac_history_submit2'])){
						AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode=media");				
					}					
					// If history button has been clicked and having no errors keeping the session data with the database - this is for the coach's history					
					if (isset($_POST['pfac_coach_history_submit'])){	
						// Data grabbing in to the session and validation in pfac_history
						if (isset($_POST['pfac_coach_history_reqired'])) {
							$_SESSION['pfac_coach_history_reqired'] = $_POST['pfac_coach_history_reqired'];					
							$errors = $pfacModel->validate_general_view($_SESSION['pfac_coach_history_reqired']);		
							// Data grabbing in to the session pfac_history_non_required					
						}
						unset($_SESSION['id']);	
						$_SESSION['id'] = $session_id['id'] = session_id();						
						// If the history form does not have any errors then redirect it to the next level							
						if ($errors['total_errors'] == 0){
							if (count($_SESSION['pfac_session_data']) < 4){							
								$pfacModel->keep_session_data(array_merge($session_id, $_SESSION['pfac_coach_history_reqired']));																																		
							}	
							// Displaing those session data
							unset($_SESSION['pfac_session_data']);
							unset($_SESSION['pfac_coach_history_reqired']);
							$param_array = array('id', 'field_1', 'field_2');
							$_SESSION['pfac_session_data'] = $pfacModel->grab_session_data($_SESSION['id'], $param_array);									
							$location = ($_SESSION['pfac_general_reqired']['player_cat'] == 5) ? "coach-history" : "history";
							for($i=0; $i<count($_SESSION['pfac_session_data']); $i++){
								$history_details .= "<tr>
														   <td align=\"center\"><span class=\"defaultFont\"><a href='".$site_config['base_url'].
																	"pfac/add/?mode={$location}&drop_id=".$_SESSION['pfac_session_data'][$i]['id'].
																	"'><img src='../../public/images/b_drop.png' border='0' /></a></span></td>						
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_1']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_2']."</span></td>
													</tr>";                						
							}
							if (count($_SESSION['pfac_session_data']) >= 4){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">History records exceeds the maximum limit.</div>";											
							}
							unset($_SESSION['pfac_coach_history_reqired']);
							$_SESSION['pfac_history_submit_success'] = "true";
						}else{
							unset($_SESSION['pfac_session_data']);
							$_SESSION['pfac_reqired_errors'] = $errors;
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
							$param_array = array('id', 'field_1', 'field_2');
							$_SESSION['pfac_session_data'] = $pfacModel->grab_session_data($_SESSION['id'], $param_array);									
							for($i=0; $i<count($_SESSION['pfac_session_data']); $i++){
								$history_details .= "<tr>
														   <td align=\"center\"><span class=\"defaultFont\"><a href='".$site_config['base_url'].
																	"pfac/add/?mode={$location}&drop_id=".$_SESSION['pfac_session_data'][$i]['id'].
																	"'><img src='../../public/images/b_drop.png' border='0' /></a></span></td>						
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_1']."</span></td>
														   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_2']."</span></td>
													</tr>";                						
							}						
						}	
					}
					// If the media button clicked
					if (isset($_POST['pfac_history_submit2'])){
						AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode=media");				
					}						
					
					// If the PFAC add - save button clicked then add those session data in to the database
					if (isset($_POST['pfac_media_submit_save'])){
						
							if ($_SESSION['pfac_general_reqired']['player_cat'] == 5){
							
								// This is for the web page creation
								if (
								   (isset($_SESSION['pfac_preview_img'])) && 
								   (isset($_SESSION['pfac_preview_cv'])) &&														   
								   (!empty($_SESSION['pfac_coachs_info_non_reqired']['club'])) && 
								   (!empty($_SESSION['pfac_coachs_info_non_reqired']['qualifications'])) && 
								   (!empty($_SESSION['pfac_coachs_info_non_reqired']['comment'])) && 
								   (!empty($_SESSION['pfac_coachs_info_non_reqired']['careers']))
								   ){							   							   
									// Load the player html web page
									$htmlContentForSinglePage = $pfacModel->create_or_update_single_web_for_pfac_player($_SESSION['pfac_general_reqired']['player_cat']);
								}
							
							// This is for the media details retriever	
							if (
							   (isset($_SESSION['pfac_preview_img'])) && 
							   (isset($_SESSION['pfac_preview_cv']))
							   ){							   							   

								// Media details													
								$mediaDetails = array(
														'photo_url' => $_SESSION['pfac_preview_img']['name'],
														'cv_url' => $_SESSION['pfac_preview_cv']['name'],
														'webpage_url' => str_replace("admin.", "", $site_config['base_url'])."clients/".strtolower($pfacModel->display_pfa_categoryName_by_id($_SESSION['pfac_general_reqired']['player_cat']))."/".
																		trim(strtolower($_SESSION['pfac_general_reqired']['firstname']))."-".trim(strtolower($_SESSION['pfac_general_reqired']['lastname']))."/"
													 );				
													 
								// make images
								$small = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/small/'.$_SESSION['pfac_preview_img']['name'];
								$medium = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/medium/'.$_SESSION['pfac_preview_img']['name'];
								$large = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/large/'.$_SESSION['pfac_preview_img']['name'];
								$ori = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/'.$_SESSION['pfac_preview_img']['name'];
								$thumb = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/thumb/'.$_SESSION['pfac_preview_img']['name'];
								
								$cv_path = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/cvs/'.$_SESSION['pfac_preview_cv']['name'];
								
								$imageCreate = new ImageCreate();
								$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $small , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], 60, 60);
								$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $medium , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], 70, 58);
								$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $large , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], Null, 275);
								
								rename($_SESSION['pfac_preview_img']['file_path_thumb'],$thumb);
								rename($_SESSION['pfac_preview_img']['file_path_ori'], $ori);
								rename($_SESSION['pfac_preview_cv']['file_path_cv'],$cv_path);
								unlink($_SESSION['pfac_preview_img']['file_path_prew']);
								
							}else{
							
								// Media details													
								$mediaDetails = array(
														'photo_url' => $_SESSION['pfac_preview_img']['name'],
														'cv_url' => $_SESSION['pfac_preview_cv']['name'],
														'webpage_url' => ""
													 );				
							
							}
							
								// This is for the player extra information							
								$extra_information = array(								
															"club" => $_SESSION['pfac_coachs_info_non_reqired']['club'], 
															"qualifications" => $_SESSION['pfac_coachs_info_non_reqired']['qualifications'],
															"comment" => $_SESSION['pfac_coachs_info_non_reqired']['comment'],
															"careers" => $_SESSION['pfac_coachs_info_non_reqired']['careers']
														  );
							}else{					
							
								// This is for the web page creation
								if (
								   (isset($_SESSION['pfac_preview_img'])) && 
								   (isset($_SESSION['pfac_preview_cv'])) &&														   
								   (!empty($_SESSION['pfac_player_info_non_reqired']['position'])) && 
								   (!empty($_SESSION['pfac_player_info_non_reqired']['club'])) && 
								   (!empty($_SESSION['pfac_player_info_non_reqired']['height'])) && 
								   (!empty($_SESSION['pfac_player_info_non_reqired']['weight']))
								   ){							   							   
									// Load the player html web page
									$htmlContentForSinglePage = $pfacModel->create_or_update_single_web_for_pfac_player($_SESSION['pfac_general_reqired']['player_cat']);
								}
							// This is for the media details retriever	
							if (
							   (isset($_SESSION['pfac_preview_img'])) && 
							   (isset($_SESSION['pfac_preview_cv']))
							   ){							   							   

								// Media details													
								$mediaDetails = array(
														'photo_url' => $_SESSION['pfac_preview_img']['name'],
														'video_url' => $_SESSION['pfac_preview_video']['name'],
														'cv_url' => $_SESSION['pfac_preview_cv']['name'],
														'webpage_url' => str_replace("admin.", "", $site_config['base_url'])."clients/".strtolower($pfacModel->display_pfa_categoryName_by_id($_SESSION['pfac_general_reqired']['player_cat']))."/".
																		trim(strtolower($_SESSION['pfac_general_reqired']['firstname']))."-".trim(strtolower($_SESSION['pfac_general_reqired']['lastname']))."/"
													 );				
													 
								// make images
								$small = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/small/'.$_SESSION['pfac_preview_img']['name'];
								$medium = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/medium/'.$_SESSION['pfac_preview_img']['name'];
								$large = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/large/'.$_SESSION['pfac_preview_img']['name'];
								$ori = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/'.$_SESSION['pfac_preview_img']['name'];
								$thumb = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/thumb/'.$_SESSION['pfac_preview_img']['name'];
								
								$cv_path = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/cvs/'.$_SESSION['pfac_preview_cv']['name'];
								$video_path = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/videos/'.$_SESSION['pfac_preview_video']['name'];
								
								$imageCreate = new ImageCreate();
								$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $small , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], 60, 60);
								$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $medium , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], 70, 58);
								$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $large , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], Null, 275);
								
								rename($_SESSION['pfac_preview_img']['file_path_thumb'],$thumb);
								rename($_SESSION['pfac_preview_img']['file_path_ori'], $ori);
								rename($_SESSION['pfac_preview_cv']['file_path_cv'],$cv_path);
								rename($_SESSION['pfac_preview_video']['file_path_video'],$video_path);
								unlink($_SESSION['pfac_preview_img']['file_path_prew']);
								
							}else{
							
								// Media details													
								$mediaDetails = array(
														'photo_url' => $_SESSION['pfac_preview_img']['name'],
														'video_url' => $_SESSION['pfac_preview_video']['name'],
														'cv_url' => $_SESSION['pfac_preview_cv']['name'],
														'webpage_url' => ""
													 );				
							
							}
								// This is for the player extra information
								$extra_information = array(								
															"club" => $_SESSION['pfac_player_info_non_reqired']['club'], 
															"position" => $_SESSION['pfac_player_info_non_reqired']['position'],
															"height" => $_SESSION['pfac_player_info_non_reqired']['height'],
															"weight" => $_SESSION['pfac_player_info_non_reqired']['weight'],
															"comment" => $_SESSION['pfac_player_info_non_reqired']['comment']															
														  );
							}
							
							// Insert general view data						
							$_SESSION['newly_inserted_pfac_id'] = $newly_inserted_pfac_id = $pfacModel->insert_general_info($_SESSION['pfac_general_reqired'], $htmlContentForSinglePage, 
																$extra_information, $mediaDetails, date("Y-m-d-H:i:s"), $_SESSION['pfac_general_reqired']['player_cat']);
							// Insert contact view data														
							$pfacModel->insert_contact_info($newly_inserted_pfac_id, $_SESSION['pfac_contact_not_reqired'], $_SESSION['contract_start_date'], $_SESSION['contract_end_date']);						

							if ($_SESSION['pfac_general_reqired']['player_cat']  == 5){

								// Insert history view data		
								if (empty($_SESSION['pfac_session_data'])){
		
									$param_array = array('field_1', 'field_2');						
									$_SESSION['pfac_session_data'] = $pfacModel->grab_session_data($_SESSION['id'], $param_array);																						
								}	
								$pfacModel->insert_history_info_for_coach($newly_inserted_pfac_id, $_SESSION['pfac_session_data'], $_SESSION['pfac_general_reqired']['player_cat']);																
								
							}else{
							
								// Insert history view data		
								if (empty($_SESSION['pfac_session_data'])){
		
									$param_array = array('field_1', 'field_2', 'field_3');						
									$_SESSION['pfac_session_data'] = $pfacModel->grab_session_data($_SESSION['id'], $param_array);																						
								}	
								$pfacModel->insert_history_info($newly_inserted_pfac_id, $_SESSION['pfac_session_data'], $_SESSION['pfac_general_reqired']['player_cat']);																
							}
							// Log keeping
							$log_params = array(
												"user_id" => $_SESSION['logged_user']['id'], 
												"action_desc" => "New PFA Client was added",
												"date_crated" => date("Y-m-d-H:i:s")
												);
							$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
							// Clear the session data according to this agenct from the db
							$_SESSION['media_data_updated'] = true;
							// Unset all session data and other loaded objects that used to PFA add section
							unset($_SESSION['pfac_general_reqired']);
							unset($_SESSION['pfac_general_non_reqired']);
							unset($_SESSION['pfac_player_info_non_reqired']);
							unset($_SESSION['pfac_coachs_info_non_reqired']);							
							unset($_SESSION['date_input_error']);
							unset($_SESSION['date_input_error_2']);
							unset($_SESSION['date_input_error_3']);
							unset($_SESSION['pfac_contact_reqired']);
							unset($_SESSION['pfac_contact_not_reqired']);													
							unset($_SESSION['contract_start_date']);
							unset($_SESSION['contract_end_date']);				
							$pfacModel->clear_session_info_regard_to_this_agent($_SESSION['id']);							
							unset($_SESSION['id']);
							unset($_SESSION['pfac_session_data']);
							unset($_SESSION['pfac_history_reqired']);
							unset($_SESSION['pfac_history_non_reqired']);
							unset($_SESSION['pfac_preview_img']);
							unset($_SESSION['pfac_preview_video']);
							unset($_SESSION['pfac_preview_cv']);
							unset($_SESSION['pfac_files_has_uploaded']);
							unset($_SESSION['pfac_general_submit_success']);
							unset($_SESSION['pfac_contact_submit_success']);						
							unset($_SESSION['pfac_history_submit_success']);												
							unset($history_details);
							unset($commonFuncs);
							unset($pfacModel);
							unset($session_id);	
							AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode=notes");											
					}					
					// If notes form has been submitted
					if (isset($_POST['pfac_notes_submit'])){
						// If no value has been submitted regarding the notes section
						if ((empty($_POST['pfac_note_required']['note_cat'])) && (empty($_POST['pfac_note_required']['note_text']))){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category and fill the note text box.</div>";		
						// If both values has been submitted	
						}else{
							if (empty($_POST['pfac_note_required']['note_cat'])){
								$_SESSION['pfac_note_required']['note_text'] = $_POST['pfac_note_required']['note_text'];
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category.</div>";																							
							}elseif (empty($_POST['pfac_note_required']['note_text'])){
								$_SESSION['pfac_note_required']['note_cat'] = $_POST['pfac_note_required']['note_cat'];							
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please fill the note text box.</div>";																														
							}else{
								$_SESSION['pfac_note_required']['note_text'] = $_POST['pfac_note_required']['note_text'];							
								$_SESSION['pfac_note_required']['note_cat'] = $_POST['pfac_note_required']['note_cat'];									
								$notes_inputting_array = array(
													"note_cat_id" => $_SESSION['pfac_note_required']['note_cat'],								
													"note_owner_id" => $_SESSION['newly_inserted_pfac_id'],
													"note_owner_type" => "PFAC",
													"note_text" => $_SESSION['pfac_note_required']['note_text'],
													"date_added" => date("Y-m-d-H:i:s"),
													"added_by" => $_SESSION['logged_user']['id']
													);
								$pfacModel->insert_new_note($notes_inputting_array);
								$_SESSION['new_note_has_created'] = true;		
								// Log keeping
								$log_params = array(
													"user_id" => $_SESSION['logged_user']['id'], 
													"action_desc" => "Created a new note to PFA Client id {$_SESSION['newly_inserted_pfac_id']}",
													"date_crated" => date("Y-m-d-H:i:s")
													);
								$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
								$notes_array = array('note_id', 'note_cat_id', 'note_owner_id', 'note_owner_type', 'note');					
								$all_notes_to_this_client = $pfacModel->retrieve_all_notes_owned_by_this_client($_SESSION['newly_inserted_pfac_id'], $notes_array);																																																	
								unset($_POST);									
								unset($_SESSION['pfac_note_required']['note_cat']);
								unset($_SESSION['pfac_note_required']['note_text']);
								AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode=notes");									
							}
						}
						$notes_array = array('note_id', 'note_cat_id', 'note_owner_id', 'note');					
						$all_notes_to_this_client = $pfacModel->retrieve_all_notes_owned_by_this_client($_SESSION['newly_inserted_pfac_id'], $notes_array);
					}
				}else{
					// When the page get first loaded clears the session
					if (isset($_GET['p'])){
						unset($_SESSION['pfac_general_reqired']);
						unset($_SESSION['pfac_general_non_reqired']);
						unset($_SESSION['pfac_player_info_non_reqired']);
						unset($_SESSION['pfac_coachs_info_non_reqired']);							
						unset($_SESSION['date_input_error']);
						unset($_SESSION['date_input_error_2']);
						unset($_SESSION['date_input_error_3']);
						unset($_SESSION['pfac_contact_reqired']);
						unset($_SESSION['pfac_contact_not_reqired']);													
						unset($_SESSION['contract_start_date']);
						unset($_SESSION['contract_end_date']);				
						if (isset($_SESSION['id'])) $pfacModel->clear_session_info_regard_to_this_agent($_SESSION['id']);							
						unset($_SESSION['id']);
						unset($_SESSION['pfac_session_data']);
						unset($_SESSION['pfac_history_reqired']);
						unset($_SESSION['pfac_history_non_reqired']);
						unset($_SESSION['pfac_preview_img']);
						unset($_SESSION['pfac_preview_video']);
						unset($_SESSION['pfac_preview_cv']);
						unset($_SESSION['pfac_files_has_uploaded']);
						unset($_SESSION['pfac_general_submit_success']);
						unset($_SESSION['pfac_contact_submit_success']);						
						unset($_SESSION['pfac_history_submit_success']);
						unset($_SESSION['newly_inserted_pfac_id']);												
					}					
					// if the coach's history details has been updated
					if ($_SESSION['pfac_general_reqired']['player_cat'] == 5){
						// Load the session data even after the dropping the last record and if there is not a post back
						$param_array = array('id', 'field_1', 'field_2');
						$_SESSION['pfac_session_data'] = $pfacModel->grab_session_data(@$_SESSION['id'], $param_array);									
						for($i=0; $i<count($_SESSION['pfac_session_data']); $i++){
							$history_details .= "<tr>
													   <td align=\"center\"><span class=\"defaultFont\"><a href='".$site_config['base_url'].
																"pfac/add/?mode=coach-history&drop_id=".$_SESSION['pfac_session_data'][$i]['id'].
																"'><img src='../../public/images/b_drop.png' border='0' /></a></span></td>						
													   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_1']."</span></td>
													   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_2']."</span></td>
												</tr>";                						
						}
					}else{
						// Load the session data even after the dropping the last record and if there is not a post back
						$param_array = array('id', 'field_1', 'field_2', 'field_3');
						$_SESSION['pfac_session_data'] = $pfacModel->grab_session_data(@$_SESSION['id'], $param_array);									
						for($i=0; $i<count($_SESSION['pfac_session_data']); $i++){
							$history_details .= "<tr>
													   <td align=\"center\"><span class=\"defaultFont\"><a href='".$site_config['base_url'].
																"pfac/add/?mode=history&drop_id=".$_SESSION['pfac_session_data'][$i]['id'].
																"'><img src='../../public/images/b_drop.png' border='0' /></a></span></td>						
													   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_1']."</span></td>
													   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_2']."</span></td>
													   <td align=\"center\"><span class=\"defaultFont\">".$_SESSION['pfac_session_data'][$i]['field_3']."</span></td>
												</tr>";                						
						}
					}	
					// If someone wants to remove session history values					
					if (isset($_GET['drop_id'])){
						$pfacModel->drop_session_data($_GET['drop_id']);
						$location = ($_SESSION['pfac_general_reqired']['player_cat'] == 5) ? "coach-history" : "history";						
						AppController::redirect_to($site_config['base_url'] ."pfac/add/?mode={$location}");											
					}
					// If no further errors found in the current mode
					if (isset($_SESSION['still_errors_in_the_form']) && ($_SESSION['still_errors_in_the_form'] == "true")){
						$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please correct the following indicated errors.</div>";																
					}
					// Unset some neccessary session data at the moment
					unset($_SESSION['pfac_reqired_errors']);
					unset($_SESSION['still_errors_in_the_form']);
					if ((@$_SESSION['pfac_general_submit_success'] != "true") && (!isset($_GET['drop_id']))){
						unset($_SESSION['pfac_general_reqired']);
						unset($_SESSION['pfac_general_non_reqired']);
					}
					if ((@$_SESSION['pfac_contact_submit_success'] != "true") && (!isset($_GET['drop_id']))){
						unset($_SESSION['pfac_contact_reqired']);
						unset($_SESSION['pfac_contact_not_reqired']);
					}	
					$submitStatus = false;				
				}
			break;
			
			case "view":
				// global declaration for the view section
				global $site_config;				
				global $pfac_all; 
				global $pagination;
				global $tot_page_count;
				global $cur_page;
				global $pfac_all_count;	
				global $img;							
				global $breadcrumb;
				global $invalidPage;
				global $headerDivMsg;				
				global $action_panel_menu;
				$sortBy = "";
				$cur_path = "";
				$breadcrumb = "";
				// objects instantiation
				$pfacModel = new PfacModel();			
				$pagination_obj = new Pagination();				
				// Unset all session data and other loaded objects that used to PFA add section
				unset($_SESSION['pfac_general_reqired']);
				unset($_SESSION['pfac_general_non_reqired']);
				unset($_SESSION['pfac_contact_reqired']);
				unset($_SESSION['pfac_contact_not_reqired']);
				unset($_SESSION['contract_start_date']);
				unset($_SESSION['contract_end_date']);				
				unset($_SESSION['pfac_history_reqired']);
				unset($_SESSION['pfac_history_non_reqired']);
				unset($_SESSION['pfac_preview_img']);
				unset($_SESSION['pfac_preview_video']);
				unset($_SESSION['pfac_preview_cv']);
				unset($_SESSION['id_for_preview']);
				unset($_SESSION['pfac_reqired_errors']);
				unset($_SESSION['still_errors_in_the_form']);
				unset($_SESSION['pfac_session_data']);	
				unset($_SESSION['date_input_error']);				
				unset($_SESSION['date_input_error_2']);
				unset($_SESSION['date_input_error_3']);
				unset($_SESSION['newly_inserted_pfac_id']);					
				// Configure the action panel with against user permissions 
				$action_panel_menu = $pfacModel->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, $view);
				// Bredcrumb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']."\" class=\"headerLink\">Home</a> &rsaquo; View All PFA Clients</div>";
				// Succesfull deletion message
				if ($_SESSION['deleted_selected_pfac'] == "true"){
					$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Successfully Deleted the PFA Client.</div>";					
				}
				unset($_SESSION['deleted_selected_pfac']);				
				// grab the current page no
				$cur_page = ((isset($_GET['page'])) && ($_GET['page'] != "") && ($_GET['page'] != 0)) ? $_GET['page'] : 1; 				
				$param_array = array('pfac_id', 'firstName', 'lastName', 'dob', 'Nationality', 'Club', 'contract_start_date', 'contract_end_date', 'playerCatName', 'webpage_url');				
				// Display all pfac_records	
				if (isset($_GET['sort'])){	
				
					$imgDefault = "<a href=\"".$site_config['base_url']."pfac/view/?sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
					$imgAsc = "<a href=\"".$site_config['base_url']."pfac/view/?sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
					$imgDesc = "<a href=\"".$site_config['base_url']."pfac/view/?sort=".$_GET['sort']."&by=desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_desc.png\" border=\"0\" /></a>";								
					$img = (!isset($_GET['by'])) ? ($imgDefault) : (($_GET['by'] == "asc") ? $imgDesc : $imgAsc);

					$sort_param_array = array(
											  "f_name" => "first_name", "l_name" => "last_name", "playercat" => "player_category_name", "dob" => "date_of_birth", "nationality" => "nationality",
											  "club" => "club", "con_start" => "contract_start_date", "con_end" => "contract_end_date", "emgconame" => "emergency_contact_name", "emgcono" => "emergency_contact_no",
											  "playerpage" => "webpage_url"				 
											 );
					foreach($sort_param_array as $key => $value) {
						if ($key == $_GET['sort']) {
							$sortBy = $value;
						}
					}
					$sortPath = "sort=".$_GET['sort'];					 
					if (isset($_GET['by'])) $sortPath .= "&by=".$_GET['by']."&";
				}				
				$pfac_all = $pfacModel->display_all_pfa_clients($param_array, $cur_page, $sortBy, (isset($_GET['by'])) ? $_GET['by'] : "");
				$pfac_all_count = $pfacModel->display_count_on_all_pfa_clients();				
				// create the pagination
				$pagination = $pagination_obj->generate_pagination($pfac_all_count, $_SERVER['REQUEST_URI'], NO_OF_RECORDS_PER_PAGE);				
				$tot_page_count = ceil($pfac_all_count/NO_OF_RECORDS_PER_PAGE);				
				// If no records found or no pages found
				$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
				if (($page > $tot_page_count) || ($page == 0)){
					$invalidPage = true;	
				}
			break;
			
			case "edit":
				// global declaration for the view section			
				global $whichFormToInclude;
				global $printHtml;
				global $fullDetails;
				global $nationalityArray;
				global $pfac_players_cats;
				global $history_details;
				global $headerDivMsg;
				global $site_config;
				global $history_records_limit;
				global $breadcrumb;
				global $all_notes_to_this_client_in_edit;
				global $notes_categories;
				global $note_full_details;
				global $pfac_id;
				global $pagination;
				global $tot_page_count;
				global $img;
				global $upload_mb;
				global $action_panel_menu;
				global $pfacModel;
				$contract_dates_ok = true;
				$email_validity = true;
				$contract_dates_empty = true;
				$sortBy ="";
				$breadcrumb = "";
				// objects instantiation
				$pfacModel = new PfacModel();	
				// Check whether the address book id is exist in the database		
				if ($pfacModel->check_pfac_id_exist(trim($_GET['pfac_id'])) != ""){															
					$params = array('id', 'player_category_name');													
					$pfac_players_cats = $pfacModel->display_all_pfac_categories($params);	
					$notes_categories = $pfacModel->retrieve_all_notes_categories_related_to_client_type("PFAC");
					$nationalityArray = CommonFunctions::retrieve_nationality_list();				
					// Switch to the correct sub view							
					if (!isset($_GET['mode'])) $mode = "general";
					switch($mode){
						
						case "general": 
							$whichFormToInclude = "general"; 
							$param_array = array('id', 'first_name', 'last_name', 'date_of_birth', 'nationality', 'club', 'player_Cat_id', 'height', 'weight', 'position', 'comment', 
												 'photo_url', 'cv_url', 'video_url', 'webpage_url', 'player_web_page');																
							$fullDetails = $pfacModel->retrive_general_details_for_single_pfac($_GET['pfac_id'], $param_array);	
							$pfac_id = $fullDetails[0]['id'];																
							$_SESSION['id_for_preview'] = $pfac_id;
							if ($_SESSION['general_data_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">General details was updated successfully. <a href='".$site_config['base_url'].
								"pfac/show/?pfac_id=".$pfac_id."#general' class='edtingMenusLink_in_view'>View details</a></div>";																																																		
							}
							unset($_SESSION['general_data_updated']);	
						break;
						case "contact": 
							$whichFormToInclude = "contact"; 									
							$param_array = array('PFAC_id', 'home_address', 'home_phone', 'home_mobile', 'overseas_address', 'overseas_phone', 'overseas_mobile', 
												 'contract_start_date', 'contract_end_date', 'email', 'passport_no', 'exact_name_on_passport', 'emergency_contact_name', 
												 'emergency_contact_no');		
							$fullDetails = $pfacModel->retrive_contact_details_for_single_pfac($_GET['pfac_id'], $param_array);	
							$pfac_id = $fullDetails[0]['PFAC_id'];	
							$_SESSION['id_for_preview'] = $pfac_id;											
							if ($_SESSION['contact_data_updated'] == "true"){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Contact details was updated successfully. <a href='".$site_config['base_url'].
								"pfac/show/?pfac_id=".$pfac_id."#contact' class='edtingMenusLink_in_view'>View details</a></div>";																																											
							}	
							unset($_SESSION['contact_data_updated']);
						break;
						case "history": 
							$whichFormToInclude = "history"; 					
							$param_array = array('pfac_history_id', 'PFAC_id', 'club', 'appearances', 'goals', 'newly_inserted');										
							$fullDetails = $pfacModel->retrive_history_details_for_single_pfac($_GET['pfac_id'], $param_array);																																
							$pfac_id = $fullDetails[0]['PFAC_id'];
							$_SESSION['id_for_preview'] = $pfac_id;																					
							for($i=0; $i<count($fullDetails); $i++){
								if ($fullDetails[$i]['newly_inserted'] == "yes"){
									$history_details .= "<tr>
															   <td align=\"center\"><span class=\"defaultFont\"><a onclick=\"ask_for_delete_record('".
															   $site_config['base_url']."pfac/edit/?mode=history&opt=history_drop&pfac_id=".$pfac_id.
															   "&history_id=".$fullDetails[$i]['pfac_history_id']."');\" title=\"Drop\" href=\"#\"><img src=\"../../public/images/b_drop.png\" border=\"0\" alt=\"Drop\" /></a>															   
															  	</a></span></td>						
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['club']."</span></td>
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['appearances']."</span></td>
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['goals']."</span></td>
														</tr>";                
								}else{
								
									$history_details .= "<tr>
															   <td align=\"center\">&nbsp;</td>						
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['club']."</span></td>
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['appearances']."</span></td>
															   <td align=\"center\"><span class=\"defaultFont\">".$fullDetails[$i]['goals']."</span></td>
														</tr>";                								
								}						
							}
							// Drop the newly inserted history records
							if ($_GET['opt'] == "history_drop"){
								if ($pfacModel->check_history_id_owned_by_the_correct_client($pfac_id, trim($_GET['history_id'])) != ""){
									$pfacModel->drop_history_data(trim($_GET['history_id']));
									// Log keeping
									$log_params = array(
														"user_id" => $_SESSION['logged_user']['id'], 
														"action_desc" => "Deleted the last inserted history record of PFA Client id {$pfac_id}",
														"date_crated" => date("Y-m-d-H:i:s")
														);
									$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
									AppController::redirect_to($site_config['base_url'] ."pfac/edit/?mode=history&pfac_id=".
										$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1"));																			
								}else{
									AppController::redirect_to($site_config['base_url'] ."pfac/view/?page=1");																			
								}		
							}	
							// Grab the history record count for each agent
							$history_records_limit = $pfacModel->retrieve_count_of_player_history($pfac_id);							
							if ($_SESSION['history_added']){
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">History details added successfully. <a href='".$site_config['base_url'].
								"pfac/show/?pfac_id=".$pfac_id."#history' class='edtingMenusLink_in_view'>View details</a></div>";																																											
							}
							unset($_SESSION['history_added']);	
							// Drop the newly inserted history records
							if (isset($_GET['history_id'])){
								$pfacModel->drop_history_data($_GET['history_id']);
								// Log keeping
								$log_params = array(
													"user_id" => $_SESSION['logged_user']['id'], 
													"action_desc" => "Deleted the last inserted history record of PFA Client id {$pfac_id}",
													"date_crated" => date("Y-m-d-H:i:s")
													);
								$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
								AppController::redirect_to($site_config['base_url'] ."pfac/edit/?mode=history&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));								
							}					
						break;										
						case "edit-media":
							$whichFormToInclude = "edit-media"; 
							$pfac_id = $_GET['pfac_id'];							
							$_SESSION['id_for_preview'] = $pfac_id;						
							$max_upload = (int)(ini_get('upload_max_filesize'));
							$max_post = (int)(ini_get('post_max_size'));
							$memory_limit = (int)(ini_get('memory_limit'));
							$upload_mb = min($max_upload, $max_post, $memory_limit);				
						break;
						case "notes":
							$whichFormToInclude = "notes"; 
							if ($_SESSION['media_data_updated'] == "true"){
								// Display the success message						
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Media Information was updated successfully.</div>";																																			
							}
							unset($_SESSION['media_data_updated']);		
							if ($_SESSION['notes_section_got_updated'] == "true"){
								// Display the success message						
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">The above note was updated successfully.</div>";																																											
							}	
							unset($_SESSION['notes_section_got_updated']);
							if ($_SESSION['new_note_has_created']){
								// Display the success message						
								$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">New note has been created.</div>";																																											
							}
							unset($_SESSION['new_note_has_created']);
							// Display the note successfull deletion message
							if ($_SESSION['selected_note_deleted']){
								$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Note has been deleted.</div>";					
							}
							unset($_SESSION['selected_note_deleted']);
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
							$pfac_id = ($all_notes_to_this_client_in_edit[0]['note_owner_id'] != "") ? $all_notes_to_this_client_in_edit[0]['note_owner_id'] : $_GET['pfac_id'];	
							$_SESSION['id_for_preview'] = $pfac_id;						
							if (isset($_GET['sort'])){	
							
								$imgDefault = "<a href=\"".$site_config['base_url']."pfac/edit/?mode=notes&pfac_id=".$pfac_id."&opt=sorting&sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "&page=1").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
								$imgAsc = "<a href=\"".$site_config['base_url']."pfac/edit/?mode=notes&pfac_id=".$pfac_id."&opt=sorting&sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "&page=1").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
								$imgDesc = "<a href=\"".$site_config['base_url']."pfac/edit/?mode=notes&pfac_id=".$pfac_id."&opt=sorting&sort=".$_GET['sort']."&by=desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "&page=1").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\"><img src=\"../../public/images/s_desc.png\" border=\"0\" /></a>";								
								$img = (!isset($_GET['by'])) ? ($imgDefault) : (($_GET['by'] == "asc") ? $imgDesc : $imgAsc);
			
								$sort_param_array = array("notecat" => "note_cat_name", "desc" => "note", "mod_date" => "date_modified", "mod_by" => "modified_by", 
														  "add_by" => "added_by", "add_date" => "date_added");
								foreach($sort_param_array as $key => $value) {
									if ($key == $_GET['sort']) {
										$sortBy = $value;
									}
								}
							}
							// retrieve all notes and all notes couunt to this client
							$all_notes_to_this_client_in_edit = $pfacModel->retrieve_all_notes_owned_by_this_client_only_for_the_edit_view($notes_array, $cur_page, $sortBy, ((isset($_GET['by'])) ? $_GET['by'] : ""), $_GET['pfac_id']);
							$all_notes_count_to_this_client_in_edit = $pfacModel->retrieve_all_notes_count_owned_by_this_client_only_for_the_edit_view($_GET['pfac_id'], $notes_array);
							$pagination = $pagination_obj->generate_pagination($all_notes_count_to_this_client_in_edit, $cur_path, NO_OF_RECORDS_PER_PAGE);				
							$tot_page_count = ceil($all_notes_count_to_this_client_in_edit/NO_OF_RECORDS_PER_PAGE);				
							// Delete the selected note	
							if ((isset($_GET['opt'])) && ($_GET['opt'] == "drop")){
								// Check the note id exist in the db
								if ($pfacModel->check_note_id_exist(trim($_GET['note_id'])) != ""){
									// Check the note is owned by him self
									if ($pfacModel->check_note_id_owned_by_the_correct_client(trim($_GET['pfac_id']), trim($_GET['note_id'])) != ""){								
										$pfacModel->delete_selected_note($_GET['note_id'], $pfac_id);
										// Log keeping
										$log_params = array(
															"user_id" => $_SESSION['logged_user']['id'], 
															"action_desc" => "Deleted a note of PFA Client id {$pfac_id}",
															"date_crated" => date("Y-m-d-H:i:s")
															);
										$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
										$_SESSION['selected_note_deleted'] = true;
										AppController::redirect_to($site_config['base_url']."pfac/edit/?mode=notes&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1"));
									}else{
										AppController::redirect_to($site_config['base_url'] ."pfac/view/");
									}
								}else{
									AppController::redirect_to($site_config['base_url'] ."pfac/view/");
								}	
							}
							// Show full details of the above client selected note
							if ((isset($_GET['opt'])) && (($_GET['opt'] == "view") || ($_GET['opt'] == "edit"))){						
								// Check the note id exist in the db
								if ($pfacModel->check_note_id_exist(trim($_GET['note_id'])) != ""){						
									if ($pfacModel->check_note_id_owned_by_the_correct_client(trim($_GET['pfac_id']), trim($_GET['note_id'])) != ""){
										$note_param = array("note", "note_cat_id", "note_cat_name", "date_modified", "modified_by", "added_by", "date_added");
										$note_full_details = $pfacModel->retrieve_full_details_of_selected_note($_GET['note_id'], $note_param);				
									}else{
										AppController::redirect_to($site_config['base_url'] ."pfac/view/");	
									}	
								}else{
									AppController::redirect_to($site_config['base_url'] ."pfac/view/");																						
								}	
							}	
						break;					
					}
					// Configure the action panel with against user permissions 
					$action_panel_menu = $pfacModel->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, $view, $_GET['mode'], trim($_GET['pfac_id']));
					// Generate the top header menu
					$printHtml = "";
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "general")) ? "<span class=\"headerTopicSelected\">General Details</span>" : "<span><a href=\"?mode=general&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">General Details</a></span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "contact")) ? "<span class=\"headerTopicSelected\">Contact Details</span>" : "<span><a href=\"?mode=contact&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Contact Details</a></span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "history")) ? "<span class=\"headerTopicSelected\">Player History</span>" : "<span><a href=\"?mode=history&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Player History</a></span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "edit-media")) ? "<span class=\"headerTopicSelected\">Add Photo / Video / CV</span>" : "<span><a href=\"?mode=edit-media&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Add Photo / Video / CV</a></span>";					
					$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
					$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "notes")) ? "<span class=\"headerTopicSelected\">Add / Edit Notes</span>" : "<span><a href=\"?mode=notes&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Add / Edit Notes</a></span>";					
					// Bredcrmb to the pfa section				
					$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']
									."\" class=\"headerLink\">Home</a> ";
					if (isset($_GET['opt'])){
						$breadcrumb .= "&rsaquo; <a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/view/\">All Clients</a> &rsaquo; <a class=\"headerLink\" href=\"".
											$site_config['base_url']."pfac/edit/?mode=general&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Edit PFA Client</a> &rsaquo; ".
											"<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/edit/?mode=notes&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."&notes_page=1"."\">Your all notes</a>";
						if ($_GET['opt'] == "view"){
							$breadcrumb	.= " &rsaquo;&nbsp;View single note";				
						}else{
							$breadcrumb	.= " &rsaquo;&nbsp;Edit single note";				
						}										
					}else{
						$breadcrumb .= "&rsaquo; <a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/view/\">All Clients</a> &rsaquo; Edit PFA Client";					
					}
					$breadcrumb .= "</div>";												
					// Start to validate and other main function				
					if ("POST" == $_SERVER['REQUEST_METHOD']){
						$submitStatus = true;					
						// Data Grabbing and validating for the required in general view
						if (isset($_POST['pfac_general_reqired'])) { 
							$_SESSION['pfac_general_reqired'] = $_POST['pfac_general_reqired']; 
							// Check data is valid
							if (!@checkdate($_POST['pfac_general_reqired']['month'], $_POST['pfac_general_reqired']['day'], $_POST['pfac_general_reqired']['year'])){
								$_SESSION['date_input_error'] = true;
							}else{
								$_SESSION['date_input_error'] = false;							
							}
							$errors = $pfacModel->validate_general_view($_POST['pfac_general_reqired']);
							// Data Grabbing and validating for the non required in general view					
							if (isset($_POST['pfac_general_non_reqired'])) { 
								$_SESSION['pfac_general_non_reqired'] = $_POST['pfac_general_non_reqired']; 
							}
						}
						// If the general form does not have any errors then redirect it to the next level	
						if (isset($_POST['pfac_general_submit'])){
							if ($errors){	
								$_SESSION['pfac_reqired_errors'] = $errors;
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
							}elseif ($_SESSION['date_input_error'] == 1){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid date for Birth day.</div>";																		
							}else{
								// If general view and the contact view data has been changed
								if (
									   (isset($_SESSION['pfac_general_reqired'])) || 
									   (isset($_SESSION['pfac_general_non_reqired']))
								   ){   
								   $_SESSION['general_data_updated'] = "true";
									// Load the player html web page
									$htmlContentForSinglePage = $pfacModel->create_or_update_single_web_for_pfac_player("edit", $pfac_id);
									// Update the general view data
									$media_details = array(
															'webpage_url' => $site_config['base_url']."clients/".strtolower($pfacModel->display_pfa_categoryName_by_pfac_id($pfac_id))."/".
																			strtolower($pfacModel->grab_player_single_information_for_the_pfac('first_name', $pfac_id))."-".strtolower($pfacModel->grab_player_single_information_for_the_pfac('last_name', $pfac_id))."/"
														 );
									if ((!empty($_SESSION['pfac_general_reqired'])) || (!empty($_SESSION['pfac_general_non_reqired']))){
										$pfacModel->update_general_info($_SESSION['pfac_general_reqired'], $pfac_id, $htmlContentForSinglePage, 
																		$_SESSION['pfac_general_non_reqired'], $media_details);
										// Log keeping
										$log_params = array(
															"user_id" => $_SESSION['logged_user']['id'], 
															"action_desc" => "Updated General details of PFA Client id {$pfac_id}",
															"date_crated" => date("Y-m-d-H:i:s")
															);
										$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
										unset($_SESSION['pfac_general_reqired']);
										unset($_SESSION['pfac_general_non_reqired']);
										AppController::redirect_to($site_config['base_url'] ."pfac/edit/?mode=general&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));
									}
								}
							}						
						}						
						// Data Grabbing and validating for the required in contact view										
						if (isset($_POST['pfac_contact_not_reqired'])) {
							// Data Grabbing and validating for the required in contact view										
							$_SESSION['pfac_contact_not_reqired'] = $_POST['pfac_contact_not_reqired'];					
							if ((!empty($_POST['contract_start_date']['day'])) && (!empty($_POST['contract_start_date']['month'])) && (!empty($_POST['contract_start_date']['year']))){
								$_SESSION['contract_start_date'] = $_POST['contract_start_date'];	
								if (!@checkdate($_POST['contract_start_date']['month'], $_POST['contract_start_date']['day'], $_POST['contract_start_date']['year'])){
									$_SESSION['date_input_error_2'] = true;
								}else{
									$_SESSION['date_input_error_2'] = false;							
								}
							}
							if ((!empty($_POST['contract_end_date']['day'])) && (!empty($_POST['contract_end_date']['month'])) && (!empty($_POST['contract_end_date']['year']))){
								$_SESSION['contract_end_date'] = $_POST['contract_end_date'];							
								if (!@checkdate($_POST['contract_end_date']['month'], $_POST['contract_end_date']['day'], $_POST['contract_end_date']['year'])){
									$_SESSION['date_input_error_3'] = true;
								}else{
									$_SESSION['date_input_error_3'] = false;							
								}
							}
							if (
								((!empty($_POST['contract_start_date']['day'])) && (!empty($_POST['contract_start_date']['month'])) && (!empty($_POST['contract_start_date']['year'])))						
									&& 
								((!empty($_POST['contract_end_date']['day'])) && (!empty($_POST['contract_end_date']['month'])) && (!empty($_POST['contract_end_date']['year'])))
							   )
							{
								$con_start_date = $_POST['contract_start_date']['year']."-".$_POST['contract_start_date']['month']."-".$_POST['contract_start_date']['day'];							
								$con_end_date = $_POST['contract_end_date']['year']."-".$_POST['contract_end_date']['month']."-".$_POST['contract_end_date']['day'];														
								//$contract_dates_ok = CommonFunctions::check_date_greater_than_another($con_start_date, $con_end_date);
							}else{
								if (
									((!empty($_POST['contract_start_date']['day'])) || (!empty($_POST['contract_start_date']['month'])) || (!empty($_POST['contract_start_date']['year'])))						
										|| 
									((!empty($_POST['contract_end_date']['day'])) || (!empty($_POST['contract_end_date']['month'])) || (!empty($_POST['contract_end_date']['year'])))
								   ){
								   		$contract_dates_empty = false;
								   }else{
								   		$contract_dates_empty = true;								   	
								   }
							}
							if (!empty($_POST['pfac_contact_not_reqired']['email'])){
								$email_validity = CommonFunctions::check_email_address($_POST['pfac_contact_not_reqired']['email']);
							}	
						}
						// If the contact form does not have any errors then redirect it to the next level	
						if (isset($_POST['pfac_contact_submit'])){
							if ($_SESSION['date_input_error_2'] == 1){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid date for Contract Start Date.</div>";																		
							}elseif ($_SESSION['date_input_error_3'] == 1){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid date for Contract End Date.</div>";																		
							//}elseif (!$contract_dates_ok){
								//$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Contract End Date must be greater than the Contract Start Date.</div>";																									
							}elseif (!$contract_dates_empty){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Both Contract Start Date and Contract End Date must be provided.</div>";																																								
							}elseif (!$email_validity){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid Email.</div>";																																
							}else{
							 	$_SESSION['contact_data_updated'] = "true";
								// Update contact view data																				
								if (!empty($_SESSION['pfac_contact_not_reqired'])){									
									$pfacModel->update_contact_info($_SESSION['pfac_contact_not_reqired'], $pfac_id,
																	$_SESSION['contract_start_date'], $_SESSION['contract_end_date']);						
									// Log keeping
									$log_params = array(
														"user_id" => $_SESSION['logged_user']['id'], 
														"action_desc" => "Updated Contact details of PFA Client id {$pfac_id}",
														"date_crated" => date("Y-m-d-H:i:s")
														);
									$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
									unset($_SESSION['pfac_contact_not_reqired']);
									unset($_SESSION['date_input_error_2']);									
									unset($_SESSION['date_input_error_3']);
									unset($_SESSION['contract_start_date']);									
									unset($_SESSION['contract_end_date']);
									AppController::redirect_to($site_config['base_url'] ."pfac/edit/?mode=contact&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));									
								}	
							}						
						}
						// Data grabbing in to the session and validation in pfac_history
						if (isset($_POST['pfac_history_reqired'])) {
							$_SESSION['pfac_history_reqired'] = $_POST['pfac_history_reqired'];					
							$errors = $pfacModel->validate_general_view($_POST['pfac_history_reqired']);						
							// Data grabbing in to the session pfac_history_non_required					
							if (isset($_POST['pfac_history_non_reqired'])) {
								$_SESSION['pfac_history_non_reqired'] = $_POST['pfac_history_non_reqired'];					
							}	
						}
						// If the history form does not have any errors then redirect it to the next level	
						if (isset($_POST['pfac_history_submit'])){
							if ($errors){
								$_SESSION['pfac_reqired_errors'] = $errors;
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
							}else{
								if ($history_records_limit >= 4){
									unset($_SESSION['pfac_session_data']);
									$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">History records exceeds the maximum limit.</div>";											
									AppController::wait_then_redirect_to(2, $site_config['base_url']."pfac/edit/?mode=media&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1"));									
								}else{
									$pfacModel->insert_history_info($pfac_id, array_merge($_SESSION['pfac_history_reqired'], $_SESSION['pfac_history_non_reqired']), "edit");
									// Log keeping
									$log_params = array(
														"user_id" => $_SESSION['logged_user']['id'], 
														"action_desc" => "Inserted new history details of PFA Client id {$pfac_id}",
														"date_crated" => date("Y-m-d-H:i:s")
														);
									$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
									$_SESSION['history_added'] = true;
									unset($_SESSION['pfac_history_reqired']);
									unset($_SESSION['pfac_history_non_reqired']);
									AppController::redirect_to($site_config['base_url'] ."pfac/edit/?mode=history&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));										
								}	
							}											
						}							
						// If the history form does not have any errors then redirect it to the next level	
						if (isset($_POST['pfac_history_submit2'])){
							if ($errors){	
								$_SESSION['pfac_reqired_errors'] = $errors;
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
							}else{
								AppController::redirect_to($site_config['base_url'] ."pfac/edit/?mode=media&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));	
							}											
						}					
						// If the media view data has been updated
						if (isset($_POST['pfac_media_submit_save'])){
		
							$data_updated = false;	
							$media_details = array();				 					
							// If media view data has been changed					
							if (
								(isset($_SESSION['pre_pfac_preview_img'])) && (isset($_SESSION['pre_pfac_preview_cv'])) 
							){
								//Image path
								if (!isset($_SESSION['pfac_preview_img'])){
									$img_path = $pfacModel->grab_player_single_information_for_the_pfac('photo_url',$pfac_id);
								}else{
									$img_path = $_SESSION['pfac_preview_img']['name'];
									//make images
									$small = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/small/'.$_SESSION['pfac_preview_img']['name'];
									$medium = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/medium/'.$_SESSION['pfac_preview_img']['name'];
									$large = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/large/'.$_SESSION['pfac_preview_img']['name'];
									$ori = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/'.$_SESSION['pfac_preview_img']['name'];
									$thumb = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/thumb/'.$_SESSION['pfac_preview_img']['name'];
											
									$imageCreate = new ImageCreate();
									$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $small , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], 60, 60);
									$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $medium , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], 70, 58);
									$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $large , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], Null, 275);
									
									rename($_SESSION['pfac_preview_img']['file_path_thumb'],$thumb);
									rename($_SESSION['pfac_preview_img']['file_path_ori'], $ori);
									unlink($_SESSION['pfac_preview_img']['file_path_prew']);
									
								}
								//Video path						
								if (!isset($_SESSION['pfac_preview_video'])){
									$video_path = $pfacModel->grab_player_single_information_for_the_pfac('video_url',$pfac_id);
								}else{
									$video_path = $_SESSION['pfac_preview_video']['name'];
									$video_loc = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/videos/'.$_SESSION['pfac_preview_video']['name'];
									if(is_file($_SESSION['pfac_preview_video']['file_path_video'])){
										rename($_SESSION['pfac_preview_video']['file_path_video'],$video_loc);
									}
									
								}
								//Cv path
								if (!isset($_SESSION['pfac_preview_cv'])){
									$cv_path = $pfacModel->grab_player_single_information_for_the_pfac('cv_url',$pfac_id);
								}else{
									$cv_path = $_SESSION['pfac_preview_cv']['name'];
									$cv_loc = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/cvs/'.$_SESSION['pfac_preview_cv']['name'];
									rename($_SESSION['pfac_preview_cv']['file_path_cv'],$cv_loc);
								}	
					
								//Database param array
								$media_details = array(
														'photo_url' => $img_path,
														'video_url' => $video_path,
														'cv_url' => $cv_path,
														'webpage_url' => str_replace("admin.", "", $site_config['base_url'])."clients/".strtolower($pfacModel->display_pfa_categoryName_by_pfac_id($pfac_id))."/".
																		strtolower($pfacModel->grab_player_single_information_for_the_pfac('first_name', $pfac_id))."-".strtolower($pfacModel->grab_player_single_information_for_the_pfac('last_name', $pfac_id))."/"
													 );	
								//Update the general media details only regarding the media view changes											 
								$data_updated = true;							
								$pfacModel->update_general_info_regarding_the_media_view_change($_SESSION['id_for_preview'], $media_details);
								// Log keeping
								$log_params = array(
													"user_id" => $_SESSION['logged_user']['id'], 
													"action_desc" => "Updated media details of PFA Client id {$pfac_id}",
													"date_crated" => date("Y-m-d-H:i:s")
													);
								$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
							}else{						
								//Database param array					
								$media_details = array(
														'photo_url' => $pfacModel->grab_player_single_information_for_the_pfac('photo_url', $pfac_id),
														'video_url' => $pfacModel->grab_player_single_information_for_the_pfac('video_url', $pfac_id),
														'cv_url' => $pfacModel->grab_player_single_information_for_the_pfac('cv_url', $pfac_id),
														'webpage_url' => $site_config['base_url']."clients/".strtolower($pfacModel->display_pfa_categoryName_by_pfac_id($pfac_id))."/".
																		strtolower($pfacModel->grab_player_single_information_for_the_pfac('first_name', $pfac_id))."-".strtolower($pfacModel->grab_player_single_information_for_the_pfac('last_name', $pfac_id))."/"
													 );
								$data_updated = false;												 
							}	
							// If data updated in the media view
							//if ($data_updated){
								$_SESSION['media_data_updated'] = "true";				
								// Unset all session data and other loaded objects that used to PFA add section
								unset($_SESSION['pfac_preview_img']);
								unset($_SESSION['pfac_preview_video']);
								unset($_SESSION['pfac_preview_cv']);
								unset($_SESSION['id_for_preview']);
								AppController::redirect_to($site_config['base_url']."pfac/edit/?mode=notes&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));								
							//}else{
								//$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please correct the errors in the form(s).</div>";																							
							//}
						}	
						// If notes form has been submitted in add new note section
						if (isset($_POST['pfac_notes_submit'])){
							// If no value has been submitted regarding the notes section
							if ((empty($_POST['pfac_note_required']['note_cat'])) && (empty($_POST['pfac_note_required']['note_text']))){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category and fill the note text box.</div>";		
							// If both values has been submitted	
							}else{
								if (empty($_POST['pfac_note_required']['note_cat'])){
									$_SESSION['pfac_note_required']['note_text'] = $_POST['pfac_note_required']['note_text'];
									$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category.</div>";																							
								}elseif (empty($_POST['pfac_note_required']['note_text'])){
									$_SESSION['pfac_note_required']['note_cat'] = $_POST['pfac_note_required']['note_cat'];							
									$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please fill the note text box.</div>";		
								}else{
									$_SESSION['pfac_note_required']['note_text'] = $_POST['pfac_note_required']['note_text'];							
									$_SESSION['pfac_note_required']['note_cat'] = $_POST['pfac_note_required']['note_cat'];									
									$notes_inputting_array = array(
														"note_cat_id" => $_SESSION['pfac_note_required']['note_cat'],								
														"note_owner_id" => $pfac_id,
														"note_owner_type" => "PFAC",
														"note_text" => $_SESSION['pfac_note_required']['note_text'],
														"date_added" => date("Y-m-d-H:i:s"),
														"added_by" => $_SESSION['logged_user']['id']
														);
									$pfacModel->insert_new_note($notes_inputting_array);
									// Log keeping
									$log_params = array(
														"user_id" => $_SESSION['logged_user']['id'], 
														"action_desc" => "New note inserted to PFA Client id {$pfac_id}",
														"date_crated" => date("Y-m-d-H:i:s")
														);
									$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
									// Load all notes regarding to this client						
									$note_param = array("note", "note_cat_id", "note_cat_name", "date_modified", "modified_by", "added_by", "date_added");											
									// Grab the current page
									$cur_page = ((isset($_GET['notes_page'])) && ($_GET['notes_page'] != "") && ($_GET['notes_page'] != 0)) ? $_GET['notes_page'] : 1; 												
									// retrieve all notes and all notes couunt to this client
									$all_notes_to_this_client_in_edit = $pfacModel->retrieve_all_notes_owned_by_this_client_only_for_the_edit_view($notes_array, $cur_page, $sortBy, ((isset($_GET['by'])) ? $_GET['by'] : ""), $_GET['pfac_id']);
									$all_notes_count_to_this_client_in_edit = $pfacModel->retrieve_all_notes_count_owned_by_this_client_only_for_the_edit_view($_GET['pfac_id'], $notes_array);
									$pagination = $pagination_obj->generate_pagination($all_notes_count_to_this_client_in_edit, $_SERVER['REQUEST_URI'], 1);				
									$tot_page_count = ceil($all_notes_count_to_this_client_in_edit/1);				
									$_SESSION['new_note_has_created'] = true;
									AppController::redirect_to($site_config['base_url']."pfac/edit/?mode=notes&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1"));																					
									unset($_POST);									
									unset($_SESSION['pfac_note_required']['note_cat']);
									unset($_SESSION['pfac_note_required']['note_text']);
								}
							}
						}
						// If notes form has been submitted in edit note section
						if (isset($_POST['pfac_notes_update_submit'])){
							// Check the note id exist in the db
							if ($pfacModel->check_note_id_exist(trim($_GET['note_id'])) != ""){
								// Check the note is owned by him self
								if ($pfacModel->check_note_id_owned_by_the_correct_client(trim($_GET['pfac_id']), trim($_GET['note_id'])) != ""){								
									// If no value has been submitted regarding the notes section
									if ((empty($_POST['pfac_note_required']['note_cat'])) && (empty($_POST['pfac_note_required']['note_text']))){
										$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category and fill the note text box.</div>";		
									// If both values has been submitted	
									}else{
										if (empty($_POST['pfac_note_required']['note_cat'])){
											$_SESSION['pfac_note_required']['note_text'] = $_POST['pfac_note_required']['note_text'];
											$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select one of note category.</div>";																							
										}elseif (empty($_POST['pfac_note_required']['note_text'])){
											$_SESSION['pfac_note_required']['note_cat'] = $_POST['pfac_note_required']['note_cat'];							
											$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please fill the note text box.</div>";		
										}else{
											$_SESSION['pfac_note_required']['note_text'] = $_POST['pfac_note_required']['note_text'];							
											$_SESSION['pfac_note_required']['note_cat'] = $_POST['pfac_note_required']['note_cat'];									
											$notes_inputting_array = array(
																"note_cat_id" => $_SESSION['pfac_note_required']['note_cat'],								
																"note_owner_id" => $pfac_id,													
																"note_text" => $_SESSION['pfac_note_required']['note_text'],
																"date_modified" => date("Y-m-d-H:i:s"),
																"modified_by" => $_SESSION['logged_user']['id']
																);
											$pfacModel->update_the_exsiting_note($notes_inputting_array, $_GET['note_id']);
											// Log keeping
											$log_params = array(
																"user_id" => $_SESSION['logged_user']['id'], 
																"action_desc" => "Update one of existing notes of PFA Client id {$pfac_id}",
																"date_crated" => date("Y-m-d-H:i:s")
																);
											$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
											$note_param = array("note", "note_cat_id", "note_cat_name", "date_modified", "modified_by", "added_by", "date_added");											
											$note_full_details = $pfacModel->retrieve_full_details_of_selected_note($_GET['note_id'], $note_param);				
											unset($_POST);
											unset($_SESSION['pfac_note_required']['note_cat']);
											unset($_SESSION['pfac_note_required']['note_text']);
											$_SESSION['notes_section_got_updated'] = "true";
											AppController::redirect_to($site_config['base_url']."pfac/edit/?mode=notes&pfac_id=".$pfac_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1"));												
										}
									}
								// If note id is not owned by him self																				
								}else{
									unset($_SESSION['pfac_note_required']['note_cat']);
									unset($_SESSION['pfac_note_required']['note_text']);
									AppController::redirect_to($site_config['base_url'] ."pfac/view/");	
								}
							// If wrong note id										
							}else{
								unset($_SESSION['pfac_note_required']['note_cat']);
								unset($_SESSION['pfac_note_required']['note_text']);
								AppController::redirect_to($site_config['base_url'] ."pfac/view/");	
							}	
						}
	
					}else{
						// If still form is having errors then not to proceed
						if (isset($_SESSION['still_errors_in_the_form']) && ($_SESSION['still_errors_in_the_form'] == "true")){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please correct the following indicated errors.</div>";																
						}					
						// Unset rest of session data if not submitted the form
						unset($_SESSION['pfac_reqired_errors']);
						unset($_SESSION['still_errors_in_the_form']);
						
						/*commented by prageeth
						unset($_SESSION['pfac_preview_img']);
						unset($_SESSION['pfac_preview_video']);
						unset($_SESSION['pfac_preview_cv']);
						*/
						unset($_SESSION['pfac_general_reqired']);
						unset($_SESSION['pfac_general_non_reqired']);
						unset($_SESSION['pfac_contact_reqired']);
						unset($_SESSION['pfac_contact_not_reqired']);
						unset($_SESSION['date_input_error_2']);									
						unset($_SESSION['date_input_error_3']);
						unset($_SESSION['contract_start_date']);									
						unset($_SESSION['contract_end_date']);
						unset($_SESSION['pfac_history_reqired']);
						unset($_SESSION['pfac_history_non_reqired']);
						unset($_SESSION['pfac_session_data']);
						$submitStatus = false;	
						unset($commonFuncs);
						unset($pfacModel);					
					}
				// If wrong id	
				}else{
					AppController::redirect_to($site_config['base_url'] ."pfac/view/");																				
				}	
			break;
			
			case "drop":
				// All global variables		
				global $site_config;
				// objects instantiation
				$pfacModel = new PfacModel();	
				// Delete the pfac contact
				// Check whether the address book id is exist in the database		
				if ($pfacModel->check_pfac_id_exist(trim($_GET['pfac_id'])) != ""){																				
					$pfacModel->delete_record_in_general_view($_GET['pfac_id']);
					$pfacModel->delete_record_in_contact_view($_GET['pfac_id']);
					$pfacModel->delete_record_in_history_view($_GET['pfac_id']);
					$pfacModel->delete_owned_notes($_GET['pfac_id']);
					// Log keeping
					$log_params = array(
										"user_id" => $_SESSION['logged_user']['id'], 
										"action_desc" => "Deleted the PFA Client id {$_GET['pfac_id']} and its all details",
										"date_crated" => date("Y-m-d-H:i:s")
										);
					$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
					$_SESSION['deleted_selected_pfac'] = "true";
					AppController::redirect_to($site_config['base_url'] ."pfac/view/");																				
				// If wrong id	
				}else{
					AppController::redirect_to($site_config['base_url'] ."pfac/view/");																				
				}	
			break;
		
			case "show":
				// All global variables		
				global $fullDetails;
				global $historyDetails;
				global $breadcrumb;
				global $site_config;
				global $action_panel_menu;
				global $pfac_id;
				$breadcrumb = "";
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']
								."\" class=\"headerLink\">Home</a> &rsaquo; "."<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/view/\">All Clients</a> &rsaquo; Details</div>";
				// objects instantiation
				$pfacModel = new PfacModel();	
				// Check whether the address book id is exist in the database		
				if ($pfacModel->check_pfac_id_exist(trim($_GET['pfac_id'])) != ""){									
					// Configure the action panel with against user permissions 
					$action_panel_menu = $pfacModel->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, $view);
					$fullDetails = $pfacModel->grab_full_details_for_the_single_view(trim($_GET['pfac_id']));		
					$pfac_id = $fullDetails[0]['id'];
					$params = array("club", "appearances", "goals");
					$historyDetails = $pfacModel->retrive_history_details_for_single_pfac(trim($_GET['pfac_id']),  $params);
					// Log keeping
					$log_params = array(
										"user_id" => $_SESSION['logged_user']['id'], 
										"action_desc" => "Viewed details of PFA Client id {$_GET['pfac_id']}",
										"date_crated" => date("Y-m-d-H:i:s")
										);
					$pfacModel->keep_track_of_activity_log_in_pfac($log_params);
				// If wrong id	
				}else{
					AppController::redirect_to($site_config['base_url'] ."pfac/view/");																				
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