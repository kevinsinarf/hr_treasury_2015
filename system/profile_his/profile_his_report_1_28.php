<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
$menu_name = 25;
$menu_num = "24".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name']; 
 
 
   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
 
   $TYPE_ID = (int)$_POST['TYPE_ID'];
   $LEVEL_ID = (int)$_POST['LEVEL_ID'];
   $LG_ID = (int)$_POST['LG_ID'];
   $LINE_ID = (int)$_POST['LINE_ID'];
   
   $POS_STATUS = (int)$_POST['POS_STATUS'];
//ประเภทการถือครอง
$arr_poshis_live = array(  
										'1' => 'ปกติ',
										'2' => 'ปฏิบัติราชการแทน',
										'3' => 'รักษาราชการแทน',
										'4' => 'ช่วยราชการภายในสำนักงานฯ',
										'5' => 'ช่วยราชการภายนอกสำนักงานฯ'
								);


 

 

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
                <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="1">
        
        
<?php    include_once("inc_select4_position.php"); ?>    


		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> </div>
			<div class="col-xs-12 col-sm-3"> 
                    <select id="POS_STATUS" name="POS_STATUS" class="selectbox form-control" placeholder="ทั้งหมด "     >   
                      <option value=""></option>
                      <option value="1">ว่าง ไม่มีเงิน</option>
                      <option value="2">ว่าง มีเงิน</option>
                      <option value="3">มีผู้ถือครอง</option>
                      <option value="4">ยุบเลิก</option>
                    </select>	
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			 </div>
			<div class="col-xs-12 col-sm-2">
 	
			</div>
        </div>
 
<?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();"); 
 
	
     $s_field = "";
	 if($type_is>0){
	     if($type_is==1){
		    $s_field = "b.ORG_ID_3";
		 }else{
		    $s_field = "a.ORG_ID_3";
		 }
	 
	 }
 
	    $html_start   =  html_report_header($menu_name);
		
		$sql_get_value = "  select a.POS_NO,a.TYPE_ID , b.TYPE_NAME_TH , d.LINE_NAME_TH, c.LEVEL_NAME_TH ,e.LG_NAME_TH ,f.MT_NAME_TH 
,a.POS_STATUS ,g.PER_ID ,h.ORG_NAME_TH ,g.PREFIX_ID, g.PER_FIRSTNAME_TH , g.PER_MIDNAME_TH , g.PER_LASTNAME_TH ,i.ORG_NAME_TH as ORG_NAME_TH2
 from POSITION_FRAME a 
LEFT JOIN SETUP_POS_TYPE b ON a.TYPE_ID = b.TYPE_ID 
LEFT JOIN  SETUP_POS_LINE d ON a.LINE_ID = d.LINE_ID 
LEFT JOIN SETUP_POS_LEVEL c ON a.LEVEL_ID = c.LEVEL_ID 
LEFT JOIN SETUP_POS_LINE_GROUP e ON a.LG_ID = e.LG_ID 
LEFT JOIN SETUP_POS_MANAGE_TYPE f ON a.MT_ID = f.MT_ID 

LEFT JOIN PER_PROFILE g ON a.POS_ID = g.POS_ID 
LEFT JOIN SETUP_ORG h ON g.ORG_ID_3 = h.ORG_ID 
LEFT JOIN SETUP_ORG i ON g.ORG_ID_2 = i.ORG_ID 

 WHERE   a.ACTIVE_STATUS = 1
 ";
 

if($TYPE_ID  > 0){
	$sql_get_value .= " AND  a.TYPE_ID = '".$TYPE_ID."'    ";	 
}
if($LEVEL_ID  > 0){
	$sql_get_value .= " AND  a.LEVEL_ID = '".$LEVEL_ID."'   ";	 
}
if($LG_ID  > 0){
	$sql_get_value .= " AND  a.LG_ID = '".$LG_ID."'    ";	 
}
if($LINE_ID  > 0){
	$sql_get_value .= " AND  a.LINE_ID = '".$LINE_ID."'   ";	 
}

if($POS_STATUS > 0){
	$sql_get_value .= " AND  a.POS_STATUS = '".$POS_STATUS."'   ";	 
}

 //echo $sql_get_value; exit();
 /*
if($s_field!=""){

		$sql_get_value .= " AND ".$s_field." = ".$ORG_ID_3." ";
}*/
 
		$query_who = $db->query($sql_get_value." ".$q_where); 
		$sum_all = $db->db_num_rows($query_who); 
             while($rec1 = $db->db_fetch_array($query_who)){
			 
			 
        $line_id_is =(int)$rec1['line_id'];
 		$html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
			 <td CENTER_TOP  >".number_format($start_no)."</td> 
	 		 <td LEFT_TOP >".$rec1['POS_NO']."&nbsp;&nbsp; </td> 
	 		 <td LEFT_TOP >".text($rec1['TYPE_NAME_TH'])."&nbsp;&nbsp; </td> 
	 		 <td LEFT_TOP >".text($rec1['LINE_NAME_TH'])."&nbsp;&nbsp; </td> 
	 		 <td LEFT_TOP >".text($rec1['LEVEL_NAME_TH'])."</td>  
	 		 <td LEFT_TOP >".text($rec1['LG_NAME_TH'])."</td>";
        $POS_STATUS = (int)$rec1['POS_STATUS'];
		if($POS_STATUS==1){ $POS_STATUS_NAME = "ว่าง ไม่มีเงิน";  }
		if($POS_STATUS==2){ $POS_STATUS_NAME = "ว่าง มีเงิน";  }
		if($POS_STATUS==3){ $POS_STATUS_NAME = "มีผู้ถือครอง";  }
		if($POS_STATUS==4){ $POS_STATUS_NAME = "ยุบเลิก";  }
		$PER_NAME = Showname($rec1["PREFIX_ID"],$rec1["PER_FIRSTNAME_TH"],$rec1["PER_MIDNAME_TH"],$rec1["PER_LASTNAME_TH"]);
		
	   if((text($rec1['MT_NAME_TH'])!="อธิบดี")AND(text($rec1['MT_NAME_TH'])!="รองอธิบดี")){ 
				$org3 = text($rec1['ORG_NAME_TH']);
		}else{
				$org3 = text($rec1['ORG_NAME_TH2']);
		}
 		$html  .= " 
		  
	 		 <td LEFT_TOP >".text($rec1['MT_NAME_TH'])."</td> 
 <td LEFT_TOP >".$POS_STATUS_NAME."&nbsp;&nbsp; </td> 
 <td LEFT_TOP >".$PER_NAME."&nbsp;&nbsp; </td> 
 <td LEFT_TOP >".$org3."&nbsp;&nbsp;</td>
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
    
    