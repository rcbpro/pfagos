<div id="static_header">
    <!-- Breadcrumb div message -->
    <?php echo $breadcrumb;?>
    <!--  End of the Breadcrumb div mesage -->
    <div class="headerTopicContainer defaultFont boldText"><span class="headerTopicSelected"><div class="someWidth2 floatLeft"><!-- --></div><?php echo $fullDetails[0]['first_name']." ".$fullDetails[0]['last_name'];?></span></div>    
      <div class="action-panel">
        <?php foreach($action_panel_menu as $eachMenu):?>                

            <?php if ($eachMenu['menu_text'] != "Details"):?>
            
				<?php if ($eachMenu['menu_text'] == "Drop"):?>                             
             
                    <a onclick="return ask_for_delete_record('<?php echo $site_config['base_url'];?>cfcp/drop/?cfcp_id=<?php echo $cfcp_id;?>')"                                
                       title="<?php echo $eachMenu['menu_text'];?>" 
                       href=""><?php echo $eachMenu['menu_img'];?></a>                    

				<?php else:?>            

                    <a title="<?php echo $eachMenu['menu_text'];?>" 
                       href="<?php echo $eachMenu['menu_url'];?><?php echo ((strstr($eachMenu['menu_url'], "cfcp/show")) || (strstr($eachMenu['menu_url'], "cfcp/drop"))) ? 
                       "?" : "&";?>cfcp_id=<?php echo $cfcp_id.
                       (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
                       (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    
                       
                <?php endif;?>       
                   
             <?php endif;?>      

        <?php endforeach;?>
    </div>
</div>
<div id="dataInputContainer_wrap">
    <div class="dataInputContainer">
        <div class="pfacTableDatContainer">
        	<div class="content-title"><a id="general" name="general">General Details</a></div>
            <div align="center">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td width="140"><span class="defaultFont specializedTexts">Team Name</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td width="460"><span class="defaultFont boldText"><?php echo $fullDetails[0]['team_name'];?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td width="140"><span class="defaultFont specializedTexts">Name</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td width="460"><span class="defaultFont boldText"><?php echo $fullDetails[0]['first_name']." ".$fullDetails[0]['last_name'];?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Date of Birth</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo App_Viewer::format_date($fullDetails[0]['date_of_birth']);?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Nickname 1</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['nickname1'] != "") ?  $fullDetails[0]['nickname1'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Nickname 2</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['nickname2'] != "") ? $fullDetails[0]['nickname2'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Player Category</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['player_category_name'] != "") ?  $fullDetails[0]['player_category_name'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                            	
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Date Created</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo App_Viewer::format_date($fullDetails[0]['date_created']);?></span></td>                
                                </tr>
                            </table> 
                        </td>
                        <td><span class="defaultFont"><a href="#general" class="jumpingLinks"><!-- --></a></span></td>
                    </tr>
                 </table>       
            </div>
            <?php if ($fullDetails[0]['team_name'] == "Senior Team"):?>
            <br /><br />
            <div class="content-title"><a id="senior" name="senior">Senior Player Details</a></div>
            <div align="center">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td width="140"><span class="defaultFont specializedTexts">Player Category</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td width="460"><span class="defaultFont boldText"><?php echo $fullDetails[0]['player_category_name'];?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Place of Birth</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['place_of_birth'];?></span></td>
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Senior Player Position</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['seniorPos'];?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Height</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['height'];?></span>&nbsp;<span class="smallFont">(feets)</span></td>                            	
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Weight</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['weight'];?></span>&nbsp;<span class="smallFont">(kg)</span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Description</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont"><?php echo ($fullDetails[0]['description'] != "") ? $fullDetails[0]['description'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Coach's Comment</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont"><?php echo ($fullDetails[0]['coach_comment'] != "") ? $fullDetails[0]['coach_comment'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                            </table> 
                        </td>
                        <td><span class="defaultFont"><a href="#general" class="jumpingLinks"><!-- --></a></span></td>
                    </tr>
                 </table>       
            </div> 
            <?php endif;?>  
            <br />          
            <div class="content-title"><a id="contact" name="contact">Contact Details</a></div>
            <div align="center">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td width="140"><span class="defaultFont specializedTexts">Home Address</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td width="460"><span class="defaultFont boldText"><?php echo $fullDetails[0]['home_address'];?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Mobile No : </span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['mobile_no'] != "") ? $fullDetails[0]['mobile_no'] : "<span class='font-normal';'>- not available -</span>";?></span></td>
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Email</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['email'] != "") ? $fullDetails[0]['email'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Father's Name</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['father_name'] != "") ? $fullDetails[0]['father_name'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                            	
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Father's Contact No :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['father_contact_no'] != "") ? $fullDetails[0]['father_contact_no'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Father's Occupation</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['father_occupation'] != "") ? $fullDetails[0]['father_occupation'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Mother's Name</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['mother_name'] != "") ? $fullDetails[0]['mother_name'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Mother's Contact No :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['mother_contact_no'] != "") ? $fullDetails[0]['mother_contact_no'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Mother's Occupation</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['mother_occupation'] != "") ? $fullDetails[0]['mother_occupation'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Parent's Address</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['parents_address'] != "") ? $fullDetails[0]['parents_address'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Passport No :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['passport_no'] != "") ? $fullDetails[0]['passport_no'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Exact Name on Passport</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['exact_name_passport'] != "") ? $fullDetails[0]['exact_name_passport'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                            </table> 
                        </td>
                        <td><span class="defaultFont"><a href="#general" class="jumpingLinks"><!-- --></a></span></td>
                    </tr>
                 </table>       
            </div>
            <br />
            <div class="content-title"><a id="contact" name="contact">Uploads</a></div>
            <div align="center">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="625">
                            <table border="0" cellpadding="0" cellspacing="0">
                            	<?php if ($fullDetails[0]['photo_url'] != ""):?>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Photo :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php 
																				$ary = explode('_', $fullDetails[0]['photo_url'], 2);
																				$img_name_real = $ary[1];
																				if ($fullDetails[0]['photo_url'] != ""){
																					echo '<div><a title="Download" href="'.$site_config['base_url'].'cfcp/download/?where=images&cfcp_id='.$cfcp_id.'&filename='.$fullDetails[0]['photo_url'].'">'.$img_name_real.'</a></div>';																					
																				 }else{
																				 	echo "<span class='font-normal';'>- not available -</span>";
																				 }	
																			?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Video :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php 
																				$ary = explode('_', $fullDetails[0]['video_url'], 2);
																				$video_name_real = $ary[1];
																				if ($fullDetails[0]['video_url'] != ""){
																					echo '<div><a title="Download" href="'.$site_config['base_url'].'cfcp/download/?where=videos&cfcp_id='.$cfcp_id.'&filename='.$fullDetails[0]['video_url'].'">'.$video_name_real.'</a></div>';																					
																				 }else{
																				 	echo "<span class='font-normal';'>- not available -</span>";
																				 }	
																			?></span></td>                
                                </tr>
                            	<?php endif;?>
                                <tr valign="top">
                                    <td width="140"><span class="defaultFont specializedTexts">Passport Scan :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php 
																				$ary = explode('_', $fullDetails[0]['passport_scan_url'], 2);
																				$ps_name_real = $ary[1];
																				if ($fullDetails[0]['passport_scan_url'] != ""){
																					echo '<div><a title="Download" href="'.$site_config['base_url'].'cfcp/download/?where=passport_scans&cfcp_id='.$cfcp_id.'&filename='.$fullDetails[0]['passport_scan_url'].'">'.$ps_name_real.'</a></div>';																					
																				 }else{
																				 	echo "<span class='font-normal';>- not available -</span>";
																				 }	
																			?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Birth Certificate :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php 
																				$ary = explode('_', $fullDetails[0]['birth_certificate_url'], 2);
																				$bc_name_real = $ary[1];
																				if ($fullDetails[0]['birth_certificate_url'] != ""){
																					echo '<div><a title="Download" href="'.$site_config['base_url'].'cfcp/download/?where=birth_certificates&cfcp_id='.$cfcp_id.'&filename='.$fullDetails[0]['birth_certificate_url'].'">'.$bc_name_real.'</a></div>';																					
																				 }else{
																				 	echo "<span class='font-normal';'>- not available -</span>";
																				 }	
																			?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Registration Card :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php 
																				$ary = explode('_', $fullDetails[0]['reg_card_url'], 2);
																				$reg_name_real = $ary[1];
																				if ($fullDetails[0]['reg_card_url'] != ""){
																					echo '<div><a title="Download" href="'.$site_config['base_url'].'cfcp/download/?where=reg_cards&cfcp_id='.$cfcp_id.'&filename='.$fullDetails[0]['reg_card_url'].'">'.$reg_name_real.'</a></div>';																					
																				 }else{
																				 	echo "<span class='font-normal';'>- not available -</span>";
																				 }	
																			?></span></td>                
                                </tr>
                            </table> 
                        </td>
                        <td><span class="defaultFont"><a href="#general" class="jumpingLinks"><!-- --></a></span></td>
                    </tr>
                 </table>       
            </div> 
			<br />
            <div class="content-title"><a id="other" name="other">Other Details</a></div>
            <div align="center">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td width="140"><span class="defaultFont specializedTexts">School</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td width="460"><span class="defaultFont boldText"><?php echo $fullDetails[0]['school'];?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Current Class</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['current_class'];?></span></td>
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Boot Size</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['boot_size'] != "") ? $fullDetails[0]['boot_size'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Boots Received</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['boots_received'] != "0000-00-00") ? $fullDetails[0]['boots_received'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                            	
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Position 1</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['position1'];?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Position 2</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['position2'] != "") ? $fullDetails[0]['position2'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Registration Card</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['registration_card_status'];?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Coach's Comment</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont"><?php echo ($fullDetails[0]['coach_comment'] != "") ? $fullDetails[0]['coach_comment'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                            </table> 
                        </td>
                        <td><span class="defaultFont"><a href="#general" class="jumpingLinks"><!-- --></a></span></td>
                    </tr>
                 </table>       
            </div> 
            <br />           
            <div class="content-title"><a id="history" name="history">History Details</a></div>                
            <div align="center">
                <table border="0" cellpadding="0" cellspacing="0" class="">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" class="tbs-main-pfac">              
                                <?php if (count($historyDetails > 0)):?>
                                    <tr>
                                        <th width="250" align="center">Season</th>
                                        <th width="150" align="center">Teams</th>                                        
                                        <th width="150" align="center">Appearances</th>
                                        <th width="80" align="center">Goals</th>
                                    </tr>             
                                    <?php for($i=0; $i<count($historyDetails); $i++):?>
                                    <tr>
                                       <td width="250" align="left"><span class="defaultFont boldText"><?php echo $historyDetails[$i]['season'];?></span></td>
                                       <td width="150" align="left"><span class="defaultFont boldText"><?php echo $historyDetails[$i]['team'];?></span></td>
                                       <td width="150" align="left"><span class="defaultFont boldText"><?php echo $historyDetails[$i]['appearances'];?></span></td>                                       
                                       <td width="80" align="left"><span class="defaultFont boldText"><?php echo ($historyDetails[$i]['goals'] != "") ? $historyDetails[$i]['goals'] : "--";?></span></td>
                                    </tr>
                                    <?php endfor;?>
                                <?php endif;?>
                            </table>
                        </td>
                        <td><span class="defaultFont"><a href="#general" class="jumpingLinks"><!-- --></a></span></td>
                    </tr>
                 </table>       
            </div>
            <br /><br />
            <div id="bottomLastInfoDiv"><span class="defaultFont specializedTexts"><a target="_top" class="browse-url defaultFont" href="<?php echo $fullDetails[0]['webpage_url'];?>">Browse to Player's web page for video and more...</a></span></div>
        </div>
    </div>
</div>
<script type="text/javascript">
try{
   //prevent the "normal" behaviour which would be a "hard" jump
   //Get the target
   var target = window.location.hash;
   //perform animated scrolling
   $('html,body').animate(
   {
	   //get top-position of target-element and set it as scroll target
	   scrollTop: $(target).offset().top
	   //scrolldelay: 2 seconds
   },500,function()
   {
	   //attach the hash (#jumptarget) to the pageurl
	   location.hash = target;
   });
}
catch (e)
{
}
</script>