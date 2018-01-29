<?php
	class System{
		
		/* This function will check the username exist in the database */
		function check_username_exist($username){
		
			global $connection;
			$db = AppModel::grab_db_function_class();		
			return ($db->return_num_of_rows_in_result($db->execute_query("SELECT username FROM pfagos__user WHERE username = '".CommonFunctions::mysql_preperation($username)."'")) != "") ? true : false;
			unset($db);						
		}
		/* End of the function */
		
		/* This fucntion will check the password correct for the given username */
		function check_password_correct($user_login_params){

			global $connection;
			$db = AppModel::grab_db_function_class();	
			$password_in_db = $db->return_single_result_from_mysql_resource($db->execute_query("SELECT password FROM pfagos__user WHERE username = '".CommonFunctions::mysql_preperation(trim($user_login_params['username']))."'"), 0);																
			return ($password_in_db == md5(trim($user_login_params['password']))) ? true : false;
			unset($db);						
		}
		/* End fof the fucntion */
		
		/* This fucntion will grab the full details for the logged in user */
		function grab_full_details_for_the_loggedin_user($username){
		
			global $connection;
			$db = AppModel::grab_db_function_class();	
			$sql = "SELECT pfagos__user.id, pfagos__user.username, pfagos__user.first_name, pfagos__user.last_name, pfagos__user.email, pfagos__user.last_login
					FROM pfagos__user
					WHERE pfagos__user.username = '{$username}'";	
			$params = array('id', 'username', 'first_name', 'last_name', 'email', 'last_login');		
			return $db->result_to_array_for_few_fields($db->execute_query($sql), $params);							
			unset($db);				
		}
		/* End of the fucntion */
		
		/* This function will update the user table last login field with current logged time */
		function update_last_login($user_id){
		
			global $connection;
			$db = AppModel::grab_db_function_class();	
			$sql = "UPDATE pfagos__user 
								SET 
									last_login  = '".date("Y-m-d-H:i:s")."' 
								WHERE id = ".$user_id;		
			$db->execute_query($sql);							
			unset($db);				
		} 
		/* End of the fucntion */
		
		/* This function will insert log details every time against the user action */
		function keep_track_of_activity_log_in_system($logParmas){
		
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
		
		/* This function will retrieve all log data from the db and display */
		function retrieve_all_logs($params, $curr_page_no = NULL, $sortBy = "", $sortMethod = ""){

			global $connection;
			$db = AppModel::grab_db_function_class();					
			$sort = "";
			$limit = "";		
		
			$display_items = 100;					
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
				$sort = " ORDER BY pfagos__log.id DESC";				
			}
			$limit = " Limit {$start_no_sql}, {$end_no_sql}";				
			$sql = "SELECT pfagos__log.id, pfagos__user.username, pfagos__log.action_type_desc, pfagos__log.date_time 
					FROM pfagos__log
					LEFT JOIN pfagos__user ON pfagos__user.id = pfagos__log.user_id {$sort}{$limit}";	
			return $db->result_to_array_for_few_fields($db->execute_query($sql), $params);							
			unset($db);				
		}
		/* End of the function */
		
		/* This function will retrieve the count for all pfagos users in to display */
		function retrieve_all_logs_count(){
		
			global $connection;
			$db = AppModel::grab_db_function_class();			
			$sql = "SELECT pfagos__log.id, pfagos__user.username, pfagos__log.action_type_desc, pfagos__log.date_time 
					FROM pfagos__log
					LEFT JOIN pfagos__user ON pfagos__user.id = pfagos__log.user_id";	
			return $db->return_num_of_rows_in_result($db->execute_query($sql));				
			unset($db);		
		}
		/* End of the fucntion */				
	}
?>