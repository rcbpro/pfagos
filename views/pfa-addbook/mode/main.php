<div align="center">
<form name="pfac_addbook_form" method="post" action="">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="154"><span class="defaultFont">First Name</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td>
                <input type="text" name="pfac_addbook_reqired[first_name]" 
                        value="<?php 
                                    if ((strstr($_SERVER['REQUEST_URI'], "add/")) && (isset($_SESSION['pfac_addbook_reqired']))){
                                        $first_name = $_SESSION['pfac_addbook_reqired']['first_name'];
                                    }elseif (isset($full_details)){
                                        $first_name = $full_details[0]['first_name'];										
                                    }else{
                                        $first_name = "";																				
                                    }
                                    echo trim($first_name);
                                ?>" 
                        class="inputs <?php echo ((isset($_SESSION['pfaaddbook_reqired_errors'])) && (array_key_exists("first_name", $_SESSION['pfaaddbook_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>            
        <tr>
            <td><span class="defaultFont">Last Name</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td>
                <input type="text" name="pfac_addbook_reqired[last_name]" 
                        value="<?php 
                                    if ((strstr($_SERVER['REQUEST_URI'], "add/")) && (isset($_SESSION['pfac_addbook_reqired']))){
                                        $last_name = $_SESSION['pfac_addbook_reqired']['last_name'];
                                    }elseif (isset($full_details)){
                                        $last_name = $full_details[0]['last_name'];										
                                    }else{
                                        $last_name = "";																				
                                    }
                                    echo trim($last_name);
                                ?>" 
                        class="inputs <?php echo ((isset($_SESSION['pfaaddbook_reqired_errors'])) && (array_key_exists("last_name", $_SESSION['pfaaddbook_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Address Book Category</span></td>
            <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
            <td>
                <div class="floatLeft <?php echo ((isset($_SESSION['pfaaddbook_reqired_errors'])) && (array_key_exists("PFAC_addbook_cat_id", $_SESSION['pfaaddbook_reqired_errors']))) ? "longSelectBoxWrapDiv errorsIndicatedFields" : "longSelectBoxWrapDiv"; ?>">
                <select class="longSelectBox" name="pfac_addbook_reqired[PFAC_addbook_cat_id]"
                    <option value=""> --------------- select --------------- </option>
                    <?php foreach($addbook_cats as $category):?>
                    <?php 
                        $selected = "";
                        if ($category['id'] == $_SESSION['pfac_addbook_reqired']['PFAC_addbook_cat_id']){
                            $selected = "selected = 'selected'";
                        }elseif ((isset($full_details)) && ($full_details[0]['addbookCatId'] == $category['id'])){
                            $selected = "selected = 'selected'";								
                        }else{
                            $selected = "";																
                        }
                    ?>
                            <option value="<?php echo $category['id'];?>"<?php echo $selected;?>><?php echo $category['Client_category_name'];?></option>
                    <?php endforeach;?>                                                
                </select>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Position</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_addbook_not_reqired[position]" 
                        value="<?php 
                                    if (isset($_SESSION['pfac_addbook_not_reqired'])){
                                        $position = $_SESSION['pfac_addbook_not_reqired']['position'];
                                    }elseif (isset($full_details)){
                                        $position = $full_details[0]['position'];										
                                    }else{
                                        $position = "";																				
                                    }
                                    echo trim($position);						
                                ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Nationality</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td>
            	<div class="longSelectBoxWrapDiv">
                    <select class="longSelectBox" name="pfac_addbook_not_reqired[nationality]">
                        <option value=""> --------------- select --------------- </option>
                        <?php 
							ksort($nationalityArray);
							foreach($nationalityArray as $key => $value):
						?>
                        <?php 
							if ($key == $_SESSION['pfac_addbook_not_reqired']['nationality']){
								$selected = "selected = 'selected'";
							}elseif ((isset($full_details)) && ($full_details[0]['nationality'] == $key)){
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
            <td><span class="defaultFont">Location</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td>
            	<div class="longSelectBoxWrapDiv">
                    <select class="longSelectBox" name="pfac_addbook_not_reqired[location]">
                        <option value=""> --------------- select --------------- </option>
                        <?php 
							ksort($countryListArray);						
							foreach($countryListArray as $key => $value):
						?>
                        <?php 
							if ($key == $_SESSION['pfac_addbook_not_reqired']['location']){
								$selected = "selected = 'selected'";
							}elseif ((isset($full_details)) && ($full_details[0]['location'] == $key)){
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
            <td><span class="defaultFont">Ability of Spoken English</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td>
            	<div class="longSelectBoxWrapDiv">            
                    <select class="longSelectBox" name="pfac_addbook_not_reqired[ability_of_english]">
                        <option value=""> --------------- select --------------- </option>
                        <?php 
							ksort($languageAbilityArray);
							foreach($languageAbilityArray as $value):
						?>
                        <?php	
                            if ($value == $_SESSION['pfac_addbook_not_reqired']['ability_of_english']){
                                $selected = "selected = 'selected'";
                            }elseif ((isset($full_details)) && ($full_details[0]['ability_of_english'] == $value)){
                                $selected = "selected = 'selected'";								
                            }else{
                                $selected = "";																
                            }
                        ?>
                        <option value="<?php echo $value;?>"<?php echo $selected?>><?php echo $value;?></option>
                        <?php endforeach;?>
                    </select>
                 </div>   
            </td>
        </tr>
        <tr>
            <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Prefered Language</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td>
            	<div class="longSelectBoxWrapDiv">
                    <select class="longSelectBox" name="pfac_addbook_not_reqired[pref_language]">
                        <option value=""> --------------- select --------------- </option>
                        <?php 
							ksort($languageListArray);
							foreach($languageListArray as $key => $value):
						?>
                        <?php 
							if ($key == $_SESSION['pfac_addbook_not_reqired']['pref_language']){
								$selected = "selected = 'selected'";
							}elseif ((isset($full_details)) && ($full_details[0]['pref_language'] == $key)){
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
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr> 
        <tr>
            <td><span class="defaultFont">Organization</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_addbook_not_reqired[organization]" 
                        value="<?php 
                                    if (isset($_SESSION['pfac_addbook_not_reqired'])){
                                        $organization = $_SESSION['pfac_addbook_not_reqired']['organization'];
                                    }elseif (isset($full_details)){
                                        $organization = $full_details[0]['organization'];										
                                    }else{
                                        $organization = "";																				
                                    }
                                    echo trim($organization);						
                                ?>" 
                        class="inputs" /></td>
        </tr> 
        
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                        
        <tr>
            <td><span class="defaultFont">Address</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_addbook_not_reqired[address]" 
                        value="<?php 
                                    if (isset($_SESSION['pfac_addbook_not_reqired'])){
                                        $address = $_SESSION['pfac_addbook_not_reqired']['address'];
                                    }elseif (isset($full_details)){
                                        $address = $full_details[0]['address'];										
                                    }else{
                                        $address = "";																				
                                    }
                                    echo trim($address);						
                                ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont">Phone</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_addbook_not_reqired[phone]" 
                        value="<?php 
                                    if (isset($_SESSION['pfac_addbook_not_reqired'])){
                                        $phone = $_SESSION['pfac_addbook_not_reqired']['phone'];
                                    }elseif (isset($full_details)){
                                        $phone = $full_details[0]['phone'];										
                                    }else{
                                        $phone = "";																				
                                    }
                                    echo trim($phone);						
                                ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                            
        <tr>
            <td><span class="defaultFont">Fax</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_addbook_not_reqired[fax]" 
                        value="<?php 
                                    if (isset($_SESSION['pfac_contact_reqired'])){
                                        $fax = $_SESSION['pfac_contact_reqired']['fax'];
                                    }elseif (isset($full_details)){
                                        $fax = $full_details[0]['fax'];										
                                    }else{
                                        $fax = "";																				
                                    }
                                    echo trim($fax);						
                                ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr> 
        <tr>
            <td><span class="defaultFont">Mobile</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_addbook_not_reqired[mobile]" 
                        value="<?php 
                                    if (isset($_SESSION['pfac_addbook_not_reqired'])){
                                        $mobile = $_SESSION['pfac_addbook_not_reqired']['mobile'];
                                    }elseif (isset($full_details)){
                                        $mobile = $full_details[0]['mobile'];										
                                    }else{
                                        $mobile = "";																				
                                    }
                                    echo trim($mobile);						
                                ?>" 
                        class="inputs <?php echo ((isset($_SESSION['pfaaddbook_reqired_errors'])) && (array_key_exists("mobile", $_SESSION['pfaaddbook_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
        </tr> 
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                        
        <tr>
            <td><span class="defaultFont">Email</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="pfac_addbook_not_reqired[email]" 
                        value="<?php 
                                    if (isset($_SESSION['pfac_addbook_not_reqired'])){
                                        $email = $_SESSION['pfac_addbook_not_reqired']['email'];
                                    }elseif (isset($full_details)){
                                        $email = $full_details[0]['email'];										
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
            <td colspan="3"><div align="center"><span class="defaultFont"><input type="submit" name="pfac_addbook_submit" value="<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? "Save" : "Save and Proceed";?>" class="inputs submit" /></span></div></td>
        </tr>
    </table>
</form>
</div>