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
<script src="<?php echo $site_config['base_url'];?>public/js/tiny_mce/tiny_mce.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
	theme : "advanced",
	mode : "specific_textareas",
    editor_selector : "tinymce",
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