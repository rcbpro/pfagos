<?php

class pfac_addbook_controller extends AppController{

	/* This function will check the correct sub view provided else redirect to the home page */
	function correct_sub_view_gate_keeper($subView){
	
		if (isset($subView)){
			$modes_array = array("main", "notes");
			if (!in_array($subView, $modes_array)){
				global $site_config;
				AppController::redirect_to($site_config['base_url']."pfa-addbook/view/");
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
	function process_the_correct_model($view, $controller, $mode = ""){

		switch($view) {
		
			case "add":
				// All Global variables
				global $addbook_cats;
				global $all_notes_to_this_client;				
				global $nationalityArray;
				global $countryListArray;
				global $languageListArray;
				global $headerDivMsg;
				global $site_config;
				global $printHtml;
				global $breadcrumb;
				global $languageAbilityArray;
				$breadcrumb = "";
				$email_validity = true;
				// Generate the top header menu
				$printHtml = "";
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "main")) ? "<span class=\"specializedTexts\">Main Details</span>" : "<span class=\"disabledHrefLinks\">Main Details</span>";					
				$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "notes")) ? "<span class=\"specializedTexts\">Notes</span>" : "<span class=\"disabledHrefLinks\">Notes</span>";					
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']."\" class=\"headerLink\">Home</a> &rsaquo; Add New Contact</div>";
				// Object Instantiation
				$pfac_addbook_model = new pfac_addbook(); 
				$addbook_cats = $pfac_addbook_model->retrieve_addressbook_categories();
				$nationalityArray = CommonFunctions::retrieve_nationality_list();
				$countryListArray = CommonFunctions::retrieve_country_list();				
				$languageListArray = CommonFunctions::retrieve_language_list();	
				$languageAbilityArray = CommonFunctions::retrieve_language_ability_list();										
				// Switch to the correct sub view
				switch($mode){
					
					case "main": $whichFormToInclude = "main"; break;
					case "notes": 
						$whichFormToInclude = "notes"; 
						// Display the success message in new contact adding
						if ($_SESSION['new_contact_saved']){					
							$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">PFA Address book contact was addedd successfully. <a href='".$site_config['base_url'].
								"pfa-addbook/show/?addbook_id=".$_SESSION['newly_inserted_pfa_addbook_id']."' class='edtingMenusLink_in_view'>View details</a></div>";																																			
						}
						unset($_SESSION['new_contact_saved']);	
						// Display the success message in new note adding in the last inserted contact	
						if ($_SESSION['new_note_has_created'] == "true"){					
							$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">New note has been created.</div>";																																			
						}
						unset($_SESSION['new_note_has_created']);	
						// Display the notice message after deletion ogf the selected note
						if ($_SESSION['deleted_selected_note'] == "true"){					
							$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Deleted the selected note.</div>";																																			
						}
						unset($_SESSION['deleted_selected_note']);							
						$pfa_addbook_id = $_SESSION['newly_inserted_pfa_addbook_id'];
						// Load last inserted notes by last inserted user
						$notes_array = array('note_id', 'note_owner_id', 'note', 'date_modified', 'modified_by');					
						$all_notes_to_this_client = $pfac_addbook_model->retrieve_all_notes_owned_by_this_client($_SESSION['newly_inserted_pfa_addbook_id'], $notes_array);
						// Delete the selected note	
						if ((isset($_GET['opt'])) && ($_GET['opt'] == "drop")){
							$pfac_addbook_model->delete_selected_note($_GET['note_id'], $pfa_addbook_id);
							$_SESSION['deleted_selected_note'] = "true";
							// Log keeping
							$log_params = array(
												"user_id" => $_SESSION['logged_user']['id'], 
												"action_desc" => "Deleted the last inserted note of PFA Address book id {$pfac_id}",
												"date_crated" => date("Y-m-d-H:i:s")
												);
							$pfac_addbook_model->keep_track_of_activity_log_in_pfa_addbook($log_params);
							AppController::redirect_to($site_config['base_url']."pfa-addbook/add/?mode=notes");
						}								
					break;										
				}
				// If the correct post back not submitted then redirect the user to the correct page
				if (($mode == "notes") && (!isset($_SESSION['newly_inserted_pfa_addbook_id']))){
					AppController::redirect_to($site_config['base_url'] ."pfa-addbook/add/?mode=main");
				}
				// If post has been submitted
				if ("POST" == $_SERVER['REQUEST_METHOD']){
					$errors = AppModel::validate($_POST['pfac_addbook_reqired']);
					$_SESSION['pfac_addbook_reqired'] = $_POST['pfac_addbook_reqired'];
					$_SESSION['pfac_addbook_not_reqired'] = $_POST['pfac_addbook_not_reqired'];
					if (!empty($_POST['pfac_addbook_not_reqired']['email'])){
						$email_validity = CommonFunctions::check_email_address($_POST['pfac_addbook_not_reqired']['email']);
					}	
					// If notes form has been submitted
					if (isset($_POST['pfac_addbook_submit'])){	
						// If errors found in the adding section
						if ($errors){
							$_SESSION['pfaaddbook_reqired_errors'] = $errors;					
							// Display the error message						
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
						}elseif (!$email_validity){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid Email.</div>";																																
						}else{
								$_SESSION['newly_inserted_pfa_addbook_id'] = $pfac_addbook_model->insert_addbook_details(array_merge($_SESSION['pfac_addbook_reqired'], 
																														$_SESSION['pfac_addbook_not_reqired']));
								// Log keeping
								$log_params = array(
													"user_id" => $_SESSION['logged_user']['id'], 
													"action_desc" => "New Address book contact was created",
													"date_crated" => date("Y-m-d-H:i:s")
													);
								$pfac_addbook_model->keep_track_of_activity_log_in_pfa_addbook($log_params);
								$_SESSION['new_contact_saved'] = true;
								// Unset all used data
								unset($_SESSION['pfaaddbook_reqired_errors']);						
								unset($_SESSION['pfac_addbook_reqired']);
								unset($_SESSION['pfac_addbook_not_reqired']);
								unset($pfac_addbook_model);	
								AppController::redirect_to($site_config['base_url']."pfa-addbook/add/?mode=notes");												
							}
						}
						// If notes form has been submitted
						if (isset($_POST['pfa_addbook_notes_submit'])){
							// If no value has been submitted regarding the notes section
							if (empty($_POST['pfa_addbook_note_required']['note_text'])){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please fill the note text box.</div>";		
							// If values has been submitted	
							}else{
								$_SESSION['pfa_addbook_note_required']['note_text'] = $_POST['pfa_addbook_note_required']['note_text'];							
								$notes_inputting_array = array(
																"note_owner_id" => $_SESSION['newly_inserted_pfa_addbook_id'],
																"note_owner_type" => "PFA_ADDBOOK",
																"note_text" => $_SESSION['pfa_addbook_note_required']['note_text'],
																"date_added" => date("Y-m-d-H:i:s"),
																"added_by" => $_SESSION['logged_user']['id']
															  );
								$pfac_addbook_model->insert_new_note($notes_inputting_array);
								$_SESSION['new_note_has_created'] = "true";		
								// Log keeping
								$log_params = array(
													"user_id" => $_SESSION['logged_user']['id'], 
													"action_desc" => "Created a new note to PFA_Address book id {$_SESSION['newly_inserted_pfa_addbook_id']}",
													"date_crated" => date("Y-m-d-H:i:s")
													);
								$pfac_addbook_model->keep_track_of_activity_log_in_pfa_addbook($log_params);
								$notes_array = array('note_id', 'note_owner_id', 'note', 'date_modified', 'modified_by');					
								$all_notes_to_this_client = $pfac_addbook_model->retrieve_all_notes_owned_by_this_client($_SESSION['newly_inserted_pfa_addbook_id'], $notes_array);																																																	
								unset($_POST);									
								unset($_SESSION['pfa_addbook_note_required']['note_text']);
								AppController::redirect_to($site_config['base_url'] ."pfa-addbook/add/?mode=notes");									
							}
							$notes_array = array('note_id', 'note_owner_id', 'note', 'date_modified', 'modified_by');					
							$all_notes_to_this_client = $pfac_addbook_model->retrieve_all_notes_owned_by_this_client($_SESSION['newly_inserted_pfa_addbook_id'], $notes_array);
						}	
					}else{
						unset($_SESSION['pfaaddbook_reqired_errors']);						
						unset($_SESSION['pfac_addbook_reqired']);
						unset($_SESSION['pfac_addbook_not_reqired']);
						unset($pfac_addbook_model);	
						if (isset($_GET['p'])){								
							unset($_SESSION['pfaaddbook_reqired_errors']);						
							unset($_SESSION['pfac_addbook_reqired']);
							unset($_SESSION['pfac_addbook_not_reqired']);
							unset($_SESSION['newly_inserted_pfa_addbook_id']);
						}
					}	
			break;
			
			case "view":
				// Unset all frist step session data
				unset($_SESSION['pfaaddbook_reqired_errors']);						
				unset($_SESSION['pfac_addbook_reqired']);
				unset($_SESSION['pfac_addbook_not_reqired']);
				unset($_SESSION['newly_inserted_pfa_addbook_id']);
				// All Global variables
				global $site_config;
				global $all_pfa_addbook_contacts;
				global $all_pfa_addbook_contacts_count;
				global $pagination;
				global $tot_page_count;
				global $cur_page;
				global $img;
				global $breadcrumb;
				global $invalidPage;								
				global $headerDivMsg;
				global $action_panel_menu;
				global $addbook_id;
				$breadcrumb = "";
				$sortBy = "";
				$sortPath = "";																												
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']."\" class=\"headerLink\">Home</a> &rsaquo; View All Contacts</div>";
				// Object Instantiation
				$pfac_addbook_model = new pfac_addbook(); 
				$pagination_obj = new Pagination();				
				// Configure the action panel with against user permissions 
				$action_panel_menu = $pfac_addbook_model->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, $view);
				// Display the success message
				if ($_SESSION['deleted_selected_contact'] == "true"){
					$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Successfully deleted the contact.</div>";					
				}
				unset($_SESSION['deleted_selected_contact']);				
				// Viewing all contacts in the table
				$cur_page = ((isset($_GET['page'])) && ($_GET['page'] != "") && ($_GET['page'] != 0)) ? $_GET['page'] : 1; 												
				$param_array = array('id', 'first_name', 'last_name', 'pfac_playerType', 'cfcp_playerType', 'Client_category_name', 'organization', 'pref_language', 'ability_of_english', 'nationality', 'location');
				// Display all pfac_records				
				if (isset($_GET['sort'])){	
				
					$imgDefault = "<a href=\"".$site_config['base_url']."pfa-addbook/view/?sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
					$imgAsc = "<a href=\"".$site_config['base_url']."pfa-addbook/view/?sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
					$imgDesc = "<a href=\"".$site_config['base_url']."pfa-addbook/view/?sort=".$_GET['sort']."&by=desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_desc.png\" border=\"0\" /></a>";								
					$img = (!isset($_GET['by'])) ? ($imgDefault) : (($_GET['by'] == "asc") ? $imgDesc : $imgAsc);

					$sort_param_array = array(
											  "f_name" => "first_name", "l_name" => "last_name", "agent_type" => "pfac_playerType", 
											  "addbook_cat" => "Client_category_name", "nation" => "nationality", "loc" => "location",
											  "eng" => "ability_of_english", "pref" => "pref_language", "org" => "organization", 
											  );
					foreach($sort_param_array as $key => $value) {
						if ($key == $_GET['sort']) {
							$sortBy = $value;
						}
					}
					$sortPath = "sort=".$_GET['sort'];					 
					if (isset($_GET['by'])) $sortPath .= "&by=".$_GET['by']."&";										 
				}
				// Load all data from the address book
				$all_pfa_addbook_contacts = $pfac_addbook_model->display_all_pfa_addbook_contacts($param_array, $cur_page, $sortBy, ((isset($_GET['by'])) ? $_GET['by'] : ""));
				$all_pfa_addbook_contacts_count = $pfac_addbook_model->display_count_on_all_pfa_addbook_contacts();
				// Pagination load
				$pagination = $pagination_obj->generate_pagination($all_pfa_addbook_contacts_count, $_SERVER['REQUEST_URI'], NO_OF_RECORDS_PER_PAGE);				
				$tot_page_count = ceil($all_pfa_addbook_contacts_count/NO_OF_RECORDS_PER_PAGE);				
				// If no records found or no pages found
				$page = (isset($_GET['page'])) ? $_GET['page'] : 1;				
				if (($page > $tot_page_count) || ($page == 0)){
					$invalidPage = true;	
				}
				// Unset all used variables
				unset($pfac_addbook_model);
				unset($pagination_obj);
			break;			
		
			case "edit":
			
				// All Global variables
				global $full_details;
				global $addbook_cats;
				global $nationalityArray;
				global $countryListArray;
				global $languageListArray;
				global $languageAbilityArray;
				global $headerDivMsg;
				global $site_config;
				global $breadcrumb;
				global $printHtml;
				global $all_notes_to_this_client_in_edit;
				global $pfa_addbook_id;
				global $note_full_details;
				global $pagination;
				global $tot_page_count;
				global $img;
				global $action_panel_menu;
				global $pfac_addbook_model;
				$breadcrumb = "";
				$email_validity = true;
				// Bredcrmb to the pfa section				
				$pfa_addbook_id = trim($_GET['addbook_id']);
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']."\" class=\"headerLink\">Home</a> ";
				if (isset($_GET['opt'])){
					$breadcrumb .= "&rsaquo; <a class=\"headerLink\" href=\"".$site_config['base_url']."pfa-addbook/view/\">All Contacts</a> &rsaquo; <a class=\"headerLink\" href=\"".
										$site_config['base_url']."pfa-addbook/edit/?mode=main&addbook_id=".$pfa_addbook_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Edit the Contact</a> &rsaquo; ".
										"<a class=\"headerLink\" href=\"".$site_config['base_url']."pfa-addbook/edit/?mode=notes&addbook_id=".$pfa_addbook_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."&notes_page=1"."\">Your all notes</a>";
					if ($_GET['opt'] == "view"){
						$breadcrumb	.= "&rsaquo; View single note";				
					}else{
						$breadcrumb	.= "&rsaquo; Edit single note";				
					}										
				}else{
					$breadcrumb .= "&rsaquo; <a class=\"headerLink\" href=\"".$site_config['base_url']."pfa-addbook/view/\">All Contacts</a> &rsaquo; Edit the Contact";					
				}
				$breadcrumb .= "</div>";												
				// Generate the top header menu
				$printHtml = "";
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "main")) ? "<span class=\"headerTopicSelected\">Main Details</span>" : "<span><a href=\"?mode=main&addbook_id=".trim($_GET['addbook_id']).((isset($_GET['page'])) ? "&page=".$_GET['page'] : "")."\">Main Details</a></span>";					
				$printHtml .= "&nbsp;&nbsp;<span class=\"ar\">&rsaquo;</span>&nbsp;&nbsp;";
				$printHtml .= ((isset($_GET['mode'])) && ($_GET['mode'] == "notes")) ? "<span class=\"headerTopicSelected\">Notes</span>" : "<span><a href=\"?mode=notes&addbook_id=".trim($_GET['addbook_id']).((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Notes</a></span>";					
				// Object Instantiation
				$pfac_addbook_model = new pfac_addbook(); 
				$addbook_cats = $pfac_addbook_model->retrieve_addressbook_categories();		
				$nationalityArray = CommonFunctions::retrieve_nationality_list();
				$countryListArray = CommonFunctions::retrieve_country_list();				
				$languageListArray = CommonFunctions::retrieve_language_list();	
				$languageAbilityArray = CommonFunctions::retrieve_language_ability_list();	
				// Generate the action panel
				$action_panel_menu = $pfac_addbook_model->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, $view, $_GET['mode'], trim($_GET['addbook_id']));				
				// Switch to the correct sub view
				switch($mode){
					
					case "main": 
						$whichFormToInclude = "main"; 
						// Display the success message after succesful updation of contact details						
						if ($_SESSION['contact_details_updated']){
							$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">Address book contact was updated successfully. <a href='".$site_config['base_url'].
								"pfa-addbook/show/?addbook_id=".$pfa_addbook_id."' class='edtingMenusLink_in_view'>View details</a></div>";																																			
						}					
						unset($_SESSION['contact_details_updated']);
					break;
					case "notes":						 
						$whichFormToInclude = "notes"; 
						$pagination_obj = new Pagination();
						// Display the success message in new note adding in the last inserted contact	
						if ($_SESSION['new_note_has_created'] == "true"){					
							$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">New note has been created.</div>";																																			
						}
						unset($_SESSION['new_note_has_created']);	
						// Display the notice message after deletion ogf the selected note
						if ($_SESSION['deleted_selected_note']){					
							$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Deleted the selected note.</div>";																																			
						}
						unset($_SESSION['deleted_selected_note']);							
						// Display the success message after succesful updation of contact details						
						if ($_SESSION['notes_section_got_updated']){
							$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">The above note was updated successfully.</div>";																																			
						}					
						unset($_SESSION['notes_section_got_updated']);
						// Sorting of the notes section
						if (!isset($_GET['notes_page'])){ 
							$cur_path = "?".(isset($_GET['sort'])) ? "sort=".@$_GET['sort'].((isset($_GET['by'])) ? "&by=".$_GET['by'] : "") : ""; 
						}else{ 
							$cur_path = $_SERVER['REQUEST_URI']; 						
						}
						// Load all notes regarding to this client						
						$notes_array = array('note_id', 'note_owner_id', 'note', 'date_added', 'added_by', 'date_modified', 'modified_by');					
						// Grab the current page
						$cur_page = ((isset($_GET['notes_page'])) && ($_GET['notes_page'] != "") && ($_GET['notes_page'] != 0)) ? $_GET['notes_page'] : 1; 												
						// Grab the pfac id
						if (isset($_GET['sort'])){	
						
							$imgDefault = "<a href=\"".$site_config['base_url']."pfa-addbook/edit/?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
							$imgAsc = "<a href=\"".$site_config['base_url']."pfa-addbook/edit/?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
							$imgDesc = "<a href=\"".$site_config['base_url']."pfa-addbook/edit/?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=".$_GET['sort']."&by=desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\"><img src=\"../../public/images/s_desc.png\" border=\"0\" /></a>";								
							$img = (!isset($_GET['by'])) ? ($imgDefault) : (($_GET['by'] == "asc") ? $imgDesc : $imgAsc);
		
							$sort_param_array = array("desc" => "note", "mod_date" => "date_modified", "mod_by" => "modified_by", "add_date" => "date_added", "add_by" => "added_by");
							foreach($sort_param_array as $key => $value) {
								if ($key == $_GET['sort']) {
									$sortBy = $value;
								}
							}
						}
						// retrieve all notes and all notes couunt to this client
						$all_notes_to_this_client_in_edit = $pfac_addbook_model->retrieve_all_notes_owned_by_this_client_only_for_the_edit_view($notes_array, $cur_page, $sortBy, ((isset($_GET['by'])) ? $_GET['by'] : ""), trim($_GET['addbook_id']));
						$all_notes_count_to_this_client_in_edit = $pfac_addbook_model->retrieve_all_notes_count_owned_by_this_client_only_for_the_edit_view(trim($_GET['addbook_id']), $notes_array);
						$pagination = $pagination_obj->generate_pagination($all_notes_count_to_this_client_in_edit, $cur_path, $cur_page, NO_OF_RECORDS_PER_PAGE);				
						$tot_page_count = ceil($all_notes_count_to_this_client_in_edit/NO_OF_RECORDS_PER_PAGE);				
						// Delete the selected note	
						if ((isset($_GET['opt'])) && ($_GET['opt'] == "drop")){
							$pfac_addbook_model->delete_selected_note(trim($_GET['note_id']), $pfa_addbook_id);
							// Log keeping
							$log_params = array(
												"user_id" => $_SESSION['logged_user']['id'], 
												"action_desc" => "Deleted the selected note of PFA Address book id {$pfa_addbook_id}",
												"date_crated" => date("Y-m-d-H:i:s")
												);
							$pfac_addbook_model->keep_track_of_activity_log_in_pfa_addbook($log_params);
							$_SESSION['deleted_selected_note'] = true;
							AppController::redirect_to($site_config['base_url']."pfa-addbook/edit/?mode=notes&addbook_id=".$pfa_addbook_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1"));							
						}
						// Show full details of the above client selected note
						if ((isset($_GET['opt'])) && (($_GET['opt'] == "view") || ($_GET['opt'] == "edit"))){						
							// Check the note id exist in the db
							if ($pfac_addbook_model->check_note_id_exist(trim($_GET['note_id']))){						
								if ($pfac_addbook_model->check_note_id_owned_by_the_correct_client(trim($_GET['addbook_id']), trim($_GET['note_id']))){
									$notes_array = array('note_id', 'note_owner_id', 'note', 'date_added', 'added_by', 'date_modified', 'modified_by');					
									$note_full_details = $pfac_addbook_model->retrieve_full_details_of_selected_note(trim($_GET['note_id']), $notes_array);				
								}else{
									AppController::redirect_to($site_config['base_url'] ."pfa-addbook/view/");	
								}	
							}else{
								AppController::redirect_to($site_config['base_url'] ."pfa-addbook/view/");																						
							}	
						}	
					break;										
				}
				// Check whether the address book id is exist in the database		
				if ($pfac_addbook_model->check_addressbook_id_exist(trim($_GET['addbook_id'])) != ""){
					$full_details = $pfac_addbook_model->retrieve_full_details_per_each_addbook_contact(trim($_GET['addbook_id']));	
					$addbook_id = $full_details[0]['id'];
					// Start to validate and other main functions				
					if ("POST" == $_SERVER['REQUEST_METHOD']){
						$errors = AppModel::validate($_POST['pfac_addbook_reqired']);				
						$_SESSION['pfac_addbook_reqired'] = $_POST['pfac_addbook_reqired'];
						$_SESSION['pfac_addbook_not_reqired'] = $_POST['pfac_addbook_not_reqired'];					
						if (!empty($_POST['pfac_addbook_not_reqired']['email'])){
							$email_validity = CommonFunctions::check_email_address($_POST['pfac_addbook_not_reqired']['email']);
						}	
						// If address book save form has been submitted
						if (isset($_POST['pfac_addbook_submit'])){	
						// If not having errors proceed with the databsse saving					
							if ($errors){
								$_SESSION['pfaaddbook_reqired_errors'] = $errors;					
								// Display the error message						
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
							}elseif (!$email_validity){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid Email.</div>";																																
							}else{
								$pfac_addbook_model->update_addbook_details(array_merge($_SESSION['pfac_addbook_reqired'], $_SESSION['pfac_addbook_not_reqired']), $addbook_id);
								// Log keeping
								$log_params = array(
													"user_id" => $_SESSION['logged_user']['id'], 
													"action_desc" => "Updated the Address book contact id {$addbook_id}",
													"date_crated" => date("Y-m-d-H:i:s")
													);
								$pfac_addbook_model->keep_track_of_activity_log_in_pfa_addbook($log_params);
								// Unset all used variables	
								unset($_SESSION['pfaaddbook_reqired_errors']);						
								unset($_SESSION['pfac_addbook_reqired']);
								unset($_SESSION['pfac_addbook_not_reqired']);
								unset($full_details);
								unset($pfac_addbook_model);	
								$_SESSION['contact_details_updated'] = true;
								AppController::redirect_to($site_config['base_url']."pfa-addbook/edit/?mode=main&addbook_id=".$addbook_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1"));							
							}
						}
						// If notes form has been submitted
						if (isset($_POST['pfa_addbook_notes_submit'])){
							// If no value has been submitted regarding the notes section
							if (empty($_POST['pfa_addbook_note_required']['note_text'])){
								$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please fill the note text box.</div>";		
							// If values has been submitted	
							}else{
								$_SESSION['pfa_addbook_note_required']['note_text'] = $_POST['pfa_addbook_note_required']['note_text'];							
								$notes_inputting_array = array(
																"note_owner_id" => $addbook_id,
																"note_owner_type" => "PFA_ADDBOOK",
																"note_text" => $_SESSION['pfa_addbook_note_required']['note_text'],
																"date_added" => date("Y-m-d-H:i:s"),
																"added_by" => $_SESSION['logged_user']['id']
															  );
								$pfac_addbook_model->insert_new_note($notes_inputting_array);
								$_SESSION['new_note_has_created'] = "true";		
								// Log keeping
								$log_params = array(
													"user_id" => $_SESSION['logged_user']['id'], 
													"action_desc" => "Created a new note to PFA_Address book id {$addbook_id}",
													"date_crated" => date("Y-m-d-H:i:s")
													);
								$pfac_addbook_model->keep_track_of_activity_log_in_pfa_addbook($log_params);
								$notes_array = array('note_id', 'note_owner_id', 'note', 'date_added', 'added_by', 'date_modified', 'modified_by');					
								$all_notes_to_this_client = $pfac_addbook_model->retrieve_all_notes_owned_by_this_client($addbook_id, $notes_array);																																																	
								unset($_POST);									
								unset($_SESSION['pfa_addbook_note_required']['note_text']);
								AppController::redirect_to($site_config['base_url']."pfa-addbook/edit/?mode=notes&addbook_id=".$addbook_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1"));							
							}
							$notes_array = array('note_id', 'note_owner_id', 'note', 'date_modified', 'modified_by');					
							$all_notes_to_this_client = $pfac_addbook_model->retrieve_all_notes_owned_by_this_client($addbook_id, $notes_array);
						}
						// If notes form has been submitted in edit note section
						if (isset($_POST['pfac_notes_update_submit'])){
							// Check the note id exist in the db
							if ($pfac_addbook_model->check_note_id_exist(trim($_GET['note_id'])) != ""){
								// Check the note is owned by him self
								if ($pfac_addbook_model->check_note_id_owned_by_the_correct_client(trim($_GET['addbook_id']), trim($_GET['note_id'])) != ""){								
									// If no value has been submitted regarding the notes section
									if (empty($_POST['pfac_note_required']['note_text'])){
										$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please fill the note text box.</div>";		
									// If both values has been submitted	
									}else{
										$_SESSION['pfac_note_required']['note_text'] = $_POST['pfac_note_required']['note_text'];							
										$notes_inputting_array = array(
															"note_owner_id" => $pfa_addbook_id,													
															"note_text" => $_SESSION['pfac_note_required']['note_text'],
															"date_modified" => date("Y-m-d-H:i:s"),
															"modified_by" => $_SESSION['logged_user']['id']
															);
										$pfac_addbook_model->update_the_exsiting_note($notes_inputting_array, trim($_GET['note_id']));
										// Log keeping
										$log_params = array(
															"user_id" => $_SESSION['logged_user']['id'], 
															"action_desc" => "Update one of existing notes of Address book id {$pfa_addbook_id}",
															"date_crated" => date("Y-m-d-H:i:s")
															);
										$pfac_addbook_model->keep_track_of_activity_log_in_pfa_addbook($log_params);
										$notes_array = array('note_id', 'note_owner_id', 'note', 'date_added', 'added_by', 'date_modified', 'modified_by');					
										$note_full_details = $pfac_addbook_model->retrieve_full_details_of_selected_note(trim($_GET['note_id']), $note_param);				
										unset($_POST);
										unset($_SESSION['pfac_note_required']['note_text']);
										$_SESSION['notes_section_got_updated'] = "true";
										AppController::redirect_to($site_config['base_url']."pfa-addbook/edit/?mode=notes&addbook_id=".$pfa_addbook_id.((isset($_GET['page'])) ? "&page=".$_GET['page'] : "").((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1"));												
									}
								// If note id is not owned by him self																				
								}else{
									unset($_SESSION['pfac_note_required']['note_text']);
									AppController::redirect_to($site_config['base_url'] ."pfa-addbook/view/");	
								}
							// If wrong note id										
							}else{
								unset($_SESSION['pfac_note_required']['note_text']);
								AppController::redirect_to($site_config['base_url'] ."pfa-addbook/view/");	
							}	
						}
					}else{
						unset($_SESSION['pfaaddbook_reqired_errors']);						
						unset($_SESSION['pfac_addbook_reqired']);
						unset($_SESSION['pfac_addbook_not_reqired']);
						unset($full_details);
						unset($pfac_addbook_model);	
					}
				// If wrong id	
				}else{
					AppController::redirect_to($site_config['base_url'] ."pfa-addbook/view/");
				}
			break;
			
			case "drop":
				// All global variables					
				global $site_config;
				global $headerDivMsg;			
				// objects instantiation
				$pfac_addbook_model = new pfac_addbook(); 
				// Check whether the address book id is exist in the database		
				if ($pfac_addbook_model->check_addressbook_id_exist(trim($_GET['addbook_id']))){										
					$pfac_addbook_model->delete_record_in_addbook(trim($_GET['addbook_id']));					
					$pfac_addbook_model->delete_owned_notes(trim($_GET['addbook_id']));
					// Log keeping
					$log_params = array(
										"user_id" => $_SESSION['logged_user']['id'], 
										"action_desc" => "Deleted the Address book contact id {$_GET['addbook_id']}",
										"date_crated" => date("Y-m-d-H:i:s")
										);
					$pfac_addbook_model->keep_track_of_activity_log_in_pfa_addbook($log_params);
					$_SESSION['deleted_selected_contact'] = "true";
					unset($pfac_addbook_model);
					AppController::redirect_to($site_config['base_url'] ."pfa-addbook/view/");							
				// If wrong id	
				}else{
					AppController::redirect_to($site_config['base_url'] ."pfa-addbook/view/");																
				}	
			break;
			
			case "show":
				// All global variables		
				global $fullDetails;
				global $historyDetails;
				global $breadcrumb;
				global $site_config;
				global $action_panel_menu;
				global $addbook_id;				
				$breadcrumb = "";
				// objects instantiation
				$pfac_addbook_model = new pfac_addbook(); 
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']
								."\" class=\"headerLink\">Home</a> &rsaquo; "."<a class=\"headerLink\" href=\"".$site_config['base_url']."pfa-addbook/view/?page=1\">All Address book Contacts</a> &rsaquo; Edit the contact</div>";
				// Check whether the address book id is exist in the database		
				if ($pfac_addbook_model->check_addressbook_id_exist(trim($_GET['addbook_id'])) != ""){					
					// Configure the action panel with against user permissions 
					$action_panel_menu = $pfac_addbook_model->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, $view);
					// Retrieve full details
					$fullDetails = $pfac_addbook_model->grab_full_details_for_the_single_view_in_addressbook(trim($_GET['addbook_id']));		
					$addbook_id = $fullDetails[0]['id'];
					// Log keeping
					$log_params = array(
										"user_id" => $_SESSION['logged_user']['id'], 
										"action_desc" => "Viewed details of Address book contact id {$_GET['addbook_id']}",
										"date_crated" => date("Y-m-d-H:i:s")
										);
					$pfac_addbook_model->keep_track_of_activity_log_in_pfa_addbook($log_params);
					unset($pfac_addbook_model);
					unset($fullDetails);
				// If wrong id	
				}else{
					AppController::redirect_to($site_config['base_url'] ."pfa-addbook/view/?page=1");							
				}	
			break;						
		}	
	}
}

?>