<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 8;
if($postype_id_is > 0){
	if($postype_id_is==5){
		$menu_name = 54; 
	}
} 

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
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><a href="profile_his_report_disp.php?<?php echo $paramlink; ?>"><?php echo showMenu($menu_sub_id); ?></a></li>
            <li class="active"><?php echo $headline_title; ?></li>
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
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['budget_year_fill']; ?> :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="<?php echo $arr_txt['budget_year']; ?> "     >   
                      <option value=""></option>
                      <?php for($i=2557;$i>2540;$i--){
					            $j = 2014;$j--;
					      if($AGE_IS>0){
						     $arr_org1 = array();
					     	 $arr_org1[$AGE_IS] = $AGE_IS;
						  }else{
					     	 $arr_org1[$i] = $i; 	
						  }	
					  ?>
                        <option value="<?php echo $i;?>"  <?php echo ($AGE_IS == $i?"selected":"");?>    >
                        <?php echo $i;?></option>
                      <?php }?>
                    </select>				
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			<div class="col-xs-12 col-sm-2"><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);searchData();">ค้นหา</button></div></div>
			<div class="col-xs-12 col-sm-2">
 	
			</div>
        </div>
 <?php
 
	
	$html_start   =  html_report_header($menu_name);
 
    $q_where = '';	
   if($SEARCH_TYPE==1){   
       $arr_org = $arr_org1;
	   if($AGE_IS>0){
			 //$q_where = ' and year(a.PER_DATE_RETIRE) = '.$AGE_IS.'   ';
			 $q_where = " and a.PER_DATE_RETIRE between convert(datetime,'10/01/".($AGE_IS-1)."') and convert(datetime,'09/30/".$AGE_IS."') ";
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
			        $AGE_IS2 = $AGE_IS-543;
					//$q_where = " and ((a.PER_DATE_RETIRE between convert(datetime,'10/01/".($AGE_IS-1)."') and convert(datetime,'09/30/".$AGE_IS."'))or(a.PER_DATE_RETIRE between convert(datetime,'10/01/".($AGE_IS2-1)."') and convert(datetime,'09/30/".$AGE_IS2."') )) ";
					$q_where = officer_year_between($AGE_IS,"a.PER_DATE_RETIRE");
					$q_where2 = not_between_bugget_year($AGE_IS);
			}else{
					$AGE_IS2 = $key-543;
					//$q_where = " and ((a.PER_DATE_RETIRE between convert(datetime,'10/01/".($key-1)."') and convert(datetime,'09/30/".$key."'))or(a.PER_DATE_RETIRE between convert(datetime,'10/01/".($AGE_IS2-1)."') and convert(datetime,'09/30/".$AGE_IS2."') )) ";
					$q_where = officer_year_between($key,"a.PER_DATE_RETIRE");
					$q_where2 = not_between_bugget_year($key);
			}
		}
	
 
	    $sql_get_value = " SELECT  PER_ID FROM PER_PROFILE a   WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1   ";
	 

	         //echo $key.$q_where."<br/>".$sql_get_value." and a.PT_ID = 1      ".$q_where; exit();
		$query_get_officer = $db->query($sql_get_value." and a.PT_ID = 1      ".$q_where); //echo $sql_get_value." and a.PT_ID = 1      ".$q_where."<br/>"; 
		$query_get_regular = $db->query($sql_get_value." and a.PT_ID = 3    ".$q_where); 

		$query_get_officer_all = $db->query($sql_get_value." and a.PT_ID = 1  AND a.PER_STATUS_CIVIL = 2 ".$q_where2);  //echo $sql_get_value." and a.PT_ID = 1  ".$q_where2."<br/>"; 
		$query_get_regular_all = $db->query($sql_get_value." and a.PT_ID = 3  AND a.PER_STATUS_CIVIL = 2   ".$q_where2); //echo $sql_get_value." and a.PT_ID = 3     ".$q_where2; exit();
		
  
		
	    $officer_num = $db->db_num_rows($query_get_officer);  
			$officer_sum = $officer_sum + $officer_num;
		$regular_emp_num = $db->db_num_rows($query_get_regular);
		    $regular_emp_sum = $regular_emp_sum + $regular_emp_num; 
 

	    $officer_all_num = $db->db_num_rows($query_get_officer_all);  
			$officer_all_sum = $officer_all_sum + $officer_all_num;
		$regular_emp_all_num = $db->db_num_rows($query_get_regular_all);
 
		    $regular_emp_all_sum = $regular_emp_all_sum + $regular_emp_all_num; 
            // บวกจำนวนที่เกษียณของปีนี้เข้าไป 	
			$officer_all_num = $officer_all_num + $officer_num;
			if($officer_all_num>0){
				$officer_rato = ($officer_num/$officer_all_num)*100;
				}else{
				  $officer_rato =  0;
				}
            // บวกจำนวนที่เกษียณของปีนี้เข้าไป 	
			$regular_emp_all_num = $regular_emp_all_num + $regular_emp_num;	
			if($regular_emp_all_num >0){
 							$regular_emp_rato = ($regular_emp_num/$regular_emp_all_num)*100;
			}else{
			    			$regular_emp_rato = 0;
			}
 
		//$all_emp_num = $officer_num_m+$regular_emp_num_m+$temp_emp_num_m+$officer_num_w+$regular_emp_num_w+$temp_emp_num_w;

		$html  .= "<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td CENTER_TOP   >&nbsp;&nbsp;".$value."</td> 
			 <td RIGHT_TOP >".number_format($officer_num,0)."&nbsp;&nbsp;</td> 
			 <td RIGHT_TOP >".number_format($officer_all_num,0)."&nbsp;&nbsp;</td> 
			 <td RIGHT_TOP >".number_format($officer_rato,0)." %&nbsp;&nbsp;</td>
			 <td RIGHT_TOP >".number_format($regular_emp_num,0)."&nbsp;&nbsp;</td> 
			 <td RIGHT_TOP >".number_format($regular_emp_all_num,0)."&nbsp;&nbsp;</td> 
			 <td RIGHT_TOP >".number_format($regular_emp_rato,0)." %&nbsp;&nbsp;</td>
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
    
    