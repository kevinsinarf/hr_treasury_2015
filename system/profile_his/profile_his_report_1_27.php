<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$menu_name = 24;
$menu_num = "23".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name']; 
$MT_ID = (int)$_POST['MT_ID'];
$MANAGE_ID = (int)$_POST['MANAGE_ID'];
 
   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
   $LINE_ID = (int)$_POST['LINE_ID'];
   $SEARCH_F = $_POST['SEARCH_F'];

   
   $sql_org = "select a.MT_ID, a.MANAGE_ID, b.MT_NAME_TH ";
   $sql_org .= " from SETUP_POS_MANAGE a LEFT JOIN SETUP_POS_MANAGE_TYPE b ON a.MT_ID = b.MT_ID  "; 
   $sql_org .= " WHERE  a.ACTIVE_STATUS = 1  AND (a.TYPE_ID = '0' OR a.TYPE_ID IS NULL) AND a.POSTYPE_ID = '1'  ";
 
 
 
   $sql_org .= " ORDER BY b.MT_SEQ ASC";
	$query_org = $db->query($sql_org); 
	
while($rec1 = $db->db_fetch_array($query_org)){
					        $arr_org[$rec1['MT_ID']] = text($rec1['MT_NAME_TH']);
	}
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
                      <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่งทางการบริหาร :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('MT_ID','MT_ID',$arr_type_mt,'ประเภทตำแหน่งทางการบริหาร',$_POST['MT_ID'],'','','1');?></div>  <div class="col-xs-12 col-md-1"></div> <?php /* onchange=get_manage(this.value,1); */ ?>
                      <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งทางการบริหาร :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_manage'><?php  echo GetHtmlSelect('MANAGE_ID','MANAGE_ID',$arr_type_manage2,'ตำแหน่งทางการบริหาร',$_POST['MANAGE_ID'],'','','1');?></span></div>       
                    </div> 
<?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();");  
       
 /*
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ตำแหน่งในการบริหาร :</div>
			<div class="col-xs-12 col-sm-3">
        
                    <select id="LINE_ID" name="LINE_ID" class="selectbox form-control" placeholder="ตำแหน่งในการบริหาร "     >   
                      <option value=""></option>
                      <?php while($rec1 = $db->db_fetch_array($query_org)){
					        $arr_org[$rec1['MANAGE_ID']] = text($rec1['MANAGE_NAME_TH']);
					  ?>
                        <option value="<?php echo $rec1['MANAGE_ID']?>"  <?php echo ($rec1['MANAGE_ID'] ==$LINE_ID?"selected":"");?>    >
                        <?php echo text($rec1['MANAGE_NAME_TH'])?></option>
                      <?php }?>
                    </select>		
					
		 	
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	<button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);$('#SEARCH_F').val($('#LINE_ID').find(':selected').text());searchData();">ค้นหา</button>	 </div>
			<div class="col-xs-12 col-sm-2">
 
			</div>
        </div>
 */ ?>
     <?php
//$(this).find(":selected").text()
// alert($('#LINE_ID').find(':selected').text());
 
    $q_where = '';	 
	/*
   if($SEARCH_TYPE==1){    
       //$arr_org = $arr_org1;

  
   }else{
       exit();
   }
   */ 
    $some_num = 0;
	$html_start   =  " <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;'  class='table table-bordered table-striped table-hover table-condensed' >  ".html_report_header($menu_name); 
        $html = "";
	 
		/*
	if($LINE_ID>0){
	      if($SEARCH_F!=""){
			  $arr_org = array();
			  $arr_org[$LINE_ID] = $SEARCH_F;
		  }
	}*/
	
	if($MT_ID > 0){
	$temp_name =  $arr_org[$MT_ID];  
	$arr_org = array();
	  $arr_org[$MT_ID] = $temp_name;
	}
	
	if($MANAGE_ID > 0){
	    $sql = " select a.MT_ID, a.MANAGE_ID, b.MT_NAME_TH  from SETUP_POS_MANAGE a LEFT JOIN SETUP_POS_MANAGE_TYPE b ON a.MT_ID = b.MT_ID  WHERE  a.ACTIVE_STATUS = 1 
 AND (a.TYPE_ID = '0' OR a.TYPE_ID IS NULL) AND a.POSTYPE_ID = '1' AND  a.MANAGE_ID = ".$MANAGE_ID;
         $query_mt = $db->query($sql);
		 $mt_is = $db->db_fetch_array($query_mt);
	   	if($MT_ID == 0){ // search ตำแหน่งทางการบริหาร อย่างเดียว
	        
		  $arr_org = array();
		  $arr_org[$mt_is['MT_ID']] = text($mt_is['MT_NAME_TH']);
		}else{ // search ทั้งหมดอย่าง
		  if($mt_is['MT_ID'] !=  $MT_ID){  // if not the same things.
		  	$arr_org[$mt_is['MT_ID']] = text($mt_is['MT_NAME_TH']);
		  }
		}
	}
	
	 $start_no = 1;	// echo "<pre>"; print_r($arr_org ); exit(); 
	foreach ($arr_org as $key => $value) {
		// echo "$key$value<br/>";
        
	    $htmlr = "
		<tr   style='height:0.7cm;background-color:#fff;' ><td LEFT_TOP  colspan=6 >
		&nbsp;&nbsp;".$value."</td> </tr> 
		
 		";
	 
		
         $sql_get_value = "  SELECT  a.PER_ID,d.MT_ID,a.PER_IDCARD,
		 a.PER_FIRSTNAME_TH, a.PER_LASTNAME_TH , a.ORG_ID_1  ,a.ORG_ID_2  ,a.ORG_ID_3 ,a.ORG_ID_4,a.ORG_ID_5 ,a.POS_NO , a.PER_GENDER ,
		  e.MT_NAME_TH , c.PREFIX_NAME_TH ,f.MANAGE_NAME_TH 
 FROM PER_PROFILE a 
LEFT JOIN SETUP_PREFIX c ON a.PREFIX_ID = c.PREFIX_ID
LEFT JOIN PER_POSITIONHIS d ON a.PER_ID = d.PER_ID 
LEFT JOIN SETUP_POS_MANAGE_TYPE e  ON a.MT_ID = e.MT_ID 
LEFT JOIN SETUP_POS_MANAGE f ON a.MANAGE_ID = f.MANAGE_ID
WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 
AND  a.PT_ID = 1";

if($MT_ID > 0){
		 $sql_get_value .= "  AND f.MT_ID = '".$MT_ID."'   ";

}

if($MANAGE_ID > 0){
		 $sql_get_value .= "  AND f.MANAGE_ID = '".$MANAGE_ID."'   ";

}
 
if(($MT_ID+$MANAGE_ID)==0){

	if($key > 0){
		 $sql_get_value .= "  AND f.MT_ID = '".$key."'   ";
	} // if key > 0
} // if MT_ID + MANAGE_ID = 0

/*
if($LINE_ID>0){
  $sql_get_value .= "  AND a.ORG_ID_3 = ".$LINE_ID."   ";
}else{
   $sql_get_value .= "  AND a.ORG_ID_3 = ".$key."   ";
}*/ 
 

		$query_who = $db->query($sql_get_value); 
		$sum_all = $db->db_num_rows($query_who); 
		  if($sum_all > 0){
				 while($rec1 = $db->db_fetch_array($query_who)){
				  $org3 = (int)$rec1['ORG_ID_2'];
				  $MT_NAME_TH = text($rec1['MT_NAME_TH']);
				  $POS_NO = $rec1['POS_NO'];
				  $MANAGE_NAME_TH = text($rec1['MANAGE_NAME_TH']); 
				  $sql = ' SELECT  ORG_NAME_TH from SETUP_ORG where ORG_ID = '.$org3;
				  $query_org = $db->query($sql);
				  $org_is = $db->db_fetch_array($query_org);
					$htmlr  .= "<tr  style='height:0.7cm; padding-left;3px;'> 
						 <td CENTER_TOP  >".$start_no."</td> 				    
						 <td CENTER_TOP  >".get_idCard($rec1['PER_IDCARD'])."</td> 
						  <td CENTER_TOP  >".$POS_NO."</td> 
						 <td LEFT_TOP >".text($rec1['PREFIX_NAME_TH'])." ".text($rec1['PER_FIRSTNAME_TH'])." ".text($rec1['PER_LASTNAME_TH'])."</td> 
 
						     <td LEFT_TOP  >".$MANAGE_NAME_TH."</td> ";
				       $htmlr .= "<td LEFT_TOP >";
					   if(($value!="อธิบดี")AND($value!="รองอธิบดี")){ 
					  			$org3 = (int)$rec1['ORG_ID_3'];
						}else{
					  			$org3 = (int)$rec1['ORG_ID_2'];
						}
					  $sql = ' SELECT  ORG_NAME_TH from SETUP_ORG where ORG_ID = '.$org3;
					  
					  $query_org = $db->query($sql);
					  $org_is = $db->db_fetch_array($query_org);
					  $htmlr .= text($org_is['ORG_NAME_TH'])  ;	 	 
					 $htmlr .= "</td>
					
					   </tr>";
					 		$start_no++;
				 }
				 
				 $html .= $htmlr;
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
    
    