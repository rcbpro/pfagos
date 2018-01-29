<?php session_start(); require './../../lib/view.php'; require './../../lib/common_functions.php'; ?>
<?php require './../../models/preview.php'; ?>
<?php
	if (isset($_SESSION['id_for_preview'])){
		$prev_model = new Preview_model();
		$preview_details_in_pfac = $prev_model->load_data_for_preview_in_pfac($_SESSION['id_for_preview']);
		$history = $preview_details_in_pfac[0];
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PFA Client <?php echo (isset($_SESSION['id_for_preview'])) ? "Edit" : "Add";?> Preview</title>
<link href="http://devel.profootballagency.com/public/styles/global.css" type="text/css" rel="stylesheet" />
<link href="http://devel.profootballagency.com/public/styles/clients.css" type="text/css" rel="stylesheet" />
<link href="http://devel.profootballagency.com/public/styles/clients-menu.css" type="text/css" rel="stylesheet" />    
</head>
<style>
#right-column-wide{
	margin:0 auto !important;
	float:left;
	overflow:auto;
}	
#profile-box{
	margin-top:0px !important;
}
</style>
<style type="text/css">
.history-white-text-club-div{
	width:80px;
	height:22px;
	overflow:hidden;
}
.history-white-text-appearences-div{
	width:80px;
	height:22px;
	overflow:hidden;
}
.history-white-text-goals-div{
	width:42px;
	height:22px;
	overflow:hidden;
}
#pre-er{
	width:500px;
	margin:auto;
	padding-top:100px;
}
#pre-er u{
	font-weight:bold;
}
#pre-title{
	font-size:14px;
	color:#F00;
}
</style>
<body>

<?php
		if(
		   (empty($preview_details_in_pfac[1]['position'])) ||
		   (empty($preview_details_in_pfac[1]['club'])) ||
		   (empty($preview_details_in_pfac[1]['height'])) ||
		   (empty($preview_details_in_pfac[1]['weight'])) ||
		   (empty($preview_details_in_pfac[1]['comment'])) ||
		   (empty($history)) ||
		   (empty($preview_details_in_pfac[1]['photo_url'])) ||
		   (empty($preview_details_in_pfac[1]['cv_url']))
		   )
		{
			echo '<div id="pre-er">';
			echo '<div id="pre-title">Following fields are required to see the preview:</div><br/>';
			//General
			$ary_general = array(
				 "Position" => $preview_details_in_pfac[1]['position'], 
				 "Club" => $preview_details_in_pfac[1]['club'], 
				 "Height" => $preview_details_in_pfac[1]['height'],
				 "Weight" => $preview_details_in_pfac[1]['weight'],
				 "Comment" => $preview_details_in_pfac[1]['comment']
				 );
				 
			$message_general = "";	 
			foreach($ary_general as $each_key => $each_val){			
				if ((!isset($each_val)) || (empty($each_val))){
					$message_general .= ' - '.$each_key."<br />";
				}
				
			}
			if($message_general != ''){
				echo '<u>General Details</u><br/>';
				echo $message_general;
			}
			
			//history															
			if (empty($history)){
				echo '<br/><u>History Details</u><br/>';
			}
			
			//media
			/*
			$ary_media = array(
				 "img" => $preview_details_in_pfac[1]['photo_url'],
				 "cv" => $preview_details_in_pfac[1]['cv_url']
				 );
			*/
				 
			$message_media = "";
			if (empty($preview_details_in_pfac[1]['photo_url']) && empty($_SESSION['pfac_preview_img'])){
				$message_media .= ' - Photo<br/>';
			}
			if(empty($preview_details_in_pfac[1]['cv_url']) && empty($_SESSION['pfac_preview_cv'])){
				$message_media .= ' - CV';
			}
			/*	 
			foreach($ary_media as $each_key => $each_val){			
				if ((!isset($each_val)) || (empty($each_val))){	
					$message_media .= ' - '.$each_key."<br />";
				}				
			}
			*/
			
			if($message_media != ''){
				echo '<br/><u>Media Details</u><br/>';
				echo $message_media;
			}
			echo '</div></body></html>';
			exit();
		}
?>


<div id="right-column-wide">
    <div id="page-content-wide">
        <div id="profile-box">
            <div id="profile-box-curve-up"><!-- --></div>
            <div align="center" id="profile-box-middle">
            
               <!-- Start of the module 1 (Photo) -->                                             
               <img title="<?php 
								if (isset($_SESSION['pfac_general_reqired']['firstname'])){
									echo $_SESSION['pfac_general_reqired']['firstname'];
								}elseif (isset($_SESSION['id_for_preview'])){
									echo $preview_details_in_pfac[1]['first_name'];
								}else{
									echo "";			   									
								}?>&nbsp;<?php
								if (isset($_SESSION['pfac_general_reqired']['lastname'])){
									echo $_SESSION['pfac_general_reqired']['lastname'];
								}elseif (isset($_SESSION['id_for_preview'])){
									echo $preview_details_in_pfac[1]['last_name'];
								}else{
									echo "";			   
								}									
								?>"	
               src="<?php 
			   					if (isset($_SESSION['pfac_preview_img']) || isset($_SESSION['pre_pfac_preview_img']['path_prew'])){
									if(!isset($_SESSION['pfac_preview_img']['path_prew'])){
										echo $_SESSION['pre_pfac_preview_img']['path_prew'];
									}
									else{
										echo $_SESSION['pfac_preview_img']['path_prew'];
									}	
								}	
							?>">
               <!-- End of the module 2 -->                                       
               
               <!-- Start of the module 2 (Genral Information) -->                                 
               <div id="player-infomation-box">
                    <table cellspacing="0" cellpadding="0" border="0" class="data-table">
                        <tbody><tr>
                            <td class="info-blue-text">Name</td>
                            <td class="info-white-text"><?php 
															if (isset($_SESSION['pfac_general_reqired']['firstname'])){
																echo $_SESSION['pfac_general_reqired']['firstname'];
															}elseif (isset($_SESSION['id_for_preview'])){
																echo $preview_details_in_pfac[1]['first_name'];
															}else{
																echo "";
															}
														?>&nbsp;<?php 
															if (isset($_SESSION['pfac_general_reqired']['lastname'])){
																echo $_SESSION['pfac_general_reqired']['lastname'];
															}elseif (isset($_SESSION['id_for_preview'])){
																echo $preview_details_in_pfac[1]['last_name'];
															}else{
																echo "";
															}
														?></td>
                        </tr>
                        <tr class="gray-row">
                            <td class="info-blue-text">D.O.B.</td>
                            <td class="info-white-text"><?php 
															if (
																   (isset($_SESSION['pfac_general_reqired']['year'])) && 
																   (isset($_SESSION['pfac_general_reqired']['month'])) &&
																   (isset($_SESSION['pfac_general_reqired']['year']))
															   ){
																echo App_Viewer::format_date($_SESSION['pfac_general_reqired']['year'].
																							"-".$_SESSION['pfac_general_reqired']['month'].
																							"-".$_SESSION['pfac_general_reqired']['day']);
															}elseif (isset($_SESSION['id_for_preview'])){
																echo App_Viewer::format_date($preview_details_in_pfac[1]['date_of_birth']);
															}else{
																echo "";
															}							
															?></td>
                        </tr>
                        <tr>
                            <td class="info-blue-text">Nationality</td>
                            <td class="info-white-text"><?php 
															if (isset($_SESSION['pfac_general_reqired']['nationality'])){
																echo $_SESSION['pfac_general_reqired']['nationality'];
															}elseif (isset($_SESSION['id_for_preview'])){
																echo $preview_details_in_pfac[1]['nationality'];
															}else{
																echo "";
															}
															?></td>
                        </tr>
                        <tr class="gray-row">
                            <td class="info-blue-text">Club</td>
                            <td class="info-white-text"><?php 
															if (isset($_SESSION['pfac_general_non_reqired']['club'])){
																echo $_SESSION['pfac_general_non_reqired']['club'];
															}elseif (isset($_SESSION['id_for_preview'])){
																echo $preview_details_in_pfac[1]['club'];
															}else{
																echo "";
															}
															?></td>
                        </tr>
                        <tr>
                            <td class="info-blue-text">Height</td>
                            <td class="info-white-text"><?php 
															if (isset($_SESSION['pfac_general_non_reqired']['height'])){
																echo $_SESSION['pfac_general_non_reqired']['height'];
															}elseif (isset($_SESSION['id_for_preview'])){
																echo $preview_details_in_pfac[1]['height'];
															}else{
																echo "";
															}
															?></td>
                        </tr>
                        <tr class="gray-row">
                            <td class="info-blue-text">Weight</td>
                            <td class="info-white-text"><?php
                            								if (isset($_SESSION['pfac_general_non_reqired']['weight'])){
																echo $_SESSION['pfac_general_non_reqired']['weight'];
															}elseif (isset($_SESSION['id_for_preview'])){
																echo $preview_details_in_pfac[1]['weight'];
															}else{
																echo "";
															}
															?></td>

                        </tr>
                        <tr>
                            <td class="info-blue-text">Position</td>
                            <td class="info-white-text"><?php 
															if (isset($_SESSION['pfac_general_non_reqired']['position'])){
																echo $_SESSION['pfac_general_non_reqired']['position'];
															}elseif (isset($_SESSION['id_for_preview'])){
																echo $preview_details_in_pfac[1]['position'];
															}else{
																echo "";
															}
															?></td>
                        </tr>
                    </tbody></table>
                </div>
               <!-- End of the module 2 -->                        
                
               <!-- Start of the module 3 (Player History) -->                  
               <div id="player-history-box">
                    <table cellspacing="0" cellpadding="0" border="0" class="data-table">
                        <tbody><tr>
                            <td class="history-blue-text-club">Club</td>
                            <td class="history-blue-text-appearences">Appearences</td>
                            <td class="history-blue-text-goals">Goals</td>
                        </tr>
                        <?php if(isset($_SESSION['pfac_session_data'])):?>
							<?php for($i=0; $i<count($_SESSION['pfac_session_data']); $i++):?>
                            <?php $trClass = (CommonFunctions::checkNum($i)) ? "" : "gray-row";?>
                            <tr class="<?php echo $trClass;?>">
                                <td class="history-white-text-club"><div class="history-white-text-club-div"><?php echo $_SESSION['pfac_session_data'][$i]['field_1'];?></div></td>
                                <td class="history-white-text-appearences"><div class="history-white-text-appearences-div"><?php echo $_SESSION['pfac_session_data'][$i]['field_2'];?></div></td>
                                <td class="history-white-text-goals"><div class="history-white-text-goals-div"><?php echo $_SESSION['pfac_session_data'][$i]['field_3'];?></div></td>
                            </tr>
                            <?php endfor;?>                        
                        <?php elseif (isset($_SESSION['id_for_preview'])):?>
                        	<?php for($i=0; $i<count($preview_details_in_pfac[0]); $i++):?>
                            <?php $trClass = (CommonFunctions::checkNum($i)) ? "" : "gray-row";?>
                            <tr class="<?php echo $trClass;?>">
                                <td class="history-white-text-club"><div class="history-white-text-club-div"><?php echo $history [$i]['club'];?></div></td>
                                <td class="history-white-text-appearences"><div class="history-white-text-appearences-div"><?php echo $history [$i]['appearances'];?></div></td>
                                <td class="history-white-text-goals"><div class="history-white-text-goals-div"><?php echo $history[$i]['goals'];?></div></td>
                            </tr>                            	
                            <?php endfor;?>
                        <?php endif;?>
                    </tbody>
                  </table>
               </div>
               <!-- End of the module 3 -->        
                            
            </div>
            <div id="profile-box-curve-down"><!-- --></div>
         </div>
        <div id="profile-box-bottom">
        
            <!-- Start of the module 4 (video) -->
            <?php
				if(is_file($_SESSION['pfac_preview_video']['file_path_video'])){
					$video_url_path = $_SESSION['pfac_preview_video']['path_video'];
				}
				else{
					if(is_file($_SESSION['pre_pfac_preview_video']['file_path_video'])){
						$video_url_path = $_SESSION['pre_pfac_preview_video']['path_video'];
					}
					elseif(isset($_SESSION['pfac_preview_video']['name'])){
						$video_url_path = $_SESSION['pfac_preview_video']['name'];
					}
					elseif(isset($_SESSION['pre_pfac_preview_video']['name'])){
						$video_url_path = $_SESSION['pre_pfac_preview_video']['name'];
					}
				}
				$video_url_path = str_replace('http://','',$video_url_path);
			?>
        	<div id="player-video"><object width="450" height="390" flashvars="path=http://devel.profootballagency.com/_videos/video-player-grey.swf&amp;skinPath=http://devel.profootballagency.com/_videos/video-player-skin.swf&amp;videoPath=http://<?php echo $video_url_path;?>&amp;videoAutoPlay=false" data="http://devel.profootballagency.com/_videos/video-player-grey.swf" type="application/x-shockwave-flash"><param value="http://devel.profootballagency.com/_videos/video-player-grey.swf" name="movie"><param value="path=http://devel.profootballagency.com/_videos/video-player-grey.swf&amp;skinPath=http://devel.profootballagency.com/_videos/video-player-skin.swf&amp;videoPath=http://<?php echo $video_url_path; ?>&amp;videoAutoPlay=false" name="FlashVars"></object></div>
            <!-- End of the module 4 -->
                        
            <!-- Start of the module 5 (comments and more) -->
            <div id="quote">
                <span><!-- --></span>
                <p><?php 
						if (isset($_SESSION['pfac_general_non_reqired']['comment'])){
							echo $_SESSION['pfac_general_non_reqired']['comment'];
						}elseif (isset($_SESSION['id_for_preview'])){
							echo $preview_details_in_pfac[1]['comment'];
						}else{
							echo "";
						}											
					?></p>
            </div>
            <div id="more-box">
                <h2><em>More About</em></h2>
                <div class="more-box-data-row">
                    <span><a href="/contact-us/" title="Contact Us">Enquire about this player</a></span>
                    <span><a title="Download CV" href="<?php 
																				if (isset($_SESSION['pfac_preview_cv']) || isset($_SESSION['pre_pfac_preview_cv']['path_cv'])){
																					if(!isset($_SESSION['pfac_preview_cv'])){
																						echo $_SESSION['pre_pfac_preview_cv']['path_cv'];
																					}
																					else{
					   																	echo $_SESSION['pfac_preview_cv']['path_cv'];
																					}
																				}	
																				?>">Download CV</a></span>
                </div>
            </div>
            <!-- End of the module 5 -->
            
    	</div>
    </div>
</div>
</body>                
</html>