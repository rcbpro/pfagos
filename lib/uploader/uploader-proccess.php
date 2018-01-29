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
		$img_path = $_SESSION['pfac_preview_img']['path_thumb'];
		$img_name = $_SESSION['pfac_preview_img']['name'];
		$ary = explode('_', $img_name, 2);
		$img_name_real = $ary[1];
		
		$display_width = $_SESSION['pfac_preview_img']['display_width'];
		echo '<div id="uploaded-img-new" align="center"><div id="d-img-new"><div id="remove-img-new" class="remove-img" title="Remove image"></div><img title="'.$img_name_real.'" alt="'.$img_name_real.'" width="'.$display_width.'" src="'.$img_path.'" /></div></div>';
	}
		
	//ajax, get image-edit
	if($_POST['get-image-edit'] == true){
		$img_path = $_SESSION['pfac_preview_img']['path_thumb'];
		$img_name = $_SESSION['pfac_preview_img']['name'];
		$ary = explode('_', $img_name, 2);
		$img_name_real = $ary[1];
		
		$display_width = $_SESSION['pfac_preview_img']['display_width'];
		echo '<div id="uploaded-img-new" align="center"><div id="d-img-new"><div id="remove-img-new" class="remove-img" title="Remove image"></div><img title="'.$img_name_real.'" alt="'.$img_name_real.'" width="'.$display_width.'" src="'.$img_path.'" /></div></div>';
	}
	
	
	
	//ajax, get cv
	if(($_POST['get-cv'] == true) && (isset($_SESSION['pfac_preview_cv']['path_cv']))){
		$prefix = '';
		$remove = '';
		
		$cv_name = $_SESSION['pfac_preview_cv']['name'];
		$ary = explode('_', $cv_name, 2);
		$cv_name_real = $ary[1];
		
		//$href = $_SERVER['DOCUMENT_ROOT'].'/'.user_uploads/temp/'.$_SESSION['pre_pfac_preview_video']['name'];
		$href = 'http://'.$_SERVER['HTTP_HOST'].'/cfcp/download/?where=temp&filename='.urlencode($_SESSION['pfac_preview_cv']['name']);
		if($_POST['new']){
			$prefix = 'New cv : ';
			$remove = '<span id="remove-cv-new"> [remove] </span>';
			echo '<div id="uploaded-cv-new"><div id="d-cv-new">'.$prefix.'<a href="'.$href.'">'.$cv_name_real.'</a>'.$remove.'</div></div>';
		}
		else{
			$remove = '<span id="remove-cv-current"> [remove] </span>';
			echo '<div id="uploaded-cv-current"><div id="d-cv-currnet">'.$prefix.'<a href="'.$href.'">'.$cv_name_real.'</a>'.$remove.'</a></div></div>';
		}
		
		
	}
	
	//ajax, get video
	if(($_POST['get-video'] == true) && (isset($_SESSION['pfac_preview_video']['path_video']))){
		$prefix = '';
		$remove = '';
		
		$video_name = $_SESSION['pfac_preview_video']['name'];
		$ary = explode('_', $video_name, 2);
		$video_name_real = $ary[1];
		
		//$href = $_SERVER['DOCUMENT_ROOT'].'/'.user_uploads/temp/'.$_SESSION['pre_pfac_preview_video']['name'];
		$href = 'http://'.$_SERVER['HTTP_HOST'].'/cfcp/download/?where=temp&filename='.urlencode($_SESSION['pfac_preview_video']['name']);
		if($_POST['new']){
			$prefix = 'New video : ';
			$remove = '<span id="remove-video-new"> [remove] </span>';
			echo '<div id="uploaded-video-new"><div id="d-video-new">'.$prefix.'<a href="'.$href.'">'.$video_name_real.'</a>'.$remove.'</div></div>';
		}
		else{
			$remove = '<span id="remove-video-current"> [remove] </span>';
			echo '<div id="uploaded-video-current"><div id="d-video-currnet">'.$prefix.'<a href="'.$href.'">'.$video_name_real.'</a>'.$remove.'</a></div></div>';
		}
		
		
	}
	
	//ajax, url upload
	if($_POST['upload-url']){
		$url = trim($_POST['val']);
		$url = str_replace('http://','',$url);
		$url = 'http://'.$url;
		if(!isset($_SESSION['pfac_preview_video']['file_path_video'])){
			//$_SESSION['pfac_preview_video']['path_video'] = $url;
			$_SESSION['pfac_preview_video']['name'] = $url;
			echo $_SESSION['pfac_preview_video']['name'];
		}
		
	}
	
	
	//ajax, removing video
	if($_POST['remove-video-current']){
		if(unlink($_SESSION['pre_pfac_preview_video']['file_path_video'])){
			if(!isset($_SESSION['pfac_preview_video'])){
				$_SESSION['pfac_preview_video']['name'] = '';
			}
			$sql = 'UPDATE pfac__genral_details SET video_url = "" WHERE video_url = "'.$_SESSION['pre_pfac_preview_video']['name'].'"';
			echo $sql;
			mysql_query($sql);
			unset($_SESSION['pre_pfac_preview_video']);
			echo 1;
		}
	}
	
	if($_POST['remove-video-new']){
		if(unlink($_SESSION['pfac_preview_video']['file_path_video'])){
			unset($_SESSION['pfac_preview_video']);
			echo 1;
		}
	}
	//end
	
	//ajax, removing cv
	if($_POST['remove-cv-current']){
		if(unlink($_SESSION['pre_pfac_preview_cv']['file_path_cv'])){
			if(!isset($_SESSION['pfac_preview_cv'])){
				$_SESSION['pfac_preview_cv']['name'] = '';
			}
			$sql = 'UPDATE pfac__genral_details SET cv_url = "" WHERE cv_url = "'.$_SESSION['pre_pfac_preview_cv']['name'].'"';
			echo $sql;
			mysql_query($sql);
			unset($_SESSION['pre_pfac_preview_cv']);
			echo 1;
		}
	}
	
	if($_POST['remove-cv-new']){
		if(unlink($_SESSION['pfac_preview_cv']['file_path_cv'])){
			unset($_SESSION['pfac_preview_cv']);
			echo 1;
		}
	}
	//end
	
	//ajax, remove-img-current
	if($_POST['remove-img-current']){
		$sql = 'UPDATE pfac__genral_details SET photo_url = "" WHERE photo_url = "'.$_SESSION['pre_pfac_preview_img']['name'].'"';
		mysql_query($sql);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/large/'.$_SESSION['pre_pfac_preview_img']['name']);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/medium/'.$_SESSION['pre_pfac_preview_img']['name']);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/small/'.$_SESSION['pre_pfac_preview_img']['name']);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/thumb/'.$_SESSION['pre_pfac_preview_img']['name']);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_uploads/images/'.$_SESSION['pre_pfac_preview_img']['name']);
		unset($_SERVER['pre_pfac_preview_img']);		
	}
	
	//ajax, remove-img-new
	if($_POST['remove-img-new']){
		unlink($_SESSION['pfac_preview_img']['file_path_prew']);
		unlink($_SESSION['pfac_preview_img']['file_path_thumb']);
		unlink($_SESSION['pfac_preview_img']['file_path_ori']);
		unset($_SESSION['pfac_preview_img']);
		
		$img_path = $_SESSION['pre_pfac_preview_img']['path_thumb'];
		$img_name = $_SESSION['pre_pfac_preview_img']['name'];
		$img_path_file = $_SESSION['pre_pfac_preview_img']['file_path'];
		$ary = explode('_', $img_name, 2);
		$img_name_real = $ary[1];
		if(is_file($img_path_file)){
			echo '<div id="uploaded-img-current" align="center"><div id="d-img-current"><div id="remove-img-current" class="remove-img" title="Remove image"></div><img title="'.$img_name_real.'" alt="'.$img_name_real.'" src="'.$img_path.'" /></div></div>';
		}
	}
	
	
	//ajax, check to disable url field
	if($_POST['field-url-status']){
		if(is_file($_SESSION['pre_pfac_preview_video']['file_path_video']) || is_file($_SESSION['pfac_preview_video']['file_path_video'])){
			echo true;
		}
		else{
			echo false;
		}
	}
	//end
		
	if($_POST['check-preview'] == true){
		$img_file_path = $_SESSION['pfac_preview_img']['file_path_thumb'];
		$cv_file_path = $_SESSION['pfac_preview_cv']['file_path_cv'];
		
		if(file_exists($img_file_path) && file_exists($cv_file_path)){
			$_SESSION['pfac_files_has_uploaded'] = true;
			echo 1;
	   	}
		else{
			$_SESSION['pfac_files_has_uploaded'] = false;
			echo 0;
		}
	}


?>