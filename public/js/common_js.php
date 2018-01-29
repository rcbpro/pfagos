<?php header('Content-type: application/javascript');?>
// JavaScript Document

var newWindow;
function popup(url){
	newWindow=window.open(url,'name','height=1100,width=695,vAlign=middle,hAlign=center,scrollbars=yes,resizable=yes,screenx=335,screeny=250');
	if (window.focus) {newWindow.focus()}
}
function popup1(url){
	newWindow=window.open(url,'name','height=500,width=675,vAlign=middle,hAlign=center,scrollbars=yes,resizable=yes,screenx=335,screeny=150');
	if (window.focus) {newWindow.focus()}
}
function got_to_this_page(path){
	if (document.getElementById('jump_to_page').value != "")
		location.href = path + document.getElementById('jump_to_page').value;		
}
function ask_for_delete_record(path){
	if (confirmation = confirm("Do you really want to delete this record ?")){
		location.href = path;
	}
    return false;
}
function submit_the_search_query(controller){
	query = "";
	if ((document.getElementById('first_name').value != "") && (document.getElementById('surname').value != "")){
		query += "?fname="+document.getElementById('first_name').value.toLowerCase() + "&sname="+document.getElementById('surname').value.toLowerCase();
	}else{
		if (document.getElementById('first_name').value != ""){
			query += "?fname="+document.getElementById('first_name').value.toLowerCase();	
		}else if (document.getElementById('surname').value != ""){
			query += "?sname="+document.getElementById('surname').value.toLowerCase();	
		}else{
			query += "";	
		}
	}
	if (query != ""){
		location.href = "http://<?php echo $_SERVER['HTTP_HOST'];?>/" + controller + "/search/" + query;	
	}
}
$(document).ready(function(){
    $("#first_name, #surname").keypress(function(e)  {
        if (e.which == 13 ){
          submit_the_search_query($("#searchController").val());
        }
    });
    
	$(".tbs-main-pfac tr").hover(function (){$(this).css("background-color","#bcbdbf");},function(){$(this).css("background-color","#dddddd");});
    $(".tbs-main-address-book tr").hover(function (){$(this).css("background-color","#bcbdbf");},function(){$(this).css("background-color","#dddddd");});
    $(".tbs-main-users tr").hover(function (){$(this).css("background-color","#bcbdbf");},function(){$(this).css("background-color","#dddddd");});
    $(".tbs-main-log tr").hover(function (){$(this).css("background-color","#bcbdbf");},function(){$(this).css("background-color","#dddddd");});
});
