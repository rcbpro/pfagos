<form name="pfac_contact_form" method="post" action="">
<div align="center">
	
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="pfac_fields_table">
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr> 
        <tr>
            <td><span class="defaultFont">Emergency Contact Name</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[emerg_contact_name]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['emerg_contact_name'])){
										$emerg_contact_name = $_SESSION['pfac_contact_not_reqired']['emerg_contact_name'];
									}elseif (isset($fullDetails)){
										$emerg_contact_name = $fullDetails[0]['emergency_contact_name'];										
									}else{
										$emerg_contact_name = "";																				
									}
									echo trim($emerg_contact_name);						
								?>" 
                        class="inputs" /></td>
        </tr>    
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                        
        <tr>
            <td><span class="defaultFont">Emergency Contact No : </span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[emerg_contact_no]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['emerg_contact_no'])){
										$emerg_contact_no = $_SESSION['pfac_contact_not_reqired']['emerg_contact_no'];
									}elseif (isset($fullDetails)){
										$emerg_contact_no = $fullDetails[0]['emergency_contact_no'];										
									}else{
										$emerg_contact_no = "";																				
									}
									echo trim($emerg_contact_no);						
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                        
        <tr>
            <td width="200"><span class="defaultFont">Home Address</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[homeaddress]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['homeaddress'])){
										$homeaddress = $_SESSION['pfac_contact_not_reqired']['homeaddress'];
									}elseif (isset($fullDetails)){
										$homeaddress = $fullDetails[0]['home_address'];										
									}else{
										$homeaddress = "";																				
									}
									echo trim($homeaddress);
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>            
        <tr>
            <td><span class="defaultFont">Home Phone</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[home_phone]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['home_phone'])){
										$home_phone = $_SESSION['pfac_contact_not_reqired']['home_phone'];
									}elseif (isset($fullDetails)){
										$home_phone = $fullDetails[0]['home_phone'];										
									}else{
										$home_phone = "";																				
									}
									echo trim($home_phone);
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>            
        <tr>
            <td><span class="defaultFont">Home Mobile</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[home_mobile]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['home_mobile'])){
										$home_mobile = $_SESSION['pfac_contact_not_reqired']['home_mobile'];
									}elseif (isset($fullDetails)){
										$home_mobile = $fullDetails[0]['home_mobile'];										
									}else{
										$home_mobile = "";																				
									}
									echo trim($home_mobile);
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Overseas Address</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[overseas_address]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['overseas_address'])){
										$overseas_address = $_SESSION['pfac_contact_not_reqired']['overseas_address'];
									}elseif (isset($fullDetails)){
										$overseas_address = $fullDetails[0]['overseas_address'];										
									}else{
										$overseas_address = "";																				
									}
									echo trim($overseas_address);						
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Overseas Phone</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[overseas_phone]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['overseas_phone'])){
										$overseas_phone = $_SESSION['pfac_contact_not_reqired']['overseas_phone'];
									}elseif (isset($fullDetails)){
										$overseas_phone = $fullDetails[0]['overseas_phone'];										
									}else{
										$overseas_phone = "";																				
									}
									echo trim($overseas_phone);						
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Overseas Mobile</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[overseas_mobile]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['overseas_mobile'])){
										$overseas_mobile = $_SESSION['pfac_contact_not_reqired']['overseas_mobile'];
									}elseif (isset($fullDetails)){
										$overseas_mobile = $fullDetails[0]['overseas_mobile'];										
									}else{
										$overseas_mobile = "";																				
									}
									echo trim($overseas_mobile);						
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Contract Start Date</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td>
				<?php 
					if (isset($_SESSION['contract_start_date']['day']) && isset($_SESSION['contract_start_date']['month']) && isset($_SESSION['contract_start_date']['year'])){
						$day = $_SESSION['contract_start_date']['day'];
						$month = $_SESSION['contract_start_date']['month'];
						$year = $_SESSION['contract_start_date']['year'];
						$required_status = false;
					}elseif (isset($fullDetails)){
						$contract_start_date = explode("-", $fullDetails[0]['contract_start_date']);
						$day = $contract_start_date[2];
						$month = $contract_start_date[1];						
						$year = $contract_start_date[0];						
					}else{
						$day = $month = $year = "";
					}
                    echo CommonFunctions::print_date_selecting_drop_down("contract_start_date", $day, $month, $year, $submitStatus, 
														@$_SESSION['date_input_error_2'], $_SERVER['REQUEST_URI'], $required_status, "both");
                ?></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Contract End Date</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td>
				<?php 
					if (isset($_SESSION['contract_end_date']['day']) && isset($_SESSION['contract_end_date']['month']) && isset($_SESSION['contract_end_date']['year'])){
						$day = $_SESSION['contract_end_date']['day'];
						$month = $_SESSION['contract_end_date']['month'];
						$year = $_SESSION['contract_end_date']['year'];
						$required_status = false;						
					}elseif (isset($fullDetails)){
						$contract_end_date = explode("-", $fullDetails[0]['contract_end_date']);
						$day = $contract_end_date[2];
						$month = $contract_end_date[1];						
						$year = $contract_end_date[0];						
					}else{
						$day = $month = $year = "";
					}
                    echo CommonFunctions::print_date_selecting_drop_down("contract_end_date", $day, $month, $year, $submitStatus, 
														@$_SESSION['date_input_error_3'], $_SERVER['REQUEST_URI'], $required_status, "new");
                ?></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont">Email</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[email]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['email'])){
										$email = $_SESSION['pfac_contact_not_reqired']['email'];
									}elseif (isset($fullDetails)){
										$email = $fullDetails[0]['email'];										
									}else{
										$email = "";																				
									}
									echo trim($email);						
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont">Passport No : </span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[passport_no]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['passport_no'])){
										$passport_no = $_SESSION['pfac_contact_not_reqired']['passport_no'];
									}elseif (isset($fullDetails)){
										$passport_no = $fullDetails[0]['passport_no'];										
									}else{
										$passport_no = "";																				
									}
									echo trim($passport_no);						
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont">Exact Name on Passport</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_contact_not_reqired[exact_name_on_passport]" 
                        value="<?php 
									if (isset($_SESSION['pfac_contact_not_reqired']['exact_name_on_passport'])){
										$exact_name_on_passport = $_SESSION['pfac_contact_not_reqired']['exact_name_on_passport'];
									}elseif (isset($fullDetails)){
										$exact_name_on_passport = $fullDetails[0]['exact_name_on_passport'];										
									}else{
										$exact_name_on_passport = "";																				
									}
									echo trim($exact_name_on_passport);						
								?>" 
                        class="inputs" /></td>
        </tr>                        
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr> 
        <tr>
            <td class="a-center" colspan="3" valign="top">                
				<input onclick="location.href='<?php echo $site_config['base_url'];?>pfac/<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ?  "edit" : "add"; ?>/?mode=<?php echo ($_SESSION['pfac_general_reqired']['player_cat'] == 5) ? "coach-info" : "player-info";?><?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? "&pfac_id=".$_GET['pfac_id'].((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1") : "";?>'" type="button" name="pfac_contact_back" value="Back to <?php echo ($_SESSION['pfac_general_reqired']['player_cat'] == 5) ? "Coach's Information" : "Player Information";?>" class="inputs submit" />&nbsp;
            	<input type="submit" name="pfac_contact_submit" value="<?php echo (!strstr($_SERVER['REQUEST_URI'], "edit")) ?  "Proceed to History Details" : "Save"; ?>" class="inputs submit" /></span>
            </td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                                                            
    </table>
</div>
</form>    