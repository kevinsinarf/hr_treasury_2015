<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

 // echo "<pre>"; print_r($_POST); echo "<hr/>";   //echo "<pre>"; print_r($_SESSION); exit();
$menu_name = 32;
$menu_num = "31".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name']; 
 
 

   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
   $arr_org = array();
   $sql_org = "   select   a.POS_NO, a.POS_STATUS,a.POS_FRAME_SALARY,
                    b.TYPE_NAME_TH,
					c.LEVEL_NAME_TH , c.LEVEL_SHORTNAME_EN ,
					d.LINE_NAME_TH,
					e.LG_NAME_TH ,
					k.ORG_SHORTNAME_TH as frame_org_name3  
FROM POSITION_FRAME a 
LEFT JOIN SETUP_POS_TYPE b ON a.TYPE_ID = b.TYPE_ID 
LEFT JOIN  SETUP_POS_LINE d ON a.LINE_ID = d.LINE_ID 
LEFT JOIN SETUP_POS_LEVEL c ON a.LEVEL_ID = c.LEVEL_ID 
LEFT JOIN SETUP_POS_LINE_GROUP e ON a.LG_ID = e.LG_ID  
LEFT JOIN SETUP_ORG k ON a.ORG_ID_3 = k.ORG_ID 
WHERE   a.ACTIVE_STATUS = 1
AND a.POS_STATUS in (1,2)  "; 

if($TYPE_ID > 0){ 
	$sql_org .= " AND  a.TYPE_ID = '".$TYPE_ID."' "; 
}
if($LEVEL_ID > 0){ 
	$sql_org .= " AND  a.LEVEL_ID = '".$LEVEL_ID."' "; 
}
if($LG_ID > 0){ 
	$sql_org .= " AND  a.LG_ID = '".$LG_ID."' "; 
}
if($LINE_ID > 0){ 
	$sql_org .= " AND  a.LINE_ID = '".$LINE_ID."' "; 
}

if($ORG_ID_3 > 0){ 
	$sql_org .= " AND  a.ORG_ID_3 = '".$ORG_ID_3."' "; 
}
 
	$query_org = $db->query($sql_org); 
	$num_rows = $db->db_num_rows($query_org);
 

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
<?php
        include_once("inc_select4_position.php"); 
?>

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
 
<?php
 echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();"); 


	    $html_start   =  html_report_header($menu_name);
	//foreach ($arr_org as $key => $value) {
 
 	while($rec1 = $db->db_fetch_array($query_org)){
 
					$type_name = text($rec1['TYPE_NAME_TH']);
					$LINE_NAME_TH = text($rec1['LINE_NAME_TH']);
					$LG_NAME_TH = text($rec1['LG_NAME_TH']);
					$LEVEL_NAME_TH = text($rec1['LEVEL_NAME_TH']);
					$SALARY =  number_format($rec1['POS_FRAME_SALARY'],2);  
					$frame_org_name3 = text($rec1['frame_org_name3']);
					
					$POS_STATUS = (int)$rec1['POS_STATUS'];
					if($POS_STATUS==1){ $POS_STATUS_NAME = "ว่าง ไม่มีเงิน";  }
					if($POS_STATUS==2){ $POS_STATUS_NAME = "ว่าง มีเงิน";  }
					if($POS_STATUS==3){ $POS_STATUS_NAME = "มีผู้ถือครอง";  }
					if($POS_STATUS==4){ $POS_STATUS_NAME = "ยุบเลิก";  }
					
					
					
		$html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td CENTER_TOP   >".$rec1['POS_NO']." </td> 
			 <td LEFT_TOP   >".$type_name." </td> 
			 <td LEFT_TOP   > ".$LG_NAME_TH."</td> 
		 <td LEFT_TOP   > ".$LINE_NAME_TH."</td> 
		 <td LEFT_TOP   >".$LEVEL_NAME_TH." </td> 
		 <td RIGHT_TOP   > ".$SALARY."&nbsp;&nbsp;</td> 
		 <td CENTER_TOP   >".$frame_org_name3." </td> 
		 <td LEFT_TOP   >".$POS_STATUS_NAME." </td> 
		 </tr>";
		$start_no++;
	}

		$html_end   = "</table>";
		$sum_all = 1;
include_once("inc_print_btn_and_output.php"); 
?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer2.php"); ?>
</div>
</body>
</html>
    
    