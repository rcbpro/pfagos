<form id="pfac_general_form" name="pfac_general_form" method="post" action="">	
<div align="center">
    <table border="0" cellpadding="0" cellspacing="0" class="pfac_fields_table">
        <tr>
            <td colspan="3">
            	<span class="defaultFont requiredFieldsIndicator">*&nbsp;</span><span class="defaultFont requiredFieldsIndicator smallFont">Required fields</span>
				<span class="defaultFont webRequiredIndicator">*&nbsp;</span><span class="defaultFont webRequiredIndicator smallFont">Need to publish</span><br /><br />                
            </td>
        </tr> 
        <tr>
            <td colspan="3"><div class="smallHeight2"><!-- --></div></td>                
        </tr>                       
        <tr>
            <td width="150"><span class="defaultFont">First Name</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td width="500"><input type="text" name="pfac_general_reqired[firstname]" 
                        value="<?php 
									if (isset($_SESSION['pfac_general_reqired']['firstname'])){
										$firstname = $_SESSION['pfac_general_reqired']['firstname'];
									}elseif (isset($fullDetails)){
										$firstname = $fullDetails[0]['first_name'];										
									}else{
										$firstname = "";																				
									}
									echo trim($firstname);
								?>" 
                        class="inputs <?php echo ((isset($_SESSION['pfac_reqired_errors'])) && (array_key_exists("firstname", $_SESSION['pfac_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>            
        <tr>
            <td><span class="defaultFont">Last Name</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td><input type="text" name="pfac_general_reqired[lastname]" 
                        value="<?php 
									if (isset($_SESSION['pfac_general_reqired']['lastname'])){
										$lastname = $_SESSION['pfac_general_reqired']['lastname'];
									}elseif (isset($fullDetails)){
										$lastname = $fullDetails[0]['last_name'];										
									}else{
										$lastname = "";																				
									}
									echo trim($lastname);
								?>" 
                        class="inputs <?php echo ((isset($_SESSION['pfac_reqired_errors'])) && (array_key_exists("lastname", $_SESSION['pfac_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Date of Birth</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td>
				<?php 
					if (isset($_SESSION['pfac_general_reqired']['day']) && isset($_SESSION['pfac_general_reqired']['month']) && isset($_SESSION['pfac_general_reqired']['year'])){
						$day = $_SESSION['pfac_general_reqired']['day'];
						$month = $_SESSION['pfac_general_reqired']['month'];
						$year = $_SESSION['pfac_general_reqired']['year'];
                        $required_status = true;						
					}elseif (isset($fullDetails)){
						$dob = explode("-", $fullDetails[0]['date_of_birth']);
						$day = $dob[2];
						$month = $dob[1];						
						$year = $dob[0];						
					}else{
						$day = $month = $year = "";
					}
                    echo CommonFunctions::print_date_selecting_drop_down("pfac_general_reqired", $day, $month, $year, 
														$submitStatus, @$_SESSION['date_input_error'], $_SERVER['REQUEST_URI'], $required_status);
                ?></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Nationality</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td>
            	<div class="<?php echo ((isset($_SESSION['pfac_reqired_errors'])) && (array_key_exists("nationality", $_SESSION['pfac_reqired_errors']))) ? "longSelectBoxWrapDiv errorsIndicatedFields" : "longSelectBoxWrapDiv"; ?>">
                    <select class="longSelectBox" name="pfac_general_reqired[nationality]">
                        <option value=""> --------------- select --------------- </option>
                        <?php foreach($nationalityArray as $key => $value):?>
                        <?php 
							if ($key == $_SESSION['pfac_general_reqired']['nationality']){
								$selected = "selected = 'selected'";
							}elseif ((isset($fullDetails)) && ($fullDetails[0]['nationality'] == $key)){
								$selected = "selected = 'selected'";								
							}else{
								$selected = "";																
							}
						?>
                        <option value="<?php echo $key;?>"<?php echo $selected?>><?php echo $value;?></option>
                        <?php endforeach;?>                                                
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr> 
        <tr>
            <td><span class="defaultFont">Player Category</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td>
            	<div class="<?php echo ((isset($_SESSION['pfac_reqired_errors'])) && (array_key_exists("player_cat", $_SESSION['pfac_reqired_errors']))) ? "longSelectBoxWrapDiv errorsIndicatedFields" : "longSelectBoxWrapDiv"; ?>">            
                    <select class="longSelectBox" name="pfac_general_reqired[player_cat]">
                        <option value=""> --------------- select --------------- </option>
                        <?php foreach($pfac_players_cats as $cat):?>
                        <option value="<?php echo $cat['id'];?>"<?php 
  							  $selected = "";	
						      if (
							  	 (isset($fullDetails)) && 
							  	 ($cat['id'] == $fullDetails[0]['player_Cat_id'])
								 ){
								echo "selected = 'selected'";
							  }elseif (
							  		  (isset($_SESSION['pfac_general_reqired']['player_cat'])) && 
							  		  ($cat['id'] == $_SESSION['pfac_general_reqired']['player_cat'])
									  ){
								echo "selected = 'selected'";
							  }else{
								echo "";
							  }?>><?php echo $cat['player_category_name'];?></option>
                        <?php endforeach;?>                                                
                </select>
                </div>                
            </td>
        </tr>                                           
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
        	<td><div><!-- --></div></td>
        	<td><div><!-- --></div></td>
            <td><input type="submit" name="pfac_general_submit" value="<?php echo (!strstr($_SERVER['REQUEST_URI'], "edit")) ?  "Proceed to Next Step" : "Save"; ?>" class="inputs submit" /></td>
        </tr>                       
    </table>
</div>
</form>    