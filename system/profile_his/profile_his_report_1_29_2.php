<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
$menu_name = 26;
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
   

//ประเภทการถือครอง
$arr_poshis_live = array(  
										'1' => 'ปกติ',
										'2' => 'ปฏิบัติราชการแทน',
										'3' => 'รักษาราชการแทน',
										'4' => 'ช่วยราชการภายในสำนักงานฯ',
										'5' => 'ช่วยราชการภายนอกสำนักงานฯ'
								);

//org1
$arr_org1=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.OL_ID='2' ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");
//org2
if(trim($rec['ORG_ID_1']) != ''){
	$org_id_1 = $rec['ORG_ID_1']; 
}else{
	$org_id_1 = 405;
}
$arr_org2=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$org_id_1."' ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ ");
//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_2']."' ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");
//org4
$arr_org4=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_3']."'  ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");

$arr_org5=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.DELETE_FLAG='0' AND a.ACTIVE_STATUS='1'  AND a.ORG_PARENT_ID='".$rec['ORG_ID_4']."'  ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");


//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '1' ", "TYPE_SEQ");
 
if($POSTYPE_ID==1||$POSTYPE_ID==5){
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_SEQ");
}else{
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'   AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_SEQ");
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

</head>
<body <?php echo $remove;?>> <?php  ///echo "<pre>"; print_r($_POST);  ?>
<div id="content" class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	    <?php echo report_breadcrumb($paramlink,showMenu($menu_sub_id),$headline_title); ?>
    
    
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
        
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่ง : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_pos_type,'ประเภทตำแหน่ง',$TYPE_ID,'onchange="getlevel(this.value,\''.$POSTYPE_ID.'\'); getLineGroup(this.value,\''.$POSTYPE_ID.'\');"','','1');?></div> 
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับตำแหน่ง : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('LEVEL_ID','LEVEL_ID',$arr_poss_level,'ระดับตำแหน่ง',$LEVEL_ID,'','','1');?></div> 
        </div>	
        <?php /*
        <div class="row formSep">
          <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สายงาน : <span style="color:red;">*</span></div>
         <div class="col-xs-12 col-sm-3">
		 <?php echo GetHtmlSelect('LG_ID','LG_ID',$arr_pos_lg,'สายงาน',$LG_ID,'onChange="GetLineGov(this.value,1);"','','1');?></div>
            <div class="col-xs-12 col-sm-1"></div>
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในสายงาน : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_line'><?php  echo GetHtmlSelect('LINE_ID','LINE_ID',$arr_pos_line,'ตำแหน่งในสายงาน',$LINE_ID,'','','1');?></span></div>
        </div>	      
 
        <div class="row formSep">
          <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ลุักษณะของตำแหน่ง : <span style="color:red;">*</span></div>
         <div class="col-xs-12 col-sm-3">
                   <select id="position_status" name="position_status" class="selectbox form-control"   placeholder=" ลุักษณะของตำแหน่ง " >  
                   <option value="" ></option>
                        <option value="1" <?php echo ($type_is == 1?"selected":"");?>   >ว่าง ไม่มีเงิน</option>
                        <option value="2" <?php echo ($type_is == 2?"selected":"");?>  >ว่าง มีเงิน</option>  
                        <option value="3" <?php echo ($type_is == 3?"selected":"");?>  >มีคนถือครอง</option>                         
                        <option value="4" <?php echo ($type_is == 4?"selected":"");?>  >ยุบเลิก</option>                         
                          
                                                         
                    </select>	
         
         </div>
            <div class="col-xs-12 col-sm-1"></div>
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สถานะ : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_line'>
                   <select id="vacancy_status" name="vacancy_status" class="selectbox form-control"   placeholder=" สถานะ " >  
                   <option value="" ></option>
                        <option value="1" <?php echo ($type_is == 1?"selected":"");?>   ><?php echo $arr_txt['vacancy']; ?></option>
                        <option value="2" <?php echo ($type_is == 2?"selected":"");?>  ><?php echo $arr_txt['not_vacancy']; ?></option>  
                        
                          
                                                         
                    </select>	
            </span></div> 
        </div>	     
          */ ?>  
       <br/><br/> 
</div>        
        
 <div class="row" style="margin:0 auto;"><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);searchData();">ค้นหา</button></div>
 
     
     <?php
 
   if($SEARCH_TYPE==1){ 
   
   }else{
   	exit();
   }
     $s_field = "";
 
 
	    $html_start   =  html_report_header($menu_name);
	 
		$sql_get_value = "   select a.ORG_ID,c.line_id ,a.ORG_NAME_TH,b.POS_ID,b.POS_NO,c.LINE_NAME_TH,d.TYPE_NAME_TH,
e.LEVEL_SHORTNAME_TH,c.LINE_NAME_TH , f.OT_NAME_TH , g.PROV_TH_NAME
from SETUP_ORG  a 
LEFT JOIN POSITION_FRAME b ON a.ORG_ID = b.ORG_ID_3
LEFT JOIN SETUP_POS_LINE c ON b.LINE_ID = c.LINE_ID
LEFT JOIN SETUP_POS_TYPE d ON c.TYPE_ID = d.TYPE_ID
LEFT JOIN SETUP_POS_LEVEL e ON b.LEVEL_ID = e.LEVEL_ID
LEFT JOIN SETUP_ORG_TYPE f ON a.OT_ID = f.OT_ID  
LEFT JOIN SETUP_PROV g ON a.ORG_PROV_ID = g.PROV_ID
WHERE a.active_status = 1 and  a.delete_flag = 0
  and b.active_status = 1 and  b.delete_flag = 0
  and c.active_status = 1 and  c.delete_flag = 0 ";
if($TYPE_ID  > 0){
$sql_get_value .= " AND c.TYPE_ID = '".$TYPE_ID."'  ";
}
if($LEVEL_ID  > 0){
$sql_get_value .= " AND b.LEVEL_ID = '".$LEVEL_ID."'  ";
}

 
$sql_get_value .= "  
ORDER BY a.ORG_SEQ ASC, b.POS_ID ASC, d.TYPE_SEQ ASC
 
 ";
  
 
		$query_who = $db->query($sql_get_value); 
		$sum_all = $db->db_num_rows($query_who); 
             while($rec1 = $db->db_fetch_array($query_who)){
			 
		$sql = " select a.per_id,a.PER_FIRSTNAME_TH,a.PER_LASTNAME_TH,b.prefix_name_th,a.PER_IDCARD , d.EL_NAME_TH,e.ed_name_th,f.em_name_th,g.ins_name_th,g.COUNTRY_ID
 from  PER_PROFILE a 
		LEFT JOIN SETUP_PREFIX b ON a.prefix_id = b.prefix_id 
		LEFT JOIN PER_EDUCATEHIS c ON a.per_id = c.per_id
    LEFT JOIN SETUP_EDU_LEVEL d ON c.EL_id = d.EL_ID
    LEFT JOIN SETUP_EDU_DEGREE e ON c.ed_id = e.ed_id
    LEFT JOIN SETUP_EDU_MAJOR f ON c.em_id = f.em_id
	LEFT JOIN SETUP_EDU_INSTITUTE g ON c.INS_ID = g.INS_id 
		
		 where a.POS_NO = ".$rec1['POS_NO']." AND a.ACTIVE_STATUS = 1 ";
		 if($type_is ==1 ){ // ตำแหน่งว่าง 
		 
		 }
		 if($type_is ==2 ){
		 
		 }	 
		 
		 
		 $sql .= " ORDER BY d.EL_ID DESC ";	  //echo $sql; exit(); 
		$query_man = $db->query($sql); 
		$sum_man = $db->db_num_rows($query_man); 
		
		if($sum_man == 0){
		    $pos_status = " ตำแหน่งว่าง ";
			$who_get_pos = "";
			$man_prefix = " - ";
			$man_fname = " - ";
			$man_lname = " - ";
			$man_idcard = " - ";
			$man_gender = " - ";
			$man_birth = " - ";
			$man_startdate = " - ";
			$mansalary = " - ";
			$mansalaryposition = " - ";			
			$man_education = " - ";
			$man_edu_degree = " - ";
			$man_edu_major = " - ";
			$man_edu_institutte = " - ";
		}else{
		    $rec2 = $db->db_fetch_array($query_man);
		    $pos_status = " มีคนถือครอง ";	
			$who_get_pos = text(wordwrap($rec2['prefix_name_th']))." ".text(wordwrap($rec2['PER_FIRSTNAME_TH']))." ".text(wordwrap($rec2['PER_LASTNAME_TH']));	
			$man_prefix = text(wordwrap($rec2['prefix_name_th']));
			$man_fname = text(wordwrap($rec2['PER_FIRSTNAME_TH']));
			$man_lname = text(wordwrap($rec2['PER_LASTNAME_TH']));
			$man_idcard = $rec2['PER_IDCARD'];
			$man_gender = ($rec2['PER_GENDER'] == 1) ? "ชาย" : "หญิง";
			$man_birth = conv_date($rec2['PER_DATE_BIRTH'],'short');
			$man_startdate = conv_date($rec2['PER_DATE_ENTRANCE'],'short');
			$man_salary = number_format($rec2['PER_SALARY'],2);
			$mansalaryposition = number_format($rec2['PER_SALARY_POSITION'],2);
			$man_education = text(wordwrap($rec2['EL_NAME_TH']));
			$man_edu_degree = text(wordwrap($rec2['ed_name_th']));
			$man_edu_major = text(wordwrap($rec2['em_name_th']));
			$man_edu_institutte = text(wordwrap($rec2['ins_name_th']));
		}
			 
		$country_name = ""; 
		$COUNTRY_id = (int)$rec2['COUNTRY_id'];
		if($COUNTRY_id > 0 ){ 
		$sql = " select COUNTRY_NAME_TH from SETUP_COUNTRY where COUNTRY_ID = ".$COUNTRY_id." ";
		$query_country = $db->query($sql); 
		 $rec3 = $db->db_fetch_array($query_country);
		 $country_name = $rec3['COUNTRY_NAME_TH'];
		}
		
		$scholar_name = "";
		$movement_type = "";
		$movement_date = "";
		$per_id = (int)$rec3['PER_ID'];
		if($per_id > 0 ){ 
		$sql = " select SCHOLAR_PROJECT_NAME from PER_SCHOLARHIS where PER_ID = ".$per_id." ";
		$query_scholar = $db->query($sql); 
		 $rec4 = $db->db_fetch_array($query_scholar);
		 $scholar_name = $rec4['SCHOLAR_PROJECT_NAME'];
		 
		$sql = " select b.MOVEMENT_TYPE,a.CONTACT_SDATE
		from PER_POSITIONHIS a 
		LEFT JOIN SETUP_MOVEMENT b ON a.MOVEMENT_ID = b.MOVEMENT_ID
		where a.PER_ID = ".$per_id." ";
		$query_movement = $db->query($sql); 
		 $rec5 = $db->db_fetch_array($query_movement);
		 $movement_name = $rec5['SCHOLAR_PROJECT_NAME'];
		 $movement_date = conv_date($rec5['CONTACT_SDATE'],'short');  
		}
 
		
        $line_id_is =(int)$rec1['line_id'];
 		$html  .= "<tr  style='height:0.7cm;'> ";
 		//$html  .= "<td CENTER_TOP  >".number_format($start_no)."</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;กระทรวงมหาดไทย</td>  
	 		 <td LEFT_TOP >&nbsp;&nbsp;กรมป้องกันและบรรเทาสาธารณภัย</td>";
 
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".text($rec1['ORG_NAME_TH'])."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td CENTER_TOP >&nbsp;&nbsp;".$rec1['POS_ID']."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".text($rec1['LINE_NAME_TH'])."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".text($rec1['TYPE_NAME_TH'])."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".text($rec1['LEVEL_SHORTNAME_TH'])."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".text($rec1['LINE_NAME_TH'])."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$test."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".text($rec1['OT_NAME_TH'])."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";		
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".text($rec1['PROV_TH_NAME'])."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$pos_status."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_prefix."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_fname."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_lname."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_idcard."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_gender."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_birth."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";	
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_startdate."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_salary."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$mansalaryposition."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_education."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_edu_degree."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_edu_major."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$man_edu_institutte."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$country_name."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";		
		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$scholar_name."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
 		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$movement_type."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";
  		$html  .= " <td LEFT_TOP >&nbsp;&nbsp;".$movement_date."&nbsp;&nbsp;&nbsp;&nbsp;</td> ";			
							
 		$html  .= " </tr>";   
 		$start_no++;
		 
		 
 	  }
 
	
		$html_end   = "</table>";
 

if($sum_all > 0){ ?>
</form>   
 <?php echo print_btn($menu_name,$html);  
} 


	$html =  str_replace("CENTER_TOP",$CENTER_TOP,$html);
	$html =  str_replace("LEFT_TOP",$LEFT_TOP,$html);		
	
?><div class="col-xs-12 col-sm-12">
<?php
	echo $html_start.$html.$html_end;	
 ?> </div>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    