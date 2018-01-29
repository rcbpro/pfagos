<?php

require './../../define.inc';
require './../../lib/database.php'; 

class Preview_model{

	/* This function will load data for the preview */
	function load_data_for_preview_in_cfcp($id){

		$settings = $this->grab_db_settings();
		$connection = DBFunctions::db_connect($settings->db_settings);
		$param_array1 = array('first_name', 'last_name', 'date_of_birth', 'place_of_birth', 'player_category_name', 'height', 'weight', 'position', 'comment', 
							 'photo_url', 'video_url', 'webpage_url', 'player_web_page');										
		$param_array2 = array('season', 'team', 'appearances', 'goals');												
		unset($settings);		
		return array_merge(
							$this->retrive_general_details_for_single_cfcp_in_preview($id, $param_array1),		
							array($this->retrive_history_details_for_single_cfcp_in_preview($id, $param_array2))
						  );		
	}
	/* End of the fucntion */
	
	/* This function will retirve db_settings */
	function grab_db_settings(){
	
		return new pfagos_settings();
	}
	/* End of the function */
	
	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_general_details_for_single_cfcp_in_preview($cfcp_id, $params){
	
		global $connection;
		$sql = "SELECT 
					 cfcp__personel_details.first_name, cfcp__personel_details.last_name, cfcp__personel_details.date_of_birth, cfcp__players_categories.player_category_name,
					 cfcp__senior_palyer_details.place_of_birth, cfcp__senior_palyer_details.height, cfcp__senior_palyer_details.weight, cfcp__senior_palyer_details.position, 
					 cfcp__senior_palyer_details.coach_comment, cfcp__senior_palyer_details.video_url, cfcp__senior_palyer_details.photo_url
				FROM cfcp__personel_details 
				LEFT JOIN cfcp__senior_palyer_details ON cfcp__senior_palyer_details.CFCP_id = cfcp__personel_details.id
				LEFT JOIN cfcp__players_categories ON cfcp__players_categories.id = cfcp__senior_palyer_details.player_cat_id
				WHERE cfcp__personel_details.id = {$cfcp_id}";
		return DBFunctions::result_to_array_for_few_fields(DBFunctions::execute_query($sql), $params);				
	}
	/* End of the fucntion */

	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_history_details_for_single_cfcp_in_preview($cfcp_id, $params){
	
		global $connection;
		$sql = "SELECT * FROM cfcp__players_history WHERE CFCP_id = {$cfcp_id}";
		return DBFunctions::result_to_array_for_few_fields(DBFunctions::execute_query($sql), $params);				
	}
	/* End of the fucntion */				
}
?>