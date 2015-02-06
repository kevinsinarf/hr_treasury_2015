<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$menu_name = 9; 
$menu_num = "8".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name'];


   $html  = "";
   $start_no = 1;
   $s_POST_ID = (int)$_POST['s_POST_ID'];
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
   $arr_org = array();
   $arr_org1 = array();
   $arr_org2 = array();   
   $arr_org3 = array();     
 
   $ED_ID = $_POST['ED_ID'];
   $EM_ID = $_POST['EM_ID'];
   $COUNTRY_ID = $_POST['COUNTRY_ID'];
     
    
   
   //$sql_line = "select ED_ID, ED_NAME_TH  from SETUP_EDU_LEVEL   ORDER BY ED_SEQ ASC";
    $sql_line = " select DISTINCT  a.ED_ID, b.ED_NAME_TH   from PER_EDUCATEHIS a
LEFT JOIN SETUP_EDU_DEGREE b
on a.ED_ID = b.ED_ID 
left join PER_PROFILE c on a.PER_ID = c.PER_ID
WHERE a.ACTIVE_STATUS = 1  AND a.ED_ID > 0  ";
   
	$query_line = $db->query($sql_line." ORDER BY  b.ED_NAME_TH ASC "); 
    //echo $sql_line; exit();

   $sql_level = "select DISTINCT  a.EM_ID, b.EM_NAME_TH+''+b.EM_NAME_EN as UNAME from PER_EDUCATEHIS a LEFT JOIN SETUP_EDU_MAJOR b
on a.EM_ID = b.EM_ID 
left join PER_PROFILE c on a.PER_ID = c.PER_ID
WHERE a.ACTIVE_STATUS = 1 AND a.EM_ID > 0  ";
 
	$query_level = $db->query($sql_level); 
	
 
	 
   
   
   
	
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


 		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">วุฒิการศึกษา :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="ED_ID" name="ED_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['show_all']; ?> "     >   
                     <option value=""   > </option>
                      <?php while($rec1 = $db->db_fetch_array($query_line)){
					        $arr_org1[$rec1['ED_ID']] = text($rec1['ED_NAME_TH']);
					  ?>
                        <option value="<?php echo $rec1['ED_ID']?>"  <?php echo ($rec1['ED_ID'] == $ED_ID?"selected":"");?>   >
                        <?php echo text($rec1['ED_NAME_TH'])?></option>
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
        
 
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">สาขาวิชาเอก :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="EM_ID" name="EM_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['show_all']; ?> "     >   
                     <option value=""  > </option>
                      <?php while($rec2 = $db->db_fetch_array($query_level)){
					            $arr_org2[$rec2['EM_ID']] = text($rec2['UNAME']);
					  ?>
                        <option value="<?php echo $rec2['EM_ID']?>" <?php echo ($rec2['EM_ID'] == $EM_ID?"selected":"");?>   >
                        <?php echo text($rec2['UNAME'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">  			<div class="col-xs-12 col-sm-2">
                     <?php echo btn_do_center("$('#SEARCH_TYPE').val(2);searchData();","a"); ?>
             </div></div>
			<div class="col-xs-12 col-sm-2">
 
			</div>
        </div>
       
 <?php
 
	
	$html_start   =  html_report_header($menu_name,$SEARCH_TYPE);
	
   $q_where = '';	
   if($SEARCH_TYPE==1){  
        $sql_get_value = $sql_line;  
   		if($ED_ID>0){  
		   $q_where = ' AND a.ED_ID = '.$ED_ID.' ';
		   
			 $sql_get_value = $sql_get_value.$q_where; 
		 
			$sql_get_value = $db->query($sql_get_value); 
		 
			
			while($rec_org = $db->db_fetch_array($sql_get_value)){
				 $arr_org[$rec_org['ED_ID']] = text($rec_org['ED_NAME_TH']);
			} //while
		}else{
		    $arr_org = $arr_org1;
			$sql_get_value = $sql_line;
		}
 
	}// if
	
   if($SEARCH_TYPE==2){ 
         $sql_get_value = $sql_level;
   		if($EM_ID>0){
		   
		   $q_where = ' AND a.EM_ID = '.$EM_ID.' ';
		 $sql_get_value = $sql_get_value.$q_where;   //echo $sql_get_value; exit();
	 
		//$sql_line .= " ORDER BY UNAME ASC"; //echo $sql_line; exit();
		$query_line = $db->query($sql_get_value); 
	
		
		while($rec_org = $db->db_fetch_array($query_line)){
			 $arr_org[$rec_org['EM_ID']] = text($rec_org['UNAME']);
		}
		}else{
		    $arr_org = $arr_org2;
			$sql_get_value = $sql_level;
		}

	}// if
	
 
	
 
		$officer_num = 0;
		$officer_sum =0;
 
		
		$officer_num_m = 0;
		$officer_sum_m =0;
 
		
		$officer_num_w = 0;
		$officer_sum_w =0;
 
		
	foreach ($arr_org as $key => $value) {
	
        if($SEARCH_TYPE==1){
		   $sql_get_value = $sql_line;  
		   $q_where = ' AND a.ED_ID = '.$key.' ';
		} 
		
        if($SEARCH_TYPE==2){
		   $sql_get_value = $sql_level; 
		   $q_where = ' AND a.EM_ID = '.$key.' ';
		} 
		
        if($SEARCH_TYPE==3){
		   $sql_get_value = $sql_country;
		   $q_where = ' AND a.COUNTRY_ID = '.$key.' ';
		} 
	
		//echo "$key$value<br/>";

		if($s_ORG_NAME_TH>0){
		   $search_org_id = $s_ORG_NAME_TH; 
		   }else{
		    $search_org_id = (int)$key;
		   }
 
		       //echo $sql_get_value." and c.PT_ID = 1  and c.PER_GENDER = 1   ".$q_where; exit();
		$query_get_officer_m = $db->query($sql_get_value." and c.PT_ID = 1  and c.PER_GENDER = 1   ".$q_where); 
 
		$query_get_officer_w = $db->query($sql_get_value." and c.PT_ID = 1  and c.PER_GENDER = 2   ".$q_where); 
 
		
	    $officer_num_m = $db->db_num_rows($query_get_officer_m);  
			$officer_sum_m = $officer_sum_m + $officer_num_m;
 
		 
		
		
	    $officer_num_w = $db->db_num_rows($query_get_officer_w);  
			$officer_sum_w = $officer_sum_w + $officer_num_w;
 
		$html .= table_all3group_w_gender_row1($start_no,$value,$officer_num_m,$officer_num_w );
		$start_no++;
	}
	
	reset($arr_org);
	    // summery 
	    $html .= table_all3group_w_gender_sum1($officer_sum_m,$officer_sum_w );	
	
		$html_end   = "</table>";
include_once("inc_print_btn_and_output.php"); ?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    