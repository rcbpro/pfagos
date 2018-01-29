<script language="javascript" type="text/javascript">
	tinyMCE.init({
	theme : "advanced",
	mode : "specific_textareas",
    editor_selector : "tinymce1",
	plugins : "bbcode",
	theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,search,replace,bullist,numlist,outdent,indent,blockquote,|,undo,redo,|,link,unlink,cleanup,insertdate,inserttime,preview,forecolor,backcolor,hr,sub,sup,charmap,emotions,iespell",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "center",
	theme_advanced_styles : "Code=codeStyle;Quote=quoteStyle",
/*	content_css : "css/bbcode.css",*/
	entity_encoding : "raw",
	add_unload_trigger : false,
	remove_linebreaks : false,
	inline_styles : false,
	convert_fonts_to_spans : false,
	height:"200px",
	width:"400px"
});
</script>
<form id="pfac_player_info_form" name="pfac_player_info_form" method="post" action="">	
<div align="center">
    <table border="0" cellpadding="0" cellspacing="0" class="pfac_fields_table">
    <tr>
        <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
    </tr> 
    <tr>
        <td><span class="defaultFont">Club</span></td>
        <td><div class="smallHeight"><span class="defaultFont webRequiredIndicator">*&nbsp;</span></div></td>                
        <td><input type="text" name="pfac_player_info_non_reqired[club]" 
                    value="<?php 
                                if (isset($_SESSION['pfac_player_info_non_reqired']['club'])){
                                    $club = $_SESSION['pfac_player_info_non_reqired']['club'];
                                }elseif (isset($fullDetails)){
                                    $club = $fullDetails[0]['club'];										
                                }else{
                                    $club = "";																				
                                }
                                echo trim($club);												
                             ?>" 
                    class="inputs" /></td>
    </tr>
    <tr>
        <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
    </tr>     
    <tr>
        <td><span class="defaultFont">Position</span></td>
        <td><div class="smallHeight"><span class="defaultFont webRequiredIndicator">*&nbsp;</span></div></td>                
        <td><input type="text" name="pfac_player_info_non_reqired[position]" 
                    value="<?php 
                                if (isset($_SESSION['pfac_player_info_non_reqired']['position'])){
                                    $position = $_SESSION['pfac_player_info_non_reqired']['position'];
                                }elseif (isset($fullDetails)){
                                    $position = $fullDetails[0]['position'];										
                                }else{
                                    $position = "";																				
                                }
                                echo trim($position);						
                             ?>" 
                    class="inputs" /></td>
    </tr>  
    <tr>
        <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
    </tr> 
    <tr>
        <td><span class="defaultFont">Height</span><span class="smallFont specializedTexts newColor">&nbsp;(feet/inches)</span></td>
        <td><div class="smallHeight"><span class="defaultFont webRequiredIndicator">*&nbsp;</span></div></td>                
        <td><input type="text" name="pfac_player_info_non_reqired[height]" 
                    value="<?php 
                                if (isset($_SESSION['pfac_player_info_non_reqired']['height'])){
                                    $height = $_SESSION['pfac_player_info_non_reqired']['height'];
                                }elseif (isset($fullDetails)){
                                    $height = $fullDetails[0]['height'];										
                                }else{
                                    $height = "";																				
                                }
                                echo trim($height);												
                             ?>" 
                    class="inputs" /></td>
    </tr>
    <tr>
        <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
    </tr>                                    
    <tr>
        <td><span class="defaultFont"><span class="defaultFont">Weight</span><span class="smallFont specializedTexts newColor">&nbsp;(kg)</span></td>
        <td><div class="smallHeight"><span class="defaultFont webRequiredIndicator">*&nbsp;</span></div></td>                
        <td><input type="text" name="pfac_player_info_non_reqired[weight]" 
                    value="<?php 
                                if (isset($_SESSION['pfac_player_info_non_reqired']['weight'])){
                                    $weight = $_SESSION['pfac_player_info_non_reqired']['weight'];
                                }elseif (isset($fullDetails)){
                                    $weight = $fullDetails[0]['weight'];										
                                }else{
                                    $weight = "";																				
                                }
                                echo trim($weight);																		
                             ?>" 
                    class="inputs" /></td>
    </tr>
    <tr>
        <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
    </tr>
    <tr>
        <td valign="top"><span class="defaultFont">Comment</span></td>
        <td valign="top"><div class="smallHeight"><span class="defaultFont webRequiredIndicator">*&nbsp;</span></div></td>               
        <td>
            <textarea class="tinymce1" id="commentTextArea" name="pfac_player_info_non_reqired[comment]" cols="85" rows="2"><?php 
                if (isset($_SESSION['pfac_player_info_non_reqired']['comment'])){
                    $comment = $_SESSION['pfac_player_info_non_reqired']['comment'];
                }elseif (isset($fullDetails)){
                    $comment = $fullDetails[0]['comment'];										
                }else{
                    $comment = "";																				
                }
                echo trim($comment);?>
            </textarea>
        </td>
    </tr> 
    <tr>
        <td colspan="2"><div class="smallHeight"><!-- --></div></td>                
    </tr>
    <tr>
        <td><div><!-- --></div></td>
        <td><div><!-- --></div></td>
        <td>
			<input onclick="location.href='<?php echo $site_config['base_url'];?>pfac/<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ?  "edit" : "add"; ?>/?mode=general<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? "&pfac_id=".$_GET['pfac_id'].((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1") : "";?>'" type="button" name="pfac_contact_back" value="Back to General Details" class="inputs submit" />&nbsp;        
        	<input type="submit" name="pfac_player_info_submit" value="<?php echo (!strstr($_SERVER['REQUEST_URI'], "edit")) ?  "Proceed to Contact Details" : "Save"; ?>" class="inputs submit" />
        </td>
    </tr>  
    </table>                         
</div>
</form>    