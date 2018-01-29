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
    <span class="headerTopicSelected">CFC Players</span>
    </div>
</div>
<div id="dataInputContainer_wrap">
    <div class="dataInputContainer rem-m">
        <div id="pfacTableDatContainer">
           <?php if ($invalidPage != true):?>   
            <table border="0" cellpadding="0" cellspacing="0" class="tbs-main-pfac">
                <thead>
                    <th><div class="actionTableFieldTd"><span class="defaultFont">Action</span></div></th>            
                    <th width="175"><span class="defaultFont"><?php echo ($cfcp_all_count > 1) ? "<a title=\"Sort By First / Last Name\" class=\"soringMenusLink\" href=\"?sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Name </a>".
                                                                    (((isset($_GET['sort']) && $_GET['sort'] == "f_name") || (isset($_GET['sort']) && $_GET['sort'] == "l_name")) ? $img : "").
                                                                    "<br /><a title=\"Sort By First Name\" class=\"soringMenusLink\" href=\"?sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\">First Name </span></a>".
                                                                    ((isset($_GET['sort']) && $_GET['sort'] == "f_name") ? $img : "").
                                                                    "|<a title=\"Sort By Last Name\" class=\"soringMenusLink\" href=\"?sort=l_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\"> Last Name </span></a>".
                                                                    ((isset($_GET['sort']) && $_GET['sort'] == "l_name") ? $img : "")."" : "Name";?></span></th>
                    <th width="75"><span class="defaultFont"><?php echo ($cfcp_all_count > 1) ? "<a title=\"Sort By Team Name\" class=\"soringMenusLink\" href=\"?sort=team".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Team Name ".((isset($_GET['sort']) && $_GET['sort'] == "team") ? $img : "")."</a>" : "Team Name";?></a></span></th>
                    <th width="100"><span class="defaultFont"><?php echo ($cfcp_all_count > 1) ? "<a title=\"Sort By Nick Name1\" class=\"soringMenusLink\" href=\"?sort=nick1".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Nick Name1 ".((isset($_GET['sort']) && $_GET['sort'] == "nick1") ? $img : "")."</a>" : "Nick Name1";?></a></span></th>
                    <th width="100"><span class="defaultFont"><?php echo ($cfcp_all_count > 1) ? "<a title=\"Sort By Nick Name2\" class=\"soringMenusLink\" href=\"?sort=nick2".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Nick Name2 ".((isset($_GET['sort']) && $_GET['sort'] == "nick2") ? $img : "")."</a>" : "Nick Name2";?></a></span></th>
                    <th width="75"><span class="defaultFont"><?php echo ($cfcp_all_count > 1) ? "<a title=\"Sort By Date of Birth\" class=\"soringMenusLink\" href=\"?sort=dob".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Date of Birth ".((isset($_GET['sort']) && $_GET['sort'] == "dob") ? $img : "")."</a>" : "Date of Birth";?></span></th>
                    <th width="75"><span class="defaultFont"><?php echo ($cfcp_all_count > 1) ? "<a title=\"Sort By Player Category\" class=\"soringMenusLink\" href=\"?sort=playercat".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Player Category </a>".((isset($_GET['sort']) && $_GET['sort'] == "playercat") ? $img : "")."" : "Player Category";?></span></th>
                    <th width="75"><span class="defaultFont"><?php echo ($cfcp_all_count > 1) ? "<a title=\"Sort By Position\" class=\"soringMenusLink\" href=\"?sort=pos1".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Position 1 </a>".((isset($_GET['sort']) && $_GET['sort'] == "pos1") ? $img : "")."" : "Position 1";?></span></th>                                                            
                    <th width="75"><span class="defaultFont"><?php echo ($cfcp_all_count > 1) ? "<a title=\"Sort By Position\" class=\"soringMenusLink\" href=\"?sort=pos2".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Position 2 </a>".((isset($_GET['sort']) && $_GET['sort'] == "pos2") ? $img : "")."" : "Position 2";?></span></th>                                                            
                    <th width="125"><span class="defaultFont"><?php echo ($cfcp_all_count > 1) ? "<a title=\"Sort By school\" class=\"soringMenusLink\" href=\"?sort=school".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">School </a>".((isset($_GET['sort']) && $_GET['sort'] == "school") ? $img : "")."" : "School";?></span></th>                                                            
                    <th width="100"><span class="defaultFont"><?php echo ($cfcp_all_count > 1) ? "<a title=\"Sort By Current Class\" class=\"soringMenusLink\" href=\"?sort=class".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Current Class </a>".((isset($_GET['sort']) && $_GET['sort'] == "class") ? $img : "")."" : "Current Class";?></span></th>                                                            
                </thead>
                <?php for($i=0; $i<count($cfcp_all); $i++):?>
                <tr>
                    <td><div class="actionTableFieldTd">

						<?php foreach($action_panel_menu as $eachMenu):?>                
    
							<?php if ($eachMenu['menu_text'] == "Drop"):?>                             
                         
                                <a onclick="return ask_for_delete_record('<?php echo $site_config['base_url'];?>cfcp/drop/?cfcp_id=<?php echo $cfcp_all[$i]['cfcp_id'];?>')"                                
                                   title="<?php echo $eachMenu['menu_text'];?>" 
                                   href=""><?php echo $eachMenu['menu_img'];?></a>                    
    
                            <?php else:?>
                                
                                <a title="<?php echo $eachMenu['menu_text'];?>" 
                                   href="<?php echo $eachMenu['menu_url'];?><?php echo ((strstr($eachMenu['menu_url'], "cfcp/show")) || (strstr($eachMenu['menu_url'], "cfcp/drop"))) ? 
                                   "?" : "&";?>cfcp_id=<?php echo $cfcp_all[$i]['cfcp_id'].
                                   (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
                                   (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    
    
                            <?php endif;?>
                            
                        <?php endforeach;?>
                         
                         </div></td>         
                                   
                    <td width="175"><span title="<?php echo $cfcp_all[$i]['firstName'];?>" class="defaultFont"><?php echo $cfcp_all[$i]['firstName'];?></span>&nbsp;<span class="defaultFont"><?php echo $cfcp_all[$i]['lastName'];?></span></td>
                    <td width="75"><span title="<?php echo $cfcp_all[$i]['teamName'];?>" class="defaultFont"><?php echo $cfcp_all[$i]['teamName'];?></span></td>
                    <td width="100"><span title="<?php echo $cfcp_all[$i]['nickname1'];?>" class="defaultFont"><?php echo ($cfcp_all[$i]['nickname1'] != "") ? $cfcp_all[$i]['nickname1'] : "--";?></span></td>
                    <td width="100"><span title="<?php echo $cfcp_all[$i]['nickname1'];?>" class="defaultFont"><?php echo ($cfcp_all[$i]['nickname2'] != "") ? $cfcp_all[$i]['nickname2'] : "--";?></span></td>
                    <td width="75"><span title="<?php echo $cfcp_all[$i]['dob'];?>" class="defaultFont"><?php $dob = explode("-",$cfcp_all[$i]['dob']); echo $dob[2]."-".$dob[1]."-".$dob[0]?></span></td>
                    <td width="75"><span title="<?php echo ($cfcp_all[$i]['playerCatName'] != "") ? $cfcp_all[$i]['playerCatName'] : "- Not Available -";?>" class="defaultFont"><?php echo ($cfcp_all[$i]['playerCatName'] != "") ? ucfirst($cfcp_all[$i]['playerCatName']) : "- N/A -" ;?></span></td>
                    <td width="75"><span title="<?php echo ($cfcp_all[$i]['position1'] != "") ? $cfcp_all[$i]['position1'] : "--";?>" class="defaultFont"><?php echo ($cfcp_all[$i]['position1'] != "") ? $cfcp_all[$i]['position1'] : "--";?></span></td>                                                            
                    <td width="75"><span title="<?php echo ($cfcp_all[$i]['position2'] != "") ? $cfcp_all[$i]['position2'] : "--";?>" class="defaultFont"><?php echo ($cfcp_all[$i]['position2'] != "") ? $cfcp_all[$i]['position2'] : "--";?></span></td>                                                            
                    <td width="125"><span title="<?php echo $cfcp_all[$i]['school'];?>" class="defaultFont"><?php echo ($cfcp_all[$i]['school'] != "") ? $cfcp_all[$i]['school'] : "--";?></span></td>                                                                                                
                    <td width="100"><span title="<?php echo $cfcp_all[$i]['currClass'];?>" class="defaultFont"><?php echo ($cfcp_all[$i]['currClass'] != "") ? $cfcp_all[$i]['currClass'] : "--";?></span></td>                               
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