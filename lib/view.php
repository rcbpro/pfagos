<?php

class App_Viewer{

	/**		
	 * Checks if the user logged in.
	 * @return bool
	 */
	static function logged_in(){
	
		if (isset($_SESSION['logged_user'])){
			return true;
		}else{
			return false;
		}
	}	

	/**		
	 * Returns user firld
	 * @string $field
	 * returns string	 
	 */
	static function current_user($field){
	
		return $_SESSION['logged_user'][$field];
	}

	/**		
	 * Format Date
	 * @param mysql timestamp $mysql_timestamp
	 * @param string	 
	 */
	static function format_date($mysql_timestamp){
	
		return date("j\<\s\u\p\>S\<\/\s\u\p\> F Y", strtotime($mysql_timestamp));
	}

	/**		
	 * Format Date with time
	 * @param mysql timestamp $mysql_timestamp
	 * @param string	 
	 */
	static function format_date_with_time($mysql_timestamp){
	
		return date('l dS \o\f F Y h:i:s A', strtotime($mysql_timestamp));
	}	
	
	/* This function will format the viewing data */
	static function format_view_data_with_line_breaks($data_to_be_splitted){
	
		$splitted_data = "";
		for($n=0; $n<strlen($data_to_be_splitted); $n++){
			if (($n == 35) || ($n == 45) || ($n == 55) || ($n == 65) || ($n == 75)){
				$splitted_data .= "<br />";												
			}
			$splitted_data .= $data_to_be_splitted[$n];	
		}
		return $splitted_data;		
	}
	/* End of the function */	
}
?>