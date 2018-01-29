<div id="static_header">
    <!-- Breadcrumb div message -->
    <?php echo $breadcrumb;?>
    <!--  End of the Breadcrumb div mesage -->
    <div class="headerTopicContainer defaultFont boldText"><span class="headerTopicSelected"><div class="someWidth2 floatLeft"><!-- --></div>View All Search Results</span>
        <?php if ($tot_page_count != 0):?>    
        <div class="someWidth3 floatRight">
            <span class="defaultFont">Page <?php echo $cur_page;?> of <?php echo $tot_page_count;?></span>
        </div>    
        <?php endif;?>            
    </div>
</div>
<div id="dataInputContainer_wrap">
    <div class="dataInputContainer">
        <div id="pfacTableDatContainer" align="center">
            <?php if (count($all_search_results) > 0):?>
            <table border="0" cellpadding="0" cellspacing="0" class="tbs-main-search">
                <?php if ($_SESSION['Controller_to_search'] == "pfa-addbook"):?>
                    <thead>
	                    <th width="100"><div class="actionTableFieldTd2"><span class="defaultFont">Action</span></div></th>                                
                        <th width="200"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfa-addbook/search/".$searchQ."&sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Name </a>".
                                                                        (((isset($_GET['sort']) && $_GET['sort'] == "f_name") || (isset($_GET['sort']) && $_GET['sort'] == "l_name")) ? $img : "").
                                                                        "<br /><a class=\"headerLink\" href=\"".$site_config['base_url']."pfa-addbook/search/".$searchQ."&sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\">First Name </span></a>".
                                                                        ((isset($_GET['sort']) && $_GET['sort'] == "f_name") ? $img : "").
                                                                        " |<a class=\"headerLink\" href=\"".$site_config['base_url']."pfa-addbook/search/".$searchQ."&sort=l_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\"> Last Name </span></a>".
                                                                        ((isset($_GET['sort']) && $_GET['sort'] == "l_name") ? $img : "")."" : "Name";?></span></th>
                        <th width="100"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfa_addbook/search/".$searchQ."&sort=cat".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Address Book Category ".((isset($_GET['sort']) && $_GET['sort'] == "cat") ? $img : "")."</a>" : "Address Book Category";?></a></span></th>
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfa_addbook/search/".$searchQ."&sort=org".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Organization ".((isset($_GET['sort']) && $_GET['sort'] == "org") ? $img : "")."</a>" : "Organization";?></a></span></th>
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfa_addbook/search/".$searchQ."&sort=nation".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Nationality </a>".((isset($_GET['sort']) && $_GET['sort'] == "nation") ? $img : "")."" : "Nationality";?></span></th>                                                                                    
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfa_addbook/search/".$searchQ."&sort=loc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Location ".((isset($_GET['sort']) && $_GET['sort'] == "loc") ? $img : "")."</a>" : "Location";?></span></th>
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfa_addbook/search/".$searchQ."&sort=eng".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Spoken English </a>".((isset($_GET['sort']) && $_GET['sort'] == "eng") ? $img : "")."" : "Spoken English";?></span></th>
                        <th width="200"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfa_addbook/search/".$searchQ."&sort=pref_lan".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Preferred Language </a>".((isset($_GET['sort']) && $_GET['sort'] == "pref_lan") ? $img : "")."" : "Preferred Language";?></span></th>                                                            
                    </thead>
                    <?php for($i=0; $i<count($all_search_results); $i++):?>
                    <tr>
                        <td width="100"><div class="actionTableFieldTd2">

										<?php foreach($action_panel_menu as $eachMenu):?>                
                    
                                            <a title="<?php echo $eachMenu['menu_text'];?>" 
                                               href="<?php echo $eachMenu['menu_url'];?><?php echo ((strstr($eachMenu['menu_url'], "pfa-addbook/show")) || (strstr($eachMenu['menu_url'], "pfa-addbook/drop"))) ? 
                                               "?" : "&";?>addbook_id=<?php echo $all_search_results[$i]['id'].
                                               (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
                                               (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    
                                            
                                        <?php endforeach;?>
                                       
                                       </div></td>
                                       
                        <td width="200"><span class="defaultFont"><?php echo $all_search_results[$i]['first_name'];?></span>&nbsp;<span class="defaultFont"><?php echo $all_search_results[$i]['last_name'];?></span></td>
                        <td width="100"><span class="defaultFont"><?php echo $all_search_results[$i]['Client_category_name'];?></span></td>
                        <td width="150"><span class="defaultFont"><?php echo ($all_search_results[$i]['organization'] != "") ? ucwords($all_search_results[$i]['organization']) : "--";?></span></td>
                        <td width="150"><span class="defaultFont"><?php echo ($all_search_results[$i]['nationality'] != "") ? ucfirst($all_search_results[$i]['nationality']) : "--";?></span></td>                                                                                                                                                                
                        <td width="150"><span class="defaultFont"><?php echo ($all_search_results[$i]['location'] != "") ? ucfirst($all_search_results[$i]['location']) : "--";?></span></td>
                        <td width="150"><span class="defaultFont"><?php echo ($all_search_results[$i]['ability_of_english'] != "") ?  $all_search_results[$i]['ability_of_english'] : "--";?></span></td>
                        <td width="200"><span class="defaultFont"><?php echo ($all_search_results[$i]['pref_language'] != "") ? ucfirst($all_search_results[$i]['pref_language']) : "--";?></span></td>
                    </tr>					
                    <?php endfor;?>
                <?php elseif ($_SESSION['Controller_to_search'] == "pfac"):?>
                    <thead>
	                    <th><div class="actionTableFieldTd"><span class="defaultFont">Action</span></div></th>                                                                
                        <th width="200"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/search/".$searchQ."&sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Name </a>".
                                                                        (((isset($_GET['sort']) && $_GET['sort'] == "f_name") || (isset($_GET['sort']) && $_GET['sort'] == "l_name")) ? $img : "").
                                                                        "<br /><a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/search/".$searchQ."&sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\">First Name </span></a>".
                                                                        ((isset($_GET['sort']) && $_GET['sort'] == "f_name") ? $img : "").
                                                                        " |<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/search/".$searchQ."&sort=l_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\"> Last Name </span></a>".
                                                                        ((isset($_GET['sort']) && $_GET['sort'] == "l_name") ? $img : "")."" : "Name";?></span></th>
                        <th width="100"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/search/".$searchQ."&sort=cat".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Category ".((isset($_GET['sort']) && $_GET['sort'] == "cat") ? $img : "")."</a>" : "Agent Type";?></a></span></th>
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/search/".$searchQ."&sort=dob".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Date of Birth ".((isset($_GET['sort']) && $_GET['sort'] == "dob") ? $img : "")."</a>" : "Date of Birth";?></a></span></th>
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/search/".$searchQ."&sort=nationality".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Nationality ".((isset($_GET['sort']) && $_GET['sort'] == "nationality") ? $img : "")."</a>" : "Nationality";?></span></th>
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/search/".$searchQ."&sort=club".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Club </a>".((isset($_GET['sort']) && $_GET['sort'] == "club") ? $img : "")."" : "Club";?></span></th>
                        <th width="100"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/search/".$searchQ."&sort=con_start".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Contract Start Date ".((isset($_GET['sort']) && $_GET['sort'] == "con_start") ? $img : "")."</a>" : "Contract Start Date";?></a></span></th>
                        <th width="200"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/search/".$searchQ."&sort=con_end".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Contract End Date </a>".((isset($_GET['sort']) && $_GET['sort'] == "con_end") ? $img : "")."" : "Contract End Date";?></span></th>                                                            
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfac/search/".$searchQ."&sort=weburl".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Web Page URL </a>".((isset($_GET['sort']) && $_GET['sort'] == "weburl") ? $img : "")."" : "Web Page URL";?></span></th>                                                            
                    </thead>
                    <?php for($i=0; $i<count($all_search_results); $i++):?>
                    <tr>
                        <td><div class="actionTableFieldTd">
                        
										<?php foreach($action_panel_menu as $eachMenu):?>                
                    
                                            <a title="<?php echo $eachMenu['menu_text'];?>" 
                                               href="<?php echo $eachMenu['menu_url'];?><?php echo ((strstr($eachMenu['menu_url'], "pfac/show")) || (strstr($eachMenu['menu_url'], "pfac/drop"))) ? 
                                               "?" : "&";?>pfac_id=<?php echo $all_search_results[$i]['id'].
                                               (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
                                               (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    
                                            
                                        <?php endforeach;?>
                                        
                                        </div></td>
                        
                        <td width="200"><span class="defaultFont"><?php echo $all_search_results[$i]['first_name'];?></span>&nbsp;<span class="defaultFont"><?php echo $all_search_results[$i]['last_name'];?></span></td>
                        <td width="100"><span class="defaultFont"><?php echo $all_search_results[$i]['player_category_name'];?></span></td>
                        <td width="150"><span class="defaultFont"><?php echo $all_search_results[$i]['date_of_birth'];?></span></td>
                        <td width="150"><span class="defaultFont"><?php echo ucfirst($all_search_results[$i]['nationality']);?></span></td>
                        <td width="150"><span class="defaultFont"><?php echo ($all_search_results[$i]['club'] != "") ? $all_search_results[$i]['club'] : "--";?></span></td>
                        <td width="100"><span class="defaultFont"><?php echo ($all_search_results[$i]['contract_start_date'] != "0000-00-00") ? $all_search_results[$i]['contract_start_date'] : "--";?></span></td>
                        <td width="200"><span class="defaultFont"><?php echo ($all_search_results[$i]['contract_end_date'] != "0000-00-00") ? $all_search_results[$i]['contract_end_date'] : "--";?></span></td>
                        <td width="150"><span class="defaultFont"><a class="singleLink" href="<?php echo $all_search_results[$i]['webpage_url'];?>" title="<?php echo $all_search_results[$i]['webpage_url'];?>"><?php 
                                                            echo (strlen(App_Viewer::format_view_data_with_line_breaks($all_search_results[$i]['webpage_url'])) > 50) ? 
                                                                substr(App_Viewer::format_view_data_with_line_breaks($all_search_results[$i]['webpage_url']), 0, 47)."..." : 
                                                                App_Viewer::format_view_data_with_line_breaks($all_search_results[$i]['webpage_url']);
                                                             ?></a></span></td>                                                                                                                                        
                    </tr>					
                    <?php endfor;?>
                <?php elseif ($_SESSION['Controller_to_search'] == "pfagos"):?>
                    <thead> 
	                    <th width="80"><span class="defaultFont">Action</span></th>                                           
                        <th width="200"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfagos/search/".$searchQ."&sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Name </a>".
                                                                        (((isset($_GET['sort']) && $_GET['sort'] == "f_name") || (isset($_GET['sort']) && $_GET['sort'] == "l_name")) ? $img : "").
                                                                        "<br /><a class=\"headerLink\" href=\"".$site_config['base_url']."pfagos/search/".$searchQ."&sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\">First Name </span></a>".
                                                                        ((isset($_GET['sort']) && $_GET['sort'] == "f_name") ? $img : "").
                                                                        " |<a class=\"headerLink\" href=\"".$site_config['base_url']."pfagos/search/".$searchQ."&sort=l_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\"> Last Name </span></a>".
                                                                        ((isset($_GET['sort']) && $_GET['sort'] == "l_name") ? $img : "")."" : "Name";?></span></th>
                        <th width="100"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfagos/search/".$searchQ."&sort=uname".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Username ".((isset($_GET['sort']) && $_GET['sort'] == "uname") ? $img : "")."</a>" : "Username";?></a></span></th>
                        <th width="100"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfagos/search/".$searchQ."&sort=email".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Email ".((isset($_GET['sort']) && $_GET['sort'] == "email") ? $img : "")."</a>" : "Email";?></a></span></th>
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfagos/search/".$searchQ."&sort=created_at".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Created At ".((isset($_GET['sort']) && $_GET['sort'] == "created_at") ? $img : "")."</a>" : "Created At";?></a></span></th>
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."pfagos/search/".$searchQ."&sort=last_log".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Last Logged ".((isset($_GET['sort']) && $_GET['sort'] == "last_log") ? $img : "")."</a>" : "Last Logged";?></span></th>
                    </thead>
                    <?php for($i=0; $i<count($all_search_results); $i++):?>
						<?php $trClass = "";?>
                         <?php if ($_SESSION['logged_user']['id'] == $all_search_results[$i]['id']):?>                
                                <?php $trClass = "systemUserColored";?>                     	
                         <?php endif;?>
                        <tr class="<?php echo $trClass;?>">

                        <td><div align="left" class="actionTableFieldTd3">
                        
										<?php foreach($action_panel_menu as $eachMenu):?>                
                    
                                            <?php if ($_SESSION['logged_user']['id'] != $all_search_results[$i]['id']):?>
                                            
                                                <a title="<?php echo $eachMenu['menu_text'];?>" 
                                                   href="<?php echo $eachMenu['menu_url'];?>pfagos_id=<?php echo $all_search_results[$i]['id'].
                                                   (isset($_GET['page']) ? "&page=".$_GET['page'] : "&page=1");?>"><?php echo $eachMenu['menu_img'];?></a>                    
                                            
                                            <?php else:?>
                                            
                                                <?php if ($eachMenu['menu_text'] != "Drop"):?>
                                                
                                                    <a title="<?php echo $eachMenu['menu_text'];?>" 
                                                       href="<?php echo $eachMenu['menu_url'];?>pfagos_id=<?php echo $all_search_results[$i]['id'].
                                                       (isset($_GET['page']) ? "&page=".$_GET['page'] : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    
                                                       
                                                <?php endif;?>
                                                
                                            <?php endif;?>
                                            
                                        <?php endforeach;?>
                                        
                          		</div></td>
                                       
                        <td width="200"><span class="defaultFont"><?php echo $all_search_results[$i]['first_name'];?></span>&nbsp;<span class="defaultFont"><?php echo $all_search_results[$i]['last_name'];?></span></td>
                        <td width="100"><span class="defaultFont"><?php echo $all_search_results[$i]['username'];?></span></td>
                        <td width="100"><span class="defaultFont"><?php echo ($all_search_results[$i]['email'] != "") ? $all_search_results[$i]['email'] : "--";?></span></td>
                        <td width="150"><span class="defaultFont"><?php echo $all_search_results[$i]['created_at'];?></span></td>
                        <td width="150"><span class="defaultFont"><?php echo ($all_search_results[$i]['last_login'] != "0000-00-00") ? $all_search_results[$i]['last_login'] : "Not Logged";?></span></td>
                    </tr>					
                    <?php endfor;?>
                <?php elseif ($_SESSION['Controller_to_search'] == "system"):?>
                    <thead>
                        <th width="75"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"soringMenusLink\" href=\"".$site_config['base_url']."system/search/".$searchQ."&sort=u_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Username ".((isset($_GET['sort']) && $_GET['sort'] == "u_name") ? $img : "")."</a>" : "Username";?></a></span></th>
                        <th width="400"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"soringMenusLink\" href=\"".$site_config['base_url']."system/search/".$searchQ."&sort=act_desc".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Activity Description ".((isset($_GET['sort']) && $_GET['sort'] == "act_desc") ? $img : "")."</a>" : "Activity Description";?></span></th>
                        <th width="200"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"soringMenusLink\" href=\"".$site_config['base_url']."system/search/".$searchQ."&sort=time".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Date &amp; Time </a>".((isset($_GET['sort']) && $_GET['sort'] == "time") ? $img : "")."" : "Date &amp; Time";?></span></th>
                    </thead>
                    <?php for($i=0; $i<count($all_search_results); $i++):?>
                    <tr>
                        <td width="75"><span title="<?php echo $all_search_results[$i]['username'];?>" class="defaultFont"><?php echo $all_search_results[$i]['username'];?></span></td>
                        <td width="400"><span title="<?php echo $all_search_results[$i]['action_type_desc'];?>" class="defaultFont"><?php echo $all_search_results[$i]['action_type_desc'];?></span></td>
                        <td width="200"><span title="<?php echo $all_search_results[$i]['date_time'];?>" class="defaultFont"><?php echo App_Viewer::format_date_with_time($all_search_results[$i]['date_time']);?></span></td>
                    </tr>					
                    <?php endfor;?>
                <?php elseif ($_SESSION['Controller_to_search'] == "cfcp"):?>
                    <thead>
	                    <th><span class="defaultFont">Action</span></th>                                                                
                        <th width="200"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Name </a>".
                                                                        (((isset($_GET['sort']) && $_GET['sort'] == "f_name") || (isset($_GET['sort']) && $_GET['sort'] == "l_name")) ? $img : "").
                                                                        "<br /><a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\">First Name </span></a>".
                                                                        ((isset($_GET['sort']) && $_GET['sort'] == "f_name") ? $img : "").
                                                                        " |<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=l_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\"> Last Name </span></a>".
                                                                        ((isset($_GET['sort']) && $_GET['sort'] == "l_name") ? $img : "")."" : "Name";?></span></th>
                        <th width="100"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=team".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Team Name ".((isset($_GET['sort']) && $_GET['sort'] == "team") ? $img : "")."</a>" : "Team Name";?></a></span></th>
                        <th width="100"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=dob".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Date of Birth ".((isset($_GET['sort']) && $_GET['sort'] == "dob") ? $img : "")."</a>" : "Date of Birth";?></a></span></th>
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=birth_place".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Place of Birth ".((isset($_GET['sort']) && $_GET['sort'] == "birth_place") ? $img : "")."</a>" : "Place of Birth";?></a></span></th>
                        <th width="150"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=cat".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Player Category Name ".((isset($_GET['sort']) && $_GET['sort'] == "cat") ? $img : "")."</a>" : "Player Category Name";?></span></th>
                        <th width="75"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=pos1".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Position 1 </a>".((isset($_GET['sort']) && $_GET['sort'] == "pos1") ? $img : "")."" : "Position 1";?></span></th>                                                            
                        <th width="75"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=pos2".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Position 2 </a>".((isset($_GET['sort']) && $_GET['sort'] == "pos2") ? $img : "")."" : "Position 2";?></span></th>                                                            
                        <th width="125"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=school".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">School </a>".((isset($_GET['sort']) && $_GET['sort'] == "school") ? $img : "")."" : "School";?></span></th>                                                            
                        <th width="100"><span class="defaultFont"><?php echo ($all_search_results_count > 1) ? "<a class=\"headerLink\" href=\"".$site_config['base_url']."cfcp/search/".$searchQ."&sort=class".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Current Class </a>".((isset($_GET['sort']) && $_GET['sort'] == "class") ? $img : "")."" : "Current Class";?></span></th>                                                            
                    </thead>
                    <?php for($i=0; $i<count($all_search_results); $i++):?>
                    <tr>
                        <td><div class="actionTableFieldTd">
                        
											<?php foreach($action_panel_menu as $eachMenu):?>                
                        
                                                <a title="<?php echo $eachMenu['menu_text'];?>" 
                                                   href="<?php echo $eachMenu['menu_url'];?><?php echo ((strstr($eachMenu['menu_url'], "cfcp/show")) || (strstr($eachMenu['menu_url'], "cfcp/drop"))) ? 
                                                   "?" : "&";?>cfcp_id=<?php echo $all_search_results[$i]['id'].
                                                   (isset($_GET['page']) ? "&page=".$_GET['page'] : "").
                                                   (($eachMenu['menu_text'] == "Add / Edit Note") ? ((isset($_GET['notes_page'])) ? "&notes_page=".$_GET['notes_page'] : "&notes_page=1") : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    
                                                
                                            <?php endforeach;?>
                        				
                                        </div></td>
                        
                        <td width="200"><span class="defaultFont"><?php echo $all_search_results[$i]['first_name'];?></span>&nbsp;<span class="defaultFont"><?php echo $all_search_results[$i]['last_name'];?></span></td>
                        <td width="100"><span class="defaultFont"><?php echo $all_search_results[$i]['team_name'];?></span></td>
                        <td width="100"><span class="defaultFont"><?php echo $all_search_results[$i]['date_of_birth'];?></span></td>
                        <td width="150"><span class="defaultFont"><?php echo ($all_search_results[$i]['place_of_birth'] != "") ? $all_search_results[$i]['place_of_birth'] : "--";?></span></td>
                        <td width="150"><span class="defaultFont"><?php echo ($all_search_results[$i]['player_category_name'] != "") ? $all_search_results[$i]['player_category_name'] : "N/A";?></span></td>
                        <td width="75"><span class="defaultFont"><?php echo ($all_search_results[$i]['position1'] != "") ? $all_search_results[$i]['position1'] : "--";?></span></td>                                                            
                        <td width="75"><span class="defaultFont"><?php echo ($all_search_results[$i]['position2'] != "") ? $all_search_results[$i]['position2'] : "--";?></span></td>                                                            
                        <td width="125"><span class="defaultFont"><?php echo ($all_search_results[$i]['school'] != "") ? $all_search_results[$i]['school'] : "--";?></span></td>                                                                                                
                        <td width="100"><span class="defaultFont"><?php echo ($all_search_results[$i]['current_class'] != "") ? $all_search_results[$i]['current_class'] : "--";?></span></td>                               
                    </tr>					
                    <?php endfor;?>
                <?php endif;?>    
            </table>
            <?php else:?>
                <span class="defaultFont boldText specializedTexts">No Results Found !</span>
            <?php endif;?>
        </div>
    </div>   
</div>
	<?php if ($tot_page_count > 1):?>   
    <div id="pagination_wrap">
        <div id="pagination" align="center">
        <!-- This is the page jumping secte box and at the moment it has been disbaled and will be enables if requested -->    
        <?php /*?>                
        <div id="jump_to_page_wrapper" class="floatLeft">
            <select id="jump_to_page" class="smallDropDownMenu" onchange="got_to_this_page('<?php echo $pathToJump;?>');">
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