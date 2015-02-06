<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
$path_file=$path.'fileupload/profile_his/';

include($path."include/config_header_top.php");

//POST
$PENSION_ID = $_POST['PENSION_ID'];
$S_PENSION_IDCARD = str_replace("-","",$_POST['S_PENSION_IDCARD']);
$PENSION_TYPE_REQUEST_CIVIL = $_POST['PENSION_TYPE_REQUEST_CIVIL'];
$PENSION_TYPE_PENSION = $_POST['PENSION_TYPE_PENSION'];
$PENSION_TYPE_RECEIVE = $_POST['PENSION_TYPE_RECEIVE'];
$PENSION_RECEIVE_IDCARDS = $_POST['PENSION_RECEIVE_IDCARDS'];
$PENSION_RECEIVE_PREFIX = $_POST['PENSION_RECEIVE_PREFIX'];
$PENSION_RECEIVE_FIRSTNAME_TH = $_POST['PENSION_RECEIVE_FIRSTNAME_TH'];
$PENSION_RECEIVE_MIDNAME_TH = $_POST['PENSION_RECEIVE_MIDNAME_TH'];
$PENSION_RECEIVE_LASTNAME_TH = $_POST['PENSION_RECEIVE_LASTNAME_TH'];
$PENSION_RECEIVE_ADDR_ROOM_NO = $_POST['PENSION_RECEIVE_ADDR_ROOM_NO'];
$PENSION_RECEIVE_ADDR_BUILDING = $_POST['PENSION_RECEIVE_ADDR_BUILDING'];
$PENSION_RECEIVE_ADDR_HOMENO = $_POST['PENSION_RECEIVE_ADDR_HOMENO'];
$PENSION_RECEIVE_ADDR_MOO = $_POST['PENSION_RECEIVE_ADDR_MOO'];
$PENSION_RECEIVE_ADDR_VILLAGE = $_POST['PENSION_RECEIVE_ADDR_VILLAGE'];
$PENSION_RECEIVE_ADDR_SOI = $_POST['PENSION_RECEIVE_ADDR_SOI'];
$PENSION_RECEIVE_ADDR_ROAD = $_POST['PENSION_RECEIVE_ADDR_ROAD'];
$PENSION_RECEIVE_ADDR_PROV_ID = $_POST['PENSION_RECEIVE_ADDR_PROV_ID'];
$PENSION_RECEIVE_ADDR_AMPR_ID = $_POST['PENSION_RECEIVE_ADDR_AMPR_ID'];
$PENSION_RECEIVE_ADDR_TAMB_ID = $_POST['PENSION_RECEIVE_ADDR_TAMB_ID'];
$PENSION_RECEIVE_ADDR_POSTCODE = $_POST['PENSION_RECEIVE_ADDR_POSTCODE'];
$PENSION_RECEIVE_ADDR_TEL = $_POST['PENSION_RECEIVE_ADDR_TEL'];
$PENSION_RECEIVE_ADDR_FAX = $_POST['PENSION_RECEIVE_ADDR_FAX'];
$PENSION_RECEIVE_ADDR_MOBILE = $_POST['PENSION_RECEIVE_ADDR_MOBILE'];
$PENSION_RECEIVE_ADDR_EMAIL = $_POST['PENSION_RECEIVE_ADDR_EMAIL'];
$PENSION_BANK_ID = $_POST['PENSION_BANK_ID'];
$PENSION_BANK_BRANCH = $_POST['PENSION_BANK_BRANCH'];
$PENSION_BANK_NO = $_POST['PENSION_BANK_NO'];
$PENSION_BANK_NAME = $_POST['PENSION_BANK_NAME'];

$table = "PENSION_MAIN";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				"PENSION_TYPE_REQUEST_CIVIL" => $PENSION_TYPE_REQUEST_CIVIL,
				"PENSION_TYPE_PENSION" => ctext($PENSION_TYPE_PENSION),
				"PENSION_TYPE_RECEIVE" => ctext($PENSION_TYPE_RECEIVE),
				"PENSION_RECEIVE_IDCARDS" => ctext(str_replace("-","",$PENSION_RECEIVE_IDCARDS)),
				"PENSION_RECEIVE_PREFIX" => ctext($PENSION_RECEIVE_PREFIX),
				"PENSION_RECEIVE_FIRSTNAME_TH" => ctext($PENSION_RECEIVE_FIRSTNAME_TH),
				"PENSION_RECEIVE_MIDNAME_TH" => ctext($PENSION_RECEIVE_MIDNAME_TH),
				"PENSION_RECEIVE_LASTNAME_TH" => ctext($PENSION_RECEIVE_LASTNAME_TH),
				"PENSION_RECEIVE_ADDR_ROOM_NO" => ctext($PENSION_RECEIVE_ADDR_ROOM_NO),
				"PENSION_RECEIVE_ADDR_BUILDING" => ctext($PENSION_RECEIVE_ADDR_BUILDING),
				"PENSION_RECEIVE_ADDR_HOMENO" => ctext($PENSION_RECEIVE_ADDR_HOMENO),
				"PENSION_RECEIVE_ADDR_MOO" => ctext($PENSION_RECEIVE_ADDR_MOO),
				"PENSION_RECEIVE_ADDR_VILLAGE" => ctext($PENSION_RECEIVE_ADDR_VILLAGE),
				"PENSION_RECEIVE_ADDR_SOI" => ctext($PENSION_RECEIVE_ADDR_SOI),
				"PENSION_RECEIVE_ADDR_ROAD" => ctext($PENSION_RECEIVE_ADDR_ROAD),
				"PENSION_RECEIVE_ADDR_PROV_ID" => ctext($PENSION_RECEIVE_ADDR_PROV_ID),
				"PENSION_RECEIVE_ADDR_AMPR_ID" => ctext($PENSION_RECEIVE_ADDR_AMPR_ID),
				"PENSION_RECEIVE_ADDR_TAMB_ID" => ctext($PENSION_RECEIVE_ADDR_TAMB_ID),
				"PENSION_RECEIVE_ADDR_POSTCODE" => ctext($PENSION_RECEIVE_ADDR_POSTCODE),
				"PENSION_RECEIVE_ADDR_TEL" => ctext(str_replace("-","",$PENSION_RECEIVE_ADDR_TEL)),
				"PENSION_RECEIVE_ADDR_FAX" => ctext(str_replace("-","",$PENSION_RECEIVE_ADDR_FAX)),
				"PENSION_RECEIVE_ADDR_MOBILE" => ctext($PENSION_RECEIVE_ADDR_MOBILE),
				"PENSION_RECEIVE_ADDR_EMAIL" => ctext($PENSION_RECEIVE_ADDR_EMAIL),
				"PENSION_BANK_ID" => ctext($PENSION_BANK_ID),
				"PENSION_BANK_BRANCH" => ctext($PENSION_BANK_BRANCH),
				"PENSION_BANK_NO" => ctext($PENSION_BANK_NO),
				"PENSION_BANK_NAME" => ctext($PENSION_BANK_NAME),
				
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update($table, $fields, " PENSION_IDCARD = '".$S_PENSION_IDCARD."' "); 
			
			$field_per = array("PENSION_STATUS" => 2);
			$db->db_update("PER_PROFILE", $field_per, " PER_IDCARD = '".$S_PENSION_IDCARD."' "); 
			
			//ข้อมูลประวัติการรับราชการปกติ
			$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "ORG_NAME_TH");
			
			$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "ORG_NAME_TH");
			$arr_line_th = GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", " ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LEVEL_NAME_TH");
			$arr_line_en = GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_EN", "SETUP_POS_LEVEL", " ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LEVEL_NAME_TH");
			
			for($i = 0; $i <= $ROW_COUNT_POSHIS; $i++){
				if(empty($_POST["POSHIS_NO".$i])){
					continue;	
				}
				
				$FILE_UPLOAD = '';
				if($_FILES["POSHIS_FILE".$i]['name'] != '' || $_FILES["POSHIS_FILE".$i]['name'] != NULL){
					$FILE_UPLOAD = getFilenameUplaod($_FILES["POSHIS_FILE".$i], $path_file, $_POST["OLD_POSHIS_FILE".$i]);
				}
				$sql="select (case when MAX(POSHIS_SEQ)>0 then (MAX(POSHIS_SEQ)+1) else '1' end) as POSHIS_SEQ  from PENSION_POSITIONHIS where PER_ID='".$PER_ID."' ";
				$POSHIS_SEQ = $db->get_data_field($sql,"POSHIS_SEQ");
				
				unset($fields);
				$fields = array(
					"PER_ID" => $PER_ID,
					"POSHIS_SEQ" => $POSHIS_SEQ,
					"POSHIS_POS_NO" => $POSTYPE_ID == "1" ? $_POST["POSHIS_NO".$i]:"",
					"POSHIS_EMP_NO" => $POSTYPE_ID == "3" ? $_POST["POSHIS_NO".$i]:"",
					"POSHIS_EMPSER_NO" => $$POSTYPE_ID == "5" ? $_POST["POSHIS_NO".$i]:"",
					"POSHIS_EMPSER_YEAR" => '',
					"POSHIS_TYPE_ID" => $_POST["POSHIS_TYPE_ID".$i],
					"POSHIS_LEVEL_ID" => $_POST["POSHIS_LEVEL_ID".$i],
					"POSHIS_LINE_ID" => $_POST["POSHIS_LINE_ID".$i],
					"POSHIS_MANAGE_ID" => $_POST["POSHIS_MANAGE_ID".$i],
					
					//"POSHIS_ORG_ID_1" => $_POST["POSHIS_ORG_ID1".$i],
					
					"POSHIS_ORG_ID_2" => $_POST["POSHIS_ORG_ID2".$i],
					"POSHIS_ORG_ID_3" => $_POST["POSHIS_ORG_ID3".$i],
					"POSHIS_ORG_ID_4" => $_POST["POSHIS_ORG_ID4".$i],
					
					//"POSHIS_ORG_ID_5" => $_POST["POSHIS_ORG_ID5".$i],
					//"ORG_NAME_TH_1" => $arr_org[$_POST["POSHIS_ORG_ID1".$i]],
					
					"ORG_NAME_TH_2" => ctext($arr_org[$_POST["POSHIS_ORG_ID2".$i]]),
					"ORG_NAME_TH_3" => ctext($arr_org[$_POST["POSHIS_ORG_ID3".$i]]),
					"ORG_NAME_TH_4" => ctext($arr_org[$_POST["POSHIS_ORG_ID4".$i]]),
					
					//"ORG_NAME_TH_5" => $arr_org[$_POST["POSHIS_ORG_ID5".$i]],
					
					"POSHIS_TITLE_NAME_TH" => ctext($arr_line_th[$_POST["POSHIS_LINE_ID".$i]]),
					"POSHIS_TITLE_NAME_EN" => ctext($arr_line_en[$_POST["POSHIS_LINE_ID".$i]]),
					"POSHIS_SDATE" => conv_date_db($_POST["POSHIS_SDATE".$i]),
					"POSHIS_EDATE" => conv_date_db($_POST["POSHIS_EDATE".$i]),
					
					//"POSHIS_TYPE_LIVE" => 1,
					//"POSHIS_TYPE_MOVE" => 3,
					
					"POSHIS_NOTE" => '',
					"POSHIS_YEAR" => $_POST["POSHIS_YEAR".$i],
					"POSHIS_MONTH" => $_POST["POSHIS_MONTH".$i],
					"POSHIS_DAY" => $_POST["POSHIS_DAY".$i],
					"POSHIS_INPUT_TYPE" => 2,
					"POSHIS_INPUT_RESULT" => 1,
					
					"ACTIVE_STATUS" => 1,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
					"UPDATE_DATE" => $TIMESTAMP,
					"DELETE_FLAG" => '0'
				);
				
				if(!empty($FILE_UPLOAD)){
					$fields["POSHIS_FILE"] = $FILE_UPLOAD;
				}else{
					$fields["POSHIS_FILE"] = $_POST["OLD_POSHIS_FILE".$i];
				}
				
				$db->db_insert("PENSION_POSITIONHIS", $fields); 
			}
			
			for($i = 0; $i <= $ROW_COUNT_MULTI; $i++){
				if(empty($_POST["MULTIME_ID".$i])){
					continue;	
				}
				
				$FILE_UPLOAD = '';
				if($_FILES["MULTI_FILE".$i]['name'] != '' || $_FILES["MULTI_FILE".$i]['name'] != NULL){
					$FILE_UPLOAD = getFilenameUplaod($_FILES["MULTI_FILE".$i], $path_file, $_POST["OLD_MULTI_FILE".$i]);
				}
				
				$sql="SELECT (CASE WHEN MAX(MULTI_SEQ)>0 THEN (MAX(MULTI_SEQ)+1) ELSE '1' END) AS MULTI_SEQ  FROM PENSION_MULTITIME WHERE PER_ID='".$PER_ID."' ";
				$MULTI_SEQ = $db->get_data_field($sql,"MULTI_SEQ");
				$PER_PROFILE = $db->get_data_rec("SELECT * FROM PER_PROFILE WHERE PER_ID='".$PER_ID."' ");
				$SETUP_MULTITIME = $db->get_data_rec("SELECT * FROM SETUP_MULTITIME WHERE MULTIME_ID='".$_POST["MULTIME_ID".$i]."' ");
				
				unset($fields);
				$fields = array(
					"PER_ID" => $PER_ID,
					"MULTI_SEQ" => $MULTI_SEQ,
					
					"TYPE_ID" => $PER_PROFILE["TYPE_ID"],
					"LEVEL_ID" => $PER_PROFILE["LEVEL_ID"],
					"LINE_ID" => $PER_PROFILE["LINE_ID"],
					"MANAGE_ID" => $PER_PROFILE["MANAGE_ID"],
					"ORG_ID_1" => $PER_PROFILE["ORG_ID_1"],
					"ORG_ID_2" => $PER_PROFILE["ORG_ID_2"],
					"ORG_ID_3" => $PER_PROFILE["ORG_ID_3"],
					"ORG_ID_4" => $PER_PROFILE["ORG_ID_4"],
					"ORG_ID_5" => $PER_PROFILE["ORG_ID_5"],
					"ORG_NAME_TH_1" => ctext($arr_org[$PER_PROFILE["ORG_ID_1"]]),
					"ORG_NAME_TH_2" => ctext($arr_org[$PER_PROFILE["ORG_ID_2"]]),
					"ORG_NAME_TH_3" => ctext($arr_org[$PER_PROFILE["ORG_ID_3"]]),
					"ORG_NAME_TH_4" => ctext($arr_org[$PER_PROFILE["ORG_ID_4"]]),
					"ORG_NAME_TH_5" => ctext($arr_org[$PER_PROFILE["ORG_ID_5"]]),
					
					//"MULTI_FRAC" => $_POST["MULTI_FRAC".$i],
					//"MULTI_BALANCE" => $_POST["MULTI_BALANCE".$i],
					//"MULTI_NOTE" => $_POST["MULTI_NOTE".$i],
					
					"MULTI_YEAR" => $SETUP_MULTITIME["MULTITIME_YEAR"],
					"MULTI_MONTH" => $SETUP_MULTITIME["MULTITIME_MONTH"],
					"MULTI_DAY" => $SETUP_MULTITIME["MULTITIME_DAY"],
					
					"MULTI_INPUT_TYPE" => 2,
					"MULTI_INPUT_RESULT" => 1,
					
					"ACTIVE_STATUS" => 1,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
					"UPDATE_DATE" => $TIMESTAMP,
					"DELETE_FLAG" => '0'
				);
				
				if(!empty($FILE_UPLOAD)){
					$fields["MULTI_FILE"] = $FILE_UPLOAD;
				}else{
					$fields["MULTI_FILE"] = $_POST["OLD_MULTI_FILE".$i];
				}
				
				$db->db_insert("PENSION_MULTITIME", $fields); 
			}
			
			for($i = 0; $i <= $ROW_COUNT_UPSALARY; $i++){
				if(empty($_POST["UPS_SALARY".$i])){
					continue;	
				}
				
				$FILE_UPLOAD = '';
				if($_FILES["UPS_FILE".$i]['name'] != '' || $_FILES["UPS_FILE".$i]['name'] != NULL){
					$FILE_UPLOAD = getFilenameUplaod($_FILES["UPS_FILE".$i], $path_file, $_POST["OLD_UPS_FILE".$i]);
				}
				
				$sql="SELECT (CASE WHEN MAX(UPS_SEQ)>0 THEN (MAX(UPS_SEQ)+1) ELSE '1' END) AS UPS_SEQ  FROM PENSION_UPSALARY WHERE PER_ID = '".$PER_ID."' ";
				$UPS_SEQ = $db->get_data_field($sql,"UPS_SEQ");
				$PER_PROFILE = $db->get_data_rec("SELECT * FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."' ");
				$PENSION_UPSALARY = $db->get_data_rec("SELECT * FROM PENSION_UPSALARY WHERE PER_ID = '".$PER_ID."' AND UPS_EFFECTIVE_DATE = (SELECT MAX(UPS_EFFECTIVE_DATE) AS UPS_EFFECTIVE_DATE FROM PENSION_UPSALARY WHERE PER_ID = '".$PER_ID."') ");
				
				unset($fields);
				$fields = array(
					"PER_ID" => $PER_ID,
					"UPS_SEQ" => $UPS_SEQ,
					
					"TYPE_ID" => $PER_PROFILE["TYPE_ID"],
					"LEVEL_ID" => $PER_PROFILE["LEVEL_ID"],
					"LINE_ID" => $PER_PROFILE["LINE_ID"],
					"MANAGE_ID" => $PER_PROFILE["MANAGE_ID"],
					"ORG_ID_1" => $PER_PROFILE["ORG_ID_1"],
					"ORG_ID_2" => $PER_PROFILE["ORG_ID_2"],
					"ORG_ID_3" => $PER_PROFILE["ORG_ID_3"],
					"ORG_ID_4" => $PER_PROFILE["ORG_ID_4"],
					"ORG_ID_5" => $PER_PROFILE["ORG_ID_5"],
					"ORG_NAME_TH_1" => ctext($arr_org[$PER_PROFILE["ORG_ID_1"]]),
					"ORG_NAME_TH_2" => ctext($arr_org[$PER_PROFILE["ORG_ID_2"]]),
					"ORG_NAME_TH_3" => ctext($arr_org[$PER_PROFILE["ORG_ID_3"]]),
					"ORG_NAME_TH_4" => ctext($arr_org[$PER_PROFILE["ORG_ID_4"]]),
					"ORG_NAME_TH_5" => ctext($arr_org[$PER_PROFILE["ORG_ID_5"]]),
					
					"UPS_EFFECTIVE_DATE" => conv_date_db($_POST["UPS_EFFECTIVE_SDATE".$i]),
					"UPS_SALARY_LAST" => $PENSION_UPSALARY["UPS_SALARY_NEW"],
					"UPS_SALARY_NEW" => $_POST["UPS_SALARY".$i],
					
					"UPS_LEVEL_LAST" => $PENSION_UPSALARY["UPS_LEVEL_LAST"],
					
					//"UPS_LEVEL_NEW" => $_POST["UPS_LEVEL_NEW"],
					//"UPS_LEVEL_CHANGE" => $_POST["UPS_LEVEL_CHANGE"],
					
					"UPS_PERCENTAGE_CHANGE" => (($_POST["UPS_SALARY".$i] - $PENSION_UPSALARY["UPS_SALARY_NEW"]) / $PENSION_UPSALARY["UPS_SALARY_NEW"]) * 100,
					
					"UPS_INPUT_TYPE" => 2,
					"UPS_INPUT_RESULT" => 1,
					
					"ACTIVE_STATUS" => 1,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
					"UPDATE_DATE" => $TIMESTAMP,
					"DELETE_FLAG" => '0'
				);
				
				if(!empty($FILE_UPLOAD)){
					$fields["UPS_FILE"] = $FILE_UPLOAD;
				}else{
					$fields["UPS_FILE"] = $_POST["OLD_UPS_FILE".$i];
				}
				
				$db->db_insert("PENSION_UPSALARY", $fields); 
			}
			
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "edit" : 
		try{
			unset($fields);
			$fields = array(
				"PENSION_TYPE_REQUEST_CIVIL" => $PENSION_TYPE_REQUEST_CIVIL,
				"PENSION_TYPE_PENSION" => ctext($PENSION_TYPE_PENSION),
				"PENSION_TYPE_RECEIVE" => ctext($PENSION_TYPE_RECEIVE),
				"PENSION_RECEIVE_IDCARDS" => ctext(str_replace("-","",$PENSION_RECEIVE_IDCARDS)),
				"PENSION_RECEIVE_PREFIX" => ctext($PENSION_RECEIVE_PREFIX),
				"PENSION_RECEIVE_FIRSTNAME_TH" => ctext($PENSION_RECEIVE_FIRSTNAME_TH),
				"PENSION_RECEIVE_MIDNAME_TH" => ctext($PENSION_RECEIVE_MIDNAME_TH),
				"PENSION_RECEIVE_LASTNAME_TH" => ctext($PENSION_RECEIVE_LASTNAME_TH),
				"PENSION_RECEIVE_ADDR_ROOM_NO" => ctext($PENSION_RECEIVE_ADDR_ROOM_NO),
				"PENSION_RECEIVE_ADDR_BUILDING" => ctext($PENSION_RECEIVE_ADDR_BUILDING),
				"PENSION_RECEIVE_ADDR_HOMENO" => ctext($PENSION_RECEIVE_ADDR_HOMENO),
				"PENSION_RECEIVE_ADDR_MOO" => ctext($PENSION_RECEIVE_ADDR_MOO),
				"PENSION_RECEIVE_ADDR_VILLAGE" => ctext($PENSION_RECEIVE_ADDR_VILLAGE),
				"PENSION_RECEIVE_ADDR_SOI" => ctext($PENSION_RECEIVE_ADDR_SOI),
				"PENSION_RECEIVE_ADDR_ROAD" => ctext($PENSION_RECEIVE_ADDR_ROAD),
				"PENSION_RECEIVE_ADDR_PROV_ID" => ctext($PENSION_RECEIVE_ADDR_PROV_ID),
				"PENSION_RECEIVE_ADDR_AMPR_ID" => ctext($PENSION_RECEIVE_ADDR_AMPR_ID),
				"PENSION_RECEIVE_ADDR_TAMB_ID" => ctext($PENSION_RECEIVE_ADDR_TAMB_ID),
				"PENSION_RECEIVE_ADDR_POSTCODE" => ctext($PENSION_RECEIVE_ADDR_POSTCODE),
				"PENSION_RECEIVE_ADDR_TEL" => ctext(str_replace("-","",$PENSION_RECEIVE_ADDR_TEL)),
				"PENSION_RECEIVE_ADDR_FAX" => ctext(str_replace("-","",$PENSION_RECEIVE_ADDR_FAX)),
				"PENSION_RECEIVE_ADDR_MOBILE" => ctext($PENSION_RECEIVE_ADDR_MOBILE),
				"PENSION_RECEIVE_ADDR_EMAIL" => ctext($PENSION_RECEIVE_ADDR_EMAIL),
				"PENSION_BANK_ID" => ctext($PENSION_BANK_ID),
				"PENSION_BANK_BRANCH" => ctext($PENSION_BANK_BRANCH),
				"PENSION_BANK_NO" => ctext($PENSION_BANK_NO),
				"PENSION_BANK_NAME" => ctext($PENSION_BANK_NAME),
				
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update($table, $fields, " PENSION_ID = '".$PENSION_ID."' "); 
			
			//ข้อมูลประวัติการรับราชการปกติ
			$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "ORG_NAME_TH");
			
			$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "ORG_NAME_TH");
			$arr_line_th = GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", " ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LEVEL_NAME_TH");
			$arr_line_en = GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_EN", "SETUP_POS_LEVEL", " ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LEVEL_NAME_TH");
			
			$db->db_delete("PENSION_POSITIONHIS", " PER_ID = '".$PER_ID."' AND POSHIS_INPUT_TYPE = '2' ");
			
			for($i = 0; $i <= $ROW_COUNT_POSHIS; $i++){
				if(empty($_POST["POSHIS_NO".$i])){
					continue;
				}
				
				$FILE_UPLOAD = '';
				if($_FILES["POSHIS_FILE".$i]['name'] != '' || $_FILES["POSHIS_FILE".$i]['name'] != NULL){
					$FILE_UPLOAD = getFilenameUplaod($_FILES["POSHIS_FILE".$i], $path_file, $_POST["OLD_POSHIS_FILE".$i]);
				}
				
				$sql="select (case when MAX(POSHIS_SEQ)>0 then (MAX(POSHIS_SEQ)+1) else '1' end) as POSHIS_SEQ  from PENSION_POSITIONHIS where PER_ID='".$PER_ID."' ";
				$POSHIS_SEQ = $db->get_data_field($sql,"POSHIS_SEQ");
				
				unset($fields);
				$fields = array(
					"PER_ID" => $PER_ID,
					"POSHIS_SEQ" => $POSHIS_SEQ,
					"POSHIS_POS_NO" => $POSTYPE_ID == "1" ? $_POST["POSHIS_NO".$i]:"",
					"POSHIS_EMP_NO" => $POSTYPE_ID == "3" ? $_POST["POSHIS_NO".$i]:"",
					"POSHIS_EMPSER_NO" => $$POSTYPE_ID == "5" ? $_POST["POSHIS_NO".$i]:"",
					"POSHIS_EMPSER_YEAR" => '',
					"POSHIS_TYPE_ID" => $_POST["POSHIS_TYPE_ID".$i],
					"POSHIS_LEVEL_ID" => $_POST["POSHIS_LEVEL_ID".$i],
					"POSHIS_LINE_ID" => $_POST["POSHIS_LINE_ID".$i],
					"POSHIS_MANAGE_ID" => $_POST["POSHIS_MANAGE_ID".$i],
					
					//"POSHIS_ORG_ID_1" => $_POST["POSHIS_ORG_ID1".$i],
					
					"POSHIS_ORG_ID_2" => $_POST["POSHIS_ORG_ID2".$i],
					"POSHIS_ORG_ID_3" => $_POST["POSHIS_ORG_ID3".$i],
					"POSHIS_ORG_ID_4" => $_POST["POSHIS_ORG_ID4".$i],
					
					//"POSHIS_ORG_ID_5" => $_POST["POSHIS_ORG_ID5".$i],
					//"ORG_NAME_TH_1" => $arr_org[$_POST["POSHIS_ORG_ID1".$i]],
					
					"ORG_NAME_TH_2" => ctext($arr_org[$_POST["POSHIS_ORG_ID2".$i]]),
					"ORG_NAME_TH_3" => ctext($arr_org[$_POST["POSHIS_ORG_ID3".$i]]),
					"ORG_NAME_TH_4" => ctext($arr_org[$_POST["POSHIS_ORG_ID4".$i]]),
					
					//"ORG_NAME_TH_5" => $arr_org[$_POST["POSHIS_ORG_ID5".$i]],
					
					"POSHIS_TITLE_NAME_TH" => ctext($arr_line_th[$_POST["POSHIS_LINE_ID".$i]]),
					"POSHIS_TITLE_NAME_EN" => ctext($arr_line_en[$_POST["POSHIS_LINE_ID".$i]]),
					"POSHIS_SDATE" => conv_date_db($_POST["POSHIS_SDATE".$i]),
					"POSHIS_EDATE" => conv_date_db($_POST["POSHIS_EDATE".$i]),
					
					//"POSHIS_TYPE_LIVE" => 1,
					//"POSHIS_TYPE_MOVE" => 3,
					
					"POSHIS_NOTE" => '',
					"POSHIS_YEAR" => $_POST["POSHIS_YEAR".$i],
					"POSHIS_MONTH" => $_POST["POSHIS_MONTH".$i],
					"POSHIS_DAY" => $_POST["POSHIS_DAY".$i],
					"POSHIS_INPUT_TYPE" => 2,
					"POSHIS_INPUT_RESULT" => 1,
					
					"ACTIVE_STATUS" => 1,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
					"UPDATE_DATE" => $TIMESTAMP,
					"DELETE_FLAG" => '0'
				);
				
				if(!empty($FILE_UPLOAD)){
					$fields["POSHIS_FILE"] = $FILE_UPLOAD;
				}else{
					$fields["POSHIS_FILE"] = $_POST["OLD_POSHIS_FILE".$i];
				}
				
				$db->db_insert("PENSION_POSITIONHIS", $fields); 
			}
			
			$db->db_delete("PENSION_MULTITIME", " PER_ID = '".$PER_ID."' AND MULTI_INPUT_TYPE = '2' ");
			for($i = 0; $i <= $ROW_COUNT_MULTI; $i++){
				if(empty($_POST["MULTIME_ID".$i])){
					continue;	
				}
				
				$FILE_UPLOAD = '';
				if($_FILES["MULTI_FILE".$i]['name'] != '' || $_FILES["MULTI_FILE".$i]['name'] != NULL){
					$FILE_UPLOAD = getFilenameUplaod($_FILES["MULTI_FILE".$i], $path_file, $_POST["OLD_MULTI_FILE".$i]);
				}
				
				$sql="SELECT (CASE WHEN MAX(MULTI_SEQ)>0 THEN (MAX(MULTI_SEQ)+1) ELSE '1' END) AS MULTI_SEQ  FROM PENSION_MULTITIME WHERE PER_ID='".$PER_ID."' ";
				$MULTI_SEQ = $db->get_data_field($sql,"MULTI_SEQ");
				$PER_PROFILE = $db->get_data_rec("SELECT * FROM PER_PROFILE WHERE PER_ID='".$PER_ID."' ");
				$SETUP_MULTITIME = $db->get_data_rec("SELECT * FROM SETUP_MULTITIME WHERE MULTIME_ID='".$_POST["MULTIME_ID".$i]."' ");
				
				unset($fields);
				$fields = array(
					"PER_ID" => $PER_ID,
					"MULTI_SEQ" => $MULTI_SEQ,
					
					"TYPE_ID" => $PER_PROFILE["TYPE_ID"],
					"LEVEL_ID" => $PER_PROFILE["LEVEL_ID"],
					"LINE_ID" => $PER_PROFILE["LINE_ID"],
					"MANAGE_ID" => $PER_PROFILE["MANAGE_ID"],
					"ORG_ID_1" => $PER_PROFILE["ORG_ID_1"],
					"ORG_ID_2" => $PER_PROFILE["ORG_ID_2"],
					"ORG_ID_3" => $PER_PROFILE["ORG_ID_3"],
					"ORG_ID_4" => $PER_PROFILE["ORG_ID_4"],
					"ORG_ID_5" => $PER_PROFILE["ORG_ID_5"],
					"ORG_NAME_TH_1" => ctext($arr_org[$PER_PROFILE["ORG_ID_1"]]),
					"ORG_NAME_TH_2" => ctext($arr_org[$PER_PROFILE["ORG_ID_2"]]),
					"ORG_NAME_TH_3" => ctext($arr_org[$PER_PROFILE["ORG_ID_3"]]),
					"ORG_NAME_TH_4" => ctext($arr_org[$PER_PROFILE["ORG_ID_4"]]),
					"ORG_NAME_TH_5" => ctext($arr_org[$PER_PROFILE["ORG_ID_5"]]),
					
					"MULTIME_ID" => $_POST["MULTIME_ID".$i],
					
					//"MULTI_FRAC" => $_POST["MULTI_FRAC".$i],
					
					"MULTI_BALANCE" => 1,
					
					//"MULTI_NOTE" => $_POST["MULTI_NOTE".$i],
					
					"MULTI_YEAR" => $SETUP_MULTITIME["MULTITIME_YEAR"],
					"MULTI_MONTH" => $SETUP_MULTITIME["MULTITIME_MONTH"],
					"MULTI_DAY" => $SETUP_MULTITIME["MULTITIME_DAY"],
					
					"MULTI_INPUT_TYPE" => 2,
					"MULTI_INPUT_RESULT" => 1,
					
					"ACTIVE_STATUS" => 1,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
					"UPDATE_DATE" => $TIMESTAMP,
					"DELETE_FLAG" => '0'
				);
				
				if(!empty($FILE_UPLOAD)){
					$fields["MULTI_FILE"] = $FILE_UPLOAD;
				}else{
					$fields["MULTI_FILE"] = $_POST["OLD_MULTI_FILE".$i];
				}
				
				$db->db_insert("PENSION_MULTITIME", $fields); 
			}
			
			$db->db_delete("PENSION_UPSALARY", " PER_ID = '".$PER_ID."' AND UPS_INPUT_TYPE = '2' ");
			for($i = 0; $i <= $ROW_COUNT_UPSALARY; $i++){
				if(empty($_POST["UPS_SALARY".$i])){
					continue;	
				}
				
				$FILE_UPLOAD = '';
				if($_FILES["UPS_FILE".$i]['name'] != '' || $_FILES["UPS_FILE".$i]['name'] != NULL){
					$FILE_UPLOAD = getFilenameUplaod($_FILES["UPS_FILE".$i], $path_file, $_POST["OLD_UPS_FILE".$i]);
				}
				
				$sql="SELECT (CASE WHEN MAX(UPS_SEQ)>0 THEN (MAX(UPS_SEQ)+1) ELSE '1' END) AS UPS_SEQ  FROM PENSION_UPSALARY WHERE PER_ID = '".$PER_ID."' ";
				$UPS_SEQ = $db->get_data_field($sql,"UPS_SEQ");
				$PER_PROFILE = $db->get_data_rec("SELECT * FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."' ");
				$PENSION_UPSALARY = $db->get_data_rec("SELECT * FROM PENSION_UPSALARY WHERE PER_ID = '".$PER_ID."' AND UPS_EFFECTIVE_DATE = (SELECT MAX(UPS_EFFECTIVE_DATE) AS UPS_EFFECTIVE_DATE FROM PENSION_UPSALARY WHERE PER_ID = '".$PER_ID."') ");
				
				unset($fields);
				$fields = array(
					"PER_ID" => $PER_ID,
					"UPS_SEQ" => $UPS_SEQ,
					
					"TYPE_ID" => $PER_PROFILE["TYPE_ID"],
					"LEVEL_ID" => $PER_PROFILE["LEVEL_ID"],
					"LINE_ID" => $PER_PROFILE["LINE_ID"],
					"MANAGE_ID" => $PER_PROFILE["MANAGE_ID"],
					"ORG_ID_1" => $PER_PROFILE["ORG_ID_1"],
					"ORG_ID_2" => $PER_PROFILE["ORG_ID_2"],
					"ORG_ID_3" => $PER_PROFILE["ORG_ID_3"],
					"ORG_ID_4" => $PER_PROFILE["ORG_ID_4"],
					"ORG_ID_5" => $PER_PROFILE["ORG_ID_5"],
					"ORG_NAME_TH_1" => ctext($arr_org[$PER_PROFILE["ORG_ID_1"]]),
					"ORG_NAME_TH_2" => ctext($arr_org[$PER_PROFILE["ORG_ID_2"]]),
					"ORG_NAME_TH_3" => ctext($arr_org[$PER_PROFILE["ORG_ID_3"]]),
					"ORG_NAME_TH_4" => ctext($arr_org[$PER_PROFILE["ORG_ID_4"]]),
					"ORG_NAME_TH_5" => ctext($arr_org[$PER_PROFILE["ORG_ID_5"]]),
					
					"UPS_EFFECTIVE_DATE" => conv_date_db($_POST["UPS_EFFECTIVE_SDATE".$i]),
					"UPS_SALARY_LAST" => $PENSION_UPSALARY["UPS_SALARY_NEW"],
					"UPS_SALARY_NEW" => $_POST["UPS_SALARY".$i],
					
					"UPS_LEVEL_LAST" => $PENSION_UPSALARY["UPS_LEVEL_LAST"],
					
					//"UPS_LEVEL_NEW" => $_POST["UPS_LEVEL_NEW"],
					//"UPS_LEVEL_CHANGE" => $_POST["UPS_LEVEL_CHANGE"],
					
					"UPS_PERCENTAGE_CHANGE" => (($_POST["UPS_SALARY".$i] - $PENSION_UPSALARY["UPS_SALARY_NEW"]) / $PENSION_UPSALARY["UPS_SALARY_NEW"]) * 100,
					
					"UPS_INPUT_TYPE" => 2,
					"UPS_INPUT_RESULT" => 1,
					
					"ACTIVE_STATUS" => 1,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
					"UPDATE_DATE" => $TIMESTAMP,
					"DELETE_FLAG" => '0'
				);
				
				if(!empty($FILE_UPLOAD)){
					$fields["UPS_FILE"] = $FILE_UPLOAD;
				}else{
					$fields["UPS_FILE"] = $_POST["OLD_UPS_FILE".$i];
				}
				
				$db->db_insert("PENSION_UPSALARY", $fields); 
			}
			
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{
			$db->db_delete("PENSION_POSITIONHIS", " PER_ID = '".$PER_ID."' AND POSHIS_INPUT_TYPE = '2' ");
			$db->db_delete("PENSION_MULTITIME", " PER_ID = '".$PER_ID."' AND MULTI_INPUT_TYPE = '2' ");
			$db->db_delete("PENSION_UPSALARY", " PER_ID = '".$PER_ID."' AND UPS_INPUT_TYPE = '2' ");
			
			$fields = array("DELETE_FLAG" => 1);
			$db->db_update($table, $fields, " PENSION_ID = '".$PENSION_ID."' ");
			
			$fields_per = array("PENSION_STATUS" => 1);
			$db->db_update("PER_PROFILE", $fields_per, " PER_ID = '".$PER_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
}
$url_back="../pension_request_record_disp.php";
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
