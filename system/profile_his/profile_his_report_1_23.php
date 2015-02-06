<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

 // echo "<pre>"; print_r($_POST); echo "<hr/>";   //echo "<pre>"; print_r($_SESSION); exit();

 

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 22;
$menu_num = "21".$number_subfix;
if($postype_id_is > 0){
	if($postype_id_is==3){
		$menu_name = 45;
	    $menu_num = "43".$number_subfix;
	}
	if($postype_id_is==5){
		$menu_name = 61;
        $menu_num = "59".$number_subfix;
	}
} 

 if($menu_name==22){
     $wh_pt_id = " AND  a.PT_ID = 1  ";
	 $wh_postype_id = " AND a.POSTYPE_ID = 1 ";
 }
 if($menu_name==45){
     $wh_pt_id = " AND  a.PT_ID = 2  ";
	 $wh_postype_id = " AND a.POSTYPE_ID = 3 ";
 }
  if($menu_name==61){
     $wh_pt_id = " AND  a.PT_ID = 3  ";
	 $wh_postype_id = " AND a.POSTYPE_ID = 5 ";
 }

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
<script src="js/profile_his_report_1_42.js?<?php echo rand(); ?>"></script>
<script>
function chk_me(){
 
    var org_id_val = $("#ORG_ID_3 option").filter(":selected").val();
    var type_is_val = $("#type_is option").filter(":selected").val();
   if(org_id_val!=""){
      if(type_is_val==""){
	     alert("หากท่านทำการเลือกกอง/สำนัก/กลุ่ม กรุณาเลือก  สังกัดกรอบ หรือ สังกัดปฎิบัติ เพื่อให้การค้นหาสมบูรณ์ด้วยค่ะ ");
	     return false;
	  }
   }

}

 

</script>
 
</head><script>
$('#footer').hide();
$(document).ready(function() {
    $('#footer').css({
        position: 'relative',
        bottom: '-200px',
         
    });
	$('#footer').show();
});
</script>
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
                <input type="hidden" id="POSTYPE_ID_is" name="POSTYPE_ID_is" value="<?php echo $postype_id_is; ?>">  
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">กอง/สำนัก/กลุ่ม :</div>
			<div class="col-xs-12 col-sm-3">
				<span id='ss_org3'><?php echo GetHtmlSelect('ORG_ID_3','ORG_ID_3',$arr_org3,$arr_txt['show_all'],$ORG_ID_3,'onchange="getORG(this);"','','1');?></span>
            
 		
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	 สังกัดตามกรอบ / สังกัดตามปฎิบัติงาน :</div>
			<div class="col-xs-12 col-sm-2">
                   <select id="type_is" name="type_is" class="selectbox form-control"   placeholder=" สังกัดกรอบ / สังกัดปฎิบัติ " >  
                  
                        <option value="1" <?php echo ($type_is == 1?"selected":"");?>   >สังกัดตามกรอบ</option>
                        <option value="2" <?php echo ($type_is == 2?"selected":"");?>  >สังกัดตามปฎิบัติงาน</option>    
                                                         
                    </select>	
			</div>
        </div> 
 

<?php echo btn_do_center("$('#SEARCH_TYPE').val(1);chk_me();searchData();"); 

     $s_field = "";
	 if($type_is>0){
	     if($type_is==1){
		    $s_field = "b.ORG_ID_3";
		 }else{
		    $s_field = "a.ORG_ID_3";
		 }
	 }
if($SEARCH_TYPE==1){   
$html_start   =  html_report_header($menu_name);


		
		$sql_get_value = "  SELECT     a.PER_IDCARD,c.PREFIX_NAME_TH ,a.PER_FIRSTNAME_TH, a.PER_LASTNAME_TH,a.POS_NO ,a.PER_SALARY
,b.ORG_ID_1 as frame_org1,b.ORG_ID_2 as frame_org2,b.ORG_ID_3 as frame_org3,b.ORG_ID_4 as frame_org4,b.ORG_ID_5 as frame_org5
,a.ORG_ID_1 as act_org1,a.ORG_ID_2  as act_org2,a.ORG_ID_3  as act_org3,a.ORG_ID_4  as act_org4,a.ORG_ID_5  as act_org5 ,a.PER_GENDER ,  d.LINE_NAME_TH, e.ORG_NAME_TH  ,
f.LEVEL_NAME_TH ,g.MANAGE_NAME_TH
 FROM PER_PROFILE a 
LEFT JOIN POSITION_FRAME b ON a.POS_ID = b.POS_ID 
LEFT JOIN SETUP_PREFIX c ON a.PREFIX_ID = c.PREFIX_ID
LEFT JOIN SETUP_POS_LINE d ON a.LINE_ID = d.LINE_ID 
LEFT JOIN SETUP_ORG e ON a.ORG_ID_4 = e.ORG_ID 
LEFT JOIN SETUP_POS_LEVEL f ON a.LEVEL_ID = f.LEVEL_ID 
LEFT JOIN SETUP_POS_MANAGE g ON a.MANAGE_ID = g.MANAGE_ID
WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 

 ".$wh_postype_id;
if($ORG_ID_3>0){
		$sql_get_value .= " AND ".$s_field." = ".$ORG_ID_3." ";
}


 

          // echo "on debuging : ".$sql_get_value.$q_where; exit();
		$query_who = $db->query($sql_get_value.$q_where); 
		$sum_all = $db->db_num_rows($query_who); 
             while($rec1 = $db->db_fetch_array($query_who)){
			 
			 
			  $org3 = (int)$rec1['frame_org3'];
			  $sql = ' SELECT  ORG_NAME_TH from SETUP_ORG where ORG_ID = '.$org3;
			  $query_org = $db->query($sql);
			  $org_is = $db->db_fetch_array($query_org);
			  
			  $org3 = (int)$rec1['act_org3'];
			  $sql = ' SELECT  ORG_NAME_TH from SETUP_ORG where ORG_ID = '.$org3;
			  $query_org = $db->query($sql);
			  $org_is2 = $db->db_fetch_array($query_org);
			  
			  
			  $r_gender = '';
			  if($rec1['PER_GENDER']==2){
			     $r_gender = $arr_gender[2];
			  }
			  if($rec1['PER_GENDER']==1){
			     $r_gender = $arr_gender[1];
			  }
			  $POS_NO = $rec1['POS_NO'];
			  $LEVEL_NAME = text($rec1['LEVEL_NAME_TH']);
			  $MANAGE_NAME_TH = text($rec1['MANAGE_NAME_TH']);
			  $PER_SALARY = number_format($rec1['PER_SALARY'],2);
 		$html  .= "<tr  style='height:0.7cm; padding-left;3px;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
	 		 <td CENTER_TOP >".get_idCard($rec1['PER_IDCARD'])."</td>  
	 		 <td CENTER_TOP >".$POS_NO."</td>  
	 		 <td LEFT_TOP >".text($rec1['PREFIX_NAME_TH'])." ".text($rec1['PER_FIRSTNAME_TH'])." ".text($rec1['PER_LASTNAME_TH'])." </td> 
	 		 
			 <td LEFT_TOP >".text($rec1['LINE_NAME_TH'])." </td> 
	 		 <td LEFT_TOP >".$LEVEL_NAME."&nbsp;&nbsp; </td>  
	 		 <td LEFT_TOP >".$MANAGE_NAME_TH."&nbsp;&nbsp; </td>  
	 		 <td RIGHT_TOP >".$PER_SALARY."&nbsp;  </td>  
			 <td LEFT_TOP >".text($org_is['ORG_NAME_TH'])." </td> 
			 <td LEFT_TOP >".text($org_is2['ORG_NAME_TH'])." </td> 
		 </tr>";
 		$start_no++;
 	  }
} //  if($SEARCH_TYPE==1){   
$html_end   = "</table>";
		include_once("inc_print_btn_and_output.php"); ?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    