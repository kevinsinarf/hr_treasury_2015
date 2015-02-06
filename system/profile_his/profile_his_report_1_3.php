<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 3; 
$menu_num = "3".$number_subfix;
$label_type_name = "ประเภทตำแหน่ง";
$label_line_name = "ตำแหน่ง";

if($postype_id_is > 0){
	if($postype_id_is==5){
		$menu_name = 51;
		$menu_num = "49".$number_subfix;	
		$label_type_name = "กลุ่มงาน"; 
		$label_line_name = "ตำแหน่งในสายงาน";
	}
} 

$headline_title =  $report_menu[$menu_name]['name'];



 
   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
   
   $LINE_ID = (int)$_POST['LINE_ID'];
   $LEVEL_ID = (int)$_POST['LEVEL_ID'];
   $SEARCH_TYPE = (int)$_POST['SEARCH_TYPE'];
 
   //echo $SEARCH_TYPE;
   
   
   $sql_type = "select TYPE_ID, TYPE_NAME_TH ";
   $sql_type .= " from SETUP_POS_TYPE WHERE POSTYPE_ID = ".$postype_id_is." AND ACTIVE_STATUS = 1  "; 
 
    $sql_type .= " ORDER BY TYPE_SEQ ASC";
	$query_type = $db->query($sql_type); 

   
   
   $sql_line = "select DISTINCT a.LINE_ID,b.LINE_NAME_TH from POSITION_FRAME a 
left join setup_pos_line b on a.line_id = b.line_id
where a.ACTIVE_STATUS = 1 AND a.POSTYPE_ID = ".$postype_id_is."
  "; 
 
    //$sql_line .= " ORDER BY b.LINE_NAME_TH ASC";
	$query_line = $db->query($sql_line. " ORDER BY b.LINE_NAME_TH ASC"); 

 


   $sql_level = "select LEVEL_ID, LEVEL_NAME_TH ";
   $sql_level .= " from SETUP_POS_LEVEL  WHERE ACTIVE_STATUS = 1  AND  POSTYPE_ID = ".$postype_id_is." "; 
 
    $sql_level .= " ORDER BY LEVEL_NAME_TH ASC";
	$query_level = $db->query($sql_level); 
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
<script src="js/profile_his_report_1_3.js?<?php echo rand(); ?>"></script>
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
                <input type="hidden" id="SEARCH_TYPE" name="SEARCH_TYPE" value="">
                <input type="hidden" id="POSTYPE_ID_is" name="POSTYPE_ID_is" value="<?php echo $postype_id_is; ?>">  

		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $label_type_name; ?> :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['show_all']; ?>"    onChange="call_line(this.value);call_level(this.value);"    >   
                     <option value=""  ></option>
                      <?php while($rec1 = $db->db_fetch_array($query_type)){?>
                        <option value="<?php echo $rec1['TYPE_ID']?>"   <?php echo ($rec1['TYPE_ID'] == $TYPE_ID?"selected":"");?>  >
                        <?php echo text($rec1['TYPE_NAME_TH'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> </div>
			<div class="col-xs-12 col-sm-2"> <?php echo btn_do_center("$('#SEARCH_TYPE').val(3);searchData();","a"); ?>
  
			</div>
        </div>
        


		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $label_line_name; ?> :</div>
			<div class="col-xs-12 col-sm-3">
            <div id="LINE_AREA" NAME="LINE_AREA" >
                    <select id="LINE_ID" name="LINE_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['show_all']; ?>"    onChange="call_level(this.value);"      >   
                    <option value=""  ></option>
                      <?php while($rec1 = $db->db_fetch_array($query_line)){?>
                        <option value="<?php echo $rec1['LINE_ID']?>"   <?php echo ($rec1['LINE_ID'] == $LINE_ID?"selected":"");?>   >
                        <?php echo text($rec1['LINE_NAME_TH'])?></option>
                      <?php }?>
                    </select>	
             </div>       		
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> </div>
			<div class="col-xs-12 col-sm-2">
            <?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();","a"); ?>
 
			</div>
        </div>
        
        
        
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ระดับ :</div>
			<div class="col-xs-12 col-sm-3"> 
                        <div id="LEVEL_AREA" NAME="LEVEL_AREA" >
                    <select id="LEVEL_ID" name="LEVEL_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['show_all']; ?>"     >   
                    <option value=""  ></option>
                      <?php while($rec2 = $db->db_fetch_array($query_level)){?>
                        <option value="<?php echo $rec2['LEVEL_ID']?>"  <?php echo ($rec2['LEVEL_ID'] == $LEVEL_ID?"selected":"");?>  >
                        <?php echo text($rec2['LEVEL_NAME_TH'])?></option>
                      <?php }?>
                    </select>	
                  </div>		
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"></div>
			<div class="col-xs-12 col-sm-2">
            <?php echo btn_do_center("$('#SEARCH_TYPE').val(2);searchData();","a"); ?>
        
			</div>
        </div>
                
        
 

<?php
 
	
	$html_start   =  html_report_header($menu_name,$SEARCH_TYPE);
   $q_where = '';	
   if($SEARCH_TYPE==1){ 
   		if($LINE_ID>0){
		   $q_where = ' AND a.LINE_ID = '.$LINE_ID.' ';
		}
   
		 $sql_line = $sql_line.$q_where; 
	 
		   // echo $sql_line; exit();
		$query_line = $db->query($sql_line. " ORDER BY b.LINE_NAME_TH ASC");  
	    
	 
		while($rec_org = $db->db_fetch_array($query_line)){
			 $arr_org[$rec_org['LINE_ID']] = text($rec_org['LINE_NAME_TH']);
		}
	}// if
	
   if($SEARCH_TYPE==2){ 
   
   		if($LEVEL_ID>0){
		   
		   $q_where = ' AND a.LEVEL_ID = '.$LEVEL_ID.' ';
		}
		 $sql_line = "select a.LEVEL_ID, a.LEVEL_NAME_TH ";
		 $sql_line .= " from SETUP_POS_LEVEL a  WHERE  a.ACTIVE_STATUS = 1   AND a.POSTYPE_ID = ".$postype_id_is."    ".$q_where; 
	 
		$sql_line .= " ORDER BY a.LEVEL_NAME_TH ASC"; 
		$query_line = $db->query($sql_line); 
	
		
		while($rec_org = $db->db_fetch_array($query_line)){
			 $arr_org[$rec_org['LEVEL_ID']] = text($rec_org['LEVEL_NAME_TH']);
		}
	}// if
	
	
	 
   if($SEARCH_TYPE==3){ 
   
   		if($TYPE_ID>0){
		   
		   $q_where = ' AND a.TYPE_ID = '.$TYPE_ID.' ';
		}
		 $sql_line = "select a.TYPE_ID, a.TYPE_NAME_TH ";
		 $sql_line .= " from SETUP_POS_TYPE a  WHERE a.ACTIVE_STATUS = 1  AND a.POSTYPE_ID = ".$postype_id_is."   ".$q_where; 
	 
		$sql_line .= " ORDER BY a.TYPE_NAME_TH ASC"; // echo $sql_line; exit();
		$query_line = $db->query($sql_line); 
	
		
		while($rec_org = $db->db_fetch_array($query_line)){
			 $arr_org[$rec_org['TYPE_ID']] = text($rec_org['TYPE_NAME_TH']);
		}
	}// if
	
	 
	 
		
 
   if(isset($arr_org)){
   
   
		$officer_num = 0;
		$officer_sum =0;
		$regular_emp_num = 0;
		$regular_emp_sum = 0;
		$temp_emp_num = 0;	
		$temp_emp_sum = 0;	
   
    
		foreach ($arr_org as $key => $value) {
		
        // from config_web
		$sql_get_value;
        if($SEARCH_TYPE==1){ 
		   $q_where = ' AND a.LINE_ID = '.$key.' ';
		}
        if($SEARCH_TYPE==2){ 
		   $q_where = ' AND a.LEVEL_ID = '.$key.' ';
		}
		
        if($SEARCH_TYPE==3){ 
		   $q_where = ' AND a.TYPE_ID = '.$key.' ';
		}
		 
		$query_get_man = $db->query($sql_get_value." AND  a.PER_GENDER = 1 ".$q_where); 
 		$query_get_woman = $db->query($sql_get_value." AND  a.PER_GENDER = 2 ".$q_where); 
		
	    $man_num = $db->db_num_rows($query_get_man);  
	    $woman_num = $db->db_num_rows($query_get_woman);
		$men_num = $man_num + $woman_num;  		 
		
			//echo "$key$value<br/>";
			$officer_num = 0;
			$regular_emp_num = 0;
			$temp_emp_num = 0;
			$all_emp_num = $officer_num + $regular_emp_num + $temp_emp_num;
			
			$html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
				 <td CENTER_TOP  >".$start_no."</td> 
				 <td LEFT_TOP   >".$value."</td> 
				 <td CENTER_TOP >".number_format($man_num,0)."&nbsp;</td> 
				 <td CENTER_TOP >".number_format($woman_num,0)."&nbsp;</td> 
				 <td CENTER_TOP >".number_format($men_num,0)."&nbsp;</td> 	
		
			 </tr>";
			 $man_sum = $man_sum + $man_num;
			 $woman_sum = $woman_sum + $woman_num;
			 $men_sum = $men_sum + $men_num;			 			 
			$start_no++;
		} //foreach 
	}//
	 

	    // summery 
		$html  .= "<tr style='height:0.7cm;'> 
			 
			 <td CENTER_TOP   colspan='2' ><div align='center'><strong>".$arr_txt['total_result_txt']."</strong></div></td> 
			 <td CENTER_TOP ><strong>".number_format($man_sum,0)."&nbsp;</strong></td> 
			 <td CENTER_TOP ><strong>".number_format($woman_sum,0)."&nbsp;</strong></td> 
			 
			 <td CENTER_TOP ><strong>".number_format($men_sum,0)."&nbsp;</strong></td> 
			 		 
		 </tr>";
	
		$html_end   = "</table>";
		$sum_all = $men_sum;
 
include_once("inc_print_btn_and_output.php"); 
 ?>  
 
     
         </div> 
 </div> 
 
    
    
    
	</div>
 <?php include_once("report_footer.php"); ?>    
	
</div>
</body>
</html>
    
    