<div id="static_header">
    <!-- Breadcrumb div message -->
    <?php echo $breadcrumb;?>
    <!--  End of the Breadcrumb div mesage -->    
    <div class="headerTopicContainer defaultFont boldText"><span class="headerTopicSelected"><div class="someWidth2 floatLeft"><!-- --></div><?php echo $fullDetails[0]['first_name']." ".$fullDetails[0]['last_name'];?></span></div>
      <div class="action-panel">
        <?php foreach($action_panel_menu as $eachMenu):?>                

            <?php if ($eachMenu['menu_text'] != "Details"):?>
            
				<?php if ($eachMenu['menu_text'] == "Drop"):?>                             
             
                    <a onclick="return ask_for_delete_record('<?php echo $site_config['base_url'];?>pfac/drop/?pfac_id=<?php echo $pfac_id;?>')"                                
                       title="<?php echo $eachMenu['menu_text'];?>" 
                       href=""><?php echo $eachMenu['menu_img'];?></a>                    

				<?php else:?>            

                    <a title="<?php echo $eachMenu['menu_text'];?>" 
                       href="<?php echo $eachMenu['menu_url'];?><?php echo ((strstr($eachMenu['menu_url'], "pfac/show")) || (strstr($eachMenu['menu_url'], "pfac/drop"))) ? 
                       "?" : "&";?>pfac_id=<?php echo $pfac_id.
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
            <div class="content-title"><a name="general" id="general">General Details</a></div>
            <div align="center">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0">
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
                                    <td><span class="defaultFont specializedTexts">Nationality</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ucwords($fullDetails[0]['nationality']);?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Player Category</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['player_category_name'];?></span></td>                            	
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Position</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['position'] != "") ? $fullDetails[0]['position'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Club</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['club'] != "") ? $fullDetails[0]['club'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Height</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['height'] != "") ? $fullDetails[0]['height']."&nbsp;<span class='smallFont'>(feet)</span>" : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Weight</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['weight'] != "") ? $fullDetails[0]['weight']."&nbsp;<span class='smallFont'>(kg)</span>" : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Comment</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont"><?php echo ($fullDetails[0]['comment'] != "") ? $fullDetails[0]['comment'] : "<span class='font-normal';'>- not available -</span>";?></span></td>
                                </tr>            
                            </table> 
                        </td>
                        <td><span class="defaultFont"><a href="#general" class="jumpingLinks"><!-- --></a></span></td>
                    </tr>
                 </table>       
              </div>
            <br /><br />
            <div class="content-title"><a name="contact" id="contact">Contact Details</a></div>
            <div align="center">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td width="140"><span class="defaultFont specializedTexts">Home Address</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td width="460"><span class="defaultFont boldText"><?php echo ($fullDetails[0]['home_address'] != "") ? $fullDetails[0]['home_address'] : "<span class='font-normal'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Home Phone</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['home_phone'] != "") ? $fullDetails[0]['home_phone'] : "<span class='font-normal'>- not available -</span>";?></span></td>
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Overseas Address</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['overseas_address'] != "") ? $fullDetails[0]['overseas_address'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Overseas Mobile</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['overseas_mobile'] != "") ? $fullDetails[0]['overseas_mobile'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                            	
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Email</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['email'] != "") ? $fullDetails[0]['email'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Passport No : </span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['passport_no'] != "") ? $fullDetails[0]['passport_no'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Exact Name on Passport</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['exact_name_on_passport'] != "") ? $fullDetails[0]['exact_name_on_passport'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td colspan="2"><div class="smallHeight2"><!-- --></div></td>
                                </tr>                
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Emergency Contact Name</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['emergency_contact_name'] != "") ? $fullDetails[0]['emergency_contact_name'] : "<span class='font-normal'>- not available -</span>";?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td colspan="2"><div class="smallHeight2"><!-- --></div></td>
                                </tr>                
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Emergency Contact No:</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['emergency_contact_no'] != "") ? $fullDetails[0]['emergency_contact_no'] : "<span class='font-normal'>- not available -</span>";?></span></td>                
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
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">CV :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php 
																				$ary = explode('_', $fullDetails[0]['cv_url'], 2);
																				$cv_name_real = $ary[1];
																				if ($fullDetails[0]['cv_url'] != ""){
																					echo '<div><a title="Download" href="'.$site_config['base_url'].'pfac/download/?where=cvs&pfac_id='.$pfac_id.'&filename='.$fullDetails[0]['cv_url'].'">'.$cv_name_real.'</a></div>';																					
																				 }else{
																				 	echo "<span class='font-normal';'>- not available -</span>";
																				 }	
																			?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td><span class="defaultFont specializedTexts">Photo :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php 
																				$ary = explode('_', $fullDetails[0]['photo_url'], 2);
																				$img_name_real = $ary[1];
																				if ($fullDetails[0]['photo_url'] != ""){
																					echo '<div><a title="Download" href="'.$site_config['base_url'].'pfac/download/?where=images&pfac_id='.$pfac_id.'&filename='.$fullDetails[0]['photo_url'].'">'.$img_name_real.'</a></div>';																					
																				 }else{
																				 	echo "<span class='font-normal';'>- not available -</span>";
																				 }	
																			?></span></td>                
                                </tr>
                                <tr valign="top">
                                    <td width="140"><span class="defaultFont specializedTexts">Video :</span></td>
                                    <td><div class="smallHeight"><!-- --></div></td>                
                                    <td><span class="defaultFont boldText"><?php 
																				if (strstr($fullDetails[0]['video_url'], "http://")){
																					echo '<a target="_blank" href="'.$fullDetails[0]['video_url'].'">'."Click to see your online video".'</a>';
																				}
																				else{
																					$ary = explode('_', $fullDetails[0]['video_url'], 2);
																					$video_name_real = $ary[1];
																					if ($fullDetails[0]['video_url'] != ""){
																						echo '<div><a title="Download" href="'.$site_config['base_url'].'pfac/download/?where=videos&pfac_id='.$pfac_id.'&filename='.$fullDetails[0]['video_url'].'">'.$video_name_real.'</a></div>';																					
																					 }else{
																						echo "<span class='font-normal';>- not available -</span>";
																					 }
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
            <div class="content-title"><a name="history" id="history">History Details</div>                
            <div align="center">
            <table border="0" cellpadding="0" cellspacing="0">                    	
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" class="tbs-main-pfac">              
                            <?php if (count($historyDetails > 0)):?>
                                <tr>
                                    <th width="350" align="center">Club</th>
                                    <th width="150" align="center">Appearances</th>
                                    <th width="150" align="center">Goals</th>
                                </tr>               
                                <?php for($i=0; $i<count($historyDetails); $i++):?>
                                <tr>
                                   <td width="350" align="left"><span class="defaultFont boldText"><?php echo $historyDetails[$i]['club'];?></span></td>
                                   <td width="150" align="left"><span class="defaultFont boldText"><?php echo $historyDetails[$i]['appearances'];?></span></td>
                                   <td width="150" align="left"><span class="defaultFont boldText"><?php echo ($historyDetails[$i]['goals'] != "") ? $historyDetails[$i]['goals'] : "--";?></span></td>
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
	catch(e)
	{
	}
</script>