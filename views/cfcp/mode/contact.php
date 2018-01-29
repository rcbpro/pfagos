<form name="cfcp_contact_form" method="post" action="">
<div align="center">	
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="pfac_fields_table">
        <tr>
            <td colspan="3"><div class="smallHeight2"><!-- --></div></td>                
        </tr>  
        <tr>
            <td width="180"><span class="defaultFont">Home Address</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[homeadd]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['homeadd'])){
										$homeadd = $_SESSION['cfcp_contact_non_reqired']['homeadd'];
									}elseif (isset($fullDetails)){
										$homeadd = $fullDetails[0]['home_address'];										
									}else{
										$homeadd = "";																				
									}
									echo stripcslashes(trim($homeadd));
								 ?>" 
                        class="inputs" /></td>
        </tr>    
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                 
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Mobile No : </span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[mob_no]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['mob_no'])){
										$mob_no = $_SESSION['cfcp_contact_non_reqired']['mob_no'];
									}elseif (isset($fullDetails)){
										$mob_no = $fullDetails[0]['mobile_no'];										
									}else{
										$mob_no = "";																				
									}
									echo stripcslashes(trim($mob_no));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Email</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[email]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['email'])){
										$email = $_SESSION['cfcp_contact_non_reqired']['email'];
									}elseif (isset($fullDetails)){
										$email = $fullDetails[0]['email'];										
									}else{
										$email = "";																				
									}
									echo stripcslashes(trim($email));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr> 
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Father's Name</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[father_name]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['father_name'])){
										$father_name = $_SESSION['cfcp_contact_non_reqired']['father_name'];
									}elseif (isset($fullDetails)){
										$father_name = $fullDetails[0]['father_name'];										
									}else{
										$father_name = "";																				
									}
									echo stripcslashes(trim($father_name));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Father's Contact No : </span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[father_con_no]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['father_con_no'])){
										$father_contact_no = $_SESSION['cfcp_contact_non_reqired']['father_con_no'];
									}elseif (isset($fullDetails)){
										$father_contact_no = $fullDetails[0]['father_contact_no'];										
									}else{
										$father_contact_no = "";																				
									}
									echo stripcslashes(trim($father_contact_no));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Father's Occupation</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[father_occupation]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['father_occupation'])){
										$father_occupation = $_SESSION['cfcp_contact_non_reqired']['father_occupation'];
									}elseif (isset($fullDetails)){
										$father_occupation = $fullDetails[0]['father_occupation'];										
									}else{
										$father_occupation = "";																				
									}
									echo stripcslashes(trim($father_occupation));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Mother's Name</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[mother_name]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['mother_name'])){
										$mother_name = $_SESSION['cfcp_contact_non_reqired']['mother_name'];
									}elseif (isset($fullDetails)){
										$mother_name = $fullDetails[0]['mother_name'];										
									}else{
										$mother_name = "";																				
									}
									echo stripcslashes(trim($mother_name));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Mother's Contact No : </span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[mother_con_no]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['mother_con_no'])){
										$mother_contact_no = $_SESSION['cfcp_contact_non_reqired']['mother_con_no'];
									}elseif (isset($fullDetails)){
										$mother_contact_no = $fullDetails[0]['mother_contact_no'];										
									}else{
										$mother_contact_no = "";																				
									}
									echo stripcslashes(trim($mother_contact_no));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Mother's Occupation</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[mother_occupation]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['mother_occupation'])){
										$mother_occupation = $_SESSION['cfcp_contact_non_reqired']['mother_occupation'];
									}elseif (isset($fullDetails)){
										$mother_occupation = $fullDetails[0]['mother_occupation'];										
									}else{
										$mother_occupation = "";																				
									}
									echo stripcslashes(trim($mother_occupation));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Parent's Address</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[parent_add]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['parent_add'])){
										$parents_address = $_SESSION['cfcp_contact_non_reqired']['parent_add'];
									}elseif (isset($fullDetails)){
										$parents_address = $fullDetails[0]['parents_address'];										
									}else{
										$parents_address = "";																				
									}
									echo stripcslashes(trim($parents_address));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Passport No : </span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[passport_no]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['passport_no'])){
										$passport_no = $_SESSION['cfcp_contact_non_reqired']['passport_no'];
									}elseif (isset($fullDetails)){
										$passport_no = $fullDetails[0]['passport_no'];										
									}else{
										$passport_no = "";																				
									}
									echo stripcslashes(trim($passport_no));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Exact Name on Passport</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_contact_non_reqired[exact_name_pass]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_contact_non_reqired']['exact_name_pass'])){
										$exact_name_passport = $_SESSION['cfcp_contact_non_reqired']['exact_name_pass'];
									}elseif (isset($fullDetails)){
										$exact_name_passport = $fullDetails[0]['exact_name_passport'];										
									}else{
										$exact_name_passport = "";																				
									}
									echo stripcslashes(trim($exact_name_passport));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr> 
        <tr>
            <td class="a-center" colspan="3" valign="top">                
            <?php if (($_SESSION['cfcp_general_reqired']['team_cat'] == 5) || ($_SESSION['temm_id'] == 5)):?>
            	<?php
					if ($_SESSION['temm_id'] == 5) $edit_mode = "edit-media";
					if ($_SESSION['cfcp_general_reqired']['team_cat'] == 5) $edit_mode = "media";						
				?>
				<input onclick="location.href='<?php echo $site_config['base_url'];?>cfcp/<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ?  "edit" : "add"; ?>/?mode=<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ?  $edit_mode : "media"; ?><?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? "&cfcp_id=".$_GET['cfcp_id'].((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1") : "";?>'" type="button" name="cfcp_media_back" value="Back to Media Details" class="inputs submit" />&nbsp;
			<?php else:?>
				<input onclick="location.href='<?php echo $site_config['base_url'];?>cfcp/<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ?  "edit" : "add"; ?>/?mode=general<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? "&cfcp_id=".$_GET['cfcp_id'].((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1") : "";?>'" type="button" name="cfcp_heneral_back" value="Back to General Details" class="inputs submit" />&nbsp;            	
            <?php endif;?>                
            	<input type="submit" name="cfcp_contact_submit" value="<?php echo (!strstr($_SERVER['REQUEST_URI'], "edit")) ?  "Proceed to Next Step" : "Save"; ?>" class="inputs submit" />
            </td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                                                            
    </table>
</div>
</form>    