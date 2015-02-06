<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

if($_GET['al']>0){
   $al = $_GET['al'];
}else{
   $al = $_POST['al'];
} 
$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = $al;
 
 
$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
   // POST Value;
   $AGE_IS = $_POST['AGE_IS'];   
   
   // array 
   $arr_org = array();
   $arr_org1 = array();
   $arr_org2 = array();
   
   if($menu_name == 19){ $menu_num = "17";  }
   if($menu_name == 20){ $menu_num = "18";  }
   if($menu_name == 60){ $menu_num = "58";  }
   if($menu_name == 62){ $menu_num = "60";  }
   $menu_num = $menu_num.$number_subfix;
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
                <input type="hidden" id="al" name="al" value="<?php  echo $al; ?>" >
        
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['budget_year_fill']; ?> :</div>
			<div class="col-xs-12 col-sm-3">  
						 <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="<?php echo $arr_txt['budget_year']; ?> "  style="width:300px"   >   
                     
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
					   $this_year10 = $this_year+11;
					   $this_yearless10 = $this_year-11; 
					   // this is case when it do for menu 19 page ( 10 year add )
					   if(($menu_name==19)||($menu_name==62)){ 
						   for($i=$this_year;$i<$this_year10;$i++){
									$j = $this_year_temp;$j++;
							  if($AGE_IS>0){
								 $arr_org1 = array();
								 $arr_org1[$AGE_IS] = $AGE_IS;
							  }else{
								 $arr_org1[$i] = $i; 	
							  }	
							  
						  ?>
							<option value="<?php echo $i;?>"  <?php echo ($search_year == $i?"selected":"");?>    >
							<?php echo $i;?></option>
						  <?php } // for   
						  } 
					   // this is case when it do for menu 20 page ( 10 year less )
					   if(($menu_name==20)||($menu_name==60)){ 
						   for($i=$this_year;$i>$this_yearless10;$i--){
									$j = $this_year_temp;$j--;
							  if($AGE_IS>0){
								 $arr_org1 = array();
								 $arr_org1[$AGE_IS] = $AGE_IS;
							  }else{
								 $arr_org1[$i] = $i; 	
							  }	
							  
						  ?>
							<option value="<?php echo $i;?>"  <?php echo ($search_year == $i?"selected":"");?>    >
							<?php echo $i;?></option>
						  <?php } // for   
						  }?>
                          
                         
                    </select>	
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			 </div>
			<div class="col-xs-12 col-sm-2">
 	
			</div>
        </div>

<?php include_once("inc_select4_position.php"); ?>
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> สังกัดกรอบ :  </div>
			<div class="col-xs-12 col-sm-3"> 
	<?php 
 
$arr_org3 = GetSqlSelectArray("ORG_ID","ORG_NAME_TH","SETUP_ORG","ACTIVE_STATUS = 1 and DELETE_FLAG = '0' " , "ORG_SEQ" );
	echo GetHtmlSelect('GOV_ORG_ID_3','GOV_ORG_ID_3', $arr_org3 , 'ทั้งหมด',$_POST['GOV_ORG_ID_3'],"onChange=\"get_gov_org4(this.value);\"",'','','300','1'); ?>		
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> สังกัดปฎิบัติ : 			 </div>
			<div class="col-xs-12 col-sm-2">
<?php echo GetHtmlSelect('GOV_ORG_ID_32','GOV_ORG_ID_32', $arr_org3 , 'ทั้งหมด',$_POST['GOV_ORG_ID_32'],"onChange=\"get_gov_org4(this.value);\"",'','','200','1'); ?>
			</div>
        </div>
        
        

		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> </div>
			<div class="col-xs-12 col-sm-3"> 
						
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			 </div>
			<div class="col-xs-12 col-sm-2">
 	
			</div>
        </div>
 
 
<?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();");  
	
	$html_start   =  html_report_header($menu_name);
 
    $q_where = '';	
   if($SEARCH_TYPE==1){   
       $arr_org = $arr_org1;
	   
	   if($AGE_IS>0){
 
			 //$q_where = ' and year(a.PER_DATE_RETIRE) = '.$AGE_IS.'   ';
			 $q_where = " and a.PER_DATE_RETIRE between convert(datetime,'10/01/".($AGE_IS-1)."') and convert(datetime,'09/30/".($AGE_IS)."') ";
			 
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
					$q_where = " and ((a.PER_DATE_RETIRE between convert(datetime,'10/01/".($AGE_IS-1)."') and convert(datetime,'09/30/".$AGE_IS."'))or(a.PER_DATE_RETIRE between convert(datetime,'10/01/".($AGE_IS2-1)."') and convert(datetime,'09/30/".($AGE_IS2)."') )) ";
           			//$q_where = ' and ((year(a.PER_DATE_RETIRE) = '.$AGE_IS.')or(year(a.PER_DATE_RETIRE) = '.$AGE_IS2.'))   ';
			}else{
					$AGE_IS2 = $key-543;
           			//$q_where = ' and ((year(a.PER_DATE_RETIRE) = '.$key.')or(year(a.PER_DATE_RETIRE) = '.$AGE_IS2.'))   ';
					$q_where = " and ((a.PER_DATE_RETIRE between convert(datetime,'10/01/".($key)."') and convert(datetime,'09/30/".($key)."'))or(a.PER_DATE_RETIRE between convert(datetime,'10/01/".($AGE_IS2-1)."') and convert(datetime,'09/30/".($AGE_IS2)."') )) ";
			}
		}
	
 
	    $sql_get_value = "   SELECT   a.PER_IDCARD, a.PER_FIRSTNAME_TH,a.PER_LASTNAME_TH,a.POS_NO , 
b.LINE_NAME_TH ,c.LEVEL_NAME_TH ,d.MANAGE_NAME_TH,a.PER_SALARY,e.ORG_NAME_TH ,g.ORG_NAME_TH as frame_org ,a.PER_DATE_RETIRE
 FROM PER_PROFILE a   
LEFT JOIN SETUP_POS_LINE b ON a.LINE_ID = b.LINE_ID
LEFT JOIN SETUP_POS_LEVEL c ON a.LEVEL_ID = c.LEVEL_ID 
LEFT JOIN SETUP_POS_MANAGE d ON a.MANAGE_ID = d.MANAGE_ID
LEFT JOIN SETUP_ORG e ON a.ORG_ID_3 = e.ORG_ID
LEFT JOIN POSITION_FRAME f ON a.POS_ID = f.POS_ID 
LEFT JOIN SETUP_ORG g ON f.ORG_ID_3 = g.ORG_ID 
WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 and  a.POSTYPE_ID =  '".$postype_id_is."'  ";

if($TYPE_ID  > 0){
	$sql_get_value .= " AND ((a.TYPE_ID = '".$TYPE_ID."' )OR(f.TYPE_ID = '".$TYPE_ID."' ))  ";	 
}
if($LEVEL_ID  > 0){
	$sql_get_value .= " AND ((a.LEVEL_ID = '".$LEVEL_ID."' )OR(f.LEVEL_ID = '".$LEVEL_ID."' ))  ";	 
}
if($LG_ID  > 0){
	$sql_get_value .= " AND ((a.LG_ID = '".$LG_ID."' )OR(f.LG_ID = '".$LG_ID."' ))  ";	 
}
if($LINE_ID  > 0){
	$sql_get_value .= " AND ((a.LINE_ID = '".$LINE_ID."' )OR(f.LINE_ID = '".$LINE_ID."' ))  ";	 
}

if($_POST['GOV_ORG_ID_3'] > 0){
	$sql_get_value .= " AND  (a.ORG_ID_3 = '".$_POST['GOV_ORG_ID_3']."' )  ";	 
} // GOV_ORG_ID_3

if($_POST['GOV_ORG_ID_32'] > 0){
	$sql_get_value .= " AND  (f.ORG_ID_3 = '".$_POST['GOV_ORG_ID_32']."' )  ";	 
} // if GOV_ORG_ID_32
 
		$query_who = $db->query($sql_get_value.$q_where); 
             while($rec1 = $db->db_fetch_array($query_who)){
			 
			 	 $name = Showname($rec1["PREFIX_ID"],$rec1["PER_FIRSTNAME_TH"],$rec1["PER_MIDNAME_TH"],$rec1["PER_LASTNAME_TH"]);
				$html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
					 <td CENTER_TOP  >".$start_no."</td> 
					 <td CENTER_TOP   >".get_idCard(text($rec1['PER_IDCARD']))."</td> 
					 <td CENTER_TOP >".$rec1['POS_NO']."&nbsp;&nbsp;</td> 
					 <td LEFT_TOP >".$name."</td> 
					 <td LEFT_TOP >".text($rec1['LINE_NAME_TH'])."</td>  
					 <td LEFT_TOP >".text($rec1['LEVEL_NAME_TH'])."</td> 
					 <td LEFT_TOP >".text($rec1['MANAGE_NAME_TH'])."</td> 
				      <td RIGHT_TOP >".number_format($rec1['PER_SALARY'],2)."&nbsp;</td> 
					 <td LEFT_TOP >".text($rec1['frame_org'])."</td> 
					 <td LEFT_TOP >".text($rec1['ORG_NAME_TH'])."</td>  
					 <td CENTER_TOP > ".conv_date($rec1['PER_DATE_RETIRE'],'short')."&nbsp;&nbsp;</td>  
				 </tr>";
				$start_no++;
			}  
	}

		$html_end   = "</table>   ";
		include_once("inc_print_btn_and_output.php"); ?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    