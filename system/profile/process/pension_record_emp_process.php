<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
$path_a='../../../fileupload/file_pension/'; 
include($path."include/config_header_top.php");
$url_back="../pension_record_emp_disp.php";
//POST
$PENSION_ID = $_POST['PENSION_ID'];
$PER_ID = $_POST['PER_ID'];
$PENSION_TIME = $_POST['PENSION_TIME'];
$PENSION_DATE = conv_date_db($_POST['PENSION_DATE']);
$PENSION_TYPE_RESIGN = $_POST['PENSION_TYPE_RESIGN'];
$PENSION_TYPE_PENSION = $_POST['PENSION_TYPE_PENSION'];
$PENSION_TYPE_RECEIVER = $_POST['PENSION_TYPE_RECEIVER'];

$ARR_POSHIS_SDATE = $_POST['POSHIS_SDATE'];
$ARR_POSHIS_EDATE = $_POST['POSHIS_EDATE'];
$ARR_POSHIS_YEAR = $_POST['POSHIS_YEAR'];
$ARR_POSHIS_MONTH  = $_POST['POSHIS_MONTH'];
$ARR_POSHIS_DAY = $_POST['POSHIS_DAY'];

$ARR_MULTI_ID = $_POST['MULTI_ID'];
$ARR_MULTITIME_ID = $_POST['MULTITIME_ID'];
$ARR_MULTI_SDATE = $_POST['MULTI_SDATE'];
$ARR_MULTI_EDATE = $_POST['MULTI_EDATE'];
$ARR_MULTI_FRAC = $_POST['MULTI_FRAC'];
$ARR_MULTI_YEAR = $_POST['MULTI_YEAR'];
$ARR_MULTI_MONTH = $_POST['MULTI_MONTH'];
$ARR_MULTI_DAY = $_POST['MULTI_DAY'];

$PENSION_YEAR = $_POST['PENSION_YEAR'];
$PENSION_MONTH = $_POST['PENSION_MONTH'];
$PENSION_DAY = $_POST['PENSION_DAY'];

//ใช้ร่วมกัน
$PENSION_SALARY = str_replace(',','',$_POST['PENSION_SALARY']);
$PENSION_ALL = str_replace(',','',$_POST['PENSION_ALL']);
$SALARY_ALL = str_replace(',','',$_POST['SALARY_ALL']);
$PENSION_MONTHLY = str_replace(',','',$_POST['PENSION_MONTHLY']);
//END ใช้ร่วมกัน



//DIV 4
$LEGENCY_ALL = str_replace(',','',$_POST['LEGENCY_ALL']);
$BONUSTIME_ALL = str_replace(',','',$_POST['BONUSTIME_ALL']);
$BONUSTIME_RECEIVE = $_POST['BONUSTIME_RECEIVE'];
$BONUSTIME_AMOUNT = str_replace(',','',$_POST['BONUSTIME_AMOUNT']);
$BONUSTIME_BALANCE = str_replace(',','',$_POST['BONUSTIME_BALANCE']);
$LEGENCY_BALANCE = str_replace(',','',$_POST['LEGENCY_BALANCE']);
//DIV 4
//DIV 5
$PENSION_TYPE_RECEIVE = $_POST['PENSION_TYPE_RECEIVE'];
$FAMILY_ID = $_POST['FAMILY_ID'];
$RECEIVER_IDCARD = str_replace('-','',$_POST['RECEIVER_IDCARD']);
$RECEIVER_PREFIX_ID = $_POST['RECEIVER_PREFIX_ID'];
$RECEIVER_FIRSTNAME_TH = ctext($_POST['RECEIVER_FIRSTNAME_TH']);
$RECEIVER_MIDNAME_TH = ctext($_POST['RECEIVER_MIDNAME_TH']);
$RECEIVER_LASTNAME_TH = ctext($_POST['RECEIVER_LASTNAME_TH']);
$PENSION_TYPE_DELEGATE = $_POST['PENSION_TYPE_DELEGATE'];
$DELEGATE_IDCARD = str_replace('-','',$_POST['DELEGATE_IDCARD']);
$DELEGATE_PREFIX_ID = $_POST['DELEGATE_PREFIX_ID'];
$DELEGATE_FIRSTNAME_TH = ctext($_POST['DELEGATE_FIRSTNAME_TH']);
$DELEGATE_MIDNAME_TH = ctext($_POST['DELEGATE_MIDNAME_TH']);
$DELEGATE_LASTNAME_TH = ctext($_POST['DELEGATE_LASTNAME_TH']);
//END DIV 5
//DIV 6
$ADDRESS_COUNTRY_ID = $_POST['ADDRESS_COUNTRY_ID'];
$ADDRESS_CITY = ctext($_POST['ADDRESS_CITY']);
$ADDRESS_ROOM_NO = ctext($_POST['ADDRESS_ROOM_NO']);
$ADDRESS_FLOOR = ctext($_POST['ADDRESS_FLOOR']);
$ADDRESS_BUILDING = ctext($_POST['ADDRESS_BUILDING']);
$ADDRESS_HOME_NO = ctext($_POST['ADDRESS_HOME_NO']);
$ADDRESS_MOO = ctext($_POST['ADDRESS_MOO']);
$ADDRESS_VILLAGE = ctext($_POST['ADDRESS_VILLAGE']);
$ADDRESS_SOI = ctext($_POST['ADDRESS_SOI']);
$ADDRESS_ROAD = ctext($_POST['ADDRESS_ROAD']);
$ADDRESS_PROV_ID = $_POST['ADDRESS_PROV_ID'];
$ADDRESS_AMPR_ID = $_POST['ADDRESS_AMPR_ID'];
$ADDRESS_TAMB_ID = $_POST['ADDRESS_TAMB_ID'];
$ADDRESS_ZIPCODE = $_POST['ADDRESS_ZIPCODE'];
$ADDRESS_TEL = $_POST['ADDRESS_TEL'];
$ADDRESS_TEL_EXT = $_POST['ADDRESS_TEL_EXT'];
$ADDRESS_FAX = $_POST['ADDRESS_FAX'];
$ADDRESS_FAX_EXT = $_POST['ADDRESS_FAX_EXT'];
$ADDRESS_MOBILE = $_POST['ADDRESS_MOBILE'];
$ADDRESS_EMAIL = ctext($_POST['ADDRESS_EMAIL']);
//END DIV 6
//DIV 7
$BANK_ID = $_POST['BANK_ID'];
$BANK_BRANCH = ctext($_POST['BANK_BRANCH']);
$BANK_NO = ctext($_POST['BANK_NO']);
$BANK_NAME = ctext($_POST['BANK_NAME']);
//END DIV 7
//DIV 8
$ARR_FAMILY_ID_8 = $_POST['FAMILY_ID_8'];
$ARR_PENHEIR_CONTACT_FAMILY_SATUS_8 = $_POST['PENHEIR_CONTACT_FAMILY_SATUS_8'];
$ARR_PENHEIR_CONTACT_IDCARD_8 = $_POST['PENHEIR_CONTACT_IDCARD_8'];
$ARR_PENHEIR_CONTACT_PREFIX_ID_8 = $_POST['PENHEIR_CONTACT_PREFIX_ID_8'];
$ARR_PENHEIR_CONTACT_FIRSTNAME_TH_8 = $_POST['PENHEIR_CONTACT_FIRSTNAME_TH_8'];
$ARR_PENHEIR_CONTACT_MIDNAME_TH_8 = $_POST['PENHEIR_CONTACT_MIDNAME_TH_8'];
$ARR_PENHEIR_CONTACT_LASTNAME_TH_8 = $_POST['PENHEIR_CONTACT_LASTNAME_TH_8'];
$ARR_PENHEIR_CONTACT_RELATIONSHIP_8 = $_POST['PENHEIR_CONTACT_RELATIONSHIP_8'];
$ARR_PENHEIR_CONTACT_BANK_ID_8 = $_POST['PENHEIR_CONTACT_BANK_ID_8'];
$ARR_PENHEIR_CONTACT_BANK_BRANCH_8 = $_POST['PENHEIR_CONTACT_BANK_BRANCH_8'];
$ARR_PENHEIR_CONTACT_BANK_NO_8 = $_POST['PENHEIR_CONTACT_BANK_NO_8'];
$ARR_PENHEIR_CONTACT_BANK_NAME_8 = $_POST['PENHEIR_CONTACT_BANK_NAME_8'];
//END DIV 8
//DIV 9 
$ARR_HEIRDESC_ID_9 = $_POST['HEIRDESC_ID_9']; 
$ARR_PENHEIR_CONTACT_FRAMILY_STATUS_9 = $_POST['PENHEIR_CONTACT_FRAMILY_STATUS_9'];
$ARR_PENHEIR_CONTACT_IDCARD_9 = $_POST['PENHEIR_CONTACT_IDCARD_9'];
$ARR_PENHEIR_CONTACT_PREFIX_ID_9 = $_POST['PENHEIR_CONTACT_PREFIX_ID_9'];
$ARR_PENHEIR_CONTACT_FIRSTNAME_TH_9 = $_POST['PENHEIR_CONTACT_FIRSTNAME_TH_9'];
$ARR_PENHEIR_CONTACT_MIDNAME_TH_9 = $_POST['PENHEIR_CONTACT_MIDNAME_TH_9'];
$ARR_PENHEIR_CONTACT_LASTNAME_TH_9 = $_POST['PENHEIR_CONTACT_LASTNAME_TH_9'];
$ARR_PENHEIR_CONTACT_BANK_ID_9 = $_POST['PENHEIR_CONTACT_BANK_ID_9'];
$ARR_PENHEIR_CONTACT_BANK_BRANCH_9 = $_POST['PENHEIR_CONTACT_BANK_BRANCH_9'];
$ARR_PENHEIR_CONTACT_BANK_NO_9 = $_POST['PENHEIR_CONTACT_BANK_NO_9'];
$ARR_PENHEIR_CONTACT_BANK_NAME_9 = $_POST['PENHEIR_CONTACT_BANK_NAME_9'];
//END DIV 9
//DIV 10
$DIED_NO = ctext($_POST['DIED_NO']);
$DIED_DATE = conv_date_db($_POST['DIED_DATE']);
$DIED_SDATE  = conv_date_db($_POST['DIED_SDATE']);
$DIED_REASON = ctext($_POST['DIED_REASON']);
$DIED_PLACE = ctext($_POST['DIED_PLACE']);
$DIED_PROV_ID = $_POST['DIED_PROV_ID'];
$DIED_AMPR_ID = $_POST['DIED_AMPR_ID'];
$DIED_FILE = $_FILES['DIED_FILE'];
$DIED_FILE_OLD = $_POST['DIED_FILE_OLD'];
//END DIV 10
//DIV 11
$ARR_FAMILY_ID_11 = $_POST['FAMILY_ID_11'];
//END DIV 11
$TB = "PENSION_MAIN";
$TB1 = "PENSION_POSITIONHIS";
$TB2 = "PENSION_MULTITIME";
$TB4 = "PENSION_FAMILY";
$TB5 = "PENSION_HEIR_DESC";

switch($proc){
	case "add" : 
		try{
			
			$DIED_FILE_NAME ='NULL';
			if($DIED_FILE['name']!=''||$DIED_FILE['name']!=NULL){
				$DIED_FILE_NAME=getFilenameUplaod($DIED_FILE,$path_a,$DIED_FILE_OLD);
			}
			
			$query_per = $db->query("SELECT * FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."' ");
			$rec_per = $db->db_fetch_array($query_per);
			
				$fields = array(
					'PER_ID' => $PER_ID,
					'PENSION_IDCARD' => $rec_per['PER_IDCARD'],
					'POSTYPE_ID' => $rec_per['POSTYPE_ID'],
					'TYPE_ID' => $rec_per['TYPE_ID'],
					'LEVEL_ID' => $rec_per['LEVEL_ID'],
					'LINE_ID' => $rec_per['LINE_ID'],
					'MANAGE_ID' => $rec_per['MANAGE_ID'],
					'ORG_ID_1' => $rec_per['ORG_ID_1'],
					'ORG_ID_2' => $rec_per['ORG_ID_2'],
					'ORG_ID_3' => $rec_per['ORG_ID_3'],
					'ORG_ID_4' => $rec_per['ORG_ID_4'],
					'ORG_ID_5' => $rec_per['ORG_ID_5'],
					'PENSION_DATE_BIRTH' => $rec_per['PER_DATE_BIRTH'],
					'PENSION_DATE_ENTRANCE' => $rec_per['PER_DATE_ENTRANCE'],
					'PENSION_DATE_RETIRE' =>  $rec_per['PER_DATE_RETIRE'],
					'PENSION_DATE_RESIGN' => $rec_per['PER_DATE_RESIGN'],
					'PENSION_TIME' => $PENSION_TIME,
					'PENSION_DATE' => $PENSION_DATE,
					'PENSION_TYPE_RESIGN' => $PENSION_TYPE_RESIGN,
					'PENSION_TYPE_PENSION' => $PENSION_TYPE_PENSION,
					'PENSION_TYPE_RECEIVER' => $PENSION_TYPE_RECEIVER,
					'PENSION_YEAR' => $PENSION_YEAR,
					'PENSION_MONTH' => $PENSION_MONTH,
					'PENSION_DAY' => $PENSION_DAY,
					'PENSION_SALARY' => $PENSION_SALARY,
					'PENSION_ALL' => $PENSION_ALL,
					'PENSION_MONTHLY' => $PENSION_MONTHLY,
					'LEGENCY_ALL' => $LEGENCY_ALL,
					'BONUSTIME_ALL' => $BONUSTIME_ALL,
					'BONUSTIME_RECEIVE' => $BONUSTIME_RECEIVE,
					'BONUSTIME_AMOUNT' => $BONUSTIME_AMOUNT,
					'BONUSTIME_BALANCE' => $BONUSTIME_BALANCE,
					'LEGENCY_BALANCE' => $LEGENCY_BALANCE,
					'PENSION_TYPE_RECEIVE' => $PENSION_TYPE_RECEIVE,
					'FAMILY_ID' => $FAMILY_ID,
					'RECEIVER_IDCARD' => $RECEIVER_IDCARD,
					'RECEIVER_PREFIX_ID' => $RECEIVER_PREFIX_ID,
					'RECEIVER_FIRSTNAME_TH' => $RECEIVER_FIRSTNAME_TH,
					'RECEIVER_MIDNAME_TH' => $RECEIVER_MIDNAME_TH,
					'RECEIVER_LASTNAME_TH' => $RECEIVER_LASTNAME_TH,
					'PENSION_TYPE_DELEGATE' => $PENSION_TYPE_DELEGATE,
					'DELEGATE_IDCARD' => $DELEGATE_IDCARD,
					'DELEGATE_PREFIX_ID' => $DELEGATE_PREFIX_ID,
					'DELEGATE_FIRSTNAME_TH'  => $DELEGATE_FIRSTNAME_TH,
					'DELEGATE_MIDNAME_TH' => $DELEGATE_MIDNAME_TH,
					'DELEGATE_LASTNAME_TH' => $DELEGATE_LASTNAME_TH,
					'ADDRESS_COUNTRY_ID' => $ADDRESS_COUNTRY_ID,
					'ADDRESS_CITY' => $ADDRESS_CITY,
					'ADDRESS_ROOM_NO' => $ADDRESS_ROOM_NO,
					'ADDRESS_FLOOR' => $ADDRESS_FLOOR,
					'ADDRESS_BUILDING' => $ADDRESS_BUILDING,
					'ADDRESS_HOME_NO' => $ADDRESS_HOME_NO,
					'ADDRESS_MOO' => $ADDRESS_MOO,
					'ADDRESS_VILLAGE' => $ADDRESS_VILLAGE,
					'ADDRESS_SOI' => $ADDRESS_SOI,
					'ADDRESS_ROAD' => $ADDRESS_ROAD,
					'ADDRESS_PROV_ID' => $ADDRESS_PROV_ID,
					'ADDRESS_AMPR_ID' => $ADDRESS_AMPR_ID,
					'ADDRESS_TAMB_ID' => $ADDRESS_TAMB_ID,
					'ADDRESS_POSTCODE' => $ADDRESS_ZIPCODE,
					'ADDRESS_TEL' => $ADDRESS_TEL,
					'ADDRESS_TEL_EXT' => $ADDRESS_TEL_EXT,
					'ADDRESS_FAX' => $ADDRESS_FAX,
					'ADDRESS_FAX_EXT' => $ADDRESS_FAX_EXT,
					'ADDRESS_MOBILE' => $ADDRESS_MOBILE,
					'ADDRESS_EMAIL'  => $ADDRESS_EMAIL,
					'BANK_ID' => $BANK_ID,
					'BANK_BRANCH' =>  $BANK_BRANCH,
					'BANK_NO' => $BANK_NO,
					'BANK_NAME' => $BANK_NAME,
					'DIED_NO' => $DIED_NO,
					'DIED_DATE' => $DIED_DATE,
					'DIED_SDATE' => $DIED_SDATE,
					'DIED_REASON' => $DIED_REASON,
					'DIED_PLACE' => $DIED_PLACE,
					'DIED_PROV_ID' => $DIED_PROV_ID,
					'DIED_AMPR_ID' => $DIED_AMPR_ID,
					'DIED_FILE' => $DIED_FILE_NAME,
					'DELETE_FLAG' => 0,
					"CREATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP
				);
			    $db->db_insert($TB,$fields);
				$query_max = $db->query("SELECT MAX(PENSION_ID) AS MAX_PENSION FROM PENSION_MAIN");
				$rec_max = $db->db_fetch_array($query_max);
				$PENSION_ID = $rec_max['MAX_PENSION'];
			
			if(count($ARR_POSHIS_YEAR) > 0){
				foreach($ARR_POSHIS_YEAR as $index => $val){
					$total_now_day = 0;
					
					if($index == 3){
						$POSHIS_YEAR = 0;
						$POSHIS_MONTH = 0;
						$POSHIS_DAY = 0;
					   if(trim($ARR_POSHIS_SDATE[$index]) != '' and trim($ARR_POSHIS_EDATE[$index]) != ''){
						   $arr_day = CalAgePension(conv_date_db($ARR_POSHIS_SDATE[$index]), date("Y-m-d", strtotime("+1 DAY", strtotime(conv_date_db($ARR_POSHIS_EDATE[$index])))));
						   $POSHIS_YEAR = $arr_day['YEAR'];
						   $POSHIS_MONTH = $arr_day['MONTH'];
						   $POSHIS_DAY = $arr_day['DAY']; 
						}
					 }else{
						 $POSHIS_YEAR = $ARR_POSHIS_YEAR[$index];
						 $POSHIS_MONTH = $ARR_POSHIS_MONTH[$index];
						 $POSHIS_DAY = $ARR_POSHIS_DAY[$index]; 
					 }
					
					
				  $fields = array(
					'PENSION_ID' => $PENSION_ID,
					'POSHIS_SEQ' => $index,
					'POSHIS_SDATE' => conv_date_db($ARR_POSHIS_SDATE[$index]),
					'POSHIS_EDATE' => conv_date_db($ARR_POSHIS_EDATE[$index]),
					'POSHIS_YEAR' => $POSHIS_YEAR,
					'POSHIS_MONTH' => $POSHIS_MONTH,
					'POSHIS_DAY' =>$POSHIS_DAY,
					'ACTIVE_STATUS' => 1,
					'DELETE_FLAG' => 0,
					"CREATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
				  );
				  $db->db_insert($TB1,$fields);
				}
			}
			
			if(count($ARR_MULTITIME_ID) > 0){
				foreach($ARR_MULTITIME_ID as $index => $val){
				  $fields = array(
					  'PENSION_ID' => $PENSION_ID,
					  'MULTIME_ID' => $val,
					  'MULTI_SDATE' => conv_date_db($ARR_MULTI_SDATE[$val]),
					  'MULTI_EDATE' => conv_date_db($ARR_MULTI_EDATE[$val]),
					  'MULTI_FRAC' => $ARR_MULTI_FRAC[$val],
					  'MULTI_YEAR' => $ARR_MULTI_YEAR[$val],
					  'MULTI_MONTH' => $ARR_MULTI_MONTH[$val],
					  'MULTI_DAY' => $ARR_MULTI_DAY[$val],
					  'DELETE_FLAG' => 0,
					  "CREATE_BY" => $USER_BY,
					  "CREATE_DATE" => $TIMESTAMP
				  );
				   $db->db_insert($TB2,$fields);
				}
			}
			
			
			if(count($ARR_FAMILY_ID_8) > 0){
				foreach($ARR_FAMILY_ID_8 as $index => $val){
					$query = $db->query("SELECT * FROM PER_FAMILY WHERE FAMILY_ID = '".$val."' ");
					$rec = $db->db_fetch_array($query);
					$fields = array(
						'FAMILY_ID' => $val,
						'PENSION_ID' => $PENSION_ID,
						'FAMILY_RELATIONSHIP' => $rec['FAMILY_RELATIONSHIP'],
						'FAMILY_DATE'  => $rec['FAMILY_DATE'],
						'FAMILY_IDTYPE' => $rec['FAMILY_IDTYPE'],
						'FAMILY_IDCARD' => $rec['FAMILY_IDCARD'],
						'FAMILY_PREFIX_ID' => $rec['FAMILY_PREFIX_ID'],
						'FAMILY_FIRSTNAME_TH' => $rec['FAMILY_FIRSTNAME_TH'],
						'FAMILY_MIDNAME_TH' => $rec['FAMILY_MIDNAME_TH'],
						'FAMILY_LASTNAME_TH' => $rec['FAMILY_LASTNAME_TH'],
						'FAMILY_STATUS' => $rec['FAMILY_STATUS'],
						'ADDRESS_COUNTRY_ID' => $rec['ADDRESS_COUNTRY_ID'],
						'ADDRESS_CITY' => $rec['ADDRESS_CITY'],
						'ADDRESS_ROOM_NO' => $rec['ADDRESS_ROOM_NO'],
						'ADDRESS_FLOOR' => $rec['ADDRESS_FLOOR'],
						'ADDRESS_BUILDING' => $rec['ADDRESS_BUILDING'],
						'ADDRESS_HOME_NO' => $rec['ADDRESS_HOME_NO'],
						'ADDRESS_MOO' => $rec['ADDRESS_MOO'],
						'ADDRESS_VILLAGE' => $rec['ADDRESS_VILLAGE'],
						'ADDRESS_SOI' => $rec['ADDRESS_SOI'],
						'ADDRESS_ROAD' => $rec['ADDRESS_ROAD'],
						'ADDRESS_TAMB_ID' => $rec['ADDRESS_TAMB_ID'],
						'ADDRESS_AMPR_ID' => $rec['ADDRESS_AMPR_ID'],
						'ADDRESS_PROV_ID' => $rec['ADDRESS_PROV_ID'],
						'ADDRESS_POSTCODE' => $rec['ADDRESS_POSTCODE'],
						'ADDRESS_TEL' => $rec['ADDRESS_TEL'],
						'ADDRESS_TEL_EXT' => $rec['ADDRESS_TEL_EXT'],
						'ADDRESS_FAX' => $rec['ADDRESS_FAX'],
						'ADDRESS_FAX_EXT' => $rec['ADDRESS_FAX_EXT'],
						'ADDRESS_MOBILE' => $rec['ADDRESS_MOBILE'],
						'ADDRESS_EMAIL' => $rec['ADDRESS_EMAIL'],
						'PENHEIR_CONTACT_BY' => $ARR_PENHEIR_CONTACT_FAMILY_SATUS_8[$val],
						'PENHEIR_CONTACT_IDCARD' => str_replace('-','',$ARR_PENHEIR_CONTACT_IDCARD_8[$val]),
						'PENHEIR_CONTACT_FIRSTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_FIRSTNAME_TH_8[$val]),
						'PENHEIR_CONTACT_MIDNAME_TH' => ctext($ARR_PENHEIR_CONTACT_MIDNAME_TH_8[$val]),
						'PENHEIR_CONTACT_LASTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_LASTNAME_TH_8[$val]),
						'PENHEIR_CONTACT_RELATIONSHIP' => ctext($ARR_PENHEIR_CONTACT_RELATIONSHIP_8[$val]),
						'BANK_ID' => $ARR_PENHEIR_CONTACT_BANK_ID_8[$val],
						'BANK_BRANCH' => ctext($ARR_PENHEIR_CONTACT_BANK_BRANCH_8[$val]),
						'BANK_NO' => ctext($ARR_PENHEIR_CONTACT_BANK_NO_8[$val]),
						'BANK_NAME' => ctext($ARR_PENHEIR_CONTACT_BANK_NAME_8[$val]),
						'DELETE_FLAG' => 0,
						'CREATE_BY' => $USER_BY,
						'CREATE_DATE' => $TIMESTAMP
					);
					$db->db_insert($TB4,$fields);
				}
			}
			
			if(count($ARR_HEIRDESC_ID_9) > 0){
				foreach($ARR_HEIRDESC_ID_9 as $index => $val){
					$query_desc = $db->query("SELECT * FROM PER_HEIRHIS_DESC  WHERE HEIRDESC_ID = '".$val."' ");
					$rec_desc = $db->db_fetch_array($query_desc);
					$fields = array(
						'HEIRDESC_ID' => $val,
						'PENSION_ID' => $PENSION_ID,
						'HEIRDESC_IDTYPE' => $rec_desc['HEIRDESC_IDTYPE'],
						'HEIRDESC_IDCARD' => $rec_desc['HEIRDESC_IDCARD'],
						'PREFIX_ID' => $rec_desc['PREFIX_ID'],
						'HEIRDESC_FIRSTNAME_TH' => $rec_desc['HEIRDESC_FIRSTNAME_TH'],
						'HEIRDESC_MIDNAME_TH' => $rec_desc['HEIRDESC_MIDNAME_TH'],
						'HEIRDESC_LASTNAME_TH' => $rec_desc['HEIRDESC_LASTNAME_TH'],
						'HEIRDESC_PART' => $rec_desc['HEIRDESC_PART'],
						'ADDRESS_COUNTRY_ID' => $rec_desc['ADDRESS_COUNTRY_ID'],
						'ADDRESS_CITY' => $rec_desc['ADDRESS_CITY'],
						'ADDRESS_ROOM_NO' => $rec_desc['ADDRESS_ROOM_NO'],
						'ADDRESS_FLOOR' => $rec_desc['ADDRESS_FLOOR'],
						'ADDRESS_BUILDING' => $rec_desc['ADDRESS_BUILDING'],
						'ADDRESS_HOME_NO' => $rec_desc['ADDRESS_HOME_NO'],
						'ADDRESS_MOO' => $rec_desc['ADDRESS_MOO'],
						'ADDRESS_VILLAGE' => $rec_desc['ADDRESS_VILLAGE'],
						'ADDRESS_SOI' => $rec_desc['ADDRESS_SOI'],
						'ADDRESS_ROAD' => $rec_desc['ADDRESS_ROAD'],
						'ADDRESS_TAMB_ID' => $rec_desc['ADDRESS_TAMB_ID'],
						'ADDRESS_AMPR_ID' => $rec_desc['ADDRESS_AMPR_ID'],
						'ADDRESS_PROV_ID' => $rec_desc['ADDRESS_PROV_ID'],
						'ADDRESS_POSTCODE' => $rec_desc['ADDRESS_POSTCODE'],
						'ADDRESS_TEL' => $rec_desc['ADDRESS_TEL'],
						'ADDRESS_TEL_EXT' => $rec_desc['ADDRESS_TEL_EXT'],
						'ADDRESS_FAX' => $rec_desc['ADDRESS_FAX'],
						'ADDRESS_FAX_EXT' => $rec_desc['ADDRESS_FAX_EXT'],
						'ADDRESS_MOBILE' => $rec_desc['ADDRESS_MOBILE'],
						'ADDRESS_EMAIL' => $rec_desc['ADDRESS_EMAIL'],
						'CONTACT_BY' => $ARR_PENHEIR_CONTACT_FRAMILY_STATUS_9[$val],
						'CONTACT_IDCARD' => str_replace('-','',$ARR_PENHEIR_CONTACT_IDCARD_9[$val]),
						'CONTACT_FIRSTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_FIRSTNAME_TH_9[$val]),
						'CONTACT_MIDNAME_TH' => ctext($ARR_PENHEIR_CONTACT_MIDNAME_TH_9[$val]),
						'CONTACT_LASTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_LASTNAME_TH_9[$val]),
						'BANK_ID' => $ARR_PENHEIR_CONTACT_BANK_ID_9[$val],
						'BANK_BRANCH' => ctext($ARR_PENHEIR_CONTACT_BANK_BRANCH_9[$val]),
						'BANK_NO' => ctext($ARR_PENHEIR_CONTACT_BANK_NO_9[$val]),
						'BANK_NAME' => ctext($ARR_PENHEIR_CONTACT_BANK_NAME_9[$val]),
						'CREATE_BY' => $USER_BY,
						'CREATE_DATE' => $TIMESTAMP,
						'DELETE_FLAG' => 0 
					);
				    $db->db_insert($TB5,$fields);
				}
			}
			
			if(count($ARR_FAMILY_ID_11) > 0){
				foreach($ARR_FAMILY_ID_11 as $index => $val){
					$query = $db->query("SELECT * FROM PER_FAMILY WHERE FAMILY_ID = '".$val."' ");
					$rec = $db->db_fetch_array($query);
					$fields = array(
						'FAMILY_ID' => $val,
						'PENSION_ID' => $PENSION_ID,
						'FAMILY_RELATIONSHIP' => $rec['FAMILY_RELATIONSHIP'],
						'FAMILY_DATE'  => $rec['FAMILY_DATE'],
						'FAMILY_IDTYPE' => $rec['FAMILY_IDTYPE'],
						'FAMILY_IDCARD' => $rec['FAMILY_IDCARD'],
						'FAMILY_PREFIX_ID' => $rec['FAMILY_PREFIX_ID'],
						'FAMILY_FIRSTNAME_TH' => $rec['FAMILY_FIRSTNAME_TH'],
						'FAMILY_MIDNAME_TH' => $rec['FAMILY_MIDNAME_TH'],
						'FAMILY_LASTNAME_TH' => $rec['FAMILY_LASTNAME_TH'],
						'FAMILY_STATUS' => $rec['FAMILY_STATUS'],
						'ADDRESS_COUNTRY_ID' => $rec['ADDRESS_COUNTRY_ID'],
						'ADDRESS_CITY' => $rec['ADDRESS_CITY'],
						'ADDRESS_ROOM_NO' => $rec['ADDRESS_ROOM_NO'],
						'ADDRESS_FLOOR' => $rec['ADDRESS_FLOOR'],
						'ADDRESS_BUILDING' => $rec['ADDRESS_BUILDING'],
						'ADDRESS_HOME_NO' => $rec['ADDRESS_HOME_NO'],
						'ADDRESS_MOO' => $rec['ADDRESS_MOO'],
						'ADDRESS_VILLAGE' => $rec['ADDRESS_VILLAGE'],
						'ADDRESS_SOI' => $rec['ADDRESS_SOI'],
						'ADDRESS_ROAD' => $rec['ADDRESS_ROAD'],
						'ADDRESS_TAMB_ID' => $rec['ADDRESS_TAMB_ID'],
						'ADDRESS_AMPR_ID' => $rec['ADDRESS_AMPR_ID'],
						'ADDRESS_PROV_ID' => $rec['ADDRESS_PROV_ID'],
						'ADDRESS_POSTCODE' => $rec['ADDRESS_POSTCODE'],
						'ADDRESS_TEL' => $rec['ADDRESS_TEL'],
						'ADDRESS_TEL_EXT' => $rec['ADDRESS_TEL_EXT'],
						'ADDRESS_FAX' => $rec['ADDRESS_FAX'],
						'ADDRESS_FAX_EXT' => $rec['ADDRESS_FAX_EXT'],
						'ADDRESS_MOBILE' => $rec['ADDRESS_MOBILE'],
						'ADDRESS_EMAIL' => $rec['ADDRESS_EMAIL'],
						'PENHEIR_CONTACT_BY' => $ARR_PENHEIR_CONTACT_FAMILY_SATUS_8[$val],
						'PENHEIR_CONTACT_IDCARD' => str_replace('-','',$ARR_PENHEIR_CONTACT_IDCARD_8[$val]),
						'PENHEIR_CONTACT_FIRSTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_FIRSTNAME_TH_8[$val]),
						'PENHEIR_CONTACT_MIDNAME_TH' => ctext($ARR_PENHEIR_CONTACT_MIDNAME_TH_8[$val]),
						'PENHEIR_CONTACT_LASTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_LASTNAME_TH_8[$val]),
						'PENHEIR_CONTACT_RELATIONSHIP' => ctext($ARR_PENHEIR_CONTACT_RELATIONSHIP_8[$val]),
						'BANK_ID' => $ARR_PENHEIR_CONTACT_BANK_ID_8[$val],
						'BANK_BRANCH' => ctext($ARR_PENHEIR_CONTACT_BANK_BRANCH_8[$val]),
						'BANK_NO' => ctext($ARR_PENHEIR_CONTACT_BANK_NO_8[$val]),
						'BANK_NAME' => ctext($ARR_PENHEIR_CONTACT_BANK_NAME_8[$val]),
						'DELETE_FLAG' => 0,
						'CREATE_BY' => $USER_BY,
						'CREATE_DATE' => $TIMESTAMP
					);
					$db->db_insert($TB4,$fields);
				}
			}
			
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "edit" : 
		try{
			$DIED_FILE_NAME ='NULL';
			if($DIED_FILE['name']!=''||$DIED_FILE['name']!=NULL){
				$DIED_FILE_NAME=getFilenameUplaod($DIED_FILE,$path_a,$DIED_FILE_OLD);
			}
			$fields = array(	
					'PENSION_TIME' => $PENSION_TIME,
					'PENSION_DATE' => $PENSION_DATE,
					'PENSION_TYPE_RESIGN' => $PENSION_TYPE_RESIGN,
					'PENSION_TYPE_PENSION' => $PENSION_TYPE_PENSION,
					'PENSION_TYPE_RECEIVER' => $PENSION_TYPE_RECEIVER,
					'PENSION_YEAR' => $PENSION_YEAR,
					'PENSION_MONTH' => $PENSION_MONTH,
					'PENSION_DAY' => $PENSION_DAY,
					'PENSION_SALARY' => $PENSION_SALARY,
					'PENSION_ALL' => $PENSION_ALL,
					'PENSION_MONTHLY' => $PENSION_MONTHLY,
					'LEGENCY_ALL' => $LEGENCY_ALL,
					'BONUSTIME_ALL' => $BONUSTIME_ALL,
					'BONUSTIME_RECEIVE' => $BONUSTIME_RECEIVE,
					'BONUSTIME_AMOUNT' => $BONUSTIME_AMOUNT,
					'BONUSTIME_BALANCE' => $BONUSTIME_BALANCE,
					'LEGENCY_BALANCE' => $LEGENCY_BALANCE,
					'PENSION_TYPE_RECEIVE' => $PENSION_TYPE_RECEIVE,
					'FAMILY_ID' => $FAMILY_ID,
					'RECEIVER_IDCARD' => $RECEIVER_IDCARD,
					'RECEIVER_PREFIX_ID' => $RECEIVER_PREFIX_ID,
					'RECEIVER_FIRSTNAME_TH' => $RECEIVER_FIRSTNAME_TH,
					'RECEIVER_MIDNAME_TH' => $RECEIVER_MIDNAME_TH,
					'RECEIVER_LASTNAME_TH' => $RECEIVER_LASTNAME_TH,
					'PENSION_TYPE_DELEGATE' => $PENSION_TYPE_DELEGATE,
					'DELEGATE_IDCARD' => $DELEGATE_IDCARD,
					'DELEGATE_PREFIX_ID' => $DELEGATE_PREFIX_ID,
					'DELEGATE_FIRSTNAME_TH'  => $DELEGATE_FIRSTNAME_TH,
					'DELEGATE_MIDNAME_TH' => $DELEGATE_MIDNAME_TH,
					'DELEGATE_LASTNAME_TH' => $DELEGATE_LASTNAME_TH,
					'ADDRESS_COUNTRY_ID' => $ADDRESS_COUNTRY_ID,
					'ADDRESS_CITY' => $ADDRESS_CITY,
					'ADDRESS_ROOM_NO' => $ADDRESS_ROOM_NO,
					'ADDRESS_FLOOR' => $ADDRESS_FLOOR,
					'ADDRESS_BUILDING' => $ADDRESS_BUILDING,
					'ADDRESS_HOME_NO' => $ADDRESS_HOME_NO,
					'ADDRESS_MOO' => $ADDRESS_MOO,
					'ADDRESS_VILLAGE' => $ADDRESS_VILLAGE,
					'ADDRESS_SOI' => $ADDRESS_SOI,
					'ADDRESS_ROAD' => $ADDRESS_ROAD,
					'ADDRESS_PROV_ID' => $ADDRESS_PROV_ID,
					'ADDRESS_AMPR_ID' => $ADDRESS_AMPR_ID,
					'ADDRESS_TAMB_ID' => $ADDRESS_TAMB_ID,
					'ADDRESS_POSTCODE' => $ADDRESS_ZIPCODE,
					'ADDRESS_TEL' => $ADDRESS_TEL,
					'ADDRESS_TEL_EXT' => $ADDRESS_TEL_EXT,
					'ADDRESS_FAX' => $ADDRESS_FAX,
					'ADDRESS_FAX_EXT' => $ADDRESS_FAX_EXT,
					'ADDRESS_MOBILE' => $ADDRESS_MOBILE,
					'ADDRESS_EMAIL'  => $ADDRESS_EMAIL,
					'BANK_ID' => $BANK_ID,
					'BANK_BRANCH' =>  $BANK_BRANCH,
					'BANK_NO' => $BANK_NO,
					'BANK_NAME' => $BANK_NAME,
					'DIED_NO' => $DIED_NO,
					'DIED_DATE' => $DIED_DATE,
					'DIED_SDATE' => $DIED_SDATE,
					'DIED_REASON' => $DIED_REASON,
					'DIED_PLACE' => $DIED_PLACE,
					'DIED_PROV_ID' => $DIED_PROV_ID,
					'DIED_AMPR_ID' => $DIED_AMPR_ID,
					'DIED_FILE' => $DIED_FILE_NAME,
					'DELETE_FLAG' => 0,
					"CREATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP
				);
				$db->db_update($TB,$fields," PENSION_ID = '".$PENSION_ID."' ");
				
			$db->db_delete($TB1," PENSION_ID = '".$PENSION_ID."' ");
			if(count($ARR_POSHIS_YEAR) > 0){
				foreach($ARR_POSHIS_YEAR as $index => $val){
					$total_now_day = 0;
					
					if($index == 3){
						$POSHIS_YEAR = 0;
						$POSHIS_MONTH = 0;
						$POSHIS_DAY = 0;
					   if(trim($ARR_POSHIS_SDATE[$index]) != '' and trim($ARR_POSHIS_EDATE[$index]) != ''){
						   $arr_day = CalAgePension(conv_date_db($ARR_POSHIS_SDATE[$index]), date("Y-m-d", strtotime("+1 DAY", strtotime(conv_date_db($ARR_POSHIS_EDATE[$index])))));
						   $POSHIS_YEAR = $arr_day['YEAR'];
						   $POSHIS_MONTH = $arr_day['MONTH'];
						   $POSHIS_DAY = $arr_day['DAY']; 
						}
					 }else{
						 $POSHIS_YEAR = $ARR_POSHIS_YEAR[$index];
						 $POSHIS_MONTH = $ARR_POSHIS_MONTH[$index];
						 $POSHIS_DAY = $ARR_POSHIS_DAY[$index]; 
					 }
					
					
				  $fields = array(
					'PENSION_ID' => $PENSION_ID,
					'POSHIS_SEQ' => $index,
					'POSHIS_SDATE' => conv_date_db($ARR_POSHIS_SDATE[$index]),
					'POSHIS_EDATE' => conv_date_db($ARR_POSHIS_EDATE[$index]),
					'POSHIS_YEAR' => $POSHIS_YEAR,
					'POSHIS_MONTH' => $POSHIS_MONTH,
					'POSHIS_DAY' =>$POSHIS_DAY,
					'ACTIVE_STATUS' => 1,
					'DELETE_FLAG' => 0,
					"CREATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
				  );
				  $db->db_insert($TB1,$fields);
				}
			}
			$db->db_delete($TB2," PENSION_ID = '".$PENSION_ID."' ");
			if(count($ARR_MULTITIME_ID) > 0){
				foreach($ARR_MULTITIME_ID as $index => $val){
				  $fields = array(
					  'PENSION_ID' => $PENSION_ID,
					  'MULTIME_ID' => $val,
					  'MULTI_SDATE' => conv_date_db($ARR_MULTI_SDATE[$val]),
					  'MULTI_EDATE' => conv_date_db($ARR_MULTI_EDATE[$val]),
					  'MULTI_FRAC' => $ARR_MULTI_FRAC[$val],
					  'MULTI_YEAR' => $ARR_MULTI_YEAR[$val],
					  'MULTI_MONTH' => $ARR_MULTI_MONTH[$val],
					  'MULTI_DAY' => $ARR_MULTI_DAY[$val],
					  'DELETE_FLAG' => 0,
					  "CREATE_BY" => $USER_BY,
					  "CREATE_DATE" => $TIMESTAMP
				  );
				   $db->db_insert($TB2,$fields);
				}
			}
			
			
			
			$db->db_delete($TB4," PENSION_ID = '".$PENSION_ID."' AND FAMILY_RELATIONSHIP <= 5  ");
			if(count($ARR_FAMILY_ID_8) > 0){
				foreach($ARR_FAMILY_ID_8 as $index => $val){
					$query = $db->query("SELECT * FROM PER_FAMILY WHERE FAMILY_ID = '".$val."' ");
					$rec = $db->db_fetch_array($query);
					$fields = array(
						'FAMILY_ID' => $val,
						'PENSION_ID' => $PENSION_ID,
						'FAMILY_RELATIONSHIP' => $rec['FAMILY_RELATIONSHIP'],
						'FAMILY_DATE'  => $rec['FAMILY_DATE'],
						'FAMILY_IDTYPE' => $rec['FAMILY_IDTYPE'],
						'FAMILY_IDCARD' => $rec['FAMILY_IDCARD'],
						'FAMILY_PREFIX_ID' => $rec['FAMILY_PREFIX_ID'],
						'FAMILY_FIRSTNAME_TH' => $rec['FAMILY_FIRSTNAME_TH'],
						'FAMILY_MIDNAME_TH' => $rec['FAMILY_MIDNAME_TH'],
						'FAMILY_LASTNAME_TH' => $rec['FAMILY_LASTNAME_TH'],
						'FAMILY_STATUS' => $rec['FAMILY_STATUS'],
						'ADDRESS_COUNTRY_ID' => $rec['ADDRESS_COUNTRY_ID'],
						'ADDRESS_CITY' => $rec['ADDRESS_CITY'],
						'ADDRESS_ROOM_NO' => $rec['ADDRESS_ROOM_NO'],
						'ADDRESS_FLOOR' => $rec['ADDRESS_FLOOR'],
						'ADDRESS_BUILDING' => $rec['ADDRESS_BUILDING'],
						'ADDRESS_HOME_NO' => $rec['ADDRESS_HOME_NO'],
						'ADDRESS_MOO' => $rec['ADDRESS_MOO'],
						'ADDRESS_VILLAGE' => $rec['ADDRESS_VILLAGE'],
						'ADDRESS_SOI' => $rec['ADDRESS_SOI'],
						'ADDRESS_ROAD' => $rec['ADDRESS_ROAD'],
						'ADDRESS_TAMB_ID' => $rec['ADDRESS_TAMB_ID'],
						'ADDRESS_AMPR_ID' => $rec['ADDRESS_AMPR_ID'],
						'ADDRESS_PROV_ID' => $rec['ADDRESS_PROV_ID'],
						'ADDRESS_POSTCODE' => $rec['ADDRESS_POSTCODE'],
						'ADDRESS_TEL' => $rec['ADDRESS_TEL'],
						'ADDRESS_TEL_EXT' => $rec['ADDRESS_TEL_EXT'],
						'ADDRESS_FAX' => $rec['ADDRESS_FAX'],
						'ADDRESS_FAX_EXT' => $rec['ADDRESS_FAX_EXT'],
						'ADDRESS_MOBILE' => $rec['ADDRESS_MOBILE'],
						'ADDRESS_EMAIL' => $rec['ADDRESS_EMAIL'],
						'PENHEIR_CONTACT_BY' => $ARR_PENHEIR_CONTACT_FAMILY_SATUS_8[$val],
						'PENHEIR_CONTACT_IDCARD' => str_replace('-','',$ARR_PENHEIR_CONTACT_IDCARD_8[$val]),
						'PENHEIR_CONTACT_FIRSTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_FIRSTNAME_TH_8[$val]),
						'PENHEIR_CONTACT_MIDNAME_TH' => ctext($ARR_PENHEIR_CONTACT_MIDNAME_TH_8[$val]),
						'PENHEIR_CONTACT_LASTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_LASTNAME_TH_8[$val]),
						'PENHEIR_CONTACT_RELATIONSHIP' => ctext($ARR_PENHEIR_CONTACT_RELATIONSHIP_8[$val]),
						'BANK_ID' => $ARR_PENHEIR_CONTACT_BANK_ID_8[$val],
						'BANK_BRANCH' => ctext($ARR_PENHEIR_CONTACT_BANK_BRANCH_8[$val]),
						'BANK_NO' => ctext($ARR_PENHEIR_CONTACT_BANK_NO_8[$val]),
						'BANK_NAME' => ctext($ARR_PENHEIR_CONTACT_BANK_NAME_8[$val]),
						'DELETE_FLAG' => 0,
						'CREATE_BY' => $USER_BY,
						'CREATE_DATE' => $TIMESTAMP
					);
					$db->db_insert($TB4,$fields);
				}
			}
			
			$db->db_delete($TB5," PENSION_ID = '".$PENSION_ID."' ");
			if(count($ARR_HEIRDESC_ID_9) > 0){
				foreach($ARR_HEIRDESC_ID_9 as $index => $val){
					$query_desc = $db->query("SELECT * FROM PER_HEIRHIS_DESC  WHERE HEIRDESC_ID = '".$val."' ");
					$rec_desc = $db->db_fetch_array($query_desc);
					$fields = array(
						'HEIRDESC_ID' => $val,
						'PENSION_ID' => $PENSION_ID,
						'HEIRDESC_IDTYPE' => $rec_desc['HEIRDESC_IDTYPE'],
						'HEIRDESC_IDCARD' => $rec_desc['HEIRDESC_IDCARD'],
						'PREFIX_ID' => $rec_desc['PREFIX_ID'],
						'HEIRDESC_FIRSTNAME_TH' => $rec_desc['HEIRDESC_FIRSTNAME_TH'],
						'HEIRDESC_MIDNAME_TH' => $rec_desc['HEIRDESC_MIDNAME_TH'],
						'HEIRDESC_LASTNAME_TH' => $rec_desc['HEIRDESC_LASTNAME_TH'],
						'HEIRDESC_PART' => $rec_desc['HEIRDESC_PART'],
						'ADDRESS_COUNTRY_ID' => $rec_desc['ADDRESS_COUNTRY_ID'],
						'ADDRESS_CITY' => $rec_desc['ADDRESS_CITY'],
						'ADDRESS_ROOM_NO' => $rec_desc['ADDRESS_ROOM_NO'],
						'ADDRESS_FLOOR' => $rec_desc['ADDRESS_FLOOR'],
						'ADDRESS_BUILDING' => $rec_desc['ADDRESS_BUILDING'],
						'ADDRESS_HOME_NO' => $rec_desc['ADDRESS_HOME_NO'],
						'ADDRESS_MOO' => $rec_desc['ADDRESS_MOO'],
						'ADDRESS_VILLAGE' => $rec_desc['ADDRESS_VILLAGE'],
						'ADDRESS_SOI' => $rec_desc['ADDRESS_SOI'],
						'ADDRESS_ROAD' => $rec_desc['ADDRESS_ROAD'],
						'ADDRESS_TAMB_ID' => $rec_desc['ADDRESS_TAMB_ID'],
						'ADDRESS_AMPR_ID' => $rec_desc['ADDRESS_AMPR_ID'],
						'ADDRESS_PROV_ID' => $rec_desc['ADDRESS_PROV_ID'],
						'ADDRESS_POSTCODE' => $rec_desc['ADDRESS_POSTCODE'],
						'ADDRESS_TEL' => $rec_desc['ADDRESS_TEL'],
						'ADDRESS_TEL_EXT' => $rec_desc['ADDRESS_TEL_EXT'],
						'ADDRESS_FAX' => $rec_desc['ADDRESS_FAX'],
						'ADDRESS_FAX_EXT' => $rec_desc['ADDRESS_FAX_EXT'],
						'ADDRESS_MOBILE' => $rec_desc['ADDRESS_MOBILE'],
						'ADDRESS_EMAIL' => $rec_desc['ADDRESS_EMAIL'],
						'CONTACT_BY' => $ARR_PENHEIR_CONTACT_FRAMILY_STATUS_9[$val],
						'CONTACT_IDCARD' => str_replace('-','',$ARR_PENHEIR_CONTACT_IDCARD_9[$val]),
						'CONTACT_FIRSTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_FIRSTNAME_TH_9[$val]),
						'CONTACT_MIDNAME_TH' => ctext($ARR_PENHEIR_CONTACT_MIDNAME_TH_9[$val]),
						'CONTACT_LASTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_LASTNAME_TH_9[$val]),
						'BANK_ID' => $ARR_PENHEIR_CONTACT_BANK_ID_9[$val],
						'BANK_BRANCH' => ctext($ARR_PENHEIR_CONTACT_BANK_BRANCH_9[$val]),
						'BANK_NO' => ctext($ARR_PENHEIR_CONTACT_BANK_NO_9[$val]),
						'BANK_NAME' => ctext($ARR_PENHEIR_CONTACT_BANK_NAME_9[$val]),
						'CREATE_BY' => $USER_BY,
						'CREATE_DATE' => $TIMESTAMP,
						'DELETE_FLAG' => 0 
					);
				    $db->db_insert($TB5,$fields);
				}
			}
			
			$db->db_delete($TB4," PENSION_ID = '".$PENSION_ID."' AND FAMILY_RELATIONSHIP = 5 ");
			if(count($ARR_FAMILY_ID_11) > 0){
				foreach($ARR_FAMILY_ID_11 as $index => $val){
					$query = $db->query("SELECT * FROM PER_FAMILY WHERE FAMILY_ID = '".$val."' ");
					$rec = $db->db_fetch_array($query);
					$fields = array(
						'FAMILY_ID' => $val,
						'PENSION_ID' => $PENSION_ID,
						'FAMILY_RELATIONSHIP' => $rec['FAMILY_RELATIONSHIP'],
						'FAMILY_DATE'  => $rec['FAMILY_DATE'],
						'FAMILY_IDTYPE' => $rec['FAMILY_IDTYPE'],
						'FAMILY_IDCARD' => $rec['FAMILY_IDCARD'],
						'FAMILY_PREFIX_ID' => $rec['FAMILY_PREFIX_ID'],
						'FAMILY_FIRSTNAME_TH' => $rec['FAMILY_FIRSTNAME_TH'],
						'FAMILY_MIDNAME_TH' => $rec['FAMILY_MIDNAME_TH'],
						'FAMILY_LASTNAME_TH' => $rec['FAMILY_LASTNAME_TH'],
						'FAMILY_STATUS' => $rec['FAMILY_STATUS'],
						'ADDRESS_COUNTRY_ID' => $rec['ADDRESS_COUNTRY_ID'],
						'ADDRESS_CITY' => $rec['ADDRESS_CITY'],
						'ADDRESS_ROOM_NO' => $rec['ADDRESS_ROOM_NO'],
						'ADDRESS_FLOOR' => $rec['ADDRESS_FLOOR'],
						'ADDRESS_BUILDING' => $rec['ADDRESS_BUILDING'],
						'ADDRESS_HOME_NO' => $rec['ADDRESS_HOME_NO'],
						'ADDRESS_MOO' => $rec['ADDRESS_MOO'],
						'ADDRESS_VILLAGE' => $rec['ADDRESS_VILLAGE'],
						'ADDRESS_SOI' => $rec['ADDRESS_SOI'],
						'ADDRESS_ROAD' => $rec['ADDRESS_ROAD'],
						'ADDRESS_TAMB_ID' => $rec['ADDRESS_TAMB_ID'],
						'ADDRESS_AMPR_ID' => $rec['ADDRESS_AMPR_ID'],
						'ADDRESS_PROV_ID' => $rec['ADDRESS_PROV_ID'],
						'ADDRESS_POSTCODE' => $rec['ADDRESS_POSTCODE'],
						'ADDRESS_TEL' => $rec['ADDRESS_TEL'],
						'ADDRESS_TEL_EXT' => $rec['ADDRESS_TEL_EXT'],
						'ADDRESS_FAX' => $rec['ADDRESS_FAX'],
						'ADDRESS_FAX_EXT' => $rec['ADDRESS_FAX_EXT'],
						'ADDRESS_MOBILE' => $rec['ADDRESS_MOBILE'],
						'ADDRESS_EMAIL' => $rec['ADDRESS_EMAIL'],
						'PENHEIR_CONTACT_BY' => $ARR_PENHEIR_CONTACT_FAMILY_SATUS_8[$val],
						'PENHEIR_CONTACT_IDCARD' => str_replace('-','',$ARR_PENHEIR_CONTACT_IDCARD_8[$val]),
						'PENHEIR_CONTACT_FIRSTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_FIRSTNAME_TH_8[$val]),
						'PENHEIR_CONTACT_MIDNAME_TH' => ctext($ARR_PENHEIR_CONTACT_MIDNAME_TH_8[$val]),
						'PENHEIR_CONTACT_LASTNAME_TH' => ctext($ARR_PENHEIR_CONTACT_LASTNAME_TH_8[$val]),
						'PENHEIR_CONTACT_RELATIONSHIP' => ctext($ARR_PENHEIR_CONTACT_RELATIONSHIP_8[$val]),
						'BANK_ID' => $ARR_PENHEIR_CONTACT_BANK_ID_8[$val],
						'BANK_BRANCH' => ctext($ARR_PENHEIR_CONTACT_BANK_BRANCH_8[$val]),
						'BANK_NO' => ctext($ARR_PENHEIR_CONTACT_BANK_NO_8[$val]),
						'BANK_NAME' => ctext($ARR_PENHEIR_CONTACT_BANK_NAME_8[$val]),
						'DELETE_FLAG' => 0,
						'CREATE_BY' => $USER_BY,
						'CREATE_DATE' => $TIMESTAMP
					);
					$db->db_insert($TB4,$fields);
				}
			}
			
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{
			$db->db_delete($TB," PENSION_ID = '".$PENSION_ID."' ");
			$db->db_delete($TB1," PENSION_ID = '".$PENSION_ID."' ");
			$db->db_delete($TB2," PENSION_ID = '".$PENSION_ID."' ");
		    $db->db_delete($TB4," PENSION_ID = '".$PENSION_ID."' ");
			 $db->db_delete($TB5," PENSION_ID = '".$PENSION_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case 'GetRampr':
	 $PROV_ID = $_POST['PROV_ID'];
	 $obj = array();
	 $query = $db->query("SELECT AMPR_ID, AMPR_NAME_TH FROM SETUP_AMPR WHERE PROV_ID = '".$PROV_ID."' AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 ");
	while($rec = $db->db_fetch_array($query)){
		$row['ID'] = $rec['AMPR_ID'];
		$row['VALUE'] = text($rec['AMPR_NAME_TH']);
		array_push($obj,$row);
	}
	echo json_encode($obj);
	exit;
	break;
	case "GetStamb";
	  $AMPR_ID = $_POST['AMPR_ID'];
	  $obj = array();
	  $query = $db->query("SELECT TAMB_ID, TAMB_NAME_TH FROM SETUP_TAMB WHERE AMPR_ID = '".$AMPR_ID."' AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 ");
	  while($rec = $db->db_fetch_array($query)){
		  $row['ID'] = $rec['TAMB_ID']; 
		  $row['VALUE'] = text($rec['TAMB_NAME_TH']);
		  array_push($obj,$row);
	  }
	 echo json_encode($obj);
	exit;
	break;
	case "getZipcode":
		$TAMB_ID = $_POST['TAMB_ID'];
		 $query = $db->query("SELECT TAMB_ZIPCODE FROM SETUP_TAMB WHERE TAMB_ID = '".$TAMB_ID."'");
		 $rec = $db->db_fetch_array($query);
		 echo $rec['TAMB_ZIPCODE'];
		 exit; 
	break;
	
}

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
