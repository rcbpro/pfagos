<div id="static_header">
    <!-- Breadcrumb div message -->
    <?php echo $breadcrumb;?>
    <!--  End of the Breadcrumb div mesage -->
    <div class="headerTopicContainer defaultFont boldText"><span class="headerTopicSelected"><div class="someWidth2 floatLeft"><!-- --></div><?php echo ucwords($fullDetails[0]['first_name'])." ".ucwords($fullDetails[0]['last_name']);?></span>    </div>
      <div class="action-panel">
        <?php foreach($action_panel_menu as $eachMenu):?>                

            <?php if ($eachMenu['menu_text'] != "Details"):?>
            
				<?php if ($eachMenu['menu_text'] == "Drop"):?>                             
             
                    <a onclick="return ask_for_delete_record('<?php echo $site_config['base_url'];?>pfa_addbook/drop/?addbook_id=<?php echo $addbook_id;?>')"                                
                       title="<?php echo $eachMenu['menu_text'];?>" 
                       href=""><?php echo $eachMenu['menu_img'];?></a>                    

				<?php else:?>            

                    <a title="<?php echo $eachMenu['menu_text'];?>" 
                       href="<?php echo $eachMenu['menu_url'];?><?php echo ((strstr($eachMenu['menu_url'], "pfa_addbook/show")) || (strstr($eachMenu['menu_url'], "pfa_addbook/drop"))) ? 
                       "?" : "&";?>addbook_id=<?php echo $addbook_id.
                       (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
                       (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    
                       
                <?php endif;?>       
                   
             <?php endif;?>      

        <?php endforeach;?>
    </div>
</div>
<div id="dataInputContainer_wrap">
    <div class="dataInputContainer" align="center">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr valign="top">
                <td width="200"><span class="defaultFont specializedTexts">Name</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['first_name']." ".$fullDetails[0]['last_name'];?></span></td>                
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Address Book Category Type</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['Client_category_name'];?></span></td>                            	
            </tr>        
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Nationality</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['nationality'];?></span></td>                
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Location</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['location'] != "") ? $fullDetails[0]['location'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Ability of Spoken English</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['ability_of_english'] != "") ? $fullDetails[0]['ability_of_english'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Prefered Language</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['pref_language'] != "") ? $fullDetails[0]['pref_language'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Organization</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['organization'] != "") ? $fullDetails[0]['organization'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Position</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['position'];?></span></td>                
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Address</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['address'] != "") ? $fullDetails[0]['address'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Phone</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['phone'] != "") ? $fullDetails[0]['phone'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                            	
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Mobile</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['mobile'] != "") ? $fullDetails[0]['mobile'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Fax</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['fax'] != "") ? $fullDetails[0]['fax'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
            </tr>
            <tr valign="top">
                <td><span class="defaultFont specializedTexts">Email</span></td>
                <td><div class="smallHeight defaultFont">:</div></td>    
                <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['email'] != "") ?  $fullDetails[0]['email'] : "<span class='font-normal';'>- not available -</span>";?></span></td>                
            </tr>
        </table> 
    </div>
</div>