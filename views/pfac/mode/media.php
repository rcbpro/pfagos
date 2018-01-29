<script type="text/javascript" src="<?php echo $site_config['base_url'];?>public/js/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $site_config['base_url'];?>public/js/jquery.uploadify.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var max_photo_size = 4194304;
	var max_cv_size = 4194304;
	var max_video_size = 41943040;
	$("#file-photo").uploadify({
		'uploader'       : '../../../lib/uploader/uploadify.swf',
		'script'         : '../../../controllers/uploader.php',
		'scriptData'	 : {'msid':'<?php echo session_id();?>','type':'photo'},
		'cancelImg'      : '../../../public/images/cancel.png',
		'folder'         : '/user_uploads/temp',
		'queueID'        : 'queue-photo',
		'fileExt'		 : '*.jpg;*.gif;*.png;',
		'fileDesc'		 : 'Allowed file types : *.jpg, *.gif, *.png',
		'wmode'      	 : 'transparent',
		'buttonImg'		 : '../../../public/images/upload-photo.gif',
		'width'			 : '120','height' : '36',
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
								get_image();
						   }
						   
	});
	
	
	$("#file-cv").uploadify({
		'uploader'       : '../../../lib/uploader/uploadify.swf',
		'script'         : '../../../controllers/uploader.php',
		'scriptData'	 : {'msid':'<?php echo session_id();?>','type':'cv'},
		'cancelImg'      : '../../../public/images/cancel.png',
		'folder'         : '/user_uploads/temp',
		'queueID'        : 'queue-cv',
		'fileExt'		 : '*.doc;*.docx;*.rtf;*.pdf;',
		'fileDesc'		 : 'Allowed file types :  *.doc, *.docx, *.rtf, *.pdf',
		'wmode'      	 : 'transparent',
		'buttonImg'		 : '../../../public/images/upload-cv.gif',
		'width'			 : '120','height' : '36',
		'auto'           : 1,
		'multi'          : 0,
		'sizeLimit'		 : max_cv_size,
		'onSelect'		 : function(event,queueID,fileObj) {
		
						   },
		'onError'		 : function(event,queueID,fileObj,errorObj){
								if (errorObj['info'] == max_photo_size){
									$("#queue-cv").html("");
									$("#file-cv").uploadifyClearQueue();
									var f_name = fileObj['name'];
									var f_size = ((fileObj['size'])/(1024*1024)).toFixed(2);
									alert("Upload error... Maximum size is " + (max_photo_size/(1024*1024)) + "MB.\n\"" + f_name + "\" ("+f_size+"MB)");
								}
						   },
		'onComplete' 	 : function(){
								get_cv();
						   }
						   
	});
	
	$("#file-video").uploadify({
		'uploader'       : '../../../lib/uploader/uploadify.swf',
		'script'         : '../../../controllers/uploader.php',
		'scriptData'	 : {'msid':'<?php echo session_id();?>','type':'video'},
		'cancelImg'      : '../../../public/images/cancel.png',
		'folder'         : '/user_uploads/temp',
		'queueID'        : 'queue-video',
		'fileExt'		 : '*.avi;*.wmv;*.flv;*.mov;*.mp4;*.3gp;*.mpeg;',
		'fileDesc'		 : 'Allowed file types :  *.avi, *.wmv, *.flv, *.mov,*.mp4, *.3gp, *.mpeg;',
		'wmode'      	 : 'transparent',
		'buttonImg'		 : '../../../public/images/upload-video.gif',
		'width'			 : '120','height' : '36',
		'auto'           : 1,
		'multi'          : 0,
		'sizeLimit'		 : max_video_size,
		'onSelect'		 : function(event,queueID,fileObj) {
		
						   },
		'onError'		 : function(event,queueID,fileObj,errorObj){
								if (errorObj['info'] == max_video_size){
									$("#queue-video").html("");
									$("#file-video").uploadifyClearQueue();
									var f_name = fileObj['name'];
									var f_size = ((fileObj['size'])/(1024*1024)).toFixed(2);
									alert("Upload error... Maximum size is " + (max_video_size/(1024*1024)) + "MB.\n\"" + f_name + "\" ("+f_size+"MB)");
								}
						   },
		'onComplete' 	 : function(){
								get_video();
						   }
						   
	});
	
	
});
/*
	function check_to_upload(){
		$.ajax({
			type: "POST",
			data: "check-preview=true",
			url: "../../../lib/uploader/uploader-proccess.php",
			success: function(resdata){
				if (resdata == 1){
					$("#pfac_media_submit_preview").removeAttr("disabled");
					$("#pfac_media_submit_save").removeAttr("disabled");
				}
				else{
					$("#pfac_media_submit_preview").attr("disabled","disabled");
					$("#pfac_media_submit_save").attr("disabled","disabled");
				}
				
			}
		});
	}
*/
	function get_image(){
		$.ajax({
			type: "POST",
			data: "get-image-add=true",
			url: "../../../lib/uploader/uploader-proccess.php",
			success: function(resdata){
				$("#uploaded-img-wrap").css("display","none");
				$("#uploaded-img-wrap").html(resdata)
				$("#uploaded-img-wrap").fadeIn(1000)
			},
			complete: function(){
			}
		});
	}	
	
	function get_cv(){
		$.ajax({
			type: "POST",
			data: "get-cv=true&new=true",
			url: "../../../lib/uploader/uploader-proccess.php",
			success: function(resdata){
				$("#uploaded-cv-wrap-new").html(resdata);
				$("#d-cv").css("display","none");
				$("#d-cv").fadeIn("slow");
			},
			complete: function(){
			}
		});
	}
	
	function get_video(){
		$.ajax({
			type: "POST",
			data: "get-video=true&new=true",
			url: "../../../lib/uploader/uploader-proccess.php",
			success: function(resdata){
				$("#uploaded-video-wrap-new").html(resdata);
				$("#uploaded-video-new").css("display","none");
				$("#uploaded-video-new").fadeIn("slow");
				$("#txt_url_upload").attr("disabled","disabled");
			},
			complete: function(){
			}
		});
	}
	
	function remove_cv_new(){
		$.ajax({type: "POST",data: "remove-cv-new=true",url: "../../../lib/uploader/uploader-proccess.php",
			   success: function(resdata){
				   $("#uploaded-cv-new").fadeOut("medium");
				   $("#txt_url_upload").removeAttr("disabled");
				   $("#txt_url_upload").focus();
			   }
		});
	}
	$("#remove-cv-new").live("click", function(){remove_cv_new();});
	
	function remove_video_new(){
		$.ajax({type: "POST",data: "remove-video-new=true",url: "../../../lib/uploader/uploader-proccess.php",
			   success: function(resdata){
				   $("#uploaded-video-new").fadeOut("medium");
				   $("#txt_url_upload").removeAttr("disabled");
				   $("#txt_url_upload").focus();
			   }
		});
	}
	$("#remove-video-new").live("click", function(){remove_video_new();});
	
	
	
	/*
	function remove_image(){
		$.ajax({type: "POST",url: "/admin/remove_image",data: "ajx=true",success: function(resdata){},complete: function(){}});
	}
	$("#remove-img").live("click", function(){$("#d-img").fadeOut(250,function(){$("#d-img").remove();$("#uploaded-img").remove();});remove_image();});
	*/	
	function remove_image_new(){
		$.ajax({type: "POST",url: "../../../lib/uploader/uploader-proccess.php",data: "remove-img-new=true",
			   success: function(resdata){
				   	$("#uploaded-img-new").fadeOut("medium");
					$("#uploaded-img-wrap").html(resdata);
					$("#uploaded-img-current").css("display","none");
					$("#uploaded-img-current").fadeIn("slow");
			   },
			   complete: function(){
			   }
		});
	}
	$("#remove-img-new").live("click", 
		function(){
			$("#d-img-new").fadeOut(250,function(){
				$("#d-img-new").remove();$("#uploaded-img-new").remove();
			});
		remove_image_new();
	});

	$(document).ready(function(){

		$("#txt_url_upload").focusout(function() {
			var val_url = $("#txt_url_upload").val();
			
			if($.trim(val_url) != ""){
				val_url = encodeURIComponent(val_url);
				$.ajax({
					type: "POST",
					data: "upload-url=true&val="+val_url,
					url: "../../../lib/uploader/uploader-proccess.php",
					success: function(resdata){
					},
					complete: function(){
					}
				});
			}
		});
	});

</script>

<div id="file-upload">
	<div id="file-upload-l">
        <div class="upload-row upload-row-cv">
            <div class="queue-file"><input type="file" name="file-cv" id="file-cv" class="hide-file" /></div>
            <div id="uploaded-area">
                <div id="queue-cv"></div>
            </div>
        </div>
        <div id="uploaded-cv-wrap-new">
            <?php
                if(isset($_SESSION['pfac_preview_cv'])){
                    $cv_name = $_SESSION['pfac_preview_cv']['name'];
                    $ary = explode('_', $cv_name, 2);
                    $cv_name_real = $ary[1];
                    $cv_path = $_SESSION['pfac_preview_cv']['path_cv'];
                    echo '<div id="uploaded-cv-new"><div id="d-cv-new">'.$cv_name_real.' <span id="remove-cv-new"> [remove] </span></div></div>';
                }
            ?>
        </div>
        <?php if ($_SESSION['pfac_general_reqired']['player_cat'] != 5):?>
		
        <div class="upload-row upload-row-video">
            <div class="queue-file"><input type="file" name="file-video" id="file-video" class="hide-file" /></div>
            <div id="uploaded-area">
                <div id="queue-video"></div>
            </div>
        </div>
        <div id="uploaded-video-wrap-new">
            <?php
                if(isset($_SESSION['pfac_preview_video']['file_path_video'])){
                    $video_name = $_SESSION['pfac_preview_video']['name'];
                    $ary = explode('_', $video_name, 2);
                    $video_name_real = $ary[1];
                    $video_path = $_SESSION['pfac_preview_video']['path_video'];
                    echo '<div id="uploaded-video-new"><div id="d-video-new">'.$video_name_real.' <span id="remove-video-new"> [remove] </span></div></div>';
                }
            ?>
        </div>
        <?php endif;?>
        <div class="upload-row upload-row-photo">
            <div class="queue-file"><input type="file" name="file-photo" id="file-photo" class="hide-file" /></div>
            <div id="uploaded-area">
                <div id="queue-photo"></div>
            </div>
        </div>
    
        <div id="uploaded-img-wrap">            	
            <?php 
                if(isset($_SESSION['pfac_preview_img'])){
                    $img_path = $_SESSION['pfac_preview_img']['path_thumb'];
                    $img_name = $_SESSION['pfac_preview_img']['name'];
                    $ary = explode('_', $img_name, 2);
                    $img_name_real = $ary[1];
                    
                    $img_display_width = $_SESSION['pfac_preview_img']['display_width'];
                    echo '<div id="uploaded-img-new" align="center"><div id="d-img-new"><div id="remove-img-new" class="remove-img" title="Remove image"></div><img title="'.$img_name_real.'" alt="'.$img_name_real.'" src="'.$img_path.'" width="'.$img_display_width.'" /></div></div>';
                }
            ?>
        </div>
    </div>
    
    <div id="file-upload-r">
    	<div id="upload-tips">
        	<span class="defaultFont webRequiredIndicator">* CV and photo are required to publish for the web.</span><br />
        </div>
		<div id="url-upload">
	        <span class="defaultFont specializedTexts">If you don't have a video to upload, enter a video url here.</span><br />
            <?php
				$disabled = '';
				if(!isset($_SESSION['pfac_preview_video']['file_path_video'])){
					$value = $_SESSION['pfac_preview_video']['name'];		
				}
				else{
					$disabled = 'disabled="disabled"';
				}
			?>
            <input type="text" id="txt_url_upload" <?php echo $disabled;?> value="<?php echo $value;?>" class="url-input" />
        </div>
    </div>
</div>
<br />
<div align="center">
<form name="pfac_media_form2" action="" method="post">
    <input type="button" id="pfac_media_submit_preview" name="pfac_media_submit_preview" value="Preview" class="inputs submit" onclick="javascript:popup('<?php echo $site_config['base_url'];?>views/previews/preview-pfa-add.php');" />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                
    <input type="button" name="pfac_media_back" value="Back to History Details" class="inputs submit" onclick="location.href='<?php echo $site_config['base_url'];?>pfac/<?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ?  "edit" : "add"; ?>/?mode=<?php echo ($_SESSION['pfac_general_reqired']['player_cat'] == 5) ? "coach-history" : "history";?><?php echo (strstr($_SERVER['REQUEST_URI'], "edit")) ? "&pfac_id=".$_GET['pfac_id'].((isset($_GET['page'])) ? "&page=".$_GET['page'] : "&page=1") : "";?>'" />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input id="pfac_media_submit_save" type="submit" name="pfac_media_submit_save" value="Save &amp; Proceed to Notes" class="inputs submit" />
</form>    
</div>