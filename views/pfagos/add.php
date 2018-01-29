<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$("#chk_group_1").click(function () {
		if ($(this).is(':checked')){
			$('input:checkbox:not(#chk_group_1)').removeAttr('checked');
		}

	});

	$('input:checkbox:not(#chk_group_1)').click(
	   function()
	   {
		   if($('input[type=checkbox]:checked').length){
			   $("#chk_group_1").removeAttr('checked');
		   }
	   }
	)
});
</script>
<div id="static_header">
    <!-- Breadcrumb div message -->
    <?php echo $breadcrumb;?>
    <!--  End of the Breadcrumb div mesage -->
    <!-- This is the success/error message to be diplayed -->
    <?php global $headerDivMsg; echo $headerDivMsg;?>
    <!-- End of the success or error message -->
    <?php if (strstr($_SERVER['REQUEST_URI'], "edit")):?>
    <!-- Start of the action panel -->
    <div class="action-panel"><?php echo $action_panel_menu;?></div>
    <!-- End of the action panel -->
    <?php endif;?>
    <div class="headerTopicContainer defaultFont boldText"><span class="headerTopicSelected">PFAGOS<?php echo (strstr($_SERVER['REQUEST_URI'], "add/")) ? " - Add New User" : " - Edit User";?></span></div>
</div>
<div id="dataInputContainer_wrap">
    <div class="dataInputContainer"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span><span class="defaultFont requiredFieldsIndicator smallFont">Required fields</span>
        <form name="pfagos_form" method="post" action="">
        <div align="center">
            <table cellpadding="0" cellspacing="0" border="0">
            <tr><td>
            <div class="add-user-l">
                <table border="0" cellpadding="0" cellspacing="0" class="pfac_fields_table">
                    <tr>
                        <td><div class="smallHeight"><!-- --></div></td>
                        <td width="124"><span class="defaultFont">First Name</span></td>
                        <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>
                        <td>
                            <input type="text" name="pfagos_reqired[first_name]" 
                            value="<?php 
                                        if (isset($_SESSION['pfagos_reqired'])){
                                            $value_to_printed = $_SESSION['pfagos_reqired']['first_name'];
                                        }elseif (isset($full_details)){
                                            $value_to_printed = $full_details[0]['first_name'];										
                                        }else{
                                            $value_to_printed = "";																				
                                        }
                                        echo ucfirst(trim($value_to_printed));
                                    ?>" 
                            class="inputs <?php echo ((isset($_SESSION['pfagos_reqired_errors'])) && (array_key_exists("first_name", $_SESSION['pfagos_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
                    </tr>            
                    <tr>
                        <td><div class="smallHeight"><!-- --></div></td>                                        
                        <td><span class="defaultFont">Last Name</span></td>
                        <td><div class="smallHeight"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span></div></td>                
                        <td>
                            <input type="text" name="pfagos_reqired[last_name]" 
                            value="<?php 
                                        if (isset($_SESSION['pfagos_reqired'])){
                                            $value_to_printed = $_SESSION['pfagos_reqired']['last_name'];
                                        }elseif (isset($full_details)){
                                            $value_to_printed = $full_details[0]['last_name'];										
                                        }else{
                                            $value_to_printed = "";																				
                                        }
                                        echo ucfirst(trim($value_to_printed));
                                    ?>" 
                            class="inputs <?php echo ((isset($_SESSION['pfagos_reqired_errors'])) && (array_key_exists("last_name", $_SESSION['pfagos_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>                            
                    </tr>
                    <tr>
                        <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
                    </tr>                        
                    <tr>
                        <td><div class="smallHeight"><!-- --></div></td>                                        
                        <td><span class="defaultFont">Username</span></td>
                        <td><div class="smallHeight"><?php if (!strstr($_SERVER['REQUEST_URI'], "edit")):?><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span><?php endif;?></div></td>                
                        <td><?php if (!strstr($_SERVER['REQUEST_URI'], "edit")):?><input type="text" name="pfagos_reqired[username]" 
                                    value="<?php 
                                                if (isset($_SESSION['pfagos_reqired'])){
                                                    $value_to_printed = $_SESSION['pfagos_reqired']['username'];
                                                }elseif (isset($full_details)){
                                                    $value_to_printed = $full_details[0]['username'];										
                                                }else{
                                                    $value_to_printed = "";																				
                                                }
                                                echo trim($value_to_printed);						
                                            ?>" 
                                    class="inputs <?php echo ((isset($_SESSION['pfagos_reqired_errors'])) && (array_key_exists("username", $_SESSION['pfagos_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" />
                            <?php else:?>
                                <span class="defaultFont boldText specializedTexts"><?php echo $full_details[0]['username'];?></span>
                            <?php endif;?></td>                            
                    </tr>
                    <tr>
                        <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
                    </tr>                                    
                    <tr>
                        <td><div class="smallHeight"><!-- --></div></td>                                        
                        <td><span class="defaultFont"><?php echo (strstr($_SERVER['REQUEST_URI'], "edit/")) ? "Current " : ""; ?>Password</span></td>
                        <td><div class="smallHeight"><?php if (!strstr($_SERVER['REQUEST_URI'], "edit/")):?><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span><?php endif;?></div></td>                
                        <td><input type="password" name="<?php echo (strstr($_SERVER['REQUEST_URI'], "edit/")) ? "pfagos_not_reqired_spec": "pfagos_reqired";?>[password]" value="" 
                                        class="inputs <?php echo ((isset($_SESSION['pfagos_reqired_errors'])) && (array_key_exists("password", $_SESSION['pfagos_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
                    </tr>                                    
                    <?php if (strstr($_SERVER['REQUEST_URI'], "edit/")):?>
                    <tr>
                        <td><div class="smallHeight"><!-- --></div></td>                                        
                        <td><span class="defaultFont">New Password</span></td>
                        <td><div class="smallHeight"><?php if (!strstr($_SERVER['REQUEST_URI'], "edit/")):?><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span><?php endif;?></div></td>                
                        <td><input type="password" name="<?php echo (strstr($_SERVER['REQUEST_URI'], "edit/")) ? "pfagos_not_reqired_spec": "pfagos_reqired";?>[new_password]" value="" 
                                                class="inputs <?php echo ((isset($_SESSION['pfagos_reqired_errors'])) && (array_key_exists("new_password", $_SESSION['pfagos_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
                    </tr>                                    
                    <?php endif;?>
                    <tr>
                        <td><div class="smallHeight"><!-- --></div></td>                                        
                        <td><span class="defaultFont">Confirm Password</span></td>
                        <td><div class="smallHeight"><?php if (!strstr($_SERVER['REQUEST_URI'], "edit/")):?><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span><?php endif;?></div></td>                
                        <td><input type="password" name="<?php echo (strstr($_SERVER['REQUEST_URI'], "edit/")) ? "pfagos_not_reqired_spec": "pfagos_reqired";?>[confirm_password]" value="" 
                                                class="inputs <?php echo ((isset($_SESSION['pfagos_reqired_errors'])) && (array_key_exists("confirm_password", $_SESSION['pfagos_reqired_errors']))) ? "errorsIndicatedFields" : ""; ?>" /></td>
                    </tr>                        
                    <tr>
                        <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
                    </tr>                                                
                    <tr>
                        <td><div class="smallHeight"><!-- --></div></td>                                        
                        <td><span class="defaultFont">Email</span></td>
                        <td><div class="smallHeight"><!-- --></div></td>                
                        <td><input type="text" name="pfagos_not_reqired[email]" 
                                    value="<?php 
                                                if (isset($_SESSION['pfagos_not_reqired'])){
                                                    $value_to_printed = $_SESSION['pfagos_not_reqired']['email'];
                                                }elseif (isset($full_details)){
                                                    $value_to_printed = $full_details[0]['email'];										
                                                }else{
                                                    $value_to_printed = "";																				
                                                }
                                                echo trim($value_to_printed);						
                                            ?>" 
                                    class="inputs" /></td>
                    </tr>
                    <tr><td colspan="4"><div class="smallHeight"><!-- --></div></td></tr>
                    <tr>
                    	<td><!-- --></td>
                                    <td><?php if (strstr($_SERVER['REQUEST_URI'], "edit")):?><span class="defaultFont"><a href="?pfagos_id=<?php echo $_GET['pfagos_id'];?>&action=reset<?php echo ((isset($_GET['page'])) ? "&page=".$_GET['page'] : "");?>">Reset Password</a></span><br /><span class="specializedTexts smallFont">Tempory Password will be<br />created as (<?php echo $_SESSION['rand_pass'];?>)</span><?php endif;?></td>
                                    <td><!-- --></td>
                                    <td><div align="center"><input type="submit" name="pahro_submit" value="Save" class="inputs submit" /></div></td>


                    </tr>
                </table>
            </div>
            </td>
            <td valign="top">
            <div id="user_group_permissions_display">
                <fieldset>
                <legend><span class="defaultFont">User Groups</span></legend>
                <?php if ("POST" == $_SERVER['REQUEST_METHOD']):?>
					<?php for($i=0; $i<count($user_groups); $i++):?>
                        <div><label class="defaultFont"><input id="chk_group_<?php echo $user_groups[$i]['group_id'];?>" 
                                            type="checkbox" name="pfagos_user_group_reqired[]" 
                                            <?php if (@in_array($user_groups[$i]['group_id'], $_SESSION['pfagos_user_group_reqired'])):?>
                                             checked="checked"
                                            <?php endif;?>
                                            value="<?php echo $user_groups[$i]['group_id'];?>" />
                        <?php echo $user_groups[$i]['group_description'];?></label></div>
                    <?php endfor;?>                	
                <?php else:?>
					<?php for($i=0; $i<count($user_groups); $i++):?>
                        <div><label class="defaultFont"><input id="chk_group_<?php echo $user_groups[$i]['group_id'];?>" 
                                            type="checkbox" name="pfagos_user_group_reqired[]" 
                                            <?php if (@in_array($user_groups[$i]['group_id'], $owned_group_ids)):?>
                                              checked="checked"											  	
                                            <?php endif;?>                                              
                                            value="<?php echo $user_groups[$i]['group_id'];?>" />
                        <?php echo $user_groups[$i]['group_description'];?></label></div>
                    <?php endfor;?>
                <?php endif;?>
                </fieldset>
            </div>
            <br />
            <?php if (count($owned_group_ids) > 0):?>
            <div id="user_group_permissions_display">
                <fieldset>
                <legend><span class="defaultFont">Your current groups</span></legend>
				<?php for($i=0; $i<count($owned_group_ids); $i++):?>
                    <div><label class="defaultFont">:: <?php echo pfagos_users::grab_owned_user_gruop_name_for_given_group_id($owned_group_ids[$i]);?></label></div>
                <?php endfor;?>
                </fieldset>
            </div>
            <?php endif;?>
            </td></tr>
            </table>
		</div>
        </form>    
    </div>
</div>