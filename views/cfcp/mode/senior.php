<form name="cfcp_senior_form" method="post" action="">	
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
            <td width="150"><span class="defaultFont">Player Category</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td width="500">
            	<div class="<?php echo ((isset($_SESSION['cfcp_reqired_errors'])) && (array_key_exists("player_cat", $_SESSION['cfcp_reqired_errors']))) ? "longSelectBoxWrapDiv errorsIndicatedFields" : "longSelectBoxWrapDiv"; ?>">            
                    <select class="longSelectBox" name="cfcp_senior_reqired[player_cat]">
                        <option value=""> --------------- select --------------- </option>
                        <?php foreach($cfcp_players_cats as $cat):?>
                        <option value="<?php echo $cat['id'];?>"<?php 
  							  $selected = "";	
						      if (
							  	 (isset($fullDetails)) && 
							  	 ($cat['id'] == $fullDetails[0]['player_cat_id'])
								 ){
								echo "selected = 'selected'";
							  }elseif (
							  		  (isset($_SESSION['cfcp_senior_reqired']['player_cat'])) && 
							  		  ($cat['id'] == $_SESSION['cfcp_senior_reqired']['player_cat'])
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
            <td width="150"><span class="defaultFont">Height</span><span class="smallFont specializedTexts newColor">&nbsp;(feet/inches)</span></td>
            <td><div class="smallHeight"><span class="defaultFont webRequiredIndicator">*&nbsp;</span></div></td>                
            <td><input type="text" name="cfcp_senior_non_reqired[height]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_senior_non_reqired']['height'])){
										$value_to_printed = $_SESSION['cfcp_senior_non_reqired']['height'];
									}elseif (isset($fullDetails)){
										$value_to_printed = $fullDetails[0]['height'];										
									}else{
										$value_to_printed = "";																				
									}
									echo trim($value_to_printed);
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>            
        <tr>
            <td><span class="defaultFont">Weight</span><span class="smallFont specializedTexts newColor">&nbsp;(kg)</span></td>
            <td><div class="smallHeight"><span class="defaultFont webRequiredIndicator">*&nbsp;</span></div></td>                
            <td><input type="text" name="cfcp_senior_non_reqired[weight]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_senior_non_reqired']['weight'])){
										$weight = $_SESSION['cfcp_senior_non_reqired']['weight'];
									}elseif (isset($fullDetails)){
										$weight = $fullDetails[0]['weight'];										
									}else{
										$weight = "";																				
									}
									echo stripcslashes(trim($weight));
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>            
        <tr>
            <td><span class="defaultFont">Place of Birth</span></td>
            <td><div class="smallHeight"><span class="defaultFont webRequiredIndicator">*&nbsp;</span></div></td>                
            <td><input type="text" name="cfcp_senior_non_reqired[birth_place]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_senior_non_reqired']['birth_place'])){
										$birth_place = $_SESSION['cfcp_senior_non_reqired']['birth_place'];
									}elseif (isset($fullDetails)){
										$birth_place = $fullDetails[0]['place_of_birth'];										
									}else{
										$birth_place = "";																				
									}
									echo stripcslashes(trim($birth_place));
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Position</span></td>
            <td><div class="smallHeight"><span class="defaultFont webRequiredIndicator">*&nbsp;</span></div></td>                
            <td><input type="text" name="cfcp_senior_non_reqired[pos]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_senior_non_reqired']['pos'])){
										$position = $_SESSION['cfcp_senior_non_reqired']['pos'];
									}elseif (isset($fullDetails)){
										$position = $fullDetails[0]['position'];										
									}else{
										$position = "";																				
									}
									echo stripcslashes(trim($position));
								?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr> 
        <tr>
            <td valign="top"><span class="defaultFont">Key Skills</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><textarea rows="6" class="tinymce" name="cfcp_senior_non_reqired[coh_comment]"><?php 
									if (isset($_SESSION['cfcp_senior_non_reqired']['coh_comment'])){
										$coh_comment = $_SESSION['cfcp_senior_non_reqired']['coh_comment'];
									}elseif (isset($fullDetails)){
										$coh_comment = $fullDetails[0]['coach_comment'];										
									}else{
										$coh_comment = "";																				
									}
									echo stripcslashes(trim($coh_comment));
								?></textarea></td>
        </tr>    
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                 
        <tr>
            <td colspan="3" valign="top">
            <div align="center">		
            	<input onclick="location.href='<?php echo $site_config['base_url'];?>cfcp/<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ?  "edit" : "add"; ?>/?mode=general<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? "&cfcp_id=".$_GET['cfcp_id'].((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1") : "";?>'" type="button" name="cfcp_contact_back" value="Back to General Details" class="inputs submit" />&nbsp;            
            	<input type="submit" name="cfcp_senior_submit" value="<?php echo (!strstr($_SERVER['REQUEST_URI'], "edit")) ? "Proceed to Next Step" : "Save" ;?>" class="inputs submit" />
            </div>    
            </td>
        </tr>                       
    </table>
</div>
</form>    