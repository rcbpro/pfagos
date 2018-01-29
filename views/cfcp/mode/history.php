<form name="cfcp_history_form" method="post" action="<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? $_SERVER['REQUEST_URI'] : "";?>">
<div class="internalSurrounder">
    <div class="historyInputDiv" align="center">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2"><span class="defaultFont webRequiredIndicator">*&nbsp;</span><span class="defaultFont webRequiredIndicator smallFont">Need to publish</span><br /><br /></td>
            </tr>                                    
            <tr>
                <td width="140"><span class="defaultFont">Season&nbsp;&nbsp;&nbsp;</span><span class="defaultFont webRequiredIndicator">*&nbsp;</span></td>
                <td><input type="text" name="cfcp_history_reqired[season]" 
                	value="<?php echo (isset($_SESSION['cfcp_history_reqired']['season'])) ? stripcslashes(trim($_SESSION['cfcp_history_reqired']['season'])) : trim("");?>" class="inputs <?php echo (array_key_exists("season", $_SESSION['cfcp_reqired_errors'])) ? "errorsIndicatedFields" : ""; ?>" /></td>
            </tr>
            <tr>
                <td width="140"><span class="defaultFont">Team&nbsp;&nbsp;&nbsp;</span><span class="defaultFont webRequiredIndicator">*&nbsp;</span></td>
                <td><input type="text" name="cfcp_history_reqired[team]" 
                	value="<?php echo (isset($_SESSION['cfcp_history_reqired']['team'])) ? stripcslashes(trim($_SESSION['cfcp_history_reqired']['team'])) : trim("");?>" class="inputs <?php echo (array_key_exists("team", $_SESSION['cfcp_reqired_errors'])) ? "errorsIndicatedFields" : ""; ?>" /></td>
            </tr>
            <tr>                                       
                <td><span class="defaultFont">Appearances&nbsp;&nbsp;&nbsp;</span><span class="defaultFont webRequiredIndicator">*&nbsp;</span></td>            
                <td><input type="text" name="cfcp_history_reqired[appearances]" 
                			value="<?php echo (isset($_SESSION['cfcp_history_reqired']['appearances'])) ? stripcslashes(trim($_SESSION['cfcp_history_reqired']['appearances'])) : "";?>" 
                			class="inputs <?php echo (array_key_exists("appearances", $_SESSION['cfcp_reqired_errors'])) ? "errorsIndicatedFields" : trim(""); ?>" /></td>
            </tr>   
                <td><span class="defaultFont">Goals&nbsp;&nbsp;&nbsp;</span></td>                        
                <td><input type="text" name="cfcp_history_non_reqired[goals]" 
                	value="<?php echo (isset($_SESSION['cfcp_history_non_reqired']['goals'])) ? trim($_SESSION['cfcp_history_non_reqired']['goals']) : trim("");?>" class="inputs" /></td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>            
            <tr>            	
                <td class="a-center" colspan="3">
                <div align="center">
                    <input type="button" name="cfcp_back_other" value="Back to Other Details" class="inputs proceed submit" onclick="location.href='<?php echo $site_config['base_url'];?>cfcp/<?php echo (!strstr($_SERVER['REQUEST_URI'], "edit")) ? "add" : "edit";?>/?mode=other<?php echo (!strstr($_SERVER['REQUEST_URI'], "edit")) ? "" : "&cfcp_id=".$_GET['cfcp_id'].(isset($_GET['page']) ? "&page=".$_GET['page'] : "&page=1");?>'" />
                    <input type="submit" name="cfcp_history_submit" value="Add History Records" class="inputs submit" />
                </div>    
				</td>
            </tr>                    
        </table>
    </div>
    <br />
	<div align="center">
    	<?php if ($_SESSION['temm_id'] == 5):?>
			<?php if (!strstr($_SERVER['REQUEST_URI'], "edit")):?>
            <input type="button" id="cfcp_media_submit_preview" name="cfcp_media_submit_preview" value="Preview" class="inputs submit" onclick="javascript:popup1('<?php echo $site_config['base_url'];?>views/previews/preview-cfcp-add.php');" />                         				    
            <?php else:?>
            <input type="button" id="cfcp_media_submit_preview" name="cfcp_media_submit_preview" value="Preview" class="inputs submit" onclick="javascript:popup1('<?php echo $site_config['base_url'];?>views/previews/preview-cfcp-edit.php');" />                         				            
            <?php endif;?>        
        <?php endif;?>
    	 <?php if (strstr($_SERVER['REQUEST_URI'], "edit")):?>          
        <input type="submit" name="cfcp_player_save_submit" value="Proceed to Notes" class="inputs submit" />
        <?php else:?>    
        		<input type="submit" name="cfcp_player_save_submit" value="Save and Proceed to Notes" class="inputs proceed submit" />                
        <?php endif;?>
	</div><br />
    <div class="historyRecordsDisplayDiv" align="center">
        <table border="0" cellpadding="0" cellspacing="0" class="tbs-main-pfac">    	
        <?php if ((!empty($_SESSION['cfcp_session_data'])) || (!empty($fullDetails))):?>
            <tr>
                <th width="8"><span class="defaultFont"><!-- --></span></th>            
                <th width="250"><span class="defaultFont">Season</span></th>
                <th width="250"><span class="defaultFont">Team</span></th>
                <th width="150"><span class="defaultFont">Appearances</span></th>
                <th width="150"><span class="defaultFont">Goals</span></th>
            </tr>
        <?php endif;?>
		<?php 
			if (isset($_SESSION['cfcp_session_data'])){
				echo $history_details;
			}elseif (isset($fullDetails)){
				echo $history_details;
			}else{
				echo "";
			}
		?>            
        </table>
    </div>
<br />
</div>
</form>    