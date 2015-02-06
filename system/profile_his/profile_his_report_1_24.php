<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
$menu_name = 23;
$menu_num = "22".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name']; 
$s_trainning_name = $_POST['s_trainning_name'];
$s_gen_name = $_POST['s_gen_name'];
   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
   $LINE_ID = (int)$_POST['LINE_ID'];
   $SEARCH_F = $_POST['SEARCH_F'];
 
   
   
   
   $sql_org = "select ORG_ID, ORG_NAME_TH ";
   $sql_org .= " from SETUP_ORG  "; 
   $sql_org .= " WHERE   ".ORG_basic_where();
 
 
 
   $sql_org .= " ORDER BY ORG_SEQ ASC";
	$query_org = $db->query($sql_org); 
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
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">สำนัก/กอง :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="LINE_ID" name="LINE_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['show_all']; ?>"     >   
                      <option value=""></option>
                      <?php while($rec1 = $db->db_fetch_array($query_org)){
					        $arr_org[$rec1['ORG_ID']] = text($rec1['ORG_NAME_TH']);
					  ?>
                        <option value="<?php echo $rec1['ORG_ID']?>"  <?php echo ($rec1['ORG_ID'] ==$LINE_ID?"selected":"");?>    >
                        <?php echo text($rec1['ORG_NAME_TH'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> ชื่อหลักสูตร :</div>
			<div class="col-xs-12 col-sm-2">
                 <input type="text" name="s_trainning_name" name="s_trainning_name" value="<?php echo $s_trainning_name; ?>"   class="  form-control" style="width:300px;">
			</div>
        </div>
        
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">  รุ่น : </div>
			<div class="col-xs-12 col-sm-3"> 
						 <input type="text" name="s_gen_name" name="s_gen_name" value="<?php echo $s_gen_name; ?>"   class="  form-control" style="width:300px;">
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			 </div>
			<div class="col-xs-12 col-sm-2">
 	
			</div>
        </div>
 
     <?php echo btn_do_center("$('#SEARCH_TYPE').val(1);$('#SEARCH_F').val($('#LINE_ID').find(':selected').text());searchData();");  
 
  
//$(this).find(":selected").text()
// alert($('#LINE_ID').find(':selected').text());
 
    $q_where = '';	 
   if($SEARCH_TYPE==1){    
       //$arr_org = $arr_org1;

  
   }else{
       exit();
   }
    $some_num = 0;
	$html_start   =  " <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;'> ".html_report_header($menu_name);
        $html = "";
		
	if($LINE_ID>0){
	      if($SEARCH_F!=""){
			  $arr_org = array();
			  $arr_org[$LINE_ID] = $SEARCH_F;
		  }
	}
		
	foreach ($arr_org as $key => $value) {
		// echo "$key$value<br/>";
        
	    $htmlr = "
		<tr style='height:0.7cm;' ><td LEFT_TOP  colspan=11 >
		&nbsp;&nbsp;".$value."</td> </tr> 
		
 		";
		 
		
         $sql_get_value = "  select a.TRAINHIS_PROJECT_NAME,a.TRAINHIS_COURSE_NAME,a.TRAINHIS_GEN_NAME,a.TRAINHIS_EDATE ,a.TRAINHIS_SDATE ,b.PER_IDCARD,
		 b.PER_FIRSTNAME_TH, b.PER_LASTNAME_TH ,  b.ORG_ID_3   , b.PER_GENDER,b.PREFIX_ID,b.PER_MIDNAME_TH ,b.POS_NO,c.LINE_NAME_TH,d.LEVEL_NAME_TH,e.ORG_NAME_TH,a.TRAINHIS_ORG_NAME ,a.TRAINHIS_GEN_NAME
 from PER_TRAINHIS a
left join PER_PROFILE b on a.PER_ID = b.PER_ID      
LEFT JOIN SETUP_POS_LINE c on b.LINE_ID = c.LINE_ID 
LEFT JOIN SETUP_POS_LEVEL d on b.LEVEL_ID = d.LEVEL_ID 
LEFT JOIN SETUP_ORG e on b.ORG_ID_3  = e.ORG_ID 
WHERE b.PER_STATUS =2 AND b.ACTIVE_STATUS = 1 AND b.PER_STATUS_CIVIL = 2 
AND  b.PT_ID = 1 ";

if($LINE_ID>0){
  $sql_get_value .= "  AND a.ORG_ID_3 = ".$LINE_ID."   ";
}else{
   $sql_get_value .= "  AND a.ORG_ID_3 = ".$key."   ";
}

if($s_trainning_name!=""){
   $sql_get_value .= "  AND a.TRAINHIS_COURSE_NAME  LIKE  '%".ctext($s_trainning_name)."%'  ";
}
if($s_gen_name!=""){
   $sql_get_value .= "  AND a.TRAINHIS_GEN_NAME  LIKE  '%".ctext($s_gen_name)."%'  ";
}
$sql_get_value .= " ORDER BY a.TRAINHIS_SDATE DESC ";
    //echo $sql_get_value ; exit();

		$query_who = $db->query($sql_get_value); 
		$sum_all = $db->db_num_rows($query_who); 
		  if($sum_all > 0){
		         
				 while($rec1 = $db->db_fetch_array($query_who)){
				  $train = text($rec1["TRAINHIS_PROJECT_NAME"]).' '.text($rec1["TRAINHIS_COURSE_NAME"]);
				  $train_org = text($rec1["TRAINHIS_ORG_NAME"]);
				  $TRAINHIS_GEN_NAME = text($rec1["TRAINHIS_GEN_NAME"]);
				  if(!empty($rec1["TRAINHIS_GEN_NAME"])){ 
				    //$train .= " ชื่อรุ่น ".text($rec1["TRAINHIS_GEN_NAME"]); 
				  }
				  $name = Showname($rec1["PREFIX_ID"],$rec1["PER_FIRSTNAME_TH"],$rec1["PER_MIDNAME_TH"],$rec1["PER_LASTNAME_TH"]);
				  $start_date = conv_date($rec1['TRAINHIS_SDATE'],'short');
				  $end_date = conv_date($rec1['TRAINHIS_EDATE'],'short');
				  $POS_NO = $rec1['POS_NO'];
				  $org3 = (int)$rec1['ORG_ID_3'];
				  //$sql = ' SELECT  ORG_NAME_TH from SETUP_ORG where ORG_ID = '.$org3;
				  //$query_org = $db->query($sql);
				  //$org_is = $db->db_fetch_array($query_org);
				  //$org_name = text($org_is['ORG_NAME_TH']);  // สำนัก/กอง 
				  $LINE_NAME_TH = text($rec1['LINE_NAME_TH']);
				  $LEVEL_NAME_TH = text($rec1['LEVEL_NAME_TH']);
				  $ORG_NAME_TH = text($rec1['ORG_NAME_TH']);
					$htmlr  .= "<tr  style='height:0.7cm;'> 
						 <td CENTER_TOP  >&nbsp;&nbsp;".get_idCard($rec1['PER_IDCARD'])."</td> 
						 <td LEFT_TOP >&nbsp;&nbsp;  ".$name."</td>  
						 <td LEFT_TOP >&nbsp;&nbsp;  ".$POS_NO."</td>  
						 <td LEFT_TOP >&nbsp;&nbsp;".$LINE_NAME_TH." </td> 
						 <td LEFT_TOP > ".$LEVEL_NAME_TH." </td>  
						 <td LEFT_TOP >".$ORG_NAME_TH." </td> ";  
					$htmlr .= "<td LEFT_TOP >";
					/*
					$sql1 = "SELECT TRAINHIS_PROJECT_NAME,TRAINHIS_COURSE_NAME FROM PER_TRAINHIS WHERE PER_ID = '".$rec1['PER_ID']."'";
					$query1 = $db->query($sql1);
					$nums1 = $db->db_num_rows($query1);	 
		              if($nums1 > 0){
						while($rec = $db->db_fetch_array($query1)){
						*/
						$htmlr .=  $train; 
						/*
						$some_num++;
						}
					  }else{
					    $htmlr .= "<div align='center'>-</div> ";
					  }
					  */
					 		 	 
					 $htmlr .= "</td>
					 <td LEFT_TOP >".$TRAINHIS_GEN_NAME." </td>
					 ";
					 $htmlr .= "<td LEFT_TOP >&nbsp;&nbsp;".$start_date." </td> ";
					 $htmlr .= "<td LEFT_TOP >&nbsp;&nbsp;".$end_date." </td>
					  <td LEFT_TOP >".$train_org." </td> ";
					 $htmlr .= " </tr>";
				 }
				 
				 $html .= $htmlr;
	     } 
	 
	
 
		$start_no++;
	}
	 
 
		$html_end   = "</table>";
		//$sum_all = $some_num;
		
 
 $sum_all = 1;
		 include_once("inc_print_btn_and_output.php"); ?>
 


         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    