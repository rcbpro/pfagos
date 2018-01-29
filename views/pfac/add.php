<div id="static_header">
	<!-- Breadcrumb div message -->
	<?php echo $breadcrumb;?>
    <!--  End of the Breadcrumb div mesage -->
    <!-- This is the success/error message to be diplayed -->
    <?php global $headerDivMsg; echo $headerDivMsg;?>
    <!-- End of the success or error message -->
    <div class="headerTopicContainer defaultFont boldText"><?php echo $printHtml;?></div>
</div>
<div id="dataInputContainer_wrap">
<!--  Tinymce include and the initilization -->
<?php if (($_GET['mode'] == "player-info") || ($_GET['mode'] == "coach-info")):?>
<script src="http://devel.admin.profootballagency.com/public/js/tiny_mce/tiny_mce.js" language="javascript" type="text/javascript"></script>
<?php endif;?>
<!-- End of the javascript -->
    <div class="dataInputContainer">
    <?php 

		if (isset($_GET['mode'])){
			$whichFormToInclude = "mode".DS.$_GET['mode'];		
		}else{
			$whichFormToInclude = "mode/general";					
		}	
		include $whichFormToInclude.".php";	
    ?>
    </div>
</div>