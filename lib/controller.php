<?php

class AppController{

	/** Redirect  to the address
	 *  @param String address
	 *  returun redirect
	*/
	static function redirect_to($address){
		
		header('Location:'.$address);
	}

	/** Redirect  to the address after given
	 *  @param String address
	 *  returun redirect
	*/
	static function wait_then_redirect_to($time, $address){
		
		header("Refresh: {$time}; {$address}");
	}
	
	/** Check for user session availability : if not found redirect to new
	 *  return bool or redirect
	 */
	 static function check_authentication(){

	 	if (isset($_SESSION['logged_user']['id'])){			
			if (AppController::is_session_uid_same_with_db_id($_SESSION['logged_user']['id'])){
				return true;
			}else{
				return false;				
			}
		}else{
			return false;
		}
	 }
	
	/** This function will process the correct model */	 
 	function process_the_correct_model(){}	
	
	/* This function will check for the url with query string which is provided by the user is valid */
	static function url_gate_keeper($qStrings, $controller){

		switch($controller){
			case "pfac":
				$allowed_qString_keys = array("p", "pfac_id", "page", "fname", "sname", "drop_id", "sort", "by", "notes_page", "note_id", "opt", "mode", "history_id", "filename", "where");			
				$location = "http://".$_SERVER['HTTP_HOST']."/pfac/view/";
				$allowed_qString_values = array(
												"by" => array("asc", "desc"),				
												"opt" => array("sorting", "edit", "view", "drop", "history_drop"), 
												"sort" => array(
																"f_name", "l_name", "playercat", "dob", "nationality", "club", "homeadd", "email", "weburl",
																"emgconame", "emgcono", "playerpage", "notecat", "desc", "mod_date", "mod_by", "add_date", "add_by", "cat", "con_start", "con_end"
																)
											   );
			break;
			
			case "cfcp":
				$allowed_qString_keys = array("p", "cfcp_id", "page", "fname", "sname", "history_drop", "drop_id", "sort", "by", "notes_page", "note_id", "opt", "mode", "history_id", "history_page", "filename", "where");			
				$location = "http://".$_SERVER['HTTP_HOST']."/cfcp/view/";
				$allowed_qString_values = array(
												"by" => array("asc", "desc"),				
												"opt" => array("sorting", "edit", "view", "drop", "history_drop"), 
												"sort" => array("f_name", "l_name", "playercat", "dob", "team", "school", "pos1", "pos2", "nick1", "nick2", "mob", "birth_place", "class",
																"notecat", "desc", "mod_date", "mod_by", "add_date", "add_by", "cat", "hm_address")
											   );
			break;
			
			case "pfagos":
				$allowed_qString_keys = array("pfagos_id", "page", "fname", "sname", "drop_id", "sort", "by", "opt", "action");			
				$location = "http://".$_SERVER['HTTP_HOST']."/pfagos/view/";
				$allowed_qString_values = array(
												"by" => array("asc", "desc"),
												"sort" => array("f_name", "l_name", "u_name", "created_at", "last_login", "email", "uname", "last_log"),
												"action" => array("reset")
											   );
			break;

			case "pfa-addbook":
				$allowed_qString_keys = array("p", "addbook_id", "page", "fname", "sname", "drop_id", "sort", "by", "mode", "notes", "note_id", "notes_page", "opt", "page");			
				$location = "http://".$_SERVER['HTTP_HOST']."/pfa-addbook/view/";
				$allowed_qString_values = array(
												"by" => array("asc", "desc"),
												"opt" => array("drop", "edit", "view", "sorting"),
												"sort" => array(
																"f_name", "l_name", "addbook_cat", "agent_type", "eng", "add", "pref", 
																"org", "nation", "loc", "desc", "mod_date", "mod_by", "add_date", "add_by"
																)
											   );
			break;	
			
			case "system":
				$allowed_qString_keys = array("page", "sort", "by", "fname", "sname");			
				$location = "http://".$_SERVER['HTTP_HOST']."/system/activity-log/";
				$allowed_qString_values = array(
												"by" => array("asc", "desc"),
												"sort" => array("u_name", "act_desc", "time", "past")
											   );
			break;					
		}
		foreach($qStrings as $key => $value){
			if (!in_array($key, $allowed_qString_keys)){
				$invalidAccess = true;
				break;							
			}else{ 
				foreach($allowed_qString_values as $keyInternal => $valueInternal){
					if ($keyInternal == $key){
						if (!in_array($value, $valueInternal)){
							$invalidAccess = true;
							break;							
						} 
					}
				}
			}	
		}
		//if ($invalidAccess) 
			//AppController::redirect_to($location);
	}
	/* End of the fucntion */	
	
	/* This function will check the session user id still exist in the database */
	function is_session_uid_same_with_db_id($session_u_id){
		
		global $connection;
		$db = AppModel::grab_db_function_class();			
		return ($db->return_num_of_rows_in_result($db->execute_query("SELECT id FROM pfagos__user WHERE id = {$session_u_id}")) == 0) ? false : true;		
		unset($db);
	}
	/* End of the fucntion */	
}
?>