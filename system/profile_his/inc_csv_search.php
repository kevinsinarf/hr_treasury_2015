<?php 

if($postype_id_is > 0){
	if($postype_id_is==3){
		$menu_name = 48;
	}
	if($postype_id_is==5){
		$menu_name = 64;	 
	}
} 
//echo "xx".$postype_id_is;
 if($menu_name==26){
     $wh_pt_id = " AND  a.PT_ID = 1  ";
	 $wh_postype_id = " AND POSTYPE_ID = 1 ";
	 $php_body = "inc_291_1.php";
 }
 if($menu_name==48){
     $wh_pt_id = " AND  a.PT_ID = 2  ";
	 $wh_postype_id = " AND POSTYPE_ID = 3 ";
	 $php_body = "inc_291_2.php";
 }
 if($menu_name==64){
     $wh_pt_id = " AND  a.PT_ID = 3  ";
	 $wh_postype_id = " AND POSTYPE_ID = 5 ";
	 $php_body = "inc_291_3.php";
 }


 


$headline_title =  $report_menu[$menu_name]['name']; 
 
 
   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
 
   $TYPE_ID = (int)$_POST['TYPE_ID'];
   $LEVEL_ID = (int)$_POST['LEVEL_ID'];
   $LG_ID = (int)$_POST['LG_ID'];
   $LINE_ID = (int)$_POST['LINE_ID'];
   $SEARCH_TYPE = (int)$_POST['SEARCH_TYPE'];
   
 
//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0'    ".$wh_postype_id, "TYPE_SEQ");
 
if($POSTYPE_ID==1||$POSTYPE_ID==5){
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_SEQ");
}else{
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  ".$wh_postype_id, "LEVEL_SEQ");
}
if($POSTYPE_ID==1||$POSTYPE_ID==5){
//ตำแหน่งในสายงาน
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND LG_ID = '".$rec['LG_ID']."'", "LINE_NAME_TH");
}else{
//ตำแหน่งในสายงาน
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."'", "LINE_NAME_TH");	
}
if($POSTYPE_ID==3){
	//ตำแหน่งพนักงานราชการ
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND LEVEL_ID = '".$rec['LEVEL_ID']."'", "LINE_NAME_TH");
}
if($POSTYPE_ID==5){
	$arr_pos_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_SEQ");
}
//สายงาน
$arr_pos_lg=GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LG_NAME_TH");
 
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
<script>
function chk_me(){
 
    //var org_id_val = $("#TYPE_ID option").filter(":selected").val();
    //var type_is_val = $("#LEVEL_ID option").filter(":selected").val();
  // if(org_id_val==""){
       // alert("กรุณาเลือก <?php echo $arr_txt['type_pos']; ?> ด้วยค่ะ");
	    // return false;exit();
  // }
         searchData();
}
function csv_export291(){
    $('#frm-291csv').submit();
}
 
</script>
<style type="text/css">
  div.small-box {
  width:1300px;
  height:auto;
  overflow-x:scroll;
  
  }
</style>
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
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['type_pos']; ?> : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_pos_type,'ทั้งหมด',$TYPE_ID,'onchange="getlevel(this.value,\''.$postype_id_is.'\'); "','','1');?></div> 
            <div class="col-xs-12 col-md-2"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับตำแหน่ง :  </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('LEVEL_ID','LEVEL_ID',$arr_poss_level,'ทั้งหมด',$LEVEL_ID,'','','1');?></div> 
        </div>	
 
 
 
 		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ปีงบประมาณ :</div>
			<div class="col-xs-12 col-sm-4">
                    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="ทั้งหมด"  style="width:280px"   >   
                     
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
 
       <br/><br/> 
   
        
 
<?php echo btn_do_center("$('#SEARCH_TYPE').val(1);return chk_me();"); ?>
 
   <div class="small-box">
<?php
   $list = array();
   if($SEARCH_TYPE==1){ 
   
   }else{ // if not , don't do.
   		exit();
   }
   
					 
	 $this_year =  date('Y', time());
	 if($AGE_IS > 0){ 
		 if($AGE_IS > 2300){ 
			  $AGE_IS_gen = $AGE_IS-543; 
		 }else{
			  $AGE_IS_gen = $AGE_IS;
		 }
	 }else{
			  $AGE_IS_gen = $this_year;	 
	 }
	 
	 
	 if($AGE_IS2 > 0){ 
		 if($AGE_IS2 > 2300){ 
			  $AGE_IS_gen2 = $AGE_IS2-543; 
		 }else{
			  $AGE_IS_gen2 = $AGE_IS2;
		 }
	 }else{
			  $AGE_IS_gen2 = $this_year;	 
	 } 
   
  $sql = " select   a.POS_NO, a.POS_STATUS, 
                    b.TYPE_NAME_TH,
					c.LEVEL_NAME_TH , c.LEVEL_SHORTNAME_EN ,
					d.LINE_NAME_TH,
					e.LG_NAME_TH ,
					f.MT_NAME_TH ,
					g.PER_ID, g.PER_IDCARD, g.PER_SALARY_POSITION, g.PER_GENDER , g.PREFIX_ID, g.PER_FIRSTNAME_TH ,  g.PER_LASTNAME_TH  , g.PER_DATE_BIRTH, g.PER_DATE_ENTRANCE, g.PER_DATE_LEVEL,g.PER_DATE_POSITION,g.PER_ID ,
					h.ORG_NAME_TH  ,h.ORG_SHORTNAME_TH as do_org_shortname, 
					i.ORG_NAME_TH as ORG_NAME_TH2,g.PER_DATE_RETIRE , 
					j.LEVEL_NAME_TH  as current_level_name ,
					k.ORG_SHORTNAME_TH as frame_org_name3 ,
					l.PREFIX_NAME_TH
FROM POSITION_FRAME a 
LEFT JOIN SETUP_POS_TYPE b ON a.TYPE_ID = b.TYPE_ID 
LEFT JOIN  SETUP_POS_LINE d ON a.LINE_ID = d.LINE_ID 
LEFT JOIN SETUP_POS_LEVEL c ON a.LEVEL_ID = c.LEVEL_ID 
LEFT JOIN SETUP_POS_LINE_GROUP e ON a.LG_ID = e.LG_ID 
LEFT JOIN SETUP_POS_MANAGE_TYPE f ON a.MT_ID = f.MT_ID 
LEFT JOIN PER_PROFILE g ON a.POS_ID = g.POS_ID 
LEFT JOIN SETUP_ORG h ON g.ORG_ID_3 = h.ORG_ID 
LEFT JOIN SETUP_ORG i ON g.ORG_ID_2 = i.ORG_ID 
LEFT JOIN SETUP_POS_LEVEL j ON g.LEVEL_ID = j.LEVEL_ID 
LEFT JOIN SETUP_ORG k ON a.ORG_ID_3 = k.ORG_ID 
LEFT JOIN SETUP_PREFIX l ON g.PREFIX_ID = l.PREFIX_ID 
WHERE   a.ACTIVE_STATUS = 1 "; 
 
		 if($type_is ==1 ){ // ตำแหน่งว่าง 
		 
		 }
		 if($type_is ==2 ){
		 
		 }	 
		 
		 // Search Addition 
		if($TYPE_ID > 0 ){
				$sql .= "  AND  a.TYPE_ID = '".$TYPE_ID."' ";
		} 
		if($LEVEL_ID > 0 ){
				$sql .= "  AND  g.LEVEL_ID = '".$LEVEL_ID."' ";
		} 
 ?>
  
 