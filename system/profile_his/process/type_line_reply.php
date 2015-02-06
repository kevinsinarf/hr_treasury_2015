<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$TYPE_ID = (int)$_POST['type_id'];
$type = $_POST['type'];

if($type=="type"){ 
	$cond_level = ($TYPE_ID != '') ? "AND TYPE_ID = '".$TYPE_ID."'" : "";
	
	$arr_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  ".$cond_level, "LEVEL_SEQ");//ORG  
	
	  echo GetHtmlSelect('S_LEVEL_ID', 'S_LEVEL_ID',$arr_level , 'ระดับตำแหน่ง' ,$S_LEVEL_ID,' onChange="get_lg_1(this);"', '1', '', '');  
 
}


if($type=="level"){ 
$cond_line = ($TYPE_ID != '') ? " AND TYPE_ID = '".$TYPE_ID."'" : "";
$arr_pos_line = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ".$cond_line."  ", "LINE_NAME_TH");
	
 echo GetHtmlSelect('S_LG_ID', 'S_LG_ID',$arr_pos_line , 'สายงาน' ,$S_LG_ID ,' onChange="get_line_1(this);"', '1', '', '');   		
 
}


if($type=="line"){ //echo $TYPE_ID; exit();
//ตำแหน่งในสายงาน
$cond_line = ($TYPE_ID != '') ? " AND TYPE_ID = '".$TYPE_ID."'" : "";
$arr_pos_line = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ".$cond_line."  ", "LINE_NAME_TH");

	
 echo GetHtmlSelect('S_LG_ID', 'S_LG_ID',$arr_pos_line , 'สายงาน' ,$S_LG_ID ,'', '1', '', '');   
 
}

 
?>