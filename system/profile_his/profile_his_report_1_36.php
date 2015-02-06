<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

 // echo "<pre>"; print_r($_POST); echo "<hr/>";   //echo "<pre>"; print_r($_SESSION); exit();
$menu_name = 33;
$menu_num = "32".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
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
<?php
	    $html_start   =  html_report_header($menu_name);
 
   
   $sql_org = "  select   count(a.POS_NO) as pos_num    FROM POSITION_FRAME a  WHERE   a.ACTIVE_STATUS = 1  AND a.POS_STATUS in (1,2,3)  AND a.TYPE_ID = 1 "; 
   $query_org = $db->query($sql_org); 
   $rec1 = $db->db_fetch_array($query_org);
   $pos1 = (int)$rec1['pos_num'];
			 
		$html  .= "<tr  style='height:0.7cm;'>  <td CENTER_TOP  >1</td> <td LEFT_TOP >ทั่วไป</td> <td RIGHT_TOP >".number_format($pos1,0)."&nbsp;&nbsp;</td> </tr>";
		
   $sql_org = "  select   count(a.POS_NO) as pos_num    FROM POSITION_FRAME a  WHERE   a.ACTIVE_STATUS = 1  AND a.POS_STATUS in (1,2,3)  AND a.TYPE_ID = 2 "; 
   $query_org = $db->query($sql_org); 
   $rec1 = $db->db_fetch_array($query_org);
   $pos2 = (int)$rec1['pos_num'];
 
		$html  .= "<tr  style='height:0.7cm;'>  <td CENTER_TOP  >2</td> <td LEFT_TOP >วิชาการ</td> <td RIGHT_TOP >".number_format($pos2,0)."&nbsp;&nbsp;</td> </tr>";
		
   $sql_org = "  select   count(a.POS_NO) as pos_num    FROM POSITION_FRAME a  WHERE   a.ACTIVE_STATUS = 1  AND a.POS_STATUS in (1,2,3)  AND a.TYPE_ID = 3 "; 
   $query_org = $db->query($sql_org); 
   $rec1 = $db->db_fetch_array($query_org);
   $pos3 = (int)$rec1['pos_num'];
		
		$html  .= "<tr  style='height:0.7cm;'>  <td CENTER_TOP  >3</td> <td LEFT_TOP >อำนวยการ</td> <td RIGHT_TOP >".number_format($pos3,0)."&nbsp;&nbsp;</td> </tr>";
		
		
   $sql_org = "  select   count(a.POS_NO) as pos_num    FROM POSITION_FRAME a  WHERE   a.ACTIVE_STATUS = 1  AND a.POS_STATUS in (1,2,3)  AND a.TYPE_ID = 4 "; 
   $query_org = $db->query($sql_org); 
   $rec1 = $db->db_fetch_array($query_org);
   $pos4 = (int)$rec1['pos_num'];
		
		$html  .= "<tr  style='height:0.7cm;'>  <td CENTER_TOP  >4</td> <td LEFT_TOP >บริหาร</td> <td RIGHT_TOP >".number_format($pos4,0)."&nbsp;&nbsp;</td> </tr>";
   $pos_all = $pos4 + $pos3 + $pos2 + $pos1; 
		$html  .= "<tr  style='height:0.7cm;'> 
			 
			 <td LEFT_TOP  colspan='2' ><div align='center'><strong>รวมจำนวน ( อัตรา )</strong></td> 
			 <td RIGHT_TOP >".number_format($pos_all,0)."&nbsp;&nbsp;</td> 

		 </tr>";

		$html_end   = "</table>";
		$sum_all = 1;
		include_once("inc_print_btn_and_output.php"); 
?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    