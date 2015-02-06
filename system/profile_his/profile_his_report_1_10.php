<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
$menu_name = 10;
$menu_num = "9".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
   // POST Value;
   $AGE_IS = $_POST['AGE_IS'];   
   // array 
   $arr_org = array();
   $arr_org1 = array();
   $arr_org2 = array();
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
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['budget_year_fill']; ?>  :</div>
			<div class="col-xs-12 col-sm-3">
            
                    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="<?php echo $arr_txt['budget_year']; ?> "     >   
                     
                      <?php 
					  $this_month =  date('m', time());  
					  $this_year =  date('Y', time());
					  $this_year_temp = $this_year;
					  if($this_year < 2300){
					      $this_year = $this_year + 543;
					  }  
					  if($this_month >= 10){
					      $this_year  = $this_year+1;
					  } 
					  if($AGE_IS > 0){
					  	$search_year = $AGE_IS;
					  }else{
					  	$search_year = $this_year;
					  }
					   for($i=$this_year;$i>2540;$i--){
					            $j = 2014;$j--;
					      if($AGE_IS>0){
						     $arr_org1 = array();
					     	 $arr_org1[$AGE_IS] = $AGE_IS;
						  }else{
					     	 $arr_org1[$i] = $i; 	
						  }	
						  

						  
						  
					  ?>
                        <option value="<?php echo $i;?>"  <?php echo ($search_year == $i?"selected":"");?>    >
                        <?php echo $i;?></option>
                      <?php }?>
                    </select>				
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			<div class="col-xs-12 col-sm-2">
 
      		 <?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();","a"); ?>
            
            </div></div>
			<div class="col-xs-12 col-sm-2">
 	
			</div>
        </div>
        
        
 <?php
 
	
	$html_start   =  html_report_header($menu_name);
 
    $q_where = '';	
   if($SEARCH_TYPE==1){   
       $arr_org = $arr_org1;
	   
	   if($AGE_IS>0){
 
			 $q_where = ' and year(a.PER_DATE_RETIRE) = '.$AGE_IS.'   ';	 
		} else{
		     exit();
		}  
   }else{
      exit();
   }
   
 
   $arr_org = array();
   $arr_org[1] = "บรรจุใหม่";
   $arr_org[2] = "บรรจุกลับ";	
   $arr_org[3] = "รับโอน"; 
   $arr_org[4] = "โอนออกไป";   
   $arr_org[5] = "เกษียณอายุปกติ"; 
   $arr_org[6] = "เกษียณอายุก่อนกำหนด"; 
   $arr_org[7] = "ลาออก";   
   $arr_org[8] = "ออกด้วยเหตุผิดวินัย";
   $arr_org[9] = "ตาย";
 
	
	foreach ($arr_org as $key => $value) {
        
       $q_where = "";

	   if($key==1){  $q_where .= " AND e.MOVE_PROCESS_ID = 1 ";   }  // บรรจุใหม่ 
	   if($key==2){  $q_where .= " AND e.MOVE_PROCESS_ID = 16 ";     }	 //"บรรจุกลับ";	
	   if($key==3){  $q_where .= " AND e.MOVE_PROCESS_ID = 2 ";    }	 //"รับโอน;	
	   if($key==4){  $q_where .= " AND e.MOVE_PROCESS_ID = 6 ";    }	 //"โอนออกไป;	
	   
	   if($key==5){  $q_where .= " AND a.RETYPE_ID = 6 ";   }  // เกษียณอายุปกติ 
	   if($key==6){  $q_where .= " AND a.RETYPE_ID = 20 ";     }	 //"เกษียณอายุก่อนกำหนด";	
	   if($key==7){  $q_where .= " AND a.RETYPE_ID = 5 ";    }	 //"ลาออก";	
	   if($key==8){  $q_where .= " AND a.RETYPE_ID = 15 ";   }	 //"ออกด้วยเหตุผิดวินัย";	
	   if($key==9){  $q_where .= " AND a.RETYPE_ID = 3 ";     }	 //"ตาย";	  
	   
	    
       if($key>=5){ // ออก ตาย 
	   // RETIRE_SETUP_TYPE 
	  //officer_year_between($AGE_IS,"a.COM_SDATE");
				$sql_get_value = " select a.per_id,a.RETYPE_ID,b.RETYPE_NAME_TH,c.TYPE_NAME_TH from per_profile a 
left join RETIRE_SETUP_TYPE b ON a.RETYPE_ID = b.RETYPE_ID
left join SETUP_POS_TYPE c ON a.type_id = c.type_id 
WHERE a.PER_STATUS =2 
AND a.ACTIVE_STATUS = 1
			  ".$q_where.officer_year_between($AGE_IS,"a.PER_DATE_RESIGN"); 
	   }else{
				$q_where .= officer_year_between($AGE_IS,"a.COM_SDATE");
				$sql_get_value = " select a.per_id, c.TYPE_NAME_TH,a.MOVEMENT_ID
 from PER_POSITIONHIS a 
			left join SETUP_POS_TYPE c ON a.type_id = c.type_id 
      left join SETUP_MOVEMENT d ON a.MOVEMENT_ID = d.MOVEMENT_ID
      left join SETUP_MOVEMENT_PROCESS e ON d.MOVE_PROCESS_ID = e.MOVE_PROCESS_ID
	  WHERE a.ACTIVE_STATUS = 1
			".$q_where; 
	   }
  
	    
		$html  .= "<tr  style='height:0.7cm;padding-left:3px;'> ";
	 
		//$html  .= "<td LEFT_TOP   >&nbsp;&nbsp;".$value."<br/>".$sql_get_value."</td>";
		$html  .= "<td LEFT_TOP   >".$value."</td>";
		$sum_civil = 0; 
		$query_get_civil = $db->query($sql_get_value." AND a.type_id IN (1,2,3,4)"); 
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 1  and a.level_id = 16  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 1  and a.level_id = 15  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 1  and a.level_id = 14  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 1  and a.level_id = 13  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 2  and a.level_id = 12  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 2  and a.level_id = 11  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> ";  
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 2  and a.level_id = 10  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 2  and a.level_id = 9  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 2  and a.level_id = 8  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 3  and a.level_id = 7  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 3  and a.level_id = 6  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 4  and a.level_id = 2  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> ";
		$sum_civil = 0;
		$query_get_civil = $db->query($sql_get_value." AND a.type_id = 3  and a.level_id = 1  ");
		$sum_civil = (int)$db->db_num_rows($query_get_civil);
		$html  .= "<td CENTER_TOP >".number_format($sum_civil,0)."&nbsp;&nbsp;</td> "; 
		$html  .= " </tr>";
	 
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
    
    