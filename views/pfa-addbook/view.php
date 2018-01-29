<div id="static_header">
    <!-- Breadcrumb div message -->
    <?php echo $breadcrumb;?>
    <!--  End of the Breadcrumb div mesage -->
    <!-- This is the success/error message to be diplayed -->
    <?php global $headerDivMsg; echo $headerDivMsg;?>
    <!-- End of the success or error message -->
    <div class="headerTopicContainer defaultFont boldText">
        <?php if ($tot_page_count != 0):?>    
			<div class="out-of">Page <?php echo $cur_page;?> of <?php echo $tot_page_count;?></div>   
        <?php endif;?>  
        <span class="headerTopicSelected">All Address Book Contacts</span>
    </div>
</div>
<div id="dataInputContainer_wrap">
    <div class="dataInputContainer">
        <div id="pfacTableDatContainer" align="center">
           <?php if ($invalidPage != true):?>           
            <table border="0" cellpadding="0" cellspacing="0" class="tbs-main-address-book">
                <thead>
                    <th><div class="actionTableFieldTd"><span class="defaultFont">Action</span></div></th>            
                    <th width="200"><span class="defaultFont"><?php echo ($all_pfa_addbook_contacts_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Name </a>".
                                                                    (((isset($_GET['sort']) && $_GET['sort'] == "f_name") || (isset($_GET['sort']) && $_GET['sort'] == "l_name")) ? $img : "").
                                                                    "<br /><a class=\"soringMenusLink\" href=\"?sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\">First Name </span></a>".
                                                                    ((isset($_GET['sort']) && $_GET['sort'] == "f_name") ? $img : "").
                                                                    "|<a class=\"soringMenusLink\" href=\"?sort=l_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\"> Last Name </span></a>".
                                                                    ((isset($_GET['sort']) && $_GET['sort'] == "l_name") ? $img : "")."" : "Name";?></span></th>
                    <th width="150"><span class="defaultFont"><?php echo ($all_pfa_addbook_contacts_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=addbook_cat".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Address Book Category ".((isset($_GET['sort']) && $_GET['sort'] == "addbook_cat") ? $img : "")."</a>" : "Address Book Category";?></a></span></th>
                    <th width="150"><span class="defaultFont"><?php echo ($all_pfa_addbook_contacts_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=nation".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Nationality </a>".((isset($_GET['sort']) && $_GET['sort'] == "nation") ? $img : "")."" : "Nationality";?></span></th>                                                                                                
                    <th width="150"><span class="defaultFont"><?php echo ($all_pfa_addbook_contacts_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=loc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Location </a>".((isset($_GET['sort']) && $_GET['sort'] == "loc") ? $img : "")."" : "Location";?></span></td>                                                               
                    <th width="120"><span class="defaultFont"><?php echo ($all_pfa_addbook_contacts_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=pref".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Prefered Language ".((isset($_GET['sort']) && $_GET['sort'] == "pref") ? $img : "")."</a>" : "Prefered Language";?></a></span></th>
                    <th width="150"><span class="defaultFont"><?php echo ($all_pfa_addbook_contacts_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=eng".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Ability of English </a>".((isset($_GET['sort']) && $_GET['sort'] == "eng") ? $img : "")."" : "Ability of English";?></span></th>                                                                                                
                    <th width="150"><span class="defaultFont"><?php echo ($all_pfa_addbook_contacts_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=org".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Organization </a>".((isset($_GET['sort']) && $_GET['sort'] == "org") ? $img : "")."" : "Organization";?></span></td>                                                               
                </thead>
                <?php for($i=0; $i<count($all_pfa_addbook_contacts); $i++):?>
                <tr class="lineHeight">
                    <td>
                    
                    <?php foreach($action_panel_menu as $eachMenu):?>                
                    
						<?php if ($eachMenu['menu_text'] == "Drop"):?>                             
                     
                            <a onclick="return ask_for_delete_record('<?php echo $site_config['base_url'];?>pfa-addbook/drop/?addbook_id=<?php echo $all_pfa_addbook_contacts[$i]['id'];?>')"                                
                               title="<?php echo $eachMenu['menu_text'];?>" 
                               href=""><?php echo $eachMenu['menu_img'];?></a>                    

                        <?php else:?>                          

                            <a title="<?php echo $eachMenu['menu_text'];?>" 
                               href="<?php echo $eachMenu['menu_url'];?><?php echo ((strstr($eachMenu['menu_url'], "pfa-addbook/show")) || (strstr($eachMenu['menu_url'], "pfa-addbook/drop"))) ? 
                               "?" : "&";?>addbook_id=<?php echo $all_pfa_addbook_contacts[$i]['id'].
                               (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
                               (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    
                               
						<?php endif;?>                               
                    	
                    <?php endforeach;?></td>
                    <td width="200"><span title="<?php echo $all_pfa_addbook_contacts[$i]['first_name'] . " " . $all_pfa_addbook_contacts[$i]['last_name'];?>" class="defaultFont"><?php echo $all_pfa_addbook_contacts[$i]['first_name'];?></span>&nbsp;<span class="defaultFont"><?php echo $all_pfa_addbook_contacts[$i]['last_name'];?></span></td>
                    <td width="150"><span title="<?php echo $all_pfa_addbook_contacts[$i]['Client_category_name'];?>" class="defaultFont"><?php echo $all_pfa_addbook_contacts[$i]['Client_category_name'];?></span></td>                
                    <td width="150"><span title="<?php echo $all_pfa_addbook_contacts[$i]['nationality'];?>" class="defaultFont"><?php echo ($all_pfa_addbook_contacts[$i]['nationality'] != "") ? ucfirst($all_pfa_addbook_contacts[$i]['nationality']) : "--";?></span></td>                                                            
                    <td width="150"><span title="<?php echo $all_pfa_addbook_contacts[$i]['location'];?>" class="defaultFont"><?php echo ($all_pfa_addbook_contacts[$i]['location'] != "") ? ucfirst($all_pfa_addbook_contacts[$i]['location']) : "--";?></span></td>                               
                    <td width="120"><span title="<?php echo $all_pfa_addbook_contacts[$i]['pref_language'];?>" class="defaultFont"><?php echo ($all_pfa_addbook_contacts[$i]['pref_language'] != "") ? $all_pfa_addbook_contacts[$i]['pref_language'] : "--";?></span></td>                
                    <td width="150"><span title="<?php echo $all_pfa_addbook_contacts[$i]['ability_of_english'];?>" class="defaultFont"><?php echo ($all_pfa_addbook_contacts[$i]['ability_of_english'] != "") ? $all_pfa_addbook_contacts[$i]['ability_of_english'] : "--";?></span></td>                                                            
                    <td width="150"><span title="<?php echo $all_pfa_addbook_contacts[$i]['organization'];?>" class="defaultFont"><?php echo ($all_pfa_addbook_contacts[$i]['organization'] != "") ? $all_pfa_addbook_contacts[$i]['organization'] : "--";?></span></td>                               
                </tr>					
                <?php endfor;?>
            </table>
            <?php else:?>  
	            <div class="someWidth6 floatLeft"><span class="defaultFont boldText specializedTexts">&nbsp;&nbsp;No Records !</span></div>
			<?php endif;?>                  
        </div>
    </div>
</div>
<?php if ($invalidPage != true):?>
	<?php if ($tot_page_count > 1):?>   
    <div id="pagination_wrap">
        <div id="pagination" align="center">
    <!-- This is the page jumping secte box and at the moment it has been disbaled and will be enables if requested -->    
    <?php /*?>        
    <div id="jump_to_page_wrapper" class="floatLeft">
        <select id="jump_to_page" class="smallDropDownMenu" onchange="got_to_this_page('<?php echo $jumpPath;?>');">
        <?php if ($tot_page_count == 0):?>
            <option value="">Page no</option>            
        <?php elseif (($tot_page_count == 1) && (!isset($_GET['page']))):?>
            <option value="">Page no</option>                    
            <option value="1" selected="selected">1</option>                    
        <?php else:?>    
            <option value="">Page no</option>                    
            <?php for($i=1; $i<=$tot_page_count; $i++):?>
                <option value="<?php echo $i;?>" <?php echo ($i == $_GET['page']) ? "selected='selected'" : "";?>><?php echo $i;?></option>                
            <?php endfor;?>
        <?php endif;?>
        </select>
    </div><?php */
    ?>           
            <div class="paginationContainer"><?php echo $pagination;?></div>
        </div>
    </div>
     <?php endif;?>
<?php endif;?>    	 