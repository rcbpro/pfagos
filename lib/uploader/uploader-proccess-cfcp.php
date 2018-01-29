<?php

	require $_SERVER['DOCUMENT_ROOT']."/define.inc";
	$db_settings = new pfagos_settings();

	$settings = $db_settings->db_settings;
	$con = mysql_connect($settings['host'], $settings['username'], $settings['password']);
	mysql_select_db($settings['database'], $con);

	if(!session_start()){
		session_start();
	}
	
	//ajax, get image-add
	if($_POST['get-image-add'] == true){
		$img_path = $_SESSION['cfcp_preview_img']['path_thumb'];
		$img_name = $_SESSION['cfcp_preview_img']['name'];
		$ary = explode('_', $img_name, 2);
		$img_name_real = $ary[1];
		
		$display_width = $_SESSION['cfcp_preview_img']['display_width'];
		echo '<div id="uploaded-img-new" align="center"><div id="d-img-new"><div id="remove-img-new" class="remove-img" title="Remove image"></div><img title="'.$img_name_real.'" alt="'.$img_name_real.'" width="'.$display_width.'" src="'.$img_path.'" /></div></div>';
	}
		
	//ajax, get image-edit
	if($_POST['get-image-edit'] == true){
		$img_path = $_SESSION['cfcp_preview_img']['path_thumb'];
		$img_name = $_SESSION['cfcp_preview_img']['name'];
		$ary = explode('_', $img_name, 2);
		$img_name_real = $ary[1];
		
		$display_width = $_SESSION['cfcp_preview_img']['display_width'];
		echo '<div id="uploaded-img-new" align="center"><div id="d-img-new"><div id="remove-img-new" class="remove-img" title="Remove image"></div><img title="'.$img_name_real.'" alt="'.$img_name_real.'" width="'.$display_width.'" src="'.$img_path.'" /></div></div>';
	}
	
	
	
	//ajax, get cv
	if($_POST['get-cv'] == true){
		$prefix = '';
		$remove = '';		
		if($_POST['new']){
			$prefix = 'New cv : ';
			$remove = '<span id="remove-cv"> [remove] </span>';
		}
		
		$cv_name = $_SESSION['cfcp_preview_cv']['name'];
		$ary = explode('_', $cv_name, 2);
		$cv_name_real = $ary[1];
		echo '<div id="uploaded-cv"><div id="d-cv">'.$prefix.$cv_name_real.$remove.'</div></div>';
//		print_r($_SESSION['cfcp_preview_cv']);
	}	
	
	//ajax, get video
	if(($_POST['get-video'] == true) && (isset($_SESSION[cfcp_preview_video]['path_video']))){
		$prefix = '';
		$remove = '';
		
		$video_name = $_SESSION['cfcp_preview_video']['name'];
		$ary = explode('_', $video_name, 2);
		$video_name_real = $ary[1];
		
		if($_POST['new']){
			$prefix = 'New video : ';
			$remove = '<span id="remove-video-new"> [remove] </span>';
			echo '<div id="uploaded-video-new"><div id="d-video-new">'.$prefix.$video_name_real.$remove.'</div></div>';
		}
		else{
			$remove = '<span id="remove-video-current"> [remove] </span>';
			echo '<div id="uploaded-video-current"><div id="d-video-currnet">'.$prefix.$video_name_real.$remove.'</div></div>';
		}
		
		
	}
	
	//ajax, get birth certificate
	if($_POST['get-bc'] == true){
		$bc_name = $_SESSION['cfcp_preview_bc']['name'];
		$ary = explode('_', $bc_name, 2);
		$bc_name_real = $ary[1];
		echo $bc_name_real;
	}
	
	//ajax, get registration card
	if($_POST['get-reg'] == true){
		$reg_name = $_SESSION['cfcp_preview_reg']['name'];
		$ary = explode('_', $reg_name, 2);
		$reg_name_real = $ary[1];
		echo $reg_name_real;
	}
	//ajax, get registration card
	if($_POST['get-ps'] == true){
		$ps_name = $_SESSION['cfcp_preview_ps']['name'];
		$ary = explode('_', $ps_name, 2);
		$ps_name_real = $ary[1];
		echo $ps_name_real;
	}
	
	//ajax, url upload
	if($_POST['upload-url']){
		$url = trim($_POST['val']);
		$url = str_replace('http://','',$url);
		$url = 'http://'.$url;
		if(!isset($_SESSION['cfcp_preview_video']['file_path_video'])){
			//$_SESSION['cfcp_preview_video']['path_video'] = $url;
			$_SESSION['cfcp_preview_video']['name'] = $url;
			echo $_SESSION['cfcp_preview_video']['name'];
		}
		
	}
	
	
	//ajax, removing video
	if($_POST['remove-video-current']){
		if(unlink($_SESSION['pre_cfcp_preview_video']['file_path_video'])){
			if(!isset($_SESSION['cfcp_preview_video'])){
				$_SESSION['cfcp_preview_video']['name'] = '';
			}
			unset($_SESSION['pre_cfcp_preview_video']);
			echo 1;
		}
	}
	
	if($_POST['remove-video-new']){
		if(unlink($_SESSION['cfcp_preview_video']['file_path_video'])){
			unset($_SESSION['cfcp_preview_video']);
			echo 1;
		}
	}
	//end
	
	//ajax, removing cv
	if($_POST['remove-cv'] == true){
		if(unlink($_SESSION['cfcp_preview_cv']['file_path_cv'])){
			unset($_SESSION['cfcp_preview_cv'] );
			echo 1;
		}
		else{
			echo 'no';
		}
	}
	//end
	
	//ajax, remove-img-current
	if($_POST['remove-img-current']){
		$sql = 'UPDATE cfcp__senior_palyer_details SET photo_url = "" WHERE photo_url = "'.$_SESSION['pre_cfcp_preview_img']['name'].'"';
		mysql_query($sql);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/large/'.$_SESSION['pre_cfcp_preview_img']['name']);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/medium/'.$_SESSION['pre_cfcp_preview_img']['name']);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/small/'.$_SESSION['pre_cfcp_preview_img']['name']);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/thumb/'.$_SESSION['pre_cfcp_preview_img']['name']);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/'.$_SESSION['pre_cfcp_preview_img']['name']);
		unset($_SERVER['pre_cfcp_preview_img']);		
	}
	
	//ajax, remove-img-new
	if($_POST['remove-img-new']){
		unlink($_SESSION['cfcp_preview_img']['file_path_prew']);
		unlink($_SESSION['cfcp_preview_img']['file_path_thumb']);
		unlink($_SESSION['cfcp_preview_img']['file_path_ori']);
		unset($_SESSION['cfcp_preview_img']);
		
		$img_path = $_SESSION['pre_cfcp_preview_img']['path_thumb'];
		$img_name = $_SESSION['pre_cfcp_preview_img']['name'];
		$img_path_file = $_SESSION['pre_cfcp_preview_img']['file_path'];
		$ary = explode('_', $img_name, 2);
		$img_name_real = $ary[1];
		if(is_file($img_path_file)){
			echo '<div id="uploaded-img-current" align="center"><div id="d-img-current"><div id="remove-img-current" class="remove-img" title="Remove image"></div><img title="'.$img_name_real.'" alt="'.$img_name_real.'" src="'.$img_path.'" /></div></div>';
		}
	}

	
	//ajax, check to disable url field
	if($_POST['field-url-status']){
		if(is_file($_SESSION['pre_cfcp_preview_video']['file_path_video']) || is_file($_SESSION['cfcp_preview_video']['file_path_video'])){
			echo true;
		}
		else{
			echo false;
		}
	}
	//end
		
	if($_POST['check-preview'] == true){
		$img_file_path = $_SESSION['cfcp_preview_img']['file_path_thumb'];
		$cv_file_path = $_SESSION['cfcp_preview_cv']['file_path_cv'];
		
		if(file_exists($img_file_path) && file_exists($cv_file_path)){
			$_SESSION['cfcp_files_has_uploaded'] = true;
			echo 1;
	   	}
		else{
			$_SESSION['cfcp_files_has_uploaded'] = false;
			echo 0;
		}
	}
	
	//remove passport scan
	if($_POST['remove-ps'] == true){
		unlink($_SESSION['cfcp_preview_ps']['file_path_ps']);
		unset($_SESSION['cfcp_preview_ps']);
	}
	
	//remove previous passport scan
	if($_POST['remove-pre-ps'] == true){
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/passport_scans/'.$_SESSION['pre_cfcp_preview_ps']['name']);		
		$sql = 'UPDATE cfcp__other_details SET passport_scan_url = "" WHERE passport_scan_url = "'.$_SESSION['pre_cfcp_preview_ps']['name'].'"';
		mysql_query($sql);
		unset($_SESSION['pre_cfcp_preview_ps']);
	}
	
	
	//remove bc
	if($_POST['remove-bc'] == true){
		unlink($_SESSION['cfcp_preview_bc']['file_path_bc']);
		unset($_SESSION['cfcp_preview_bc']);
	}
	
	//remove previous bc
	if($_POST['remove-pre-bc'] == true){
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/birth_certificates/'.$_SESSION['pre_cfcp_preview_bc']['name']);		
		$sql = 'UPDATE cfcp__other_details SET birth_certificate_url = "" WHERE birth_certificate_url = "'.$_SESSION['pre_cfcp_preview_bc']['name'].'"';
		mysql_query($sql);
		unset($_SESSION['pre_cfcp_preview_bc']);
	}
	
	//remove reg
	if($_POST['remove-reg'] == true){
		unlink($_SESSION['cfcp_preview_reg']['file_path_reg']);
		unset($_SESSION['cfcp_preview_reg']);
	}
	
	//remove previous reg
	if($_POST['remove-pre-reg'] == true){
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/birth_certificates/'.$_SESSION['pre_cfcp_preview_reg']['name']);		
		$sql = 'UPDATE cfcp__other_details SET reg_card_url = "" WHERE reg_card_url = "'.$_SESSION['pre_cfcp_preview_reg']['name'].'"';
		mysql_query($sql);
		unset($_SESSION['pre_cfcp_preview_reg']);
	}
?>

