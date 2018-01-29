<div id="static_header">
    <!-- Breadcrumb div message -->
    <?php echo $breadcrumb;?>
    <!--  End of the Breadcrumb div mesage -->
    <div class="headerTopicContainer defaultFont boldText"><span class="headerTopicSelected"><div class="someWidth2 floatLeft"><!-- --></div><?php echo ucwords($fullDetails[0]['first_name'])." ".ucwords($fullDetails[0]['last_name']);?></span></div>
    <div class="action-panel"><?php echo $action_panel_menu;?></div>
    <div id="dataInputContainer_wrap">
        <div id="dataInputContainer" align="center">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr valign="top">
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr valign="top">
                    <td width="140"><span class="defaultFont specializedTexts">Name</span></td>
                    <td><div class="smallHeight"><!-- --></div></td>                
                    <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['first_name']." ".$fullDetails[0]['last_name'];?></span></td>                
                </tr>
                <tr valign="top">
                    <td><span class="defaultFont specializedTexts">Username</span></td>
                    <td><div class="smallHeight"><!-- --></div></td>                
                    <td><span class="defaultFont boldText"><?php echo $fullDetails[0]['username'];?></span></td>                
                </tr>
                <tr valign="top">
                    <td><span class="defaultFont specializedTexts">Email</span></td>
                    <td><div class="smallHeight"><!-- --></div></td>                
                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['email'] != "") ? $fullDetails[0]['email'] :  "<span class='font-normal';'>- not available -</span>";?></span></td>                
                </tr>        
                <tr valign="top">
                    <td><span class="defaultFont specializedTexts">Created at</span></td>
                    <td><div class="smallHeight"><!-- --></div></td>                
                    <td><span class="defaultFont boldText"><?php echo App_Viewer::format_date($fullDetails[0]['created_at']);?></span></td>                
                </tr>
                <tr valign="top">
                    <td><span class="defaultFont specializedTexts">Last Login</span></td>
                    <td><div class="smallHeight"><!-- --></div></td>                
                    <td><span class="defaultFont boldText"><?php echo ($fullDetails[0]['last_login'] != "0000-00-00") ? App_Viewer::format_date($fullDetails[0]['last_login']) : "Not logged";?></span></td>                            	
                </tr>
            </table> 
        </div>
    </div>
</div>