<?php

require './../../define.inc';
require './../../lib/database.php'; 

class Preview_model{

	/* This function will load data for the preview */
	function load_data_for_preview_in_pfac($id){
		
		$settings = $this->grab_db_settings();
		$connection = DBFunctions::db_connect($settings->db_settings);
		$param_array1 = array('first_name', 'last_name', 'date_of_birth', 'nationality', 'club', 'player_Cat_id', 'height', 'weight', 'position', 'comment', 
							 'photo_url', 'cv_url', 'video_url', 'webpage_url', 'player_web_page');										
		$param_array2 = array('club', 'appearances', 'goals');												
		unset($settings);		
		return array_merge(
							array($this->retrive_history_details_for_single_pfac_in_preview($id, $param_array2)),		
							$this->retrive_general_details_for_single_pfac_in_preview($id, $param_array1)
						  );		
	}
	/* End of the fucntion */
	
	/* This function will retirve db_settings */
	function grab_db_settings(){
	
		return new pfagos_settings();
	}
	/* End of the function */
	
	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_general_details_for_single_pfac_in_preview($pfac_id, $params){
	
		global $connection;
		$sql = "SELECT pfac__genral_details.* FROM pfac__genral_details 
						WHERE pfac__genral_details.id = {$pfac_id}";
		return DBFunctions::result_to_array_for_few_fields(DBFunctions::execute_query($sql), $params);				
	}
	/* End of the fucntion */

	/* This functio will display full of details for each record in pfac in edit view */
	function retrive_history_details_for_single_pfac_in_preview($pfac_id, $params){
	
		global $connection;
		$sql = "SELECT * FROM pfac__players_history WHERE PFAC_id = {$pfac_id}";
		return DBFunctions::result_to_array_for_few_fields(DBFunctions::execute_query($sql), $params);				
	}
	/* End of the fucntion */				
}
?>