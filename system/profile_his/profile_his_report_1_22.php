<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
$menu_name = 21;
$menu_num = "20".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
   // POST Value;
   $AGE_IS = (int)$_POST['AGE_IS']; 
   $type_is = (int)$_POST['type_is'];  
$PER_ID=$_POST['PER_ID'];
$POSHIS_ID=$_POST['POSHIS_ID'];
   
   $TYPE_ID = (int)$_POST['TYPE_ID'];
   $LEVEL_ID = (int)$_POST['LEVEL_ID'];
   $LG_ID = (int)$_POST['LG_ID'];
   $LINE_ID = (int)$_POST['LINE_ID'];
   
   // array 
   $arr_org = array();
   $arr_org1 = array();
   $arr_org2 = array();
//ประเภทการถือครอง
$arr_poshis_live = array(  
										'1' => 'ปกติ',
										'2' => 'ปฏิบัติราชการแทน',
										'3' => 'รักษาราชการแทน',
										'4' => 'ช่วยราชการภายในสำนักงานฯ',
										'5' => 'ช่วยราชการภายนอกสำนักงานฯ'
								);

 
 //ประเภทตำแหน่ง
 //echo "<pre>"; print_r($arr_pos_type);
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "DELETE_FLAG='0' AND POSTYPE_ID = '1' AND TYPE_ID != 24 ", "TYPE_SEQ");
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "DELETE_FLAG='0'  AND TYPE_ID = '".$_POST['TYPE_ID']."' AND POSTYPE_ID = '1' ", "LEVEL_SEQ");

//สายงาน
//ตำแหน่งในสายงาน
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND LG_ID = '".$_POST['LG_ID']."'", "LINE_NAME_TH","DISTINCT");

 

$LEVEL_ID = (int)$_POST['LEVEL_ID'];
$LG_ID = (int)$_POST['LG_ID'];
$LINE_ID = (int)$_POST['LINE_ID'];
$ORG_ID_1 = (int)$_POST['ORG_ID_1'];
$ORG_ID_2 = (int)$_POST['ORG_ID_2'];
$ORG_ID_3 = (int)$_POST['ORG_ID_3'];
$ORG_ID_4 = (int)$_POST['ORG_ID_4'];
$ORG_ID_5 = (int)$_POST['ORG_ID_5'];
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
    function chk_type_select(){
       var TYPE_ID = $("#TYPE_ID option").filter(":selected").val();
	   if(TYPE_ID==""){
		   alert('กรุณา<?php echo $arr_txt['spec_me'].$arr_txt['type_pos']; ?>ก่อนค่ะ');
		   
		   return false;
		   exit();
	   }
   searchData();
	}
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
                <input type="hidden" id="SEARCH_F" name="SEARCH_F" value="" >
 
                <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="1">
 
        
 <div class="row"  >

 
 


        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['type_pos']; ?> : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><?php  



			  echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_pos_type,$arr_txt['type_pos'],$_POST['TYPE_ID'],'onchange="getlevel(this.value,\'1\'); getLineGroup(this.value,\'1\'); getPosLine(this.value,\'1\');"','','1');?>
            
            <?php /* 
<select name="TYPE_ID" id="TYPE_ID" placeholder="ระบุประเภทตำแหน่ง" class="selectbox  " onchange="getlevel(this.value,'1'); getLineGroup(this.value,'1'); getPosLine(this.value,'1');" style="width: 300px; " title="สามารถค้นหาและเลือกข้อมูลได้">
 <option value=""></option>
 <option value="1">ทั่วไป</option>
 <option value="2">วิชาการ</option>
 <option value="3">อำนวยการ</option>
 <option value="4">บริหาร</option>
 </select>
      */ ?>      
            
            </div> 
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับ : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('LEVEL_ID','LEVEL_ID',$arr_poss_level,$arr_txt['show_all'],$_POST['LEVEL_ID'],'','','1');?></div> 
        </div>	
        <div class="row formSep">
          <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สายงาน : <span style="color:red;">*</span></div>
         <div class="col-xs-12 col-sm-3">
		<?php 
//สายงาน
$arr_pos_lg=GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '1' AND TYPE_ID = '".$_POST['TYPE_ID']."' ", "LG_NAME_TH","DISTINCT");
  echo GetHtmlSelect('LG_ID','LG_ID',$arr_pos_lg,'ทั้งหมด',$_POST['LG_ID'],'onChange="GetLineGov(this.value,1);"','','1');?></div>
            <div class="col-xs-12 col-sm-1"></div>
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในสายงาน : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_line'><?php
//ตำแหน่งในสายงาน
$arr_line_gov = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND TYPE_ID = '".$_POST['TYPE_ID']."' ", "LINE_NAME_TH","DISTINCT");
   echo GetHtmlSelect('LINE_ID','LINE_ID',$arr_pos_line,'ทั้งหมด',$_POST['LINE_ID'],'','','1');?> </span></div>
       <br/><br/> 
</div>        
 <br/>
<?php echo btn_do_center("$('#SEARCH_TYPE').val(1); return chk_type_select();"); 
	$html_start   =  html_report_header($menu_name);
 
    $q_where = '';	 
   if($SEARCH_TYPE==1){    
       $arr_org = $arr_org1;
	   
  
   }else{
       exit();
   }
    
	/*	
	foreach ($arr_org as $key => $value) {
        if($SEARCH_TYPE==1){ 
		    if($AGE_IS>0){
					$q_where = officer_year_between($AGE_IS,"a.PER_DATE_RETIRE");
			}else{
					$q_where = officer_year_between($key,"a.PER_DATE_RETIRE");
			}  
		}
    */
	   /* $sql_get_value = "   SELECT   DATEDIFF(yy, a.PER_DATE_ENTRANCE,  GETDATE()) as officer_year ,DATEDIFF(d, a.PER_DATE_ENTRANCE,  GETDATE()) as officer_year_in_day ,a.PER_DATE_ENTRANCE,a.PER_IDCARD,c.PREFIX_NAME_TH ,a.PER_FIRSTNAME_TH, a.PER_LASTNAME_TH ,a.ORG_ID_1,a.ORG_ID_2,a.ORG_ID_3,a.ORG_ID_4,a.ORG_ID_5,e.TYPE_NAME_TH,F.LINE_NAME_TH,G.LEVEL_NAME_TH  FROM PER_PROFILE a 
LEFT JOIN POSITION_FRAME b ON a.POS_ID = b.POS_ID 
LEFT JOIN SETUP_PREFIX c ON a.PREFIX_ID = c.PREFIX_ID
LEFT JOIN PER_DECORATEHIS d ON a.PER_ID = d.PER_ID
LEFT JOIN SETUP_POS_TYPE E ON A.TYPE_ID = E.TYPE_ID
LEFT JOIN SETUP_POS_LINE F ON A.LINE_ID = F.LINE_ID
LEFT JOIN SETUP_POS_LEVEL G ON A.LEVEL_ID = G.LEVEL_ID
LEFT JOIN SETUP_DECORATION H ON d.DEC_ID = H.DEC_ID
WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 
AND  a.PT_ID = 1  
ORDER BY  G.LEVEL_SEQ DESC,
a.PER_DATE_LEVEL ASC,
a.PER_SALARY DESC,
a.PER_DATE_ENTRANCE ASC,
H.DEC_LEVEL ASC,
d.DEH_RECEIVE_DATE ASC,
a.PER_DATE_BIRTH ASC
 ";*/
 
 
 	    $sql_get_value = "  SELECT   
month(a.PER_DATE_ENTRANCE) as month_start,
DATEPART(dd,a.PER_DATE_ENTRANCE) AS OrderDay,
GETDATE() as this_date,
a.PER_DATE_ENTRANCE,DATEDIFF(yy, a.PER_DATE_ENTRANCE,  GETDATE()) as officer_year ,a.POS_NO,a.PER_SALARY,
 DATEDIFF(d, a.PER_DATE_ENTRANCE,  GETDATE()) as officer_year_in_day , DATEDIFF(m, a.PER_DATE_ENTRANCE,  GETDATE()) as officer_year_in_m ,a.PER_DATE_ENTRANCE,a.PER_IDCARD,c.PREFIX_NAME_TH ,a.PER_FIRSTNAME_TH, a.PER_LASTNAME_TH ,a.ORG_ID_1,a.ORG_ID_2,a.ORG_ID_3,a.ORG_ID_4,a.ORG_ID_5,e.TYPE_NAME_TH,F.LINE_NAME_TH,G.LEVEL_NAME_TH
   FROM PER_PROFILE a 
LEFT JOIN POSITION_FRAME b ON a.POS_ID = b.POS_ID 
LEFT JOIN SETUP_PREFIX c ON a.PREFIX_ID = c.PREFIX_ID
LEFT JOIN PER_DECORATEHIS d ON a.PER_ID = d.PER_ID
LEFT JOIN SETUP_POS_TYPE E ON A.TYPE_ID = E.TYPE_ID
LEFT JOIN SETUP_POS_LINE F ON A.LINE_ID = F.LINE_ID
LEFT JOIN SETUP_POS_LEVEL G ON A.LEVEL_ID = G.LEVEL_ID
LEFT JOIN SETUP_DECORATION H ON d.DEC_ID = H.DEC_ID
WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 
AND  a.PT_ID = 1  ";


 
if($LEVEL_ID>0){
    $sql_get_value .= " AND  a.LEVEL_ID = ".$LEVEL_ID."  ";
} 

if($TYPE_ID>0){
    $sql_get_value .= " AND  a.TYPE_ID = ".$TYPE_ID."  ";
} 

if($LG_ID>0){
    $sql_get_value .= " AND  a.LG_ID = ".$LG_ID."  ";
} 

if($LINE_ID>0){
    $sql_get_value .= " AND  a.LINE_ID = ".$LINE_ID."  ";
} 
 
/*
if($LG_ID>0){
    $sql_get_value .= " AND  a.LG_ID = ".$LG_ID."  ";
} */
 
if($ORG_ID_1>0){
    $sql_get_value .= " AND  a.ORG_ID_1 = ".$ORG_ID_1."  ";
} 
if($ORG_ID_2>0){
    $sql_get_value .= " AND  a.ORG_ID_2 = ".$ORG_ID_2."  ";
} 
if($ORG_ID_3>0){
    $sql_get_value .= " AND  a.ORG_ID_3 = ".$ORG_ID_3."  ";
}   
if($ORG_ID_4>0){
    $sql_get_value .= " AND  a.ORG_ID_4 = ".$ORG_ID_4."  ";
} 
if($ORG_ID_5>0){
    $sql_get_value .= " AND  a.ORG_ID_5 = ".$ORG_ID_5."  ";
} 

$sql_get_value .= " ORDER BY  G.LEVEL_SEQ DESC,
a.PER_DATE_LEVEL ASC,
a.PER_SALARY DESC,
a.PER_DATE_ENTRANCE ASC,
H.DEC_LEVEL ASC,
d.DEH_RECEIVE_DATE ASC,
a.PER_DATE_BIRTH ASC
 ";
 
          //echo $key.$q_where."<br/>".$sql_get_value." and a.PT_ID = ".$type_is."     ".$q_where; exit();
		$query_who = $db->query($sql_get_value."     ".$q_where); 
		$sum_all = $db->db_num_rows($query_who); 
		$this_month = (int)date("n");
		$this_day = (int)date('d'); 
             while($rec1 = $db->db_fetch_array($query_who)){
			  $org3 = (int)$rec1['ORG_ID_3'];
			  $sql = ' SELECT  ORG_NAME_TH from SETUP_ORG where ORG_ID = '.$org3;
			  $query_org = $db->query($sql);
			  $org_is = $db->db_fetch_array($query_org);
			  $my_year = (int)$rec1['officer_year'];
			  $month_all = (int)$rec1['officer_year_in_m'];	
			  $date_all = (int)$rec1['officer_year_in_day'];
			  $month_year_is = $my_year*12;
			  $my_month = (int)($month_all - $month_year_is);
               $month_start = (int)$rec1['month_start'];
               $OrderDay = (int)$rec1['OrderDay'];
               $month_diff_is = $this_month - $month_start;
			   $date_diff_is = $this_day - $OrderDay;
			   // ===============================
               if($month_diff_is < 0){ // ยังไม่ถึง
			  	$my_year = $my_year - 1;
			 	$my_month =  12 + ($month_diff_is);
					 if($date_diff_is ==0){
						$my_date = 0;
					 }else{
					    $my_date = $date_diff_is;
					 } 
 
			   }
			   // =============================
               if($month_diff_is > 0){ // เกินมาแล้ว
					 if($date_diff_is ==0){
						$my_date = 0;
					 }else{
					    $my_date = $date_diff_is;
					 } 
			   }	   
			   // =============================
               if($month_diff_is == 0){ // เดือนนี้แหละ
			 		 $my_month =  12;
					 if($date_diff_is ==0){
						$my_date = 0;
					 }else{
					    $my_date = $date_diff_is;
					 } 
			   }	  
			   
			   if($my_date < 0 ){ // เศษวัน
			     $my_month =  $my_month - 1;
				 if($my_month < 0){ // ไม่ถึงเดือน
				   $my_month = 0;
				   $my_year = $my_year - 1;
				 }
				 $my_date = 30 +( $my_date); 
			   }
			   if($my_date > 0 ){
			 
			   }
			  /*
			  if($my_month < 0){
			  	$my_year = $my_year - 1;
				$my_month = 12+($my_month);
			  }*/
			  
		       $html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
					 <td CENTER_TOP  >".$start_no."</td> 
					 <td CENTER_TOP   >".get_idCard($rec1['PER_IDCARD'])."</td> 
					 <td CENTER_TOP   >".$rec1['POS_NO']."</td> 
					 <td LEFT_TOP   >".text($rec1['PREFIX_NAME_TH'])." ".text($rec1['PER_FIRSTNAME_TH'])." ".text($rec1['PER_LASTNAME_TH'])."</td>
					 <td LEFT_TOP   >".text($rec1['TYPE_NAME_TH'])."</td> 
					 <td LEFT_TOP   >".text($rec1['LINE_NAME_TH'])."</td> 
					 <td LEFT_TOP   >".text($rec1['LEVEL_NAME_TH'])."</td>  
					 <td RIGHT_TOP   >".number_format($rec1['PER_SALARY'],2)."</td> 
					 <td LEFT_TOP   >".text($org_is['ORG_NAME_TH'])."</td>  
					 <td CENTER_TOP   >".conv_date($rec1['PER_DATE_ENTRANCE'],'short')."</td> "; 
		       $html  .= "<td LEFT_TOP   >";
			   if($my_year > 0){ 
			   $html  .= $my_year." ปี ";
			   }
			   if($my_month > 0){
			   	$html  .= $my_month." เดือน ";
				}
			   if($my_date > 0){
			    $html .= $my_date." วัน ";
			   }
			   $html  .= "</td>   
				  </tr>";
			$start_no++;
	  }  
	//}   
	 
 
		$html_end   = "</table>";
		include_once("inc_print_btn_and_output.php"); ?>
     
         </div> 
 </div> 
 
    
    
	</div>
    <div style="position:absolute;
   bottom:0;
   width:100%;
   height:30px;   ">
	<?php include_once("report_footer.php"); ?></div>
</div>
</body>
</html>
    
    