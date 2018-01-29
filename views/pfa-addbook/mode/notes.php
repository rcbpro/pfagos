<?php if ((@$_GET['opt'] != "view") && (@$_GET['opt'] != "edit")):?>
	<span class="defaultFont requiredFieldsIndicator">*&nbsp;</span><span class="defaultFont requiredFieldsIndicator smallFont">Required fields</span><br /><br />
<?php endif;?>
<form id="pfac_notes_submit_form" name="pfac_notes_submit_form" action="" method="post"> 
	<!-- Start of notes in its PFAC add section -->
	<?php if (!strstr($_SERVER['REQUEST_URI'], "edit")):?> 
		<div align="center">
            <div>
			<?php if (count($all_notes_to_this_client) > 0):?>
                <table border="0" cellpadding="0" cellspacing="0" align="center" class="tbs-main-pfac">
                <tr valign="middle">
                    <th width="50" align="center">Action</th>
                    <th width="350" align="center">Description</span></th>
                </tr>
                <?php foreach($all_notes_to_this_client as $note):?>
                <tr>
                    <td valign="middle" align="center"><a onclick="ask_for_delete_record('<?php echo $site_config['base_url'];?>pfa-addbook/add/?mode=notes&opt=drop&pfac_id=<?php echo $pfac_id;?>&note_id=<?php echo $note['note_id'];?>');" title="Drop" href="#"><img src="../../public/images/b_drop.png" border="0" alt="Drop" /></a></td>                            
                    <td><p class="note_description defaultFont"><?php echo $note['note']; ?></p></td>
                </tr>                                  
                <?php endforeach; ?>
                </table>
            <?php endif;?>
            </div>
        	<br />            
            <div>
                <table cellpadding="0" cellspacing="0" border="0" class="tbs-main-pfac">
                    <tr valign="middle">
                        <th width="400" align="center">Description</span></th>
                    </tr>
                    <tr>              
                        <td valign="top"><textarea class="noteTextArea" rows="6" name="pfa_addbook_note_required[note_text]"><?php if (!empty($_SESSION['pfa_addbook_note_required']['note_text'])){ echo trim($_SESSION['pfa_addbook_note_required']['note_text']);}?></textarea></td>
                    </tr>
                </table>
            </div>
        </div>
        <br /> 
        <div align="center"><input type="submit" name="pfa_addbook_notes_submit" class="inputs submit" value="Save note" />&nbsp;<input onclick="location.href='<?php echo $site_config['base_url'];?>pfa-addbook/view/'" type="button" name="pfa_addbook_notes_exit" class="inputs submit" value="Done" /></div>
		<!-- End of Notes in its PFAC add section -->            
		<!-- Start of Notes in its PFAC edit section -->
	<?php else:?>
		<?php if (!isset($_GET['opt'])):?>        
		<div align="center">
			<table border="0" cellpadding="0" cellspacing="0" align="center" class="tbs-main-pfac">
				<!-- New note adding in the pfac edit section -->
				<tr valign="middle">
					<th align="center">Description</th>
				</tr>
				<tr>
					<td align="center" valign="top" width="400"><textarea class="noteTextArea" rows="6" name="pfa_addbook_note_required[note_text]"><?php if (!empty($_SESSION['pfa_addbook_note_required']['note_text'])){ echo trim($_SESSION['pfa_addbook_note_required']['note_text']);}?></textarea></td>
				</tr>                                   
			</table>
		</div>
        <br />
        <div align="center"><input type="submit" name="pfa_addbook_notes_submit" class="inputs submit" value="Save note" />&nbsp;<input onclick="location.href='<?php echo $site_config['base_url'];?>pfa-addbook/view/'" type="button" name="pfa_notes_exit" class="inputs submit" value="Done" /></div>
		<!-- End of the PFAC Edit new note adding section -->
		<!-- If this client having notes -->
			<?php if (count($all_notes_to_this_client_in_edit) > 0):?>  
			<br /><br />
			<div class="someWidth5"><span class="defaultFont boldText">Your Previous Notes</span></div>
            <br />
            <div align="center">
                <table border="0" cellpadding="0" cellspacing="0" align="center" class="tbs-main-pfac">
                    <tr>
                        <th width="50" align="center"><div class="actionTableFieldTd">Action</div></th>            
                        <th width="350" align="center"><?php echo (count($all_notes_to_this_client_in_edit) > 1) ? "<a title=\"Sort By Description\" class=\"soringMenusLink\" href=\"?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Description ".((isset($_GET['sort']) && $_GET['sort'] == "desc") ? $img : "")."</a>" : "Description";?></a></th>
                        <th width="150" align="center"><?php echo (count($all_notes_to_this_client_in_edit) > 1) ? "<a title=\"Sort By Added Date and Time\" class=\"soringMenusLink\" href=\"?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=add_date".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Added Date and Time ".((isset($_GET['sort']) && $_GET['sort'] == "add_date") ? $img : "")."</a>" : "Added Date and Time";?></a></th>
                        <th width="100" align="center"><?php echo (count($all_notes_to_this_client_in_edit) > 1) ? "<a title=\"Sort By Added Person\" class=\"soringMenusLink\" href=\"?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=add_by".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Added By ".((isset($_GET['sort']) && $_GET['sort'] == "add_by") ? $img : "")."</a>" : "Added By";?></a></th>
                        <th width="150" align="center"><?php echo (count($all_notes_to_this_client_in_edit) > 1) ? "<a title=\"Sort By Modified Date and Time\" class=\"soringMenusLink\" href=\"?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=mod_date".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Modified Date and Time ".((isset($_GET['sort']) && $_GET['sort'] == "mod_date") ? $img : "")."</a>" : "Modified Date and Time";?></a></th>
                        <th width="100" align="center"><?php echo (count($all_notes_to_this_client_in_edit) > 1) ? "<a title=\"Sort By Modified Person\" class=\"soringMenusLink\" href=\"?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=mod_by".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Modified By ".((isset($_GET['sort']) && $_GET['sort'] == "mod_by") ? $img : "")."</a>" : "Modified By";?></a></th>
                    </tr>
                    <?php for($i=0; $i<count($all_notes_to_this_client_in_edit); $i++):?>
                    <tr>
                        <td width="50" align="center"><span class="defaultFont">
                                       <a title="Details" href="<?php echo $site_config['base_url'];?>pfa-addbook/edit/?mode=notes&opt=view&addbook_id=<?php echo $pfa_addbook_id;?><?php echo (isset($_GET['page'])) ? "&page=".$_GET['page'] : "";?>&note_id=<?php echo $all_notes_to_this_client_in_edit[$i]['note_id'].(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1");?>"><img src="../../public/images/b_browse.png" border="0" alt="Browse" /></a>                                   
                                       <a title="Edit" href="<?php echo $site_config['base_url'];?>pfa-addbook/edit/?mode=notes&opt=edit&addbook_id=<?php echo $pfa_addbook_id;?><?php echo (isset($_GET['page'])) ? "&page=".$_GET['page'] : "";?>&note_id=<?php echo $all_notes_to_this_client_in_edit[$i]['note_id'].(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1");?>"><img src="../../public/images/b_edit.png" border="0" alt="Edit" /></a>
                                       <a title="Drop" onclick="ask_for_delete_record('<?php echo $site_config['base_url'];?>pfa-addbook/edit/?mode=notes&opt=drop&addbook_id=<?php echo $pfa_addbook_id;?><?php echo (isset($_GET['page'])) ? "&page=".$_GET['page'] : "";?>&note_id=<?php echo $all_notes_to_this_client_in_edit[$i]['note_id'];?>');" href="#"><img src="../../public/images/b_drop.png" border="0" alt="Drop" /></a></span></td>
                        <td width="350" align="center"><p class="note_description defaultFont"><?php echo $all_notes_to_this_client_in_edit[$i]['note'];?></p></td>
                        <td width="150" align="center"><span class="defaultFont"><?php echo $all_notes_to_this_client_in_edit[$i]['date_added'];?></span></td>
                        <td width="100" align="center"><span class="defaultFont"><?php echo $pfac_addbook_model->grab_note_modified_or_added_person("added_by", $all_notes_to_this_client_in_edit[$i]['added_by']);?></span></td>
                        <td width="150" align="center"><span class="defaultFont"><?php echo ($all_notes_to_this_client_in_edit[$i]['date_modified'] != "0000-00-00 00:00:00") ? $all_notes_to_this_client_in_edit[$i]['date_modified'] : "--";?></span></td>
                        <td width="100" align="center"><span class="defaultFont"><?php echo ($all_notes_to_this_client_in_edit[$i]['modified_by'] != 0) ? $pfac_addbook_model->grab_note_modified_or_added_person("modified_by", $all_notes_to_this_client_in_edit[$i]['modified_by']) : "--";?></span></td>
                    </tr>					
                    <?php endfor;?>
                </table>
            </div>                 
			<?php endif;?> 
		<?php else:?>         
			<?php if ((isset($_GET['opt'])) && ($_GET['opt'] == "edit")):?>
				<!-- single note edit section -->
                <div align="center">
                    <table border="0" cellpadding="0" cellspacing="0" align="center" class="tbs-main-pfac">
                        <!-- New note adding in the pfac edit section -->
                        <tr valign="middle">
                            <th align="center">Description</th>
                            <th align="center">Date Added</th>
                            <th align="center">Added By</th>
                            <th align="center">Date Modified</th>                                                        
                            <th align="center">Modified By</th>                                                                                    
                        </tr>
                        <tr>
                            <td valign="top"><textarea class="noteTextArea defaultFont" rows="6" name="pfac_note_required[note_text]"><?php if (!empty($_SESSION['pfac_note_required']['note_text'])){ echo trim($_SESSION['pfac_note_required']['note_text']);} else { echo $note_full_details[0]['note'];}?></textarea></td>
                            <td valign="middle"><?php echo $note_full_details[0]['date_added'];?></td>
                            <td valign="middle"><?php echo $pfac_addbook_model->grab_note_modified_or_added_person("added_by", $note_full_details[0]['added_by']);?></td>
                            <td valign="middle"><?php echo ($note_full_details[0]['date_modified'] != "0000-00-00 00:00:00") ? $note_full_details[0]['date_modified'] : "--";?></td>
                            <td valign="middle"><?php echo ($note_full_details[0]['modified_by'] != 0) ? $pfac_addbook_model->grab_note_modified_or_added_person("modified_by", $note_full_details[0]['modified_by']) : "--";?></td>
                        </tr>
                    </table>
                </div>
            <br />
            <div align="center"><input type="submit" name="pfac_notes_update_submit" class="inputs submit" value="Update" /></div>
			<?php elseif ((isset($_GET['opt'])) && ($_GET['opt'] == "view")):?>
				<!-- single note show section -->   
                <div align="center">             	
				<table border="0" cellpadding="0" cellspacing="0" align="center" class="tbs-main-pfac">
					<tr valign="top">
						<td colspan="3">&nbsp;</td>
					</tr>                        
					<tr valign="top">
						<td width="150"><span class="defaultFont specializedTexts">Description</span></td>
                        <td>:</td>
						<td width="250"><span class="defaultFont boldText"><?php echo $note_full_details[0]['note'];?></span></td>                
					</tr>
					<tr valign="top">
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr valign="top">
						<td width="150"><span class="defaultFont specializedTexts">Date Created</span></td>
                        <td width="30">:</td>
						<td width="150"><span class="defaultFont boldText"><?php echo $note_full_details[0]['date_added'];?></span></td>                
					</tr>
					<tr valign="top">
						<td colspan="3">&nbsp;</td>
					</tr>                        
					<tr valign="top">
						<td width="150"><span class="defaultFont specializedTexts">Creadted by</span></td>
                        <td>:</td>
						<td width="150"><span class="defaultFont boldText"><?php echo $pfac_addbook_model->grab_note_modified_or_added_person("added_by", $note_full_details[0]['added_by']);?></span></td>                
					</tr> 
					<tr valign="top">
						<td colspan="3">&nbsp;</td>
					</tr> 
					<tr valign="top">
						<td width="150"><span class="defaultFont specializedTexts">Date Modified</span></td>
                        <td width="30">:</td>
						<td width="150"><span class="defaultFont boldText"><?php echo ($note_full_details[0]['date_modified'] != "0000-00-00 00:00:00") ? $note_full_details[0]['date_modified'] : "--";?></span></td>                
					</tr>
					<tr valign="top">
						<td colspan="3">&nbsp;</td>
					</tr>                        
					<tr valign="top">
						<td width="150"><span class="defaultFont specializedTexts">Modified by</span></td>
                        <td>:</td>
						<td width="150"><span class="defaultFont boldText"><?php echo ($note_full_details[0]['modified_by'] != 0) ? $pfac_addbook_model->grab_note_modified_or_added_person("modified_by", $note_full_details[0]['modified_by']) : "--";?></span></td>                
					</tr> 
					<tr valign="top">
						<td colspan="3">&nbsp;</td>
					</tr>                        
				</table>
                </div>
			<?php elseif ((isset($_GET['opt'])) && (($_GET['opt'] == "sorting") || ($_GET['opt'] == "drop"))):?>
				<?php if (count($all_notes_to_this_client_in_edit) > 0):?>    
                <div align="center">
                    <table border="1" cellpadding="0" cellspacing="0" align="center" class="collapse-boder tbs-main-pfac">
                        <!-- New note adding in the pfac edit section -->
                        <tr valign="middle">
                            <th align="center"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span>Note Category</th>
                            <th align="center"><span class="defaultFont requiredFieldsIndicator">*&nbsp;</span>Description</th>
                        </tr>
                        <tr>
                            <td class="a-left"><?php for($i=0; $i<count($notes_categories); $i++):?>	
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input <?php if ((!empty($_SESSION['pfac_note_required']['note_cat'])) && ($_SESSION['pfac_note_required']['note_cat'] == $notes_categories[$i]['id'])) { echo "checked=\"checked\"";}?> type="radio" id="note_<?php echo strtolower($notes_categories[$i]['note_cat_name']);?>" name="pfac_note_required[note_cat]" value="<?php echo $notes_categories[$i]['id'];?>" /><span class="defaultFont"><?php echo ucfirst($notes_categories[$i]['note_cat_name']);?></span></label><br />
                                <?php endfor;?>
                            </td>        
                            <td valign="top"><textarea class="noteTextArea" rows="6" name="pfac_note_required[note_text]"><?php if (!empty($_SESSION['pfac_note_required']['note_text'])){ echo trim($_SESSION['pfac_note_required']['note_text']);}?></textarea></td>
                        </tr>                                   
                    </table>
                </div>
                <br />
                <div align="center"><input type="submit" name="pfac_notes_submit" class="inputs submit" value="Save" /></div>
				<div class="smallHeight"><!-- --></div>                            
                <div class="someWidth5 text-center-align"><span class="defaultFont specializedTexts boldText">Your Previous Notes</span></div>                    
                <div class="smallHeight"><!-- --></div>                
                <div align="center">                
                <table border="0" cellpadding="0" cellspacing="0" align="center" class="tbs-main-pfac">
                    <tr>
                        <th width="50" align="center"><div class="actionTableFieldTd">Action</div></th>            
                        <th width="350" align="center"><?php echo (count($all_notes_to_this_client_in_edit) > 1) ? "<a title=\"Sort By Description\" class=\"soringMenusLink\" href=\"?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Description ".((isset($_GET['sort']) && $_GET['sort'] == "desc") ? $img : "")."</a>" : "Description";?></a></th>
                        <th width="150" align="center"><?php echo (count($all_notes_to_this_client_in_edit) > 1) ? "<a title=\"Sort By Added Date and Time\" class=\"soringMenusLink\" href=\"?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=add_date".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Added Date and Time ".((isset($_GET['sort']) && $_GET['sort'] == "add_date") ? $img : "")."</a>" : "Added Date and Time";?></a></th>
                        <th width="100" align="center"><?php echo (count($all_notes_to_this_client_in_edit) > 1) ? "<a title=\"Sort By Added Person\" class=\"soringMenusLink\" href=\"?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=add_by".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Added By ".((isset($_GET['sort']) && $_GET['sort'] == "add_by") ? $img : "")."</a>" : "Added By";?></a></th>
                        <th width="150" align="center"><?php echo (count($all_notes_to_this_client_in_edit) > 1) ? "<a title=\"Sort By Modified Date and Time\" class=\"soringMenusLink\" href=\"?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=mod_date".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Modified Date and Time ".((isset($_GET['sort']) && $_GET['sort'] == "mod_date") ? $img : "")."</a>" : "Modified Date and Time";?></a></th>
                        <th width="100" align="center"><?php echo (count($all_notes_to_this_client_in_edit) > 1) ? "<a title=\"Sort By Modified Person\" class=\"soringMenusLink\" href=\"?mode=notes&addbook_id=".$pfa_addbook_id."&opt=sorting&sort=mod_by".(isset($_GET['page']) ? "&page=".$_GET['page'] : "").(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1")."\">Modified By ".((isset($_GET['sort']) && $_GET['sort'] == "mod_by") ? $img : "")."</a>" : "Modified By";?></a></th>
                    </tr>
                    <?php for($i=0; $i<count($all_notes_to_this_client_in_edit); $i++):?>
                    <tr>
                        <td width="50" align="center"><span class="defaultFont">
                                       <a title="Details" href="<?php echo $site_config['base_url'];?>pfa-addbook/edit/?mode=notes&opt=view&addbook_id=<?php echo $pfa_addbook_id;?><?php echo (isset($_GET['page'])) ? "&page=".$_GET['page'] : "";?>&note_id=<?php echo $all_notes_to_this_client_in_edit[$i]['note_id'].(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1");?>"><img src="../../public/images/b_browse.png" border="0" alt="Browse" /></a>                                   
                                       <a title="Edit" href="<?php echo $site_config['base_url'];?>pfa-addbook/edit/?mode=notes&opt=edit&addbook_id=<?php echo $pfa_addbook_id;?><?php echo (isset($_GET['page'])) ? "&page=".$_GET['page'] : "";?>&note_id=<?php echo $all_notes_to_this_client_in_edit[$i]['note_id'].(isset($_GET['notes_page']) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1");?>"><img src="../../public/images/b_edit.png" border="0" alt="Edit" /></a>
                                       <a title="Drop" onclick="ask_for_delete_record('<?php echo $site_config['base_url'];?>pfa-addbook/edit/?mode=notes&opt=drop&addbook_id=<?php echo $pfa_addbook_id;?><?php echo (isset($_GET['page'])) ? "&page=".$_GET['page'] : "";?>&note_id=<?php echo $all_notes_to_this_client_in_edit[$i]['note_id'];?>');" href="#"><img src="../../public/images/b_drop.png" border="0" alt="Drop" /></a></span></td>
                        <td width="350" align="center"><p class="note_description defaultFont"><?php echo $all_notes_to_this_client_in_edit[$i]['note'];?></p></td>
                        <td width="150" align="center"><span class="defaultFont"><?php echo $all_notes_to_this_client_in_edit[$i]['date_added'];?></span></td>
                        <td width="100" align="center"><span class="defaultFont"><?php echo $pfac_addbook_model->grab_note_modified_or_added_person("added_by", $all_notes_to_this_client_in_edit[$i]['added_by']);?></span></td>
                        <td width="150" align="center"><span class="defaultFont"><?php echo ($all_notes_to_this_client_in_edit[$i]['date_modified'] != "0000-00-00 00:00:00") ? $all_notes_to_this_client_in_edit[$i]['date_modified'] : "--";?></span></td>
                        <td width="100" align="center"><span class="defaultFont"><?php echo ($all_notes_to_this_client_in_edit[$i]['modified_by'] != 0) ? $pfac_addbook_model->grab_note_modified_or_added_person("modified_by", $all_notes_to_this_client_in_edit[$i]['modified_by']) : "--";?></span></td>
                    </tr>					
                    <?php endfor;?>
                </table>
                </div>
                <?php endif;?>   
			<?php endif;?>
		<?php endif;?>                       
		<!-- End of the notes set display section  -->
	<?php endif;?> 
	<!-- End of the PFAC Edit note section -->          
</form>