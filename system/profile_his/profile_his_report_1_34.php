<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

 // echo "<pre>"; print_r($_POST); echo "<hr/>";   //echo "<pre>"; print_r($_SESSION); exit();
$headline_title = "  จำนวนตำแหน่งจำแนกตามลักษณะของตำแหน่ง                      ";
$menu_name = 34;
$menu_num = "30".$number_subfix;
 
 

   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
   $arr_org = array();
 
	     $arr_org[1] = "ว่าง ไม่มีเงิน";
	     $arr_org[2] = "ว่าง มีเงิน";
	     $arr_org[3] = "มีผู้ถือครอง";
	     $arr_org[4] = "ยุบเลิก";

 
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

 
 
<?php
		 	 $pos_status[1] = 0;
		 	 $pos_status[2] = 0;
		 	 $pos_status[3] = 0;
		 	 $pos_status[4] = 0; 
			$filter = " AND  ACTIVE_STATUS = 1  AND  DELETE_FLAG = 0   AND  NULLIF( LINE_ID,'') IS NOT NULL  AND  NULLIF( LEVEL_ID,'') IS NOT NULL   AND  NULLIF( TYPE_ID,'') IS NOT NULL  and TYPE_ID in ( 1,2,3,4)";
	        $sql = " select count(pos_status) as sum_pos from POSITION_FRAME where pos_status = 1       ".$filter ; 
 
	        $query_1 = $db->query($sql); 
			$rec1 = $db->db_fetch_array($query_1);
	        $pos_status[1] =  $rec1['sum_pos'];
 
	        $sql = " select count(pos_status) as sum_pos from POSITION_FRAME where pos_status = 2   ".$filter ; //echo $sql ; 
	 
	        $query_2 = $db->query($sql); 
			$rec2 = $db->db_fetch_array($query_2);
	        $pos_status[2] = $rec2['sum_pos'];   
			
			
	        $sql = " select count(pos_status) as sum_pos from POSITION_FRAME where pos_status = 3   ".$filter ; //echo $sql ;  
 
	        $query_3 = $db->query($sql); 
			$rec3 = $db->db_fetch_array($query_3);
	        $pos_status[3] = $rec3['sum_pos'];
 
	        $sql = " select count(pos_status) as sum_pos from POSITION_FRAME where pos_status = 4     ".$filter ; //echo $sql ;  
 
	        $query_4 = $db->query($sql); 
			$rec4 = $db->db_fetch_array($query_4);
	        $pos_status[4] =  $rec4['sum_pos'];  
			
			$sum_pos_status = $pos_status[1] + $pos_status[2] + $pos_status[3] + $pos_status[4];
			
	
	$html_start   =  "  <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;' class='table table-bordered table-striped table-hover table-condensed' >
		<thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  <tr class='bgHead'>
    <th style=''><div align='center'><strong>สถานภาพของตำแหน่ง</strong></div></th>
    <th style=''><div align='center'><strong>ข้าราชการ</strong></div></th>
  </tr>	
		</thead> 
	"; 
 
 
 
	foreach ($arr_org as $key => $value) {
		//echo "$key$value<br/>";
		$officer_num = 0;
		$regular_emp_num = 0;
		$temp_emp_num = 0;
		$all_emp_num = $officer_num + $regular_emp_num + $temp_emp_num;
		
		$html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
 
			 <td LEFT_TOP  >".$value."</td>  <td RIGHT_TOP >".number_format($pos_status[$key],0)."&nbsp;&nbsp;</td> 
		 </tr>";
		$start_no++;
	}
	 
 	  
		$html  .= "<tr  style='height:0.7cm;'> 
 
			 <td CENTER_TOP  >  รวม ( อัตรา )  </td> 	  <td RIGHT_TOP >".number_format($sum_pos_status,0)."&nbsp;&nbsp;</td> 
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
    
    