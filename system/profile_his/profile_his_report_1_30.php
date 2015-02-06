<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
$menu_name = 27;
$menu_num = "26. ";
$headline_title =  $report_menu[$menu_name]['name']; 
 
 
   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
 
   $ORG_ID_3 = (int)$_POST['ORG_ID_3'];
   $type_is = (int)$_POST['type_is'];
   
 

  $arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='15' ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/chosen.css" rel="stylesheet">
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_his_report_1_4.js?<?php echo rand(); ?>"></script>

</head>
<body <?php echo $remove;?>> <?php  ///echo "<pre>"; print_r($_POST);  ?>
<div id="content" class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	    <?php echo report_breadcrumb($paramlink,showMenu($menu_sub_id),$menu_num.$headline_title); ?>
    
    
	<div class="col-xs-12 col-md-12" id="content">
		<div class="groupdata">
			<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">
                <input type="hidden" id="SEARCH_TYPE" name="SEARCH_TYPE" value="" >
                <input type="hidden" id="SEARCH_F" name="SEARCH_F" value="" >


<?php include_once("inc_select4_position.php"); ?>
       
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['org_label_name']; ?> :</div>
			<div class="col-xs-12 col-sm-3">
				<span id='ss_org3'><?php echo GetHtmlSelect('ORG_ID_3','ORG_ID_3',$arr_org3,'ทั้งหมด',$ORG_ID_3,'onchange="getORG(this);"','','1');?></span>
            
 		
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	  </div>
			<div class="col-xs-12 col-sm-2">
             
			</div>
        </div>
 
<?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();"); 
     $s_field = "";
	 if($type_is>0){
	     if($type_is==1){
		    $s_field = "b.ORG_ID_3";
			$title_1 = "สังกัดตามกรอบ";
		 }else{
		    $s_field = "a.ORG_ID_3";
			$title_1 = "สังกัดตามปฎิบัติงาน";
		 }
	 }
 
	    $html_start   =  html_report_header($menu_name);
 
 		$sql_get_value = "  SELECT    a.POS_NO,b.ORG_ID_1 as frame_org1,b.ORG_ID_2 as frame_org2,b.ORG_ID_3 as frame_org3,b.ORG_ID_4 as frame_org4,b.ORG_ID_5 as frame_org5
,a.ORG_ID_1 as act_org1,a.ORG_ID_2  as act_org2,a.ORG_ID_3  as act_org3,a.ORG_ID_4  as act_org4,a.ORG_ID_5  as act_org5  ,  d.LINE_NAME_TH, f.TYPE_NAME_TH ,g.LEVEL_NAME_TH ,h.LG_NAME_TH ,i.MANAGE_NAME_TH ,a.PER_SALARY
 FROM PER_PROFILE a 
LEFT JOIN POSITION_FRAME b ON a.POS_ID = b.POS_ID 
LEFT JOIN SETUP_POS_LINE d ON a.LINE_ID = d.LINE_ID 
LEFT JOIN SETUP_POS_TYPE f ON a.TYPE_ID = f.TYPE_ID 
LEFT JOIN SETUP_POS_LEVEL g ON a.LEVEL_ID = g.LEVEL_ID 
LEFT JOIN SETUP_POS_LINE_GROUP h ON a.LG_ID = h.LG_ID 
LEFT JOIN SETUP_POS_MANAGE i ON a.MANAGE_ID = i.MANAGE_ID 
WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 
AND  a.PT_ID = 1 
 ";
 
if($TYPE_ID  > 0){
	$sql_get_value .= " AND  (a.TYPE_ID = '".$TYPE_ID."' )    ";	 
}
if($LEVEL_ID  > 0){
	$sql_get_value .= " AND  (a.LEVEL_ID = '".$LEVEL_ID."' )  ";	 
}
if($LG_ID  > 0){
	$sql_get_value .= " AND  (a.LG_ID = '".$LG_ID."' )   ";	 
}
if($LINE_ID  > 0){
	$sql_get_value .= " AND  (a.LINE_ID = '".$LINE_ID."' )  ";	 
}
 
 
if($ORG_ID_3  > 0){
	$sql_get_value .= " AND  (b.ORG_ID_3 = '".$ORG_ID_3."' )  ";	 
}
  
 
if($s_field!=""){
		$sql_get_value .= " AND ".$s_field." = ".$ORG_ID_3." ";
}
  
		$query_who = $db->query($sql_get_value." ".$q_where); 
		$sum_all = $db->db_num_rows($query_who); 
             while($rec1 = $db->db_fetch_array($query_who)){

                       $MANAGE_NAME_TH = text($rec1['MANAGE_NAME_TH']);
					   if(($MANAGE_NAME_TH!="อธิบดี")AND($MANAGE_NAME_TH!="รองอธิบดี")){ 
					  			$org3 = (int)$rec1['frame_org3'];
						}else{
					  			$org3 = (int)$rec1['frame_org2'];
						}
					  $sql = ' SELECT  ORG_NAME_TH from SETUP_ORG where ORG_ID = '.$org3;
					  
					  $query_org = $db->query($sql);
					  $org_is = $db->db_fetch_array($query_org);
			 
 
			  
 
			  
			  $r_gender = '';
			  if($rec1['PER_GENDER']==2){
			     $r_gender = "หญิง";
			  }
			  if($rec1['PER_GENDER']==1){
			     $r_gender = "ชาย";
			  }
 
 		$html  .= "<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  >".$rec1['POS_NO']."</td> 
			 <td LEFT_TOP  >".text($rec1['TYPE_NAME_TH'])."</td> 
			 <td LEFT_TOP  >".text($rec1['LEVEL_NAME_TH'])."</td> 	
			 <td LEFT_TOP  >".text($rec1['LG_NAME_TH'])."</td> 	
			 <td LEFT_TOP >&nbsp;".text($rec1['LINE_NAME_TH'])." </td> 
			 <td CENTER_TOP  >".text($rec1['MANAGE_NAME_TH'])."</td> 
			 <td RIGHT_TOP  >".number_format($rec1['PER_SALARY'],0)."</td> 
			 <td LEFT_TOP >&nbsp;".text($org_is['ORG_NAME_TH'])." </td> 
			  
		 </tr>";
         $start_no++;
 	  }

	  
 
	
		$html_end   = "</table>";
		include_once("inc_print_btn_and_output.php"); ?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    