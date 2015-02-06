<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);


$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}

$menu_name = 11;
$menu_num = "10".$number_subfix;

if($postype_id_is > 0){
	if($postype_id_is==3){
		$menu_name = 42; 
	    $menu_num = "40".$number_subfix;
	}
	if($postype_id_is==5){
		$menu_name = 56; 
        $menu_num = "54".$number_subfix;
	}
} 

$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
   // POST Value;
   $AGE_IS = $_POST['AGE_IS'];   
   $AGE_IS_gen = $AGE_IS; // for print data.
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
                <input type="hidden" id="POSTYPE_ID_is" name="POSTYPE_ID_is" value="<?php echo $postype_id_is; ?>"> 
        
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
		}   
   } 
		$officer_num = 0;
		$officer_sum =0;
		$regular_emp_num = 0;
		$regular_emp_sum = 0;
		$temp_emp_num = 0;	
		$temp_emp_sum = 0;	
		
		$officer_num_m = 0;
		$officer_sum_m =0;
		$regular_emp_num_m = 0;
		$regular_emp_sum_m = 0;
		$temp_emp_num_m = 0;	
		$temp_emp_sum_m = 0;	
		
		$officer_num_w = 0;
		$officer_sum_w =0;
		$regular_emp_num_w = 0;
		$regular_emp_sum_w = 0;
		$temp_emp_num_w = 0;	
		$temp_emp_sum_w = 0;	
		//echo "<pre>"; print_r($arr_org);
		
	foreach ($arr_org as $key => $value) {
        if($SEARCH_TYPE==1){ 
		    if($AGE_IS>0){
			        //$AGE_IS2 = $AGE_IS-543;
           			//$q_where = ' and ((year(a.PER_DATE_RETIRE) = '.$AGE_IS.')or(year(a.PER_DATE_RETIRE) = '.$AGE_IS2.'))   ';
					$q_where = officer_year_between($AGE_IS,"b.COM_SDATE");
			}else{
					//$AGE_IS2 = $key-543;
           			//$q_where = ' and ((year(a.PER_DATE_RETIRE) = '.$key.')or(year(a.PER_DATE_RETIRE) = '.$AGE_IS2.'))   ';
					$q_where = officer_year_between($key,"b.COM_SDATE");
			}  
		}
		/*
		SELECT c.MOVEMENT_GROUP,b.POS_NO,b.ORG_ID_3 as new_position,a.ORG_ID_3 as old_position,b.ORG_ID_4,a.ORG_ID_4,c.MOVEMENT_NAME_TH  FROM PER_POSITIONHIS b 
LEFT JOIN PER_PROFILE a
ON b.PER_ID = a.PER_ID
LEFT JOIN SETUP_MOVEMENT c
ON b.MOVEMENT_ID = c.MOVEMENT_ID
WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 
AND    b.COM_SDATE between convert(datetime,'10/01/2013') and convert(datetime,'09/30/2014')
AND c.MOVEMENT_GROUP = 1 
AND b.ORG_ID_3 <> a.ORG_ID_3
		*/
	    $sql_get_value = " SELECT c.MOVEMENT_GROUP,b.POS_NO,b.ORG_ID_3 as new_position,a.ORG_ID_3 as old_position,b.ORG_ID_4,a.ORG_ID_4,c.MOVEMENT_NAME_TH  FROM PER_POSITIONHIS b 
LEFT JOIN PER_PROFILE a
ON b.PER_ID = a.PER_ID
LEFT JOIN SETUP_MOVEMENT c
ON b.MOVEMENT_ID = c.MOVEMENT_ID
WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 
AND c.MOVEMENT_GROUP = 1 
AND b.ORG_ID_3 <> a.ORG_ID_3 ";
	 

	       // echo $key.$q_where."<br/>".$sql_get_value." and a.PT_ID = 1  and a.PER_GENDER = 1   ".$q_where; exit();
		$query_get_officer_m = $db->query($sql_get_value." and a.POSTYPE_ID =  '".$postype_id_is."'  and a.PER_GENDER = 1   ".$q_where); 
		//$query_get_regular_m = $db->query($sql_get_value." and a.PT_ID = 3   and a.PER_GENDER = 1   ".$q_where);
		//$query_get_emp_m  = $db->query($sql_get_value." and a.PT_ID = 2   and a.PER_GENDER = 1  ".$q_where);
		
		$query_get_officer_w = $db->query($sql_get_value." and a.POSTYPE_ID =  '".$postype_id_is."'   and a.PER_GENDER = 2   ".$q_where); 
		//$query_get_regular_w = $db->query($sql_get_value." and a.PT_ID = 3   and a.PER_GENDER = 2  ".$q_where);
		//$query_get_emp_w  = $db->query($sql_get_value." and a.PT_ID = 2  and a.PER_GENDER = 2   ".$q_where);
		
	    $officer_num_m = $db->db_num_rows($query_get_officer_m);  
			$officer_sum_m = $officer_sum_m + $officer_num_m;
		//$regular_emp_num_m = $db->db_num_rows($query_get_regular_m);
		//    $regular_emp_sum_m = $regular_emp_sum_m + $regular_emp_num_m; 
		//$temp_emp_num_m =  $db->db_num_rows($query_get_emp_m);
        //    $temp_emp_sum_m = $temp_emp_sum_m + $temp_emp_num_m;
		 
		
		
	    $officer_num_w = $db->db_num_rows($query_get_officer_w);  
			$officer_sum_w = $officer_sum_w + $officer_num_w;
		//$regular_emp_num_w = $db->db_num_rows($query_get_regular_w);
		////    $regular_emp_sum_w = $regular_emp_sum_w + $regular_emp_num_w; 
		//$temp_emp_num_w =  $db->db_num_rows($query_get_emp_w);
        //    $temp_emp_sum_w = $temp_emp_sum + $temp_emp_num_w;
		
		$html .= table_all3group_w_gender_row1($start_no,$value,$officer_num_m,$officer_num_w);
		$start_no++;
	}
	 
 
	    // summery 
	    $html .= table_all3group_w_gender_sum1($officer_sum_m,$officer_sum_w);	
		$html_end   = "</table>";
include_once("inc_print_btn_and_output.php"); ?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    