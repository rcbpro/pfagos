<div id="static_header">
    <!-- Breadcrumb div message -->
    <?php echo $breadcrumb;?>
    <!--  End of the Breadcrumb div mesage -->
    <!-- Success / Warning message -->    
    <?php echo $headerDivMsg;?>
    <!--  End of the Success / Warning mesage -->    
    <div class="headerTopicContainer defaultFont boldText">
        <?php if ($tot_page_count != 0):?>    
			<div class="out-of">Page <?php echo $cur_page;?> of <?php echo $tot_page_count;?></div>   
        <?php endif;?>  
        <span class="headerTopicSelected">All PFAGOS Users</span>
    </div>
</div>
<div id="dataInputContainer_wrap">
    <div class="dataInputContainer">
        <div id="pfacTableDatContainer" align="center">
           <?php if ($invalidPage != true):?>           
            <table border="0" cellpadding="0" cellspacing="0" class="tbs-main-users">
                <thead>
                    <th><div class="actionTableFieldTd3"><span class="defaultFont">Action</span></div></th>            
                    <th width="300"><span class="defaultFont"><?php echo ($all_pfagos_users_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Name </a>".
                                                                    (((isset($_GET['sort']) && $_GET['sort'] == "f_name") || (isset($_GET['sort']) && $_GET['sort'] == "l_name")) ? $img : "").
                                                                    "<br /><a class=\"soringMenusLink\" href=\"?sort=f_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\">First Name </span></a>".
                                                                    ((isset($_GET['sort']) && $_GET['sort'] == "f_name") ? $img : "").
                                                                    "|<a class=\"soringMenusLink\" href=\"?sort=l_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\"><span class=\"smallFont\"> Last Name </span></a>".
                                                                    ((isset($_GET['sort']) && $_GET['sort'] == "l_name") ? $img : "")."" : "Name";?></span></th>
                    <th width="150"><span class="defaultFont"><?php echo ($all_pfagos_users_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=u_name".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Username ".((isset($_GET['sort']) && $_GET['sort'] == "u_name") ? $img : "")."</a>" : "Username";?></a></span></th>
                    <th width="150"><span class="defaultFont"><?php echo ($all_pfagos_users_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=email".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Email ".((isset($_GET['sort']) && $_GET['sort'] == "email") ? $img : "")."</a>" : "Email";?></span></th>
                    <th width="150"><span class="defaultFont"><?php echo ($all_pfagos_users_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=created_at".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Created At </a>".((isset($_GET['sort']) && $_GET['sort'] == "created_at") ? $img : "")."" : "Created At";?></span></th>
                    <th width="150"><span class="defaultFont"><?php echo ($all_pfagos_users_count > 1) ? "<a class=\"soringMenusLink\" href=\"?sort=last_login".(isset($_GET['page']) ? "&page=".$_GET['page'] : "")."\">Last Login </a>".((isset($_GET['sort']) && $_GET['sort'] == "last_login") ? $img : "")."" : "Last Login";?></span></th>                                                            
                </thead>
                <?php for($i=0; $i<count($all_pfagos_users); $i++):?>
                	<?php $trClass = "";?>
                     <?php if ($_SESSION['logged_user']['id'] == $all_pfagos_users[$i]['id']):?>                
                        	<?php $trClass = "systemUserColored";?>                     	
                     <?php endif;?>
                <tr class="<?php echo $trClass;?>">
                    <td><div align="left" class="actionTableFieldTd3">
                    
                    <?php foreach($action_panel_menu as $eachMenu):?>                

						<?php if ($_SESSION['logged_user']['id'] != $all_pfagos_users[$i]['id']):?>
                        
							<?php if ($eachMenu['menu_text'] == "Drop"):?>                             
                         
                                <a onclick="return ask_for_delete_record('<?php echo $site_config['base_url'];?>pfagos/drop/?pfagos_id=<?php echo $all_pfagos_users[$i]['id'];?>')"                                
                                   title="<?php echo $eachMenu['menu_text'];?>" 
                                   href=""><?php echo $eachMenu['menu_img'];?></a>                    
    
                            <?php else:?>                          
                        
                                <a title="<?php echo $eachMenu['menu_text'];?>" 
                                   href="<?php echo $eachMenu['menu_url'];?>pfagos_id=<?php echo $all_pfagos_users[$i]['id'].
                                   (isset($_GET['page']) ? "&page=".$_GET['page'] : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    
                                   
							<?php endif;?>                                   
                    	
                        <?php else:?>
                        
							<?php if ($eachMenu['menu_text'] != "Drop"):?>
                            
                                <a title="<?php echo $eachMenu['menu_text'];?>" 
                                   href="<?php echo $eachMenu['menu_url'];?>pfagos_id=<?php echo $all_pfagos_users[$i]['id'].
                                   (isset($_GET['page']) ? "&page=".$_GET['page'] : "");?>"><?php echo $eachMenu['menu_img'];?></a>                    
                                   
                            <?php endif;?>
                            
                        <?php endif;?>
                        
                    <?php endforeach;?>
                    
                    </div></td>
                    
                    <td width="300"><span title="<?php echo $all_pfagos_users[$i]['first_name'] . " " . $all_pfagos_users[$i]['last_name'];?>" class="defaultFont"><?php echo $all_pfagos_users[$i]['first_name'];?></span>&nbsp;<span class="defaultFont"><?php echo $all_pfagos_users[$i]['last_name'];?></span></td>
                    <td width="150"><span title="<?php echo $all_pfagos_users[$i]['username'];?>" class="defaultFont"><?php echo $all_pfagos_users[$i]['username'];?></span></td>
                    <td width="150"><span title="<?php echo $all_pfagos_users[$i]['email'];?>" class="defaultFont"><?php echo ($all_pfagos_users[$i]['email'] != "") ? $all_pfagos_users[$i]['email'] : "--";?></span></td>
                    <td width="150"><span title="<?php echo $all_pfagos_users[$i]['created_at'];?>" class="defaultFont"><?php echo App_Viewer::format_date($all_pfagos_users[$i]['created_at']);?></span></td>
                    <td width="150"><span title="<?php echo $all_pfagos_users[$i]['last_login'];?>" class="defaultFont"><?php echo ($all_pfagos_users[$i]['last_login'] != "0000-00-00") ? $all_pfagos_users[$i]['last_login'] : "Not Logged";?></span></td>                                                            
                </tr>					
                <?php endfor;?>
            </table>
            <?php else:?>  
	            <div class="someWidth6 floatLeft"><span class="defaultFont boldText specializedTexts">Invalid page !</span></div><div class="someWidth6 boldText floatLeft specializedTexts2"><span class="defaultFont">Redirecting ... </span></div>
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