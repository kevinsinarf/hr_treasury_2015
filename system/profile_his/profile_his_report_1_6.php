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
$menu_num = "7".$number_subfix;


if($postype_id_is > 0){
	if($postype_id_is==3){
		$menu_name = 41; 
		$menu_num = "39".$number_subfix;
	}
	if($postype_id_is==5){
		$menu_name = 54; 
		$menu_num = "52".$number_subfix;
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
   
 /* 
 $dateValue = '2012-01-05';
 $time=strtotime($dateValue);
 $month=date("F",$time);
 $year=date("Y",$time);  
 */
 //echo  $date = date('m/d/Y h:i:s a', time());
 
 
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
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['budget_year_fill']; ?> :</div>
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
	
 
	    $sql_get_value = " SELECT a.POS_ID,a.POS_NO,a.per_idcard, b.LINE_NAME_TH,a.PREFIX_ID,a.PER_FIRSTNAME_TH,a.PER_LASTNAME_TH,a.TYPE_ID,a.level_id,a.line_id, a.per_salary
,c.ORG_ID_1 as frame_org1,c.ORG_ID_2 as frame_org2,c.ORG_ID_3 as frame_org3,c.ORG_ID_4 as frame_org4,c.ORG_ID_5 as frame_org5
,a.ORG_ID_1 as act_org1,a.ORG_ID_2  as act_org2,a.ORG_ID_3  as act_org3,a.ORG_ID_4  as act_org4,a.ORG_ID_5  as act_org5 
 FROM 
PER_PROFILE a 
LEFT JOIN SETUP_POS_LINE b ON a.LINE_ID = b.LINE_ID
LEFT JOIN POSITION_FRAME c ON a.POS_ID = c.POS_ID  WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1   ";
	 

	          //echo $key.$q_where."<br/>".$sql_get_value." and a.PT_ID = 1      ".$q_where; exit();
	    $sql = $sql_get_value."  and a.POSTYPE_ID =  '".$postype_id_is."'    ".$q_where;
		$query_get_officer = $db->query($sql); //echo $sql_get_value." and a.PT_ID = 1      ".$q_where."<br/>"; 
  
		$sum_all = $db->db_num_rows($query_get_officer); 
             while($rec1 = $db->db_fetch_array($query_get_officer)){
	 
			 
			  $org3 = (int)$rec1['frame_org3'];
			  $sql = ' SELECT  ORG_NAME_TH from SETUP_ORG where ORG_ID = '.$org3;
			  $query_org = $db->query($sql);
			  $org_is = $db->db_fetch_array($query_org);
			  
			  $org3 = (int)$rec1['act_org3'];
			  $sql2 = ' SELECT  ORG_NAME_TH from SETUP_ORG where ORG_ID = '.$org3;
			  $query_org = $db->query($sql2);
			  $org_is2 = $db->db_fetch_array($query_org);
			  
	 
 
        $position_id = (int)$rec1['POS_NO'];
		$idcard = get_idCard($rec1['per_idcard']);
	    $line_name_th = text(wordwrap($rec1['LINE_NAME_TH']));
		$per_salary = $rec1['per_salary'];
		$per_name = Showname($rec1["PREFIX_ID"],$rec1["PER_FIRSTNAME_TH"],$rec1["PER_MIDNAME_TH"],$rec1["PER_LASTNAME_TH"]);
		//  <!--td CENTER_TOP   >&nbsp;&nbsp;".$value."</td--> 
		$html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			
			 <td CENTER_TOP >".$idcard."&nbsp;&nbsp;</td> 
			 <td CENTER_TOP >".$position_id."&nbsp;&nbsp;</td> 
			 <td LEFT_TOP >".$per_name."&nbsp;&nbsp;</td> 	 
			 <td LEFT_TOP >".$line_name_th."&nbsp;&nbsp;</td> 	 
			 <td RIGHT_TOP >".number_format($per_salary,2)."</td> 	
			 <td LEFT_TOP >".text($org_is['ORG_NAME_TH']) ." </td> 
			 <td LEFT_TOP >".text($org_is2['ORG_NAME_TH'])  ." </td>  
		 </tr>"; 
		$start_no++; 
		 }
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
    
    