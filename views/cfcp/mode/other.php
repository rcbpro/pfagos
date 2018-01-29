<script type="text/javascript" src="<?php echo $site_config['base_url'];?>public/js/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $site_config['base_url'];?>public/js/jquery.uploadify.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	var max_photo_size = 4194304;
	var max_cv_size = 4194304;
	var max_video_size = 41943040;
	$("#file-bc").uploadify({
		'uploader'       : '../../../lib/uploader/uploadify.swf',
		'script'         : '../../../controllers/uploader-cfcp.php',
		'scriptData'	 : {'msid':'<?php echo session_id();?>','type':'bc'},
		'cancelImg'      : '../../../public/images/cancel.png',
		'folder'         : '/user_uploads/temp',
		'queueID'        : 'queue-bc',
		'fileExt'		 : '*.doc;*.docx;*.rtf;*.pdf;',
		'fileDesc'		 : 'Allowed file types :  *.doc, *.docx, *.rtf, *.pdf',
		'wmode'      	 : 'transparent',
		'buttonImg'		 : '../../../public/images/upload-default.gif',
		'width'			 : '30','height' : '22',
		'auto'           : 1,
		'multi'          : 0,
		'sizeLimit'		 : max_photo_size,
		'onSelect'		 : function(event,queueID,fileObj) {
		
						   },
		'onError'		 : function(event,queueID,fileObj,errorObj){								
								if (errorObj['info'] == max_photo_size){
									$("#queue-photo").html("");
									$("#file-photo").uploadifyClearQueue();
									var f_name = fileObj['name'];
									var f_size = ((fileObj['size'])/(1024*1024)).toFixed(2);
									alert("Upload error... Maximum size is " + (max_photo_size/(1024*1024)) + "MB.\n\"" + f_name + "\" ("+f_size+"MB)");
								}	
						   },
		'onComplete' 	 : function(){
								get_bc();
						   }
						   
	});
	
	/*
	function get_bc(){
		$.ajax({
			type: "POST",
			data: "get-bc=true",
			url: "../../../lib/uploader/uploader-proccess-cfcp.php",
			success: function(resdata){
				$("#txt-bc").val(resdata);
			},
			complete: function(){
			}
		});
	}
	*/
	
	$("#file-reg").uploadify({
		'uploader'       : '../../../lib/uploader/uploadify.swf',
		'script'         : '../../../controllers/uploader-cfcp.php',
		'scriptData'	 : {'msid':'<?php echo session_id();?>','type':'reg'},
		'cancelImg'      : '../../../public/images/cancel.png',
		'folder'         : '/user_uploads/temp',
		'queueID'        : 'queue-reg',
		'fileExt'		 : '*.doc;*.docx;*.rtf;*.pdf;',
		'fileDesc'		 : 'Allowed file types :  *.doc, *.docx, *.rtf, *.pdf',
		'wmode'      	 : 'transparent',
		'buttonImg'		 : '../../../public/images/upload-default.gif',
		'width'			 : '30','height' : '22',
		'auto'           : 1,
		'multi'          : 0,
		'sizeLimit'		 : max_photo_size,
		'onSelect'		 : function(event,queueID,fileObj) {
		
						   },
		'onError'		 : function(event,queueID,fileObj,errorObj){								
								if (errorObj['info'] == max_photo_size){
									$("#queue-photo").html("");
									$("#file-photo").uploadifyClearQueue();
									var f_name = fileObj['name'];
									var f_size = ((fileObj['size'])/(1024*1024)).toFixed(2);
									alert("Upload error... Maximum size is " + (max_photo_size/(1024*1024)) + "MB.\n\"" + f_name + "\" ("+f_size+"MB)");
								}	
						   },
		'onComplete' 	 : function(){
								get_reg();
						   }
						   
	});
	
	/*
	function get_reg(){
		$.ajax({
			type: "POST",
			data: "get-reg=true",
			url: "../../../lib/uploader/uploader-proccess-cfcp.php",
			success: function(resdata){
				$("#txt-reg").val(resdata);
			},
			complete: function(){
			}
		});
	}
	*/
	
	$("#file-ps").uploadify({
		'uploader'       : '../../../lib/uploader/uploadify.swf',
		'script'         : '../../../controllers/uploader-cfcp.php',
		'scriptData'	 : {'msid':'<?php echo session_id();?>','type':'ps'},
		'cancelImg'      : '../../../public/images/cancel.png',
		'folder'         : '/user_uploads/temp',
		'queueID'        : 'queue-ps',
		'fileExt'		 : '*.jpg;*.jpeg;*.gif;*.pdf;',
		'fileDesc'		 : 'Allowed file types :  *.jpg, *.gif, *.pdf',
		'wmode'      	 : 'transparent',
		'buttonImg'		 : '../../../public/images/upload-default.gif',
		'width'			 : '30','height' : '22',
		'auto'           : 1,
		'multi'          : 0,
		'sizeLimit'		 : max_photo_size,
		'onSelect'		 : function(event,queueID,fileObj) {
		
						   },
		'onError'		 : function(event,queueID,fileObj,errorObj){								
								if (errorObj['info'] == max_photo_size){
									$("#queue-photo").html("");
									$("#file-photo").uploadifyClearQueue();
									var f_name = fileObj['name'];
									var f_size = ((fileObj['size'])/(1024*1024)).toFixed(2);
									alert("Upload error... Maximum size is " + (max_photo_size/(1024*1024)) + "MB.\n\"" + f_name + "\" ("+f_size+"MB)");
								}	
						   },
		'onComplete' 	 : function(){
								get_ps();
						   }
						   
	});
	
	//passport
	function get_ps(){
		$.ajax({
			type: "POST",
			data: "get-ps=true",
			url: "../../../lib/uploader/uploader-proccess-cfcp.php",
			success: function(resdata){
				$("#txt-ps").val(resdata);
				$("#rem-ps").fadeIn(250);
			},
			complete: function(){
			}
		});
	}
	
	$("#rem-ps").click(function() {
		$.ajax({
			type: "POST",
			data: "remove-ps=true",
			url: "../../../lib/uploader/uploader-proccess-cfcp.php",
			success: function(resdata){
				$("#txt-ps").val("");
				$("#rem-ps").fadeOut(250);
			},
			complete: function(){
			}
		});
	});
	
	$("#rem-pre-ps").click(function() {
		if(confirm("This will remove permanently.\nAre you sure?")){
			$.ajax({
				type: "POST",
				data: "remove-pre-ps=true",
				url: "../../../lib/uploader/uploader-proccess-cfcp.php",
				success: function(resdata){
					$("#txt-ps").val("");
					$("#rem-pre-ps").fadeOut(250);
				},
				complete: function(){
				}
			});
		}
	});
	
	
	//bc
	function get_bc(){
		$.ajax({
			type: "POST",
			data: "get-bc=true",
			url: "../../../lib/uploader/uploader-proccess-cfcp.php",
			success: function(resdata){
				$("#txt-bc").val(resdata);
				$("#rem-bc").fadeIn(250);
			},
			complete: function(){
			}
		});
	}
	
	$("#rem-bc").click(function() {
		$.ajax({
			type: "POST",
			data: "remove-bc=true",
			url: "../../../lib/uploader/uploader-proccess-cfcp.php",
			success: function(resdata){
				$("#txt-bc").val("");
				$("#rem-bc").fadeOut(250);
			},
			complete: function(){
			}
		});
	});
	
	$("#rem-pre-bc").click(function() {
		if(confirm("This will remove permanently.\nAre you sure?")){
			$.ajax({
				type: "POST",
				data: "remove-pre-bc=true",
				url: "../../../lib/uploader/uploader-proccess-cfcp.php",
				success: function(resdata){
					$("#txt-bc").val("");
					$("#rem-pre-bc").fadeOut(250);
				},
				complete: function(){
				}
			});
		}
	});
	
	
	//reg
	function get_reg(){
		$.ajax({
			type: "POST",
			data: "get-reg=true",
			url: "../../../lib/uploader/uploader-proccess-cfcp.php",
			success: function(resdata){
				$("#txt-reg").val(resdata);
				$("#rem-reg").fadeIn(250);
			},
			complete: function(){
			}
		});
	}
	
	$("#rem-reg").click(function() {
		$.ajax({
			type: "POST",
			data: "remove-reg=true",
			url: "../../../lib/uploader/uploader-proccess-cfcp.php",
			success: function(resdata){
				$("#txt-reg").val("");
				$("#rem-reg").fadeOut(250);
			},
			complete: function(){
			}
		});
	});
	
	$("#rem-pre-reg").click(function() {
		if(confirm("This will remove permanently.\nAre you sure?")){
			$.ajax({
				type: "POST",
				data: "remove-pre-reg=true",
				url: "../../../lib/uploader/uploader-proccess-cfcp.php",
				success: function(resdata){
					$("#txt-reg").val("");
					$("#rem-pre-reg").fadeOut(250);
				},
				complete: function(){
				}
			});
		}
	});
	
});
</script>
<?php /*?><link type="text/css" href="<?php echo $site_config['base_url'];?>public/css/jquery.ui.base.css" rel="stylesheet" />
<link type="text/css" href="<?php echo $site_config['base_url'];?>public/css/jquery.ui.theme.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $site_config['base_url'];?>public/js/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo $site_config['base_url'];?>public/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo $site_config['base_url'];?>public/js/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
$(function() {
	$("#txt-boots-received").datepicker();
	$.datepicker.formatDate('yy-mm-dd');
});
</script>
<?php */?>
<form name="cfcp_other_form" method="post" action="">
<div align="center">	
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="pfac_fields_table">
        <tr>
            <td colspan="3"><div class="smallHeight2"><!-- --></div></td>                
        </tr>  
        <tr>
            <td width="200"><span class="defaultFont">School</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_other_non_reqired[school]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_other_non_reqired']['school'])){
										$school = $_SESSION['cfcp_other_non_reqired']['school'];
									}elseif (isset($fullDetails)){
										$school = $fullDetails[0]['school'];										
									}else{
										$school = "";																				
									}
									echo stripcslashes(trim($school));
								 ?>" 
                        class="inputs" /></td>
        </tr>    
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                 
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Current Class</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_other_non_reqired[curr_class]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_other_non_reqired']['curr_class'])){
										$curr_class = $_SESSION['cfcp_other_non_reqired']['curr_class'];
									}elseif (isset($fullDetails)){
										$curr_class = $fullDetails[0]['current_class'];										
									}else{
										$curr_class = "";																				
									}
									echo stripcslashes(trim($curr_class));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td width="194"><span class="defaultFont">Position 1</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td>
            	<div class="longSelectBoxWrapDiv">            
                    <select class="longSelectBox" name="cfcp_other_non_reqired[position1]">
                        <option value=""> --------------- select --------------- </option>
                        <?php foreach($postions_in_cfcp as $value):?>
                        <option value="<?php echo $value;?>"<?php 
  							  $selected = "";	
						      if (
							  	 (isset($fullDetails)) && 
							  	 ($value == $fullDetails[0]['position1'])
								 ){
								echo "selected = 'selected'";
							  }elseif (
							  		  (isset($_SESSION['cfcp_other_non_reqired']['position1'])) && 
							  		  ($value == $_SESSION['cfcp_other_non_reqired']['position1'])
									  ){
								echo "selected = 'selected'";
							  }else{
								echo "";
							  }?>><?php echo $value;?></option>
                        <?php endforeach;?>                                                
                </select>
                </div>                
            </td>
        </tr>                                           
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td width="194"><span class="defaultFont">Position 2</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td>
            	<div class="longSelectBoxWrapDiv">            
                    <select class="longSelectBox" name="cfcp_other_non_reqired[position2]">
                        <option value=""> --------------- select --------------- </option>
                        <?php foreach($postions_in_cfcp as $value):?>
                        <option value="<?php echo $value;?>"<?php 
  							  $selected = "";	
						      if (
							  	 (isset($fullDetails)) && 
							  	 ($value == $fullDetails[0]['position2'])
								 ){
								echo "selected = 'selected'";
							  }elseif (
							  		  (isset($_SESSION['cfcp_other_non_reqired']['position2'])) && 
							  		  ($value == $_SESSION['cfcp_other_non_reqired']['position2'])
									  ){
								echo "selected = 'selected'";
							  }else{
								echo "";
							  }?>><?php echo $value;?></option>
                        <?php endforeach;?>                                                
                </select>
                </div>                
            </td>
        </tr>                                           
        
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Boot Size</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td><input type="text" name="cfcp_other_non_reqired[boot_size]" 
                        value="<?php 
									if (isset($_SESSION['cfcp_other_non_reqired']['boot_size'])){
										$boot_size = $_SESSION['cfcp_other_non_reqired']['boot_size'];
									}elseif (isset($fullDetails)){
										$boot_size = $fullDetails[0]['boot_size'];										
									}else{
										$boot_size = "";																				
									}
									echo stripcslashes(trim($boot_size));
								 ?>" 
                        class="inputs" /></td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                        
        <tr>
            <td><span class="defaultFont">Boots received date</span></td>
            <td><div class="smallHeight"><!-- --></div></td>                
            <td>
				<?php 
					if (isset($_SESSION['cfcp_other_non_reqired']['day']) && isset($_SESSION['cfcp_other_non_reqired']['month']) && isset($_SESSION['cfcp_other_non_reqired']['year'])){
						$day = $_SESSION['cfcp_other_non_reqired']['day'];
						$month = $_SESSION['cfcp_other_non_reqired']['month'];
						$year = $_SESSION['cfcp_other_non_reqired']['year'];
                        $required_status = false;						
					}elseif (isset($fullDetails)){
						$boots_received = explode("-", $fullDetails[0]['boots_received']);
						$day = $boots_received[2];
						$month = $boots_received[1];						
						$year = $boots_received[0];						
					}else{
						$day = $month = $year = "";
					}
                    echo CommonFunctions::print_date_selecting_drop_down("cfcp_other_non_reqired", $day, $month, $year, $submitStatus, @$_SESSION['date_input_error_2'], $_SERVER['REQUEST_URI'], $required_status);
                ?>
              </td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr> 
        <tr>
            <td><span class="defaultFont">Upload player's Birth Certificate</span></td>
            <td><div class="smallHeight"><!-- --></div></td>
            <td>
            	<?php
					if(isset($_SESSION['cfcp_preview_bc'])){
						$bc_name = $_SESSION['cfcp_preview_bc']['name'];
						$ary = explode('_', $bc_name, 2);
						$bc_name_real = $ary[1];
					}
					else{
						$pre_bc_file_path = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/birth_certificates/'.$pre_bc_name;
						$_SESSION['pre_cfcp_preview_bc']['name'] = $pre_bc_name;
						if(is_file($pre_bc_file_path)){
							$bc_name = $_SESSION['pre_cfcp_preview_bc']['name'];
							$ary = explode('_', $bc_name, 2);
							$bc_name_real = $ary[1];
						}
					}
				?>
                <div class="bc-wrap">
                	<div class="bc-input-d"><input id="txt-bc" readonly="readonly" class="inputs <?php echo ((isset($_SESSION['cfcp_reqired_errors'])) && ($_SESSION['cfcp_reqired_errors'] == "passport_scan")) ? "errorsIndicatedFields" : ""; ?>" type="text"  value="<?php echo $bc_name_real;?>" style="width:164px;" /></div><div title="Browse Passport scan" class="queue-file-bc"><input type="file" name="file-bc" class="hide-file" id="file-bc" /></div>
                    <?php
					$dis = '';
					if(isset($_SESSION['cfcp_preview_bc'])){
						$dis = 'style="display:block"';
					}
                    ?>
                    <div id="rem-bc" <?php echo $dis;?> title="Click to remove">[remove]</div>
                    <?php
						if(is_file($pre_bc_file_path)){ ?>
							<div id="rem-pre-bc" <?php echo $dis;?> title="Click to remove">[remove]</div>

					<?php }?>
                </div>
            </td>
        </tr>
        <tr>
        	<td colspan="3">
            	<div class="upload-row">
                    <div id="uploaded-area">
                        <div id="queue-bc"></div>
                    </div>
                </div>
            </td>
        </tr>        
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Upload player's <span class="specializedTexts"><?php echo $reg_card_type;?></span> <br />registration card here...</span></td>
            <td><div class="smallHeight"><!-- --></div></td>
            <td>
            	<?php
					if(isset($_SESSION['cfcp_preview_reg'])){
						$reg_name = $_SESSION['cfcp_preview_reg']['name'];
						$ary = explode('_', $reg_name, 2);
						$reg_name_real = $ary[1];
					}
					else{
						$pre_reg_file_path = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/reg_cards/'.$pre_reg_name;
						$_SESSION['pre_cfcp_preview_reg']['name'] = $pre_reg_name;
						if(is_file($pre_reg_file_path)){
							$reg_name = $_SESSION['pre_cfcp_preview_reg']['name'];
							$ary = explode('_', $reg_name, 2);
							$reg_name_real = $ary[1];
						}
					}
				?>
                <div class="reg-wrap">
                	<div class="reg-input-d"><input id="txt-reg" readonly="readonly" class="inputs <?php echo ((isset($_SESSION['cfcp_reqired_errors'])) && ($_SESSION['cfcp_reqired_errors'] == "passport_scan")) ? "errorsIndicatedFields" : ""; ?>" type="text"  value="<?php echo $reg_name_real;?>" style="width:164px;" /></div><div title="Browse Passport scan" class="queue-file-reg"><input type="file" name="file-reg" class="hide-file" id="file-reg" /></div>
                    <?php
					$dis = '';
					if(isset($_SESSION['cfcp_preview_reg'])){
						$dis = 'style="display:block"';
					}
                    ?>
                    <div id="rem-reg" <?php echo $dis;?> title="Click to remove">[remove]</div>
                    <?php
						if(is_file($pre_reg_file_path)){ ?>
							<div id="rem-pre-reg" <?php echo $dis;?> title="Click to remove">[remove]</div>

					<?php }?>
                </div>
            </td>
        </tr>
        <tr>
	        <td colspan="3">
            	<div class="upload-row">
                    <div id="uploaded-area">
                        <div id="queue-reg"></div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                    
        <tr>
            <td><span class="defaultFont"><span class="defaultFont">Upload player's Passport Scan</span></td>
            <td><div class="smallHeight"><!-- --></div></td>
            <td>
            	<?php
					if(isset($_SESSION['cfcp_preview_ps'])){
						$ps_name = $_SESSION['cfcp_preview_ps']['name'];
						$ary = explode('_', $ps_name, 2);
						$ps_name_real = $ary[1];
					}
					else{
						$pre_ps_file_path = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/passport_scans/'.$pre_ps_name;
						$_SESSION['pre_cfcp_preview_ps']['name'] = $pre_ps_name;
						if(is_file($pre_ps_file_path)){
							$ps_name = $_SESSION['pre_cfcp_preview_ps']['name'];
							$ary = explode('_', $ps_name, 2);
							$ps_name_real = $ary[1];
						}
					}
				?>
                <div class="ps-wrap">
                	<div class="ps-input-d"><input id="txt-ps" readonly="readonly" class="inputs <?php echo ((isset($_SESSION['cfcp_reqired_errors'])) && ($_SESSION['cfcp_reqired_errors'] == "passport_scan")) ? "errorsIndicatedFields" : ""; ?>" type="text"  value="<?php echo $ps_name_real;?>" style="width:164px;" /></div><div title="Browse Passport scan" class="queue-file-ps"><input type="file" name="file-ps" class="hide-file" id="file-ps" /></div>
                    <?php
					$dis = '';
					if(isset($_SESSION['cfcp_preview_ps'])){
						$dis = 'style="display:block"';
					}
                    ?>
                    <div id="rem-ps" <?php echo $dis;?> title="Click to remove">[remove]</div>
                    <?php
						if(is_file($pre_ps_file_path)){ ?>
							<div id="rem-pre-ps" <?php echo $dis;?> title="Click to remove">[remove]</div>

					<?php }?>
                </div>
            </td>
        </tr>
        <tr>
	        <td colspan="3">
            	<div class="upload-row">
                    <div id="uploaded-area">
                        <div id="queue-ps"></div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3"><div class="smallHeight"><!-- --></div></td>                
        </tr>                                                                            
        <tr>
            <td class="a-center" colspan="3" valign="top">                
				<input onclick="location.href='<?php echo $site_config['base_url'];?>cfcp/<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ?  "edit" : "add"; ?>/?mode=contact<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? "&cfcp_id=".$_GET['cfcp_id'].((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1") : "";?>'" type="button" name="cfcp_contact_back" value="Back to Contact Details" class="inputs submit" />&nbsp;            	
            	<input type="submit" name="cfcp_other_submit" value="<?php echo (!strstr($_SERVER['REQUEST_URI'], "edit")) ?  "Proceed to Next Step" : "Save"; ?>" class="inputs submit" />
            </td>
        </tr>
    </table>
</div>
</form>