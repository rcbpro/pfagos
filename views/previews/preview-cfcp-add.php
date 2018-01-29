<?php session_start(); require './../../lib/view.php'; require './../../lib/common_functions.php'; ?>
<?php require './../../models/cfcp_preview.php'; ?>
<?php
	if (isset($_SESSION['id_for_preview_cfcp'])){
		$prev_model = new Preview_model();
		$preview_details_in_cfcp = $prev_model->load_data_for_preview_in_cfcp($_SESSION['id_for_preview_cfcp']);
		$history = $preview_details_in_cfcp[1];
	}		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CFC Client <?php echo (isset($_SESSION['id_for_preview_cfcp'])) ? "Edit" : "Add";?> Preview</title>
<link href="http://devel.profootballagency.com/public/styles/global.css" type="text/css" rel="stylesheet" />
<link href="http://devel.profootballagency.com/public/styles/clients.css" type="text/css" rel="stylesheet" />
<link href="http://devel.profootballagency.com/public/styles/clients-menu.css" type="text/css" rel="stylesheet" />
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
</style>
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
<body>
<?php
		if(
		   (empty($_SESSION['cfcp_senior_non_reqired']['height'])) ||
		   (empty($_SESSION['cfcp_senior_non_reqired']['weight'])) ||
		   (empty($_SESSION['cfcp_senior_non_reqired']['birth_place'])) ||
		   (empty($_SESSION['cfcp_senior_non_reqired']['pos'])) ||
		   (empty($_SESSION['cfcp_session_data'])) ||
		   (!isset($_SESSION['cfcp_preview_img']))
		   )
		{
			echo '<div id="pre-er">';
			echo '<div id="pre-title">Following fields are required to see the preview:</div><br/>';
			//General
			$ary_general = array(
								 "Position" => $_SESSION['cfcp_senior_non_reqired']['pos'], 
								 "Height" => $_SESSION['cfcp_senior_non_reqired']['height'], 
								 "Weight" => $_SESSION['cfcp_senior_non_reqired']['weight'],
								 "Birth Place" => $_SESSION['cfcp_senior_non_reqired']['birth_place']
				 				);
				 
			$message_general = "";	 
			foreach($ary_general as $each_key => $each_val){			
				if ((!isset($each_val)) || (empty($each_val))){
					$message_general .= ' - '.$each_key."<br />";
				}
				
			}
			if($message_general != ''){
				echo '<u>Senior Player Details</u><br/>';
				echo $message_general;
			}
			
			//history															
			if (empty($_SESSION['cfcp_session_data'])){
				echo '<br/><u>History Details</u><br/>';
				echo ' - Season<br/>';
				echo ' - Team<br/>';
				echo ' - Appearances<br/>';
				echo ' - Goals<br/>';				
			}
			
			//media
			$ary_media = array("Photo" => $_SESSION['cfcp_preview_img']);
				 
			$message_media = "";	 
			foreach($ary_media as $each_key => $each_val){			
				if ((!isset($each_val)) || (empty($each_val))){	
					$message_media .= ' - '.$each_key."<br />";
				}				
			}
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
								if (isset($_SESSION['cfcp_general_reqired']['firstname'])){
									echo $_SESSION['cfcp_general_reqired']['firstname'];
								}elseif (isset($_SESSION['id_for_preview_cfcp'])){
									echo $preview_details_in_cfcp[0]['first_name'];
								}else{
									echo "";			   									
								}?>&nbsp;<?php
								if (isset($_SESSION['cfcp_general_reqired']['lastname'])){
									echo $_SESSION['cfcp_general_reqired']['lastname'];
								}elseif (isset($_SESSION['id_for_preview_cfcp'])){
									echo $preview_details_in_cfcp[0]['last_name'];
								}else{
									echo "";			   
								}									
								?>"	
               src="<?php 
			   					if (isset($_SESSION['cfcp_preview_img']) || isset($_SESSION['pre_cfcp_preview_img']['path_prew'])){
									if(!isset($_SESSION['cfcp_preview_img']['path_prew'])){
										echo $_SESSION['pre_cfcp_preview_img']['path_prew'];
									}else{
										echo $_SESSION['cfcp_preview_img']['path_prew'];
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
															if (isset($_SESSION['cfcp_general_reqired']['firstname'])){
																echo $_SESSION['cfcp_general_reqired']['firstname'];
															}elseif (isset($_SESSION['id_for_preview_cfcp'])){
																echo $preview_details_in_cfcp[0]['first_name'];
															}else{
																echo "";
															}
														?>&nbsp;<?php 
															if (isset($_SESSION['cfcp_general_reqired']['lastname'])){
																echo $_SESSION['cfcp_general_reqired']['lastname'];
															}elseif (isset($_SESSION['id_for_preview_cfcp'])){
																echo $preview_details_in_cfcp[0]['last_name'];
															}else{
																echo "";
															}
														?></td>
                        </tr>
                        <tr class="gray-row">
                            <td class="info-blue-text">D.O.B.</td>
                            <td class="info-white-text"><?php 
															if (
																   (isset($_SESSION['cfcp_general_reqired']['year'])) && 
																   (isset($_SESSION['cfcp_general_reqired']['month'])) &&
																   (isset($_SESSION['cfcp_general_reqired']['year']))
															   ){
																echo App_Viewer::format_date($_SESSION['cfcp_general_reqired']['year'].
																							"-".$_SESSION['cfcp_general_reqired']['month'].
																							"-".$_SESSION['cfcp_general_reqired']['day']);
															}elseif (isset($_SESSION['id_for_preview_cfcp'])){
																echo App_Viewer::format_date($preview_details_in_cfcp[0]['date_of_birth']);
															}else{
																echo "";
															}							
															?></td>
                        </tr>
                        <tr>
                            <td class="info-blue-text">Place of Birth</td>
                            <td class="info-white-text"><?php 
															if (isset($_SESSION['cfcp_senior_non_reqired']['birth_place'])){
																echo $_SESSION['cfcp_senior_non_reqired']['birth_place'];
															}elseif (isset($_SESSION['id_for_preview_cfcp'])){
																echo $preview_details_in_cfcp[0]['birth_place'];
															}else{
																echo "";
															}
															?></td>
                        </tr>
                        <tr>
                            <td class="info-blue-text">Height</td>
                            <td class="info-white-text"><?php 
															if (isset($_SESSION['cfcp_senior_non_reqired']['height'])){
																echo $_SESSION['cfcp_senior_non_reqired']['height'];
															}elseif (isset($_SESSION['id_for_preview_cfcp'])){
																echo $preview_details_in_cfcp[0]['height'];
															}else{
																echo "";
															}
															?></td>
                        </tr>
                        <tr class="gray-row">
                            <td class="info-blue-text">Weight</td>
                            <td class="info-white-text"><?php
                            								if (isset($_SESSION['cfcp_senior_non_reqired']['weight'])){
																echo $_SESSION['cfcp_senior_non_reqired']['weight'];
															}elseif (isset($_SESSION['id_for_preview_cfcp'])){
																echo $preview_details_in_cfcp[0]['weight'];
															}else{
																echo "";
															}
															?></td>

                        </tr>
                        <tr>
                            <td class="info-blue-text">Position</td>
                            <td class="info-white-text"><?php 
															if (isset($_SESSION['cfcp_senior_non_reqired']['pos'])){
																echo $_SESSION['cfcp_senior_non_reqired']['pos'];
															}elseif (isset($_SESSION['id_for_preview_cfcp'])){
																echo $preview_details_in_cfcp[0]['position'];
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
                            <td class="history-blue-text-club">Season</td>
                            <td class="history-blue-text-appearences">Team</td>
                            <td class="history-blue-text-goals">Appearance</td>
                            <td class="history-blue-text-goals">Goals</td>
                        </tr>
                        <?php if(isset($_SESSION['cfcp_session_data'])):?>
							<?php for($i=0; $i<count($_SESSION['cfcp_session_data']); $i++):?>
                            <?php $trClass = (CommonFunctions::checkNum($i)) ? "" : "gray-row";?>
                            <tr class="<?php echo $trClass;?>">
                                <td valign="top" class="history-white-text-club"><div class="history-white-text-club-div"><?php echo $_SESSION['cfcp_session_data'][$i]['field_1'];?></div></td>
                                <td valign="top" class="history-white-text-appearences"><div class="history-white-text-appearences-div"><?php echo $_SESSION['cfcp_session_data'][$i]['field_2'];?></div></td>
                                <td valign="top" class="history-white-text-goals"><div class="history-white-text-goals-div"><?php echo $_SESSION['cfcp_session_data'][$i]['field_3'];?></div></td>
                                <td valign="top" class="history-white-text-goals"><div class="history-white-text-goals-div"><?php echo $_SESSION['cfcp_session_data'][$i]['field_4'];?></div></td>
                            </tr>
                            <?php endfor;?>                        
                        <?php elseif (isset($_SESSION['id_for_preview_cfcp'])):?>
                        	<?php for($i=0; $i<count($history); $i++):?>
                            <?php $trClass = (CommonFunctions::checkNum($i)) ? "" : "gray-row";?>
                            <tr class="<?php echo $trClass;?>">
                                <td valign="top" class="history-white-text-club"><div class="history-white-text-club-div"><?php echo $history[$i]['season'];?></div></td>
                                <td valign="top" class="history-white-text-appearences"><div class="history-white-text-appearences-div"><?php echo $history[$i]['team'];?></div></td>
                                <td valign="top" class="history-white-text-goals"><div class="history-white-text-goals-div"><?php echo $history[$i]['appearances'];?></div></td>
                                <td valign="top" class="history-white-text-goals"><div class="history-white-text-goals-div"><?php echo $history[$i]['goals'];?></div></td>
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
    </div>
</div>
</body>                
</html>