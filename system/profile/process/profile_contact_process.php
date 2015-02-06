<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PT_ID = $_POST['PT_ID'];
$PER_ID = $_POST['PER_ID'];
$FAMILY_ID = $_POST['FAMILY_ID'];
$FAMILY_RELATIONSHIP = $_POST['FAMILY_RELATIONSHIP'];
$FAMILY_DATE = $_POST['FAMILY_DATE'];
$FAMILY_IDTYPE = $_POST['FAMILY_IDTYPE'];
$FAMILY_IDCARD = $_POST['FAMILY_IDCARD'];
$FAMILY_BIRTHDATE = $_POST['FAMILY_BIRTHDATE'];
$FAMILY_PREFIX_ID = $_POST['FAMILY_PREFIX_ID'];
$FAMILY_FIRSTNAME_TH = $_POST['FAMILY_FIRSTNAME_TH'];
$FAMILY_MIDNAME_TH = $_POST['FAMILY_MIDNAME_TH'];
$FAMILY_LASTNAME_TH = $_POST['FAMILY_LASTNAME_TH'];
$FAMILY_FIRSTNAME_EN = $_POST['FAMILY_FIRSTNAME_EN'];
$FAMILY_MIDNAME_EN = $_POST['FAMILY_MIDNAME_EN'];
$FAMILY_LASTNAME_EN = $_POST['FAMILY_LASTNAME_EN'];
$FAMILY_GENDER = $_POST['FAMILY_GENDER'];
$FAMILY_NATION_ID = $_POST['FAMILY_NATION_ID'];
$FAMILY_RACE_NATION_ID = $_POST['FAMILY_RACE_NATION_ID'];
$FAMILY_RELIGION_ID = $_POST['FAMILY_RELIGION_ID'];
$FAMILY_JOB_ID = $_POST['FAMILY_JOB_ID'];
$FAMILY_JOB_OTHER = $_POST['FAMILY_JOB_OTHER'];
$FAMILY_STATUS = $_POST['FAMILY_STATUS'];
$ADDRESS_COUNTRY_ID = $_POST['ADDRESS_COUNTRY_ID'];
$ADDRESS_CITY = $_POST['ADDRESS_CITY'];
$ADDRESS_ROOM_NO = $_POST['ADDRESS_ROOM_NO'];
$ADDRESS_FLOOR = $_POST['ADDRESS_FLOOR'];
$ADDRESS_BUILDING = $_POST['ADDRESS_BUILDING'];
$ADDRESS_HOME_NO = $_POST['ADDRESS_HOME_NO'];
$ADDRESS_MOO = $_POST['ADDRESS_MOO'];
$ADDRESS_VILLAGE = $_POST['ADDRESS_VILLAGE'];
$ADDRESS_SOI = $_POST['ADDRESS_SOI'];
$ADDRESS_ROAD = $_POST['ADDRESS_ROAD'];
$ADDRESS_TAMB_ID = $_POST['ADDRESS_TAMB_ID'];
$ADDRESS_AMPR_ID = $_POST['ADDRESS_AMPR_ID'];
$ADDRESS_PROV_ID = $_POST['ADDRESS_PROV_ID'];
$ADDRESS_POSTCODE = $_POST['ADDRESS_POSTCODE'];
$ADDRESS_TEL = $_POST['ADDRESS_TEL'];
$ADDRESS_TEL_EXT = $_POST['ADDRESS_TEL_EXT'];
$ADDRESS_FAX = $_POST['ADDRESS_FAX'];
$ADDRESS_FAX_EXT = $_POST['ADDRESS_FAX_EXT'];
$ADDRESS_MOBILE = $_POST['ADDRESS_MOBILE'];
$ADDRESS_EMAIL = $_POST['ADDRESS_EMAIL'];
$MARRY_TYPE = $_POST['MARRY_TYPE'];
$MARRY_SEQ = $_POST['MARRY_SEQ'];
$MARRY_NO = $_POST['MARRY_NO'];
$MARRY_DATE = $_POST['MARRY_DATE'];
$MARRY_PROV_ID = $_POST['MARRY_PROV_ID'];
$MARRY_AMPR_ID = $_POST['MARRY_AMPR_ID'];
$MARRY_LASTNAME_TH = $_POST['MARRY_LASTNAME_TH'];
$MARRY_LASTNAME_EN = $_POST['MARRY_LASTNAME_EN'];
$MARRY_STATUS = $_POST['MARRY_STATUS'];
$MARRY_FILE = $_FILES['MARRY_FILE'];
$DIVORCE_NO = $_POST['DIVORCE_NO'];
$DIVORCE_DATE = $_POST['DIVORCE_DATE'];
$DIVORCE_PROV_ID = $_POST['DIVORCE_PROV_ID'];
$DIVORCE_AMPR_ID = $_POST['DIVORCE_AMPR_ID'];
$DIVORCE_FILE = $_FILES['DIVORCE_FILE'];
$BIRTH_NO = $_POST['BIRTH_NO'];
$BIRTH_DATE = $_POST['BIRTH_DATE'];
$BIRTH_MARRY_ID = $_POST['BIRTH_MARRY_ID'];
$BIRTH_SEQ = $_POST['BIRTH_SEQ'];
$BIRTH_PLACE = $_POST['BIRTH_PLACE'];
$BIRTH_FILE = $_FILES['BIRTH_FILE'];
$BIRTH_CERT_NO = $_POST['BIRTH_CERT_NO'];
$BIRTH_CERT_DATE = $_POST['BIRTH_CERT_DATE'];
$BIRTH_CERT_PLACE = $_POST['BIRTH_CERT_PLACE'];
$BIRTH_CERT_FILE = $_FILES['BIRTH_CERT_FILE'];
$PROTEGE_SNO = $_POST['PROTEGE_SNO'];
$PROTEGE_SDATE = $_POST['PROTEGE_SDATE'];
$PROTEGE_SPROV_ID = $_POST['PROTEGE_SPROV_ID'];
$PROTEGE_SAMPR_ID = $_POST['PROTEGE_SAMPR_ID'];
$PROTEGE_SFILE = $_FILES['PROTEGE_SFILE'];
$PROTEGE_STATUS = $_POST['PROTEGE_STATUS'];
$PROTEGE_ENO = $_POST['PROTEGE_ENO'];
$PROTEGE_EDATE = $_POST['PROTEGE_EDATE'];
$PROTEGE_EPROV_ID = $_POST['PROTEGE_EPROV_ID'];
$PROTEGE_EAMPR_ID = $_POST['PROTEGE_EAMPR_ID'];
$PROTEGE_EFILE = $_FILES['PROTEGE_EFILE'];
$DIED_NO = $_POST['DIED_NO'];
$DIED_DATE = $_POST['DIED_DATE'];
$DIED_SDATE = $_POST['DIED_SDATE'];
$DIED_REASON = $_POST['DIED_REASON'];
$DIED_PLACE = $_POST['DIED_PLACE'];
$DIED_PROV_ID = $_POST['DIED_PROV_ID'];
$DIED_AMPR_ID = $_POST['DIED_AMPR_ID'];
$DIED_FILE = $_FILES['DIED_FILE'];
$ID_CARD = ($FAMILY_IDTYPE == 1) ? str_replace("-","",$FAMILY_IDCARD1) : $FAMILY_IDCARD2; 
$path_a = $path.'fileupload/profile_his/';

$table = "PER_FAMILY";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			if($ADDRESS_COUNTRY_ID == $default_country_id){
				$ADDRESS_CITY = '';
			}else{
				$ADDRESS_TAMB_ID = '';
				$ADDRESS_AMPR_ID = '';
				$ADDRESS_PROV_ID = '';
				$ADDRESS_POSTCODE = '';
			}
			
			$C_MARRY_FILE = 'NULL';
			if(!empty($MARRY_FILE['name'])){
				$C_MARRY_FILE = getFilenameUplaod($MARRY_FILE, $path_a, $OLD_MARRY_FILE);
			}
			
			$C_DIVORCE_FILE = 'NULL';
			if(!empty($DIVORCE_FILE['name'])){
				$C_DIVORCE_FILE = getFilenameUplaod($DIVORCE_FILE, $path_a, $OLD_DIVORCE_FILE);
			}
			
			$C_BIRTH_FILE = 'NULL';
			if(!empty($BIRTH_FILE['name'])){
				$C_BIRTH_FILE = getFilenameUplaod($BIRTH_FILE, $path_a, $OLD_BIRTH_FILE);
			}
			
			$C_BIRTH_CERT_FILE = 'NULL';
			if(!empty($BIRTH_CERT_FILE['name'])){
				$C_BIRTH_CERT_FILE = getFilenameUplaod($BIRTH_CERT_FILE, $path_a, $OLD_BIRTH_CERT_FILE);
			}
			
			$C_PROTEGE_SFILE = 'NULL';
			if(!empty($PROTEGE_SFILE['name'])){
				$C_PROTEGE_SFILE = getFilenameUplaod($PROTEGE_SFILE, $path_a, $OLD_PROTEGE_SFILE);
			}
			
			$C_PROTEGE_EFILE = 'NULL';
			if(!empty($PROTEGE_EFILE['name'])){
				$C_PROTEGE_EFILE = getFilenameUplaod($PROTEGE_EFILE, $path_a, $OLD_PROTEGE_EFILE);
			}
			
			$C_DIED_FILE = 'NULL';
			if(!empty($DIED_FILE['name'])){
				$C_DIED_FILE = getFilenameUplaod($DIED_FILE, $path_a, $OLD_DIED_FILE);
			}
			
			if($FAMILY_RELATIONSHIP == 1 || $FAMILY_RELATIONSHIP == 2 || $FAMILY_RELATIONSHIP == 3){
				$db->db_update($table, array("ACTIVE_STATUS" => 0), " PER_ID = '".$PER_ID."' AND FAMILY_RELATIONSHIP = '".$FAMILY_RELATIONSHIP."'"); 
			}

			$fields["PER_ID"] = $PER_ID;
			$fields["FAMILY_RELATIONSHIP"] = $FAMILY_RELATIONSHIP;
			$fields["FAMILY_DATE"] = conv_date_db($FAMILY_DATE);
			$fields["FAMILY_IDTYPE"] = $FAMILY_IDTYPE;
			$fields["FAMILY_IDCARD"] = $ID_CARD;
			$fields["FAMILY_BIRTHDATE"] = conv_date_db($FAMILY_BIRTHDATE);
			$fields["FAMILY_PREFIX_ID"] = $FAMILY_PREFIX_ID;
			$fields["FAMILY_FIRSTNAME_TH"] = ctext($FAMILY_FIRSTNAME_TH);
			$fields["FAMILY_MIDNAME_TH"] = ctext($FAMILY_MIDNAME_TH);
			$fields["FAMILY_LASTNAME_TH"] = ctext($FAMILY_LASTNAME_TH);
			$fields["FAMILY_FIRSTNAME_EN"] = ctext($FAMILY_FIRSTNAME_EN);
			$fields["FAMILY_MIDNAME_EN"] = ctext($FAMILY_MIDNAME_EN);
			$fields["FAMILY_LASTNAME_EN"] = ctext($FAMILY_LASTNAME_EN);
			$fields["FAMILY_GENDER"] = $FAMILY_GENDER;
			$fields["FAMILY_NATION_ID"] = $FAMILY_NATION_ID;
			$fields["FAMILY_RACE_NATION_ID"] = $FAMILY_RACE_NATION_ID;
			$fields["FAMILY_RELIGION_ID"] = $FAMILY_RELIGION_ID;
			$fields["FAMILY_JOB_ID"] = $FAMILY_JOB_ID;
			$fields["FAMILY_JOB_OTHER"] = ctext($FAMILY_JOB_OTHER);
			$fields["FAMILY_STATUS"] = $FAMILY_STATUS;
			$fields["ADDRESS_COUNTRY_ID"] = $ADDRESS_COUNTRY_ID;
			$fields["ADDRESS_CITY"] = ctext($ADDRESS_CITY);
			$fields["ADDRESS_ROOM_NO"] = ctext($ADDRESS_ROOM_NO);
			$fields["ADDRESS_FLOOR"] = ctext($ADDRESS_FLOOR);
			$fields["ADDRESS_BUILDING"] = ctext($ADDRESS_BUILDING);
			$fields["ADDRESS_HOME_NO"] = ctext($ADDRESS_HOME_NO);
			$fields["ADDRESS_MOO"] = ctext($ADDRESS_MOO);
			$fields["ADDRESS_VILLAGE"] = ctext($ADDRESS_VILLAGE);
			$fields["ADDRESS_SOI"] = ctext($ADDRESS_SOI);
			$fields["ADDRESS_ROAD"] = ctext($ADDRESS_ROAD);
			$fields["ADDRESS_TAMB_ID"] = $ADDRESS_TAMB_ID;
			$fields["ADDRESS_AMPR_ID"] = $ADDRESS_AMPR_ID;
			$fields["ADDRESS_PROV_ID"] = $ADDRESS_PROV_ID;
			$fields["ADDRESS_POSTCODE"] = ctext($ADDRESS_POSTCODE);
			$fields["ADDRESS_TEL"] = ctext($ADDRESS_TEL);
			$fields["ADDRESS_TEL_EXT"] = ctext($ADDRESS_TEL_EXT);
			$fields["ADDRESS_FAX"] = ctext($ADDRESS_FAX);
			$fields["ADDRESS_FAX_EXT"] = ctext($ADDRESS_FAX_EXT);
			$fields["ADDRESS_MOBILE"] = ctext($ADDRESS_MOBILE);
			$fields["ADDRESS_EMAIL"] = ctext($ADDRESS_EMAIL);
			
			if($FAMILY_RELATIONSHIP == 3){
				$fields["MARRY_TYPE"] = $MARRY_TYPE;
				$fields["MARRY_SEQ"] = ctext($MARRY_SEQ);
				$fields["MARRY_NO"] = ctext($MARRY_NO);
				$fields["MARRY_DATE"] = conv_date_db($MARRY_DATE);
				$fields["MARRY_PROV_ID"] = $MARRY_PROV_ID;
				$fields["MARRY_AMPR_ID"] = $MARRY_AMPR_ID;
				$fields["MARRY_LASTNAME_TH"] = ctext($MARRY_LASTNAME_TH);
				$fields["MARRY_LASTNAME_EN"] = ctext($MARRY_LASTNAME_EN);
				$fields["MARRY_STATUS"] = $MARRY_STATUS;
				$fields["MARRY_FILE"] = $C_MARRY_FILE;
				
				if($MARRY_STATUS == 2){
					$fields["DIVORCE_NO"] = ctext($DIVORCE_NO);	
					$fields["DIVORCE_DATE"] = conv_date_db($DIVORCE_DATE);
					$fields["DIVORCE_PROV_ID"] = $DIVORCE_PROV_ID;
					$fields["DIVORCE_AMPR_ID"] = $DIVORCE_AMPR_ID;
					$fields["DIVORCE_FILE"] = $C_DIVORCE_FILE;
				}
			}else if($FAMILY_RELATIONSHIP == 4){
				$fields["BIRTH_NO"] = ctext($BIRTH_NO);
				$fields["BIRTH_DATE"] = conv_date_db($BIRTH_DATE);
				$fields["BIRTH_MARRY_ID"] = $BIRTH_MARRY_ID;
				$fields["BIRTH_SEQ"] = ctext($BIRTH_SEQ);
				$fields["BIRTH_PLACE"] = ctext($BIRTH_PLACE);
				$fields["BIRTH_FILE"] = $C_BIRTH_FILE;
				$fields["BIRTH_CERT_NO"] = ctext($BIRTH_CERT_NO);
				$fields["BIRTH_CERT_DATE"] = conv_date_db($BIRTH_CERT_DATE);
				$fields["BIRTH_CERT_PLACE"] = ctext($BIRTH_CERT_PLACE);
				$fields["BIRTH_CERT_FILE"] = $C_BIRTH_CERT_FILE;
			}else if($FAMILY_RELATIONSHIP == 5){
				$fields["PROTEGE_SNO"] = ctext($PROTEGE_SNO);
				$fields["PROTEGE_SDATE"] = conv_date_db($PROTEGE_SDATE);
				$fields["PROTEGE_SPROV_ID"] = $PROTEGE_SPROV_ID;
				$fields["PROTEGE_SAMPR_ID"] = $PROTEGE_SAMPR_ID;
				$fields["PROTEGE_SFILE"] = $C_PROTEGE_SFILE;
				$fields["PROTEGE_STATUS"] = $PROTEGE_STATUS;
				if($PROTEGE_STATUS == 2){
					$fields["PROTEGE_ENO"] = ctext($PROTEGE_ENO);
					$fields["PROTEGE_EDATE"] = conv_date_db($PROTEGE_EDATE);
					$fields["PROTEGE_EPROV_ID"] = $PROTEGE_EPROV_ID;
					$fields["PROTEGE_EAMPR_ID"] = $PROTEGE_EAMPR_ID;
					$fields["PROTEGE_EFILE"] = $C_PROTEGE_EFILE;
				}
			}
			if($FAMILY_STATUS == 2){
				$fields["DIED_NO"] = ctext($DIED_NO);
				$fields["DIED_DATE"] = conv_date_db($DIED_DATE);
				$fields["DIED_SDATE"] = conv_date_db($DIED_SDATE);
				$fields["DIED_REASON"] = ctext($DIED_REASON);
				$fields["DIED_PLACE"] = ctext($DIED_PLACE);
				$fields["DIED_PROV_ID"] = $DIED_PROV_ID;
				$fields["DIED_AMPR_ID"] = $DIED_AMPR_ID;
				$fields["DIED_FILE"] = $C_DIED_FILE;
			}
			$fields["REQUEST_STATUS"] = 2;
			$fields["REQUEST_RESULT"] = 2;
			$fields["ACTIVE_STATUS"] = 1;
			$fields["CREATE_BY"] = $USER_BY;
			$fields["UPDATE_BY"] = $USER_BY;
			$fields["CREATE_DATE"] = $TIMESTAMP;
			$fields["UPDATE_DATE"] = $TIMESTAMP;
			$fields["DELETE_FLAG"] = 0;
			$db->db_insert($table, $fields);
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "edit" : 
		try{
			unset($fields);
			if($ADDRESS_COUNTRY_ID == $default_country_id){
				$ADDRESS_CITY = '';
			}else{
				$ADDRESS_TAMB_ID = '';
				$ADDRESS_AMPR_ID = '';
				$ADDRESS_PROV_ID = '';
				$ADDRESS_POSTCODE = '';
			}
			
			$C_MARRY_FILE = 'NULL';
			$C_MARRY_FILE = getFilenameUplaod($MARRY_FILE, $path_a, $OLD_MARRY_FILE);
			
			$C_DIVORCE_FILE = 'NULL';
			$C_DIVORCE_FILE = getFilenameUplaod($DIVORCE_FILE, $path_a, $OLD_DIVORCE_FILE);
			
			$C_BIRTH_FILE = 'NULL';
			$C_BIRTH_FILE = getFilenameUplaod($BIRTH_FILE, $path_a, $OLD_BIRTH_FILE);
			
			$C_BIRTH_CERT_FILE = 'NULL';
			$C_BIRTH_CERT_FILE = getFilenameUplaod($BIRTH_CERT_FILE, $path_a, $OLD_BIRTH_CERT_FILE);
			
			$C_PROTEGE_SFILE = 'NULL';
			$C_PROTEGE_SFILE = getFilenameUplaod($PROTEGE_SFILE, $path_a, $OLD_PROTEGE_SFILE);
			
			$C_PROTEGE_EFILE = 'NULL';
			$C_PROTEGE_EFILE = getFilenameUplaod($PROTEGE_EFILE, $path_a, $OLD_PROTEGE_EFILE);
			
			$C_DIED_FILE = 'NULL';
			$C_DIED_FILE = getFilenameUplaod($DIED_FILE, $path_a, $OLD_DIED_FILE);
			
			$fields["PER_ID"] = $PER_ID;
			$fields["FAMILY_RELATIONSHIP"] = $FAMILY_RELATIONSHIP;
			$fields["FAMILY_DATE"] = conv_date_db($FAMILY_DATE);
			$fields["FAMILY_IDTYPE"] = $FAMILY_IDTYPE;
			$fields["FAMILY_IDCARD"] = $ID_CARD;
			$fields["FAMILY_BIRTHDATE"] = conv_date_db($FAMILY_BIRTHDATE);
			$fields["FAMILY_PREFIX_ID"] = $FAMILY_PREFIX_ID;
			$fields["FAMILY_FIRSTNAME_TH"] = ctext($FAMILY_FIRSTNAME_TH);
			$fields["FAMILY_MIDNAME_TH"] = ctext($FAMILY_MIDNAME_TH);
			$fields["FAMILY_LASTNAME_TH"] = ctext($FAMILY_LASTNAME_TH);
			$fields["FAMILY_FIRSTNAME_EN"] = ctext($FAMILY_FIRSTNAME_EN);
			$fields["FAMILY_MIDNAME_EN"] = ctext($FAMILY_MIDNAME_EN);
			$fields["FAMILY_LASTNAME_EN"] = ctext($FAMILY_LASTNAME_EN);
			$fields["FAMILY_GENDER"] = $FAMILY_GENDER;
			$fields["FAMILY_NATION_ID"] = $FAMILY_NATION_ID;
			$fields["FAMILY_RACE_NATION_ID"] = $FAMILY_RACE_NATION_ID;
			$fields["FAMILY_RELIGION_ID"] = $FAMILY_RELIGION_ID;
			$fields["FAMILY_JOB_ID"] = $FAMILY_JOB_ID;
			$fields["FAMILY_JOB_OTHER"] = ctext($FAMILY_JOB_OTHER);
			$fields["FAMILY_STATUS"] = $FAMILY_STATUS;
			$fields["ADDRESS_COUNTRY_ID"] = $ADDRESS_COUNTRY_ID;
			$fields["ADDRESS_CITY"] = ctext($ADDRESS_CITY);
			$fields["ADDRESS_ROOM_NO"] = ctext($ADDRESS_ROOM_NO);
			$fields["ADDRESS_FLOOR"] = ctext($ADDRESS_FLOOR);
			$fields["ADDRESS_BUILDING"] = ctext($ADDRESS_BUILDING);
			$fields["ADDRESS_HOME_NO"] = ctext($ADDRESS_HOME_NO);
			$fields["ADDRESS_MOO"] = ctext($ADDRESS_MOO);
			$fields["ADDRESS_VILLAGE"] = ctext($ADDRESS_VILLAGE);
			$fields["ADDRESS_SOI"] = ctext($ADDRESS_SOI);
			$fields["ADDRESS_ROAD"] = ctext($ADDRESS_ROAD);
			$fields["ADDRESS_TAMB_ID"] = $ADDRESS_TAMB_ID;
			$fields["ADDRESS_AMPR_ID"] = $ADDRESS_AMPR_ID;
			$fields["ADDRESS_PROV_ID"] = $ADDRESS_PROV_ID;
			$fields["ADDRESS_POSTCODE"] = ctext($ADDRESS_POSTCODE);
			$fields["ADDRESS_TEL"] = ctext($ADDRESS_TEL);
			$fields["ADDRESS_TEL_EXT"] = ctext($ADDRESS_TEL_EXT);
			$fields["ADDRESS_FAX"] = ctext($ADDRESS_FAX);
			$fields["ADDRESS_FAX_EXT"] = ctext($ADDRESS_FAX_EXT);
			$fields["ADDRESS_MOBILE"] = ctext($ADDRESS_MOBILE);
			$fields["ADDRESS_EMAIL"] = ctext($ADDRESS_EMAIL);
			
			if($FAMILY_RELATIONSHIP == 3){
				$fields["MARRY_TYPE"] = $MARRY_TYPE;
				$fields["MARRY_SEQ"] = ctext($MARRY_SEQ);
				$fields["MARRY_NO"] = ctext($MARRY_NO);
				$fields["MARRY_DATE"] = conv_date_db($MARRY_DATE);
				$fields["MARRY_PROV_ID"] = $MARRY_PROV_ID;
				$fields["MARRY_AMPR_ID"] = $MARRY_AMPR_ID;
				$fields["MARRY_LASTNAME_TH"] = ctext($MARRY_LASTNAME_TH);
				$fields["MARRY_LASTNAME_EN"] = ctext($MARRY_LASTNAME_EN);
				$fields["MARRY_STATUS"] = $MARRY_STATUS;
				$fields["MARRY_FILE"] = $C_MARRY_FILE;
				
				if($MARRY_STATUS == 2){
					$fields["DIVORCE_NO"] = ctext($DIVORCE_NO);	
					$fields["DIVORCE_DATE"] = conv_date_db($DIVORCE_DATE);
					$fields["DIVORCE_PROV_ID"] = $DIVORCE_PROV_ID;
					$fields["DIVORCE_AMPR_ID"] = $DIVORCE_AMPR_ID;
					$fields["DIVORCE_FILE"] = $C_DIVORCE_FILE;
				}else{
					$fields["DIVORCE_NO"] = '';	
					$fields["DIVORCE_DATE"] = '';
					$fields["DIVORCE_PROV_ID"] = '';
					$fields["DIVORCE_AMPR_ID"] = '';
					$fields["DIVORCE_FILE"] = '';
				}
			}else if($FAMILY_RELATIONSHIP == 4){
				$fields["BIRTH_NO"] = ctext($BIRTH_NO);
				$fields["BIRTH_DATE"] = conv_date_db($BIRTH_DATE);
				$fields["BIRTH_MARRY_ID"] = $BIRTH_MARRY_ID;
				$fields["BIRTH_SEQ"] = ctext($BIRTH_SEQ);
				$fields["BIRTH_PLACE"] = ctext($BIRTH_PLACE);
				$fields["BIRTH_FILE"] = $C_BIRTH_FILE;
				$fields["BIRTH_CERT_NO"] = ctext($BIRTH_CERT_NO);
				$fields["BIRTH_CERT_DATE"] = conv_date_db($BIRTH_CERT_DATE);
				$fields["BIRTH_CERT_PLACE"] = ctext($BIRTH_CERT_PLACE);
				$fields["BIRTH_CERT_FILE"] = $C_BIRTH_CERT_FILE;
			}else if($FAMILY_RELATIONSHIP == 5){
				$fields["PROTEGE_SNO"] = ctext($PROTEGE_SNO);
				$fields["PROTEGE_SDATE"] = conv_date_db($PROTEGE_SDATE);
				$fields["PROTEGE_SPROV_ID"] = $PROTEGE_SPROV_ID;
				$fields["PROTEGE_SAMPR_ID"] = $PROTEGE_SAMPR_ID;
				$fields["PROTEGE_SFILE"] = $C_PROTEGE_SFILE;
				$fields["PROTEGE_STATUS"] = $PROTEGE_STATUS;
				if($PROTEGE_STATUS == 2){
					$fields["PROTEGE_ENO"] = ctext($PROTEGE_ENO);
					$fields["PROTEGE_EDATE"] = conv_date_db($PROTEGE_EDATE);
					$fields["PROTEGE_EPROV_ID"] = $PROTEGE_EPROV_ID;
					$fields["PROTEGE_EAMPR_ID"] = $PROTEGE_EAMPR_ID;
					$fields["PROTEGE_EFILE"] = $C_PROTEGE_EFILE;
				}else{
					$fields["PROTEGE_ENO"] = '';
					$fields["PROTEGE_EDATE"] = '';
					$fields["PROTEGE_EPROV_ID"] = '';
					$fields["PROTEGE_EAMPR_ID"] = '';
					$fields["PROTEGE_EFILE"] = '';
				}
			}
			if($FAMILY_STATUS == 2){
				$fields["DIED_NO"] = ctext($DIED_NO);
				$fields["DIED_DATE"] = conv_date_db($DIED_DATE);
				$fields["DIED_SDATE"] = conv_date_db($DIED_SDATE);
				$fields["DIED_REASON"] = ctext($DIED_REASON);
				$fields["DIED_PLACE"] = ctext($DIED_PLACE);
				$fields["DIED_PROV_ID"] = $DIED_PROV_ID;
				$fields["DIED_AMPR_ID"] = $DIED_AMPR_ID;
				$fields["DIED_FILE"] = $C_DIED_FILE;
			}else{
				$fields["DIED_NO"] = '';
				$fields["DIED_DATE"] = '';
				$fields["DIED_SDATE"] = '';
				$fields["DIED_REASON"] = '';
				$fields["DIED_PLACE"] = '';
				$fields["DIED_PROV_ID"] = '';
				$fields["DIED_AMPR_ID"] = '';
				$fields["DIED_FILE"] = '';
			}
			$fields["UPDATE_BY"] = $USER_BY;
			$fields["UPDATE_DATE"] = $TIMESTAMP;
			$db->db_update($table, $fields, " FAMILY_ID = '".$FAMILY_ID."' "); 
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," FAMILY_ID = '".$FAMILY_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_contact_disp.php";
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
    <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
