<div class="internalSurrounder">
<form name="pfac_history_form" method="post" action="<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? $_SERVER['REQUEST_URI'] : "";?>">
    <div class="historyInputDiv" align="center">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2"><span class="defaultFont webRequiredIndicator">*&nbsp;</span><span class="defaultFont webRequiredIndicator smallFont">Need to publish</span><br /><br /></td>
            </tr>                                    
            <tr>
                <td width="140"><span class="defaultFont">Club&nbsp;&nbsp;&nbsp;</span><span class="defaultFont webRequiredIndicator">*&nbsp;</span></td>
                <td><input type="text" name="pfac_coach_history_reqired[clubs]" 
                			value="<?php echo (isset($_SESSION['pfac_coach_history_reqired']['clubs'])) ? trim($_SESSION['pfac_coach_history_reqired']['clubs']) : trim("");?>" 
                            class="inputs <?php echo (array_key_exists("clubs", $_SESSION['pfac_reqired_errors'])) ? "errorsIndicatedFields" : ""; ?>" /></td>
            </tr>
            <tr>
                <td><span class="defaultFont">Position&nbsp;&nbsp;&nbsp;</span><span class="defaultFont webRequiredIndicator">*&nbsp;</span></td>                        
                <td><input type="text" name="pfac_coach_history_reqired[position]" 
                			value="<?php echo (isset($_SESSION['pfac_coach_history_reqired']['position'])) ? trim($_SESSION['pfac_coach_history_reqired']['position']) : trim("");?>" 
                            class="inputs <?php echo (array_key_exists("position", $_SESSION['pfac_reqired_errors'])) ? "errorsIndicatedFields" : ""; ?>" /></td>
            </tr>
            <tr>            	
                <td class="a-center" colspan="3">
        		<input type="button" name="pfac_history_back" value="Back to Contact Details" class="inputs proceed submit" 
                		onclick="location.href='<?php echo $site_config['base_url'];?>pfac/<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? "edit" : "add";?>/?mode=contact<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? "&pfac_id=".$_GET['pfac_id'] : "";?>'" />            
                <input type="submit" name="pfac_coach_history_submit" 
                                                        value="Add History Records" class="inputs submit"
                                                        <?php if (strstr($_SERVER['REQUEST_URI'], "edit")):?>
                                                            <?php if ($history_records_limit >= 4):?>                                                                        
                                                                  <?php echo "disabled='disabled'";?>
                                                            <?php endif;?> />
                                                        <?php else:?>
                                                            <?php if (count($_SESSION['session_data']) >= 4):?>                                                                        
                                                                  <?php echo "disabled='disabled'";?>
                                                            <?php endif;?> />
                                                        <?php endif;?>
				</td>
            </tr>                    
        </table>
    </div>
    <br />
    <div class="historyRecordsDisplayDiv" align="center">
        <table border="0" cellpadding="0" cellspacing="0" class="tbs-main-pfac">    	
        <?php if ((!empty($_SESSION['pfac_session_data'])) || (isset($fullDetails))):?>
            <tr>
                <th width="8"><span class="defaultFont"><!-- --></span></th>            
                <th width="200"><span class="defaultFont">Club</span></th>
                <th width="200"><span class="defaultFont">Position</span></th>
            </tr>
        <?php endif;?>
		<?php 
			if (isset($_SESSION['pfac_session_data'])){
				echo $history_details;
			}elseif (isset($fullDetails)){
				echo $history_details;
			}else{
				echo "";
			}
		?>            
        </table>
    </div>
</form>
<br /><br />
	<div align="center">
    	<form name="media_redirection_form" action="" method="post">
    	 <?php if (strstr($_SERVER['REQUEST_URI'], "edit")):?> 
            <?php if ($history_records_limit >= 1):?>
        <input type="submit" name="pfac_history_submit2" value="Go to Media View" class="inputs submit" onclick="location.href='<?php echo $site_config['base_url'];?>pfac/edit/?mode=edit-media&pfac_id=<?php echo $_GET['pfac_id'].((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1");?>'" />
            <?php endif;?>
        <?php else:?>    
        <input type="submit" name="pfac_history_submit2" value="Proceed to Media Details" class="inputs proceed submit" />
        <?php endif;?>
        </form>
	</div>
</div>