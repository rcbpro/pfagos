<div id="static_header">
    <!-- Breadcrumb div message -->
    <?php echo $breadcrumb;?>
    <!--  End of the Breadcrumb div mesage -->
    <!-- This is the success/error message to be diplayed -->
    <?php global $headerDivMsg; echo $headerDivMsg;?>
    <!-- End of the success or error message -->
    <div class="headerTopicContainer defaultFont boldText">
    <?php if ($invalidPage != true):?>
		<?php if ($tot_page_count != 0):?>    
            <div class="out-of">Page <?php echo $cur_page;?> of <?php echo $tot_page_count;?></div>
        <?php endif;?>
    <?php endif;?>        
    <span class="headerTopicSelected">PFA Clients</span>
    </div>
</div>
<div id="dataInputContainer_wrap">
    <div class="dataInputContainer rem-m">
        <div id="pfacTableDatContainer">
           <?php if ($invalidPage != true):?>   
            <table border="0" cellpadding="0" cellspacing="0" class="tbs-main-pfac">
                <thead>
                    <th><div class="actionTableFieldTd"><span class="defaultFont">Action</span></div></th>            
                    <th width="200"><span class="defaultFont"><?php echo ($pfac_all_count > 1) ? "<a title=\"Sort By First / Last Name\" class=\"soringMenusLink\" href=\"?sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Name </a>".
                                                                    (((isset($_GET['sort']) && $_GET['sort'] == "f_name") || (isset($_GET['sort']) && $_GET['sort'] == "l_name")) ? $img : "").
                                                                    "<br /><a title=\"Sort By First Name\" class=\"soringMenusLink\" href=\"?sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\">First Name </span></a>".
                                                                    ((isset($_GET['sort']) && $_GET['sort'] == "f_name") ? $img : "").
                                                                    " | <a title=\"Sort By Last Name\" class=\"soringMenusLink\" href=\"?sort=l_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\"> Last Name </span></a>".
                                                                    ((isset($_GET['sort']) && $_GET['sort'] == "l_name") ? $img : "")."" : "Name";?></span></th>
                    <th width="100"><span class="defaultFont"><?php echo ($pfac_all_count > 1) ? "<a title=\"Sort By Player Category\" class=\"soringMenusLink\" href=\"?sort=playercat".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Player Category ".((isset($_GET['sort']) && $_GET['sort'] == "playercat") ? $img : "")."</a>" : "Player Category";?></a></span></th>
                    <th width="75"><span class="defaultFont"><?php echo ($pfac_all_count > 1) ? "<a title=\"Sort By Date of Birth\" class=\"soringMenusLink\" href=\"?sort=dob".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">DOB ".((isset($_GET['sort']) && $_GET['sort'] == "dob") ? $img : "")."</a>" : "DOB";?></span></th>
                    <th width="100"><span class="defaultFont"><?php echo ($pfac_all_count > 1) ? "<a title=\"Sort By Nationality\" class=\"soringMenusLink\" href=\"?sort=nationality".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Nationality </a>".((isset($_GET['sort']) && $_GET['sort'] == "nationality") ? $img : "")."" : "Nationality";?></span></th>
                    <th width="130"><span class="defaultFont"><?php echo ($pfac_all_count > 1) ? "<a title=\"Sort By Club\" class=\"soringMenusLink\" href=\"?sort=club".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Club </a>".((isset($_GET['sort']) && $_GET['sort'] == "club") ? $img : "")."" : "Club";?></span></th>                                                            
                    <th width="100"><span class="defaultFont"><?php echo ($pfac_all_count > 1) ? "<a title=\"Sort By Contract Start Date\" class=\"soringMenusLink\" href=\"?sort=con_start".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Contract Start Date </a>".((isset($_GET['sort']) && $_GET['sort'] == "con_start") ? $img : "")."" : "Contract Start Date";?></span></th>                                                            
                    <th width="100"><span class="defaultFont"><?php echo ($pfac_all_count > 1) ? "<a title=\"Sort By Contract End Date\" class=\"soringMenusLink\" href=\"?sort=con_end".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Contract End Date </a>".((isset($_GET['sort']) && $_GET['sort'] == "con_end") ? $img : "")."" : "Contract End Date";?></span></th>                                                            
                    <th width="210"><span class="defaultFont"><?php echo ($pfac_all_count > 1) ? "<a title=\"Sort By Player's Single Web Page\" class=\"soringMenusLink\" href=\"?sort=playerpage".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Player's Web Page </a>".((isset($_GET['sort']) && $_GET['sort'] == "playerpage") ? $img : "")."" : "Player's Web Page";?></span></td>                                                               
                </thead>
                <?php for($i=0; $i<count($pfac_all); $i++):?>
                <tr>
                    <td><div class="actionTableFieldTd">
                                   
                    <?php foreach($action_panel_menu as $eachMenu):?>                

						<?php if ($eachMenu['menu_text'] == "Drop"):?>                             
                     
                            <a onclick="return ask_for_delete_record('<?php echo $site_config['base_url'];?>pfac/drop/?pfac_id=<?php echo $pfac_all[$i]['pfac_id'];?>')"                                
                               title="<?php echo $eachMenu['menu_text'];?>" 
                               href=""><?php echo $eachMenu['menu_img'];?></a>                    

                        <?php else:?>
                            
                            <a title="<?php echo $eachMenu['menu_text'];?>" 
                               href="<?php echo $eachMenu['menu_url'];?><?php echo ((strstr($eachMenu['menu_url'], "pfac/show")) || (strstr($eachMenu['menu_url'], "pfac/drop"))) ? 
                               "?" : "&";?>pfac_id=<?php echo $pfac_all[$i]['pfac_id'].
                               (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
                               (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    

                        <?php endif;?>
                    	
                    <?php endforeach;?>
                    
                    </div></td>
                    
                    <td width="200"><span title="<?php echo $pfac_all[$i]['firstName'];?>" class="defaultFont"><?php echo $pfac_all[$i]['firstName'];?></span>&nbsp;<span class="defaultFont"><?php echo $pfac_all[$i]['lastName'];?></span></td>
                    <td width="100"><span title="<?php echo $pfac_all[$i]['playerCatName'];?>" class="defaultFont"><?php echo $pfac_all[$i]['playerCatName'];?></span></td>
                    <td width="100"><span title="<?php echo $pfac_all[$i]['dob'];?>" class="defaultFont"><?php $dob = explode("-",$pfac_all[$i]['dob']); echo $dob[2]."-".$dob[1]."-".$dob[0]?></span></td>
                    <td width="75"><span title="<?php echo ucfirst($pfac_all[$i]['Nationality']);?>" class="defaultFont"><?php echo ucfirst($pfac_all[$i]['Nationality']);?></span></td>
                    <td width="130"><span title="<?php echo $pfac_all[$i]['Club'];?>" class="defaultFont"><?php echo ($pfac_all[$i]['Club'] != "") ? $pfac_all[$i]['Club'] : "--";?></span></td>                                                            
                    <td width="100"><span title="<?php echo $pfac_all[$i]['contract_start_date'];?>" class="defaultFont"><?php $contract_start_date = explode("-",$pfac_all[$i]['contract_start_date']); echo ($pfac_all[$i]['contract_start_date'] != "0000-00-00") ? $contract_start_date[2]."-".$contract_start_date[1]."-".$contract_start_date[0] : "--";?></span></td>                                                            
                    <td width="100"><span title="<?php echo $pfac_all[$i]['contract_end_date'];?>" class="defaultFont"><?php $contract_end_date = explode("-",$pfac_all[$i]['contract_end_date']); echo ($pfac_all[$i]['contract_end_date'] != "0000-00-00") ? $contract_end_date[2]."-".$contract_end_date[1]."-".$contract_end_date[0] : "--";?></span></td>                                                            
                    <td width="210"><span title="<?php echo $pfac_all[$i]['webpage_url'];?>" class="defaultFont"><?php if ($pfac_all[$i]['webpage_url'] != ""):?><a class="singleLink" href="<?php echo $pfac_all[$i]['webpage_url'];?>" target="_blank" title="<?php echo $pfac_all[$i]['webpage_url'];?>"><?php 
                                                            echo ((strlen(App_Viewer::format_view_data_with_line_breaks($pfac_all[$i]['webpage_url'])) > 70) ? 
                                                                substr(App_Viewer::format_view_data_with_line_breaks($pfac_all[$i]['webpage_url']), 0, 67)."..." : 
                                                                App_Viewer::format_view_data_with_line_breaks($pfac_all[$i]['webpage_url']));
                                                             ?></a><?php else:?>--<?php endif;?></span></td>                                               
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