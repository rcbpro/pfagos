<form name="cfcp_general_form" method="post" action="">	
<div align="center">
    <table border="0" cellpadding="0" cellspacing="0" class="pfac_fields_table">
        <tr>
            <td colspan="3"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span><span class="defaultFont requiredFieldsIndicator smallFont">Required fields</span></td>
        </tr> 
        <tr>
            <td colspan="3"><div class="smallHeight2"><!-- --></div></td>                
        </tr>
        <tr>
            <td width="194"><span class="defaultFont">Team Category</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td>
            	<div class="<?php echo ((isset($_SESSION['cfcp_reqired_errors'])) && (array_key_exists("team_cat", $_SESSION['cfcp_reqired_errors']))) ? "longSelectBoxWrapDiv errorsIndicatedFields" : "longSelectBoxWrapDiv"; ?>">            
                    <select class="longSelectBox" name="cfcp_general_reqired[team_cat]">
                        <option value=""> --------------- select --------------- </option>
                        <?php foreach($cfcp_team_cats as $cat):?>
                        <option value="<?php echo $cat['id'];?>"<?php 
  							  $selected = "";	
						      if (
							  	 (isset($fullDetails)) && 
							  	 ($cat['id'] == $fullDetails[0]['team_id'])
								 ){
								echo "selected = 'selected'";
							  }elseif (
							  		  (isset($_SESSION['cfcp_general_reqired']['team_cat'])) && 
							  		  ($cat['id'] == $_SESSION['cfcp_general_reqired']['team_cat'])
									  ){
								echo "selected = 'selected'";
							  }else{
								echo "";
							  }?>><?php echo $cat['team_name'];?></option>
                        <?php endforeach;?>                                                
                </select>
                </div>                
            </td>
        </tr>                                           
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>            
        <tr>
            <td><span class="defaultFont">First Name</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td><input type="text" name="cfcp_general_reqired[firstname]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_general_reqired']['firstname'])){
										$firstname = $_SESSION['cfcp_general_reqired']['firstname'];
									}elseif (isset($fullDetails)){
										$firstname = $fullDetails[0]['first_name'];										
									}else{
										$firstname = "";																				
									}
									echo stripcslashes(trim($firstname));
								?>" 
                        class="inputs <?php echo ((isset($_SESSION['cfcp_reqired_errors'])) && (array_key_exists("firstname", $_SESSION['cfcp_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>            
        <tr>
            <td><span class="defaultFont">Last Name</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td><input type="text" name="cfcp_general_reqired[lastname]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_general_reqired']['lastname'])){
										$last_name = $_SESSION['cfcp_general_reqired']['lastname'];
									}elseif (isset($fullDetails)){
										$last_name = $fullDetails[0]['last_name'];										
									}else{
										$last_name = "";																				
									}
									echo stripcslashes(trim($last_name));
								?>" 
                        class="inputs <?php echo ((isset($_SESSION['cfcp_reqired_errors'])) && (array_key_exists("lastname", $_SESSION['cfcp_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Date of Birth</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td>
				<?php 
					if (isset($_SESSION['cfcp_general_reqired']['day']) && isset($_SESSION['cfcp_general_reqired']['month']) && isset($_SESSION['cfcp_general_reqired']['year'])){
						$day = $_SESSION['cfcp_general_reqired']['day'];
						$month = $_SESSION['cfcp_general_reqired']['month'];
						$year = $_SESSION['cfcp_general_reqired']['year'];
                        $required_status = true;												
					}elseif (isset($fullDetails)){
						$dob = explode("-", $fullDetails[0]['date_of_birth']);
						$day = $dob[2];
						$month = $dob[1];						
						$year = $dob[0];						
					}else{
						$day = $month = $year = "";
					}
                    echo CommonFunctions::print_date_selecting_drop_down("cfcp_general_reqired", $day, $month, $year, $submitStatus, @$_SESSION['date_input_error'], $_SERVER['REQUEST_URI'], $required_status);
                ?>
              </td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>            
        <tr>
            <td><span class="defaultFont">Nickname 1</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_general_non_reqired[nickname1]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_general_non_reqired']['nickname1'])){
										$nickname1 = $_SESSION['cfcp_general_non_reqired']['nickname1'];
									}elseif (isset($fullDetails)){
										$nickname1 = $fullDetails[0]['nickname1'];										
									}else{
										$nickname1 = "";																				
									}
									echo stripcslashes(trim($nickname1));
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>            
        <tr>
            <td><span class="defaultFont">Nickname 2</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_general_non_reqired[nickname2]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_general_non_reqired']['nickname2'])){
										$nickname2 = $_SESSION['cfcp_general_non_reqired']['nickname2'];
									}elseif (isset($fullDetails)){
										$nickname2 = $fullDetails[0]['nickname2'];										
									}else{
										$nickname2 = "";																				
									}
									echo stripcslashes(trim($nickname2));
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>
        <tr>
            <td colspan="3"><div align="center"><input type="submit" name="cfcp_general_submit" value="<?php echo (!strstr($_SERVER['REQUEST_URI'], "edit")) ? "Proceed to Next Step" : "Save";?>" class="inputs submit" /></div></td>
        </tr>                       
    </table>
</div>
</form>