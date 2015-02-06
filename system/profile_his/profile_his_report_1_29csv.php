<?php 
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream'); 
header('Content-Disposition: attachment; filename=file.csv');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
echo "\xEF\xBB\xBF"; // UTF-8 BOM
 

 
//header('content-type: text/csv; charset=utf-8');   // TIS-620 // utf-8
//header("Content-Disposition: attachment; filename=report-.csv");
//header("Pragma: no-cache");
//header("Expires: 0");
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
 
 
$menu_name = 26;
$headline_title =  $report_menu[$menu_name]['name']; 
 
 
   $html  = "";
   $start_no = 1;
   $LEVEL_ID = (int)$_GET['level_id_is'];
   $TYPE_ID = (int)$_GET['type_is_is'];
   $menu_name = (int)$_GET['menu_name'];
   if($TYPE_ID < 0){
     exit();
   }
   if($menu_name > 0){
   		exit();
   }
   
 if($menu_name==26){
     $wh_pt_id = " AND  a.PT_ID = 1  ";
 }
 if($menu_name==48){
     $wh_pt_id = " AND  a.PT_ID = 2  ";
 }
 if($menu_name==64){
     $wh_pt_id = " AND  a.PT_ID = 3  ";
 }

 
 
   $list = array();
 
     $s_field = "";
 
   
	    $html_start   =  html_report_header($menu_name);
	 
		$sql_get_value = "   select a.ORG_ID,c.line_id ,a.ORG_NAME_TH,b.POS_ID,b.POS_NO,c.LINE_NAME_TH,d.TYPE_NAME_TH,
e.LEVEL_SHORTNAME_TH,e.LEVEL_SHORTNAME_EN,c.LINE_NAME_TH , f.OT_NAME_TH , g.PROV_TH_NAME
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
   if($TYPE_ID!=2){
      $temp_skill = " ไม่มีสาขาชำนาญการ ";
   }else{
      $temp_skill = " ";
   }
}
if($LEVEL_ID  > 0){
$sql_get_value .= " AND b.LEVEL_ID = '".$LEVEL_ID."'  ";
}

 
$sql_get_value .= "  ORDER BY a.ORG_SEQ ASC, b.POS_ID ASC, d.TYPE_SEQ ASC ";
  //echo "xx".$sql_get_value;
 
		$query_who = $db->query($sql_get_value); 
		$sum_all = $db->db_num_rows($query_who); 
             while($rec1 = $db->db_fetch_array($query_who)){
			 
		$sql = " select a.per_id,a.PER_FIRSTNAME_TH,a.PER_LASTNAME_TH,b.prefix_name_th,a.PER_IDCARD , d.EL_NAME_TH,e.ed_name_th,f.em_name_th,g.ins_name_th,g.COUNTRY_ID,a.PER_DATE_BIRTH,a.PER_DATE_ENTRANCE,a.PER_SALARY,a.PER_SALARY_POSITION
 from  PER_PROFILE a 
		LEFT JOIN SETUP_PREFIX b ON a.prefix_id = b.prefix_id 
		LEFT JOIN PER_EDUCATEHIS c ON a.per_id = c.per_id
    LEFT JOIN SETUP_EDU_LEVEL d ON c.EL_id = d.EL_ID
    LEFT JOIN SETUP_EDU_DEGREE e ON c.ed_id = e.ed_id
    LEFT JOIN SETUP_EDU_MAJOR f ON c.em_id = f.em_id
	LEFT JOIN SETUP_EDU_INSTITUTE g ON c.INS_ID = g.INS_id 
		
		 where a.POS_NO = ".$rec1['POS_NO']." AND a.ACTIVE_STATUS = 1 ".$wh_pt_id;
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
		$COUNTRY_id = (int)$rec2['COUNTRY_ID'];
		if($COUNTRY_id > 0 ){ 
		$sql = " select COUNTRY_NAME_TH from SETUP_COUNTRY where COUNTRY_ID = ".$COUNTRY_id." ";
		$query_country = $db->query($sql); 
		 $rec3 = $db->db_fetch_array($query_country);
		 $country_name = text(wordwrap($rec3['COUNTRY_NAME_TH']));
		}
		
		$scholar_name = "";
		$movement_type = "";
		$movement_date = "";
		$per_id = (int)$rec3['PER_ID'];
		if($per_id > 0 ){ 
		$sql = " select SCHOLAR_PROJECT_NAME from PER_SCHOLARHIS where PER_ID = ".$per_id." ";
		$query_scholar = $db->query($sql); 
		 $rec4 = $db->db_fetch_array($query_scholar);
		 $scholar_name = text(wordwrap($rec4['SCHOLAR_PROJECT_NAME']));
		 
		$sql = " select b.MOVEMENT_TYPE,a.CONTACT_SDATE
		from PER_POSITIONHIS a 
		LEFT JOIN SETUP_MOVEMENT b ON a.MOVEMENT_ID = b.MOVEMENT_ID
		where a.PER_ID = ".$per_id." ";
		$query_movement = $db->query($sql); 
		 $rec5 = $db->db_fetch_array($query_movement);
		 $movement_name = text(wordwrap($rec5['SCHOLAR_PROJECT_NAME']));
		 $movement_date = conv_date($rec5['CONTACT_SDATE'],'short');  
		}
        
        $line_id_is =(int)$rec1['line_id'];
		
		$ORG_NAME_TH_is = text($rec1['ORG_NAME_TH']);
		$POS_ID_is = $rec1['POS_ID'];
		$LINE_NAME_TH_is  = text($rec1['LINE_NAME_TH']);
		$TYPE_NAME_TH_is = text($rec1['TYPE_NAME_TH']);
		$LEVEL_SHORTNAME_EN_is = text($rec1['LEVEL_SHORTNAME_EN']);
		$LINE_NAME_TH_is =  text($rec1['LINE_NAME_TH']);
		$OT_NAME_TH_is = text($rec1['OT_NAME_TH']);
		$PROV_TH_NAME_is = text($rec1['PROV_TH_NAME']);
		
 
    
		$list[$start_no] = array($ORG_NAME_TH_is, $POS_ID_is,$LINE_NAME_TH_is,$TYPE_NAME_TH_is,$LEVEL_SHORTNAME_EN_is,$LINE_NAME_TH_is,$temp_skill,$OT_NAME_TH_is,$PROV_TH_NAME_is,$pos_status,$man_prefix,$man_fname,$man_lname,$man_idcard,$man_gender,$man_birth,$man_startdate,$man_salary,$mansalaryposition,$man_education,$man_edu_degree,$man_edu_major,$man_edu_institutte,$country_name,$scholar_name,$movement_type,$movement_date);
		
		echo $ORG_NAME_TH_is.",";
		echo $POS_ID_is.",";
		echo $LINE_NAME_TH_is.",";
		echo $TYPE_NAME_TH_is.",";
		echo $LEVEL_SHORTNAME_EN_is.",";
		echo $LINE_NAME_TH_is.",";
		echo $temp_skill.",";
		echo $OT_NAME_TH_is.",";
		echo $PROV_TH_NAME_is.",";
		echo $pos_status.",";
		echo $man_prefix.",";
		echo $man_fname.",";
		echo $man_lname.",";
		echo $man_idcard.",";
		echo $man_gender.",";
		echo $man_birth.",";
		echo $man_startdate.",";
		echo $man_salary.",";
		echo $mansalaryposition.",";
		echo $man_education.",";
		echo $man_edu_degree.",";
		echo $man_edu_major.",";
		echo $man_edu_institutte.",";
		echo $country_name.",";
		echo $scholar_name.",";
		echo $movement_type.",";
		echo $movement_date."\r\n";;
 		$start_no++;
		 
		 
 	  }
exit();
 
 
	/*
	    $filename = 'file.csv';

        $fp = fopen($filename, 'w');
		foreach ($list as $fields) {
			fputcsv($fp, $fields);
		}
		fclose($fp);
	*/
 ?>  
 
 
    