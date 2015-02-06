<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

 // echo "<pre>"; print_r($_POST); echo "<hr/>";   //echo "<pre>"; print_r($_SESSION); exit();
 

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 35;
$menu_num = "33".$number_subfix;
if($postype_id_is > 0){
	if($postype_id_is==3){
		$menu_name = 47;
		$menu_num = "45".$number_subfix;
	}
	if($postype_id_is==5){
		$menu_name = 65;	
		$menu_num = "63".$number_subfix;
	}
} 

 if($menu_name==35){
     $wh_pt_id = " AND  C.PT_ID = 1  ";
 }
 if($menu_name==47){
     $wh_pt_id = " AND  C.PT_ID = 2  ";
 }
  if($menu_name==65){
     $wh_pt_id = " AND  C.PT_ID = 3  ";
 }

$headline_title =  $report_menu[$menu_name]['name'];  // ชื่อรายงาน
 
 
 
 

   $html  = "";
   $start_no = 1;
 
	
	 
    $arr_org = array();
 
    $arr_leave[1] = array('name'=>"การลาป่วย",'id'=>"LEAVEHIS_SICK_");
    $arr_leave[2] = array('name'=>"การลาคลอด",'id'=>"LEAVEHIS_BIRTH_");
    $arr_leave[3] = array('name'=>"การลาไปช่วยเหลือภรรยาที่คลอดบุตร",'id'=>"LEAVEHIS_HELP_");
    $arr_leave[4] = array('name'=>"การลากิจส่วนตัว",'id'=>"LEAVEHIS_PRIVATE_");
    $arr_leave[5] = array('name'=>"การลาพักผ่อน",'id'=>"LEAVEHIS_RELAX_");
    $arr_leave[6] = array('name'=>"การลาอุปสมบทหรือการลาไปประกอบพิธีฮัจญ์",'id'=>"LEAVEHIS_REGION_");
    $arr_leave[7] = array('name'=>"การลาเข้ารับการตรวจเลือกหรือเข้ารับการเตรียมพล",'id'=>"LEAVEHIS_SOLDIER_");
    $arr_leave[8] = array('name'=>"การลาไปศึกษา ฝึกอบรม ปฎิบัติการวิจัย หรือดูงาน",'id'=>"LEAVEHIS_STUDY_");
    $arr_leave[9] = array('name'=>"การลาไปปฎิบัติงานในองค์การระหว่างประเทศ",'id'=>"LEAVEHIS_WORK_");
    $arr_leave[10] = array('name'=>"การลาติดตามคู่สมรส",'id'=>"LEAVEHIS_MARRIED_");
    $arr_leave[11] = array('name'=>"การลาไปฟื้นฟูสมรรถภาพด้านอาชีพ",'id'=>"LEAVEHIS_COMPLETENCY_");					
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
                    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="<?php echo $arr_txt['budget_year_fill']; ?> "     >   
                       
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
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			
            <div class="col-xs-12 col-sm-2">
   
            <?php echo btn_do_center("$('$('#SEARCH_TYPE').val(1);searchData();","a"); ?>
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
			 //$q_where = " and a.PER_DATE_RETIRE between convert(datetime,'10/01/".($AGE_IS-1)."') and convert(datetime,'09/30/".$AGE_IS."') ";
		}   
   }
	// echo "<pre>"; print_r($arr_org);
	foreach ($arr_org as $key => $value) {
		//echo "$key$value<br/>";
		$officer_num = 0;
		$regular_emp_num = 0;
		$temp_emp_num = 0;
		$all_emp_num = $officer_num + $regular_emp_num + $temp_emp_num;
		
	foreach ($arr_leave as $key1 => $value1) {
 
	    $sql_get_value = " select ".$value1['id']."DAY , LEAVEHIS_SICK_DAY,sum from PER_LEAVEHIS CROSS JOIN (SELECT SUM(a.".$value1['id']."DAY) sum FROM PER_LEAVEHIS  a
 LEFT JOIN PER_PROFILE b on a.PER_ID = b.PER_ID  where a.LEAVEHIS_YEAR = ".$value." and b.POSTYPE_ID = ".$postype_id_is.") b  
		LEFT JOIN PER_PROFILE C ON PER_LEAVEHIS.PER_ID = C.PER_ID 
		where LEAVEHIS_YEAR = ".$value." ".$wh_pt_id."  ORDER BY sum DESC  "; // echo $sql_get_value."<br/>"; 
	   
		$query_get_sum = $db->query($sql_get_value); 
		$day_value = $db->db_fetch_array($query_get_sum);
		
	    $sql_get_value = " select ".$value1['id']."TIME , LEAVEHIS_SICK_DAY,sum from PER_LEAVEHIS CROSS JOIN (SELECT SUM(a.".$value1['id']."TIME) sum FROM PER_LEAVEHIS a  LEFT JOIN PER_PROFILE b on a.PER_ID = b.PER_ID   where a.LEAVEHIS_YEAR = ".$value."  and b.POSTYPE_ID = ".$postype_id_is.") b  
		LEFT JOIN PER_PROFILE C ON PER_LEAVEHIS.PER_ID = C.PER_ID 
		where LEAVEHIS_YEAR = ".$value." ".$wh_pt_id."  ORDER BY sum DESC  "; //echo $sql_get_value."<br/>"; 
		$query_get_sum = $db->query($sql_get_value); 
		$time_value = $db->db_fetch_array($query_get_sum);
		
		
		$html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td CENTER_TOP  >".$value." </td> 
			 <td LEFT_TOP   >".$value1['name']."</td> 
			 <td CENTER_TOP >".number_format($day_value['sum'],0)."&nbsp;&nbsp;</td> 
			 <td CENTER_TOP >".number_format($time_value['sum'],0)."&nbsp;&nbsp;</td> 
		 </tr>";
		$start_no++;
	 }// foreach
	}
	
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
    
    