<?php
if(isset($_POST['msid'])){
	session_id($_POST['msid']);
	if(!session_start()){
		session_start();
	}
}				

if (!empty($_FILES)) {
	if($_POST['type'] == 'photo'){
		
		require './../lib/ImageCreate.php';
	
		$file_path = $_SERVER['DOCUMENT_ROOT'];
		
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$image_name = $_FILES['Filedata']['name'];
		$unique_img = 'f'.rand(1000,9999).'_'.$image_name;
		list($image_width, $image_height) = getimagesize($_FILES['Filedata']['tmp_name']); 
		
		$targetPath = $file_path . $_REQUEST['folder'] . '/';
		$targetFile =  str_replace('//','/',$targetPath) . $unique_img;
		
		if(move_uploaded_file($tempFile,$targetFile)){
			if ($image_width > 260){
				$display_width = 260;
			}
			else{
				$display_width = $image_width;
			}
			
			$_SESSION['pfac_preview_img']['name'] = $unique_img;
			$_SESSION['pfac_preview_img']['width'] = $image_width;
			$_SESSION['pfac_preview_img']['height'] = $image_height;
			$_SESSION['pfac_preview_img']['display_width'] = $display_width;
			
			$_SESSION['pfac_preview_img']['path_thumb'] = 'http://'.$_SERVER['HTTP_HOST'].'/user_uploads/temp/thumb_'.$unique_img;
			$_SESSION['pfac_preview_img']['path_prew']   = 'http://'.$_SERVER['HTTP_HOST'].'/user_uploads/temp/pre_'.$unique_img;
			$_SESSION['pfac_preview_img']['path_ori']   = 'http://'.$_SERVER['HTTP_HOST'].'/user_uploads/temp/'.$unique_img;
			
			$_SESSION['pfac_preview_img']['file_path_thumb'] = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/temp/thumb_'.$unique_img;
			$_SESSION['pfac_preview_img']['file_path_prew'] = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/temp/pre_'.$unique_img;
			$_SESSION['pfac_preview_img']['file_path_ori']   = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/temp/'.$unique_img;			
					
			$imageCreate = new ImageCreate();
			$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $_SESSION['pfac_preview_img']['file_path_thumb'] , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], 260,Null);
			$imageCreate->make_thumb($_SESSION['pfac_preview_img']['file_path_ori'], $_SESSION['pfac_preview_img']['file_path_prew'] , $_SESSION['pfac_preview_img']['width'], $_SESSION['pfac_preview_img']['height'], Null,275);
		
			echo "1";
		}
	}
	
	
	if($_POST['type']=='cv'){
		
		$file_path = $_SERVER['DOCUMENT_ROOT'];
		
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$cv_name = $_FILES['Filedata']['name'];
		$unique_cv = 'f'.rand(1000,9999).'_'.$cv_name;
		
		$targetPath = $file_path . $_REQUEST['folder'] . '/';
		$targetFile =  str_replace('//','/',$targetPath) . $unique_cv;
		
		if(move_uploaded_file($tempFile,$targetFile)){
			
			$_SESSION['pfac_preview_cv']['name'] = $unique_cv;
			
			$_SESSION['pfac_preview_cv']['path_cv']   = 'http://'.$_SERVER['HTTP_HOST'].'/user_uploads/temp/'.$unique_cv;			
			$_SESSION['pfac_preview_cv']['file_path_cv'] = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/temp/'.$unique_cv;	
		
			echo "1";
		}
	}
	
	if($_POST['type']=='video'){
		
		$file_path = $_SERVER['DOCUMENT_ROOT'];
		
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$video_name = $_FILES['Filedata']['name'];
		$unique_video = 'f'.rand(1000,9999).'_'.$video_name;
		
		$targetPath = $file_path . $_REQUEST['folder'] . '/';
		$targetFile =  str_replace('//','/',$targetPath) . $unique_video;
		
		if(move_uploaded_file($tempFile,$targetFile)){
			
			$_SESSION['pfac_preview_video']['name'] = $unique_video;			
			$_SESSION['pfac_preview_video']['path_video']   = $_SERVER['HTTP_HOST'].'/user_uploads/temp/'.$unique_video;			
			$_SESSION['pfac_preview_video']['file_path_video'] = $_SERVER['DOCUMENT_ROOT'].'/user_uploads/temp/'.$unique_video;	
		
			echo "1";
		}
	}
	
	
}
?>