<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 29;
$menu_num = "28".$number_subfix;
if($postype_id_is > 0){
	if($postype_id_is==3){
		$menu_name = 46;
		$menu_num = "44".$number_subfix;
	}
	if($postype_id_is==5){
		$menu_name = 63;	
		$menu_num = "61".$number_subfix;
	}
} 

 if($menu_name==29){
     $wh_pt_id = " AND  d.PT_ID = 1  ";
 }
 if($menu_name==46){
     $wh_pt_id = " AND  d.PT_ID = 2  ";
 }
 if($menu_name==63){
     $wh_pt_id = " AND  d.PT_ID = 3  ";
 }

$headline_title =  $report_menu[$menu_name]['name']; 
 
   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];

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
                <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="1">
                <input type="hidden" id="POSTYPE_ID_is" name="POSTYPE_ID_is" value="<?php echo $postype_id_is; ?>">  
 
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ระบุุ<?php echo $arr_txt['budget_year_fill']; ?> :</div>
			<div class="col-xs-12 col-sm-3">
    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="<?php echo $arr_txt['budget_year_fill']; ?> "  style="width:200px"   >   
                     
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

	$html_start    =  html_report_header($menu_name);
	
if($SEARCH_TYPE==1){ 
	if($AGE_IS>0){
			$q_where = officer_year_between($AGE_IS,"a.DEH_GAZZETTE_DATE");
	}else{
			exit();
	}  
}	
	
$sql_get_value = " select  a.PER_ID,e.PREFIX_NAME_TH,d.PER_IDCARD,d.PER_FIRSTNAME_TH, d.PER_LASTNAME_TH,  a.DEH_ID, a.DEH_SEQ, a.DEH_GAZZETTE_DATE, a.DEH_RECEIVE_DATE, a.DEH_RETURN_DATE, b.DEF_NAME_TH, c.DEC_NAME_TH, a.ACTIVE_STATUS  
from   PER_DECORATEHIS  a
		 LEFT JOIN SETUP_DECORATION_FAMILY b ON a.DEF_ID=b.DEF_ID
		 LEFT JOIN SETUP_DECORATION c ON a.DEC_ID=c.DEC_ID
     LEFT JOIN PER_PROFILE d ON a.PER_ID = d.PER_ID
     LEFT JOIN SETUP_PREFIX e ON d.PREFIX_ID = e.PREFIX_ID where  a.DELETE_FLAG = '0' ".$wh_pt_id;
		 //echo $sql_get_value." ".$q_where; exit();
		$query_who = $db->query($sql_get_value.$q_where); 
		$sum_all = $db->db_num_rows($query_who); 
          while($rec1 = $db->db_fetch_array($query_who)){
 
			$html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
				 <td CENTER_TOP  >".$start_no."</td> 
				 <td CENTER_TOP >".get_idCard(text($rec1['PER_IDCARD']))." </td>  
				 <td LEFT_TOP >".text($rec1['PREFIX_NAME_TH'])." ".text($rec1['PER_FIRSTNAME_TH'])." ".text($rec1['PER_LASTNAME_TH'])." </td> 
				 <td LEFT_TOP >".text($rec1['DEF_NAME_TH'])." </td> 		 	 
				 <td LEFT_TOP >".text($rec1['DEC_NAME_TH'])." </td> 
				 <td LEFT_TOP >".conv_date($rec1['DEH_GAZZETTE_DATE'],'short')." </td> 		 	 
				 <td LEFT_TOP >".conv_date($rec1['DEH_RECEIVE_DATE'],'short')." </td> 
				 <td LEFT_TOP >".conv_date($rec1['DEH_RETURN_DATE'],'short')." </td> 			 	  
			 </tr>";
		 } //while
 
		$html_end   = "</table>";
echo '</form> ';
include_once("inc_print_btn_and_output.php"); 
?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    