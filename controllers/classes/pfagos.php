<?php

class pfagosUsers extends AppController{

	/* This function will process the correct model for the given view */
	function process_the_correct_model($view, $controller){

		switch($view) {
		
			case "add":
				// All Global variables
				global $headerDivMsg;
				global $site_config;
				global $breadcrumb;
				global $user_groups;
				$email_validity = true;
				$breadcrumb = "";
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']."\" class=\"headerLink\">Home</a> &rsaquo; Add New PFAGOS User</div>";
				// Object Instantiation
				$pfagos_users_model = new pfagos_users();
				// Load all user group permissions
				$user_groups = $pfagos_users_model->retrieve_all_user_groups();				
				// Display the success message after updating user details				
				if ($_SESSION['user_addedd'] == "true"){
					$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">New user has been created successfully.</div>";																																								
				}
				unset($_SESSION['user_addedd']);
				// If post has been submitted
				if ("POST" == $_SERVER['REQUEST_METHOD']){
					$errors = AppModel::validate($_POST['pfagos_reqired']);
					if (!empty($_POST['pfagos_not_reqired']['email'])){
						$email_validity = CommonFunctions::check_email_address($_POST['pfagos_not_reqired']['email']);
					}	
					$_SESSION['pfagos_reqired'] = $_POST['pfagos_reqired'];
					$_SESSION['pfagos_not_reqired'] = $_POST['pfagos_not_reqired'];
					$_SESSION['pfagos_user_group_reqired'] = $_POST['pfagos_user_group_reqired'];
					if (isset($_SESSION['pfagos_user_group_reqired'])){
						foreach($_SESSION['pfagos_user_group_reqired'] as $key => $value){							
							$_SESSION['user_groups'][] = $key;
						}
					}	
					// If errors free in the form
					if ($errors){
						$_SESSION['pfagos_reqired_errors'] = $errors;					
						// Display the error message						
						$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Required fields cannot be blank !.</div>";											
					}elseif(empty($_POST['pfagos_user_group_reqired'])){
						unset($_SESSION['pfagos_reqired_errors']);
						// Display the error message						
						$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select the \"User Group\".</div>";											
					}else{
						$fields_with_length = array($_POST['pfagos_reqired']['password'] => 6);
						$errors = AppModel::check_max_field_length($fields_with_length, "password");
						if ($errors){
							// Display the error message
							$_SESSION['pfagos_reqired_errors']['password'] = "password";						
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Password too short.</div>";																		
						// Check the username exist or not
						}elseif (!$email_validity){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid Email.</div>";																																
						}elseif ($pfagos_users_model->check_username_exist_in_db(trim($_SESSION['pfagos_reqired']['username']))){
							if (isset($_SESSION['pfagos_reqired_errors']['password'])) unset($_SESSION['pfagos_reqired_errors']['password']);						
							if (isset($_SESSION['pfagos_reqired_errors']['confirm_password'])) unset($_SESSION['pfagos_reqired_errors']['confirm_password']);													
							// Display the error message
							$_SESSION['pfagos_reqired_errors']['username'] = "username";						
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Username already exists.</div>";																		
						// Check the password and the confirm password are same							
						}elseif (($_POST['pfagos_reqired']['password'] != $_POST['pfagos_reqired']['confirm_password'])){							
							if (isset($_SESSION['pfagos_reqired_errors']['username'])) unset($_SESSION['pfagos_reqired_errors']['username']);
							// Display the error message
							$_SESSION['pfagos_reqired_errors']['password'] = "password";						
							$_SESSION['pfagos_reqired_errors']['password'] = "confirm_password";													
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Password and Password Confirmation are not same !</div>";																		
						// If no errors found							
						}else{							
							// Add the user to the users table						
							$pfagosNewUserDetails = array(
														"first_name" => $_SESSION['pfagos_reqired']['first_name'], "last_name" => $_SESSION['pfagos_reqired']['last_name'],
														"email"	=> $_SESSION['pfagos_not_reqired']['email'], 
														"username" => trim($_SESSION['pfagos_reqired']['username']), "password" => md5(trim($_SESSION['pfagos_reqired']['password'])),
														"created_at" => date('Y-m-d'), "last_login" => ""														
														 );	
							$newly_inserted_pfagos_user_id = $pfagos_users_model->insert_new_pfagos_user($pfagosNewUserDetails);							 						
							// Add user grups to the pagos_user_grups table regarding the newly added pfagos user
							foreach($_POST['pfagos_user_group_reqired'] as $key => $value){
								$u_groups[]['group_id'] = $value;
							}
							$pfagos_users_model->insert_user_groups_to_newly_added_user($newly_inserted_pfagos_user_id, $u_groups);							 						
							// Log keeping
							$log_params = array(
												"user_id" => $_SESSION['logged_user']['id'], 
												"action_desc" => "Added new system user",
												"date_crated" => date("Y-m-d-H:i:s")
												);
							$pfagos_users_model->keep_track_of_activity_log_in_pfagos($log_params);
							$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">PFAGOS User was addedd successfully.</div>";																																			
							// Unset all used data
							unset($_SESSION['pfagos_reqired_errors']);						
							unset($_SESSION['pfagos_reqired']);
							unset($_SESSION['pfagos_not_reqired']);
							unset($_SESSION['pfagos_user_group_reqired']);
							unset($_SESSION['user_groups']);
							unset($pfagos_users_model);
							$_SESSION['user_addedd'] = "true";
							AppController::redirect_to($site_config['base_url']."pfagos/add/");																	
						}
					}
				}else{
					unset($_SESSION['pfagos_reqired_errors']);						
					unset($_SESSION['pfagos_reqired']);
					unset($_SESSION['pfagos_not_reqired']);
					unset($pfagos_users_model);
				}
			break;
			
			case "view":
				// Unset all used variables	
				unset($_SESSION['pfagos_reqired']);						
				unset($_SESSION['pfagos_not_reqired']);
				unset($_SESSION['pfagos_reqired_errors']);
				// All Global variables
				global $site_config;
				global $all_pfagos_users;
				global $all_pfagos_users_count;
				global $pagination;
				global $tot_page_count;
				global $cur_page;
				global $img;
				global $breadcrumb;
				global $invalidPage;
				global $headerDivMsg;
				global $action_panel_menu;				
				$sortBy = "";
				$breadcrumb = "";
				$action_panel_menu = array();
				// Object Instantiation
				$pfagos_users_model = new pfagos_users();
				$pagination_obj = new Pagination();				
				// Display the success message after updating user details
				if ($_SESSION['user_details_updated'] == "true"){
					$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">User details was updated successfully.</div>";																																			
				}
				unset($_SESSION['user_details_updated']);
				// Display success message on user deletion
				if ($_SESSION['user_deleted']){
					$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Successfully Deleted the PFAGOS user.</div>";					
				}
				unset($_SESSION['user_deleted']);
				// Display success message on user deletion
				if ($_SESSION['is_not_exist_user_id']){
					$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Requested user id not exist !.</div>";					
				}
				unset($_SESSION['is_not_exist_user_id']);
				// Display success message on user deletion
				if ($_SESSION['is_assinged_currently_logged_user']){
					$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Cannot delete currently logged user !.</div>";					
				}
				unset($_SESSION['is_assinged_currently_logged_user']);
				// Display success message on user password resetting
				if ($_SESSION['password_reseted'] == "true"){
					$headerDivMsg = "<div class=\"headerMessageDivInNotice defaultFont\">Password reset success.</div>";					
				}
				unset($_SESSION['password_reseted']);
				// Configure the action panel with against user permissions 
				$action_panel_menu = $pfagos_users_model->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, "");
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']."\" class=\"headerLink\">Home</a> &rsaquo; View All PFAGOS Users</div>";
				// Viewing all contacts in the table
				$cur_page = ((isset($_GET['page'])) && ($_GET['page'] != "") && ($_GET['page'] != 0)) ? $_GET['page'] : 1; 												
				$param_array = array('id', 'username', 'first_name', 'last_name', 'email', 'created_at', 'last_login');
				// Display all pfac_records				
				if (isset($_GET['sort'])){	
				
					$imgDefault = "<a href=\"".$site_config['base_url']."pfagos/view/?sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
					$imgAsc = "<a href=\"".$site_config['base_url']."pfagos/view/?sort=".$_GET['sort']."&by=asc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_asc.png\" border=\"0\" /></a>";			
					$imgDesc = "<a href=\"".$site_config['base_url']."pfagos/view/?sort=".$_GET['sort']."&by=desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><img src=\"../../public/images/s_desc.png\" border=\"0\" /></a>";								
					$img = (!isset($_GET['by'])) ? ($imgDefault) : (($_GET['by'] == "asc") ? $imgDesc : $imgAsc);

					$sort_param_array = array(
											  "u_name" => "username", "f_name" => "first_name", "l_name" => "last_name", "email" => "email", 
											  "created_at" => "created_at", "last_login" => "last_login"
											 );
					foreach($sort_param_array as $key => $value) {
						if ($key == $_GET['sort']) {
							$sortBy = $value;
						}
					}
				}
				$all_pfagos_users = $pfagos_users_model->display_all_pfagos_users($param_array, $cur_page, $sortBy, (isset($_GET['by'])) ? $_GET['by'] : "");
				$all_pfagos_users_count = $pfagos_users_model->display_count_on_all_pfagos();
				// Pagination load
				$pagination = $pagination_obj->generate_pagination($all_pfagos_users_count, $_SERVER['REQUEST_URI'], NO_OF_RECORDS_PER_PAGE);				
				$tot_page_count = ceil($all_pfagos_users_count/NO_OF_RECORDS_PER_PAGE);				
				// If no records found or no pages found
				$page = (isset($_GET['page'])) ? $_GET['page'] : 1;				
				if (($page > $tot_page_count) || ($page == 0)){
					$invalidPage = true;	
				}
				// Unset all used variables
				unset($pfagos_users_model);
				unset($pagination_obj);
			break;			
		
			case "edit":
				// All Global variables
				global $full_details;
				global $headerDivMsg;
				global $site_config;
				global $breadcrumb;
				global $user_groups;
				global $owned_group_ids;
				global $action_panel_menu;
				global $pfagos_id;
				$email_validity = true;				
				$breadcrumb = "";
				$mode = "";
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']
								."\" class=\"headerLink\">Home</a> &rsaquo; "."<a class=\"headerLink\" href=\"".$site_config['base_url']."pfagos/view/\">View All PFAGOS Users</a> &rsaquo; Edit PFAGOS User</div>";
				// Object Instantiation
				$pfagos_users_model = new pfagos_users();
				// Load all user groups
				$user_groups = $pfagos_users_model->retrieve_all_user_groups();				
				$owned_group_ids = $pfagos_users_model->grab_owned_user_gruops(trim($_GET['pfagos_id']));
				// Genrate random password
				if (!isset($_SESSION['rand_pass'])) $_SESSION['rand_pass'] = CommonFunctions::createRandomPassword();
				// Check whether the address book id is exist in the database						
				if ($pfagos_users_model->check_pfagos_id_exist(trim($_GET['pfagos_id']))){															
					// Load the pfagos user details for the given 
					$full_details = $pfagos_users_model->retrieve_full_details_per_each_pfagos_user(trim($_GET['pfagos_id']));
					$pfagos_id = $full_details[0]['id'];
					// Configure the action panel with against user permissions 
					$action_panel_menu = $pfagos_users_model->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, "edit", "", $pfagos_id);
					// Start to validate and other main functions				
					if ("POST" == $_SERVER['REQUEST_METHOD']){
						$errors = AppModel::validate($_POST['pfagos_reqired']);				
						if (!empty($_POST['pfagos_not_reqired']['email'])){
							$email_validity = CommonFunctions::check_email_address($_POST['pfagos_not_reqired']['email']);
						}	
						$_SESSION['pfagos_reqired'] = $_POST['pfagos_reqired'];
						$_SESSION['pfagos_not_reqired'] = $_POST['pfagos_not_reqired'];						
						$_SESSION['pfagos_user_group_reqired'] = $_POST['pfagos_user_group_reqired'];
						// If not having errors proceed with the databsse saving					
						if ($errors){
							$_SESSION['pfagos_reqired_errors'] = $errors;					
							// Display the error message						
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please correct the following indicated errors.</div>";											
						}elseif(empty($_POST['pfagos_user_group_reqired'])){
							unset($_SESSION['pfagos_reqired_errors']);
							// Display the error message						
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please select the \"User Group\".</div>";											
						}elseif (!$email_validity){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid Email.</div>";																																
						}else{
							if (
							   ($_POST['pfagos_not_reqired_spec']['new_password'] != "") ||
							   ($_POST['pfagos_not_reqired_spec']['password'] != "") ||
							   ($_POST['pfagos_not_reqired_spec']['confirm_password'] != "")
							   ){	
							   		// If the new password is being provided : then should be validated
									$errors = AppModel::validate($_POST['pfagos_not_reqired_spec']);
									$_SESSION['pfagos_not_reqired_spec'] = $_POST['pfagos_not_reqired_spec'];
									if ($errors){
										// Display the error message
										$_SESSION['pfagos_reqired_errors'] = $errors;						
										$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Current passoword, confirmation of password and new passowrds required.</div>";																								
										$need_to_be_submit = "false";
									// If passwords are too short	
									}else{
										$fields_with_length = array($_POST['pfagos_not_reqired_spec']['new_password'] => 6);
										$errors = AppModel::check_max_field_length($fields_with_length, "new_password");
										if ($errors){
											// Display the error message										
											$_SESSION['pfagos_reqired_errors']['password'] = "new_password";						
											$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Password too short.</div>";																		
											$need_to_be_submit = "false";										
										}elseif (!$pfagos_users_model->check_previous_password_correct(trim($full_details[0]['username']), trim(md5($_SESSION['pfagos_not_reqired_spec']['password'])))){
										// Check the previous password is correct																
											if (isset($_SESSION['pfagos_reqired_errors']['new_password'])) unset($_SESSION['pfagos_reqired_errors']['new_password']);								
											if (isset($_SESSION['pfagos_reqired_errors']['confirm_password'])) unset($_SESSION['pfagos_reqired_errors']['confirm_password']);															
											// Display the error message
											$_SESSION['pfagos_reqired_errors']['password'] = "password";						
											$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Current Password is not correct !</div>";																								
											$need_to_be_submit = "false";																				
										// Check the password and the confirm password are same														
										}elseif ((trim($_POST['pfagos_not_reqired_spec']['new_password']) != trim($_POST['pfagos_not_reqired_spec']['confirm_password']))){	
											if (isset($_SESSION['pfagos_reqired_errors']['password'])) unset($_SESSION['pfagos_reqired_errors']['password']);								
											// Display the error message
											$_SESSION['pfagos_reqired_errors']['new_password'] = "new_password";						
											$_SESSION['pfagos_reqired_errors']['confirm_password'] = "confirm_password";													
											$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Password and Password Confirmation are not same !</div>";																		
											$need_to_be_submit = "false";																				
										}else{
											$need_to_be_submit = "true";
										}
									}	
								}else{
									$need_to_be_submit = "true";
								}
								if ($need_to_be_submit == "true"){									
									// Then update the users table
									$user_details_params = array(
																"first_name" => $_SESSION['pfagos_reqired']['first_name'], "last_name" => $_SESSION['pfagos_reqired']['last_name'],														
																"password" => ($_POST['pfagos_not_reqired_spec']['new_password'] != "") ? trim(md5($_SESSION['pfagos_not_reqired_spec']['new_password'])) : "", 
																"email" => $_SESSION['pfagos_not_reqired']['email']
																);
									// First clear the user previous user group details
									$pfagos_users_model->clear_user_previous_group_details($full_details[0]['id']);
									// Update the new user group details															
									foreach($_POST['pfagos_user_group_reqired'] as $key => $value){
										$u_groups[]['group_id'] = $value;
									}
									$pfagos_users_model->insert_user_groups_to_newly_added_user($full_details[0]['id'], $u_groups);
									// Update user other details								
									$pfagos_users_model->update_user_details($full_details[0]['id'], $user_details_params);
									// Log keeping
									$log_params = array(
														"user_id" => $_SESSION['logged_user']['id'], 
														"action_desc" => "Updated system user details of user id {$full_details[0]['id']}",
														"date_crated" => date("Y-m-d-H:i:s")
														);
									$pfagos_users_model->keep_track_of_activity_log_in_pfagos($log_params);
									// Unset all used variables	
									unset($_SESSION['pfagos_reqired']);						
									unset($_SESSION['pfagos_not_reqired']);
									unset($_SESSION['pfagos_reqired_errors']);
									unset($_SESSION['pfagos_not_reqired_spec']);
									unset($full_details);
									unset($pfagos_users_model);	
									$_SESSION['user_details_updated'] = "true";
									AppController::redirect_to($site_config['base_url']."pfagos/view/".((isset($_GET['page'])) ? "?page=".$_GET['page'] : ""));									
								}	
							}									
						}else{
							unset($_SESSION['pfagos_reqired']);						
							unset($_SESSION['pfagos_not_reqired']);
							unset($_SESSION['pfagos_reqired_errors']);
							unset($_SESSION['pfagos_not_reqired_spec']);
							// If the user wants to reset the password
							if (isset($_GET['action']) && ($_GET['action'] == "reset")){
								$pfagos_users_model->reset_password(trim($_GET['pfagos_id']), $_SESSION['rand_pass']);
								$_SESSION['password_reseted'] = "true";
								AppController::redirect_to($site_config['base_url']."pfagos/view/".((isset($_GET['page'])) ? "?page=".$_GET['page'] : ""));
							}
						}
				// If wrong id	
				}else{
					AppController::redirect_to($site_config['base_url'] ."pfagos/view/");																
				}	
			break;
			
			case "drop":
				// All global variables		
				global $site_config;				
				// objects instantiation
				$pfagos_users_model = new pfagos_users();
				// Check whether the address book id is exist in the database						
				if (!$pfagos_users_model->check_pfagos_id_exist(trim($_GET['pfagos_id']))){															
					$_SESSION['is_not_exist_user_id'] = true;				
				// Check whether the user id is equal to logged user
				}elseif (trim($_GET['pfagos_id']) == $_SESSION['logged_user']['id']){
					$_SESSION['is_assinged_currently_logged_user'] = true;				
				}else{	
					// First clear the user previous user group details
					$pfagos_users_model->clear_user_previous_group_details(trim($_GET['pfagos_id']));
					// Actually deleting the PFAGOS user from the users table
					$pfagos_users_model->delete_user_details_from_the_table(trim($_GET['pfagos_id']));
					// Log keeping
					$log_params = array(
										"user_id" => $_SESSION['logged_user']['id'], 
										"action_desc" => "Deleted system user id {$_GET['pfagos_id']}",
										"date_crated" => date("Y-m-d-H:i:s")
										);
					$pfagos_users_model->keep_track_of_activity_log_in_pfagos($log_params);
					$_SESSION['user_deleted'] = true;
				}	
				AppController::redirect_to($site_config['base_url'] ."pfagos/view/");																															
				unset($pfagos_users_model);
			break;			
			
			case "show":
				// All global variables		
				global $fullDetails;
				global $historyDetails;
				global $breadcrumb;
				global $site_config;
				global $pfagos_id;
				global $action_panel_menu;				
				$breadcrumb = "";
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']
								."\" class=\"headerLink\">Home</a> &rsaquo; "."<a class=\"headerLink\" href=\"".$site_config['base_url']."pfagos/view/\">View All PFAGOS Users</a> &rsaquo; Details</div>";
				// objects instantiation
				$pfagos_users_model = new pfagos_users();
				// Check whether the address book id is exist in the database						
				if ($pfagos_users_model->check_pfagos_id_exist(trim($_GET['pfagos_id'])) != ""){										
					$fullDetails = $pfagos_users_model->grab_full_details_for_the_single_view_in_pfagos(trim($_GET['pfagos_id']));		
					$pfagos_id = $fullDetails[0]['id'];
					// Configure the action panel with against user permissions 
					$action_panel_menu = $pfagos_users_model->generate_action_panel_with_user_related_permissions($_SESSION['logged_user']['permissions'], $site_config, "show", "", $pfagos_id);
					// Log keeping
					$log_params = array(
										"user_id" => $_SESSION['logged_user']['id'], 
										"action_desc" => "Viewed details of system user id {$_GET['pfagos_id']}",
										"date_crated" => date("Y-m-d-H:i:s")
										);
					$pfagos_users_model->keep_track_of_activity_log_in_pfagos($log_params);
					unset($pfagos_users_model);
					unset($fullDetails);
				// If wrong id	
				}else{
					AppController::redirect_to($site_config['base_url'] ."pfagos/view/");																																
				}	
			break;
			
			case "acc-edit":
				// All Global variables
				global $full_details;
				global $headerDivMsg;
				global $site_config;
				global $breadcrumb;
				$email_validity = true;
				$breadcrumb = "";
				$mode = "";
				// Bredcrmb to the pfa section
				$breadcrumb .= "<div class=\"breadcrumbMessageDiv defaultFont boldText\"><a href=\"".$site_config['base_url']
								."\" class=\"headerLink\">Home</a> &rsaquo; "."<a class=\"headerLink\" href=\"".$site_config['base_url']."pfagos/view/\">View All PFAGOS Users</a> &rsaquo; Edit PFAGOS User</div>";
				// Object Instantiation
				$pfagos_users_model = new pfagos_users();
				// Genrate random password
				if (!isset($_SESSION['rand_pass'])) $_SESSION['rand_pass'] = CommonFunctions::createRandomPassword();
				// Check whether the address book id is exist in the database						
				if ($pfagos_users_model->check_pfagos_id_exist(trim($_GET['pfagos_id'])) != ""){															
					// Display the success message after updating user details
					if ($_SESSION['user_details_updated']){
						$headerDivMsg = "<div class=\"headerMessageDivInSuccess defaultFont\">User details was updated successfully.</div>";																																			
					}
					unset($_SESSION['user_details_updated']);
					// Load the pfagos user details for the given 
					$full_details = $pfagos_users_model->retrieve_full_details_per_each_pfagos_user($_GET['pfagos_id']);
					// Start to validate and other main functions				
					if ("POST" == $_SERVER['REQUEST_METHOD']){
						$errors = AppModel::validate($_POST['pfagos_reqired']);				
						if (!empty($_POST['pfagos_not_reqired']['email'])){
							$email_validity = CommonFunctions::check_email_address($_POST['pfagos_not_reqired']['email']);
						}	
						$_SESSION['pfagos_reqired'] = $_POST['pfagos_reqired'];
						$_SESSION['pfagos_not_reqired'] = $_POST['pfagos_not_reqired'];						
						$_SESSION['pfagos_user_group_reqired'] = $_POST['pfagos_user_group_reqired'];
						// If not having errors proceed with the databsse saving					
						if ($errors){
							$_SESSION['pfagos_reqired_errors'] = $errors;					
							// Display the error message						
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Please correct the following indicated errors.</div>";											
						}elseif (!$email_validity){
							$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Invalid Email.</div>";																																
						}else{
							if (
							   ($_POST['pfagos_not_reqired_spec']['new_password'] != "") ||
							   ($_POST['pfagos_not_reqired_spec']['password'] != "") ||
							   ($_POST['pfagos_not_reqired_spec']['confirm_password'] != "")
							   ){	
							   		// If the new password is being provided : then should be validated
									$errors = AppModel::validate($_POST['pfagos_not_reqired_spec']);
									$_SESSION['pfagos_not_reqired_spec'] = $_POST['pfagos_not_reqired_spec'];
									if ($errors){
										// Display the error message
										$_SESSION['pfagos_reqired_errors'] = $errors;						
										$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Current passowrd, confirmation of password and new passowrds required.</div>";																								
										$need_to_be_submit = "false";
									// If passwords are too short	
									}else{
										$fields_with_length = array($_POST['pfagos_not_reqired_spec']['new_password'] => 6);
										$errors = AppModel::check_max_field_length($fields_with_length, "new_password");
										if ($errors){
											// Display the error message										
											$_SESSION['pfagos_reqired_errors']['password'] = "new_password";						
											$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Password too short.</div>";																		
											$need_to_be_submit = "false";										
										}elseif (!$pfagos_users_model->check_previous_password_correct(trim($full_details[0]['username']), trim(md5($_SESSION['pfagos_not_reqired_spec']['password'])))){
										// Check the previous password is correct																
											if (isset($_SESSION['pfagos_reqired_errors']['new_password'])) unset($_SESSION['pfagos_reqired_errors']['new_password']);								
											if (isset($_SESSION['pfagos_reqired_errors']['confirm_password'])) unset($_SESSION['pfagos_reqired_errors']['confirm_password']);															
											// Display the error message
											$_SESSION['pfagos_reqired_errors']['password'] = "password";						
											$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Current Password is not correct !</div>";																								
											$need_to_be_submit = "false";																				
										// Check the password and the confirm password are same														
										}elseif ((trim($_POST['pfagos_not_reqired_spec']['new_password']) != trim($_POST['pfagos_not_reqired_spec']['confirm_password']))){	
											if (isset($_SESSION['pfagos_reqired_errors']['password'])) unset($_SESSION['pfagos_reqired_errors']['password']);								
											// Display the error message
											$_SESSION['pfagos_reqired_errors']['new_password'] = "new_password";						
											$_SESSION['pfagos_reqired_errors']['confirm_password'] = "confirm_password";													
											$headerDivMsg = "<div class=\"headerMessageDivInError defaultFont\">Password and Password Confirmation are not same !</div>";																		
											$need_to_be_submit = "false";																				
										}else{
											$need_to_be_submit = "true";
										}
									}										
								}else{
									$need_to_be_submit = "true";
								}
								if ($need_to_be_submit == "true"){	
									// Then update the users table
									$user_details_params = array(
																"first_name" => $_SESSION['pfagos_reqired']['first_name'], "last_name" => $_SESSION['pfagos_reqired']['last_name'],														
																"password" => ($_POST['pfagos_not_reqired_spec']['new_password'] != "") ? trim(md5($_SESSION['pfagos_not_reqired_spec']['new_password'])) : "", 
																"email" => $_SESSION['pfagos_not_reqired']['email']
																);
									// Update user other details								
									$pfagos_users_model->update_user_details($full_details[0]['id'], $user_details_params);
									// Log keeping
									$log_params = array(
														"user_id" => $_SESSION['logged_user']['id'], 
														"action_desc" => "Updated system user details of user id {$full_details[0]['id']}",
														"date_crated" => date("Y-m-d-H:i:s")
														);
									$pfagos_users_model->keep_track_of_activity_log_in_pfagos($log_params);
									// Unset all used variables	
									unset($_SESSION['pfagos_reqired']);						
									unset($_SESSION['pfagos_not_reqired']);
									unset($_SESSION['pfagos_reqired_errors']);
									unset($_SESSION['pfagos_not_reqired_spec']);
									unset($full_details);
									unset($pfagos_users_model);	
									$_SESSION['user_details_updated'] = true;
									AppController::redirect_to($site_config['base_url']."pfagos/acc-edit/?pfagos_id=".trim($_GET['pfagos_id']).((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));									
								}	
							}									
						}else{
							unset($_SESSION['pfagos_reqired']);						
							unset($_SESSION['pfagos_not_reqired']);
							unset($_SESSION['pfagos_reqired_errors']);
							unset($_SESSION['pfagos_not_reqired_spec']);
							// If the user wants to reset the password
							if (isset($_GET['action']) && ($_GET['action'] == "reset")){
								$pfagos_users_model->reset_password(trim($_GET['pfagos_id']), $_SESSION['rand_pass']);
								$_SESSION['password_reseted'] = "true";
								AppController::redirect_to($site_config['base_url']."pfagos/acc-edit/?pfagos_id=".trim($_GET['pfagos_id']).((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));
							}
						}
				// If wrong id	
				}else{
					AppController::redirect_to($site_config['base_url']."pfagos/acc-edit/?pfagos_id=".trim($_GET['pfagos_id']).((isset($_GET['page'])) ? "&page=".$_GET['page'] : ""));
				}	
			break;
		}	
	}
}
?>