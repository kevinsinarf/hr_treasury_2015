<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

 // echo "<pre>"; print_r($_POST); echo "<hr/>";   //echo "<pre>"; print_r($_SESSION); exit();
$menu_name = 30;
$menu_num = "29".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name']; 
 

   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
   $arr_org = array();
   // $sql_org = "select DISTINCT LINE_ID from POSITION_FRAME  ORDER BY LINE_ID  "; 
   
   $sql = " select DISTINCT a.LINE_ID,c.TYPE_NAME_TH,b.LINE_NAME_TH,c.TYPE_SEQ,d.LEVEL_NAME_TH ,a.LEVEL_ID,a.TYPE_ID from POSITION_FRAME a 
left join setup_pos_line b on a.LINE_ID = b.LINE_ID
left join SETUP_POS_TYPE c on a.TYPE_ID = c.TYPE_ID 
left join SETUP_POS_LEVEL d on a.LEVEL_ID = d.LEVEL_ID 
   WHERE  a.ACTIVE_STATUS = 1  AND a.DELETE_FLAG = 0 AND b.DELETE_FLAG = 0
AND  a.POSTYPE_ID = '1'  
AND b.ACTIVE_STATUS = 1 
AND  b.POSTYPE_ID = '1' 
AND  NULLIF(c.TYPE_NAME_TH, '') IS NOT NULL  
AND  NULLIF(d.LEVEL_NAME_TH, '') IS NOT NULL 
AND  NULLIF(b.LINE_NAME_TH, '') IS NOT NULL 
 ";
   

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
	$query_org = $db->query($sql);  
	$num_rows = $db->db_num_rows($query_org);
 

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
                
<?php include_once("inc_select4_position.php"); 
 echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();"); 
 
	    $html_start   =  html_report_header($menu_name);
	//foreach ($arr_org as $key => $value) {
 
 	while($rec_org = $db->db_fetch_array($query_org)){
	   //  $arr_org[$rec_org['LINE_ID']] = text($rec_org['LINE_NAME_TH']);
            $line_id = (int)$rec_org['LINE_ID'];
            $level_id = (int)$rec_org['LEVEL_ID'];
			$TYPE_ID = (int)$rec_org['TYPE_ID'];
			 $pos_status1 = 0;
			 $pos_status2 = 0;
			 $pos_status3 = 0;
			 $pos_status4 = 0;	 
			 
	        $sql = " select count(pos_status) as sum_pos from POSITION_FRAME where pos_status = 1 and line_id =  ".$line_id; 
			if($level_id > 0 ){ 
			$sql .= " AND  LEVEL_ID = '". $level_id."' ";
			}
			if($TYPE_ID > 0 ){ 
			$sql .= " AND  TYPE_ID = '". $TYPE_ID."' ";
			}  
	        $query_1 = $db->query($sql); 
			$rec1 = $db->db_fetch_array($query_1);
	        $pos_status1 =  $rec1['sum_pos'];
 
	        $sql = " select count(pos_status) as sum_pos from POSITION_FRAME where pos_status = 2 and line_id =  ".$line_id; //echo $sql ; 
			if($level_id > 0 ){ 
			$sql .= " AND  LEVEL_ID = '". $level_id."' ";
			}
			if($TYPE_ID > 0 ){ 
			$sql .= " AND  TYPE_ID = '". $TYPE_ID."' ";
			}
	        $query_2 = $db->query($sql); 
			$rec2 = $db->db_fetch_array($query_2);
	        $pos_status2 =  $rec2['sum_pos'];   
			
	        $sql = " select count(pos_status) as sum_pos from POSITION_FRAME where pos_status = 3 and line_id =  ".$line_id; //echo $sql ;  
			if($level_id > 0 ){ 
			$sql .= " AND  LEVEL_ID = '". $level_id."' ";
			}
			if($TYPE_ID > 0 ){ 
			$sql .= " AND  TYPE_ID = '". $TYPE_ID."' ";
			}
	        $query_3 = $db->query($sql); 
			$rec3 = $db->db_fetch_array($query_3);
	        $pos_status3 =  $rec3['sum_pos'];
 
	        $sql = " select count(pos_status) as sum_pos from POSITION_FRAME where pos_status = 4 and line_id =  ".$line_id; //echo $sql ;  
			if($level_id > 0 ){ 
			$sql .= " AND  LEVEL_ID = '". $level_id."' ";
			}
			if($TYPE_ID > 0 ){ 
			$sql .= " AND  TYPE_ID = '". $TYPE_ID."' ";
			}
	        $query_4 = $db->query($sql); 
			$rec4 = $db->db_fetch_array($query_4);
	        $pos_status4 =  $rec4['sum_pos'];  
			
			$sum_pos_status = $pos_status1+$pos_status2+$pos_status3+$pos_status4;	
			
 
			
	        $line_name =  text($rec_org['LINE_NAME_TH']); 
			$TYPE_NAME_TH = text($rec_org['TYPE_NAME_TH']); 
			$LEVEL_NAME_TH = text($rec_org['LEVEL_NAME_TH']);
			 
		$html  .= "<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td LEFT_TOP   >".$TYPE_NAME_TH."</td> 
			 <td LEFT_TOP   >".$LEVEL_NAME_TH."</td> 
			 <td LEFT_TOP   >".$line_name."</td> 

			 <td CENTER_TOP >".number_format($pos_status1,0)."&nbsp;&nbsp;</td> 
			 <td CENTER_TOP >".number_format($pos_status2,0)."&nbsp;&nbsp;</td> 
			 <td CENTER_TOP >".number_format($pos_status3,0)."&nbsp;&nbsp;</td> 	
			 <td CENTER_TOP >".number_format($pos_status4,0)."&nbsp;&nbsp;</td> 		 
 			 <td CENTER_TOP >".number_format($sum_pos_status,0)."&nbsp;&nbsp;</td> 
		 </tr>";
		$start_no++;
		$pos_status1_all = $pos_status1_all + $pos_status1;
		$pos_status2_all = $pos_status2_all + $pos_status2;
		$pos_status3_all = $pos_status3_all + $pos_status3;
		$pos_status4_all = $pos_status4_all + $pos_status4;
		$sum_pos_status_all = $sum_pos_status_all + $sum_pos_status; 
	}
	
		$html  .= "<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  colspan=4   >&nbsp;&nbsp; รวม ( อัตรา )  </td> 	
	 

			 <td CENTER_TOP >".number_format($pos_status1_all,0)."&nbsp;&nbsp;</td> 
			 <td CENTER_TOP >".number_format($pos_status2_all,0)."&nbsp;&nbsp;</td> 
			 <td CENTER_TOP >".number_format($pos_status3_all,0)."&nbsp;&nbsp;</td> 	
			 <td CENTER_TOP >".number_format($pos_status4_all,0)."&nbsp;&nbsp;</td> 		 
 			 <td CENTER_TOP >".number_format($sum_pos_status_all,0)."&nbsp;&nbsp;</td> 
		 </tr>";

		$html_end   = "</table>";
		$sum_all = 1;
		include_once("inc_print_btn_and_output.php"); ?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer2.php"); ?>
</div>
</body>
</html>
    
    