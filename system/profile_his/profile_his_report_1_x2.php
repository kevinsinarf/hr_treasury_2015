<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 2; 
$menu_num = "2".$number_subfix;
if($postype_id_is > 0){
	if($postype_id_is==3){
		$menu_name = 37; 
		$menu_num = "35".$number_subfix;
	}
	if($postype_id_is==5){
		$menu_name = 50; 
		$menu_num = "48".$number_subfix;
	}
}

$headline_title =  $report_menu[$menu_name]['name'];


   $html  = "";
   $start_no = 1;
   
   $s_POST_ID = (int)$_POST['s_POST_ID'];
   if($s_POST_ID < 1){ $s_POST_ID = 1; }
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
   $arr_org = array();
   $sql_org = "select ORG_ID, ORG_NAME_TH ";
   $sql_org .= " from SETUP_ORG  "; 
   $sql_org .= " WHERE ".ORG_basic_where();
   if(($s_OT_ID==5)||($s_OT_ID==6)){
	   $sql_org .= " and OT_ID = ".$s_OT_ID." ";
   }
    if($s_ORG_NAME_TH!=""){
	   //$sql_org .= " and ORG_NAME_TH LIKE '%".ctext($s_ORG_NAME_TH)."%' ";
	   $sql_org .= " and ORG_ID = {$s_ORG_NAME_TH} ";
    }
    $sql_org2 .= " ORDER BY ORG_SEQ ASC"; 
	$query_org = $db->query($sql_org." ORDER BY ORG_SEQ ASC"); 
	//echo "on debuging : ".$sql_org;
	$num_rows = $db->db_num_rows($query_org);
	
   $sql_org2 = "select ORG_ID, ORG_NAME_TH ";
   $sql_org2 .= " from SETUP_ORG  "; 
   $sql_org2 .= " WHERE   ".ORG_basic_where();
    
 
   $sql_org2 .= " ORDER BY ORG_SEQ ASC"; 
   $query_org2 = $db->query($sql_org2); 
	
//echo $sql_org;
?><!DOCTYPE html>
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
<script src="js/profile_his_report_1_2.js?<?php echo rand(); ?>"></script>
<script>
 
$(document).ready(function() {
    $('#footer').css({
        position: 'relative',
        bottom: '0px',
         
    });
});
</script>
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
                <input type="hidden" id="POSTYPE_ID_is" name="POSTYPE_ID_is" value="<?php echo $postype_id_is; ?>"> 
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['org_label_name']; ?>:</div>
			<div class="col-xs-12 col-sm-3">
            
            
            
            <select id="s_ORG_NAME_TH" name="s_ORG_NAME_TH" class="selectbox form-control" placeholder="<?php echo $arr_txt['show_all']; ?>"     >   
                    <option value=""  ></option>
                      <?php while($rec1 = $db->db_fetch_array($query_org2)){?>
                        <option value="<?php echo $rec1['ORG_ID']?>"  <?php echo ($rec1['ORG_ID'] == $s_ORG_NAME_TH?"selected":"");?>    >
                        <?php echo text($rec1['ORG_NAME_TH'])?></option>
                      <?php }?>
            </select>	
            
            
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ส่วนงาน :</div>
			<div class="col-xs-12 col-sm-2">
			  <select id="s_OT_ID" name="s_OT_ID"  class="selectbox form-control" placeholder="<?php echo $arr_txt['show_all']; ?>">
                    <option value=""  ></option>
                    <option value="5" <?php echo (5 == $s_OT_ID?"selected":"");?>   >ส่วนกลาง</option>
                    <option value="6"  <?php echo (6 == $s_OT_ID?"selected":"");?> >ส่วนภูมิภาค</option>	
                         
			  </select>  
              
 
			</div>
        </div>
              
                                
               
  
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">สังกัดกรอบ/สังกัดปฎิบัติ :</div>
			<div class="col-xs-12 col-sm-3">
            
              <select id="s_POST_ID" name="s_POST_ID" class="selectbox form-control"  placeholder="<?php echo $arr_txt['show_all']; ?>" >
            
                    <option value="1" <?php echo (1 == $s_POST_ID?"selected":"");?>  >สังกัดกรอบ</option>
                    <option value="2"  <?php echo (2 == $s_POST_ID?"selected":"");?> >สังกัดปฏิบัติ</option>	  
			  </select>
            
            
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> </div>
			<div class="col-xs-12 col-sm-2">
			  
			</div>
        </div>
 <?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();");    
 
	while($rec_org = $db->db_fetch_array($query_org)){
	     $arr_org[$rec_org['ORG_ID']] = text($rec_org['ORG_NAME_TH']);
	}
	
	//echo $sql_org;
     ?>

     
     <?php  
 
	// html_report_header($menu_name);
	$html_start   =  html_report_header($menu_name);
 
		$officer_num = 0;
		$officer_sum =0;
		$regular_emp_num = 0;
		$regular_emp_sum = 0;
		$temp_emp_num = 0;	
		$temp_emp_sum = 0;	
		
	foreach ($arr_org as $key => $value) {
	

	
		//echo "$key$value<br/>";

		$sql_get_value = '  SELECT a.PER_ID FROM PER_PROFILE a ';
		$sql_get_value .= ' LEFT JOIN POSITION_FRAME b ON a.POS_ID = b.POS_ID ';
		$sql_get_value .= ' WHERE a.ACTIVE_STATUS = 1 ';
		$sql_get_value .= ' AND a.PER_STATUS =2   AND a.PER_STATUS_CIVIL = 2  AND a.DELETE_FLAG=0 '; 
		$sql_get_value .= ' AND a.POSTYPE_ID = '.$postype_id_is.' '; 
		if($s_ORG_NAME_TH>0){
		   $search_org_id = $s_ORG_NAME_TH; 
		   }else{
		    $search_org_id = (int)$key;
		   }
 
			 
		     if($s_POST_ID==1){
			    $table_get = 'b'; 
			 }if($s_POST_ID==2){
			    $table_get = 'a';
			 }  
   			   
				 if($key==1){
				   $sql_get_value .= ' AND ( ('.$table_get.'.ORG_ID_1 = '.$search_org_id.') OR ('.$table_get.'.ORG_ID_2 = '.$search_org_id.')   ) ';
				 }else{
				   $sql_get_value .= ' AND ( ('.$table_get.'.ORG_ID_3 = '.$search_org_id.') OR ('.$table_get.'.ORG_ID_4 = '.$search_org_id.') OR ('.$table_get.'.ORG_ID_5 = '.$search_org_id.')  ) ';
				 } 
			   
		      
		 //echo "on dev ".$sql_get_value; exit();
		$query_get_officer = $db->query($sql_get_value."   "); 
 
		
	    $officer_num = $db->db_num_rows($query_get_officer);  
			$officer_sum = $officer_sum + $officer_num;
 
		$html  .= "<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td LEFT_TOP   >&nbsp;&nbsp;".$value."</td> 
			 <td CENTER_TOP >".number_format($officer_num,0)."&nbsp;&nbsp;</td> 
  
		 </tr>";
		 
		$start_no++;
	}
	
	reset($arr_org);
	    // summery 
	$sum_all = $officer_sum+$regular_emp_sum+$temp_emp_sum;
 
		$html  .= "<tr style='height:0.7cm;'> 
			 
			 <td CENTER_TOP   colspan='2' ><div align='center'><strong>".$arr_txt['total_result_txt']."</strong></div></td> 
			 <td CENTER_TOP ><div  ><strong>".number_format($officer_sum,0)."&nbsp;&nbsp;</strong></div></td> 
 
		 </tr>";
	
		$html_end   = "</table>";
		$sum_all = $num_rows;

 
include_once("inc_print_btn_and_output.php"); 
?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    