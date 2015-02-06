<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
$menu_name = 28;
$menu_num = "27".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
   // POST Value;
   $AGE_IS = (int)$_POST['AGE_IS']; 
   $type_is = (int)$_POST['type_is'];  
$PER_ID=$_POST['PER_ID'];
$POSHIS_ID=$_POST['POSHIS_ID'];
   
   $TYPE_ID = (int)$_POST['TYPE_ID'];
   $LEVEL_ID = (int)$_POST['LEVEL_ID'];
   $LG_ID = (int)$_POST['LG_ID'];
   $LINE_ID = (int)$_POST['LINE_ID'];
   
   // array 
   $arr_org = array();
   $arr_org1 = array();
   $arr_org2 = array();
//ประเภทการถือครอง
$arr_poshis_live = array(  
										'1' => 'ปกติ',
										'2' => 'ปฏิบัติราชการแทน',
										'3' => 'รักษาราชการแทน',
										'4' => 'ช่วยราชการภายในสำนักงานฯ',
										'5' => 'ช่วยราชการภายนอกสำนักงานฯ'
								);

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}

//org1
$arr_org1=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.OL_ID='2' ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");
//org2
if(trim($rec['ORG_ID_1']) != ''){
	$org_id_1 = $rec['ORG_ID_1']; 
}else{
	$org_id_1 = 405;
}
 

 

$LEVEL_ID = (int)$_POST['LEVEL_ID'];
$LG_ID = (int)$_POST['LG_ID'];
$LINE_ID = (int)$_POST['LINE_ID'];
$ORG_ID_1 = (int)$_POST['ORG_ID_1'];
$ORG_ID_2 = (int)$_POST['ORG_ID_2'];
$ORG_ID_3 = (int)$_POST['ORG_ID_3'];
$ORG_ID_4 = (int)$_POST['ORG_ID_4'];
$ORG_ID_5 = (int)$_POST['ORG_ID_5'];



		

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
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><a href="profile_his_report_disp.php?<?php echo $paramlink; ?>"><?php echo showMenu($menu_sub_id); ?></a></li>
            <?php active_title($menu_num.$headline_title); ?>
		</ol>
	</div>
    
    
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
                <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="1">
 
        
  
<?php include_once("inc_select4_position.php");    
 echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();"); 
 
 
	$html_start   =  html_report_header($menu_name);
 
    $q_where = '';	 
   if($SEARCH_TYPE==1){    
       $arr_org = $arr_org1;
	   
  
   }else{
       exit();
   }
 
	    $sql = " select DISTINCT a.LINE_ID,c.TYPE_NAME_TH,b.LINE_NAME_TH, c.TYPE_SEQ from POSITION_FRAME a 
left join setup_pos_line b on a.LINE_ID = b.LINE_ID
left join SETUP_POS_TYPE c on a.TYPE_ID = c.TYPE_ID 
 
   WHERE  a.ACTIVE_STATUS = 1  AND a.DELETE_FLAG = 0 AND b.DELETE_FLAG = 0
AND  a.POSTYPE_ID = '1'  
AND b.ACTIVE_STATUS = 1 
AND  b.POSTYPE_ID = '1'  ";



if($TYPE_ID  > 0){
	$sql .= " AND  (a.TYPE_ID = '".$TYPE_ID."' )  ";	 
}
if($LEVEL_ID  > 0){
	$sql .= " AND  (a.LEVEL_ID = '".$LEVEL_ID."' )   ";	 
}
if($LG_ID  > 0){
	$sql .= " AND  (a.LG_ID = '".$LG_ID."' )   ";	 
}
if($LINE_ID  > 0){
	$sql .= " AND  (a.LINE_ID = '".$LINE_ID."' )   ";	 
}

$sql .= " ORDER BY  c.TYPE_SEQ ASC,  b.LINE_NAME_TH ASC   ";
         $query = $db->query($sql);
		 $arr_org = array();
		 $count_data_all = 0;
		 while($rec1 = $db->db_fetch_array($query)){
		        $line_id = $rec1['LINE_ID']; 
                $sql_count = "  select count(per_id) as all_per from PER_PROFILE where LINE_ID= '".$line_id."' ";
				$sql_count .= " and LINE_ID > 0 AND  PER_STATUS_CIVIL = 2   ";
				$query_count = $db->query($sql_count);
				$rec_count = $db->db_fetch_array($query_count);
				$count_data = $rec_count['all_per'];
		       $html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
		
					 			 <td LEFT_TOP  >  ".text($rec1['TYPE_NAME_TH'])."</td> 
					 <td LEFT_TOP   >".text($rec1['LINE_NAME_TH'])." </td> 	  
					 			 <td CENTER_TOP  >".number_format($count_data,0)." </td> 
				  </tr>";
			$start_no++;
			$count_data_all = $count_data_all + $count_data;
	  }
	//}      
		       $html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
		
					 			 <td LEFT_TOP     colspan=2  >&nbsp;&nbsp; รวม ( อัตรา )  </td> 	  
					 			 <td CENTER_TOP   >".number_format($count_data_all,0)." </td> 
				  </tr>";
	
 
		$html_end   = "</table>";
		include_once("inc_print_btn_and_output.php"); ?>
     
         </div> 
 </div> 
 
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    